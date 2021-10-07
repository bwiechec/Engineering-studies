import time

class Element:
    def __init__(self,weight,value):
        self.weight = int(weight)
        self.value = int(value)

    def __str__(self):
        return "(weight = {}, value = {})".format(self.weight,self.value)

def readFile(filepath):                         # <-- funkcja do odczytywania danych o elementach z pliku
    elems = list()
    file = open(filepath,'r')
    content = file.read().splitlines()
    c = content[0]; n = content[1]; content = content[2:]           # odczytujemy informacje początkowe czyli pojemność plecaka i ilość elementów
    for elem in content:
        wp = elem.split(" ")
        elems.append(Element(int(wp[1]),int(wp[0])))                # tworzymy elementy z odczytanych danych i dodajemy do listy
    return int(c),elems

def totalValue(elements):               # proste funkcje zliczające, odpowiednio całkowitą masę i całkowitą wartość elementów
    if len(elements)==0:
        return 0
    tVal = 0
    for elem in elements:
        tVal += elem.value
    return tVal

def totalWeight(elements):
    if len(elements)==0:
        return 0
    tWeight = 0
    for elem in elements:
        tWeight += elem.weight
    return tWeight

def printElems(elements):
    for elem in elements:
        print(elem)

def recursiveForce(elements,taken,c):
    if len(elements) == 1:                                          # jeśli został tylko nam jeden element, to jeśli całkowita
        if totalWeight(taken) + elements[0].weight <= c:            # masa po jego dodaniu jest <= dopuszczalnej, to bierzemy (dopisujemy
                                                                    # do listy wziętych i zwracamy ją), w innym przypadku
            return taken + [elements[0]]                            # zwracamy niezmienioną listę wziętych elementów
        else:
            return taken
    else:
        if totalWeight(taken)+elements[0].weight > c:                           # jeśli nie możemy wziąć elementu, ale są jeszcze inne dalej
                                                                                # (lista dłuższa niż jeden element) to pomijamy go i szukamy dalej
            return recursiveForce(elements[1:],taken,c)
        else:
            taken1 = recursiveForce(elements[1:],taken+[elements[0]],c)         # jeśli możemy zabrać element, to mamy dwie ścieżki: z wziętym elementem i bez
            taken2 = recursiveForce(elements[1:],taken,c)                       # sprawdzamy obie i porównujemy dla której będzie większa totalna wartość i tą zwracamy
            if totalValue(taken1) > totalValue(taken2):
                return taken1
            else:
                return taken2


def plecakRekurencyjny(filepath):                        # główna funkcja łącząca automatyzująca cały proces
    c, elements = readFile(filepath)
    taken = recursiveForce(elements,[],c)
    return taken

def blankArray(i,j):                        # generowanie pustej macierzy: tworzymy i list o długości j wypełnionych zerami
    array = list()                          # i dodajemy je do wynikowej listy
    for x in range(i):
        tmpArr = [0]*j
        array.append(tmpArr)
    return array

def printArray(array):
    for row in array:
        print(row)

def goThrough(array,i,j,taken,elements):
    '''
    Przechodzenie macierzy rekurencyjnie w poszukiwaniu zabranych elementów.
    '''
    #print(len(array),i)
    if i <= 0 or j <= 0 or array[i][j] == 0:
        return taken
    while array[i][j] == array[i-1][j]:     # idziemy do góry aż wartość w komórce powyżej będzie inna niż w aktualnej (oznacza to, że
        i -= 1                              # obiekt o indeksie i został zabrany)
    taken.append(elements[i-1])             # dołączamy element do listy zabranych
    #print("({},{}), w({}) = {}".format(i-1,j-elements[i].weight,i,elements[i-1].weight))
    taken = goThrough(array,i-1,j-elements[i-1].weight,taken,elements)      # rekurencyjnie uruchamiamy funkcję dla zmodyfikowanych indeksów tak jak było omawiane na zajęciach
    return taken

def plecakDynamiczny(filepath):
    start = time.time()
    c, elements = readFile(filepath)
    n = len(elements)
    array = blankArray(n+1,c+1)
    for i in range(1,n+1):
        for j in range(1,c+1):
            '''
            Tworzenie macierzy programowania dynamicznego: wypełnianie według wzoru podanego na zajęciach.
            '''
            if j < elements[i-1].weight:
                array[i][j] = array[i-1][j]
            else:
                if array[i-1][j] < array[i-1][j-elements[i-1].weight] + elements[i-1].value:
                    array[i][j] = array[i-1][j-elements[i-1].weight] + elements[i-1].value
                else:
                    array[i][j] = array[i-1][j]
    #printArray(array)
    taken = goThrough(array,n,c,[],elements)
    end = time.time()
    print(end-start)
    return taken

wartPlecaka = 0
taken = plecakDynamiczny("./elements")
for i in range(len(taken)):
    wartPlecaka += taken[i].value
    print(taken[i])
print("Wartosc plecaka: ",wartPlecaka)