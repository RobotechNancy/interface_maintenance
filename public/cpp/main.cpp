#include <iostream>

#include "logLib.h"
#include "defineCan.h"
#include "canClass.h"
#include "convertionTramePR.h"

Can g_can;

using namespace std;

int main(int argc, char** argv)
{
    string id = argv[argc - 1];

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

    switch(id){
        case "1":
            cout << "La connectivité est correcte";
            break;
        case "2":
            cout << "Le robot avance";
            break;
        case "3":
            cout << "25,6N 43,2E";
            break;
        case "4":
            //cout << "Tourne à droite7";
            cout << move(7);
            break;
        case "5":
            //cout << "Avance à gauche6";
            cout << move(6);
            break;
        case "6":
            //cout << "Recule à gauche5";
            cout << move(5);
            break;
        case "7":
            //cout << "Avance 1";
            cout << move(1);
            break;
        case "8":
            //cout << "Recule4";
            cout << move(4);
            break;
        case "9":
            //cout << "Avance à droite 2";
            cout << move(2);
            break;
        case "10":
            //cout << "Recule à droite3";
            cout << move(3);
            break; 
        case "11":
            //cout << "Tourne à gauche8";
            cout << move(8);
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
