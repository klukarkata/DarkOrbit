package game;

import game.objetos.Inventario;

import java.util.Map;
import java.util.TreeMap;

import javax.swing.Timer;

import net.GameThread;
import net.SocketManager;
import net.chat.ChatThread;

import common.SQLManager;
import common.ServerCommands;
import common.World;

public class Usuarios {
	
	//Datos de los usuarios
	private int id;
	private String usuario;
	private String password;
	private String email;
	private int servidor;
	private String fecha_nacimiento;
	private String pais;
	private String empresa;
	private int premium;
	private String fecha_creacion;
	private long experiencia;
	private int nivel;
	private double jackpot;
	private long creditos;
	private long uridium;
	private int energia_extra;
	private int nave;
	private int gfx;
	private String vants;
	private int skylab;
	private int tecnofabrica;
	private String ciudad;
	private int edad;
	private int sexo;
	private String intereses;
	private String mensaje_estado;
	private int ficheros;
	private int pi;
	private int habilidades;
	private int clan;
	private int estado;
	private int acceso;
	private int rango;
	private long honor;
	private int bono_reparacion;
	private int bono_teleportacion;
	private int llaves;
	private int puertas_alfa;
	private int puertas_beta;
	private int puertas_delta;
	private int puertas_omega;
	private int mapa;
	private String pos;
	private long hp;
	private long hpMax;
	private long escudo;
	private long escudoMax;
	private int vel;
	private long carga;
	private long cargaMax;
	private String _inventario;
	private Inventario inventario;
	private String slot2;
	private String slot3;
	private String slot4;
	private String mun1;
	private String mun2;
	private String mun3;
	private int invisible;
	private String titulo;
	private String lastIP;
	private String ultimaConexion;
	private Usuarios _cuenta;
	private GameThread _gameThread;
	private ChatThread _chatThread;
	private Usuarios _actualUsuario;
	private String _actualIP = "";
	private Map<Integer, Usuarios> _user = new TreeMap<Integer, Usuarios>();
	private static Map<Integer, Usuarios> conectados = new TreeMap<Integer, Usuarios>();
	private boolean _isOnline  = false;
	public static boolean isKilled;
	public static int factionID = 0;
    private String sessionID = null;
    private int oldPosX = 0;
    private int oldPosY = 0;
    private Settings userSetting;
    private Settings userSetting2;
    private Ship ship;
	//Inactividad
	protected long _lastPacketTime;
	//Portales
	public int tPortal = 0;
	public boolean usaPortal = false;
	//TIEMPO de Acciones
	public int tAccionPortal = 0;//1s por accion
	public int tAccionConfig = 5;//5s por accion
	public int tAccionLogout = 5;//5s por accion
	public boolean isLogout = false;
	public boolean isHeroLoaded = false;
	public boolean isMoviendo = false;
	@SuppressWarnings("unused")
	private Timer movimiento;
	//Galaxy Gates
	private int GG;
	//Laser activado
	private int laser1 = 1;
	public int permitirGrupo = 0;//0: Permitir | 1: Bloqueado
	
