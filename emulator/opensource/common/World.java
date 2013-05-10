package common;

import game.Clanes;
import game.Mapas;
import game.NPC;
import game.Naves;
import game.Portales;
import game.Ship;
import game.Usuarios;
import game.Usuarios.Settings;

import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.ConcurrentModificationException;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.TreeMap;

public class World {
	
	private static Map<Integer,Usuarios> Usuarios = new TreeMap<Integer,Usuarios>();
	private static Map<String,Integer> 	UsuariobyNombre	= new TreeMap<String,Integer>();
	private static Map<Integer,Settings> Settings = new TreeMap<Integer,Settings>();
	private static Map<Integer,Mapas> Mapas = new TreeMap<Integer,Mapas>();
	private static Map<Integer,Naves> Naves = new TreeMap<Integer,Naves>();
	private static Map<Integer,NPC> NPCs = new TreeMap<Integer,NPC>();
	private static Map<Integer,Portales> Portales = new TreeMap<Integer,Portales>();
	private static Map<Integer,Clanes> Clanes = new TreeMap<Integer,Clanes>();
	private static Map<Integer,ExpLevel> ExpLevels = new TreeMap<Integer, ExpLevel>();
	private static int nextObjetoID;
	private static int saveTry = 1;
	//Estado del servidor 1: accesible; 0: inaccesible; 2: guardandose
	@SuppressWarnings("unused")
	private static short _state = 1;
	
	public World(){
		
	}

	public static void addUsuario(Usuarios usuario)
	{
		Usuarios.put(usuario.getId(), usuario);
		UsuariobyNombre.put(usuario.getUsuario().toLowerCase(), usuario.getId());
	}
	
	public static void addUsuariobyNombre(Usuarios usuario)
	{
		UsuariobyNombre.put(usuario.getUsuario(), usuario.getId());
	}
	
	public static class ExpLevel
	{
		public long nave;
		public int vant;
		public int pet;
		
		public ExpLevel(long n, int v, int p)
		{
			nave = n;
			vant = v;
			pet = p;
		}	
	}
	
	public static void addExpLevel(int lvl,ExpLevel exp)
	{
		ExpLevels.put(lvl, exp);
	}
	
	public static ExpLevel getExpLevel(int lvl)
	{
		return ExpLevels.get(lvl);
	}
	
	public static long getUserXpMin(int lvl)
	{
		if(lvl > 32) 	lvl = 32;
		if(lvl < 1) 	lvl = 1;
		return ExpLevels.get(lvl).nave;
	}
	
	public static long getUserXpMax(int lvl)
	{
		int up = 0;
		if(lvl >= 32)lvl = 32;
		if(lvl <= 1)lvl = 1;
		if(lvl<32)up=1;
		return ExpLevels.get(lvl+up).nave;
	}
	
	public static void createWorld()
	{
		System.out.println("Cargando cuenta(s)...");
		SQLManager.CARGAR_SETTINGS();
		SQLManager.CARGAR_USUARIOS();
		System.out.println(Usuarios.size()+" cuentas creada(s).");
		
		System.out.println("Cargando alien(s)...");
		SQLManager.CARGAR_NPCS();
		System.out.println(NPCs.size()+" alien(s) cargado(s).");
		
		System.out.println("Cargando nivel(es) de experiencia...");
		SQLManager.CARGAR_XP();
		System.out.println(ExpLevels.size()+" nivel(es) cargado(s).");
		
		System.out.println("Cargando mapa(s)...");
		SQLManager.CARGAR_MAPAS();
		System.out.println(Mapas.size()+" mapa(s) cargado(s).");
		
		System.out.println("Cargando nave(s)...");
		SQLManager.CARGAR_NAVES();
		System.out.println(Naves.size()+" nave(s) cargada(s).");
		
		System.out.println("Cargando portal(es)...");
		SQLManager.CARGAR_PORTALES();
		System.out.println(Portales.size()+" portal(es) cargado(s).");
		
		System.out.println("Cargando clan(es)...");
		SQLManager.CARGAR_CLANES();
		System.out.println(Clanes.size()+" clan(es) cargado(s).");
		
		System.out.print("Estados de conexion reseteados: ");
		SQLManager.LOGGED_ZERO();
		System.out.println("Correcto!");
		int nbr;
		System.out.println("Cargando lista de baneados...");
		nbr = SQLManager.CARGAR_BANEADOS();
		System.out.println(nbr+" baneados.");
		
		nextObjetoID = SQLManager.getNextObjetoID();
	}
	public static void NuevoUsuario() {
	
	}
	public synchronized static int getNewObjetoId()
	{
		return nextObjetoID++;
	}
	
