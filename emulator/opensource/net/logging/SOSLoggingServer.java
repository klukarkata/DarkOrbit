package net.logging;

import java.io.IOException;
import java.net.ServerSocket;
import java.util.ArrayList;

import utils.Logs;

import common.CryptManager;
import common.DarkOrbit;

public class SOSLoggingServer implements Runnable{

		private ServerSocket _SS;
		private Thread _t;
		private ArrayList<SOSLoggingThread> _clients = new ArrayList<SOSLoggingThread>();
		private long _startTime;
		private int _maxUsuarios = 0;
		
		public SOSLoggingServer(String Ip)
		{
			try {		
				_SS = new ServerSocket(DarkOrbit.CONFIG_LOG_PORT);
				if(DarkOrbit.CONFIG_USE_IP)
					DarkOrbit.LOGSERVER_IP = CryptManager.CryptIP(Ip)+CryptManager.CryptPort(DarkOrbit.CONFIG_LOG_PORT);
				_startTime = System.currentTimeMillis();
				_t = new Thread(this);
				_t.start();
			} catch (IOException e) {
				Logs.error("IOException: "+e.getMessage());
				DarkOrbit.closeServers();
			}
		}
		
		public ArrayList<SOSLoggingThread> getClients() {
			return _clients;
		}
		
		public void delClient(SOSLoggingThread loggingThread)
		{
			_clients.remove(loggingThread);
			if(_clients.size() > _maxUsuarios)_maxUsuarios = _clients.size();
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
					_clients.add(new SOSLoggingThread(_SS.accept()));
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

		public Thread getThread()
		{
			return _t;
		}

}

