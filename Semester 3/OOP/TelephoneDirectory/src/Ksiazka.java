import java.io.File;
//import java.io.BufferedReader; 
//import java.io.IOException; 
//import java.io.InputStreamReader; 
import java.io.FileNotFoundException;  
import java.util.Scanner; 
//import java.util.ArrayList;

public class Ksiazka {

	public static void main(String[] args){
		DaneOsobowe osobowe = new DaneOsobowe();
		Adres adres = new Adres();
		//int iloscRekordow = 0;
		try {
			File plik = new File("ksiazka.txt");
			Scanner myReader = new Scanner(plik);
		    while (myReader.hasNextLine()) {
		    	//iloscRekordow++;
		    	osobowe.dodajImie(myReader.nextLine());
		    	osobowe.dodajNazwisko(myReader.nextLine());
		    	osobowe.dodajTelefon(myReader.nextLine());
		    	adres.dodajUlica(myReader.nextLine());
		    	adres.dodajNrDomu(myReader.nextLine());
		    	adres.dodajNrMieszkania(myReader.nextLine());
		    	adres.dodajKod(myReader.nextLine());
		    	adres.dodajUrzad(myReader.nextLine());
		    }
		    myReader.close();
		}catch (FileNotFoundException e){
			System.out.println("Brak pliku.");
		    //e.printStackTrace();
		}
		String wybor = "-1";
		Scanner scanner = new Scanner(System.in);
		while(wybor!="7") {
			System.out.println("Wybierz opcje:");
			System.out.println("1. Dodawanie wpisu");
			System.out.println("2. Usuwanie wpisu");
			System.out.println("3. Modyfikowanie wpisu");
			System.out.println("4. Wyswietlanie listy wpisów");
			System.out.println("5. Wyszukiwanie po nazwisku");
			System.out.println("6. Koniec");
			//BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));
			wybor = scanner.nextLine();
			//wybor = reader.readLine();
			//scanner.close();
			//reader.close();
			switch(wybor) {
			case "1": 
				Dodawanie dodaj = new Dodawanie();
				dodaj.dzialanieNaWpisie(osobowe, adres);
				break;
			case "2": 
				Usuwanie usun = new Usuwanie();
				usun.dzialanieNaWpisie(osobowe, adres);
				break;
			case "3": 
				Modyfikowanie modyfikuj = new Modyfikowanie();
				modyfikuj.dzialanieNaWpisie(osobowe, adres);
				break;
			case "4": 
				Wyswietlanie wyswietl = new Wyswietlanie();
				wyswietl.dzialanieNaWpisie(osobowe, adres);
				break;
			case "5": 
				Wyszukiwanie wyszukaj = new Wyszukiwanie();
				wyszukaj.dzialanieNaWpisie(osobowe, adres);
				break;
			case "6": 
				NadpiszPlik nadpisz = new NadpiszPlik();
				nadpisz.dzialaj(osobowe, adres);
				wybor = "7";
				break;
			default:
				System.out.println("Bledny numer");
			}
			//Thread.sleep(2000);
		}
		scanner.close();
	}

}
