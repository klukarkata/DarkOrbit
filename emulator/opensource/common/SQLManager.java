package common;

import game.Clanes;
import game.Mapas;
import game.NPC;
import game.Naves;
import game.Portales;
import game.Usuarios;
import game.Usuarios.Settings;

import java.sql.*;
import java.util.*;

public class SQLManager {
	
	private static Connection conexion;
	private static Timer timerCommit;
	private static boolean needCommit;
	
	public synchronized static ResultSet executeQuery(String query,String DBNAME) throws SQLException
	{
		if(!DarkOrbit.isInit)
			return null;
		
		Connection DB = conexion;
		
		Statement stat = DB.createStatement();
		ResultSet RS = stat.executeQuery(query);
		stat.setQueryTimeout(300);
		return RS;
	}
	
	public synchronized static PreparedStatement newTransact(String baseQuery,Connection dbCon) throws SQLException
	{
		PreparedStatement toReturn = (PreparedStatement) dbCon.prepareStatement(baseQuery);
		
		needCommit = true;
		return toReturn;
	}
	
	public synchronized static void closeCons()
	{
		try
		{
			commitTransacts();
			
			conexion.close();
		}catch (Exception e)
		{
			System.out.println("Error al cerrar la conexion SQL:"+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public synchronized static void commitTransacts()
	{
		try
		{
			if(conexion.isClosed())
			{
				closeCons();
				setUpConnexion();
			}
			
			conexion.commit();
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR:"+e.getMessage());
			e.printStackTrace();
			commitTransacts();
		}
	}
	
	public static final boolean setUpConnexion()
	{
		try
		{
			conexion = DriverManager.getConnection("jdbc:mysql://"+DarkOrbit.HOST+"/"+DarkOrbit.BD,DarkOrbit.USUARIO,DarkOrbit.PASSWORD);
			conexion.setAutoCommit(false);
			
			if(!conexion.isValid(1000))
			{
				System.out.println("SQLError : Conexion incorrecta a la BD!");
				return false;
			}
			
			needCommit = false;
			TIMER(true);
			
			return true;
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
			return false;
		}
	}
	
	public static void TIMER(boolean start)
	{
			if(start)
			{
				timerCommit = new Timer();
				timerCommit.schedule(new TimerTask() {
					
					public void run() {
						if(!needCommit)return;
						
						commitTransacts();
						needCommit = false;
						
					}
				}, DarkOrbit.CONFIG_DB_COMMIT);
			}
			else
				timerCommit.cancel();
		}
	
	private static void closeResultSet(ResultSet RS)
	{
		try {
			RS.getStatement().close();
			RS.close();
		} catch (SQLException e) {e.printStackTrace();}	
	}
	
	private static void closePreparedStatement(PreparedStatement p)
	{
		try {
			p.clearParameters();
			p.close();
		} catch (SQLException e) {e.printStackTrace();}
	}
	
	public static void DESCONECTAR_USUARIO(int userID, int estado)
	{
		PreparedStatement p;
		String query = "UPDATE `cuentas` SET estado=? WHERE `id`=?;";
		try {
			p = newTransact(query, conexion);
			p.setInt(1, estado);
			p.setInt(2, userID);
			
			p.execute();
			closePreparedStatement(p);
		} catch (SQLException e) {
			System.out.println("Juego: SQL ERROR: "+e.getMessage());
			System.out.println("Juego: Consulta: "+query);
		}
	}
	
	public static void LOGGED_ZERO() 
	{	
		PreparedStatement p;
		String query = "UPDATE `cuentas` SET estado=0;";
		try {
			p = newTransact(query, conexion);
			
			p.execute();
			closePreparedStatement(p);
		} catch (SQLException e) {
			System.out.println("Juego: SQL ERROR: "+e.getMessage());
			System.out.println("Juego: Consulta: "+query);
		}	
	}
	
	public static void CARGAR_USUARIOS()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from cuentas ;",DarkOrbit.BD);
			while(RS.next())
			{
				Usuarios C = new Usuarios(
						RS.getInt("id"),
						RS.getString("usuario").toLowerCase(),
						RS.getString("password"),
						RS.getString("email"),
						RS.getInt("servidor"),
						RS.getString("fecha_nacimiento"),
						RS.getString("pais"),
						RS.getString("empresa"),
						RS.getInt("premium"),
						RS.getString("fecha_creacion"),
						RS.getLong("experiencia"),
						RS.getInt("nivel"),
						RS.getDouble("jackpot"),
						RS.getLong("creditos"),
						RS.getLong("uridium"),
						RS.getInt("energia_extra"),
						RS.getInt("nave"),
						RS.getInt("gfx"),
						RS.getString("vants"),
						RS.getInt("skylab"),
						RS.getInt("tecnofabrica"),
						RS.getString("ciudad"),
						RS.getInt("edad"),
						RS.getInt("sexo"),
						RS.getString("intereses"),
						RS.getString("mensaje_estado"),
						RS.getInt("ficheros"),
						RS.getInt("pi"),
						RS.getInt("habilidades"),
						RS.getInt("clan"),
						RS.getInt("estado"),
						RS.getInt("acceso"),
						RS.getInt("rango"),
						RS.getLong("honor"),
						RS.getInt("bono_reparacion"),
						RS.getInt("bono_teleportacion"),
						RS.getInt("llaves"),
						RS.getInt("puertas_alfa"),
						RS.getInt("puertas_beta"),
						RS.getInt("puertas_delta"),
						RS.getInt("puertas_omega"),
						RS.getInt("mapa"),
						RS.getString("pos"),
						RS.getLong("hp"),
						RS.getLong("hpMax"),
						RS.getLong("escudo"),
						RS.getLong("escudoMax"),
						RS.getInt("vel"),
						RS.getLong("carga"),
						RS.getLong("cargaMax"),
						RS.getString("inventario"),
						RS.getString("slot2"),
						RS.getString("slot3"),
						RS.getString("slot4"),
						RS.getString("mun1"),
						RS.getString("mun2"),
						RS.getString("mun3"),
						RS.getInt("invisible"),
						RS.getString("titulo"),
						RS.getString("lastIP"),
						RS.getString("ultimaConexion")
						);
				World.addUsuario(C);
				World.addUsuariobyNombre(C);
				
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void NUEVO_USUARIOS(int ids)
	{
		try
		{
			String myId = String.valueOf(ids);
			PreparedStatement stm = conexion.prepareStatement("SELECT * from cuentas WHERE id= ?");
			stm.setString(1, myId);
			ResultSet RS = stm.executeQuery();
			
			//SQLManager.executeQuery("SELECT * from cuentas",DarkOrbit.BD);
			while(RS.next())
			{
			Usuarios C = new Usuarios(
						RS.getInt("id"),
						RS.getString("usuario").toLowerCase(),
						RS.getString("password"),
						RS.getString("email"),
						RS.getInt("servidor"),
						RS.getString("fecha_nacimiento"),
						RS.getString("pais"),
						RS.getString("empresa"),
						RS.getInt("premium"),
						RS.getString("fecha_creacion"),
						RS.getLong("experiencia"),
						RS.getInt("nivel"),
						RS.getDouble("jackpot"),
						RS.getLong("creditos"),
						RS.getLong("uridium"),
						RS.getInt("energia_extra"),
						RS.getInt("nave"),
						RS.getInt("gfx"),
						RS.getString("vants"),
						RS.getInt("skylab"),
						RS.getInt("tecnofabrica"),
						RS.getString("ciudad"),
						RS.getInt("edad"),
						RS.getInt("sexo"),
						RS.getString("intereses"),
						RS.getString("mensaje_estado"),
						RS.getInt("ficheros"),
						RS.getInt("pi"),
						RS.getInt("habilidades"),
						RS.getInt("clan"),
						RS.getInt("estado"),
						RS.getInt("acceso"),
						RS.getInt("rango"),
						RS.getLong("honor"),
						RS.getInt("bono_reparacion"),
						RS.getInt("bono_teleportacion"),
						RS.getInt("llaves"),
						RS.getInt("puertas_alfa"),
						RS.getInt("puertas_beta"),
						RS.getInt("puertas_delta"),
						RS.getInt("puertas_omega"),
						RS.getInt("mapa"),
						RS.getString("pos"),
						RS.getLong("hp"),
						RS.getLong("hpMax"),
						RS.getLong("escudo"),
						RS.getLong("escudoMax"),
						RS.getInt("vel"),
						RS.getLong("carga"),
						RS.getLong("cargaMax"),
						RS.getString("inventario"),
						RS.getString("slot2"),
						RS.getString("slot3"),
						RS.getString("slot4"),
						RS.getString("mun1"),
						RS.getString("mun2"),
						RS.getString("mun3"),
						RS.getInt("invisible"),
						RS.getString("titulo"),
						RS.getString("lastIP"),
						RS.getString("ultimaConexion")
						);
			World.addUsuario(C);
			World.addUsuariobyNombre(C);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	public static int getNextUsuarioId()
	{
		try
		{
			ResultSet RS = executeQuery("SELECT id FROM cuentas ORDER BY id DESC LIMIT 1;",DarkOrbit.BD);
			if(!RS.first())return 1;
			int id = RS.getInt("id");
			id++;
			closeResultSet(RS);
			return id;
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
			DarkOrbit.closeServers();
		}
		return 0;
	}
	
	public static int getNextObjetoID()
	{
		try
		{
			ResultSet RS = executeQuery("SELECT MAX(id) AS max FROM objetos;",DarkOrbit.BD);
			
			int id = 0;
			boolean found = RS.first();
			
			if(found)
				id = RS.getInt("max");
			
			closeResultSet(RS);
			return id;
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
			DarkOrbit.closeServers();
		}
		return 0;
	}
	
	public static void CARGAR_NAVES()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from naves;",DarkOrbit.BD);
			while(RS.next())
			{
				Naves N = new Naves
					(
						RS.getInt("id"),
						RS.getString("nombre"),
						RS.getInt("velocidad"),
						RS.getInt("carga"),
						RS.getInt("lasers"),
						RS.getInt("generadores"),
						RS.getLong("vida"),
						RS.getInt("misiles"),
						RS.getInt("extras")
					);
				World.addNaves(N);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void CARGAR_PORTALES()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from portales;",DarkOrbit.BD);
			while(RS.next())
			{
				Portales P = new Portales
					(
						RS.getInt("ID"),
						RS.getInt("factionID"),
						RS.getInt("keyPortal"),
						RS.getInt("mapID"),
						RS.getInt("posX"),
						RS.getInt("posY"),
						RS.getInt("factionScrap"),
						RS.getInt("toMapID"),
						RS.getString("toPos"),
						RS.getInt("reqNivel")
					);
				World.addPortales(P);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	
	public static void CARGAR_CLANES()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from clanes;",DarkOrbit.BD);
			while(RS.next())
			{
				Clanes C = new Clanes
					(
						RS.getInt("clanID"),
						RS.getString("nombre"),
						RS.getString("tagNombre")
					);
				World.addClanes(C);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void CARGAR_MAPAS()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from mapas;",DarkOrbit.BD);
			while(RS.next())
			{
				Mapas M = new Mapas
					(
						RS.getInt("mapid"),
						RS.getString("name"),
						RS.getInt("music"),
						RS.getInt("scaleFactor"),
						RS.getString("neighbours"),
						RS.getString("starfield"),
						RS.getString("backgrounds"),
						RS.getString("lensflares"),
						RS.getString("planets"),
						RS.getString("aliens")
					);
				World.addMapa(M);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void CARGAR_NPCS()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from npcs;",DarkOrbit.BD);
			while(RS.next())
			{
				NPC N = new NPC
					(
						RS.getInt("id"),
						RS.getString("nombre"),
						RS.getInt("gfx"),
						RS.getInt("pv"),
						RS.getInt("esc"),
						RS.getInt("exp"),
						RS.getInt("hon"),
						RS.getInt("cre"),
						RS.getInt("uri"),
						RS.getInt("xenomit"),
						RS.getInt("prometium"),
						RS.getInt("terbium"),
						RS.getInt("endurium"),
						RS.getInt("prometid"),
						RS.getInt("duranium"),
						RS.getInt("promerium"),
						RS.getString("dmg"),
						RS.getInt("IA")
					);
				World.addNPC(N);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void CARGAR_SETTINGS()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from settings;",DarkOrbit.BD);
			while(RS.next())
			{
				Settings S = new Settings
					(
						RS.getInt("userID"),
						RS.getString("SET"),
						RS.getString("MINIMAP_SCALE"),
						RS.getString("DISPLAY_PLAYER_NAMES"),
						RS.getString("DISPLAY_CHAT"),
						RS.getString("PLAY_MUSIC"),
						RS.getString("PLAY_SFX"),
						RS.getString("BAR_STATUS"),					
						RS.getString("WINDOW_SETTINGS"),
						RS.getString("AUTO_REFINEMENT"),
						RS.getString("QUICKSLOT_STOP_ATTACK"),
						RS.getString("DOUBLECLICK_ATTACK"),
						RS.getString("AUTO_START"),
						RS.getString("DISPLAY_NOTIFICATIONS"),
						RS.getString("SHOW_DRONES"),
						RS.getString("DISPLAY_WINDOW_BACKGROUND"),
						RS.getString("ALWAYS_DRAGGABLE_WINDOWS"),
						RS.getString("PRELOAD_USER_SHIPS"),
						RS.getString("QUALITY_PRESETTING"),
						RS.getString("QUALITY_CUSTOMIZED"),
						RS.getString("QUALITY_BACKGROUND"),						
						RS.getString("QUALITY_POIZONE"),						
						RS.getString("QUALITY_SHIP"),
						RS.getString("QUALITY_ENGINE"),
						RS.getString("QUALITY_COLLECTABLE"),
						RS.getString("QUALITY_ATTACK"),
						RS.getString("QUALITY_EFFECT"),
						RS.getString("QUALITY_EXPLOSION"),
						RS.getString("QUICKBAR_SLOT"),
						RS.getString("SLOTMENU_POSITION"),						
						RS.getString("SLOTMENU_ORDER")
					);
				World.addSettings(S);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void NUEVOS_SETTINGS(int ids)
	{
		try
		{
			String myId = String.valueOf(ids);
			PreparedStatement stm = conexion.prepareStatement("SELECT * from settings WHERE userID= ?");
			stm.setString(1, myId);
			ResultSet RS = stm.executeQuery();

			while(RS.next())
			{
				Settings S = new Settings
					(
						RS.getInt("userID"),
						RS.getString("SET"),
						RS.getString("MINIMAP_SCALE"),
						RS.getString("DISPLAY_PLAYER_NAMES"),
						RS.getString("DISPLAY_CHAT"),
						RS.getString("PLAY_MUSIC"),
						RS.getString("PLAY_SFX"),
						RS.getString("BAR_STATUS"),					
						RS.getString("WINDOW_SETTINGS"),
						RS.getString("AUTO_REFINEMENT"),
						RS.getString("QUICKSLOT_STOP_ATTACK"),
						RS.getString("DOUBLECLICK_ATTACK"),
						RS.getString("AUTO_START"),
						RS.getString("DISPLAY_NOTIFICATIONS"),
						RS.getString("SHOW_DRONES"),
						RS.getString("DISPLAY_WINDOW_BACKGROUND"),
						RS.getString("ALWAYS_DRAGGABLE_WINDOWS"),
						RS.getString("PRELOAD_USER_SHIPS"),
						RS.getString("QUALITY_PRESETTING"),
						RS.getString("QUALITY_CUSTOMIZED"),
						RS.getString("QUALITY_BACKGROUND"),						
						RS.getString("QUALITY_POIZONE"),						
						RS.getString("QUALITY_SHIP"),
						RS.getString("QUALITY_ENGINE"),
						RS.getString("QUALITY_COLLECTABLE"),
						RS.getString("QUALITY_ATTACK"),
						RS.getString("QUALITY_EFFECT"),
						RS.getString("QUALITY_EXPLOSION"),
						RS.getString("QUICKBAR_SLOT"),
						RS.getString("SLOTMENU_POSITION"),						
						RS.getString("SLOTMENU_ORDER")
					);
				World.addSettings(S);
			}
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void ACTUALIZAR_DATOS_USUARIO(Usuarios user)
	{
		try
		{
			String baseQuery = "UPDATE cuentas SET " +
								"`usuario` = ?,"+
								"`password` = ?,"+
								"`email` = ?,"+
								"`servidor` = ?,"+
								"`fecha_nacimiento` = ?,"+
								"`pais` = ?,"+
								"`empresa` = ?,"+
								"`premium` = ?,"+
								"`fecha_creacion` = ?,"+
								"`experiencia` = ?,"+
								"`nivel` = ?,"+
								"`jackpot` = ?,"+
								"`creditos` = ?,"+
								"`uridium` = ?,"+
								"`energia_extra` = ?,"+
								"`nave` = ?,"+
								"`gfx` = ?,"+
								"`vants` = ?,"+
								"`skylab` = ?,"+
								"`tecnofabrica` = ?,"+
								"`ciudad` = ?,"+
								"`edad` = ?,"+
								"`sexo` = ?,"+
								"`intereses` = ?,"+
								"`mensaje_estado` = ?,"+
								"`ficheros` = ?,"+
								"`pi` = ?,"+
								"`habilidades` = ?,"+
								"`clan` = ?,"+
								"`estado` = ?,"+
								"`acceso` = ?,"+
								"`rango` = ?,"+
								"`honor` = ?,"+
								"`bono_reparacion` = ?,"+
								"`bono_teleportacion` = ?,"+
								"`llaves` = ?,"+
								"`puertas_alfa` = ?,"+
								"`puertas_beta` = ?,"+
								"`puertas_delta` = ?,"+
								"`puertas_omega` = ?,"+
								"`mapa` = ?,"+
								"`pos` = ?,"+
								"`hp` = ?,"+
								"`hpMax` = ?,"+
								"`escudo` = ?,"+
								"`escudoMax` = ?,"+
								"`vel` = ?,"+
								"`carga` = ?,"+
								"`cargaMax` = ?,"+
								"`inventario` = ?,"+
								"`slot2` = ?,"+
								"`slot3` = ?,"+
								"`slot4` = ?,"+
								"`mun1` = ?,"+
								"`mun2` = ?,"+
								"`mun3` = ?,"+
								"`invisible` = ?,"+
								"`titulo` = ?,"+
								"`lastIP` = ?,"+
								"`ultimaConexion` = ?"+
								" WHERE `id` = ?;";
			
			PreparedStatement p = newTransact(baseQuery, conexion);
			
			
			p.setString(1, user.getUsuario());
			p.setString(2, user.getPassword());
			p.setString(3, user.getEmail());
			p.setInt(4, user.getServidor());
			p.setString(5, user.getFecha_nacimiento());
			p.setString(6, user.getPais());
			p.setString(7, user.getEmpresa());
			p.setInt(8, user.getPremium());
			p.setString(9, user.getFecha_creacion());
			p.setLong(10, user.getExperiencia());
			p.setInt(11, user.getNivel());
			p.setDouble(12, user.getJackpot());
			p.setLong(13, user.getCreditos());
			p.setLong(14, user.getUridium());
			p.setInt(15, user.getEnergia_extra());
			p.setInt(16, user.getNave());
			p.setInt(17, user.getGfx());
			p.setString(18, user.getVants());
			p.setInt(19, user.getSkylab());
			p.setInt(20, user.getTecnofabrica());
			p.setString(21, user.getCiudad());
			p.setInt(22, user.getEdad());
			p.setInt(23, user.getSexo());
			p.setString(24, user.getIntereses());
			p.setString(25, user.getMensaje_estado());
			p.setInt(26, user.getFicheros());
			p.setInt(27, user.getPi());
			p.setInt(28, user.getHabilidades());
			p.setInt(29, user.getClan());
			p.setInt(30, user.getEstado());
			p.setInt(31, user.getAcceso());
			p.setInt(32, user.getRango());
			p.setLong(33, user.getHonor());
			p.setInt(34, user.getBono_reparacion());
			p.setInt(35, user.getBono_teleportacion());
			p.setInt(36, user.getLlaves());
			p.setInt(37, user.getPuertas_alfa());
			p.setInt(38, user.getPuertas_beta());
			p.setInt(39, user.getPuertas_delta());
			p.setInt(40, user.getPuertas_omega());
			p.setInt(41, user.getMapa());
			p.setString(42, user.getPos());
			p.setLong(43, user.getHp());
			p.setLong(44, user.getHpMax());
			p.setLong(45, user.getEscudo());
			p.setLong(46, user.getEscudoMax());
			p.setInt(47, user.getVel());
			p.setLong(48, user.getCarga());
			p.setLong(49, user.getCargaMax());
			p.setString(50, user.get_inventario());
			p.setString(51, user.getSlot2());
			p.setString(52, user.getSlot3());
			p.setString(53, user.getSlot4());
			p.setString(54, user.getMun1());
			p.setString(55, user.getMun2());
			p.setString(56, user.getMun3());
			p.setInt(57, user.getInvisible());
			p.setString(58, user.getTitulo());
			p.setString(59, user.getLastIP());
			p.setString(60, user.getUltimaConexion());
			p.setInt(61, user.getId());
			
			p.executeUpdate();
			closePreparedStatement(p);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void GUARDAR_USUARIO(Usuarios user)
	{
		try
		{
			String baseQuery = "UPDATE cuentas SET " +
					"`usuario` = ?,"+
					"`password` = ?,"+
					"`email` = ?,"+
					"`servidor` = ?,"+
					"`fecha_nacimiento` = ?,"+
					"`pais` = ?,"+
					"`empresa` = ?,"+
					"`premium` = ?,"+
					"`fecha_creacion` = ?,"+
					"`experiencia` = ?,"+
					"`nivel` = ?,"+
					"`jackpot` = ?,"+
					"`creditos` = ?,"+
					"`uridium` = ?,"+
					"`energia_extra` = ?,"+
					"`nave` = ?,"+
					"`gfx` = ?,"+
					"`vants` = ?,"+
					"`skylab` = ?,"+
					"`tecnofabrica` = ?,"+
					"`ciudad` = ?,"+
					"`edad` = ?,"+
					"`sexo` = ?,"+
					"`intereses` = ?,"+
					"`mensaje_estado` = ?,"+
					"`ficheros` = ?,"+
					"`pi` = ?,"+
					"`habilidades` = ?,"+
					"`clan` = ?,"+
					"`estado` = ?,"+
					"`acceso` = ?,"+
					"`rango` = ?,"+
					"`honor` = ?,"+
					"`bono_reparacion` = ?,"+
					"`bono_teleportacion` = ?,"+
					"`llaves` = ?,"+
					"`puertas_alfa` = ?,"+
					"`puertas_beta` = ?,"+
					"`puertas_delta` = ?,"+
					"`puertas_omega` = ?,"+
					"`mapa` = ?,"+
					"`pos` = ?,"+
					"`hp` = ?,"+
					"`hpMax` = ?,"+
					"`escudo` = ?,"+
					"`escudoMax` = ?,"+
					"`vel` = ?,"+
					"`carga` = ?,"+
					"`cargaMax` = ?,"+
					"`inventario` = ?,"+
					"`slot2` = ?,"+
					"`slot3` = ?,"+
					"`slot4` = ?,"+
					"`mun1` = ?,"+
					"`mun2` = ?,"+
					"`mun3` = ?,"+
					"`invisible` = ?,"+
					"`titulo` = ?,"+
					"`lastIP` = ?,"+
					"`ultimaConexion` = ?"+
					"WHERE `cuentas`.`id` = ? LIMIT 1 ;";

			PreparedStatement p = newTransact(baseQuery, conexion);

			p.setString(1, user.getUsuario());
			p.setString(2, user.getPassword());
			p.setString(3, user.getEmail());
			p.setInt(4, user.getServidor());
			p.setString(5, user.getFecha_nacimiento());
			p.setString(6, user.getPais());
			p.setString(7, user.getEmpresa());
			p.setInt(8, user.getPremium());
			p.setString(9, user.getFecha_creacion());
			p.setLong(10, user.getExperiencia());
			p.setInt(11, user.getNivel());
			p.setDouble(12, user.getJackpot());
			p.setLong(13, user.getCreditos());
			p.setLong(14, user.getUridium());
			p.setInt(15, user.getEnergia_extra());
			p.setInt(16, user.getNave());
			p.setInt(17, user.getGfx());
			p.setString(18, user.getVants());
			p.setInt(19, user.getSkylab());
			p.setInt(20, user.getTecnofabrica());
			p.setString(21, user.getCiudad());
			p.setInt(22, user.getEdad());
			p.setInt(23, user.getSexo());
			p.setString(24, user.getIntereses());
			p.setString(25, user.getMensaje_estado());
			p.setInt(26, user.getFicheros());
			p.setInt(27, user.getPi());
			p.setInt(28, user.getHabilidades());
			p.setInt(29, user.getClan());
			p.setInt(30, user.getEstado());
			p.setInt(31, user.getAcceso());
			p.setInt(32, user.getRango());
			p.setLong(33, user.getHonor());
			p.setInt(34, user.getBono_reparacion());
			p.setInt(35, user.getBono_teleportacion());
			p.setInt(36, user.getLlaves());
			p.setInt(37, user.getPuertas_alfa());
			p.setInt(38, user.getPuertas_beta());
			p.setInt(39, user.getPuertas_delta());
			p.setInt(40, user.getPuertas_omega());
			p.setInt(41, user.getMapa());
			p.setString(42, user.getPos());
			p.setLong(43, user.getHp());
			p.setLong(44, user.getHpMax());
			p.setLong(45, user.getEscudo());
			p.setLong(46, user.getEscudoMax());
			p.setInt(47, user.getVel());
			p.setLong(48, user.getCarga());
			p.setLong(49, user.getCargaMax());
			p.setString(50, user.get_inventario());
			p.setString(51, user.getSlot2());
			p.setString(52, user.getSlot3());
			p.setString(53, user.getSlot4());
			p.setString(54, user.getMun1());
			p.setString(55, user.getMun2());
			p.setString(56, user.getMun3());
			p.setInt(57, user.getInvisible());
			p.setString(58, user.getTitulo());
			p.setString(59, user.getLastIP());
			p.setString(60, user.getUltimaConexion());
			p.setInt(61, user.getId());
			
			p.executeUpdate();
			closePreparedStatement(p);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
	}
	
	public static void CARGAR_XP()
	{
		try
		{
			ResultSet RS = SQLManager.executeQuery("SELECT * from experiencias;", DarkOrbit.BD);
			while(RS.next())World.addExpLevel(RS.getInt("nivel"),new World.ExpLevel(RS.getLong("nave"),RS.getInt("vant"),RS.getInt("pet")));
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("Juego: SQL ERROR: "+e.getMessage());
			System.exit(1);
		}
	}
	
	public static int CARGAR_BANEADOS() 
	{
		int i = 0;
		try
		{
			ResultSet RS = executeQuery("SELECT ip from banip;", DarkOrbit.BD); 
			while (RS.next()) 
			{ 
				Constantes.BAN_IP += RS.getString("ip");
				if(!RS.isLast()) Constantes.BAN_IP += ",";
				i++;
		    }
			closeResultSet(RS);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
		return i;
	}
	
	public static boolean AGREGAR_BANEADO(String ip)
	{
		String baseQuery = "INSERT INTO `banip`" +
				" VALUES (?);";
		try {
			PreparedStatement p = newTransact(baseQuery, conexion);
			p.setString(1, ip);
			p.execute();
			closePreparedStatement(p);
			return true;
		} catch (SQLException e) {
			System.out.println("Juego: SQL ERROR: "+e.getMessage());
			System.out.println("Juego: Consulta: "+baseQuery);
		}
		return false;
	}

	public static void ACTUALIZAR_POSICION_USUARIO(Usuarios user) {
		try
		{
			String baseQuery = "UPDATE cuentas SET " +
								"`mapa` = ?,"+
								"`pos` = ?"+
								" WHERE `id` = ?;";
			
			PreparedStatement p = newTransact(baseQuery, conexion);
			
			
			p.setInt(1, user.getMapa());
			p.setString(2, user.getPos());
			p.setInt(3, user.getId());
			
			p.executeUpdate();
			closePreparedStatement(p);
		}catch(SQLException e)
		{
			System.out.println("SQL ERROR: "+e.getMessage());
			e.printStackTrace();
		}
		
	}

	
}
