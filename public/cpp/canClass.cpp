
/* 
 * 	\file      canClass.cpp
 *  \brief     classe de gestion d'un bus can
 *  \details   Cette classe permet d'envoyer et de recevoir des messages via un bus can
 *  \author    Theo RUSINOWITCH <theo.rusinowitch1@etu.univ-lorraine.fr>
 *  \version   1.0
 *  \date      2021-2022
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <iostream>

#include <net/if.h>
#include <sys/ioctl.h>
#include <sys/socket.h>

#include <linux/can.h>
#include <linux/can/raw.h>

#include <string>

#include <unistd.h>

#include <thread>

#include "canClass.h"
#include "defineCan.h"
using namespace std;

/*!
 *  \brief initialise le bus can
 *  \param myAddr adresse sur le bus can
 *  \retval 0 succes
 *  \retval {CAN_E_SOCKET_ERROR} erreur dans l'ouverture du socket
 *  \retval {CAN_E_BIND_ERROR} erreur dans le bind du bus
 *  \retval {CAN_E_OOB_ADDR} adresse en dehors des bornes
 *  \retval {CAN_E_UNKNOW_ADDR} l'adresse n'est pas dans le #define
*/
int Can::init(CAN_EMIT_ADDR myAddr){
    int i; 
    int nbytes;
    struct sockaddr_can addr;
    struct ifreq ifr;


    if ((s = socket(PF_CAN, SOCK_RAW, CAN_RAW)) < 0) {
        perror("Socket");
        return CAN_E_SOCKET_ERROR;
    }
    strcpy(ifr.ifr_name, CAN_BUS_NAME); //definie le bus sur le quel on travaille (can0 ou vcan0 normalement)
    ioctl(s, SIOCGIFINDEX, &ifr);

    memset(&addr, 0, sizeof(addr));
    addr.can_family = AF_CAN;
    addr.can_ifindex = ifr.ifr_ifindex;

    if (bind(s, (struct sockaddr *)&addr, sizeof(addr)) < 0) {
        perror("Bind");
        return CAN_E_BIND_ERROR;
    }

    // si l'address est incorect on ne setup juste pas de filtre
    //if(myAddr <0 || myAddr > CAN_MAX_VALUE_ADDR) return CAN_E_OOB_ADDR;
    //if(!is_valid_addr(myAddr)) return CAN_E_UNKNOW_ADDR;

    //  Initialisation de l'adresse
    struct can_filter rfilter[1];
    rfilter[0].can_id   = myAddr ;
    rfilter[0].can_mask = CAN_FILTER_ADDR_RECEPTEUR;


    //setsockopt(s, SOL_CAN_RAW, CAN_RAW_FILTER, &rfilter, sizeof(rfilter));

    //logC << "bus can initialiser" << mendl;
    return 0;
}


/*!
 *  \brief envoie un message sur le bus can
 *  \param addr addresse du destinataire
 *  \param codeFct code fct du message
 *  \param data tableau d'octet d'une taille 0 ... 8
 *  \param data_len nombre d'octet de data, compris entre 0 et 8
 *  \param isRep true si le message est une réponse à une requete, false sinon
 *  \param repLenght isRep = true : id du msg dans la réponse. isRep = false : nbr de reponse atendu
 *  \retval 0 le message a bien été envoyé
 *  \retval {CAN_E_DATA_SIZE_TOO_LONG} data_len n'est pas compris entre 0 et 8 inclu
 *  \retval {CAN_E_OOB_ADDR} l'adresse n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_ADDR})
 *  \retval {CAN_E_OOB_CODE_FCT} le code fct n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_CODE_FCT})
 *  \retval {CAN_E_OOB_REP_NBR} le rep nbr n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_REP_NBR})
 *  \retval {CAN_E_OOB_DATA} au moins une des donnés n'est pas dans les valeurs possible (0 - 255)
 *  \retval {CAN_E_UNKNOW_ADDR} l'adresse n'est pas dans le #define
 *  \retval {CAN_E_UNKNOW_CODE_FCT} le code fonction n'est pas dans le #define
 *  \retval {CAN_E_WRITE_ERROR} une erreur à eu lieu lors de l'envoi du message
*/
int Can::send(CAN_ADDR addr, CAN_CODE_FCT codeFct , uint8_t data[], uint dataLen, bool isRep, uint repLenght, uint idmessage){
    if (dataLen >8){
        logC << "vous ne pouvez envoyer que 8 octet de data" << mendl;
        return CAN_E_DATA_SIZE_TOO_LONG;   
    }

   struct can_frame frame;
     frame.can_id = addr | CAN_ADDR_RASPBERRY_E | codeFct | repLenght | idmessage << CAN_DECALAGE_ID_MSG | isRep << CAN_DECALAGE_IS_REP 
                    | CAN_EFF_FLAG;

    frame.can_dlc = dataLen;

    logC << "send : ";
    logC << "   addr : " << hex << showbase << addr ;
    logC << "   emetteur : " << CAN_ADDR_RASPBERRY_E; 
    logC << "   codeFct : " << codeFct;
    logC << "   id msg : " << idmessage;
    logC << "   isRep : " << isRep;
    logC << "   RepId : " << repLenght;
    logC << "       Data : ["<< dataLen <<"] ";
    for (int i = 0; i < dataLen; i++)
    {
        if(data[i] <0 || data[i] > 255) return CAN_E_OOB_DATA;
        frame.data[i] = data[i];
        logC << hex << showbase << (int) data[i] << " ";
    }
    logC << mendl;
    if (write(s, &frame, sizeof(struct can_frame)) != sizeof(struct can_frame)) { //on verifie que le nombre de byte envoyer est corecte
        perror("Write");
        return CAN_E_WRITE_ERROR;
    }

    return 0;	
}

