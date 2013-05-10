package utils;

import game.Usuarios;

import java.util.Random;

import common.World;

import net.SocketManager;

public class Formulas {

	public static int getRandomValue(int i1,int i2)
	{
		Random rand = new Random();
		return (rand.nextInt((i2-i1)+1))+i1;
	}
	
	public static long getXpNecesaria(int lvl)
	{
		long xp = (World.getUserXpMax(lvl) - World.getUserXpMin(lvl));		
		return xp;
	}
	
	public static int parseBoolean(boolean b)
	{
		int n = 0;
		if(b == true)n=1;
		return n;
	}
	
	public static String getPrecioVentas(long honor)
	{
		//(1 + puntos de honor / 500.000)
		/*Prometium: 50.000 de honor = +1 crédito
		Endurium: 33.333 de honor = +1 crédito
		Terbium: 20.000 de honor = +1 crédito
		Prometid y Duranium: 2.500 de honor = +1 crédito
		Promerium: 1.000 de honor = 1 crédito*/
		int prometium = (int) (10 * (1 + ((double)honor / (double)500000)));
		int endurium = (int) (15 * (1 + ((double)honor / (double)500000)));
		int terbium = (int) (25 * (1 + ((double)honor / (double)500000)));
		int prometid = (int) (200 * (1 + ((double)honor / (double)500000)));
		int duranium = (int) (200 * (1 + ((double)honor / (double)500000)));
		int promerium = (int) (500 * (1 + ((double)honor / (double)500000)));
		String precios = prometium + "|"+endurium+"|"+terbium+"|"+prometid+"|"+duranium+"|"+promerium+"|15";
		return precios;
	}
	
	public static void getGifts(Usuarios _user)
	{
		int bonusID = Formulas.getRandomValue(0, 13);
		switch(bonusID)
		{
			case 1:
				double jackpot = _user.getJackpot() + 0.1;
				_user.setJackpot(jackpot);
				SocketManager.send(_user, "0|LM|ST|JPE|0.1|"+_user.getJackpot());
			break;
			case 2:
				jackpot = _user.getJackpot() + 0.25;
				_user.setJackpot(jackpot);
				SocketManager.send(_user, "0|LM|ST|JPE|0.25|"+_user.getJackpot());
			break;
			case 3:
				jackpot = _user.getJackpot() + 0.75;
				_user.setJackpot(jackpot);
				SocketManager.send(_user, "0|LM|ST|JPE|0.75|"+_user.getJackpot());
			break;
			case 4:
				jackpot = _user.getJackpot() + 1.0;
				_user.setJackpot(jackpot);
				SocketManager.send(_user, "0|LM|ST|JPE|1.0|"+_user.getJackpot());
			break;
			case 5:
				long creditos = _user.getCreditos() + 500;
				_user.setCreditos(creditos);
				SocketManager.send(_user, "0|LM|ST|CRE|500|"+creditos);
			break;
			case 6:
				creditos = _user.getCreditos() + 1000;
				_user.setCreditos(creditos);
				SocketManager.send(_user, "0|LM|ST|CRE|1000|"+creditos);
			break;
			case 7:
				creditos = _user.getCreditos() + 1500;
				_user.setCreditos(creditos);
				SocketManager.send(_user, "0|LM|ST|CRE|1500|"+creditos);
			break;
			case 8:
				creditos = _user.getCreditos() + 5000;
				_user.setCreditos(creditos);
				SocketManager.send(_user, "0|LM|ST|CRE|5000|"+creditos);
			break;
			case 9:
				long uris = _user.getUridium() + 1;
				_user.setUridium(uris);
				SocketManager.send(_user, "0|LM|ST|URI|1|"+uris);
			break;
			case 10:
				uris = _user.getUridium() + 25;
				_user.setUridium(uris);
				SocketManager.send(_user, "0|LM|ST|URI|25|"+uris);
			break;
			case 11:
				uris = _user.getUridium() + 50;
				_user.setUridium(uris);
				SocketManager.send(_user, "0|LM|ST|URI|50|"+uris);
			break;
			case 12:
				uris = _user.getUridium() + 75;
				_user.setUridium(uris);
				SocketManager.send(_user, "0|LM|ST|URI|75|"+uris);
			break;
			case 13:
				uris = _user.getUridium() + 100;
				_user.setUridium(uris);
				SocketManager.send(_user, "0|LM|ST|URI|100|"+uris);
			break;
			
			default:
				creditos = _user.getCreditos() + 200;
				_user.setCreditos(creditos);
				SocketManager.send(_user, "0|LM|ST|CRE|200|"+creditos);
			break;
		}
	}
}
