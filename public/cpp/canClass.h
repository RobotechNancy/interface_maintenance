/*! 
 * 	\file canClass.h
 *  \brief     classe de gestion d'un bus can
 *  \details   Cette classe permet d'envoyer et de recevoir des messages via un bus can
 *  \author    Theo RUSINOWITCH <theo.rusinowitch1@etu.univ-lorraine.fr>
 *  \version   4.1a
 *  \date      2021-2022
 */
#if !defined CANCLASS_H
#define CANCLASS_H
#include <thread>
#include <linux/can.h>
#include "logLib.h"
#include "defineCan.h"
#include <map>

#include <sys/time.h>





/*!
 * \struct CanResponse_t
 * \brief contient un message décoder venant du bus can
 * \param addr addresse du destinataire du message
 * \param emetteur adresse de l'émeteur du message 
 * \param codeFct code fonction du message
 * \param isRep vrai si c'est une reponse a une requete, faux sinon
 * \param RepId indique le nombre de reponse atendu pour une requete et le num de la reponse pour une reponse
 * \param dataLen frame payload length in byte (0 .. 8) aka data length code
 * \param data CAN frame payload (up to 8 byte)
 */
struct CanResponse_t{
	uint32_t addr;	/* addresse du destinataire du message */
	uint32_t emetteur;	/* adresse de l'éméteur */
	uint32_t codeFct;	/* code fonction du msg */
    uint idMessage ;
	bool isRep;	/* vrai si c'est une reponse a une requete, faux sinon */
	uint RepId;	/* nb de rep atendu si requete, num de la rep si reponse */
	uint dataLen;	/* frame payload length in byte (0 .. 8) */
	unsigned char data[8];
}; 



typedef union {
    struct {
        uint32_t nb_steps : 32;
        uint8_t div0 : 8;
        uint8_t div1 : 8;
        uint8_t div2 : 8;
        bool dir0 : 1;
        bool dir1 : 1;
        bool dir2 : 1;
		uint8_t unused : 5;
    } fields;
    uint64_t unified;
    uint8_t raw_data[8];
} Tramme_Moteur_t;

typedef union {
    struct {
        uint16_t dx : 16;
        uint16_t dy : 16;
        bool signeX : 1;
        bool signeY : 1;
        uint8_t unused : 6;
    } fields;
    uint64_t unified;
    uint8_t raw_data[5];
} Tramme_Variation_position_t;

typedef union {
    struct {
    	uint16_t Dictance : 16;
        uint8_t TofId : 8;
    } fields;
    uint32_t unified;
    uint8_t raw_data[3];
} Tramme_Deetection_TOF_t;

typedef enum{
    NEUTRE = 0,
    STATUETTE = 1,
    AIMANT = 2,
    INCONNUE = 3
} POSITION_GLICIERE_STATUE;





/*!
 *	\class Can
 *  \brief classe qui gère l'envoie et la réception de msg via un bus can
 *  \param s idantifiant du gestionnaire du bus
 *  \param threadListen objet du thread d'écoute du bus can
*/
class Can{
  private:
	int s;
	std::thread* threadListen;
	void listen();
	int traitement_trame(CanResponse_t &rep, can_frame frame);
    
  
  
  public:

    std::map<uint,CanResponse_t>messages;




	Can() : logC("can") {};
	Log logC;
	int init(CAN_EMIT_ADDR myAddr);
    
    bool is_message(uint id);
    CanResponse_t get_message(uint id);


	int send(CAN_ADDR addr, CAN_CODE_FCT codeFct , uint8_t data[], uint data_len, bool isRep, uint repLenght, uint idmessage);
	void traitement(CanResponse_t msg);
	int start_listen();
};

    
#endif