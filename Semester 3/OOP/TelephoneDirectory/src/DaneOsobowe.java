import java.util.ArrayList;

public class DaneOsobowe {
	private ArrayList<String> imie = new ArrayList<String>();
	private ArrayList<String> nazwisko = new ArrayList<String>();
	private ArrayList<String> telefon = new ArrayList<String>();
	
	public void dodajImie(String i) {
		imie.add(i);
	}
	public void dodajNazwisko(String n) {
		nazwisko.add(n);
	}
	public void dodajTelefon(String t) {
		telefon.add(t);
	}
	
	public String wypiszImie(int a) {
		return imie.get(a);
	}
	public String wypiszNazwisko(int a) {
		return nazwisko.get(a);
	}
	public String wypiszTelefon(int a) {
		return telefon.get(a);
	}
	public int size() {
		return imie.size();
	}
	public void usun(int x) {
		imie.remove(x);
		nazwisko.remove(x);
		telefon.remove(x);
	}
	public void mod(int wyb,String i,String n,String t) {
		imie.set(wyb,i);
		nazwisko.set(wyb,n);
		telefon.set(wyb,t);
	}
}
