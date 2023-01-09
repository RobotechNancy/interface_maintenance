/*!
 \file    xbeelib.h
 \brief   Fichier d'en-tête de la classe XBee. Cette classe est utilisée afin de programmer les modules XBee en UART et de mettre en place des communications entre différents modules XBee.
 \author  Samuel-Charles DITTE-DESTREE (samueldittedestree@protonmail.com)
 \version 3.0
 \date    10/03/2022
 */
#ifndef XBEE_H
#define XBEE_H

#include "xbee_define.h"
#include "serialib.h"
#include "loglib.h"
#include <string>
#include <vector>
#include <iomanip>
#include <iostream>
#include <chrono>
#include <thread>
#include <iterator>

/*!  \class     XBee
 *   \brief     Cette classe est utilisée pour la communication entre un module XBee et une RaspberryPi et entre plusieurs modules XBee.
 */
class XBee{

public:

    // Constructeur de la classe
    XBee();

    // Desctructeur de la classe
    ~XBee();
    
    // Ouverture de la connexion série
    int openSerialConnection(int mode = 0);

    // Fermeture de la connexion série
    void closeSerialConnection();

    // Vérfication et paramétrage de la configuration AT par défaut du module
    int checkATConfig();

    // Lecture de la réponse du module à une commande AT
    bool readATResponse(const char *value = XB_AT_R_EMPTY, int mode = 0);

    // Envoi d'une commande AT 
    bool sendATCommand(const char *command, const char *value, unsigned int mode = XB_AT_M_SET);

    // Ecriture de la configuration AT dans la mémoire flash du module
    bool writeATConfig();

    // Création et envoi de la trame de message structurée
    int sendTrame(uint8_t ad_dest, uint8_t code_fct, char* data = 0x00);
    
    // Envoi d'un objet string quelconque
    void sendMsg(std::string msg);

    // Attente de trames dans le buffer Rx et appel des fonctions de traitement
    void waitForATrame();

    // Envoi de la demande de battement de coeur
    void sendHeartbeat();

    // Permet de vérifier si un message envoyé a reçu une réponse
    int isXbeeResponding();

    // Conversion char* en string
    std::string charToString(char* message);

    // Conversion string en char*
    char* stringToChar(std::string chaine);
    
    // Affichage du contenu d'un vecteur d'entiers
    void print(const std::vector<int> &v);

private:

    /*!
     * \typedef Trame_t
     * \brief Format des trames reçues en fonction des paramètres de la trame
     */  
    typedef struct{
      int start_seq; /*!< Caractère de début de trame */
      int adr_emetteur; /*!< Adresse de l'émetteur de la trame */
      int adr_dest; /*!< Adresse du destinataire de la trame */
      int id_trame_low; /*!< Bits de poids faible de l'ID de la trame */
      int id_trame_high; /*!< Bits de poids fort de l'ID de la trame */
      int nb_octets_msg; /*!< Nombre d'octets du champ data + code fonction */
      int code_fct; /*!< Code fonction de la trame */
      std::vector<int> param; /*!< Data de la trame */
      int crc_low; /*!< Bits de poids faible du CRC */
      int crc_high; /*!< Bits de poids fort du CRC */
      int end_seq; /*!< Caractère de fin de trame */

    } Trame_t;

    // Entrée dans le mode de configuration AT
    bool enterATMode();

    // Sortie du mode de configuration AT
    bool exitATMode();

    // Lance une découverte réseau des modules Xbee
    bool discoverXbeeNetwork();

    // Vérifie si l'adresse de l'expéditeur existe 
    bool isExpCorrect(int exp);

    // Vérifie si l'adresse de destination existe 
    bool isDestCorrect(int dest);

    // Vérifie si le code fonction existe 
    bool isCodeFctCorrect(int code_fct);

    // Vérifie si la taille de la trame est cohérente 
    bool isTrameSizeCorrect(std::vector<int> trame);

    // Découpe un ensemble de trames en trames uniques
    int subTrame(std::vector<int> msg_recu);

    // Interprète le code fonction et exécute les fonctions associées
    int processCodeFct(int code_fct, int exp);

    // Affichage des différents paramètres d'une structure Trame_t 
    void afficherTrameRecue(Trame_t trame);

    // Interprète et contrôle l'intégrité d'une trame reçue
    int processTrame(std::vector<int> trame);

    // Lis le contenu du buffer Rx de la RaspberryPi
    std::vector<int> readBuffer();

    // Lis le contenu du buffer Rx de la RaspberryPi
    std::string readString();

    // Calcul du CRC16 Modbus de la trame
    int crc16(int trame[], uint8_t taille);
    
    // Vérifie si le caractère de début de trame est correct
    bool isStartSeqCorrect(int value);

    // Vérifie si le caractère de fin de trame est correct
    bool isEndSeqCorrect(int value);

    // Vérifie si le CRC de la trame est correct
    bool isCRCCorrect(uint8_t crc_low, uint8_t crc_high, int trame[], int trame_size);

    // Retard de temporisation dans l'exécution du code
    void delay(unsigned int time);

    // Découpe un vecteur d'entiers en un sous vecteur 
    std::vector<int> slice(const std::vector<int> &v, int a, int b);

    // Variable calculant l'ID de la trame
    int ID_TRAME = 0;

    // Variable permettant de définir la configuration série à utiliser
    int MODE = 0;

    //vecteur contenant la liste des trames envoyées classées par destinataire et code fonction
    int trames_envoyees[100];
};

#endif // XBEE_H
