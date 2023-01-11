#include <stdio.h>
#include <iostream>
#include "canClass.h"
#include "convertionTramePR.h"
#include "logLib.h"
#include "defineCan.h"
#include <unistd.h>
#include "xbeelib.h"

using namespace std;

Can can;

map<int, string> error_codes {
    {0, "Succès de la commande"},
    {1, "Erreur générale ou inconnue"},
    {2, "Commande générale inconnue"},
    {3, "Commande relais inconnue"},
    {4, "Commande test comm inconnue"},
    {5, "Impossible de modifier le relais"},
    {6, "Délais de réponse dépassé"},
    {7, "Erreur commande terminal"},
    {101, "Envoi CAN impossible"},
    {102, "Erreur dans la lecture de la trame CAN depuis le buffer"},
    {103, "Erreur dans l'ouverture du socket"},
    {104, "Erreur dans la lecture du socket CAN"},
    {105, "Direction base roulante non reconnue"},
    {106, "Relais alimentation désactivé"},
    {110, "Longueur DATA CAN trop grande"},
    {111, "Adresse destination CAN incorrecte"},
    {112, "Code fonction CAN incorrect"},
    {113, "Valeur REP NBR CAN incorrecte"},
    {114, "Valeur DATA CAN incorrecte"},
    {151, "Adresse destination CAN inconnue"},
    {152, "Code fonction CAN inconnu"}
};

/*!
 *  \brief Tente d'executer la commande passée en paramètre
 *  \param command Commande à executer
 *  \retval 0 La commande s'est bien executée
 *  \retval 7 Erreur dans l'execution de la commande
*/
int tryCommand(string command)
{
    FILE *fp;
    fp = popen(command.c_str(), "r");
    if (fp == NULL) return 7;
    return 0;
}

/*!
 *  \brief Lit l'état du relais avec la commande popen("gpio read 2", "r")
 *  \retval true Le relais est allumé
 *  \retval false Le relais est éteint
*/
bool readRelayPin()
{
    FILE *fp;
    char path[1035];
    fp = popen("gpio read 2", "r");
    if (fp == NULL) return false;
    while (fgets(path, sizeof(path), fp) !=NULL);
    if(path[0] == '1') return true;
    else return false;
}

/*!
 *  \brief Retourne le prochain paramètre et le supprime de l'entrée
 *  \param input Trame à traiter
 *  \retval Prochain paramètre de la trame
*/
string nextParameter(string & input)
{
    string delimiter = ",";
    size_t pos = 0;
    string token;
    if ((pos = input.find(delimiter)) != string::npos) {
        token = input.substr(0, pos);
        input.erase(0, pos + delimiter.length());
        return token;
    }
    else{
        token = input;
        input = "";
        return token;
    }
}

/*!
 *  \brief Convertit les codes d'erreur CAN pour qu'ils soient positifs
 *  \param error Le numéro d'erreur à convertir
 *  \retval 101 Envoi CAN impossible
 *  \retval 102 Erreur dans la lecture de la trame depuis le buffer
 *  \retval 103 Erreur dans l'ouverture du socket
 *  \retval 104 Erreur dans la lecture du socket
 *  \retval 110 Longueur DATA CAN trop grande
 *  \retval 111 Adresse destination CAN incorrecte
 *  \retval 112 Code fonction CAN incorrect
 *  \retval 113 Valeur REP NBR CAN incorrecte
 *  \retval 114 Valeur DATA CAN incorrecte
 *  \retval 151 Adresse destination CAN inconnue
 *  \retval 152 Code fonction CAN inconnu
*/
int convertCanError(int error){
    switch (error){
        case -501:
            return 101; // Envoi CAN impossible
            break;

        case -502:
            return 102; // Erreur dans la lecture de la trame depuis le buffer
            break;

        case -503:
            return 103; // Erreur dans l'ouverture du socket
            break;

        case -504:
            return 104; // Erreur dans la lecture du socket
            break;

        case -510:
            return 110; // Longueur DATA CAN trop grande
            break;

        case -511:
            return 111; // Adresse destination CAN incorrecte
            break;

        case -512:
            return 112; // Code fonction CAN incorrect
            break;

        case -513:
            return 113; // Valeur REP NBR CAN incorrecte
            break;

        case -514:
            return 114; // Valeur DATA CAN incorrecte
            break;

        case -551:
            return 151; // Adresse destination CAN inconnue
            break;

        case -552:
            return 152; // Code fonction CAN inconnu
            break;

        default:
            return 0;
            break;
    }
}

