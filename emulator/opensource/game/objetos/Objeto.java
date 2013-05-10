package game.objetos;

import java.util.ArrayList;


public class Objeto 
{
	public static final char RECURSO 					= 'R';
	public static final char RECURSO_MINERAL 			= 'M';
	public static final int RECURSO_MINERAL_PROMETIUM 	= 1;
	public static final int RECURSO_MINERAL_ENDURIUM 	= 2;
	public static final int RECURSO_MINERAL_TERBIUM 	= 3;
	public static final int RECURSO_MINERAL_XENOMIT 	= 10;
	public static final int RECURSO_MINERAL_PROMETID 	= 11;
	public static final int RECURSO_MINERAL_DURANIUM 	= 12;
	public static final int RECURSO_MINERAL_PROMERIUM	= 13;
	public static final int RECURSO_MINERAL_SEPROM 		= 14;
	public static final int RECURSO_MINERAL_PALADIO 	= 15;
	private char id;
	
	private ArrayList<Recurso> recursos = new ArrayList<Recurso>();	
	public Objeto(Recurso recurso)
	{
		this.id = 'R';
		this.recursos.add(recurso);
	}	

	public static class Recurso
	{
		private ArrayList<Mineral> minerales = new ArrayList<Mineral>();
		public Recurso(Mineral mineral) 
		{
			minerales.add(mineral);
		}
		public static class Mineral
		{
			private int id;
			private int cantidad;
			public Mineral(int id, int cantidad)
			{
				this.id = id;
				this.cantidad = cantidad;
			}
			public int getId() {
				return id;
			}
			public void setId(int id) {
				this.id = id;
			}
			public int getCantidad() {
				return cantidad;
			}
			public void setCantidad(int cantidad) {
				this.cantidad = cantidad;
			}
		}
		
		public ArrayList<Mineral> getMinerales() 
		{
			return minerales;
		}
	}
	
	public ArrayList<Recurso> getRecursos()
	{
		return recursos;
	}
	
	public char getId() {
		return id;
	}

	public void setId(char id) {
		this.id = id;
	}

	public class Municion
	{
		public class Laser
		{
			
		}
		
		public class Misil
		{
			
		}
		
		public class Mina
		{
			
		}
		
		public class LanzaMisil
		{
			
		}
		
		public class Firework
		{
			
		}
		
		public class ArmaEspecial
		{
			
		}
	}

}
