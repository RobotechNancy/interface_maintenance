/*!
    \file    xbeelib.cpp
    \brief   Fichier source de la classe XBee. Cette classe est utilisée afin de programmer les modules XBee en UART et de mettre en place des communications entre différents modules XBee.
    \author  Samuel-Charles DITTE-DESTREE (samueldittedestree@protonmail.com)
    \version 3.0
    \date    10/03/2022
 */
#include "xbeelib.h"

using namespace std;

serialib serial;
Log logXbee("xbee");

//_____________________________________
// ::: Constructeurs et destructeurs :::

/*!
    \brief Constructeur de la classe xbee.
*/
XBee::XBee(){ }

/*!
    \brief Destructeur de la classe xbee.
*/
XBee::~XBee(){ }


//_________________________________________
// ::: Configuration and initialisation :::

/*!
    \brief Nettoyage du buffer et ouverture de la connexion UART entre la RaspberryPi et le module XBee
    \param mode permet de définir la configuration de port à utiliser
    \return 500 succès
    \return -501 port série non trouvé
    \return -502 erreur lors de l'ouverture du port série
    \return -503 erreur lors de la récupération des informations du port série
    \return -504 baudrate non reconnu
    \return -505 erreur lors de l'écriture de la configuration du port série
    \return -506 erreur lors de l'écriture du timeout
    \return -507 databits non reconnus
    \return -508 stopbits non reconnus
    \return -509 parité non reconnue
 */
int XBee::openSerialConnection(int mode){
    int errorOpening;
    if(mode == 1){
        errorOpening = serial.openDevice(XB_SERIAL_PORT_DEFAULT, XB_BAUDRATE_DEFAULT, XB_DATABITS_DEFAULT, XB_PARITY_DEFAULT, XB_STOPBITS_DEFAULT);      

        if (errorOpening != XB_SER_E_SUCCESS)
            logXbee << "(serial) /!\\ erreur " << errorOpening << " : impossible d'ouvrir le port " << XB_SERIAL_PORT_DEFAULT  << " - baudrate : " << XB_BAUDRATE_DEFAULT << " - parité : " << XB_PARITY_DEFAULT << mendl;
        else{
            logXbee << "(serial) connexion ouverte avec succès sur le port " << XB_SERIAL_PORT_DEFAULT << " - baudrate : " << XB_BAUDRATE_DEFAULT << " - parité : " << XB_PARITY_DEFAULT << mendl;
	        if (MODE != 2) checkATConfig();
	    }    
    } else if(mode == 0) {
        errorOpening = serial.openDevice(XB_SERIAL_PORT_PRIMARY, XB_BAUDRATE_PRIMARY, XB_DATABITS_PRIMARY, XB_PARITY_PRIMARY, XB_STOPBITS_PRIMARY);      
        
        if (errorOpening != XB_SER_E_SUCCESS)
            logXbee << "(serial) /!\\ erreur " << errorOpening << " : impossible d'ouvrir le port " << XB_SERIAL_PORT_PRIMARY  << " - baudrate : " << XB_BAUDRATE_PRIMARY << " - parités : " << XB_PARITY_PRIMARY << mendl;
        
	    else{
            logXbee << "(serial) connexion ouverte avec succès sur le port " << XB_SERIAL_PORT_PRIMARY << " - baudrate : " << XB_BAUDRATE_PRIMARY << " - parité : " << XB_PARITY_PRIMARY << mendl;
    	    if(MODE != 2) checkATConfig();
        }
    }

    return errorOpening;
}

/*!
    \brief Nettoyage du buffer et fermeture de la connexion UART entre la RaspberryPi et le module XBee
 */
void XBee::closeSerialConnection(){
    serial.flushReceiver();
    logXbee << "(serial) buffer Rx nettoyé avec succès" << mendl;
    
    serial.closeDevice();
    logXbee << "(serial) connexion série fermée avec succès" << mendl;
}

//_________________________________________
// ::: Configuration en mode AT :::