	public Usuarios(int id, String usuario, String password, String email, int servidor, String fecha_nacimiento,
			String pais, String empresa, int premium, String fecha_creacion, long experiencia, int nivel,
			double jackpot, long creditos, long uridium, int energia_extra, int nave, int gfx, String vants, int skylab,
			int tecnofabrica, String ciudad, int edad, int sexo, String intereses, String mensaje_estado, int ficheros,
			int pi, int habilidades, int clan, int estado, int acceso, int rango, long honor, int bono_reparacion,
			int bono_teleportacion, int llaves, int puertas_alfa, int puertas_beta, int puertas_delta,
			int puertas_omega, int mapa, String pos, long hp, long hpMax, long escudo, long escudoMax,
			int vel, long carga, long cargaMax, String inventario, String slot2,
			String slot3, String slot4, String mun1, String mun2, String mun3, int invisible,
			String titulo, String lastIP, String ultimaConexion
			) {
		this.id = id;
		this.usuario = usuario;
		this.password = password;
		this.email = email;
		this.servidor = servidor;
		this.fecha_nacimiento = fecha_nacimiento;
		this.pais = pais;
		this.empresa = empresa;
		this.premium = premium;
		this.fecha_creacion = fecha_creacion;
		this.experiencia = experiencia;
		this.nivel = nivel;
		this.jackpot = jackpot;
		this.creditos = creditos;
		this.uridium = uridium;
		this.energia_extra = energia_extra;
		this.nave = nave;
		this.gfx = gfx;
		this.vants = vants;
		this.skylab = skylab;
		this.tecnofabrica = tecnofabrica;
		this.ciudad = ciudad;
		this.edad = edad;
		this.sexo = sexo;
		this.intereses = intereses;
		this.mensaje_estado = mensaje_estado;
		this.ficheros = ficheros;
		this.pi = pi;
		this.habilidades = habilidades;
		this.clan = clan;
		this.estado = estado;
		this.acceso = acceso;
		this.rango = rango;
		this.honor = honor;
		this.bono_reparacion = bono_reparacion;
		this.bono_teleportacion = bono_teleportacion;
		this.llaves = llaves;
		this.puertas_alfa = puertas_alfa;
		this.puertas_beta = puertas_beta;
		this.puertas_delta = puertas_delta;
		this.puertas_omega = puertas_omega;
		this.mapa = mapa;
		this.pos = pos;
		if(hp < 0 || hp == 0)hp = 1000;
		this.hp = hp;
		this.hpMax = hpMax;
		this.escudo = escudo;
		this.escudoMax = escudoMax;
		this.vel = vel;
		this.carga = carga;
		this.cargaMax = cargaMax;
		/** CARGA DE INVENTARIO **/
		this._inventario = inventario;
		this.inventario = new Inventario(this);
		/** FIN INVENTARIO**/
		this.slot2 = slot2;
		this.slot3 = slot3;
		this.slot4 = slot4;
		this.mun1 = mun1;
		this.mun2 = mun2;
		this.mun3 = mun3;
		this.invisible = invisible;
		this.titulo = titulo;
		this.lastIP = lastIP;
		this.ultimaConexion = ultimaConexion;
		this.userSetting = Settings.getSettingByUserID(id);
	}

	//Recogedores y modificadores de datos
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getUsuario() {
		return usuario;
	}

	public void setUsuario(String usuario) {
		this.usuario = usuario;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}
	
	public Usuarios get_cuenta() {
		return _cuenta;
	}
	
	public boolean isOnline()
	{
		if(_gameThread != null)return true;
		return false;
	}
	
	public GameThread getGameThread()
	{
		return _gameThread;
	}
	
	public ChatThread getChatThread()
	{
		return _chatThread;
	}
	
	public void desconexion()
	{
		_actualUsuario = null;
		_gameThread = null;
		_chatThread = null;
		_actualIP = "";
		SQLManager.DESCONECTAR_USUARIO(getId(), 0);
		resetAllChars(true);
		SQLManager.ACTUALIZAR_DATOS_USUARIO(this);
	}
	
	public void resetAllChars(boolean save)
	{
		this.set_isOnline(false);
		this.resetVars();
		if(save)SQLManager.GUARDAR_USUARIO(this);
		_user.clear();
	}
	
	private void resetVars() {
		//Resetear variables de un usuario
	}

	public long getLastPacketTime()
	{
		return _lastPacketTime;
	}
	
	public void refreshLastPacketTime()
	{
		_lastPacketTime = System.currentTimeMillis();
	}

	public boolean get_isOnline() {
		return _isOnline;
	}

	public void set_isOnline(boolean _isOnline) {
		this._isOnline = _isOnline;
	}

	public String get_actualIP() {
		return _actualIP;
	}

	public void set_actualIP(String _actualIP) {
		this._actualIP = _actualIP;
	}

	public Usuarios get_actualUsuario() {
		return _actualUsuario;
	}

	public void set_actualUsuario(Usuarios _actualUsuario) {
		this._actualUsuario = _actualUsuario;
	}
	
