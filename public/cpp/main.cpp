#include <stdio.h>
#include <string.h>
#include <iostream>
#include "canClass.h"
#include "convertionTramePR.h"
#include "logLib.h"
#include "defineCan.h"

Can can;
using namespace std;



int powerOn(){ // Peut être améliorer en utilisant popen
    system("gpio mode 3 output");
    return system("gpio write 3 1");
}

int powerOff(){
    system("gpio mode 3 output");
    return system("gpio write 3 0");
}

bool readRelayPin(){ //Lit l'état du relais avec la commande popen("gpio read 2", "r")
    FILE *fp;
    char path[1035];
    fp = popen("gpio read 2", "r");
    if (fp == NULL) {
        cout<<"Failed reading relay pin with popen\n" << endl;
    }
    while (fgets(path, sizeof(path), fp) !=NULL)
    pclose(fp);

    if(path[0] == '1') return true;
    else return false;    
}

int move(int direction, Can &can){

    
    if(readRelayPin()){
        
        Trame_BR_dpt data;
        Trame_Moteur_t trameMoteur;
        data.fields.vitesse = 100;
        data.fields.direction = direction;
        data.fields.distance = 100;
        convertir(&data, &trameMoteur);
        return can.send(CAN_ADDR_BASE_ROULANTE, AVANCE, trameMoteur.raw_data, 8, false, 1,0);
    }
    else return -1;

}

string nextParameter(string &s){ // Retourne le prochain paramètre et le supprime de l'input
    //https://stackoverflow.com/questions/14265581/parse-split-a-string-in-c-using-string-delimiter-standard-c
    string delimiter = "|";
    size_t pos = 0;
    string token;
    while ((pos = s.find(delimiter)) != std::string::npos) {
        token = s.substr(0, pos);
        std::cout << token << std::endl;
        s.erase(0, pos + delimiter.length());
    }
    return token;
}
/*     int pos = input.find(delimiter);
    if (pos != string::npos) {
        token = input.substr(0, pos);
        input.erase(0, pos + delimiter.length());
        return token;
    }
    else return "";
}  */



int main(int argc, char **argv)
{

    Log sysLog("systeme");
    Can can;
    int err = can.init(CAN_ADDR_RASPBERRY_E);//CAN_ADDR_RASPBERRY
    if(err <0){
        can.logC << "erreur dans l'init du bus can. err n°" << dec << err << "\t\t c.f. #define" << mendl;
        return err;
    }

/*
    string input = argv[argc-1];
    if(nextParameter(input.c_str()) =="BR"){
        int id = atoi(nextParameter(input.c_str()));
        switch(id){
        case 1:
            //Tourne à droite
            cout << move(7,can);
            break;
        case 2:
            //Avance à gauche
            cout << move(2,can);
            break;
        case 3:
            //Recule à gauche
            cout << move(3,can);
            break;
        case 4:
            //Avance
            cout << move(1,can);
            break;
        case 5:
            //Recule
            cout << move(4,can);
            break;
        case 6:
            //Avance à droite
            cout << move(6,can);
            break;
        case 7:
            //Recule à droite
            cout << move(5,can);
            break; 
        case 8:
            //Tourne à gauche
            cout << move(8,can);
            break;     
        default:
            cout << "Commande " << id << " invalide";
            return 2; 
        }    
    }
    
     else if(nextParameter(input) =="Relay"){
        string id = nextParameter(input);
        if(id == "ON") powerOn();
        else if(id == "OFF") powerOff();
        else cout << "Commande " << id << " invalide";
    }
    else if(nextParameter(input) =="Test"){
        id = nextParameter(input);
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
        default:
            cout << "Commande " << id << " invalide";
            return 2;
        }
        
    } 
    else cout << "Erreur de syntaxe" << endl;
*/

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
                cout << powerOn();
                break; 
        case 13:
                cout << powerOff();                
                break;  
        default:
            cout << "Commande " << id << " invalide";
            return 2;
    return 0;
    } 
}

    
