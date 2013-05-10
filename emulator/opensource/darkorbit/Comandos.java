package darkorbit;

import game.BonusBox;
import game.Usuarios;

import java.io.PrintWriter;

import net.GameServer;
import net.SocketManager;
import utils.Logs;

import common.World;

public class Comandos 
{
	public Usuarios _user;
	public PrintWriter _out;
	
	public Comandos(Usuarios user)
	{
		this._user = user;
		this._out = _user.getGameThread().get_out();
	}
	
	public void enviarComando(String comando)
	{
		if(comando.substring(0, 3).equalsIgnoreCase("msg"))
		{
			String msg = comando.split("\\,")[1];
			SocketManager.SEND_SERVER_MSG(msg);
		}else
		if(comando.substring(0, 4).equalsIgnoreCase("tele"))
		{
			int mapa = Integer.parseInt(comando.split("\\,")[1]);
			_user.setMapa(mapa);
		}else
		if(comando.substring(0, 5).equalsIgnoreCase("alert"))
		{
			String msg = comando.split("\\,")[1];
			String param = comando.split("\\,")[2];
			SocketManager.GAME_SEND_MSG_ALL(msg, param);
		}else
		if(comando.substring(0, 5).equalsIgnoreCase("cajas"))
		{
			int boxs = 0;
			for(BonusBox cajas: _user.getMapaActual().getBonusBox().values())
				if(cajas.getMapa()==_user.getMapa())boxs++;
			Logs.info("Cajas de Bonus en el mapa: "+boxs);
		}else
		if(comando.substring(0, 6).equalsIgnoreCase("online"))
		{
			Logs.info("Usuario(s) conectado(s): "+World.getUsuariosOnline().size());
			Logs.info("Nave(s) y/o Alien(s) en el mapa: "+_user.getMapaActual().get_aliens().size());
		}else
		if(comando.substring(0, 6).equalsIgnoreCase("apagar"))
		{
			if(GameServer.activarApagado == true)
			{
				GameServer.activarApagado = false;
				GameServer.tiempoApagado = 60;
				return;
			}
			int tiempo = 60;
			if(comando.contains(","))
			{
				tiempo = Integer.parseInt(comando.split("\\,")[1]);
			}		
			SocketManager.GAME_SEND_MSG_ALL("server_restart_n_seconds", tiempo);
			GameServer.tiempoApagado = tiempo;
			GameServer.activarApagado = true;			
		}
		//Mostrar flecha
		//SocketManager.send(user, "0|UI|AR|SA|3000|1500");		
		//SocketManager.send(user, "0|UI|MM|SM|1|6500|3000|20|0"); //PING hacia objetivo
	}
}
