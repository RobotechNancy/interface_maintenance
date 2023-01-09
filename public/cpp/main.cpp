#include <stdio.h>
#include <iostream>
#include "canClass.h"
#include "convertionTramePR.h"
#include "logLib.h"
#include "defineCan.h"
#include <unistd.h>
//#include "xbeelib.h"


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
    {101, "Envoi CAN impossible"},
    {105, "Direction base roulante non reconnue"},
    {106, "Relais arrêt d'urgence désactivé"},
    {110, "Longueur DATA CAN trop grande"},
    {111, "Adresse destination CAN incorrecte"},
    {112, "Code fonction CAN incorrect"},
    {113, "Valeur REP NBR CAN incorrecte"},
    {114, "Valeur DATA CAN incorrecte"},
    {151, "Adresse destination CAN inconnue"},
    {152, "Code fonction CAN inconnu"}
};

//Tente d'executer la commande passée en paramètre
int tryCommand(string c)
{
    FILE *fp;
    char path[1035];
    const char *command = c.c_str();
    fp = popen(command, "r");

    string output = "";

    if (fp == NULL) return 5;

    while (fgets(path, sizeof(path), fp) != NULL) pclose(fp);
    //for (int i = 0; i < sizeof(path); i++) output += path[i];
    return 0;
}

//Lit l'état du relais avec la commande popen("gpio read 2", "r")
bool readRelayPin()
{
    FILE *fp;
    char path[1035];
    fp = popen("gpio read 2", "r");
    if (fp == NULL) return false;
    while (fgets(path, sizeof(path), fp) !=NULL)
    pclose(fp);

    if(path[0] == '1') return true;
    else return false;
}

// Retourne le prochain paramètre et le supprime de l'entrée
string nextParameter(string & s)
{
    string delimiter = ",";
    size_t pos = 0;
    string token;
    if ((pos = s.find(delimiter)) != string::npos) {
        token = s.substr(0, pos);
        s.erase(0, pos + delimiter.length());
        return token;
    }
    else{
        token = s;
        s = "";
        return token;
    }

}

// Convertit les codes d'erreur CAN pour qu'ils soient positifs
int convertCanError(int error){
    switch (error){
        case -501:
            return 101;
            break;

        case -502:
            return 102;
            break;

        case -503:
            return 103;
            break;

        case -504:
            return 104;
            break;

        case -510:
            return 110;
            break;

        case -511:
            return 111;
            break;

        case -512:
            return 112;
            break;

        case -513:
            return 113;
            break;

        case -514:
            return 114;
            break;

        case -551:
            return 151;
            break;

        case -552:
            return 152;
            break;

        default:
            return 0;
            break;
    }
}

// Gère les commandes pour le relais
int relais(string s)
{
    string command = nextParameter(s);
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

// Gère les commandes pour les tests communication
int testComm(string s){
    string command = nextParameter(s);
    if(readRelayPin()){
        if(command == "Odo") //Envoie une trame de test de communication à l'odométrie et attend la réponse
        {
            uint8_t data[1] = {0x00};
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
    }
    else return 106;

    if(command == "XB")
    {
        return 0;
    }
    else return 4;
}


// Déplace la base roulante en fonction des paramètres de la trame
int move(string s)
// Trame de Base roulante : BR,Move,distance,vitesse,direction
// Distance en mm, vitesse en mm/s, direction : Av, Re, AvD, AvG, ReD, ReG
{
    if(readRelayPin())
    {
        Trame_BR_dpt data;
        Trame_Moteur_t trameMoteur;
        data.fields.distance = (uint16_t)atoi(nextParameter(s).c_str());
        data.fields.vitesse = (uint16_t)atoi(nextParameter(s).c_str());
        string dir = nextParameter(s);
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

    else return 106;
}

// Gère les commandes pour la base roulante
int BaseRoulante(string s)
{

    int error = testComm("BR");
    if(error != 0) return error;
    string command = nextParameter(s);


    if(command == "Move")
    {
        return move(s);
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
int initCan(Can & can)
{
    Log sysLog("systeme");

    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY

    if(err < 0)
    {
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }

    return err;
}

/* void ajoutCodeErreur(int id, string erreur){
    error_codes.insert(pair<int, string>(id, erreur));
} */

// Reçoit une trame du serveur web et la traite en fonction de son contenu
int main(int argc, char **argv)
{

    initCan(can);

    string input = argv[argc-1], param = nextParameter(input);

    int id = 0;

    if(param == "BR") id = BaseRoulante(input);
    else if(param == "Relais") id = relais(input);
    else if(param == "TestComm") id = testComm(input);
    else id = 2;

    cout << error_codes[id] << endl;
    return id;
}
