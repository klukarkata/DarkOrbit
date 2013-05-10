package net;

import game.BonusBox;
import game.Mapas;
import game.NPC;
import game.Portales;
import game.Ship;
import game.Usuarios;
import game.objetos.Objeto;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.Timer;
import java.util.TimerTask;

import utils.Formulas;
import utils.Logs;

import common.ClientCommands;
import common.CryptManager;
import common.DarkOrbit;
import common.SQLManager;
import common.ServerCommands;
import common.World;

import darkorbit.Comandos;

public class GameThread implements Runnable
{
	private BufferedReader _in;
	private Thread _t;
	private PrintWriter _out;
	private Socket _s;
	private Usuarios _user;
	int contador = 0;
	public int userID;
	public String sesionID;
	public String version;
	public int _packetNum = 0;
	private Timer tPortal;
	private Comandos comandos;
	
	public GameThread(Socket sock)
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
		    		if(_user != null)Logs.recv(1,"(ID:"+_user.getId()+",SIZE:"+packet.length()+") < "+packet);
		    		_packetNum++;
		    		System.out.println(packet);
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
	    			_user.setGameThread(null);
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
		
		
		
		System.out.println(packet);
		if(_user != null) {
			_user.refreshLastPacketTime();
		}
		if(packet.equals("<policy-file-request/>"))
		{
			SocketManager.REALM_SEND_POLICY_FILE(_out);
		}
		
