package common;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintStream;
import java.net.InetAddress;
import java.util.Calendar;

import net.GameServer;
import net.chat.ChatServer;
import net.logging.SOSLoggingServer;

import policyserver.PolicyServer;

public class DarkOrbit {

	/**
	 * @author ELIEAZ
	 * elieaz@mail.ru
	 * @version DarkOrbit Beta v1.0.0
	 */
	//Configuracion global
	private static final String CONFIG_FILE = "config.ini";
	public static String VERSION = "1.2.0";
	public static boolean isRunning = false;
	public static boolean canLog;
	public static boolean isSaving = false;
	
	public static int CONFIG_GAME_PORT 	= 8080;
	public static int CONFIG_CHAT_PORT 	= 9338;
	public static int CONFIG_LOG_PORT 	= 4444;
	
	public static int CONFIG_SAVE_TIME = 10*60*10000; //Tiempo en el cual se guardaran de nuevo todos los datos
	public static String GAMESERVER_IP;
	public static String CHATSERVER_IP;
	public static String LOGSERVER_IP;
	public static String IP = "127.0.0.1";
	public static boolean CONFIG_USE_IP = true;
	
	public static GameServer gameServer;
	public static ChatServer chatServer;
	public static SOSLoggingServer logServer;
	public static BufferedWriter Log_Game;
	public static PrintStream PS;
	//Config del juego
	public static boolean CONFIG_DEBUG = true;
	public static boolean CONFIG_MODO_CONSOLA = false;
	public static int LANZAR_BONUSBOX = 1*60;//1 min
	public static int SIZE_BONUSBOX = 50;
	
	//Inactividad
	public static int CONFIG_MAX_IDLE_TIME = 5*60000;//5 min
	//Configuracion Base de datos
	public static String HOST = "127.0.0.1";
	public static String BD = "do_es";
	public static String USUARIO = "root";
	public static String PASSWORD = "";
	
	public static int CONFIG_DB_COMMIT = 30*1000;
	public static boolean isInit = false;
	
	//Configuracion del PolicyServer
	public static PolicyServer policyServer;
	private static DarkOrbit _this;

	public static void main(String[] args) {
		Runtime.getRuntime().addShutdownHook(new Thread()
		{
			public void run()
			{
				DarkOrbit.closeServers();
			}
		}
		);
		System.out.println("#========================= #");
		System.out.println("# DarkOrbit v"+VERSION+"\t #");
		System.out.println("# Creadopor:Elieaz Neor1326#");
		System.out.println("# elieaz@mail.ru           #");
		System.out.println("#========================= #");
		System.out.println("Cargando configuracion:");
		cargarConfiguracion();
		isInit = true;
		System.out.println("Cargado con exito!");
		System.out.println("Conexion con la Base de datos...");
		if(SQLManager.setUpConnexion()) System.out.println("Conectado!");
		else
		{
			System.out.println("Conexion invalida");
			DarkOrbit.closeServers();
			System.exit(0);
		}
        
		System.out.println("Creando DarkOrbit...");
		long startTime = System.currentTimeMillis();
        //Start Policy Server
		System.out.println("Creando Policy Server...");
        policyServer = new PolicyServer(_this);
		World.createWorld();
		long endTime = System.currentTimeMillis();
		long differenceTime = (endTime - startTime)/1000;
		System.out.println("Creado con exito ! en : "+differenceTime+" s");
		isRunning = true;
		String Ip = "";
		try
		{
			Ip = InetAddress.getLocalHost().getHostAddress();
		}catch(Exception e)
		{
			System.out.println(e.getMessage());
			try {
				Thread.sleep(10000);
			} catch (InterruptedException e1) {}
			System.exit(1);
		}
		Ip = IP;
		gameServer = new GameServer(Ip);
		System.out.println("Servidor del juego lanzado en el puerto "+CONFIG_GAME_PORT);
		chatServer = new ChatServer(Ip);
		System.out.println("Servidor del chat lanzado en el puerto "+CONFIG_CHAT_PORT);
		logServer = new SOSLoggingServer(Ip);
		System.out.println("Servidor de Logs lanzado en el puerto "+CONFIG_LOG_PORT);
		if(CONFIG_USE_IP)
			System.out.println("IP del servidor "+IP+" encriptada: "+GAMESERVER_IP);
        
		System.out.println("Esperando conexiones...");
		System.out.println("Visit http://mycom69.tk");
		
	}
	