/*!
    \brief Vérification et paramétrage de la configuration par défaut pour le module XBee
    \return 400 succès
    \return -401 impossible d'entrer dans le mode AT
    \return -402 impossible de configurer le mode API
    \return -403 impossible de configurer le baudrate
    \return -404 impossible de configurer le paramètre de chiffrement AES
    \return -405 impossible de configurer la clé de chiffrement AES 
    \return -406 impossible de configurer le canal de découverte réseau
    \return -407 impossible de configurer l'ID du réseau
    \return -408 impossible de configurer le mode coordinateur
    \return -409 impossible de configurer le nombre de bits de parité
    \return -410 impossible de configurer l'adresse source 16bits
    \return -411 impossible de configuer l'adresse de destination
    \return -412 impossible de sortir du mode AT
    \return -413 impossible d'écrire les paramètres dans la mémoire flash
    \return -414 impossible d'établir une connexion avec le module XBee distant
 */
int XBee::checkATConfig(){
    if(!enterATMode()){
	    logXbee << "/!\\ (config AT) erreur " << XB_AT_E_ENTER << " : impossible d'entrer dans le mode AT" << mendl;
        closeSerialConnection();
        if(MODE == 0){
            MODE = 1;
        	openSerialConnection(1);
        }else{
            MODE = 0;
		    openSerialConnection();
        }
        return XB_AT_E_ENTER;
    }
    else logXbee << "(config AT) entrée dans le mode AT" << mendl;

    if(!sendATCommand(XB_AT_CMD_BAUDRATE, XB_AT_V_BAUDRATE, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_BAUDRATE, XB_AT_V_BAUDRATE)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_BAUDRATE << " : impossible de configurer le baudrate" << mendl;
	        return XB_AT_E_BAUDRATE;
        }
        logXbee << "(config AT) baudrate configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) baudrate vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_PARITY, XB_AT_V_PARITY, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_PARITY, XB_AT_V_PARITY)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_PARITY << " : impossible de configurer le nombre de bits de parité" << mendl;
	        return XB_AT_E_PARITY;
        }
        logXbee << "(config AT) nombre de bits de parité configuré avec succès" << mendl;

        if(!writeATConfig()){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_WRITE_CONFIG << " : impossible d'écrire les paramètres dans la mémoire flash" << mendl;
	        return XB_AT_E_WRITE_CONFIG;
        }

        closeSerialConnection();
        if(MODE == 0){
            MODE = 1;
            openSerialConnection(1);
        }else{
            MODE = 0;
            openSerialConnection();
        }
    }
    else logXbee << "(config AT) nombre de bits de parité vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_API, XB_AT_V_API, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_API, XB_AT_V_API)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_API << " : impossible de configurer le mode API" << mendl;
	        return XB_AT_E_API;
        }
        logXbee << "(config AT) mode API configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) mode API vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_AES, XB_AT_V_AES, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_AES, XB_AT_V_AES)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_AES << " : impossible de configurer le paramètre de chiffrement AES" << mendl;
	        return XB_AT_E_AES;
        }
        logXbee << "(config AT) chiffrement AES configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) chiffrement AES vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_AES_KEY, XB_AT_V_AES_KEY)){
        logXbee << "/!\\ (config AT) erreur " << XB_AT_E_AES_KEY << " : impossible de configurer la clé de chiffrement AES" << mendl;
	return XB_AT_E_AES_KEY;
    }
    else logXbee << "(config AT) clé de chiffrement configurée avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_CHANEL, XB_AT_V_CHANEL, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_CHANEL, XB_AT_V_CHANEL)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_CHANEL << " : impossible de configurer le canal de découverte réseau" << mendl;
	        return XB_AT_E_CHANEL;
        }
        logXbee << "(config AT) canal de découverte réseau configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) canal de découverte réseau vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_PAN_ID, XB_AT_V_PAN_ID, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_PAN_ID, XB_AT_V_PAN_ID)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_PAN_ID << " : impossible de configurer l'ID du réseau" << mendl;
	        return XB_AT_E_PAN_ID;
        }
        logXbee << "(config AT) ID du réseau configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) ID du réseau vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_COORDINATOR, XB_AT_V_COORDINATOR, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_COORDINATOR, XB_AT_V_COORDINATOR)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_COORDINATOR << " : impossible de configurer le mode coordinateur" << mendl;
	        return XB_AT_E_COORDINATOR;
        }
        logXbee << "(config AT) mode coordinateur configuré avec succès" << mendl;
    }
    else logXbee << "(config AT) mode coordinateur vérifié avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_16BIT_SOURCE_ADDR, XB_AT_V_16BIT_SOURCE_ADDR, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_16BIT_SOURCE_ADDR, XB_AT_V_16BIT_SOURCE_ADDR)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_16BIT_SOURCE_ADDR << " : impossible de configurer l'adresse source 16bits" << mendl;
	        return XB_AT_E_16BIT_SOURCE_ADDR;
        }
        logXbee << "(config AT) adresse source 16bits configurée avec succès" << mendl;
    }
    else logXbee << "(config AT) adresse source 16bits vérifiée avec succès" << mendl;

    if(!sendATCommand(XB_AT_CMD_LOW_DEST_ADDR, XB_AT_V_LOW_DEST_ADDR, XB_AT_M_GET)){
        if(!sendATCommand(XB_AT_CMD_LOW_DEST_ADDR, XB_AT_V_LOW_DEST_ADDR)){
            logXbee << "/!\\ (config AT) erreur " << XB_AT_E_LOW_DEST_ADDR << " : impossible de configurer l'adresse de destination" << mendl;
	        return XB_AT_E_LOW_DEST_ADDR;
        }
        logXbee << "(config AT) adresse de destination configurée avec succès" << mendl;
    }
    else logXbee << "(config AT) adresse de destination vérifiée avec succès" << mendl;

    if(!writeATConfig()){
        logXbee << "/!\\ (config AT) erreur " << XB_AT_E_WRITE_CONFIG << " : impossible d'écrire les paramètres dans la mémoire flash" << mendl;
	    return XB_AT_E_WRITE_CONFIG;
    }
    else logXbee << "(config AT) configuration AT enregistrée dans la mémoire du module" << mendl;

    if(!discoverXbeeNetwork()){
        logXbee << "/!\\ (config AT) erreur " << XB_AT_E_DISCOVER_NETWORK << " : impossible d'établir une connexion avec le module XBee distant" << mendl;
	    return XB_AT_E_DISCOVER_NETWORK;
    }
    else logXbee << "(config AT) connexion XBee établie avec succès avec le module distant" << mendl;

    if(!exitATMode()){
        logXbee << "/!\\ (config AT) erreur " << XB_AT_E_EXIT << " : impossible de sortir du mode AT" << mendl;
	    return XB_AT_E_EXIT;
    }

    logXbee << "(config AT) configuration AT réalisée avec succès" << mendl;
    MODE = 2;
    return XB_AT_E_SUCCESS;
}

