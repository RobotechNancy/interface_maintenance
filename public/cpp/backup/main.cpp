#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <thread>
#include <string.h>
#include <ctime>
#include <sstream>
#include <fstream>
#include <iostream>
#include <math.h>
#include "defineDeplacementPR.h"

#include "logLib.h"
#include "defineCan.h"
#include "canClass.h"
#include "convertionTramePR.h"


using namespace std;



int main(int argc, char** argv)
{
    int id = atoi(argv[argc - 1]);
	Can can;
    /*
    if(id == "1"){
        cout << "La connectivité est correcte";
    }else if(id == "2"){
        cout << "Le robot avance";
    }else if(id == "3"){
        cout << "25,6N 43,2E";
    }else{
        cout << "Commande " << id << " invalide";
        return 2;
    }

    */

    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
	uint8_t data[8] = {0x01,0x02,0xFF,0x34,0x45};
	err = can.send(CAN_ADDR_BASE_ROULANTE, DEPLACEMENT_COURROIE, data, 5, true, 5, 1); // envoie data à la base roulante 

    if(err <0){
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }

 

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
            //cout << "Tourne à droite7";
            Trame_Moteur_t sto = move(7);
            cout << can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, sto.raw_data, 8, false, 1,0);
            break;
        case 5:
            //cout << "Avance à gauche6";
            //cout << move(6,can);
            break;
        case 6:
            //cout << "Recule à gauche5";
            //cout << move(5,can);
            break;
        case 7:
            //cout << "Avance 1";
            //cout << move(1,can);
            break;
        case 8:
            //cout << "Recule4";
            //cout << move(4,can);
            break;
        case 9:
            //cout << "Avance à droite 2";
            //cout << move(2,can);
            break;
        case 10:
            //cout << "Recule à droite3";
            //cout << move(3,can);
            break;
        case 11:
            //cout << "Tourne à gauche8";
            //cout << move(8,can);
            break;
        default:
            cout << "Commande " << id << " invalide";
            return 2;
    }

    return 0;
}


Trame_Moteur_t  move(int direction){
    Trame_BR_dpt data;
    Trame_Moteur_t trameMoteur;
    data.fields.vitesse = 100;
    data.fields.direction = direction;
    data.fields.distance = 360;
    convertir(&data, &trameMoteur);
    //return can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);
	return trameMoteur;
}