	public static void cargarConfiguracion()
	{
		boolean log = false;
		try {
			BufferedReader config = new BufferedReader(new FileReader(CONFIG_FILE));
			String lin = "";
			while ((lin=config.readLine())!=null)
			{
				if(lin.split("=").length == 1) continue;
				String param = lin.split("=")[0].trim();
				String valor = lin.split("=")[1].trim();
				if(param.equalsIgnoreCase("DEBUG"))
				{
					if(valor.equalsIgnoreCase("true"))
					{
						DarkOrbit.CONFIG_DEBUG = true;
						System.out.println("Modo Debug: Habilitado");
					}
				}else if(param.equalsIgnoreCase("LOG"))
				{
					if(valor.equalsIgnoreCase("true"))
					{
						log = true;
					}
				}else if(param.equalsIgnoreCase("USE_IP"))
				{
					if(valor.equalsIgnoreCase("true"))
					{
						DarkOrbit.CONFIG_USE_IP = true;
					}
				}else if(param.equalsIgnoreCase("SERVER_IP"))
				{
					DarkOrbit.IP = valor;
				}
				else if(param.equalsIgnoreCase("DB_HOST"))
				{
					DarkOrbit.HOST = valor;
				}else if(param.equalsIgnoreCase("DB_USER"))
				{
					DarkOrbit.USUARIO = valor;
				}else if(param.equalsIgnoreCase("DB_PASS"))
				{
					if(valor == null) valor = "";
					DarkOrbit.PASSWORD = valor;
				}else if(param.equalsIgnoreCase("DB_NAME"))
				{
					DarkOrbit.BD = valor;
				}else if (param.equalsIgnoreCase("MAX_IDLE_TIME"))
				{
					DarkOrbit.CONFIG_MAX_IDLE_TIME = (Integer.parseInt(valor)*60000);
				}else if (param.equalsIgnoreCase("CONFIG_MODO_CONSOLA"))
				{
					DarkOrbit.CONFIG_MODO_CONSOLA = valor.equalsIgnoreCase("true");
				}else if (param.equalsIgnoreCase("LANZAR_BONUSBOX"))
				{
					DarkOrbit.LANZAR_BONUSBOX = (Integer.parseInt(valor)*60);
				}else if (param.equalsIgnoreCase("SIZE_BONUSBOX"))
				{
					DarkOrbit.SIZE_BONUSBOX = Integer.parseInt(valor);
				}
			}
			if(BD == null || HOST == null || PASSWORD == null || USUARIO == null)
			{
				throw new Exception();
			}
		} catch (Exception e) {
            System.out.println(e.getMessage());
			System.out.println("Fichero de configuracion inaccesible");
			System.out.println("Cerrando el servidor...");
			System.exit(1);
		}
		try
		{
			String fecha = Calendar.getInstance().get(Calendar.DAY_OF_MONTH)+"_"+(Calendar.getInstance().get(Calendar.MONTH)+1)+"_"+Calendar.getInstance().get(Calendar.YEAR);
			if(log)
			{
				Log_Game = new BufferedWriter(new FileWriter("logs/"+fecha+".txt", true));
				PS = new PrintStream(new File("logs/"+fecha+"_error.txt"));
				PS.append("Lanzamiento del servidor..\n");
				PS.flush();
				System.setErr(PS);
				canLog = true;
				String str = "Lanzamiento del servidor...\n";
				Log_Game.write(str);
				Log_Game.flush();
			}
		}catch(IOException e)
		{
			System.out.println("Los archivos de registro no se han podido crear");
			System.out.println("Creando las carptetas");
			new File("logs").mkdir(); 
			System.out.println(e.getMessage());
			System.exit(1);
		}
	}
	
	public static void closeServers()
	{
		System.out.println("Deteniendo la peticion del servidor...");
		if(isRunning)
		{
			isRunning = false;
			DarkOrbit.gameServer.kickAll();
			DarkOrbit.chatServer.kickAll();
			World.saveAll(null);
			SQLManager.closeCons();
		}
		System.out.println("Detener servidor: OK");
		isRunning = false;
	}

}
