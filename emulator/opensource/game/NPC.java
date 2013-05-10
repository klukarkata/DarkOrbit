package game;

public class NPC {
	
	private int id;
	private String nombre;
	private int gfx;
	private int pv;
	private int esc;
	private int exp;
	private int hon;
	private int cre;
	private int uri;
	private int xenomit;
	private int prometium;
	private int terbium;
	private int endurium;
	private int prometid;
	private int duranium;
	private int promerium;
	private String dmg;
	private int IA;
	
	public NPC(int id, String nombre, int gfx, int pv, int esc, int exp, int hon, int cre,
			int uri, int xenomit, int prometium, int terbium, int endurium, int prometid,
			int duranium, int promerium, String dmg, int IA)
	{
		this.id = id;
		this.nombre = nombre;
		this.gfx = gfx;
		this.pv = pv;
		this.esc = esc;
		this.exp = exp;
		this.hon = hon;
		this.cre = cre;
		this.uri = uri;
		this.xenomit = xenomit;
		this.prometium = prometium;
		this.terbium = terbium;
		this.endurium = endurium;
		this.prometid = prometid;
		this.duranium = duranium;
		this.promerium = promerium;
		this.dmg = dmg;
		this.IA = IA;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public int getGfx() {
		return gfx;
	}

	public void setGfx(int gfx) {
		this.gfx = gfx;
	}

	public int getPv() {
		return pv;
	}

	public void setPv(int pv) {
		this.pv = pv;
	}

	public int getEsc() {
		return esc;
	}

	public void setEsc(int esc) {
		this.esc = esc;
	}

	public int getExp() {
		return exp;
	}

	public void setExp(int exp) {
		this.exp = exp;
	}

	public int getHon() {
		return hon;
	}

	public void setHon(int hon) {
		this.hon = hon;
	}

	public int getCre() {
		return cre;
	}

	public void setCre(int cre) {
		this.cre = cre;
	}

	public int getUri() {
		return uri;
	}

	public void setUri(int uri) {
		this.uri = uri;
	}

	public int getXenomit() {
		return xenomit;
	}

	public void setXenomit(int xenomit) {
		this.xenomit = xenomit;
	}

	public int getPrometium() {
		return prometium;
	}

	public void setPrometium(int prometium) {
		this.prometium = prometium;
	}

	public int getTerbium() {
		return terbium;
	}

	public void setTerbium(int terbium) {
		this.terbium = terbium;
	}

	public int getEndurium() {
		return endurium;
	}

	public void setEndurium(int endurium) {
		this.endurium = endurium;
	}

	public int getPrometid() {
		return prometid;
	}

	public void setPrometid(int prometid) {
		this.prometid = prometid;
	}

	public int getDuranium() {
		return duranium;
	}

	public void setDuranium(int duranium) {
		this.duranium = duranium;
	}

	public int getPromerium() {
		return promerium;
	}

	public void setPromerium(int promerium) {
		this.promerium = promerium;
	}

	public String getDmg() {
		return dmg;
	}

	public void setDmg(String dmg) {
		this.dmg = dmg;
	}

	public int getIA() {
		return IA;
	}

	public void setIA(int iA) {
		IA = iA;
	}

}
