package net;

import game.BonusBox;
import game.Mapas;
import game.Naves;
import game.Portales;
import game.Ship;
import game.Usuarios;

import java.io.PrintWriter;

import utils.Logs;

import common.CryptManager;
import common.ServerCommands;
import common.World;


public class SocketManager {
	
    public String content;
    public static String id;

    public static void send(PrintWriter out, String packet)
    {
       if(out != null && !packet.equals("") && !packet.equals(""+(char)0x00))
        {
        	packet = CryptManager.toUtf(packet);
        	out.print((packet)+(char)0x00);
        	out.flush();
        	Logs.env(1,packet);
        }      
    }
    
    public static void send(Usuarios p, String packet)
    {
       if(p == null)return;
       if(p.getGameThread() == null)return;
       PrintWriter out = p.getGameThread().get_out();
       if(out != null && !packet.equals("") && !packet.equals(""+(char)0x00))
       {
               packet = CryptManager.toUtf(packet);
               out.print((packet)+(char)0x00);
               out.flush();
               Logs.env(1,packet);
       }
     }
    
    public static void send(Ship p, String packet)
    {
       if(p == null)return;
       if(p.getNave().getGameThread() == null)return;
       PrintWriter out = p.getNave().getGameThread().get_out();
       if(out != null && !packet.equals("") && !packet.equals(""+(char)0x00))
       {
               packet = CryptManager.toUtf(packet);
               out.print((packet)+(char)0x00);
               out.flush();
       }
     }
    
    public static void sendCommand(PrintWriter out, String packet)
    {
        if(out != null && !packet.equals("") && !packet.equals(""+(char)0x00))
        {
        	packet = CryptManager.toUtf(packet);
        	out.print((packet)+(char)0x00);
        	out.flush();
        	Logs.env(2,packet);
        }     
    }
    
	public static void REALM_SEND_POLICY_FILE(PrintWriter out)
	{
        String packet =
                "<?xml version=\"1.0\"?>\r\n" +
                "<!DOCTYPE cross-domain-policy SYSTEM \"/xml/dtds/cross-domain-policy.dtd\">\r\n" +
                "<cross-domain-policy>\r\n" +
                "<allow-access-from domain=\"*\" to-ports=\"*\" />\r\n" +
                "</cross-domain-policy>";
		send(out,packet);
	}

	public static void GAME_SEND_PONG(PrintWriter _out) {
		String packet = ServerCommands.PING;
		send(_out,packet);
	}

	public static void GAME_SEND_GAME_OVER(PrintWriter _out) {
		String packet = ServerCommands.ERROR+"|"+ServerCommands.NO_HITPOINTS;
		send(_out,packet);		
	}
	
	public static void GAME_SEND_DOUBLE_LOGGED_IN(PrintWriter _out) {
		String packet = ServerCommands.ERROR+"|"+ServerCommands.DOUBLE_LOGGED_IN;
		send(_out,packet);			
	}
	
	public static void GAME_SEND_NOT_LOGGED_IN(PrintWriter _out) {
		String packet = ServerCommands.ERROR+"|"+ServerCommands.NOT_LOGGED_IN;
		send(_out,packet);			
	}

	public static void GAME_SEND_INVALID_SESSION(PrintWriter _out) {
		String packet = ServerCommands.ERROR+"|"+ServerCommands.INVALID_SESSION;
		send(_out,packet);		
	}
	
	public static void GAME_SEND_MAP_PORTALES(PrintWriter _out, Usuarios _user) {
		//portalID|factionID|keyPortal|posX|posY|?|factionScrap
		for(Portales portal : World.getPortales())
		{
			if(_user.getMapa() == portal.getMapID())
			{
				String packet = ServerCommands.CREATE+"|"+ServerCommands.CREATE_PORTAL+"|"+portal.getID()+"|"+
				portal.getFactionID()+"|"+portal.getKeyPortal()+"|"+portal.getPosX()+"|"+portal.getPosY()+
				"|1|"+portal.getFactionScrap();
				send(_out, packet);
			}
			
		}	
	}
	