		int tPacket = packet.length();
		switch(tPacket)
		{	
			case 1:
				//ACCIONES
				if(packet.equals(ClientCommands.PORTAL_JUMP))
				{
					usarPortal();
				}
				if(packet.equals(ServerCommands.LOGOUT))
				{
					_user.isLogout = true;
					_user.tAccionLogout = 5;
				}
				if(packet.equals(ServerCommands.LOGOUT_CANCEL_FROM_CLIENT))
				{
					_user.isLogout = false;
					_user.tAccionLogout = 5;
					SocketManager.send(_user, "0|t");
				}
				if(packet.equals(ServerCommands.GET_ORE_PRICES))
				{
					parsePreciosVenta(packet);
				}
			break;
			
			case 3:
				if(packet.equalsIgnoreCase(ServerCommands.PING))
				{
					
					SocketManager.GAME_SEND_MAP_ALIENS(_user.getMapaActual());
				}
				if(packet.substring(0, 1).equals(ServerCommands.REQUEST_SHIP))
				{
					int userID = Integer.parseInt(packet.split("\\|")[1]);
					if(userID > 0)
					{
						SocketManager.GAME_SEND_INFO_SHIPS(_user.getGameThread().get_out(), userID, _user.getMapaActual());
					}else{
						SocketManager.GAME_SEND_INFO_ALIENS(_user.getMapaActual(), userID);
					}				
				}
				if(packet.substring(0, 1).equals(ClientCommands.SELECT_LASER))
				{
					int laserID = Integer.parseInt(packet.split("\\|")[1]);
					_user.setLaser1(laserID);
				}
				if(packet.substring(0, 1).equals(ServerCommands.LASER_ATTACK))
				{
					parseAttackLaser(packet);					
				}
				if(packet.substring(0, 1).equals(ServerCommands.ROCKET_ATTACK))
				{
					parseAttackRocket(packet);
				}
			break;
			
			case 4:
				if(packet.substring(0, 1).equals(ServerCommands.LASER_ATTACK))
				{
					parseAttackLaser(packet);					
				}
				if(packet.substring(0, 1).equals(ServerCommands.ROCKET_ATTACK))
				{
					parseAttackRocket(packet);
				}
				if(packet.substring(0, 1).equals(ServerCommands.REQUEST_SHIP))
				{
					int userID = Integer.parseInt(packet.split("\\|")[1]);
					if(userID > 0)
					{
						SocketManager.GAME_SEND_INFO_SHIPS(_user.getGameThread().get_out(), userID, _user.getMapaActual());
					}else{
						SocketManager.GAME_SEND_INFO_ALIENS(_user.getMapaActual(), userID);
					}				
				}
			break;
			
			default:
				
				if(packet.substring(0, 5).equalsIgnoreCase("LOGIN"))
				{
					userSecurity(packet);
				}
				
				if(packet.substring(0, 4).equalsIgnoreCase("APZ"))
				{
					System.out.println("Sebas112665566");
				}
				if(packet.substring(0, 3).equalsIgnoreCase("APZ"))
				{
					System.out.println("cristianasdasdasd2");
				}
				//Actualizar Mapa y Posicion del jugador
				if(packet.substring(0, 1).equals(ServerCommands.SHIP_MOVEMENT))
				{
					parseShipMovement(packet);
				}
				if(packet.equals("RDY|MAP"))
				{
					crearEstaciones();
					cargarPortales();
					SocketManager.GAME_SEND_MAP_ALIENS(_user.getMapaActual());
					SocketManager.CREATE_BONUSBOX_MAP();
					SocketManager.SEND_MINIMAP_ALERT(_user.getMapaActual().getAlertaEnemigos());					
				}
				if(packet.substring(0, 3).equalsIgnoreCase("cmd"))
				{
					String comando = packet.split("\\|")[1];
					if(comandos == null) comandos = new Comandos(_user);
					comandos.enviarComando(comando);
				}
				if(packet.substring(0, 5).equals("S|CFG"))
				{
					parseShipConfig(packet);
				}
				if(packet.substring(0, 1).equals(ClientCommands.COLLECT_BOX))
				{
					parseCollectBox(packet);
				}
				if(packet.substring(0, 3).equals(ClientCommands.SELECT_SHIP))
				{					
					parseSelectShip(packet);					
				}
				if(packet.substring(0, 1).equals(ServerCommands.LASER_ATTACK))
				{
					parseAttackLaser(packet);					
				}
				if(packet.substring(0, 1).equals(ServerCommands.ROCKET_ATTACK))
				{
					parseAttackRocket(packet);
				}				
				if(packet.substring(0, 5).equals("S|ROB"))
				{
					if(_user.getHp() == _user.getHpMax())
					{
						SocketManager.send(_user, "0|A|RS|0");
						SocketManager.send(_user, "0|A|HPT|"+_user.getHp()+"|"+_user.getHpMax());
						return;
					}
					SocketManager.send(_user, "0|A|RS|1");
					long hp = _user.getHp()+500;
					_user.setHp(hp);
					SocketManager.send(_user, "0|A|HPT|"+hp+"|"+_user.getHpMax());
					if(_user.getHp() >= _user.getHpMax())
					{
						_user.setHp(_user.getHpMax());
						SocketManager.send(_user, "0|A|RS|0");
					}				
				}
				if(packet.equals("ps|blk"))
				{
					if(_user.permitirGrupo == 1)
					{
						_user.permitirGrupo = 0;
					}else{
						_user.permitirGrupo = 1;
					}
					SocketManager.send(_user, "0|ps|blk|"+_user.permitirGrupo);
				}
				if(packet.substring(0, 1).equals(ServerCommands.REQUEST_SHIP))
				{
					int userID = Integer.parseInt(packet.split("\\|")[1]);
					if(userID > 0)
					{
						SocketManager.GAME_SEND_INFO_SHIPS(_user.getGameThread().get_out(), userID, _user.getMapaActual());
					}else{
						SocketManager.GAME_SEND_INFO_ALIENS(_user.getMapaActual(), userID);
					}				
				}
				break;
		}	
	}
	
	private void userSecurity(String myUser) {
		int luserID = Integer.parseInt(myUser.split("\\|")[1]);
		SQLManager.NUEVO_USUARIOS(luserID);
		SQLManager.NUEVOS_SETTINGS(luserID);

		parseLogin(myUser);
	}

	private void parsePreciosVenta(String packet) 
	{
		/** ZONA DE VENTAS **/
		long honor = _user.getHonor();
		if(honor>500000)honor = 500000;
		SocketManager.send(_user, "0|g|"+Formulas.getPrecioVentas(honor));		
	}

	/** LOGIN **/
	private void parseLogin(String packet) 
	{
		
	
		userID = Integer.parseInt(packet.split("\\|")[1]);
		sesionID = packet.split("\\|")[2];
		version = packet.split("\\|")[3];
		SQLManager.NUEVO_USUARIOS(userID);
		SQLManager.NUEVOS_SETTINGS(userID);
		if(World.getUsuarioByID(userID) == null)
		{			
			SocketManager.GAME_SEND_NOT_LOGGED_IN(_out);
			return;
		}
		_user = World.getUsuarioByID(userID);
		System.out.println(World.getUsuarioByID(userID)+" ***********");
		if(_user != null)
		{			
			if(sesionID != "" || sesionID != null)
			{	
				if(_user.getSessionID() == null)
				{
					_user.setSessionID(sesionID);
				}else
				{
					SocketManager.GAME_SEND_DOUBLE_LOGGED_IN(_out);
					System.out.println("out");
					return;
				}
				//Comprobamos que no este ya conectado
				if(_user.isOnline() && _user.getGameThread() != null)
				{
					Logs.error("Ya esta conectado: "+_user.getUsuario());
					SocketManager.GAME_SEND_DOUBLE_LOGGED_IN(_out);
					System.out.println("dblr");
					return;
				}
				//Si la nave no tiene vida
				if(_user.getHp() <= 0)
				{
					SocketManager.GAME_SEND_GAME_OVER(_out);
					return;
				}
				_user.setGameThread(this);
				_user.getMapaActual().addNave(_user.getId());
				try {
					cargarDatos(_user);
				} catch (Exception e){
					cargarDatos(_user);
				}
			}else{
				SocketManager.GAME_SEND_INVALID_SESSION(_out);
				System.out.println("asdsad");
				return;
			}		
		}		
	}
	/** FIN LOGIN **/
	
	private void parseShipConfig(String packet) 
	{
		int nuevaConfig = Integer.parseInt(packet.split("\\|")[2]);
		if(_user.tAccionConfig != 0)
		{
			SocketManager.send(_user, "0|A|STM|config_change_failed_time");
			return;
		}
		SocketManager.send(_user, "0|A|CC|"+nuevaConfig);
		_user.tAccionConfig = 5;
	}
	
	private void parseCollectBox(String packet) 
	{
		String gift = packet.split("\\|")[1];
		if(gift == null)
		{
			SocketManager.send(_user, "0|"+ServerCommands.BOX_DISABLED);
			return;
		}
		//Bonus de Aliens
		if(gift.substring(0,3).equals("bxa"))
		{
			int alienID = Integer.parseInt(gift.substring(3));
			if(World.getNPC(alienID)==null)return;
			NPC alien = World.getNPC(alienID);
			SocketManager.send(_user, "0|LM|ST|CAR|"+alien.getPrometium()+"|"+alien.getEndurium()+"|"+
			alien.getTerbium()+"|"+alien.getXenomit()+"|"+alien.getPrometid()+"|"+alien.getDuranium()+
			"|"+alien.getPromerium());
		}else{
			Formulas.getGifts(_user);
		}
		//SocketManager.send(_user, "0|LM|ST|BAT|5|5"); //5 de municion de SAB-50 (1q2u6)
		for(BonusBox box: _user.getMapaActual().getBonusBox().values())if(box.getId().equals(gift))box.setUser(_user);
		SocketManager.DEL_BONUSBOX_MAP(gift);
	}
	
	private void parseSelectShip(String packet) 
	{
		int userID = Integer.parseInt(packet.split("\\|")[1]);
		Ship enemigo = null;
		if(World.getUsuarioByID(userID) != null)
		{
			enemigo = _user.getMapaActual().getShip(userID);
			SocketManager.send(_out, "0|"+ServerCommands.SHIP_SELECTED+"|"+userID+"||"+
					enemigo.getNave().getEscudo()+"|"+enemigo.getNave().getEscudoMax()+"|"+
					enemigo.getNave().getHp()+"|"+enemigo.getNave().getHpMax()+"|1");
		}else{
			enemigo = _user.getMapaActual().getShip(userID);
			SocketManager.send(_out, "0|"+ServerCommands.SHIP_SELECTED+"|"+userID+"||"+
					enemigo.getNpc().getEsc()+"|"+enemigo.getNpc().getEsc()+"|"+
					enemigo.getNpc().getPv()+"|"+enemigo.getNpc().getPv()+"|0");
		}		
	}
	
	private void parseAttackLaser(String packet) 
	{
		int userID = Integer.parseInt(packet.split("\\|")[1]);
		if(_user.getMapaActual().getShip(userID) != null)
		{
			Ship user = _user.getShip();
			Ship enemigo = _user.getMapaActual().getShip(userID);
			if(enemigo.isNPC() == false)
			{
				parseAttackLaserToShip(user,enemigo);
			}else
			{
				parseAttackLaserToAlien(user,enemigo);
			}
			
		}	
	}

	private void parseAttackLaserToAlien(Ship user, Ship enemigo)
	{
		int tipoLaser = user.getNave().getLaser1() - 1;
		if(tipoLaser == 5)tipoLaser = 6;
		int dmg = 500;
		int dmgESC = dmg;
		switch(user.getNave().getLaser1())
		{
			case 2:
				dmg *= 2;
				break;
			case 3:
				dmg *= 3;
				break;
			case 4:
				dmg *= 4;
				break;
			case 6:
				dmg *= 5;
				break;
		}
		int dmgPV = dmg/2;
		if(user.getNave().getLaser1()==5)
		{
			dmgESC = dmg/2;
			dmg=0;
			dmgPV=0;
		}				
		SocketManager.SHIP_SEND_LASER_ATTACK_TO_ALIEN(user.getNave().getMapaActual(), user.getNave(), enemigo, tipoLaser, 0, 1);
		enemigo.setTarget(user);
		enemigo.setHp(enemigo.getHp()-dmgPV);
		enemigo.setEsc(enemigo.getEsc()-dmgESC);
		if(enemigo.getHp() <= 0)
		{	
			getBonusAlien(user.getNave(),enemigo);
			enemigo.setHp(enemigo.getNpc().getPv());
			enemigo.setEsc(enemigo.getNpc().getEsc());
			enemigo.setPlay(false);
			enemigo.setDead(true);
			SocketManager.GAME_SEND_DESTROY_SHIP(enemigo.getId());		
		}
		if(enemigo.getEsc() < 0)enemigo.setEsc(0);
		//LANZADOR|ENEMIGO|EFECTO(H:cura, resto: daña)|vidaActual|escudoActual|dañosHp|dañosEsc|?
		SocketManager.SHIP_SEND_LASER_EFFECT_TO_ALIEN(user.getNave(),enemigo,dmg,dmgESC);		
	}

	private void parseAttackLaserToShip(Ship user, Ship enemigo)
	{
		int tipoLaser = user.getNave().getLaser1() - 1;
		if(tipoLaser == 5)tipoLaser = 6;
		//LANZADOR|ENEMIGO|LASER|efectoEscudoRival|laserGrueso
		SocketManager.SHIP_SEND_LASER_ATTACK(user.getNave().getMapaActual(), user.getNave(), enemigo, tipoLaser, 0, 1);
		//LANZADOR|ENEMIGO|EFECTO(H:cura, resto: daña)|vidaActual|escudoActual|dañosHp|dañosEsc|?
		SocketManager.send(user.getNave(), "0|Y|"+user.getId()+"|"+enemigo.getId()+"|L|"
		+enemigo.getNave().getHp()+"|"+enemigo.getNave().getEscudo()+"|500|100|1");
		SocketManager.send(enemigo.getNave(), "0|a|"+user.getId()+"|"+enemigo.getId()+"|"+tipoLaser+"|0|1");
		SocketManager.send(enemigo.getNave(), "0|Y|"+user.getId()+"|"+enemigo.getId()+"|L|"+enemigo.getNave().getHp()+
				"|"+enemigo.getNave().getEscudo()+"|500|100|1");	
	}

	private void getBonusAlien(Usuarios user,Ship alien) 
	{
		boolean levelUp = false;
		long xpLv = 0;
		int nivel = user.getNivel()+1;
		long exp = alien.getNpc().getExp();
		long hon = alien.getNpc().getHon();
		long cred = alien.getNpc().getCre();
		long uri = alien.getNpc().getUri();		
		user.setExperiencia(user.getExperiencia()+exp);
		user.setHonor(user.getHonor()+hon);
		user.setCreditos(user.getCreditos()+cred);
		user.setUridium(user.getUridium()+uri);
		xpLv = Formulas.getXpNecesaria(nivel);
		if(user.getExperiencia() > xpLv && user.getNivel()<32)
		{
			user.setNivel(nivel);
			levelUp = true;
		}
		SocketManager.send(user, "0|LM|ST|EP|"+exp+"|"+user.getExperiencia()+"|"+user.getNivel());
		SocketManager.send(user, "0|LM|ST|HON|"+hon+"|"+user.getHonor());
		SocketManager.send(user, "0|LM|ST|CRE|"+cred+"|"+user.getCreditos());
		SocketManager.send(user, "0|LM|ST|URI|"+uri+"|"+user.getUridium());
		if(levelUp==true)
			SocketManager.send(user, "0|A|LUP|"+nivel+"|"+Formulas.getXpNecesaria(nivel+1));
		levelUp = false;
		SocketManager.CREATE_BONUSBOX_ALIEN(alien, user);
		//SQLManager.ACTUALIZAR_DATOS_USUARIO(user);
	}

	private void parseAttackRocket(String packet) 
	{
		int userID = Integer.parseInt(packet.split("\\|")[1]);
		//LANZADOR|ENEMIGO|acierto(H)|idMisil|habilidadMisil|lanzaMisil
		SocketManager.send(_out, "0|v|"+_user.getId()+"|"+userID+"|H|1|0|0");
		//LANZADOR|ENEMIGO|EFECTO(H:cura, resto: daña)|?|?|dañosHp|dañosEsc
		SocketManager.send(_out, "0|Y|"+_user.getId()+"|"+userID+"|R|2500|25000|500|100|1");		
	}
	
	private void parseShipMovement(String packet) 
	{
		if(_user.isOnline() && _user.getGameThread() != null && _user.usaPortal == false)
		{
			//1|1839|1341|1842|1419 ---> 1|nuevaPosX|nuevaPosY|actualPosX|actualPosY
			int newPosX = Integer.parseInt(packet.split("\\|")[1]);
			int newPosY = Integer.parseInt(packet.split("\\|")[2]);
			int actualPosX = Integer.parseInt(packet.split("\\|")[3]);
			int actualPosY = Integer.parseInt(packet.split("\\|")[4]);
			String posNueva = newPosX+"|"+newPosY;
			_user.setPos(posNueva);
			_user.setOldPosX(actualPosX);
			_user.setOldPosY(actualPosY);
			_user.getShip().setMoviendo(true);
			SQLManager.ACTUALIZAR_POSICION_USUARIO(_user);
			calcularMovimientos(_user, actualPosX, actualPosY);					
		}	
	}
	
	private void calcularMovimientos(Usuarios user, int posX, int posY) 
	{		
		int mapaActual = _user.getMapa();
		int seccionUser = Mapas.getSeccionID(mapaActual, posX, posY);
		int ext = 500;
		//[posX|posY] (Posicion cursor)|Delimitar zona|Permite recuperarse|Zona de venta|Zona de radiacion|Zona de teleportacion|Cantidad de teletransporte
		//SocketManager.send(user, "0|D|10400|6400|0|1|0|0|1|50"); //Defecto
		if(posX < 0 || posY < 0 || posX > 20800 || posY > 12800)
		{		
			_user.getShip().setZonaRadiactiva(true);
			_user.getShip().addShipDamageRadiacion();			
			return;
		}
		_user.getShip().setZonaRadiactiva(false);
		_user.getShip().setZonaSegura(false);
		for(Portales portal : World.getPortales())
		{			
			int seccionPortal = Mapas.getSeccionID(portal.getMapID(), portal.getPosX(), portal.getPosY());
			if(mapaActual == portal.getMapID() && seccionUser == seccionPortal)
			{			
				int portalX = portal.getPosX() + ext;
				int portalY = portal.getPosY() + ext;
				int portalX2 = portal.getPosX() - ext;
				int portalY2 = portal.getPosY() - ext;
				if(posX >= portalX2 && posX <= portalX)
				{
					if(posY >= portalY2 && posY <= portalY)
					{
						_user.getShip().setZonaSegura(true);						
					}
				}
			}
		}
		_user.getShip().updateShipMovement();
	}

	private void usarPortal()
	{
		int mapaActual = _user.getMapa();
		//int posX = Integer.parseInt(_user.getPos().split("\\|")[0]);
		//int posY = Integer.parseInt(_user.getPos().split("\\|")[1]);
		int posX = _user.getOldPosX();
		int posY = _user.getOldPosY();
		int ext = 500;
		int seccionUser = Mapas.getSeccionID(mapaActual, posX, posY);
		boolean errorSalto = true;
		for(Portales portal : World.getPortales())
		{			
			int seccionPortal = Mapas.getSeccionID(portal.getMapID(), portal.getPosX(), portal.getPosY());
			if(mapaActual == portal.getMapID() && seccionUser == seccionPortal)
			{			
				int portalX = portal.getPosX() + ext;
				int portalY = portal.getPosY() + ext;
				int portalX2 = portal.getPosX() - ext;
				int portalY2 = portal.getPosY() - ext;
				if(posX >= portalX2 && posX <= portalX)
				{
					if(posY >= portalY2 && posY <= portalY)
					{
						if(_user.getNivel() < portal.getReqNivel())
						{
							SocketManager.send(_user, "0|"+ServerCommands.JUMP_FAILED+"|"+portal.getReqNivel());
							return;
						}else{
							_user.usaPortal = true;
							SocketManager.send(_user, "0|"+ServerCommands.PLAY_PORTAL_ANIMATION+"|"+portal.getToMapID()+"|"+portal.getID());
							_user.setMapa(portal.getToMapID());
							_user.setPos(portal.getToPos());
							_user.tPortal = 3;
							errorSalto = false;
							tPortal = new Timer();
							tPortal.schedule(new TimerTask()
							{
								public void run()
								{
									_user.tPortal--;
									if(_user.tPortal == 0 && _user.usaPortal == true)
									{	
										SQLManager.ACTUALIZAR_POSICION_USUARIO(_user);
										cargarDatos(_user);
										tPortal.cancel();
										_user.usaPortal = false;
									}
								}
							}, 0,1000);							
							return;
						}
					}
				}
			}			
		}if(errorSalto)SocketManager.send(_user, "0|A|STM|jumpgate_failed_no_gate");	
		
	}

	private void cargarDatos(Usuarios user)
	{
		/** CONFIGURACION DE CLIENTE **/
		cargarConfigCliente(user);
		
		/** DATOS USUARIO & NAVE **/						
		SocketManager.GAME_SEND_INFO_USER(user);
		/** MAP_READY_HANDSHAKE **/
		SocketManager.send(user, "0|7|HS");
		
		//Configuracion actual
		SocketManager.send(user, "0|S|CFG|1");
		
		/** MUNICION LASER **/
		//LCB-10(x1)|MCB-25(x2)|MCB-50(x3)|UCB-100(x4)|SAB-50(roba escudo)|RSB-75(x5)
		SocketManager.send(user, "0|"+ServerCommands.PRIMARY_WEAPON_INFO+"|"+user.getMun1());
		/** MUNICION MISILES **/
		//R-310|PLT-2026|PLT-2021|PLT-3030|PLD-8|DCR-250|WIZ-X
		/** MUNICION MINAS **/
		//|ACM-01|SMB-01|ISH-01|EMP-01|EMPM-01|SABM-01|DDM-01
		SocketManager.send(user, "0|"+ServerCommands.SECONDARY_WEAPON_INFO+"|"+user.getMun2());
		/** MUNICION LANZAMISILES **/
		String[] lanzamisiles = user.getMun3().split("\\;");
		SocketManager.send(user, "0|A|FWX|INL|"+lanzamisiles[0]);
		SocketManager.send(user, "0|A|FWX|FWL|"+lanzamisiles[1]);
		SocketManager.send(user, "0|RL|R|"+lanzamisiles[2]);
		/** CARGAR TITULO **/
		SocketManager.send(user, "0|"+ServerCommands.MAP_EVENT+"|t|"+user.getId()+"|"+user.getTitulo());
		/** BONOS DE TELEPORTACION **/
		SocketManager.send(user, "0|A|JV|"+user.getBono_teleportacion());
		/** LLAVES DE BOTIN DISPONIBLES **/
		SocketManager.send(user, "0|A|BK|"+user.getLlaves());
		/** CARGAR DRONES **/
		//ID|posicion(/:derecha,//:abajo,///:izquierda,////:arriba)cantidad-(1:flax,2:iris)-(nivel),...
		SocketManager.send(user, "0|n|d|"+user.getId()+"|"+user.getVants());
		/** EXTRAS **/
		//CPU REPARADOR VANTS(1-2)|CPU TRANSPORTE(1)|CPU de transporte JP01|CPU de compra de municion|
		//Robot de reparacion(1-4)|Vant comercial HM7|?|?|?|?|Vant ayuda contra objetivo|CPU misil auto
		//|CPU camuflaje|CPU auto lanzamisil|CPU compra de misiles|CPU teletrans activado|?
		SocketManager.send(user, "0|A|ITM|0|0|0|0|4|1|0|0|0|0|0|0|0|0|0|0|0");
		/** TIENDA DE COMPRA AUTOMATICA **/
		SocketManager.send(user, "0|g|a|b,1000,1,10000,C,2,500,U,3,1000,U,5,1000,U|r,100,1,10000,C,2,50000,C,3,500,U,4,700,U");
		/** TECNOLOGIAS **/
		//estado|cantidad|tiempo?
		SocketManager.send(user, "0|TX|S|1|15|0|1|15|0|1|15|0|1|15|0|1|15|0");
		/** ADVANCED_JUMP_CPU **/
		//SocketManager.send(user, "0|A|JCPU|I|-1|1;5;20;24;|850|2;3;4;6;7;8;9;10;11;12;|375|17;19;18;21;23;22;|100|13;14;15;27;26;|175|29;|125|25;|225|16;");
		/** LOGROS **/
		//SocketManager.send(user, "0|ach|set|1|1|3|2|0|0|3|0|3|4|0|0|5|0|3|6|0|0|7|0|0|8|0|3|9|0|0|10|0|0|11|0|0|12|0|0");
		/** ofertas especiales **/
		//SocketManager.send(user, "0|A|SON");
		/** MINERALES **/
		cargarMinerales(user);
		//Objetivos ? //SocketManager.send(user, "0|CRE|AST|1|1||redStation|||1500|1000|1");
		/** PET **/
		//REPARAR|ESTADO|FUEL
		SocketManager.send(user, "0|PET|I|0|1|1");
		//?|idPet|propietario|Nombre|empresa|?|?|clanTag|0(normal|1:aliado|2:alianza|3:enemigo)
		//SocketManager.send(user, "0|PET|L|1|3|2|Pet_admin|2|0|5|ADM|0|707|448|0");
		/** SISTEM DE GRUPOS**/
		SocketManager.send(user, "0|ps|blk|0");
		/** JCPU **/
		//Solo si se recibe JCPU|GET
		//SocketManager.send(user, "0|A|JCPU|I|-1|1;5;20;24;");
		SocketManager.send(user, "0|m|"+user.getMapa()+"|"+user.getPos());
		SocketManager.send(user, "0|POI|RDY");
	}
	
	private void cargarMinerales(Usuarios user) 
	{
		/** MINERALES **/
		//PROMETIUM|ENDURIUM|TERBIUM|XENOMIT|PROMETID|DURANIUM|PROMERIUM|SEPROM|PALLADIUM
		//SocketManager.send(user, "0|E|"+100+"|150|200|250|300|300|500|100|30");
		SocketManager.send(user, "0|E|"+100+"|150|200|250|300|300|500|100|30");
		for(Objeto obj: user.getInventario().getObjetos())
		{
			Logs.info("Hay:" +obj.getRecursos().size());
		}
	}

	private void cargarConfigCliente(Usuarios user) {
		SocketManager.send(user, "0|A|SET|"+user.getUserSetting().SET);
		SocketManager.send(user, "0|7|MINIMAP_SCALE,1|"+user.getUserSetting().MINIMAP_SCALE);
		SocketManager.send(user, "0|7|DISPLAY_PLAYER_NAMES|"+user.getUserSetting().DISPLAY_PLAYER_NAMES);
		SocketManager.send(user, "0|7|DISPLAY_CHAT|"+user.getUserSetting().DISPLAY_CHAT);
		SocketManager.send(user, "0|7|PLAY_MUSIC|"+user.getUserSetting().PLAY_MUSIC);
		SocketManager.send(user, "0|7|PLAY_SFX|"+user.getUserSetting().PLAY_SFX);
		SocketManager.send(user, "0|7|BAR_STATUS|"+user.getUserSetting().BAR_STATUS);
		SocketManager.send(user, "0|7|WINDOW_SETTINGS,1|"+user.getUserSetting().WINDOW_SETTINGS);
		SocketManager.send(user, "0|7|AUTO_REFINEMENT|"+user.getUserSetting().AUTO_REFINEMENT);
		SocketManager.send(user, "0|7|QUICKSLOT_STOP_ATTACK|"+user.getUserSetting().QUICKSLOT_STOP_ATTACK);
		SocketManager.send(user, "0|7|DOUBLECLICK_ATTACK|"+user.getUserSetting().DOUBLECLICK_ATTACK);
		SocketManager.send(user, "0|7|AUTO_START|"+user.getUserSetting().AUTO_START);
		SocketManager.send(user, "0|7|DISPLAY_NOTIFICATIONS|"+user.getUserSetting().DISPLAY_NOTIFICATIONS);
		SocketManager.send(user, "0|7|SHOW_DRONES|"+user.getUserSetting().SHOW_DRONES);
		SocketManager.send(user, "0|7|DISPLAY_WINDOW_BACKGROUND|"+user.getUserSetting().DISPLAY_WINDOW_BACKGROUND);
		SocketManager.send(user, "0|7|ALWAYS_DRAGGABLE_WINDOWS|"+user.getUserSetting().ALWAYS_DRAGGABLE_WINDOWS);
		SocketManager.send(user, "0|7|PRELOAD_USER_SHIPS|"+user.getUserSetting().PRELOAD_USER_SHIPS);
		SocketManager.send(user, "0|7|QUALITY_PRESETTING|"+user.getUserSetting().QUALITY_PRESETTING);
		SocketManager.send(user, "0|7|QUALITY_CUSTOMIZED|"+user.getUserSetting().QUALITY_CUSTOMIZED);
		SocketManager.send(user, "0|7|QUALITY_BACKGROUND|"+user.getUserSetting().QUALITY_BACKGROUND);
		SocketManager.send(user, "0|7|QUALITY_POIZONE|"+user.getUserSetting().QUALITY_POIZONE);
		SocketManager.send(user, "0|7|QUALITY_SHIP|"+user.getUserSetting().QUALITY_SHIP);
		SocketManager.send(user, "0|7|QUALITY_ENGINE|"+user.getUserSetting().QUALITY_ENGINE);
		SocketManager.send(user, "0|7|QUALITY_COLLECTABLE|"+user.getUserSetting().QUALITY_COLLECTABLE);
		SocketManager.send(user, "0|7|QUALITY_ATTACK|"+user.getUserSetting().QUALITY_ATTACK);
		SocketManager.send(user, "0|7|QUALITY_EFFECT|"+user.getUserSetting().QUALITY_EFFECT);
		SocketManager.send(user, "0|7|QUALITY_EXPLOSION|"+user.getUserSetting().QUALITY_EXPLOSION);
		SocketManager.send(user, "0|7|QUICKBAR_SLOT|"+user.getUserSetting().QUICKBAR_SLOT);
		SocketManager.send(user, "0|7|SLOTMENU_POSITION|"+user.getUserSetting().SLOTMENU_POSITION);
		SocketManager.send(user, "0|7|SLOTMENU_ORDER|"+user.getUserSetting().SLOTMENU_ORDER);
	}
	
	/** ESTACIONES ESPACIALES **/
	private void crearEstaciones()
	{
		//Estacion espacial de Marte
		if(_user.getMapa() == 1)
		{
			String packet = "0|s|0|1|redStation|1|1500|1000|1000";
			SocketManager.send(_out, packet);
			SocketManager.send(_out, "0|"+ServerCommands.CHANGE_HEALTH_STATION_STATUS+"|1");
			SocketManager.send(_out, "0|"+ServerCommands.SET_MAP_PVP_STATUS+"|1|1");
		}
		//Estacion espacial de Tierra
		if(_user.getMapa() == 5)
		{
			String packet = "0|s|0|1|blueStation|2|1500|19500|1250";
			SocketManager.send(_out, packet);
			SocketManager.send(_out, "0|"+ServerCommands.CHANGE_HEALTH_STATION_STATUS+"|1");
			SocketManager.send(_out, "0|"+ServerCommands.SET_MAP_PVP_STATUS+"|1|2");
		}
		//Estacion espacial de Venus
		if(_user.getMapa() == 9)
		{
			String packet = "0|s|0|1|greenStation|3|1500|19500|12500";
			SocketManager.send(_out, packet);
			SocketManager.send(_out, "0|"+ServerCommands.CHANGE_HEALTH_STATION_STATUS+"|1");
			SocketManager.send(_out, "0|"+ServerCommands.SET_MAP_PVP_STATUS+"|1|3");
		}
	}
	/** FIN ESTACIONES ESPACIALES **/
	
	private void cargarPortales()
	{
		SocketManager.GAME_SEND_MAP_PORTALES(_out, _user);
	}
	
	public PrintWriter get_out() {
		return _out;
	}
	
	public void kick()
	{
		try
		{
			DarkOrbit.gameServer.delClient(this);
			
    		if(_user != null)
    		{
    			_user.setSessionID(null);
    			_user.desconexion();
    			_user.getMapaActual().eliminarNave(_user.getShip());
    			SocketManager.GAME_SEND_DESCONEXION_USER(_user);
    		}
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

