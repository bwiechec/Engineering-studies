import java.util.Scanner;

public class Usuwanie extends Opcje{
	public void dzialanieNaWpisie(DaneOsobowe osobowe, Adres adres) {
		Wyswietlanie wyswietlanie = new Wyswietlanie();
		System.out.println("Wybierz ktora osobe z listy chcesz usunac: ");
		System.out.println("==============================");
		wyswietlanie.dzialanieNaWpisie(osobowe, adres);
		System.out.println("==============================");

		Scanner scanner = new Scanner(System.in);
		String wybor = scanner.nextLine();
		
		int wyb = Integer.parseInt(wybor);	
		wyb--;
		osobowe.usun(wyb);
		adres.usun(wyb);

		//scanner.close();
	}
}