package common;

import game.Mapas;
import game.Ship;
import game.Usuarios;
import net.SocketManager;
import utils.Formulas;

public class IA {
	
	//0 : Tranquilo | 1: Agresivo | 2: Apacible | 3: Muy Agresivo | 4: Pacifico
	
	public static class IAThread implements Runnable
	{
		private Ship _fighter;
		public static boolean stop = false;
		private Thread _t;
		
		public IAThread(Ship fighter)
		{
			_fighter = fighter;
			_t = new Thread(this);
			_t.setDaemon(true);
			_t.start();
		}
		public void run()
		{
			stop = false;
			if(_fighter.getNpc() == null)
			{
					try {
						Thread.sleep(2000);
					} catch (InterruptedException e) {};
			}else{
				switch(_fighter.getNpc().getIA())
				{
					case 0://No hace nada
						apply_type0(_fighter);
					break;
					case 1://Sigue y ataca
						apply_type1(_fighter);
					break;
				}
				try {
					Thread.sleep(2000);
				} catch (InterruptedException e) {};
			}
		}
		
		private static void apply_type0(Ship F)
		{
			if(F.isDead() == true && F.isPlay() == false)return;
			Ship T = F.getTarget();
			if(F.getTarget() == null)for(Usuarios users: Mapas.getNaves())T = users.getShip();
			long hp = (F.getHp()*100)/F.getNpc().getPv();
			//Si tiene menos del 35% de la vida se esconde
			if(hp > 35)
			{
				seguirNave(F,T);				
			}else
			{
				esconder(F);
			}
			stop = true;
		}
		
		private static void apply_type1(Ship F)
		{
			if(F.isDead() == true && F.isPlay() == false)return;
			Ship T = F.getTarget();
			if(F.getTarget() == null)for(Usuarios users: Mapas.getNaves())T = users.getShip();
			long hp = (F.getHp()*100)/F.getNpc().getPv();
			//Si tiene menos del 35% de la vida se esconde
			if(hp > 35)
			{
				seguirNave(F,T);
				atacarNave(F,T);				
			}else
			{
				esconder(F);
			}
			stop = true;
		}
		
		
		private static void atacarNave(Ship F, Ship T) 
		{
			int dmg = 0;
			if(F.getNpc().getDmg().charAt(0)=='D')
				dmg = Formulas.getRandomValue(Integer.parseInt(F.getNpc().getDmg().substring(1).split("\\,")[0]),
						Integer.parseInt(F.getNpc().getDmg().substring(1).split("\\,")[1]));			
			int dmgESC = dmg;
			SocketManager.send(T.getNave().getGameThread().get_out(), "0|a|"+F.getId()+"|"+T.getId()+"|"+0+"|0|0");
			SocketManager.send(T.getNave().getGameThread().get_out(), "0|Y|"+F.getId()+"|"+T.getId()+"|L|"+T.getNave().getHp()+"|"+T.getNave().getEscudo()+
					"|"+dmg+"|"+dmgESC+"|0");	
		}
		private static void seguirNave(Ship F, Ship T)
		{
			int posX = Integer.parseInt(T.getNave().getPos().split("\\|")[0]) - 50;
			int posY = Integer.parseInt(T.getNave().getPos().split("\\|")[1]) - 50;
			F.setPosX(posX);
			F.setPosY(posY);
			SocketManager.MOVE_ALIEN(F, 5000);

		}
		private static void esconder(Ship F)
		{
			int posX = 0;
			int posY = 0;
			F.setPosX(posX);
			F.setPosY(posY);
			SocketManager.MOVE_ALIEN(F, 500);
		}
		
	}
}