/*!
    \brief Fonction permettant de retarder l'exécution du code
    \param time : temps du retard en secondes
 */
void XBee::delay(unsigned int time){ std::this_thread::sleep_for(std::chrono::milliseconds(time*1000)); }


/*!
    \brief Fonction permettant de lire la réponse à un envoi de commande AT au module XBee
    \param value : la valeur de réponse attendue pour la commande envoyée
    \param mode : le mode de lecture à utiliser
    \return true la réponse du module XBee est celle attendue
    \return false la réponse du module XBee n'est pas celle attendue
 */
bool XBee::readATResponse(const char *value, int mode){
    
    string reponse;

    if(value == XB_AT_V_DISCOVER_NETWORK){
        delay(3);
        reponse = readString();
        serial.flushReceiver();
        logXbee << "(config AT) réponse du Xbee : " << mendl;
        logXbee << reponse << mendl;

        if(reponse != XB_AT_R_EMPTY && reponse != XB_AT_V_END_LINE) return true;
        return false;
    }

    reponse = readString();

    if(reponse != XB_AT_R_EMPTY && reponse != XB_AT_V_END_LINE){
        logXbee << "(config AT) réponse du Xbee : " << reponse << mendl;
    }

    if(mode == 0)
        if(reponse == value) return true;  
    
    return false;
}

/*!
    \brief Fonction permettant d'entrer dans le mode AT
    \return true la réponse du module XBee est celle attendue
    \return false la réponse du module XBee n'est pas celle attendue
 */
bool XBee::enterATMode(){
    serial.writeString(XB_AT_CMD_ENTER);
    delay(3);
    serial.writeString(XB_AT_V_END_LINE);
    logXbee << "(config AT) entrée en mode AT en cours..." << mendl;
    return readATResponse(XB_AT_R_SUCCESS);
}

/*!
    \brief Fonction permettant de sortir du mode AT
    \return true la réponse du module XBee est celle attendue
    \return false la réponse du module XBee n'est pas celle attendue
 */
bool XBee::exitATMode(){
    serial.writeString(XB_AT_CMD_EXIT);
    serial.writeString(XB_AT_V_END_LINE);
    logXbee << "(config AT) sortie du mode AT" << mendl;
    return readATResponse(XB_AT_R_SUCCESS);
}

