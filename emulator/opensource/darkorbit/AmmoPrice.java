package darkorbit;

public class AmmoPrice {
	
	public int ammoID;
	public int amount;
	public int summedPrice;
	public int currency;
	public int category;
	public static int CURRENCY_URIDIUM = 0;
	public static int CURRENCY_CREDITS = 1;
	public static int CATEGORY_LASER = 0;
	public static int CATEGORY_ROCKET = 1;

	public AmmoPrice(int param1, int param2, int param3, int param4, String param5)
	{
		this.category = param1;
		this.ammoID = param3;
		this.amount = param2;
		this.summedPrice = param4;
		if (param5 == "U")
		{
        this.currency = CURRENCY_URIDIUM;
		}
		else if (param5 == "C")
		{
        this.currency = CURRENCY_CREDITS;
		}
	}

}