	public void setGameThread(GameThread t)
	{
		_gameThread = t;
	}
	
	public void setChatThread(ChatThread t)
	{
		_chatThread = t;
	}
	
	public int getServidor() {
		return servidor;
	}

	public void setServidor(int servidor) {
		this.servidor = servidor;
	}

	public String getFecha_nacimiento() {
		return fecha_nacimiento;
	}

	public void setFecha_nacimiento(String fecha_nacimiento) {
		this.fecha_nacimiento = fecha_nacimiento;
	}

	public String getPais() {
		return pais;
	}

	public void setPais(String pais) {
		this.pais = pais;
	}

	public String getEmpresa() {
		return empresa;
	}

	public void setEmpresa(String empresa) {
		this.empresa = empresa;
	}

	public int getPremium() {
		return premium;
	}

	public void setPremium(int premium) {
		this.premium = premium;
	}

	public String getFecha_creacion() {
		return fecha_creacion;
	}

	public void setFecha_creacion(String fecha_creacion) {
		this.fecha_creacion = fecha_creacion;
	}

	public long getExperiencia() {
		return experiencia;
	}

	public void setExperiencia(long experiencia) {
		this.experiencia = experiencia;
	}

	public int getNivel() {
		return nivel;
	}

	public void setNivel(int nivel) {
		this.nivel = nivel;
	}

	public double getJackpot() {
		return jackpot;
	}

	public void setJackpot(double jackpot) {
		this.jackpot = jackpot;
	}

	public long getCreditos() {
		return creditos;
	}

	public void setCreditos(long creditos) {
		this.creditos = creditos;
	}

	public long getUridium() {
		return uridium;
	}

	public void setUridium(long uridium) {
		this.uridium = uridium;
	}

	public int getEnergia_extra() {
		return energia_extra;
	}

	public void setEnergia_extra(int energia_extra) {
		this.energia_extra = energia_extra;
	}

	public int getNave() {
		return nave;
	}

	public void setNave(int nave) {
		this.nave = nave;
	}

	public String getVants() {
		return vants;
	}

	public void setVants(String vants) {
		this.vants = vants;
	}

	public int getSkylab() {
		return skylab;
	}

	public void setSkylab(int skylab) {
		this.skylab = skylab;
	}

	public int getTecnofabrica() {
		return tecnofabrica;
	}

	public void setTecnofabrica(int tecnofabrica) {
		this.tecnofabrica = tecnofabrica;
	}

	public String getCiudad() {
		return ciudad;
	}

	public void setCiudad(String ciudad) {
		this.ciudad = ciudad;
	}

	public int getEdad() {
		return edad;
	}

	public void setEdad(int edad) {
		this.edad = edad;
	}

	public int getSexo() {
		return sexo;
	}

	public void setSexo(int sexo) {
		this.sexo = sexo;
	}

	public String getIntereses() {
		return intereses;
	}

	public void setIntereses(String intereses) {
		this.intereses = intereses;
	}

	public String getMensaje_estado() {
		return mensaje_estado;
	}

	public void setMensaje_estado(String mensaje_estado) {
		this.mensaje_estado = mensaje_estado;
	}

	public int getFicheros() {
		return ficheros;
	}

	public void setFicheros(int ficheros) {
		this.ficheros = ficheros;
	}

	public int getPi() {
		return pi;
	}

	public void setPi(int pi) {
		this.pi = pi;
	}

	public int getHabilidades() {
		return habilidades;
	}

	public void setHabilidades(int habilidades) {
		this.habilidades = habilidades;
	}

	public int getClan() {
		return clan;
	}

	public void setClan(int clan) {
		this.clan = clan;
	}

	public int getEstado() {
		return estado;
	}

	public void setEstado(int estado) {
		this.estado = estado;
	}

	public int getAcceso() {
		return acceso;
	}

	public void setAcceso(int acceso) {
		this.acceso = acceso;
	}

	public int getRango() {
		return rango;
	}

	public void setRango(int rango) {
		this.rango = rango;
	}

	public long getHonor() {
		return honor;
	}

