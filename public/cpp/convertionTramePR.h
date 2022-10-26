#pragma once


typedef union{
    struct {
        uint16_t vitesse : 16;
        uint16_t distance : 16;
        uint8_t direction : 8;
    } fields;
    uint64_t unified;
    uint8_t raw_data[8];
} Trame_BR_dpt;

typedef union {
    struct {
        uint32_t nb_steps : 32;
        uint8_t div0 : 8;
        uint8_t div1 : 8;
        uint8_t div2 : 8;
        bool dir0 : 1;
        bool dir1 : 1;
        bool dir2 : 1;
    } fields;
    uint64_t unified;
    uint8_t raw_data[8];
} Trame_Moteur_t;

typedef union {
   uint8_t[2] raw;
   uint16_t unified;
} Angle_Lidar_t;

Trame_Moteur_t* convertir(Trame_BR_dpt* trameDpt, Trame_Moteur_t* trameMoteur);
float calcul_arc(float angle);