/*!
    \brief Recherche du module XBee distant de l'autre robot
    \return true le bon module XBee est détecté
    \return false aucun module XBee détecté ou module XBee incorrect détecté
 */
bool XBee::discoverXbeeNetwork(){
    serial.writeString(XB_AT_CMD_DISCOVER_NETWORK);
    serial.writeString(XB_AT_V_END_LINE);
    logXbee << "(config AT) lancement de la découverte réseau XBee" << mendl;
    return readATResponse(XB_AT_V_DISCOVER_NETWORK, 1);
}

/*!
    \brief Fonction permettant d'écrire dans la mémoire flash du module XBee, les paramètres AT définis
    \return true la réponse du module XBee est celle attendue
    \return false la réponse du module XBee n'est pas celle attendue
 */
bool XBee::writeATConfig(){
    serial.writeString(XB_AT_CMD_WRITE_CONFIG);
    serial.writeString(XB_AT_V_END_LINE);
    logXbee << "(config AT) écriture des paramètres AT dans la mémoire" << mendl;
    return readATResponse(XB_AT_R_SUCCESS);
}

/*!
    \brief Fonction permettant d'envoyer en UART via le port série une commmande AT
    \param command : le paramètre AT a envoyer au module
    \param value : la valeur de réponse attendue
    \param mode : le mode de transmission de la commande AT (mode lecture ou écriture)
    \return true la réponse du module XBee est celle attendue
    \return false la réponse du module XBee n'est pas celle attendue
 */
bool XBee::sendATCommand(const char *command, const char *value, unsigned int mode){
    if(mode == XB_AT_M_GET){
        serial.writeString(command);
        serial.writeString(XB_AT_V_END_LINE);
        logXbee << "(config AT) envoi de la commande AT : " << command << mendl;
        return readATResponse(value);
    }else{
        serial.writeString(command);
        serial.writeString(value);    
        logXbee << "(config AT) envoi de la commande AT : " << command << "=" << value << mendl;
        return readATResponse(XB_AT_R_SUCCESS);
    }
}

//__________________________________________________________
// ::: Envoi/Réception/Traitement des trames de messages :::

/*!
    \brief Fonction permettant de calculer le CRC16 Modbus de la trame XBee envoyée
    \param trame : la trame XBee complète sauf le CRC et le caractère de fin de trame
    \param taille : la taille de la trame
    \return la valeur entière du crc calculée sur 16 bits
 */
int XBee::crc16(int trame[], uint8_t taille){
    int crc = 0xFFFF, count = 0;
    int octet_a_traiter;
    const int POLYNOME = 0xA001;

    octet_a_traiter = trame[0];

    do{
        crc ^= octet_a_traiter;
        for(uint8_t i = 0; i < 8; i++){

            if((crc%2)!=0)
	        crc = (crc >> 1) ^ POLYNOME;

            else
                crc = (crc >> 1);

        }
        count++;
        octet_a_traiter = trame[count];
        
    }while(count < taille);

    return crc;
}

/*!
    \brief Fonction permettant d'envoyer une trame de message structurée via UART en XBee
    \param ad_dest : l'adresse du destinataire du message
    \param code_fct : le code de la fonction concernée par le message
    \param data : les valeurs des paramètres demandées par le code fonction
    \return {XB_TRAME_E_SUCCESS} succès
 */
int XBee::sendTrame(uint8_t ad_dest, uint8_t code_fct, char* data){
   
    cout << hex << showbase;

    uint8_t length_trame = strlen(data)+10;
    uint8_t trame[length_trame];
    int trame_int[length_trame];
    int id_trame = ++ID_TRAME;
    uint8_t id_trame_low = id_trame & 0xFF;
    uint8_t id_trame_high = (id_trame >> 8) & 0xFF;

    trame[0] = XB_V_START;
    trame[1] = XB_ADR_CURRENT_ROBOT;
    trame[2] = ad_dest;
    trame[3] = id_trame_low+4;
    trame[4] = id_trame_high+4;
    trame[5] = strlen(data)+4;
    trame[6] = code_fct;
 
    for(size_t i = 0; i < strlen(data); i++){
        trame[i+7] = data[i]; 
    }
    
    
    for(int i=0; i < length_trame; i++){
    	trame_int[i] = int(trame[i]);
    }
    int crc = crc16(trame_int, strlen(data)+6);
    uint8_t crc_low = crc & 0xFF;
    uint8_t crc_high = (crc >> 8) & 0xFF;

    trame[strlen(data)+7] = crc_low;
    trame[strlen(data)+8] = crc_high;
    trame[strlen(data)+9] = XB_V_END;

    serial.writeBytes(trame, length_trame);
    logXbee << "(sendTrame) envoi de la trame n°" << dec << id_trame_low+id_trame_high  << " effectué avec succès" << mendl; 

    trames_envoyees[code_fct] = trames_envoyees[code_fct]+1;

    return XB_TRAME_E_SUCCESS;
}

