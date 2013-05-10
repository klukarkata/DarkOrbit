package policyserver;

import java.net.*;

import common.DarkOrbit;

public class PolicyServerThread extends Thread {
	protected int port;
	protected ServerSocket serverSocket;
    protected boolean listening;
    
    private DarkOrbit _main;
	
	public PolicyServerThread(int port, DarkOrbit main)
	{
		this.port = port;
		this.listening = false;
		this._main = main;
	}
	
	public void run()
	{
		try {
			this.serverSocket = new ServerSocket(this.port);
			this.listening = true;
			System.out.println("Policy Server abierto por el puerto " + this.port);
			
			while(this.listening)
			{
				Socket socket = serverSocket.accept();
				PolicyServerConnection socketConnection = new PolicyServerConnection(socket, this._main);
				socketConnection.start();
			}
		}
        catch (Exception e) {
        	System.out.println("Exception (run): " + e.getMessage());
        }
	}
	
	protected void finalize() {	 
        try {
            this.serverSocket.close();
            this.listening = false;
        }
        catch (Exception e) {
        	System.out.println("Exception (finalize): " + e.getMessage());
        }
    }
}