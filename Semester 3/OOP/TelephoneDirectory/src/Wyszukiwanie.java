import java.util.ArrayList;
import java.util.Scanner;

public class Wyszukiwanie extends Opcje{
	public void dzialanieNaWpisie(DaneOsobowe osobowe, Adres adres) {
		System.out.println("Podaj nazwisko do wyszukania");
		Scanner scanner = new Scanner(System.in);
		String nazwisko = "";
		nazwisko = scanner.nextLine();
		//scanner.close();
		ArrayList<String> numery = new ArrayList<String>();
		for(int i = 0;i<osobowe.size();i++) {
			if(osobowe.wypiszNazwisko(i).equals(nazwisko)) {
				//System.out.println(osobowe.wypiszNazwisko(i));
				//System.out.println(nazwisko);
				numery.add(Integer.toString(i));
			}
		}
		if(numery.size()==0) System.out.println("W bazie wpisow nie ma osoby o takim nazwisku");
		for(int i = 0;i<numery.size();i++) {
			System.out.println((i+1) + ". " + osobowe.wypiszImie(Integer.parseInt(numery.get(i))));
			System.out.println("   " + osobowe.wypiszNazwisko(Integer.parseInt(numery.get(i))));
			System.out.println("   " + osobowe.wypiszTelefon(Integer.parseInt(numery.get(i))));
			System.out.println("   " + adres.wypiszUlica(Integer.parseInt(numery.get(i))));
			System.out.println("   " + adres.wypiszNrDomu(Integer.parseInt(numery.get(i))));
			System.out.println("   " + adres.wypiszNrMieszkania(Integer.parseInt(numery.get(i))));
			System.out.println("   " + adres.wypiszKodPocztowy(Integer.parseInt(numery.get(i))));
			System.out.println("   " + adres.wypiszUrzadPocztowy(Integer.parseInt(numery.get(i))));
		}
		//scanner.close();
	}
}