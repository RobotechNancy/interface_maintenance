#include <iostream>
#include <string>
//#include <cmath>
#define _USE_MATH_DEFINES // for C
#include <math.h>
#include "convertionTramePR.h"
#include "defineDeplacementPR.h"

using namespace std ;

//40% de pas en + pour une roue de travers, *sqrt(2)
//div = vitesse de base /vitesse souhaitée
//div * sqrt(2) parce que roue decalée


Trame_Moteur_t* convertir(Trame_BR_dpt* trameDpt, Trame_Moteur_t* trameMoteur){
    const int DIRECTION = trameDpt->fields.direction;

    float distParTours = DIAMETRE * M_PI; //mm
    float taillePas = (float)(360)/((float)(DIV_DRIVER)*200); //°
    float distanceSouhait;
    if ((DIRECTION==7) || (DIRECTION==8)){
        distanceSouhait = calcul_arc(trameDpt->fields.distance); //mm
    }
    else{
        distanceSouhait = trameDpt->fields.distance; //mm
    }
    float vitesseSouhait = trameDpt->fields.vitesse;//distParTours * 3; //mm/sec
    
    float nbTours = (float)distanceSouhait/(float)distParTours;
    float nbPas = nbTours*360/taillePas;
    
    bool dir[3];
    float ratio[3];
    switch(DIRECTION){
    case 1:; //avance angle 0
        dir[0] = 0;
        dir[1] = 1;
        dir[2] = 0;
        ratio[0] = 0;
        ratio[1] = sin(60*M_PI/180);
        ratio[2] = sin(2*60*M_PI/180);
        break;
    case 2:; //avance angle 60
        dir[0] = 0;
        dir[1] = 1;
        dir[2] = 0;
        ratio[0] = sin(60*M_PI/180);
        ratio[1] = sin(2*60*M_PI/180);
        ratio[2] = 0;
        break;
    case 3:; //avance angle 120
        dir[0] = 0;
        dir[1] = 0;
        dir[2] = 1;
        ratio[0] = sin(2*60*M_PI/180);
        ratio[1] = 0;
        ratio[2] = sin(60*M_PI/180);
        break;
    case 4:; //avance angle 180
        dir[0] = 0;
        dir[1] = 0;
        dir[2] = 1;
        ratio[0] = 0;
        ratio[1] = sin(60*M_PI/180);
        ratio[2] = sin(2*60*M_PI/180);
        break;
    case 5:; //avance angle 240
        dir[0] = 1;
        dir[1] = 0;
        dir[2] = 0;
        ratio[0] = sin(60*M_PI/180);
        ratio[1] = sin(2*60*M_PI/180);
        ratio[2] = 0;
        break;
    case 6:; //avance angle 300
        dir[0] = 1;
        dir[1] = 0;
        dir[2] = 0;
        ratio[0] = sin(2*60*M_PI/180);
        ratio[1] = 0;
        ratio[2] = sin(60*M_PI/180);
        break;
    case 7:; //rotation trigo
        dir[0] = 1;
        dir[1] = 1;
        dir[2] = 1;
        ratio[0] = 1;
        ratio[1] = 1;
        ratio[2] = 1;
        break;
    case 8:; //rotation anti-trigo
        dir[0] = 0;
        dir[1] = 0;
        dir[2] = 0;
        ratio[0] = 1;
        ratio[1] = 1;
        ratio[2] = 1;
        break;
    default:;
        break;
    }
    
    float freqPas = round(vitesseSouhait / distParTours * (float)(360) / taillePas); //peut-etre mettre dans un table pour avoir plusieurs taillePas
    float freq[3];
    for (int i=0; i<3; i++){
        if(ratio[i]!=0){
            freq[i] = freqPas/ratio[i];
        }
        else{
            freq[i] = 0;
        }
    }
    
    float div[3];
    for (int i=0; i<3; i++){
        if(freq[i]!=0){
            div[i] = FREQ_BASE/freq[i];
        }
        else{
            div[i] = 0;
        }
    }
    
    float nbPasRoue[3];
    for (int i=0; i<3; i++){
        if(ratio[i]!=0){
            nbPasRoue[i] = (nbPas * div[i]/ratio[i]);
        }
        else{
            nbPasRoue[i] = 0;
        }
    }
    
    float nbPasGrossier = round(distanceSouhait*(float)(FREQ_BASE)/vitesseSouhait);

    if ((DIRECTION==7) || (DIRECTION==8)){
        if(nbPasRoue[0]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[0])) + (0.1875*(round(nbPasRoue[0]))));
        }
        else if(nbPasRoue[1]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[1])) + (0.1875*(round(nbPasRoue[1]))));
        }
        else if(nbPasRoue[2]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[2])) + (0.1875*(round(nbPasRoue[2]))));
        }
        else{
            trameMoteur->fields.nb_steps = 0;
        } 
    }
    else{
        if(nbPasRoue[0]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[0])) - (0.2*(round(nbPasRoue[0]))));
        }
        else if(nbPasRoue[1]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[1])) - (0.2*(round(nbPasRoue[1]))));
        }
        else if(nbPasRoue[2]!=0){
            trameMoteur->fields.nb_steps = (uint32_t)((round(nbPasRoue[2])) - (0.2*(round(nbPasRoue[2]))));
        }
        else{
            trameMoteur->fields.nb_steps = 0;
        }
    }  
    trameMoteur->fields.div0 = (uint32_t)(round(div[0]));
    trameMoteur->fields.div1 = (uint32_t)(round(div[1]));
    trameMoteur->fields.div2 = (uint32_t)(round(div[2]));
    trameMoteur->fields.dir0 = (uint32_t)(round(dir[0]));
    trameMoteur->fields.dir1 = (uint32_t)(round(dir[1]));
    trameMoteur->fields.dir2 = (uint32_t)(round(dir[2]));


