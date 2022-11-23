#include <stdio.h>
#include <iostream>
#include "canClass.h"
#include "convertionTramePR.h"
#include "logLib.h"
#include "defineCan.h"
//#include <wiringPi.h>
#include <pigpio.h>

#define relayPin 27
#define retRelayPin 22

Can can;
using namespace std;

  
/* void powerOn(){
    
    wiringPiSetup();
    pinMode(relayPin, OUTPUT);
    digitalWrite(relayPin, HIGH);
}

void powerOff(){
    wiringPiSetup();
    pinMode(relayPin, OUTPUT);
    digitalWrite(relayPin, LOW);
} */

void powerOn(){
    if (gpioInitialise() <0 ) {
             return -1;
       }
    gpioSetMode(relayPin , PI_OUTPUT);
    gpioWrite(relayPin, 1);
    gpioTerminate();
}

void powerOff(){
    if (gpioInitialise() <0 ) {
             return -1;
       }
    gpioSetMode(relayPin , PI_OUTPUT);
    gpioWrite(relayPin, 0);
    gpioTerminate();
}

int move(int direction, Can &can){
    Trame_BR_dpt data;
    Trame_Moteur_t trameMoteur;
    data.fields.vitesse = 100;
    data.fields.direction = direction;
    data.fields.distance = 100;
    convertir(&data, &trameMoteur);
    return can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);
}

string nextParameter(string *input){ // Retourne le prochain paramètre et le supprime de l'input
    //https://stackoverflow.com/questions/14265581/parse-split-a-string-in-c-using-string-delimiter-standard-c
    if ((pos = input.find(delimiter)) != string::npos) {
        token = input.substr(0, pos);
        input.erase(0, pos + delimiter.length());
        return token;
    }
    else return "";
}




int main(int argc, char **argv)
{

    // Initialisation du bus CAN
    Log sysLog("systeme");
    sysLog << mendl << mendl << "Début du programme" << mendl;
    Can can;
    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
    if(err <0){
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }



    // string input = argv[argc-1];

    // if(nextParameter(&input) =="BR"){
    //     int id = atoi(nextParameter(&input));
    //     switch(id){
    //     case 1:
    //         //Tourne à droite
    //         cout << move(7,can);
    //         break;
    //     case 2:
    //         //Avance à gauche
    //         cout << move(2,can);
    //         break;
    //     case 3:
    //         //Recule à gauche
    //         cout << move(3,can);
    //         break;
    //     case 4:
    //         //Avance
    //         cout << move(1,can);
    //         break;
    //     case 5:
    //         //Recule
    //         cout << move(4,can);
    //         break;
    //     case 6:
    //         //Avance à droite
    //         cout << move(6,can);
    //         break;
    //     case 7:
    //         //Recule à droite
    //         cout << move(5,can);
    //         break; 
    //     case 8:
    //         //Tourne à gauche
    //         cout << move(8,can);
    //         break;     
    //     default:
    //         cout << "Commande " << id << " invalide";
    //         return 2; 
    //     }    
    // }
    
    // else if(nextParameter(&input) =="Relay"){
    //     string id = nextParameter(&input);
    //     if(id = "ON") powerOn();
    //     else if(id = "OFF") powerOff();
    //     else cout << "Commande " << id << " invalide";

    // }
    // else if(nextParameter(&input) =="Test"){
    //     id = nextParameter(&input);
    //     switch(id){
    //     case 1:
    //         cout << "La connectivité est correcte";
    //         break;
    //     case 2:
    //         cout << "Le robot avance";
    //         break;
    //     case 3:
    //         cout << "25,6N 43,2E";
    //         break;
    //     default:
    //         cout << "Commande " << id << " invalide";
    //         return 2;
    //     }
        
    // }
    // else cout << "Erreur de syntaxe" << endl;


	int id = atoi(argv[argc-1]);
    switch(id){
        case 1:
            cout << "La connectivité est correcte";
            break;
        case 2:
            cout << "Le robot avance";
            break;
        case 3:
            cout << "25,6N 43,2E";
            break;
        case 4:
            //cout << "Tourne à droite";
            cout << move(7,can);
            break;
        case 5:
            //cout << "Avance à gauche";
            cout << move(2,can);
            break;
        case 6:
            //cout << "Recule à gauche";
            cout << move(3,can);
            break;
        case 7:
            //cout << "Avance ";
            cout << move(1,can);
            break;
        case 8:
            //cout << "Recule";
            cout << move(4,can);
            break;
        case 9:
            //cout << "Avance à droite";
            cout << move(6,can);
            break;
        case 10:
            //cout << "Recule à droite";
            cout << move(5,can);
            break; 
        case 11:
            //cout << "Tourne à gauche";
            cout << move(8,can);
            break;          
            case 12:
                powerOn();
                cout << "Robot allumé";
                break; 
            case 13:
                cout << "Robot éteint";
                powerOff();
                break;  
        default:
            cout << "Commande " << id << " invalide";
            return 2;
    return 0;
}

    


