package common;

public class Constantes {
	
	//Versiones
	public static final	String VERSION_CLIENTE	= "4.1";
	public static final boolean IGNORAR_VERSION = false;
	//Lista de baneados
	public static String BAN_IP = "";

	public static boolean compararIPConBanIP(String ip)
	{
		String[] split = BAN_IP.split(",");
		for(String ipsplit : split)
		{
			if(ip.compareTo(ipsplit) == 0) return true;
		}
		
		return false;
	}
}
