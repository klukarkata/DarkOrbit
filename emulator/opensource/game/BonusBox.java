package game;

import java.util.Random;

public class BonusBox {
	
    public static int TYPE_NOT_FREE_CARGO_BOX = 0;
    public static int TYPE_FREE_CARGO_BOX = 1;
    public static int TYPE_BONUS_BOX = 2;

	private String id;
	private int tipo;
	private int posX;
	private int posY;
	private int mapa;
	private Usuarios user;
	
	public BonusBox(String id, int tipo, int mapa, int posX, int posY)
	{
		this.id = id;
		this.tipo = tipo;
		this.mapa = mapa;
		this.posX = posX;
		this.posY = posY;
		this.user = null;
	}
	
	public static String getNewBonusBox()
	{
		String box = "";
		long milis = new java.util.GregorianCalendar().getTimeInMillis();
		Random r = new Random(milis);
		int i = 0;
		while ( i < 5)
		{
			char c = (char)r.nextInt(255);
			if ( (c >= '0' && c <='9') || (c >='a' && c <='z') )
			{
				box += c;
				i ++;
			}
		}
		if(box.length()>5)box = box.substring(0, 5);
		return box;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public int getTipo() {
		return tipo;
	}

	public void setTipo(int tipo) {
		this.tipo = tipo;
	}

	public int getPosX() {
		return posX;
	}

	public void setPosX(int posX) {
		this.posX = posX;
	}

	public int getPosY() {
		return posY;
	}

	public void setPosY(int posY) {
		this.posY = posY;
	}

	public int getMapa() {
		return mapa;
	}

	public void setMapa(int mapaID) {
		this.mapa = mapaID;
	}

	public Usuarios getUser() {
		return user;
	}

	public void setUser(Usuarios user) {
		this.user = user;
	}


}