	public void setHonor(long honor) {
		this.honor = honor;
	}

	public int getBono_reparacion() {
		return bono_reparacion;
	}

	public void setBono_reparacion(int bono_reparacion) {
		this.bono_reparacion = bono_reparacion;
	}

	public int getBono_teleportacion() {
		return bono_teleportacion;
	}

	public void setBono_teleportacion(int bono_teleportacion) {
		this.bono_teleportacion = bono_teleportacion;
	}

	public int getLlaves() {
		return llaves;
	}

	public void setLlaves(int llaves) {
		this.llaves = llaves;
	}

	public int getPuertas_alfa() {
		return puertas_alfa;
	}

	public void setPuertas_alfa(int puertas_alfa) {
		this.puertas_alfa = puertas_alfa;
	}

	public int getPuertas_beta() {
		return puertas_beta;
	}

	public void setPuertas_beta(int puertas_beta) {
		this.puertas_beta = puertas_beta;
	}

	public int getPuertas_delta() {
		return puertas_delta;
	}

	public void setPuertas_delta(int puertas_delta) {
		this.puertas_delta = puertas_delta;
	}

	public int getPuertas_omega() {
		return puertas_omega;
	}

	public void setPuertas_omega(int puertas_omega) {
		this.puertas_omega = puertas_omega;
	}

	public int getMapa() {
		return mapa;
	}

	public void setMapa(int mapa) {
		this.mapa = mapa;
	}

	public String getPos() {
		return pos;
	}

	public void setPos(String pos) {
		this.pos = pos;
	}

	public long getHp() {
		return hp;
	}

	public void setHp(long hp) {
		this.hp = hp;
	}

	public int getVel() {	
		return vel;
	}

	public void setVel(int vel) {
		this.vel = vel;
	}

	public long getCarga() {
		return carga;
	}

	public void setCarga(long carga) {
		this.carga = carga;
	}

	public String getSlot2() {
		return slot2;
	}

	public void setSlot2(String slot2) {
		this.slot2 = slot2;
	}

	public String getSlot3() {
		return slot3;
	}

	public void setSlot3(String slot3) {
		this.slot3 = slot3;
	}

	public String getSlot4() {
		return slot4;
	}

	public void setSlot4(String slot4) {
		this.slot4 = slot4;
	}

	public String getMun1() {
		return mun1;
	}

	public void setMun1(String mun1) {
		this.mun1 = mun1;
	}

	public String getMun2() {
		return mun2;
	}

	public void setMun2(String mun2) {
		this.mun2 = mun2;
	}

	public String getMun3() {
		return mun3;
	}

	public void setMun3(String mun3) {
		this.mun3 = mun3;
	}

	public String getLastIP() {
		return lastIP;
	}

	public void setLastIP(String lastIP) {
		this.lastIP = lastIP;
	}

	public String getUltimaConexion() {
		return ultimaConexion;
	}

	public void setUltimaConexion(String ultimaConexion) {
		this.ultimaConexion = ultimaConexion;
	}

	public long getEscudo() {
		return escudo;
	}

	public void setEscudo(long escudo) {
		this.escudo = escudo;
	}
	
	public boolean esPremium(int id)
	{
		boolean esPremium = false;
		if(id == 1)
		{
			esPremium = true;
		}else
		{
			esPremium = false;
		}
		return esPremium;	
	}

	public static Map<Integer, Usuarios> getConectados() {
		return conectados;
	}

	public static void setConectados(int id, Usuarios user) {
		
		conectados.put(id, user);
	}
	
	public void autoPilotar(int posX, int posY)
	{
		String HeroPacket = "RDY|"+ServerCommands.HERO_MOVEMENT+"|"+posX+"|"+posY;
		SocketManager.send(this, HeroPacket);
	}

	public int getInvisible() {
		return invisible;
	}

	public void setInvisible(int invisible) {
		this.invisible = invisible;
	}

	public int getGG() {
		GG = (puertas_alfa+puertas_beta+puertas_delta+puertas_omega);
		if(GG > 4)GG = 4;
		return GG;
	}

