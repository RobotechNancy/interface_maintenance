/*!
 *  \file define.h
 *  \brief Fichier contenant l'ensemble des constantes utilisées dans la librairie XBee.
 *  \author Samuel-Charles DITTE-DESTREE (samueldittedestree@protonmail.com)
 *  \version 3.0
 *  \date 10/03/2022
 */
#ifndef DEFINE_XBEE_H
#define DEFINE_XBEE_H

// Paramètres du port série
// Configuration des modules XBee pour la compétition
#define XB_SERIAL_PORT_PRIMARY "/dev/ttyAMA0"
#define XB_BAUDRATE_PRIMARY 9600
#define XB_DATABITS_PRIMARY SERIAL_DATABITS_8
#define XB_PARITY_PRIMARY SERIAL_PARITY_EVEN
#define XB_STOPBITS_PRIMARY SERIAL_STOPBITS_1


// Configuration d'usine par défaut des modules XBee neufs
#define XB_SERIAL_PORT_DEFAULT "/dev/ttyAMA0"
#define XB_BAUDRATE_DEFAULT 9600
#define XB_DATABITS_DEFAULT SERIAL_DATABITS_8
#define XB_PARITY_DEFAULT SERIAL_PARITY_NONE
#define XB_STOPBITS_DEFAULT SERIAL_STOPBITS_1

#define XB_V_ACK 0x06
#define XB_V_NACK 0x15

// Addresses des robots
#define XB_ADR_BROADCAST 0x11
#define XB_ADR_ROBOT_01 0x12
#define XB_ADR_ROBOT_02 0x13

#define XB_LIST_ADR (int[]){XB_ADR_BROADCAST, XB_ADR_ROBOT_01, XB_ADR_ROBOT_02}

#define XB_ADR_CURRENT_ROBOT XB_ADR_ROBOT_01

// Paramètres de la trame message
#define XB_V_START 0x02
#define XB_V_END 0x03

// Codes fonctions
#define XB_FCT_TEST_ALIVE 0x07

#define XB_LIST_CODE_FCT (int[]){XB_FCT_TEST_ALIVE}

// Code erreurs généraux
#define XB_E_SUCCESS 000

// Codes erreurs des codes fonctions
#define XB_FCT_E_SUCCESS 100
#define XB_FCT_E_NOT_FOUND -101
#define XB_FCT_E_NONE_REACHABLE -102

// Codes erreurs traitement de trame
#define XB_TRAME_E_SUCCESS 200
#define XB_TRAME_E_SIZE -201
#define XB_TRAME_E_START -202
#define XB_TRAME_E_END -203
#define XB_TRAME_E_CRC -204
#define XB_TRAME_E_EXP -205
#define XB_TRAME_E_DEST -206

// Codes erreurs découpage de trame
#define XB_SUB_TRAME_E_SUCCESS 300
#define XB_SUB_TRAME_E_SIZE -301
#define XB_SUB_TRAME_E_REPARTITION -302
#define XB_SUB_TRAME_E_DECOUPAGE -303
#define XB_SUB_TRAME_E_START -304
#define XB_SUB_TRAME_E_END -305
#define XB_SUB_TRAME_E_NULL -306

// Codes d'erreurs AT
#define XB_AT_E_SUCCESS 400
#define XB_AT_E_ENTER -401
#define XB_AT_E_API -402
#define XB_AT_E_BAUDRATE -403
#define XB_AT_E_AES -404
#define XB_AT_E_AES_KEY -405
#define XB_AT_E_CHANEL -406
#define XB_AT_E_PAN_ID -407
#define XB_AT_E_COORDINATOR -408
#define XB_AT_E_PARITY -409
#define XB_AT_E_16BIT_SOURCE_ADDR -410
#define XB_AT_E_LOW_DEST_ADDR -411
#define XB_AT_E_EXIT -412
#define XB_AT_E_WRITE_CONFIG -413
#define XB_AT_E_DISCOVER_NETWORK -414

// Codes d'erreurs ouverture connexion série
#define XB_SER_E_SUCCESS 500
#define XB_SER_E_NOT_FOUND -501
#define XB_SER_E_OPEN -502
#define XB_SER_E_PARAM -503
#define XB_SER_E_UKN_BAUDRATE -504
#define XB_SER_E_CONFIG -505
#define XB_SER_E_TIMOUT -506
#define XB_SER_E_UKN_DATABITS -507
#define XB_SER_E_UKN_STOPBITS -508
#define XB_SER_E_UKN_PARITY -509

// Commandes AT
#define XB_AT_CMD_ENTER "+++"
#define XB_AT_CMD_EXIT "ATCN"
#define XB_AT_CMD_WRITE_CONFIG "ATWR"
#define XB_AT_CMD_API "ATAP"
#define XB_AT_CMD_BAUDRATE "ATBD"
#define XB_AT_CMD_AES "ATEE"
#define XB_AT_CMD_AES_KEY "ATKY"
#define XB_AT_CMD_CHANEL "ATCH"
#define XB_AT_CMD_PAN_ID "ATID"
#define XB_AT_CMD_COORDINATOR "ATCE"
#define XB_AT_CMD_PARITY "ATNB"
#define XB_AT_CMD_16BIT_SOURCE_ADDR "ATMY"
#define XB_AT_CMD_LOW_DEST_ADDR "ATDL"
#define XB_AT_CMD_DISCOVER_NETWORK "ATND"

// Valeurs AT
#define XB_AT_V_END_LINE "\r"
#define XB_AT_V_API "0\r"
#define XB_AT_V_BAUDRATE "3\r"
#define XB_AT_V_AES "1\r"
#define XB_AT_V_AES_KEY "32303032\r"
#define XB_AT_V_CHANEL "C\r"
#define XB_AT_V_PAN_ID "3332\r"
#define XB_AT_V_COORDINATOR "0\r"
#define XB_AT_V_PARITY "1\r"
#define XB_AT_V_16BIT_SOURCE_ADDR "1\r"
#define XB_AT_V_LOW_DEST_ADDR "2\r"
#define XB_AT_V_DISCOVER_NETWORK "167D2F1\r"

// Réponses AT
#define XB_AT_R_EMPTY ""
#define XB_AT_R_SUCCESS "OK\r"
#define XB_AT_R_ERROR "ERROR\r"

// Mode AT
#define XB_AT_M_GET 1
#define XB_AT_M_SET 2
#endif
