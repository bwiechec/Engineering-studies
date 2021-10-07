import java.util.Scanner;

public class Modyfikowanie extends Opcje{
	public void dzialanieNaWpisie(DaneOsobowe osobowe, Adres adres) {
		Scanner scanner = new Scanner(System.in);
		Wyswietlanie wyswietlanie = new Wyswietlanie();
		System.out.println("Wybierz ktora osobe z listy chcesz modyfikowac: ");
		System.out.println("==============================");
		wyswietlanie.dzialanieNaWpisie(osobowe, adres);
		System.out.println("==============================");
		String wybor = scanner.nextLine();
		int wyb = Integer.parseInt(wybor);	
		wyb--;
		System.out.println("Podaj nowe imie");
		String imie = scanner.nextLine();
		osobowe.dodajImie(imie);
		System.out.println("Podaj nowe nazwisko");
		String nazwisko = scanner.nextLine();
		osobowe.dodajNazwisko(nazwisko);
		System.out.println("Podaj nowy telefon");
		String telefon = scanner.nextLine();
		osobowe.dodajTelefon(telefon);
		System.out.println("Podaj nowa ulice");
		String ulica = scanner.nextLine();
		adres.dodajUlica(ulica);
		System.out.println("Podaj nowy numer domu");
		String nrDomu = scanner.nextLine();
		adres.dodajNrDomu(nrDomu);
		System.out.println("Podaj nowy numer mieszkania (- gdy mieszka w domu nie bloku)");
		String nrMieszkania = scanner.nextLine();
		adres.dodajNrMieszkania(nrMieszkania);
		System.out.println("Podaj nowy kod pocztowy");
		String kodPocztowy = scanner.nextLine();
		adres.dodajKod(kodPocztowy);
		System.out.println("Podaj nowy urzad pocztowy");
		String urzadPocztowy = scanner.nextLine();
		adres.dodajUrzad(urzadPocztowy);
		osobowe.mod(wyb,imie,nazwisko,telefon);
		adres.mod(wyb,ulica,nrDomu,nrMieszkania,kodPocztowy,urzadPocztowy);
		//scanner.close();
	}
}