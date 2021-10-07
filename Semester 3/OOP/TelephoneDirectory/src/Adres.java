import java.util.ArrayList;

public class Adres {
	private ArrayList<String> ulica = new ArrayList<String>();
	private ArrayList<String> nrDomu = new ArrayList<String>();
	private ArrayList<String> nrMieszkania = new ArrayList<String>();
	private ArrayList<String> kodPocztowy = new ArrayList<String>();
	private ArrayList<String> urzadPocztowy = new ArrayList<String>();
	
	public void dodajUlica(String u) {
		ulica.add(u);
	}
	public void dodajNrDomu(String nr) {
		nrDomu.add(nr);
	}
	public void dodajNrMieszkania(String nr) {
		nrMieszkania.add(nr);
	}
	public void dodajKod(String k) {
		kodPocztowy.add(k);
	}
	public void dodajUrzad(String u) {
		urzadPocztowy.add(u);
	}
	
	public String wypiszUlica(int a) {
		return ulica.get(a);
	}
	public String wypiszNrDomu(int a) {
		return nrDomu.get(a);
	}
	public String wypiszNrMieszkania(int a) {
		return nrMieszkania.get(a);
	}
	public String wypiszKodPocztowy(int a) {
		return kodPocztowy.get(a);
	}
	public String wypiszUrzadPocztowy(int a) {
		return urzadPocztowy.get(a);
	}
	public void usun(int x) {
		ulica.remove(x);
		nrDomu.remove(x);
		nrMieszkania.remove(x);
		kodPocztowy.remove(x);
		urzadPocztowy.remove(x);
	}
	public void mod(int wyb,String u,String nrD,String nrM,String kod,String urzad) {
		ulica.set(wyb, u);
		nrDomu.set(wyb, nrD);
		nrMieszkania.set(wyb, nrM);
		kodPocztowy.set(wyb, kod);
		urzadPocztowy.set(wyb, urzad);
	}
}