/*!
 *  \brief Découpe une trame reçue en fonction de ses paramètres et interprete son code fonction
 *  \return 200 succès
 *  \return -201 taille de la trame incorrecte ou non concordante
 *  \return -202 premier caractère de la trame incorrect
 *  \return -203 dernier caractère de la trame incorrect
 *  \return -204 valeur du CRC incorrecte
 *  \return -205 adresse de l'expéditeur incorrecte ou inconnue
 *  \return -206 adresse du destinataire incorrecte ou inconnue
 */
int XBee::processTrame(vector<int> trame_recue){
    
    if(!isTrameSizeCorrect(trame_recue)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_SIZE << " : taille de la trame incorrecte ou non concordante " << mendl;
        return XB_TRAME_E_SIZE;
    }
    Trame_t trame = {
        .start_seq = trame_recue[0],
        .adr_emetteur = trame_recue[1],
        .adr_dest = trame_recue[2],
        .id_trame_low = trame_recue[3]-4,
        .id_trame_high = trame_recue[4]-4,
        .nb_octets_msg = trame_recue[5]-4,
        .code_fct = trame_recue[6],
        .crc_low = trame_recue[3+trame_recue[4]],
        .crc_high = trame_recue[4+trame_recue[4]],
        .end_seq = trame_recue[5+trame_recue[4]]
    };

    vector<int> data {};
    
    for(uint8_t i = 0; i < trame.nb_octets_msg; i++){
       data.push_back(trame_recue[7+i]); 
    }

    trame.param = data;

    afficherTrameRecue(trame);

    int decoupe_trame[trame_recue[4]+6];

    for(uint8_t i = 0; i < trame_recue[4]+3; i++){
        decoupe_trame[i] = trame_recue[i];
    }

    if(!isStartSeqCorrect(trame.start_seq)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_START << " : premier caractère de la trame incorrect " << mendl;
        return XB_TRAME_E_START;
    }

    if(!isEndSeqCorrect(trame.end_seq)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_END << " : dernier caractère de la trame incorrect " << mendl;
        return XB_TRAME_E_END;
    }

    if(!isCRCCorrect(trame.crc_low, trame.crc_high, decoupe_trame, trame_recue[4]+2)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_CRC << " : valeur du CRC incorrecte " << mendl;
        return XB_TRAME_E_CRC;
    }

    if(!isExpCorrect(trame.adr_emetteur)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_EXP << " : adresse de l'expéditeur incorrecte ou inconnue " << mendl;
        return XB_TRAME_E_EXP;
    }

    if(!isDestCorrect(trame.adr_dest)){
        logXbee << "/!\\ (process trame) erreur " << XB_TRAME_E_DEST << " : adresse du destinataire incorrecte ou inconnue " << mendl;
        return XB_TRAME_E_DEST;
    }

    processCodeFct(trame.code_fct, trame.adr_emetteur);

    logXbee << "(process trame) trame n°" << trame.id_trame_high+trame.id_trame_low << "a été traitée avec succès " << mendl;
	
    return XB_TRAME_E_SUCCESS;
}

/*!
 *  \brief Interprète le code fonction issu d'une trame reçue
 *  \return 100 succès
 *  \return -101 code fonction incorrect
 *  \return -102 code fonction existant mais ne déclenchant aucune action  
 */
int XBee::processCodeFct(int code_fct, int exp){
    if(!isCodeFctCorrect(code_fct)){
        logXbee << "/!\\ (process code fonction) erreur " << XB_FCT_E_NOT_FOUND << " : code fonction incorrect " << mendl;
        return XB_FCT_E_NOT_FOUND;
    }
    char msg[1];
    switch(code_fct){
       case XB_FCT_TEST_ALIVE :
           msg[0] = {XB_V_ACK};
           sendTrame(exp, XB_FCT_TEST_ALIVE, msg);
           break;

       default :
           logXbee << "/!\\ (process code fonction) erreur " << XB_FCT_E_NONE_REACHABLE << " : code fonction existant mais ne déclenchant aucune action  " << mendl;
           return XB_FCT_E_NONE_REACHABLE;
    }

    trames_envoyees[code_fct] = trames_envoyees[code_fct]-1;
    logXbee << "(process code fonction) code fonction n°" << code_fct << " traité avec succès" << mendl;
    return XB_FCT_E_SUCCESS;
}

