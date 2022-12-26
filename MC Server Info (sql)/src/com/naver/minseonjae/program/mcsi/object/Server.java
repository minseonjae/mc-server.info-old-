package com.naver.minseonjae.program.mcsi.object;

import lombok.Data;

@Data
public class Server {
	private int id = -1, port = -1, protocol = -1, players = 0, maxplayers = 0, uptime = 0, ping = -1;
	private String name = null, address = null, version = null, motd = null, last_Get = null, last_Chack = null;
	private boolean get = false, srv = false;
}