/*!
 *  \brief extrait d'une trame reçu les différentes informations
 *  \param[out] rep pointeur d'une structure dans le quel la trame décoder est stocker
 *  \param frame structure contenant la trame à décoder
 *  \retval 0 la trame à bien etait décodé
 *  \retval {CAN_E_OOB_ADDR} l'adresse n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_ADDR})
 *  \retval {CAN_E_OOB_CODE_FCT} le code fct n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_CODE_FCT})
 *  \retval {CAN_E_OOB_REP_NBR} le rep nbr n'est pas dans les valeurs possible (0 - {CAN_MAX_VALUE_REP_NBR})
 *  \retval {CAN_E_OOB_DATA} au moins une des donnés n'est pas dans les valeurs possible (0 - 255)
 *  \retval {CAN_E_UNKNOW_ADDR} l'adresse n'est pas dans le #define
 *  \retval {CAN_E_UNKNOW_CODE_FCT} le code fonction n'est pas dans le #define
 *  \retval {CAN_E_READ_ERROR} erreur dans la lecture de la trame depuis le buffer
*/
int Can::traitement_trame(CanResponse_t &rep, can_frame frame){

    int nbytes;
		nbytes = read(s, &frame, sizeof(struct can_frame));
		if (nbytes < 0) {
			perror("Read");
            return CAN_E_READ_ERROR;
		}
        cout << "ExtId : " << hex << frame.can_id << endl;

        rep.addr = (frame.can_id & CAN_FILTER_ADDR_EMETTEUR )  ;
        rep.emetteur = (frame.can_id &  CAN_FILTER_ADDR_RECEPTEUR) ;
        rep.codeFct = (frame.can_id & CAN_FILTER_CODE_FCT);
        rep.isRep = (frame.can_id & CAN_FILTER_IS_REP) >> CAN_DECALAGE_IS_REP;
        rep.RepId = (frame.can_id & CAN_FILTER_REP_NBR) ;
        rep.idMessage = (frame.can_id & CAN_FILTER_IDE_MSG) >> CAN_DECALAGE_ID_MSG;

        if (frame.can_dlc >8)  return CAN_E_DATA_SIZE_TOO_LONG;

        rep.dataLen = frame.can_dlc;
        

        for (int i = 0; i < frame.can_dlc; i++){
            if(frame.data[i] <0 || frame.data[i] > 255) return CAN_E_OOB_DATA;
            rep.data[i] = frame.data[i];
        }


    return 0;
}

/*!
 *  \brief fonction à lancer en thread qui ecoute le buffer et decode les trames
 */

void Can::listen(){
	while(true){
		struct can_frame frame;
		struct CanResponse_t reponse;
        
        int err =traitement_trame(reponse, frame);
        if(err < 0){
            logC << "erreur dans le décodage d'une trame. err n°" << dec << err << "\t\t c.f. #define" << mendl;
            continue;
        }
        logC << "get : ";
        logC << "addr : " << hex <<  reponse.addr ;
        logC << "   emetteur : " << reponse.emetteur;
        logC << "   codeFct : " << reponse.codeFct;
        logC << "   isRep : " << reponse.isRep;
        logC << "   RepId : " << reponse.RepId;
        logC << "       Data : ["<< reponse.dataLen <<"] ";
        //logC << reponse.data;
        for (int i = 0; i < reponse.dataLen ; i++){
            logC << hex << showbase << (int) reponse.data[i] << " ";
        }
        logC << mendl;

        traitement(reponse);
        
	}
}


/*!
 *  \brief traite le message décodé dans un nouveau thread
 *  \param msg structure contenant le message decoder
*/    
void Can::traitement(CanResponse_t msg){

    if(msg.addr == CAN_ADDR_RASPBERRY){

    messages.insert( pair<int,CanResponse_t>(msg.idMessage,msg));
    cout << "OSKOUTR : " <<messages[1].codeFct << endl;
   }

    switch (msg.emetteur){     
    case CAN_ADDR_BASE_ROULANTE_E:
        switch (msg.codeFct){
        case REP_AVANCE:
            

        break;
        default:
            cout << "code fonction inconu" << endl;
        break;
        }
    break;
    case CAN_ADDR_ODOMETRIE_E:

        switch (msg.codeFct){
        case VARIATION_XY:
            Tramme_Variation_position_t variation;

            for(int i = 0; i< 5; i++){
                variation.raw_data[i] = msg.data[i];
            }
            int16_t dx;
            int16_t dy;
            dx = variation.fields.signeX ? variation.fields.dx : variation.fields.dx * (-1);
            dy = variation.fields.signeY ? variation.fields.dy : variation.fields.dy * (-1);

        break;
        default:
            cout << "code fonction inconu" << endl;
        break;
        }
    break;
    case CAN_ADDR_RASPBERRY_E:
        cout << "self emeteur" << endl;
    break;
    default:
        cout << "emetteur inconu" << endl;
    break;
    }
}

    bool Can::is_message(uint id){
        if(messages.find(id) != messages.end()){
			return true;
			
		}else{
            return false;               
        }
    }
    
    CanResponse_t Can::get_message(uint id){
        CanResponse_t rep;
        rep = messages[id];
        messages.erase(id);
	return rep;
    }


/*!
 *  \brief démarre le thread d'écoute du bus can
 *  \retval 0 le thread a bien etait lancer 
*/
int Can::start_listen(){
    thread tListen(&Can::listen, this);
	tListen.detach();
    threadListen = &tListen;
    logC << "lancement de l'ecoute du bus can" << mendl;
    return 0;
}



