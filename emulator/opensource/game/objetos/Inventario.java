package game.objetos;

import java.util.ArrayList;

import game.Usuarios;
import game.objetos.Objeto.Recurso;
import game.objetos.Objeto.Recurso.Mineral;
import utils.Logs;

public class Inventario 
{
	private Usuarios user;
	private ArrayList<Objeto> objetos = new ArrayList<Objeto>();
	private String minerales  = "";
	public Inventario(Usuarios user)
	{
		this.user = user;
		for(String objeto : user.get_inventario().split("\\|"))
		{
			if(objeto.equals(""))continue;
			switch(objeto.charAt(0))
			{
				case Objeto.RECURSO:
					switch(objeto.charAt(1))
					{
						case Objeto.RECURSO_MINERAL:
							for(String nobj : objeto.substring(2).split("\\;"))
							{
								int id = 0;
								int max = 0;	
								try
								{
									id = Integer.parseInt(nobj.split(",")[0]);
									max = Integer.parseInt(nobj.split(",")[1]);
								}catch(NumberFormatException e){continue;};
								Logs.info("Objeto cargado: RECURSO_MINERAL ("+id+") tiene "+max+".");
								Mineral mineral = new Mineral(id,max);
								Recurso recurso = new Recurso(mineral);
								Objeto obj = new Objeto(recurso);
								this.objetos.add(obj);
							}
						break;
					}
				break;
			}
		}
	}
	
	public ArrayList<Objeto> getObjetos() {
		return objetos;
	}
	
	public Usuarios getUser() {
		return user;
	}
	public void setUser(Usuarios user) {
		this.user = user;
	}
	
	public String getMinerales()
	{
		return minerales;
	}

	public void setMinerales(String minerales) {
		this.minerales = minerales;
	}

}
