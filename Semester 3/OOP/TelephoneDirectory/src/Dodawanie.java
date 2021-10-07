import java.util.Scanner;

public class Dodawanie extends Opcje{
	public void dzialanieNaWpisie(DaneOsobowe osobowe, Adres adres) {
		Scanner scanner = new Scanner(System.in);
		System.out.println("Podaj imie dodawanej osoby");
		String imie = scanner.nextLine();
		osobowe.dodajImie(imie);
		System.out.println("Podaj nazwisko dodawanej osoby");
		String nazwisko = scanner.nextLine();
		osobowe.dodajNazwisko(nazwisko);
		System.out.println("Podaj telefon dodawanej osoby");
		String telefon = scanner.nextLine();
		osobowe.dodajTelefon(telefon);
		System.out.println("Podaj ulice dodawanej osoby");
		String ulica = scanner.nextLine();
		adres.dodajUlica(ulica);
		System.out.println("Podaj numer domu dodawanej osoby");
		String nrDomu = scanner.nextLine();
		adres.dodajNrDomu(nrDomu);
		System.out.println("Podaj numer mieszkania dodawanej osoby (- gdy mieszka w domu nie bloku)");
		String nrMieszkania = scanner.nextLine();
		adres.dodajNrMieszkania(nrMieszkania);
		System.out.println("Podaj kod pocztowy dodawanej osoby");
		String kodPocztowy = scanner.nextLine();
		adres.dodajKod(kodPocztowy);
		System.out.println("Podaj urzad pocztowy dodawanej osoby");
		String urzadPocztowy = scanner.nextLine();
		adres.dodajUrzad(urzadPocztowy);
		//scanner.close();
	}
}
