#ifndef LOGLIB_H
#define LOGLIB_H

#include <ostream>
#include <iostream>
#include <string>
#include <sstream>
#include <cstring>

struct Mendl{
};

const Mendl mendl;

char* stringToChar(std::string chaine);


class Log : public std::ostream{
    private:
        std::stringstream ss;

    public:
        std::string name;
        Log(std::string nom);
        int save(int data);
        template<typename T>
        friend Log& operator<<(Log& log, const T &classObj);
        friend Log& operator<<(Log& log, const Mendl& data);

};


template <typename T>
Log& operator<<(Log &log, T const &data)
{
    log.ss << data;
    std::cout << data;
    return log;
}

#endif
