package net.chat;

import java.io.IOException;
import java.net.ServerSocket;
import java.util.ArrayList;

import utils.Logs;

import common.CryptManager;
import common.DarkOrbit;

public class ChatServer implements Runnable{

	private ServerSocket _SS;
	private Thread _t;
	private ArrayList<ChatThread> _clients = new ArrayList<ChatThread>();
	private long _startTime;
	private int _maxUsuarios = 0;
	private long tiempo = 0;
	public static String VERSION = "2.2.0";
	
	public ChatServer(String Ip)
	{
		try {		
			_SS = new ServerSocket(DarkOrbit.CONFIG_CHAT_PORT);
			if(DarkOrbit.CONFIG_USE_IP)
				DarkOrbit.CHATSERVER_IP = CryptManager.CryptIP(Ip)+CryptManager.CryptPort(DarkOrbit.CONFIG_CHAT_PORT);
			_startTime = System.currentTimeMillis();
			_t = new Thread(this);
			_t.start();
		} catch (IOException e) {
			Logs.error("IOException: "+e.getMessage());
			DarkOrbit.closeServers();
		}
	}
	
	public ArrayList<ChatThread> getClients() {
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
		while(DarkOrbit.isRunning)
		{
			try
			{
				_clients.add(new ChatThread(_SS.accept()));
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
		ArrayList<ChatThread> c = new ArrayList<ChatThread>();
		c.addAll(_clients);
		for(ChatThread CT : c)
		{
			try
			{
				CT.closeSocket();
			}catch(Exception e){};	
		}
	}

	public void delClient(ChatThread chatThread)
	{
		_clients.remove(chatThread);
		if(_clients.size() > _maxUsuarios)_maxUsuarios = _clients.size();
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
}
	
	
