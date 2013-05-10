package game;

public class Portales {
	
	private int ID;
	private int factionID;
	private int keyPortal;
	private int mapID;
	private int posX;
	private int posY;
	private int factionScrap;
	private int toMapID;
	private String toPos;
	private int reqNivel;
	
	
	public Portales(int ID, int factionID, int keyPortal, int mapID, int posX, int posY,
			int factionScrap, int toMapID, String toPos, int reqNivel)
	{
		this.ID = ID;
		this.factionID = factionID;
		this.keyPortal = keyPortal;
		this.mapID = mapID;
		this.posX = posX;
		this.posY = posY;
		this.factionScrap = factionScrap;
		this.toMapID = toMapID;
		this.toPos = toPos;
		this.reqNivel = reqNivel;		
	}

	public int getID() {
		return ID;
	}

	public void setID(int iD) {
		ID = iD;
	}

	public int getFactionID() {
		return factionID;
	}

	public void setFactionID(int factionID) {
		this.factionID = factionID;
	}

	public int getKeyPortal() {
		return keyPortal;
	}

	public void setKeyPortal(int keyPortal) {
		this.keyPortal = keyPortal;
	}

	public int getMapID() {
		return mapID;
	}

	public void setMapID(int mapID) {
		this.mapID = mapID;
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

	public int getFactionScrap() {
		return factionScrap;
	}

	public void setFactionScrap(int factionScrap) {
		this.factionScrap = factionScrap;
	}

	public int getToMapID() {
		return toMapID;
	}

	public void setToMapID(int toMapID) {
		this.toMapID = toMapID;
	}

	public int getReqNivel() {
		return reqNivel;
	}

	public void setReqNivel(int reqNivel) {
		this.reqNivel = reqNivel;
	}

	public String getToPos() {
		return toPos;
	}

	public void setToPos(String toPos) {
		this.toPos = toPos;
	}

}