	public void setGG(int gG) {
		if(gG > 4)gG = 4;
		GG = gG;
	}
	
	public String getTagClan()
	{
		String tagClan = "";
		if(World.getClanByID(clan) != null && World.getClanByID(clan).getClanID() == clan)
		{
			tagClan = World.getClanByID(clan).getTagNombre();
		}
		return tagClan;
		
	}

	public String getTitulo() {
		return titulo;
	}

	public void setTitulo(String titulo) {
		this.titulo = titulo;
	}

	public long getHpMax() {
		return hpMax;
	}

	public void setHpMax(long hpMax) {
		this.hpMax = hpMax;
	}

	public long getEscudoMax() {
		return escudoMax;
	}

	public void setEscudoMax(long escudoMax) {
		this.escudoMax = escudoMax;
	}

	public long getCargaMax() {
		return cargaMax;
	}

	public void setCargaMax(long cargaMax) {
		this.cargaMax = cargaMax;
	}
	
	public void acciones()
	{
		this.tAccionPortal--;
		if(this.tAccionPortal < 0)this.tAccionPortal =  0;
		this.tAccionConfig--;
		if(this.tAccionConfig < 0)this.tAccionConfig =  0;
		if(isLogout == true)
		{
			if(this.tAccionLogout == 0)
			{
				this.isLogout = false;
				this.tAccionLogout = 5;
				SocketManager.send(this, "0|"+ServerCommands.LOGOUT);
				this.desconexion();
			}
			this.tAccionLogout--;
			if(this.tAccionLogout < 0)this.tAccionLogout =  0;
		}
		
	}

	public int getLaser1() {
		return laser1;
	}

	public void setLaser1(int laser1) {
		this.laser1 = laser1;
	}

	public int getOldPosX() {
		return oldPosX;
	}

	public void setOldPosX(int oldPosX) {
		this.oldPosX = oldPosX;
	}

	public int getOldPosY() {
		return oldPosY;
	}

	public void setOldPosY(int oldPosY) {
		this.oldPosY = oldPosY;
	}

	

	public void setUserSetting(Settings userSetting) {
		this.userSetting = userSetting;
	}
	
	public Mapas getMapaActual() 
	{
		return World.getMapaByID(this.mapa);
	}

	public Ship getShip() {
		return ship;
	}

	public void setShip(Ship ship) {
		this.ship = ship;
	}

	public String getSessionID() {
		return sessionID;
	}

	public void setSessionID(String sessionID) {
		this.sessionID = sessionID;
	}

	public int getGfx() {
		return gfx;
	}

	public void setGfx(int gfx) {
		this.gfx = gfx;
	}

	public Inventario getInventario() {
		return inventario;
	}

	public void setInventario(Inventario inventario) {
		this.inventario = inventario;
	}

	public String get_inventario() {
		return _inventario;
	}

	public void set_inventario(String _inventario) {
		this._inventario = _inventario;
	}
	
	public Settings getUserSetting() {
		return userSetting;
	}

