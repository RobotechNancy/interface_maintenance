#include <stdio.h>
#include <stdlib.h>

#include <unistd.h>
#include <iostream>

#include <unistd.h>


#include "canClass.h"
#include "convertionTramePR.h"


#include <thread>
#include <string.h>

#include <ctime>
#include <sstream>  

#include <iostream>
#include <fstream>


#include "logLib.h"
#include "defineCan.h"

Can can;


using namespace std;

  

void wait(int miliseconde){
    usleep(miliseconde*1000);
    return;
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


int main(int argc, char **argv)
{

    Log sysLog("systeme");

    sysLog << mendl << mendl << "Début du programme" << mendl;

    Can can;
    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
    if(err <0){
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }

    

    //uint8_t data[8] = {0x01,0x02,0xFF,0x34,0x45};


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
        default:
            cout << "Commande " << id << " invalide";
            return 2;
    }

    return 0;
}

string move(int direction){
    Trame_BR_dpt data;
    Trame_Moteur_t trameMoteur;
    data.fields.vitesse = 100;
    data.fields.direction = direction;
    data.fields.distance = 360;
    convertir(&data, &trameMoteur);
    return can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);
}