	public static void GAME_SEND_INFO_USER(Usuarios user) {
		//ID del user|Nombre?|naveID|vel|escudoMin|escudoMax|hpMin|hpMax|cargaMin|cargaMax|pos1|pos2|
		//mapaID|factionID(empresa?)|clanID|maxLaser|maxMisil|expansion(lookArmas)|premium|experiencia|honor|
		//nivel|creditos|uridiums|jackpot|rango?|tituloClan|galaxyGatesFin(estrellitas)|Invisibilidad
		long honor = user.getHonor();
		int rango = user.getRango();
		if(honor <= -500)rango = 22;
		String packet = "RDY|"+ServerCommands.HERO_INIT+"|"+user.getId()+"|"+user.getUsuario()+"|"+
		user.getGfx()+"|"+user.getVel()+"|"+user.getEscudo()+"|"+user.getEscudoMax()+"|"+
		user.getHp()+"|"+user.getHpMax()+"|"+user.getCarga()+"|"+user.getCargaMax()+"|"+user.getPos()+"|"+
		user.getMapa()+"|"+user.getEmpresa()+"|"+user.getClan()+"|"+Naves.getMaxLaserCapacidad(user.getNave())+"|"+
		Naves.getMaxMisilCapacidad(user.getNave())+"|"+3+"|"+user.getPremium()+"|"+
		user.getExperiencia()+"|"+honor+"|"+user.getNivel()+"|"+user.getCreditos()+"|"+
		user.getUridium()+"|"+user.getJackpot()+"|"+rango+"|"+user.getTagClan()+"|"+user.getGG()+"|1|"+user.getInvisible();
		send(user,packet);		
	}
	
	
	public static void GAME_SEND_INFO_SHIPS(PrintWriter _out, int userID, Mapas mapa) 
	{
		//id|idNave
		if(mapa.getShip(userID) == null)return;
		Ship user = mapa.getShip(userID);		
		int posX =  user.getPosX();
		int posY = user.getPosY();
		String empresa = user.getNave().getEmpresa();
		int clanDiplomacy = 0; //0: Aliado | 1: Alianza | 2: Paz | 3: Enemigos
		int warnIconOnMap = user.isWarnIconOnMap()==true?1:0; //0: No | 1: Si
		int isNPC = user.getIsNPC()==true?1:0;//0: No | 1: Si
		long honor = user.getNave().getHonor();
		int rango = user.getNave().getRango();
		if(honor <= -500)rango = 22;
		send(_out, "f|C|"+user.getId()+"|"+user.getGfx()+"|3|"+user.getNave().getTagClan()+"|"+
		user.getNombre()+"|"+posX+"|"+posY+"|"+empresa+"|"+user.getNave().getClan()+"|"+rango+
		"|"+warnIconOnMap+"|"+clanDiplomacy+"|"+user.getNave().getGG()+"||"+isNPC+"|"+user.getNave().getInvisible());	
		send(_out, "0|n|INV|"+user.getId()+"|"+user.getNave().getInvisible());
		send(_out, "0|n|d|"+user.getId()+"|"+user.getNave().getVants());						
	}
	
	public static void GAME_SEND_MOVE_SHIP(PrintWriter _out, Usuarios _user) {
		//ID del user|pos|vel
		String packet = "";
		for(Usuarios user : World.getUsuariosOnline())
		{			
			if(user.getMapa() == _user.getMapa() && _user != user)
			{
				packet = "0|1|"+user.getId()+"|"+user.getPos()+"|"+user.getVel();
				send(_user.getShip(),packet);
			}
		}			
	}
	
	
	public static void SHIP_SEND_LASER_ATTACK_TO_ALIEN(Mapas mapa, Usuarios lanzador, Ship enemigo, int tipoLaser, int efectoEscudo, int laserGrueso)
	{	
		for(Ship users: mapa.getShips().values())
		{
			String packet = "0|a|"+lanzador.getId()+"|"+enemigo.getId()+"|"+tipoLaser+"|"+efectoEscudo+"|"+laserGrueso;
			if(users.getIsNPC()==false)send(users.getNave(),packet);
		}
	}
	
	public static void SHIP_SEND_LASER_ATTACK(Mapas mapa, Usuarios lanzador, Ship enemigo, int tipoLaser, int efectoEscudo, int laserGrueso)
	{	
		for(Ship users: mapa.getShips().values())
		{
			String packet = "0|a|"+lanzador.getId()+"|"+enemigo.getId()+"|"+tipoLaser+"|"+efectoEscudo+"|"+laserGrueso;
			if(users.getIsNPC()==false)send(users.getNave(),packet);
		}
	}
	
	public static void GAME_SEND_DESTROY_SHIP(int id) 
	{
		String packet = "0|K|"+id;
		for(Usuarios users : Mapas.getNaves())send(users,packet);	
	}
	
	public static void GAME_SEND_DESCONEXION_USER(Usuarios _user) 
	{
		for(Usuarios user : World.getUsuariosOnline())
		{
			if(user.getMapa() == _user.getMapa())
			{
				String packet = "0|"+ServerCommands.REMOVE_SHIP+"|"+_user.getId();
				send(user,packet);	
			}
		}
	}
	
	public static void GAME_SEND_MAP_ALIENS(Mapas mapa) 
	{
		//id|idNave	
		System.out.println("****** : Mapa: "+mapa);
		for(Ship aliens: mapa.get_aliens().values())
		{
			if(aliens.getId() < 0)
			{
				if(mapa.getShip(aliens.getId()) == null)return;
				Ship alien = mapa.getShip(aliens.getId());
				int posX =  alien.getPosX();
				int posY = alien.getPosY();
				int clanDiplomacy = 3; //0: Aliado | 1: Alianza | 2: Paz | 3: Enemigos
				int warnIconOnMap = 0; //0: No | 1: Si
				int isNPC = 1;//0: No | 1: Si
				int rango = 0;
				String packet = "f|C|"+alien.getId()+"|"+alien.getGfx()+"|0|"+""+"|"+
				alien.getNombre()+"|"+posX+"|"+posY+"||-1|"+rango+
				"|"+warnIconOnMap+"|"+clanDiplomacy+"|"+0+"||"+isNPC+"|0";
				alien.setPlay(true);
				alien.setDead(false);
				for(Usuarios users : Mapas.getNaves())send(users,packet);
			}
		}						
	}

