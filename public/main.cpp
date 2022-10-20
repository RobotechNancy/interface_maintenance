#include <iostream>
using namespace std;

int main(int argc, char** argv)
{
    string id = argv[argc - 1];

    if(id == "1")
        cout << "La connectivité est correcte";
    else if(id == "2")
        cout << "Le robot avance";
    else if(id == "3")
        cout << "25,6N 43,2E";
    else
        cout << "Commande invalide";

    return 0;
}