/*!
 *  \brief Gère les commandes pour le relais
 *  \param input Commande relais
 *  \retval 0 La commande s'est bien executée
 *  \retval 3 Commande relais inconnue
 *  \retval 106 Relais alimentation désactivé
*/
int relais(string input)
{
    string command = nextParameter(input);
    int id;

    if(command == "ON")
    {
        id = tryCommand("gpio mode 3 output");

        if(id == 0)
            id = tryCommand("gpio write 3 1");

        return id;
    }
    else if(command == "OFF")
    {
        id = tryCommand("gpio mode 3 output");

        if(id == 0)
            id = tryCommand("gpio write 3 0");

        return id;
    }
    else if(command == "Test")
    {
        if(readRelayPin()) return 0;
        else return 106;
    }
    else return 3;
}

/*!
 *  \brief Gère les commandes pour les tests communication
 *  \param input Commande test communication
 *  \retval 0 La commande s'est bien executée
 *  \retval 4 Commande test comm inconnue
 *  \retval 6 Délais de réponse dépassé
 *  \retval 106 Relais alimentation désactivé
*/
int testComm(string input){
    string command = nextParameter(input);
    if(readRelayPin()){
        if(command == "Odo") //Envoie une trame de test de communication à l'odométrie et attend la réponse
        {
            uint8_t data[1] = {0x00};
            // Destinataire : Odométrie, Code fonction : Test de communication, Data : 0x00, Rep Nbr : 1, Rep : false
            int retour_can = can.send(CAN_ADDR_ODOMETRIE, TEST_COMM, data, 1, false, 1,0);
            can.start_listen();
            if(retour_can == 0){
                for(int t = 0; t < 100; t++)
                {
                    while(can.is_message(0)){
                        CanResponse_t msg = can.get_message(0);
                        if(msg.codeFct == TEST_COMM && msg.addr == CAN_ADDR_ODOMETRIE_E){
                            return 0;
                        }
                    }
                    usleep(1000);
                }
                return 6;
            }
            else return convertCanError(retour_can);
        }

        else if(command == "BR") //Même principe que pour l'odométrie
        {
            uint8_t data[1] = {0x00};
            int retour_can = can.send(CAN_ADDR_BASE_ROULANTE, TEST_COMM, data, 1, false, 1,0);
            can.start_listen();
            if(retour_can == 0){
                for(int t = 0; t < 100; t++)
                {
                    while(can.is_message(0)){
                        CanResponse_t msg = can.get_message(0);
                        if(msg.codeFct == TEST_COMM && msg.emetteur == CAN_ADDR_BASE_ROULANTE_E){
                            return 0;
                        }
                    }
                    usleep(1000);
                }
                return 6;
            }
            else return convertCanError(retour_can);
        }
        else return 4;
    }
    else return 106;

    if(command == "XB")
    {
        return 0;
    }
    else return 4;
}

