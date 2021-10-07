
public class Wyswietlanie extends Opcje{
	public void dzialanieNaWpisie(DaneOsobowe osobowe, Adres adres) {
		for(int i = 0;i<osobowe.size();i++) {
			System.out.println((i+1) + ". " + osobowe.wypiszImie(i));
			System.out.println("   " + osobowe.wypiszNazwisko(i));
			System.out.println("   " + osobowe.wypiszTelefon(i));
			System.out.println("   " + adres.wypiszUlica(i));
			System.out.println("   " + adres.wypiszNrDomu(i));
			System.out.println("   " + adres.wypiszNrMieszkania(i));
			System.out.println("   " + adres.wypiszKodPocztowy(i));
			System.out.println("   " + adres.wypiszUrzadPocztowy(i));
		}
	}
}