	public static void GAME_SEND_INFO_ALIENS(Mapas mapa, int alienID) 
	{
		//id|idNave
		if(mapa.getShip(alienID) == null)return;
		Ship alien = mapa.getShip(alienID);
		int posX =  alien.getPosX();
		int posY = alien.getPosY();
		int clanDiplomacy = 3; //0: Aliado | 1: Alianza | 2: Paz | 3: Enemigos
		int warnIconOnMap = 0; //0: No | 1: Si
		int isNPC = 1;//0: No | 1: Si
		int rango = 0;
		String packet = "f|C|"+alien.getId()+"|"+alien.getGfx()+"|0|"+""+"|"+
		alien.getNombre()+"|"+posX+"|"+posY+"||-1|"+rango+
		"|"+warnIconOnMap+"|"+clanDiplomacy+"|"+0+"||"+isNPC+"|0";
		alien.setPlay(true);
		alien.setDead(false);
		for(Usuarios users : Mapas.getNaves())send(users,packet);						
	}
	
	public static void CREATE_BONUSBOX_ALIEN(Ship alien, Usuarios user) 
	{
		String boxID = "bxa"+alien.getNpc().getId();
		int estado = 1; //0: no accesible | 1: accesible
		String packet = "0|c|"+boxID+"|"+estado+"|"+alien.getPosX()+"|"+alien.getPosY();
		for(Usuarios users : Mapas.getNaves())send(users,packet);				
	}
	
	public static void CREATE_BONUSBOX_MAP() 
	{
		//EJ: 0|c|1q2u6|2|4406|2151
		for(Mapas mapa: World.getMapas())
		{
			for(BonusBox box: mapa.getBonusBox().values())
			{			
				for(Usuarios users : World.getUsuariosOnline())
				{
					if(box.getMapa() == users.getMapa() && box.getUser() == null)
					{						
						String packet = "0|c|"+box.getId()+"|"+box.getTipo()+"|"+box.getPosX()+"|"+box.getPosY();
						send(users,packet);
					}
				}			
			}	
		}
			
	}
	
	public static void DEL_BONUSBOX_MAP(String gift)
	{
		String packet = "0|2|"+gift;
		for(Usuarios users : Mapas.getNaves())send(users,packet);				
	}
	
	public static void SEND_MINIMAP_ALERT(int alerta)
	{
		String packet = "0|n|w|"+alerta;
		for(Usuarios users : Mapas.getNaves())send(users,packet);				
	}
	
	public static void GAME_SEND_MSG_CHAT(PrintWriter _out, int canal, Usuarios _user, String mensaje) 
	{
		String packet =  "a%"+canal+"@"+_user.getUsuario()+"@"+mensaje+_user.getTagClan()+"#";
		for(Usuarios users : World.getUsuariosOnline())sendCommand(users.getChatThread().get_out(),packet);			
	}
	
	public static void GAME_SEND_MSG_CHAT_ADMIN(PrintWriter _out, int canal, Usuarios _user, String mensaje) 
	{
		String packet =  "j%"+canal+"@"+_user.getUsuario()+"@"+mensaje+3+"#";
		for(Usuarios users : World.getUsuariosOnline())sendCommand(users.getChatThread().get_out(),packet);			
	}
	
	public static void GAME_SEND_MSG_ALL(String mensaje, Object param) 
	{
		String packet =  "0|A|STM|"+mensaje+"|"+param;
		for(Usuarios users : World.getUsuariosOnline())send(users,packet);			
	}
	
	public static void SEND_SERVER_MSG(String mensaje) 
	{
		String packet =  "0|A|STD|"+mensaje;
		for(Usuarios users : World.getUsuariosOnline())send(users,packet);		
	}

	public static void SHIP_SEND_LASER_EFFECT_TO_ALIEN(Usuarios user,
			Ship enemigo, int dmgHP, int dmgESC) 
	{
		String packet = "0|Y|"+user.getId()+"|"+enemigo.getId()+"|L|"+enemigo.getHp()+"|"+
				enemigo.getEsc()+"|"+dmgHP+"|"+dmgESC;
		send(user,packet);		
	}
	public static void MOVE_ALIEN(Ship alien, int vel) {
		//ID|pos|vel
		for(Usuarios users : Mapas.getNaves())
		{			
			String packet = "0|1|"+alien.getId()+"|"+alien.getPosX()+"|"+alien.getPosY()+"|"+vel;
			send(users.getShip(),packet);
		}			
	}

     
}