/*!
 *  \brief Déplace la base roulante en fonction des paramètres de la trame
 *  \param input Commande de déplacement : BR,Move,distance,vitesse,direction
 *  \retval 0 La commande s'est bien executée
 *  \retval 101 Envoi CAN impossible
 *  \retval 102 Erreur dans la lecture de la trame depuis le buffer
 *  \retval 103 Erreur dans l'ouverture du socket
 *  \retval 104 Erreur dans la lecture du socket
 *  \retval 105 Direction base roulante non reconnue
 *  \retval 106 Relais alimentation désactivé
 *  \retval 110 Longueur DATA CAN trop grande
 *  \retval 111 Adresse destination CAN incorrecte
 *  \retval 112 Code fonction CAN incorrect
 *  \retval 113 Valeur REP NBR CAN incorrecte
 *  \retval 114 Valeur DATA CAN incorrecte
 *  \retval 151 Adresse destination CAN inconnue
 *  \retval 152 Code fonction CAN inconnu
*/
int move(string input)
// Trame de Base roulante : BR,Move,distance,vitesse,direction
// Distance en mm, vitesse en mm/s, direction : Av, Re, AvD, AvG, ReD, ReG, RotD, RotG
{
    Trame_BR_dpt data;
    Trame_Moteur_t trameMoteur;
    data.fields.distance = (uint16_t)atoi(nextParameter(input).c_str());
    data.fields.vitesse = (uint16_t)atoi(nextParameter(input).c_str());
    string dir = nextParameter(input);
    int retour_can;

    if(dir == "Av") data.fields.direction = 1;
    else if(dir == "Re") data.fields.direction = 4;
    else if(dir == "AvD") data.fields.direction = 6;
    else if(dir == "AvG") data.fields.direction = 2;
    else if(dir == "ReD") data.fields.direction = 5;
    else if(dir == "ReG") data.fields.direction = 3;
    else if(dir == "RotD") data.fields.direction = 7;
    else if(dir == "RotG") data.fields.direction = 8;
    else return 105;


    convertir(&data, &trameMoteur);
    retour_can = can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);
    return convertCanError(retour_can);
}

/*!
 *  \brief Gère les commandes pour la base roulante
 *  \param input Commande à executer pour la base roulante
 *  \retval 0 La commande s'est bien executée
 *  \retval 2 Commande générale inconnue
 *  \retval 7 Erreur dans l'execution de la commande
 *  \retval Autre : Erreur bus CAN
*/
int BaseRoulante(string input)
{

    int error = testComm("BR");
    if(error != 0) return error;
    string command = nextParameter(input);


    if(command == "Move")
    {
        return move(input);
    }
    else if(command == "Stop")
    {
        uint8_t data[1] = {0x00};
        int retour_can = can.send(CAN_ADDR_BASE_ROULANTE, STOP, data, 1, false, 1,0);
        return convertCanError(retour_can);
    }
    else if(command == "StopUrgent")
    {
        uint8_t data[1] = {0x00};
        int retour_can = can.send(CAN_ADDR_BASE_ROULANTE, STOP_URGENT, data, 1, false, 1,0);
        return convertCanError(retour_can);
    }
    else return 2;
}

// Initialise le bus CAN
/*!
 *  \brief Initialise le bus CAN
 *  \param can Objet Can à initialiser
 *  \retval 0 L'initialisation s'est bien passée
 *  \retval Autre : Erreur bus CAN
*/
int initCan(Can & can)
{
    Log sysLog("systeme");
    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
    if(err < 0)
    {
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return convertCanError(err);
    }
    return convertCanError(err);
}

/*!
 *  \brief Reçoit une trame du serveur web et la traite en fonction de son contenu
*/
int main(int argc, char **argv)
{
    XBee xbee;

    int status = xbee.openSerialConnection();
    if(status != XB_SER_E_SUCCESS)
        return status;

    initCan(can);

    string input = argv[argc-1], param = nextParameter(input);

    int id = 0;

    if(param == "BR") id = BaseRoulante(input);
    else if(param == "Relais") id = relais(input);
    else if(param == "TestComm") id = testComm(input);
    else id = 2;

    cout << error_codes[id] << endl;

    thread heartbeat(&XBee::sendHeartbeat, xbee);
    thread waitingtrame(&XBee::waitForATrame, xbee);
    thread reponse(&XBee::isXbeeResponding, xbee);
    while(true){}

    xbee.closeSerialConnection();
    return id;
}
