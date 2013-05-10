package game;

import common.World;

public class Naves {
	
	private int id;
	private String nombre;
	private int velocidad;
	private int carga;
	private int lasers;
	private int generadores;
	private long vida;
	private int misiles;
	private int extras;
	
	public Naves(int id, String nombre, int velocidad, int carga, int lasers, int generadores,
			long vida, int misiles, int extras){
		
		this.id = id;
		this.nombre = nombre;
		this.velocidad = velocidad;
		this.carga = carga;
		this.lasers = lasers;
		this.generadores = generadores;
		this.vida = vida;
		this.misiles = misiles;
		this.extras = extras;
		
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

	public int getVelocidad() {
		return velocidad;
	}

	public void setVelocidad(int velocidad) {
		this.velocidad = velocidad;
	}

	public int getCarga() {
		return carga;
	}

	public void setCarga(int carga) {
		this.carga = carga;
	}

	public int getLasers() {
		return lasers;
	}

	public void setLasers(int lasers) {
		this.lasers = lasers;
	}

	public int getGeneradores() {
		return generadores;
	}

	public void setGeneradores(int generadores) {
		this.generadores = generadores;
	}

	public long getVida() {
		return vida;
	}

	public void setVida(long vida) {
		this.vida = vida;
	}

	public int getMisiles() {
		return misiles;
	}

	public void setMisiles(int misiles) {
		this.misiles = misiles;
	}

	public int getExtras() {
		return extras;
	}

	public void setExtras(int extras) {
		this.extras = extras;
	}
	
	public static int getMaxLaserCapacidad(int naveID)
	{
		int lasers = 0;
		if(naveID >= 1 && naveID <= 10)
		{
			lasers = World.getNavesByID(naveID).getMisiles()*20;
		}else
		{
			lasers = 9999999;
		}
		return lasers;
	}
	
	public static int getMaxMisilCapacidad(int naveID)
	{
		int misiles = 0;
		if(naveID >= 1 && naveID <= 10)
		{
			misiles = World.getNavesByID(naveID).getMisiles();
		}else
		{
			misiles = 9999999;
		}
		return misiles;
	}
	
	public static int getTipoExpansionArma(int c)
	{
		int expansion = 1;
		if(c<0 || c==0)expansion = 1;
		if(c>0 && c<3)expansion = 2;
		if(c>2)expansion = 3;
		return expansion;
	}
	
}