	public static class Settings
	{
		private int userID;
		public String SET;
		public String MINIMAP_SCALE;
		public String DISPLAY_PLAYER_NAMES;
		public String DISPLAY_CHAT;
		public String PLAY_MUSIC;
		public String PLAY_SFX;
		public String BAR_STATUS;
		public String WINDOW_SETTINGS;
		public String AUTO_REFINEMENT;
		public String QUICKSLOT_STOP_ATTACK;
		public String DOUBLECLICK_ATTACK;
		public String AUTO_START;
		public String DISPLAY_NOTIFICATIONS;
		public String SHOW_DRONES;
		public String ALWAYS_DRAGGABLE_WINDOWS;
		public String PRELOAD_USER_SHIPS;
		public String QUALITY_PRESETTING;
		public String QUALITY_CUSTOMIZED;
		public String QUALITY_BACKGROUND;
		public String QUALITY_POIZONE;
		public String QUALITY_SHIP;
		public String QUALITY_ENGINE;
		public String DISPLAY_WINDOW_BACKGROUND;
		public String QUALITY_COLLECTABLE;
		public String QUALITY_ATTACK;
		public String QUALITY_EFFECT;
		public String QUALITY_EXPLOSION;
		public String QUICKBAR_SLOT;
		public String SLOTMENU_POSITION;
		public String SLOTMENU_ORDER;

		
		public Settings(int userID, String SET, String MINIMAP_SCALE,
				String DISPLAY_PLAYER_NAMES, String DISPLAY_CHAT, String PLAY_MUSIC, String PLAY_SFX,
				String BAR_STATUS, String WINDOW_SETTINGS, String AUTO_REFINEMENT,
				String QUICKSLOT_STOP_ATTACK, String DOUBLECLICK_ATTACK, String AUTO_START,
				String DISPLAY_NOTIFICATIONS, String SHOW_DRONES, String DISPLAY_WINDOW_BACKGROUND,
				String ALWAYS_DRAGGABLE_WINDOWS, String PRELOAD_USER_SHIPS, String QUALITY_PRESETTING,
				String QUALITY_CUSTOMIZED, String QUALITY_BACKGROUND, String QUALITY_POIZONE,
				String QUALITY_SHIP, String QUALITY_ENGINE, String QUALITY_COLLECTABLE,
				String QUALITY_ATTACK, String QUALITY_EFFECT, String QUALITY_EXPLOSION,
				String QUICKBAR_SLOT, String SLOTMENU_POSITION, String SLOTMENU_ORDER) 
		{
			this.userID = userID;
			this.SET = SET;
			this.MINIMAP_SCALE = MINIMAP_SCALE;
			this.DISPLAY_PLAYER_NAMES = DISPLAY_PLAYER_NAMES;
			this.DISPLAY_CHAT = DISPLAY_CHAT;
			this.PLAY_MUSIC = PLAY_MUSIC;
			this.PLAY_SFX = PLAY_SFX;
			this.BAR_STATUS = BAR_STATUS;
			this.WINDOW_SETTINGS = WINDOW_SETTINGS; 
			this.AUTO_REFINEMENT = AUTO_REFINEMENT;
			this.QUICKSLOT_STOP_ATTACK = QUICKSLOT_STOP_ATTACK;
			this.DOUBLECLICK_ATTACK = DOUBLECLICK_ATTACK;
			this.AUTO_START = AUTO_START;
			this.DISPLAY_NOTIFICATIONS = DISPLAY_NOTIFICATIONS;
			this.SHOW_DRONES = SHOW_DRONES;
			this.DISPLAY_WINDOW_BACKGROUND = DISPLAY_WINDOW_BACKGROUND;
			this.ALWAYS_DRAGGABLE_WINDOWS = ALWAYS_DRAGGABLE_WINDOWS;
			this.PRELOAD_USER_SHIPS = PRELOAD_USER_SHIPS;
			this.QUALITY_PRESETTING = QUALITY_PRESETTING;
			this.QUALITY_CUSTOMIZED = QUALITY_CUSTOMIZED;
			this.QUALITY_BACKGROUND = QUALITY_BACKGROUND;
			this.QUALITY_POIZONE = QUALITY_POIZONE;
			this.QUALITY_SHIP = QUALITY_SHIP;
			this.QUALITY_ENGINE = QUALITY_ENGINE;
			this.QUALITY_COLLECTABLE = QUALITY_COLLECTABLE;
			this.QUALITY_ATTACK = QUALITY_ATTACK;
			this.QUALITY_EFFECT = QUALITY_EFFECT;
			this.QUALITY_EXPLOSION = QUALITY_EXPLOSION;
			this.QUICKBAR_SLOT = QUICKBAR_SLOT;
			this.SLOTMENU_POSITION = SLOTMENU_POSITION;
			this.SLOTMENU_ORDER = SLOTMENU_ORDER;
		}

		public int getUserID() {
			return userID;
		}

		public void setUserID(int userID) {
			this.userID = userID;
		}
		
		public static Settings getSettingByUserID(int id)
		{
			return World.getSettingByID(id);
		}
	}
	

}
