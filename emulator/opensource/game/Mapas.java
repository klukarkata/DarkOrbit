package game;

import java.util.ArrayList;
import java.util.Map;
import java.util.TreeMap;

import common.World;

public class Mapas {
	
	private int mapid;
	private String name;
	private int music;
	private int scaleFactor;
	private String neighbours;
	private String starfield;
	private String backgrounds;
	private String lensflares;
	private String planets;
	private String npcs;
	int _nextAlienID = -2;
	private Map<Integer,Ship> naves = new TreeMap<Integer,Ship>();
	private Map<String,BonusBox> bonusBox = new TreeMap<String,BonusBox>();
	private int alertaEnemigos;
	
	public Mapas(int mapid, String name, int music, int scaleFactor, String neighbours, String starfield,
			String backgrounds, String lensflares, String planets, String npcs){
		
		this.mapid = mapid;
		this.name = name;
		this.music = music;
		this.scaleFactor = scaleFactor;
		this.neighbours = neighbours;
		this.starfield = starfield;
		this.backgrounds = backgrounds;
		this.lensflares = lensflares;
		this.planets = planets;
		this.npcs = npcs;
		for(String npc : npcs.split("\\|"))
		{
			if(npc.equals(""))continue;
			int id = 0;
			int max = 0;	
			try
			{
				id = Integer.parseInt(npc.split(",")[0]);
				max = Integer.parseInt(npc.split(",")[1]);
			}catch(NumberFormatException e){continue;};			
			if(id == 0 || max == 0)continue;
			if(World.getNPC(id) == null)continue;
			for(int i=0;i<max;i++)addAlien(id);
		}
		this.alertaEnemigos = 0;
	}

	public int getMapid() {
		return mapid;
	}

	public void setMapid(int mapid) {
		this.mapid = mapid;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getMusic() {
		return music;
	}

	public void setMusic(int music) {
		this.music = music;
	}

	public int getScaleFactor() {
		return scaleFactor;
	}

	public void setScaleFactor(int scaleFactor) {
		this.scaleFactor = scaleFactor;
	}

	public String getNeighbours() {
		return neighbours;
	}

	public void setNeighbours(String neighbours) {
		this.neighbours = neighbours;
	}

	public String getStarfield() {
		return starfield;
	}

	public void setStarfield(String starfield) {
		this.starfield = starfield;
	}

	public String getBackgrounds() {
		return backgrounds;
	}

	public void setBackgrounds(String backgrounds) {
		this.backgrounds = backgrounds;
	}

	public String getLensflares() {
		return lensflares;
	}

	public void setLensflares(String lensflares) {
		this.lensflares = lensflares;
	}

	public String getPlanets() {
		return planets;
	}

	public void setPlanets(String planets) {
		this.planets = planets;
	}
	
	public static int getSeccionID(int mapa, int x, int y) {
		int seccionID = 1;
		switch(mapa)
		{
			default:
				if(x >= 0 && x <= 6933)
				{
					if(y >= 0 && y <= 4266)
					{
						seccionID = 1;
						
					}else if(y >= 4266 && y <= 8532)
					{
						seccionID = 4;
					}else if(y >= 8532 && y <= 12800)
					{
						seccionID = 7;
					}
							
				}else if(x >= 6933 && x <= 13866)
				{
					if(y >= 0 && y <= 4266)
					{
						seccionID = 2;
						
					}else if(y >= 4266 && y <= 8532)
					{
						seccionID = 5;
					}else if(y >= 8532 && y <= 12800)
					{
						seccionID = 8;
					}
					
				}else if(x >= 13866 && x <= 20800)
				{
					if(y >= 0 && y <= 4266)
					{
						seccionID = 3;
						
					}else if(y >= 4266 && y <= 8532)
					{
						seccionID = 6;
					}else if(y >= 8532 && y <= 12800)
					{
						seccionID = 9;
					}
				}
				break;
		}
		
		return seccionID;
	}
	
	public void addNave(int ID)
	{
		if(World.getUsuarioByID(ID) != null)
		{
			Usuarios user = World.getUsuarioByID(ID);
			Ship nave = new Ship(user);
			user.setShip(nave);
			naves.put(user.getId(), nave);
		}		
	}
	
	public void addAlien(int ID)
	{
		Ship alien = new Ship(_nextAlienID,World.getNPC(ID));
		naves.put(_nextAlienID, alien);
		_nextAlienID--;		
	}
	
	public void eliminarNave(Ship nave)
	{
		if(nave != null)naves.remove(nave.getId());
	}
	
	public Map<Integer, Ship> get_aliens() {
		return naves;
	}
	
	public static ArrayList<Usuarios> getNaves()
	{
		ArrayList<Usuarios> naves = new ArrayList<Usuarios>();
		for(Mapas mapa: World.getMapas())
		{
			for(Usuarios user : World.getUsuariosOnline())
			{
				if(user.getMapa() == mapa.getMapid())naves.add(user);
			}
		}		
		return naves;
	}
	
	public Map<Integer,Ship> getShips() {
		return naves;
	}
	
	public Ship getShip(int id)
	{
		return naves.get(id);
	}

	public String getNpcs() {
		return npcs;
	}

	public void setNpcs(String npcs) {
		this.npcs = npcs;
	}

	public Map<String,BonusBox> getBonusBox() {
		return bonusBox;
	}
	
	public void addBonusBox(BonusBox box)
	{
		bonusBox.put(box.getId(), box);
	}

	public int getAlertaEnemigos() {
		return alertaEnemigos;
	}

	public void setAlertaEnemigos(int alertaEnemigos) {
		this.alertaEnemigos = alertaEnemigos;
	}

}
