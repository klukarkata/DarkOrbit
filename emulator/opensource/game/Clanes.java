package game;

public class Clanes {
	
	private int clanID;
	private String nombre;
	private String tagNombre;
	
	public Clanes(int clanID, String nombre, String tagNombre)
	{
		this.clanID = clanID;
		this.nombre = nombre;
		this.tagNombre = tagNombre;
	}

	public int getClanID() {
		return clanID;
	}

	public void setClanID(int clanID) {
		this.clanID = clanID;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public String getTagNombre() {
		return tagNombre;
	}

	public void setTagNombre(String tagNombre) {
		this.tagNombre = tagNombre;
	}

}
