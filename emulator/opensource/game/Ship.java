package game;

import java.util.Timer;
import java.util.TimerTask;

import net.SocketManager;
import utils.Formulas;

import common.IA;
import common.IA.IAThread;
import common.SQLManager;

public class Ship {
	
	private int id;
	private int tipo; //1: Usuario, 2: Alien, 3: MotherAlien
	private Usuarios nave;
	private NPC npc;
	private String nombre;
	private int gfx;
	private int posX;
	private int posY;
	private int fractionID;
	private int hp;
	private int esc;
	private boolean isDead = true;
	private boolean isNPC = false;
	private boolean warnIconOnMap = false;
	private boolean isAttacked = false;
	private boolean isZonaRadiactiva = false;
	private boolean isZonaSegura = false;
	private boolean isMoviendo = false;
	private boolean isPlay = false;
	private Timer damageTimer;
	private Timer moveTimer;
	private boolean cinturonRadiactivo = false;
	private IAThread IA;
	private Ship target = null;
	
	public Ship(Usuarios nave)
	{
		this.id = nave.getId();
		this.tipo = 1;
		this.nave = nave;
		this.nombre = nave.getUsuario();
		this.gfx = nave.getGfx();
		this.posX = Integer.parseInt(nave.getPos().split("\\|")[0]);
		this.posY = Integer.parseInt(nave.getPos().split("\\|")[1]);	
		this.fractionID = Mapas.getSeccionID(nave.getMapa(), posX, posY);
		this.isNPC = false;
		this.damageTimer = new Timer();
		damageTimer.scheduleAtFixedRate(new DamageTask(), 3000, 1000);
		this.moveTimer = new Timer();
		moveTimer.scheduleAtFixedRate(new moveShip(), 370, 370);
	}
	
	public Ship(int id, NPC npc)
	{
		this.id = id;
		this.tipo = 2;
		this.npc = npc;
		this.nombre = npc.getNombre();
		this.gfx = npc.getGfx();
		this.posX = 0;
		this.posY = 0;
		this.fractionID = 1;
		this.hp = npc.getPv();
		this.esc = npc.getEsc();
		this.isNPC = true;		
		this.IA = new IA.IAThread(this);
	}

	public void addShipDamageRadiacion()
	{
		SocketManager.send(nave, "0|D|10400|6400|0|0|1|1|1|"+nave.getBono_reparacion());
	}
	
	public class DamageTask extends TimerTask {
        public void run() 
        {
	       	 if(isZonaRadiactiva == false)
	    	 {
				if(cinturonRadiactivo==true)
				{
					damageTimer.cancel();
				}
				cinturonRadiactivo=false;
				return;
	    	 }else{
	    		 if(nave.getEscudo()<0)nave.setEscudo(0);
	    		 if(nave.getHp()<0)
	    		 {
	    			 nave.setHp(0);  			 
	    			 SQLManager.ACTUALIZAR_DATOS_USUARIO(nave);
	    			 SocketManager.GAME_SEND_DESTROY_SHIP(nave.getId());
	    			 damageTimer.cancel();
	    			 return;
	    		 }else{
		    		 nave.setHp(nave.getHp()-1000);
		    		 nave.setEscudo(nave.getEscudo()-1000);
		    		 SocketManager.send(nave, "0|Y|"+id+"|"+id+"|L|"+
		 					nave.getHp()+"|"+nave.getEscudo()+"|"+1000+"|"+1000);
	    		 }
	    	 }       			    	 
        }
    }
	
	public class moveShip extends TimerTask {
        public void run() 
        {
        	if(nave==null)
        	{
        		moveTimer = null;
        		return;
        	}
        	if(nave!=null)SocketManager.GAME_SEND_MOVE_SHIP(nave.getGameThread().get_out(), nave);
        }
    }
	
	
	
	public void updateShipMovement()
	{
		//[posX|posY] (Posicion cursor)|Delimitar zona|Permite recuperarse|Zona de venta|Zona de radiacion|Zona de teleportacion|Cantidad de teletransporte
		int zona_segura = Formulas.parseBoolean(this.isZonaSegura);
		SocketManager.send(this.getNave(), "0|D|10400|6400|"+zona_segura+"|1|1|0|1|"+this.getNave().getBono_reparacion());
	}
	
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public NPC getNpc() {
		return npc;
	}

	public void setNpc(NPC npc) {
		this.npc = npc;
	}

	public Usuarios getNave() {
		return nave;
	}

	public void setNave(Usuarios nave) {
		this.nave = nave;
	}

	public int getTipo() {
		return tipo;
	}

	public void setTipo(int tipo) {
		this.tipo = tipo;
	}

	public boolean isDead() {
		return isDead;
	}
	
	public void setDead(boolean isDead) {
		this.isDead = isDead;
	}

	public boolean isNPC() {
		return isNPC;
	}

	public void setNPC(boolean isNPC) {
		this.isNPC = isNPC;
	}

	public int getFractionID() {
		return fractionID;
	}

	public void setFractionID(int fractionID) {
		this.fractionID = fractionID;
	}
	
	public int getPosX() {
		return posX;
	}

	public void setPosX(int posX) {
		this.posX = posX;
	}

	public int getPosY() {
		return posY;
	}

	public void setPosY(int posY) {
		this.posY = posY;
	}

	public boolean isWarnIconOnMap() {
		return warnIconOnMap;
	}

	public void setWarnIconOnMap(boolean warnIconOnMap) {
		this.warnIconOnMap = warnIconOnMap;
	}
	
	public boolean getIsNPC() {
		return isNPC;
	}

	public void setIsNPC(boolean isNPC) {
		this.isNPC = isNPC;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public int getGfx() {
		return gfx;
	}

	public void setGfx(int gfx) {
		this.gfx = gfx;
	}

	public boolean isAttacked() {
		return isAttacked;
	}

	public void setAttacked(boolean isAttacked) {
		this.isAttacked = isAttacked;
	}

	public int getHp() {
		return hp;
	}

	public void setHp(int hp) {
		this.hp = hp;
	}

	public int getEsc() {
		return esc;
	}

	public void setEsc(int esc) {
		this.esc = esc;
	}

	public boolean isZonaRadiactiva() {
		return isZonaRadiactiva;
	}

	public void setZonaRadiactiva(boolean isZonaRadiactiva) {
		this.isZonaRadiactiva = isZonaRadiactiva;
	}

	public boolean isZonaSegura() {
		return isZonaSegura;
	}

	public void setZonaSegura(boolean isZonaSegura) {
		this.isZonaSegura = isZonaSegura;
	}

	public boolean isMoviendo() {
		return isMoviendo;
	}

	public void setMoviendo(boolean isMoviendo) {
		this.isMoviendo = isMoviendo;
	}

	public boolean isPlay() {
		return isPlay;
	}

	public void setPlay(boolean isPlay) {
		this.isPlay = isPlay;
	}

	public IAThread getIA() {
		return IA;
	}

	public void setIA(IAThread iA) {
		IA = iA;
	}

	public Ship getTarget() {
		return target;
	}

	public void setTarget(Ship target) {
		this.target = target;
	}



}
