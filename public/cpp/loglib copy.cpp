#include "loglib.h"
#include <iostream>
#include <sstream>
#include <string>

using namespace std;

char* stringToChar(std::string chaine){
    char* message = strcpy(new char[chaine.size() + 1], chaine.c_str());
    return message;
}


Log::Log(string nom){
    name = nom;
    stringstream ss;
}


Log& operator<<(Log &log, Mendl const& data){
    time_t now = time(0);
    tm *ltm = localtime(&now);
    cout << endl;
    stringstream cmd;
    cmd << "echo \"" << "["<<ltm->tm_hour << ":" << ltm->tm_min << ":" << ltm->tm_sec << " - "<< log.name <<"] " <<log.ss.str()<<"\" >> log.log";
    log.ss.str("");
    system(stringToChar(cmd.str()));

    return log; 

}

