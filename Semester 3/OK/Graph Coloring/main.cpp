#include <iostream>
#include <fstream>
#include <list>

using namespace std;
//-----------------Klasa graf-------------
class Graph{
    int V;
    list<int> *sasiedzi;
public:

    Graph(int V)   { this->V = V; sasiedzi = new list<int>[V]; }
    ~Graph()       { delete [] sasiedzi; }


    void dodajKrawedz(int v, int w);


    void GCzachlanne();
};
//---------------KONIEC KLASY GRAF----------------


//--------------DODAWANIE KRAWEDZI----------------
void Graph::dodajKrawedz(int v, int w){
    sasiedzi[v].push_back(w);
    sasiedzi[w].push_back(v);
}
//------------------KONIEC DODAWANIA-----------


//-----------------------KOLOROWANIE ZACHLANNE----------------------------
void Graph::GCzachlanne(){
    int wynik[V];
    bool wolne[V];

    wynik[0]  = 0; //przypisanie do pierwszego koloru '0'
    wolne[0] = false;
    for (int i = 1; i < V; i++){
        wynik[i] = -1; //-1 oznacza brak przypisanego koloru
        wolne[i] = false; //czy kolor uzyty
    }

    for (int i = 1; i < V; i++){ //przydzielanie kolorów dla wierzcho³ków od 2 w gore

        list<int>::iterator j;

        for (j = sasiedzi[i].begin(); j != sasiedzi[i].end(); ++j) //ustawiamy kolor ktory jest numerem sasiednich wierzcholkow na zajety
            if (wynik[*j] != -1)
                wolne[wynik[*j]] = true;

        int x;
        for (x = 0; x < V; x++) //szukamy pierwszego wolnego koloru
            if (wolne[x] == false)
                break;

        wynik[i] = x;

        for (j = sasiedzi[i].begin();j != sasiedzi[i].end(); ++j)//cofamy ustawienie nie zabranych kolorow
            if (wynik[*j] != -1)
                wolne[wynik[*j]] = false;
    }
    for (int i = 0; i < V; i++) cout << "Wierzcholek " << i+1 << " - Pokolorowany " << wynik[i] << endl;
}
//-------------------------KONIEC KOLOROWANIA-----------------------------


int main()
{
    //---------------------ODCZYT Z INSTANCJI---------------------
    fstream instancjaSpr;
    instancjaSpr.open("inst.txt",ios::in);
    if(instancjaSpr.good()){
        int iloscWierz;
        instancjaSpr>>iloscWierz;
        Graph graf(iloscWierz);
        //cout<<iloscWierz<<endl;
        int** macierzSas = new int*[iloscWierz];
        for(int i = 0;i<iloscWierz;i++) macierzSas[i] = new int[iloscWierz];
        for(int i = 0;i<iloscWierz;i++){
            for(int j = 0;j<iloscWierz;j++)
                macierzSas[i][j]=0;
        }
        int wIn;
        int wOut;
        while(!instancjaSpr.eof()){
            instancjaSpr>>wIn;
            //cout<<wIn<<" ";
            instancjaSpr>>wOut;
            //cout<<wOut<<endl;
            macierzSas[wIn-1][wOut-1]=1;
            graf.dodajKrawedz(wIn-1,wOut-1);
        }
        cout<<iloscWierz<<endl;
        for(int i = 0;i<iloscWierz;i++){
            for(int j = 0;j<iloscWierz;j++)
                cout<<macierzSas[i][j]<<" ";
            cout<<endl;
        }
        //-------------------------KONIEC ODCZYTU-------------------------
        instancjaSpr.close();
        graf.GCzachlanne();
    }else cout<<"Blad";
    return 0;
}