/*!
 *  \brief Vérifie si le code fonction donné est présent dans le fichier define.h
 *  \param code_fct : le code fonction à vérifier
 *  \return true : le code fonction est correct
 *  \return false : le code fonction est incorrect/n'existe pas
 */
bool XBee::isCodeFctCorrect(int code_fct){
    int size_list_code_fct = sizeof(XB_LIST_CODE_FCT)/sizeof(XB_LIST_CODE_FCT[0]), i = 0;

    while(i < size_list_code_fct){
        if(XB_LIST_CODE_FCT[i] == code_fct)
            return true;
        i++;
    }

    return false;
}

/*!
 *  \brief Vérifie si la taille de la trame est cohérente
 *  \param trame : la trame à vérifier
 *  \return true : la taille de la trame semble cohérente
 *  \return false : la taille de la trame est incorrecte, trop petite ou non cohérente
 */
bool XBee::isTrameSizeCorrect(vector<int> trame){
    if(trame.size() > 10 && trame.size() == trame[4]+5)
        return true;

    return false;
}

/*!
 *  \brief Vérifie si une adresse d'expéditeur est correcte
 *  \param exp : l'adresse de l'expéditeur à vérifier
 *  \return true : l'adresse est correcte
 *  \return false : l'adresse est incorrecte
 */
bool XBee::isExpCorrect(int exp){
    int size_list_addr = sizeof(XB_LIST_ADR)/sizeof(XB_LIST_ADR[0]), i = 0;

    while(i < size_list_addr){
        if(XB_LIST_ADR[i] == exp)
            return true;

        i++;
    }

    return false;
}

/*!
 *  \brief Vérifie si une adresse de destination est correcte
 *  \param exp : l'adresse de destination à vérifier
 *  \return true : l'adresse est correcte
 *  \return false : l'adresse est incorrecte
 */
bool XBee::isDestCorrect(int dest){
    int size_list_addr = sizeof(XB_LIST_ADR)/sizeof(XB_LIST_ADR[0]), i = 0;

    while(i < size_list_addr){
        if(XB_LIST_ADR[i] == dest)
            return true;

        i++;
    }

    return false;
}

/*!
 *  \brief Vérifie si le caractère de début de la trame correpond à celui attendu
 *  \param value : le caractère à vérifier
 *  \return true : le caratère est bien celui attendu
 *  \return false : le caractère est incorrect
 */
bool XBee::isStartSeqCorrect(int value){
    if(value == XB_V_START)
        return true;

    return false;
}

/*!
 *  \brief Vérifie si le caractère de fin de la trame correpond à celui attendu
 *  \param value : le caractère à vérifier
 *  \return true : le caratère est bien celui attendu
 *  \return false : le caractère est incorrect
 */
bool XBee::isEndSeqCorrect(int value){
    if(value == XB_V_END)
        return true;

    return false;
}

/*!
 *  \brief Vérifie si le CRC reçu est cohérent avec la trame reçue
 *  \param crc_low : les bits de poids faible du CRC reçu
 *  \param crc_high : les bits de poids forts du CRC reçu
 *  \param trame : la trame reçue (en enlevant le CRC et le caratère de fin de trame)
 *  \param trame_size : la taille de le trame telle qu'entrée dans la fonction
 *  \return true : la valeur du CRC reçue est bien celle calculée à partir du reste de la trame
 *  \return false : la valeur du CRC est incohérente ou non calculable
 */
bool XBee::isCRCCorrect(uint8_t crc_low, uint8_t crc_high, int trame[], int trame_size){
    int crc = crc16(trame, trame_size);

    uint8_t newcrc_low = crc & 0xFF;
    uint8_t newcrc_high = (crc >> 8) & 0xFF;

    if(newcrc_low == crc_low && newcrc_high == crc_high)
        return true;

    return false;
}

/*!
 *  \brief Permet de lire l'intégralité du buffer Rx de la RaspberryPi
 *  \return rep : la valeur du buffer sous forme d'un vecteur d'entiers signés sur 32 bits
 */
