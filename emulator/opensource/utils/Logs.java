package utils;

import common.DarkOrbit;

public class Logs {
	
	public Logs()
	{
		
	}
	/** LOGS **/
	public static void info(Object msg)
	{
		if(DarkOrbit.CONFIG_DEBUG == true)System.out.println("INFO: "+msg);
	}
	
	public static void error(Object msg)
	{
		if(DarkOrbit.CONFIG_DEBUG == true)System.err.println("ERROR: "+msg);
	}
	/** LOGS **/
	/** PAQUETES ENVIADOS Y RECIBIDOS **/
	public static void recv(int server, Object packet)
	{
		if(DarkOrbit.CONFIG_DEBUG == false)return;
		switch(server)
		{
			case 1:
				System.out.println("Servidor elieaz: Recv << "+packet);
			break;
			case 2:
				System.out.println("Chat elieaz: Recv << "+packet);
			break;
			default:
				System.out.println(packet);
			break;
		}	
	}
	public static void env(int server, Object packet)
	{
		if(DarkOrbit.CONFIG_DEBUG == false)return;
		switch(server)
		{
			case 1:
				System.out.println("Servidor elieaz: Env << "+packet);
			break;
			case 2:
				System.out.println("Chat elieaz: Env << "+packet);
			break;
			default:
				System.out.println(packet);
			break;
		}
	}
	/** PAQUETES ENVIADOS Y RECIBIDOS **/
}
