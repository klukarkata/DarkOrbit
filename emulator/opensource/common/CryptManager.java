package common;

public class CryptManager {
	
	public static String CryptIP(String IP)
    {
		String[] Splitted = IP.split("\\.");
		String Encrypted = "";
        int Count = 0;
        for (int i = 0; i < 50; i++)
        {
            for (int o = 0; o < 50; o++)
            {
                if (((i & 15) << 4 | o & 15) == Integer.parseInt(Splitted[Count]))
                {
                    Character A = (char)(i+48);
                    Character B = (char)(o + 48);
                    Encrypted += A.toString() + B.toString();
                    i = 0;
                    o = 0;
                    Count++;
                    if (Count == 4)
                        return Encrypted;
                }
            }
        }
        return "DD";
    }
	
	public static String CryptPort(int config_game_port)
	{
		char[] HASH = {'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
	            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
	            'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_'};
		int P = config_game_port;
		String nbr64 = "";
		for(int a = 2;a>=0;a--)
		{
			nbr64 += HASH[(int)(P/(java.lang.Math.pow(64,a)))];
			P = (int)(P%(int)(java.lang.Math.pow(64,a)));
		}
		return nbr64;
	}

	public static int getIntByHashedValue(char c)
	{
		char[] HASH = {'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
	            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
	            'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_'};
		for(int a = 0;a<HASH.length; a++)
		{
			if(HASH[a] == c)
			{
				return a;
			}
		}	
		return -1;
	}
	
	public static char getHashedValueByInt(int c)
	{
		char[] HASH = {'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
	            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
	            'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_'};	
		return HASH[c];
	}
	
	//Funcion que convierte todos los textos ANSI(Unicode) en UTF-8.
	public static String toUtf(String _in)
	{
		String _out = "";

		try
		{
			_out = new String(_in.getBytes("UTF8"));
			
		}catch(Exception e)
		{
			System.out.println ("Conversion en UTF-8 echo! : "+e.getMessage());
		}
		
		return _out;
	}
	//Utilizado para convertir entradas UTF-8 en String normal.
	public static String toUnicode(String _in)
	{
		String _out = "";

		try
		{
			_out = new String(_in.getBytes(),"UTF8");
			
		}catch(Exception e)
		{
			System.out.println ("Conversion en UTF-8 echo! : "+e.getMessage());
		}
		
		return _out;
	}
	
	public static byte[] stringToByteArray(String data)
    {
        if (data != "")
        {
            return data.getBytes();
        }
        return null;
    }

}
