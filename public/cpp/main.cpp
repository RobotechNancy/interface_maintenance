#include <stdio.h>
#include <iostream>
#include "canClass.h"
#include "convertionTramePR.h"
#include "logLib.h"
#include "defineCan.h"

using namespace std;

Can can;

map<int, string> error_codes;

int tryCommand(string c)
{ //Tente d'executer la commande passée en paramètre
    FILE *fp;
    char path[1035];
    const char *command = c.c_str();
    fp = popen(command, "r");

    string output = "";

    //fp = popen(command);

    if (fp == NULL) return 5;
    
    while (fgets(path, sizeof(path), fp) != NULL) pclose(fp);

    for (int i = 0; i < sizeof(path); i++) output += path[i];
    
    return 0;
}

bool readRelayPin()
{ //Lit l'état du relais avec la commande popen("gpio read 2", "r")
    /* FILE *fp;
    char path[1035];
    fp = popen("gpio read 2", "r");
    if (fp == NULL) {
        cout<<"Failed reading relay pin with popen\n" << endl;
    }
    while (fgets(path, sizeof(path), fp) !=NULL)
    pclose(fp);

    if(path[0] == '1') return true;
    else return false;   */  

    int id = 0;

    id = tryCommand("gpio read 2");

    if (id == 0)
        return true;
    else
        return false;
}


string nextParameter(string & s)
{ // Retourne le prochain paramètre et le supprime de l'input
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
    else return 3;
}

int testComm(string s){ 
    string command = nextParameter(s);

    if(command == "ODO")
    {
        //cout << "Test communication odométrie non implémentée" << endl;
        return 0;
    }
    else if(command == "BR")
    {
        //cout << "Test communication base roulante non implémentée" << endl;
        return 0;
    }
    else if(command == "XB")
    {
        //cout << "Test communication xbee non implémentée" << endl;
        return 0;
    }
    else return 4;
}


// Trame de Base roulante : BR, distance, vitesse, direction
// Ex : BR,100,100,Av
int move(string s)
{ // Trame de Base roulante : BR, distance, vitesse, direction
    if(readRelayPin())
    {
        Trame_BR_dpt data;
        Trame_Moteur_t trameMoteur;    
        data.fields.distance = atoi(nextParameter(s).c_str()); // or atoi(nextParameter(s).c_str());
        data.fields.vitesse = atoi(nextParameter(s).c_str()); 
        string dir = nextParameter(s);
        int retour_can;

        if(dir == "Av")
        { 
            data.fields.direction = 1; 
            //cout << "Direction avant" << endl;
            //cout << "Direction : " << data.fields.direction << endl;
        }
        else if(dir == "Re") data.fields.direction = 4;
        else if(dir == "AvD") data.fields.direction = 6;
        else if(dir == "AvG") data.fields.direction = 2;
        else if(dir == "ReD") data.fields.direction = 5;
        else if(dir == "ReG") data.fields.direction = 3;
        else if(dir == "RotD") data.fields.direction = 7;
        else if(dir == "RotG") data.fields.direction = 8;
        else return 105;
        
        //cout << "Distance : " << data.fields.distance << endl;
        //cout << "Vitesse : " << data.fields.vitesse << endl;
        //cout << "Direction : " << data.fields.direction << endl;
        convertir(&data, &trameMoteur);

        retour_can = can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);

        switch (retour_can){
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
                return 1;
                break;
        }
    }

    else return 106;
}

int initCan()
{
    Log sysLog("systeme");
    Can can;

    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
    
    if(err < 0)
    {
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }

    return err;
}

void ajoutCodeErreur(int id, string erreur){
    error_codes.insert(pair<int, string>(id, erreur));
}

int main(int argc, char **argv) 
{
    
    ajoutCodeErreur(0, "Succès de la commande");
    ajoutCodeErreur(1, "Erreur générale ou inconnue");

    ajoutCodeErreur(2, "Commande générale inconnue");
    ajoutCodeErreur(3, "Commande relais inconnue");
    ajoutCodeErreur(4, "Commande test comm inconnue");
    ajoutCodeErreur(5, "Impossible de modifier le relais");

    ajoutCodeErreur(101, "Envoi CAN impossible");
    ajoutCodeErreur(105, "Direction non reconnue");
    ajoutCodeErreur(106, "Relais désactivé");

    ajoutCodeErreur(110, "Longueur DATA CAN trop grande");
    ajoutCodeErreur(111, "Adresse destination CAN incorrecte");
    ajoutCodeErreur(112, "Code fonction CAN incorrect");
    ajoutCodeErreur(113, "Valeur REP NBR CAN incorrecte");
    ajoutCodeErreur(114, "Valeur DATA CAN incorrecte");

    ajoutCodeErreur(151, "Adresse destination CAN inconnue");
    ajoutCodeErreur(152, "Code fonction CAN inconnu");

    initCan();

    string input = argv[argc-1], param = nextParameter(input);
    int id = 0;

    if(param == "BR")
        id = move(input);
    
    else if(param == "Relais")
        id = relais(input);
    
    else if(param == "TestComm")
        id = testComm(input);
    
    else id = 2;

    cout << error_codes[id] << endl;
    return id;
}