/*
    cout << "vitesse = " << vitesseSouhait << endl;
    cout << "dist = " << distanceSouhait << endl;
    cout << "dir = " << DIRECTION << endl;
    cout << "distParTours = " << distParTours << endl;
    cout << "taillePas = " << taillePas << endl;
    cout << "vitesseSouhait = " << vitesseSouhait << endl;
    cout << "distanceSouhait = " << distanceSouhait << endl;
    cout << "freqPas = " << freqPas << endl;
    cout << "nbPas = " << nbPas << endl;

    cout << "------------------------------------------------------------------------------------------------" << endl;
    cout << "dir = [" << dir[0] << ", " << dir[1] << ", " << dir[2] << "]" <<endl;
    cout << "ratio = [" << ratio[0] << ", " << ratio[1] << ", " << ratio[2] << "]" <<endl;
    cout << "freq = [" << freq[0] << ", " << freq[1] << ", " << freq[2] << "]" <<endl;
    cout << "div = [" << (uint16_t)div[0] << ", " << (uint16_t)div[1] << ", " << (uint16_t)div[2] << "]" <<endl;
    cout << "nbPasRoue = [" << nbPasRoue[0] << ", " << nbPasRoue[1] << ", " << nbPasRoue[2] << "]" <<endl;
    cout << "nbPasGrossier = " << nbPasGrossier << endl;

    cout << "------------------------------------------------------------------------------------------------" << endl;
    cout << "dist cpp = " << round(nbPasRoue[1] * ratio[1]/div[1] * taillePas/360 * distParTours) << endl;
    cout << "dist voulue = " << nbTours * distParTours << endl;
    cout << "nbtours voulus = " << distanceSouhait / distParTours << endl;

    cout << "------------------------------------------------------------------------------------------------" << endl;
*/


    return trameMoteur;

}

float calcul_arc(float angle){
    float arc = (2 * M_PI * (DIAMETRE_BASE) * angle) / 360;
    return arc;
}