	public static Usuarios getUsuarioByID(int id)
	{
		return Usuarios.get(id);
	}
	
	public static Usuarios getUsuarioByNombre(String usuario)
	{
		return (UsuariobyNombre.get(usuario.toLowerCase())!=null?Usuarios.get(UsuariobyNombre.get(usuario.toLowerCase())):null);
	}
	
	public static void addMapa(Mapas mapa)
	{
		Mapas.put(mapa.getMapid(), mapa);
	}
	
	public static void addNaves(Naves nave)
	{
		Naves.put(nave.getId(), nave);
	}
	
	public static Clanes getClanByID(int id)
	{
		return Clanes.get(id);
	}
	
	public static void addPortales(Portales portal)
	{
		Portales.put(portal.getID(), portal);
	}
	
	public static void addClanes(Clanes clan)
	{
		Clanes.put(clan.getClanID(), clan);
	}
	
	public static Naves getNavesByID(int id)
	{
		return Naves.get(id);
	}
	
	public static List<Usuarios> getUsuariosOnline()
	{
		List<Usuarios> online = new ArrayList<Usuarios>();
		for(Entry<Integer,Usuarios> user : Usuarios.entrySet())
		{
			if(user.getValue().isOnline() && user.getValue().getGameThread() != null)
			{
				if(user.getValue().getGameThread().get_out() != null)
				{
					online.add(user.getValue());
				}
			}
		}
		return online;
	}
	
	public static List<Portales> getPortales()
	{
		List<Portales> portal = new ArrayList<Portales>();
		for(Entry<Integer,Portales> p : Portales.entrySet())
		{
			portal.add(p.getValue());
		}
		return portal;
	}
	
	public static List<Mapas> getMapas()
	{
		List<Mapas> mapa = new ArrayList<Mapas>();
		for(Entry<Integer,Mapas> m : Mapas.entrySet())
		{
			mapa.add(m.getValue());
		}
		return mapa;
	}
	
	
	public static void saveAll(Usuarios saver)
	{
		PrintWriter _out = null;
		if(saver != null)
		_out = saver.get_cuenta().getGameThread().get_out();
		
		set_state((short)2);

		try
		{
			System.out.println("Lanzamiento de autoguardado...");
			DarkOrbit.isSaving = true;
			
			SQLManager.commitTransacts();
			SQLManager.TIMER(false);	//Detiene la grabación con temporizador SQL
			Thread.sleep(10000);
			
			System.out.println("Guardando cuentas...");
			for(Usuarios user : Usuarios.values())
			{
				if(!user.isOnline())continue;
				Thread.sleep(100);//0.1 seg. para los objetos
				SQLManager.GUARDAR_USUARIO(user);//Guarda los usuarios
			}
			Thread.sleep(2500);
			System.out.println("Guardado con exito !");
			
			set_state((short)1);
			//TODO : Refrescar 
			
		}catch(ConcurrentModificationException e)
		{
			if(saveTry < 10)
			{
				System.out.println("Nueva tentativa de guardado");
				if(saver != null && _out != null)
					System.out.println("Error. Nueva tentativa de guardado.");
				saveTry++;
				saveAll(saver);
			}
			else
			{
				set_state((short)1);
				//TODO : Refrescar 
				String mess = "Error al guardar despues de " + saveTry + " tentativas";
				if(saver != null && _out != null)
					System.out.println(mess);
			}
				
		}catch(Exception e)
		{
			System.out.println("Error al guardar los datos : " + e.getMessage());
			e.printStackTrace();
		}
		finally
		{
			SQLManager.commitTransacts();
			SQLManager.TIMER(true); //Reinicia la grabación con temporizador de SQL
			DarkOrbit.isSaving = false;
			saveTry = 1;
		}
	}

	public static void set_state(short state)
	{
		_state = state;
	}
	
	public static void MoveAliensOnMaps() 
	{
		for (Usuarios user : World.getUsuariosOnline())
		{			
			for(Ship aliens: user.getMapaActual().get_aliens().values())
			{
				if(aliens.getId() < 0)
				{
					new IA.IAThread(aliens);
				}			
			}
		}		
	}

	public static void addNPC(NPC npc) 
	{
		NPCs.put(npc.getId(), npc);		
	}

	public static void addSettings(Settings s) {
		Settings.put(s.getUserID(), s);		
	}
	
	public static Settings getSettingByID(int id)
	{
		return Settings.get(id);
	}
	
	public static NPC getNPC(int id)
	{
		return NPCs.get(id);
	}
	
	public static Mapas getMapaByID(int id)
	{
		return Mapas.get(id);
	}

}
