package policyserver;

import common.*;

public class PolicyServer {
	@SuppressWarnings("unused")
	private DarkOrbit _main;
	
	public static final String POLICY_REQUEST = "<policy-file-request/>";
    public static final String POLICY_XML =
            "<?xml version=\"1.0\"?>"
            + "<cross-domain-policy>"
            + "<allow-access-from domain=\"*\" to-ports=\"*\" />"
            + "</cross-domain-policy>";
	
	public PolicyServer(DarkOrbit main)
	{
		_main = main;
		
		PolicyServerThread policyServer = new PolicyServerThread(new Integer(843), main);
		policyServer.start();
	}
}