vector<int> XBee::readBuffer(){
    char *reponse(0);
    unsigned int timeout = 100;
    reponse = new char;
    vector<int> rep;
    delay(1);
    int i = 0;
    while(serial.available() > 0){
        i++;
        serial.readChar(reponse, timeout);
        rep.push_back(*reponse);
    }
    delete reponse;
    reponse = 0;

    return rep;
}


/*!
 *   \brief Permet de lire l'intégralité du contenu du buffer Rx de la RaspberryPi et de le renvoyer sous forme d'objet string
 *   \return rep : la valeur du buffer concaténée sous forme d'objet string
 */
string XBee::readString() {
     char *reponse(0);
     unsigned int timeout = 100;
     reponse = new char;
     string rep;
     delay(1);
     int i = 0;

     while(serial.available() > 0){
        i++;
        serial.readChar(reponse, timeout);
        rep += *reponse;
     }

      delete reponse;
      reponse = 0;
      return rep;

}

/*!
 *  \brief Permet l'attente et la vérification régulée d'une trame en entrée dans le buffer du port Rx de la RaspberryPi et d'appeler la fonction de découpe des trames.
 */
void XBee::waitForATrame(){
   vector<int> rep;
   
   while(true){
     rep.clear();

     delay(1/100);
     
     if(serial.available() > 0){
       rep = readBuffer();
       subTrame(rep);
     }
   }
}

/*!
 *  \brief Découpe le résultat de la lecture du buffer en différentes trames avant le traitement 
 *
 *  \param msg_recu : le résultat de la lecture du buffer
 *  \return 300 succès
 *  \return -301 la position des trames dans le message reçu est incorrecte : les caractères de début et de fin de trame ne sont pas au même nombre
 *  \return -302 la position des trames dans le message reçu est incorrecte : certains caractères de début de trame sont placés après des caractères de fin de trame
 *  \return -303 la position des trames dans le message reçu est incorrecte : des caractères inconnus sont placés entre deux trames
 *  \return -304 le premier caractère lu dans le buffer n'est pas celui d'un début de trame
 *  \return -305 le dernier caractère lu dans le buffer n'est pas celui d'une fin de trame
 *  \return -306 aucun caractère de début et/ou de fin n'est présent dans le message reçu
 */
int XBee::subTrame(vector<int> msg_recu){

    vector<int> list_start_seq {};
    vector<int> list_end_seq {};
    vector<int> decoupe {};
    int decoupe_retour;

    for(uint8_t i = 0; i < msg_recu.size(); i++){
        if(msg_recu[i] == XB_V_START)
            list_start_seq.push_back(i);

        if(msg_recu[i] == XB_V_END)
            list_end_seq.push_back(i);
    }

    if(list_start_seq.size() == 0 || list_end_seq.size() == 0){
        logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_NULL << " : aucun caractère de début et/ou de fin n'est présent dans le message reçu " << mendl;
	    return XB_SUB_TRAME_E_NULL;
    }

    if(list_start_seq.size() != list_end_seq.size()){
        logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_SIZE << " : les caractères de début et de fin de trame ne sont pas au même nombre " << mendl;
        return XB_SUB_TRAME_E_SIZE;
    }

    for(uint8_t i = 0; i < list_start_seq.size(); i++){
        if(list_start_seq[i] > list_end_seq[i]){
            logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_REPARTITION << " : certains caractères de début de trame sont placés après des caractères de fin de trame " << mendl;
            return XB_SUB_TRAME_E_REPARTITION;
        }

        if(i != 0){
            if(list_start_seq[i] != list_end_seq[i-1]-1){
                logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_DECOUPAGE << " : des caractères inconnus sont placés entre deux trames " << mendl;
                return XB_SUB_TRAME_E_DECOUPAGE;
            }
        }
    }


    if(list_start_seq[0] != 0){
        logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_START << " : le premier caractère lu dans le buffer n'est pas celui d'un début de trame " << mendl;
        return XB_SUB_TRAME_E_START;
    }
    
    if(list_end_seq[list_end_seq.size()-1] != msg_recu.size()-1){
        logXbee << "/!\\ (découpe trame) erreur " << XB_SUB_TRAME_E_END << " : le dernier caractère lu dans le buffer n'est pas celui d'une fin de trame " << mendl;
        return XB_SUB_TRAME_E_END;
    }
    
    for(uint8_t i = 0; i < list_start_seq.size(); i++){
       decoupe.clear();
       decoupe = slice(msg_recu, list_start_seq[i], list_end_seq[i]); 
       decoupe_retour = processTrame(decoupe);
    }   

    logXbee << "(découpe trame) découpage des trames effectué avec succès" << mendl;
    return XB_SUB_TRAME_E_SUCCESS;  
}

