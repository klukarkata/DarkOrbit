package policyserver;

import java.io.*;
import java.net.*;

import common.DarkOrbit;
public class PolicyServerConnection extends Thread{
	protected Socket socket;
    protected BufferedReader socketIn;
    protected PrintWriter socketOut;
    
    @SuppressWarnings("unused")
	private DarkOrbit _main;
    
    public PolicyServerConnection(Socket socket, DarkOrbit main)
    {
    	this.socket = socket;
    	this._main = main;
    }
    
    public void run() {
        try {
            this.socketIn = new BufferedReader(new InputStreamReader(this.socket.getInputStream()));
            this.socketOut = new PrintWriter(this.socket.getOutputStream(), true);
            readPolicyRequest();
        }
        catch (Exception e) {
        	System.out.println("Exception (run): " + e.getMessage());
        }
    }
    
    protected void readPolicyRequest() {
        try {
            String request = read();
            
            if (request.equals(PolicyServer.POLICY_REQUEST)) {
               writePolicy();
            }
        }
        catch (Exception e) {
        	System.out.println("Exception (readPolicyRequest): " + e.getMessage());
        }
        finalize();
    }
    
    protected void writePolicy() {
        try {
            this.socketOut.write(PolicyServer.POLICY_XML + "\u0000");
            this.socketOut.close();
        }
        catch (Exception e) {
        	System.out.println("Exception (writePolicy): " + e.getMessage());
        }
    }
    
    protected String read() {
        StringBuffer buffer = new StringBuffer();
        int codePoint;
        boolean zeroByteRead = false;
        
        try {
            do {
                codePoint = this.socketIn.read();

                if (codePoint == 0) {
                    zeroByteRead = true;
                }
                else if (Character.isValidCodePoint(codePoint)) {
                    buffer.appendCodePoint(codePoint);
                }
            }
            while (!zeroByteRead && buffer.length() < 200);
        }
        catch (Exception e) {
        	System.out.println("Exception (read): " + e.getMessage());
        }
        
        return buffer.toString();
    }
    
    protected void finalize() {	 
        try {
            this.socketIn.close(); 
            this.socketOut.close();
            this.socket.close();
        }
        catch (Exception e) {
        	System.out.println("Exception (finalize): " + e.getMessage());
        }
    }
}