package net;

import game.BonusBox;
import game.Mapas;
import game.Usuarios;

import java.io.IOException;
import java.net.ServerSocket;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;

import utils.Formulas;
import utils.Logs;

import common.CryptManager;
import common.DarkOrbit;
import common.World;

public class GameServer implements Runnable{

	private ServerSocket _SS;
	private Thread _t;
	private ArrayList<GameThread> _clients = new ArrayList<GameThread>();
	private ArrayList<Usuarios> _waitings = new ArrayList<Usuarios>();
	private long _startTime;
	private int _maxUsuarios = 0;
	private long tiempo = 0;
	private Timer accionesJuego;
	private Timer accionesGlobales = new Timer();
	private int _saveTimer = 0;
	private int nuevasCajas = DarkOrbit.LANZAR_BONUSBOX;
	/** SISTEMA DE AUTOAPAGADO **/
	public static int tiempoApagado = 60;
	public static boolean activarApagado = false;
	
	public GameServer(String Ip)
	{
		try {
			
			accionesJuego = new Timer();
			accionesJuego.schedule(new TimerTask()
			{
				public void run()
				{
					_saveTimer++;					
					if(_saveTimer == (DarkOrbit.CONFIG_SAVE_TIME/60000))
					{
						if(!DarkOrbit.isSaving)
						{
							Thread t = new Thread(new SaveThread());
							t.start();
						}
						_saveTimer = 0;
					}
					for(Usuarios user : World.getUsuariosOnline()) 
					{
						if (user.getLastPacketTime() + DarkOrbit.CONFIG_MAX_IDLE_TIME < System.currentTimeMillis())
						{
							
							if(user != null && user.getGameThread() != null && user.isOnline())
							{
								Logs.info("Expulsado por inactividad : "+user.getUsuario()); 
								user.getGameThread().kick();
							}
						}
					}
					
				}
			}, 60000,60000);
			
			accionesGlobales.schedule(new TimerTask()
			{
				public void run()
				{
					tiempo++;
					nuevasCajas--;
					if(activarApagado == true)
					{
						if(tiempoApagado == 0)
						{
							System.exit(0);
						}
						tiempoApagado--;
						SocketManager.SEND_SERVER_MSG("-= "+tiempoApagado+" =-");
					}
					for(Usuarios user : World.getUsuariosOnline()) 
					{						
						if(user != null && user.getGameThread() != null && user.isOnline())
						{
							user.acciones();
						}
					}
					if(nuevasCajas == 0)
					{
						nuevasCajas = DarkOrbit.LANZAR_BONUSBOX;
						renovarCajas();
						SocketManager.CREATE_BONUSBOX_MAP();
					}
					World.MoveAliensOnMaps();
				}

			}, 0,1000);
			crearBonusBox();
			_SS = new ServerSocket(DarkOrbit.CONFIG_GAME_PORT);
			if(DarkOrbit.CONFIG_USE_IP)
				DarkOrbit.GAMESERVER_IP = CryptManager.CryptIP(Ip)+CryptManager.CryptPort(DarkOrbit.CONFIG_GAME_PORT);
			_startTime = System.currentTimeMillis();
			_t = new Thread(this);
			_t.start();
		} catch (IOException e) {
			Logs.error("IOException: "+e.getMessage());
			DarkOrbit.closeServers();
		}
	}
	
	public static class SaveThread implements Runnable
	{
		public void run()
		{
			if(DarkOrbit.isSaving == false)
			{
				World.saveAll(null);
			}
		}
	}
	
	public ArrayList<GameThread> getClients() {
		return _clients;
	}

	public long getStartTime()
	{
		return _startTime;
	}
	
	public int getMaxUsuarios()
	{
		return _maxUsuarios;
	}
	
	public int getNumeroUsuario()
	{
		return _clients.size();
	}
	public void run()
	{	
		while(DarkOrbit.isRunning)//bloque de _SS.accept()
		{
			try
			{
				_clients.add(new GameThread(_SS.accept()));
				if(_clients.size() > _maxUsuarios)_maxUsuarios = _clients.size();
			}catch(IOException e)
			{
				System.out.println("IOException: "+e.getMessage());
				try
				{
					if(!_SS.isClosed())_SS.close();
					DarkOrbit.closeServers();
				}
				catch(IOException e1){}
			}
		}
	}
	
	public void kickAll()
	{
		try {
			_SS.close();
		} catch (IOException e) {}
		//Copia
		ArrayList<GameThread> c = new ArrayList<GameThread>();
		c.addAll(_clients);
		for(GameThread GT : c)
		{
			try
			{
				GT.closeSocket();
			}catch(Exception e){};	
		}
	}

	public void delClient(GameThread gameThread)
	{
		_clients.remove(gameThread);
		if(_clients.size() > _maxUsuarios)_maxUsuarios = _clients.size();
	}

	public synchronized Usuarios getEsperaUsuario(int id)
	{
		for (int i = 0; i < _waitings.size(); i++)
		{
			if(_waitings.get(i).getId() == id)
				return _waitings.get(i);
		}
		return null;
	}
	
	public synchronized void delEsperaUsuario(Usuarios _user)
	{
		_waitings.remove(_user);
	}
	
	public synchronized void addEsperaUsuario(Usuarios _user)
	{
		_waitings.add(_user);
	}
	
	public static String getServerTime()
	{
		Date actDate = new Date();
		return "BT"+(actDate.getTime()+3600000);
	}
	public static String getServerDate()
	{
		Date actDate = new Date();
		DateFormat dateFormat = new SimpleDateFormat("dd");
		String hora = Integer.parseInt(dateFormat.format(actDate))+"";
		while(hora.length() <2)
		{
			hora = "0"+hora;
		}
		dateFormat = new SimpleDateFormat("MM");
		String mes = (Integer.parseInt(dateFormat.format(actDate))-1)+"";
		while(mes.length() <2)
		{
			mes = "0"+mes;
		}
		dateFormat = new SimpleDateFormat("yyyy");
		String year = (Integer.parseInt(dateFormat.format(actDate))-1370)+"";
		return "BD"+year+"|"+mes+"|"+hora;
	}

	public Thread getThread()
	{
		return _t;
	}

	public long getTiempo() {
		return tiempo;
	}

	public void setTiempo(long tiempo) {
		this.tiempo = tiempo;
	}
	
	private void crearBonusBox()
	{
		//EJ: 0|c|1q2u6|2|4406|2151
		int cajas = 0;
		for(int box = 0; box < DarkOrbit.SIZE_BONUSBOX; box++)
		{
			for(int mapa = 1; mapa < 30; mapa++)
			{
				BonusBox boxs = new BonusBox(BonusBox.getNewBonusBox(), 
						BonusBox.TYPE_BONUS_BOX, mapa, Formulas.getRandomValue(0, 20800), 
						Formulas.getRandomValue(0, 12800));
				World.getMapaByID(mapa).addBonusBox(boxs);
				cajas++;
			}
		}
		Logs.info("Se han creado "+cajas+" cajas de bonos con exito!");
	}
	
	private void renovarCajas() 
	{
		for(Mapas mapa: World.getMapas())
		{
			for(BonusBox box: mapa.getBonusBox().values())
			{
				if(box.getUser() != null)
				{
					box.setUser(null);
				}	
			}
		}
	}
		
}