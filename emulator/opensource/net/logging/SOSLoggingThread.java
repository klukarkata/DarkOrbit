package net.logging;

import game.Usuarios;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;

import utils.Logs;

import common.CryptManager;
import common.DarkOrbit;

public class SOSLoggingThread implements Runnable
{
		private BufferedReader _in;
		private Thread _t;
		private PrintWriter _out;
		private Socket _s;
		private Usuarios _user;
		public int userID;
		public String sesionID;
		public String version;
		public int _packetNum = 0;
	
		public SOSLoggingThread(Socket sock)
		{
			try
			{
				_s = sock;
				_in = new BufferedReader(new InputStreamReader(_s.getInputStream()));
				_out = new PrintWriter(_s.getOutputStream());
				_t = new Thread(this);
				_t.setDaemon(true);
				_t.start();
			}
			catch(IOException e)
			{
				try {
					System.out.println(e.getMessage());
					if(!_s.isClosed())_s.close();
				} catch (IOException e1) {e1.printStackTrace();}
			}
		}
		
		public void run()
		{
			try
	    	{
				String packet = "";
				char charCur[] = new char[1];
		    	while(_in.read(charCur, 0, 1)!=-1 && DarkOrbit.isRunning)
		    	{
		    		if (charCur[0] != '\u0000' && charCur[0] != '\n' && charCur[0] != '\r')
			    	{
		    			packet += charCur[0];
			    	}else if(!packet.isEmpty())
			    	{
			    		packet = CryptManager.toUnicode(packet);
			    		Logs.recv(3,packet);
			    		_packetNum++;
			    		parsePacket(packet);
			    		packet = "";
			    	}
		    	}
	    	}catch(IOException e)
	    	{
	    		try
	    		{
	    			Logs.error(e.getMessage());
		    		_in.close();
		    		_out.close();
		    		if(_user != null)
		    		{
		    			_user.set_actualUsuario(null);
		    		}
		    		if(!_s.isClosed())_s.close();
		    	}catch(IOException e1){e1.printStackTrace();};
	    	}catch(Exception e)
	    	{
	    		e.printStackTrace();
	    		Logs.error(e.getMessage());
	    	}
	    	finally
	    	{
	    		kick();
	    	}
		}
		
		private void parsePacket(String packet)
		{
			
		}
		
		public PrintWriter get_out() {
			return _out;
		}
		
		public void kick()
		{
			try
			{
				DarkOrbit.logServer.delClient(this);
	    		if(!_s.isClosed())
	    		_s.close();
	    		_in.close();
	    		_out.close();
	    		_t.interrupt();
			}catch(IOException e1){e1.printStackTrace();};
		}

		public Thread getThread()
		{
			return _t;
		}
		
		public void closeSocket()
		{
			try {
				this._s.close();
			} catch (IOException e) {}
		}
		
}
