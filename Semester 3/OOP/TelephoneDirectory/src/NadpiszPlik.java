import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

public class NadpiszPlik {
	public void usun() {
		File myObj = new File("ksiazka.txt"); 
	    myObj.delete();
	}
	public void stworz() {
		try {
			File myObj = new File("ksiazka.txt");
		    myObj.createNewFile();
		}catch (IOException e) {
			System.out.println("Blad.");
		}
	}
	public void zapisz(DaneOsobowe osobowe, Adres adres) {
		try {
			FileWriter myWriter = new FileWriter("ksiazka.txt");
			for(int i = 0;i<osobowe.size();i++) {
				myWriter.write(osobowe.wypiszImie(i));
				myWriter.write(osobowe.wypiszNazwisko(i));
				myWriter.write(osobowe.wypiszTelefon(i));
				myWriter.write(adres.wypiszUlica(i));
				myWriter.write(adres.wypiszNrDomu(i));
				myWriter.write(adres.wypiszNrMieszkania(i));
				myWriter.write(adres.wypiszKodPocztowy(i));
				myWriter.write(adres.wypiszUrzadPocztowy(i));
			}
		    myWriter.close();
		}catch (IOException e) {
			System.out.println("Blad.");
		}
	}
	
	public void dzialaj(DaneOsobowe osobowe, Adres adres){
		    usun();
		    stworz();
		    zapisz(osobowe, adres);
	}
}