/*!
 *  \brief Permet d'envoyer des demandes de battements de coeur au second robot afin de savoir s'il est toujours opérationnel
 */
void XBee::sendHeartbeat(){
    char* msg;
    msg[0] = XB_V_ACK;

    while(true){
      delay(3);
      sendTrame(XB_ADR_ROBOT_02, XB_FCT_TEST_ALIVE, msg);
   } 
}

/*!
 *  \brief Permet de vérifier si un message envoyé a reçu une réponse
 */
int XBee::isXbeeResponding(){
    int size_list_code_fct = sizeof(XB_LIST_CODE_FCT)/sizeof(XB_LIST_CODE_FCT[0]);
    while(true){
      delay(3);  
      for(int i = 0; i < size_list_code_fct; i++){
          if(trames_envoyees[XB_LIST_CODE_FCT[i]] == 0){
              logXbee << "(verif reponse) les trames envoyées portant le code fonction " << XB_LIST_CODE_FCT[i] << " ont toutes reçues une réponse" << mendl;
          }else{
              logXbee << "(verif reponse) /!\\ les trames envoyées portant le code fonction " << XB_LIST_CODE_FCT[i] << " n'ont pas toutes reçues une réponse" << mendl;
          }
      }
   } 
}

/*!
 *  \brief Permet d'envoyer un mesage ASCII sans format particulier via XBee
 *  \param msg : le message à envoyer
 */
void XBee::sendMsg(string msg){
    serial.writeString(stringToChar(msg));
    logXbee << "(envoi message) message : " << msg << " envoyé avec succès" << mendl;
}

/*!
 *  \brief Permet de convertir un objet de type string en chaine de caractère standard C
 *  \param chaine : l'objet string à convertir
 *  \return message : la chaine de caractère convertie
 */
char* XBee::stringToChar(string chaine){
    char* message = strcpy(new char[chaine.size() + 1], chaine.c_str());
    return message;
}

/*!
 *  \brief Permet de convertir une chaine de caractère standard C en objet de type string
 *  \param message : la chaine de caractère à convertir
 *  \return chaine : l'objet de type string converti
 */
string XBee::charToString(char* message){
    string chaine = string(message);
    return chaine;
}

/*!
 * \brief Fonction d'affichage des données découpées d'une structure de type Trame
 */
void XBee::afficherTrameRecue(Trame_t trame){
    cout << hex << showbase;
    cout << "\t-> Start seq : " << trame.start_seq << endl;
    cout << "\t-> Emetteur : " << trame.adr_emetteur << endl;
    cout << "\t-> Destinataire : " << trame.adr_dest << endl;
    cout << "\t-> Id trame  : " << trame.id_trame_low << " " << trame.crc_high << endl;
    cout << "\t-> Taille msg : " << trame.nb_octets_msg - 3 << endl;
    cout << "\t-> Code fct : " << trame.code_fct << endl;
    cout << "\t-> Data : ";
    print(trame.param);
    cout << "\t-> CRC : " << trame.crc_low << " " << trame.crc_high << endl;
    cout << "\t-> End seq : " << trame.end_seq << endl;
}

/*!
 *  \brief Fonction d'affichage des valeurs contenues dans un vecteur d'entiers
 *  \param v : le vecteur dont on souhaite afficher le contenu
 */
void XBee::print(const vector<int> &v){
    copy(v.begin(), v.end(),
            ostream_iterator<int>(cout << hex, " "));
    cout << endl;
}

/*!
 *  \brief Fonction de traitement permettant d'extraire un sous-vecteur d'entiers d'un vecteur d'entiers
 *  \param v : le vecteur à découper
 *  \param a : l'indice de la première valeur à découper
 *  \param b : l'indice de la dernière valeur à découper
 *  \return vec : le sous-vecteur d'entiers découpé
 */
vector<int> XBee::slice(const vector<int> &v, int a, int b){
    auto first = v.cbegin() + a;
    auto last = v.cbegin() + b + 1;

    vector<int> vec(first, last);
    return vec;
}
