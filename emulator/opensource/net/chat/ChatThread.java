package net.chat;

import game.Usuarios;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;

import net.SocketManager;
import utils.Logs;

import common.CryptManager;
import common.DarkOrbit;
import common.World;

public class ChatThread implements Runnable
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
	
		public ChatThread(Socket sock)
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
			    		Logs.recv(2,packet);
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
		    			_user.setChatThread(null);
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
			if(packet.equals("<policy-file-request/>"))
			{
				SocketManager.REALM_SEND_POLICY_FILE(_out);
			}
			
			//bu%-1%admin@2@6e9bece1914809fb8493146417e722f6@563@es@ADM@2.2.0@0@-1@
			/** LOGIN **/
			if(packet.length() > 2 && packet.substring(0, 2).equals(ChatCommands.CMD_USER_LOGIN))
			{
				userID = Integer.parseInt(packet.split("\\@")[1]);
				sesionID = packet.split("\\@")[2];
				version = packet.split("\\@")[6];
				if(World.getUsuarioByID(userID) != null)
				{
					_user = World.getUsuarioByID(userID);
					_user.setChatThread(this);
				}
				SocketManager.sendCommand(_out, "bv%"+userID+"#");
				SocketManager.sendCommand(_out, "by%274|EIC|1|2|0|0}273|MMO|1|1|0|0}275|VRU|1|3|0|0}396|Buscar clan|2|-1|0|0}272|Global|0|-1|0|0#");
			}
			if(packet.length() > 2 && packet.substring(0, 1).equals(ChatCommands.CMD_USER_MSG))
			{
				int canal = Integer.parseInt(packet.split("\\%")[1]);
				String mensaje = packet.split("\\%")[2];
				if(_user.getRango() == 21)
				{
					SocketManager.GAME_SEND_MSG_CHAT_ADMIN(_out, canal, _user, mensaje);
				}else{
					SocketManager.GAME_SEND_MSG_CHAT(_out, canal, _user, mensaje);
				}
			}
		}
		
		public PrintWriter get_out() {
			return _out;
		}
		
		public void kick()
		{
			try
			{
				DarkOrbit.chatServer.delClient(this);
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
