package com.naver.minseonjae.program.mcsi.manager;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

import com.naver.minseonjae.program.mcsi.object.Server;
import com.naver.minseonjae.program.mcsi.sql.SQLManagerBase;
import com.naver.minseonjae.program.mcsi.sql.SQLTable;

import lombok.Cleanup;
import lombok.Getter;
import lombok.Setter;
import lombok.SneakyThrows;

public class SQLManager extends SQLManagerBase{
	
	
	@Getter
	@Setter
	private String address, database, user, password;
	@Getter
	@Setter
	private int port;
	
	@Getter
	private SQLTable servers_Data, servers_Peak, servers_All_Peak, servers_Chart, servers_Version,
					server_List, server_Data, server_Peak, server_All_Peak, server_Chart;
	
	public void createTable() {
		create_ServersTable();
		create_ServerTable();
	}
	
	public void create_ServersTable() {
		servers_Data = new SQLTable(this, "servers_data", "id int primary key, uptime int, players int, online int").createTable();
		servers_Peak = new SQLTable(this, "servers_peak", "year int, month int, day int, time varchar(32), players int").createTable();
		servers_All_Peak = new SQLTable(this, "servers_all_peak", "year int, month int, day int, time varchar(32), players int").createTable();
		servers_Chart = new SQLTable(this, "servers_chart", "year int, month int, day int, time varchar(32), players int").createTable();
		servers_Version = new SQLTable(this, "servers_version", "version varchar(255), servers int").createTable();
	}
	public void create_ServerTable() {
		server_List = new SQLTable(this, "server_list", "id int primary key not null auto_increment, name varchar(255), address varchar(255), port int").createTable();
		server_Data = new SQLTable(this, "server_data", "id int primary key, version varchar(255), protocol int, motd varchar(255), players int, maxplayers int, uptime int, ping int, srv boolean, last_get varchar(32), last_check varchar(32)").createTable();
		server_Peak = new SQLTable(this, "server_peak", "id int primary key, year int, month int, day int, time varchar(32), players int").createTable();
		server_All_Peak = new SQLTable(this, "server_all_peak", "id int primary key, year int, month int, day int, time varchar(32), players int").createTable();
		server_Chart = new SQLTable(this, "server_chart", "id int primary key, year int, month int, day int, time varchar(32), players int").createTable();
	}
	
	public boolean connect() {
		return super.connect(address, port, database, user, password);
	}
	
	public void setServerData(Server server) {
	}
	@SneakyThrows
	public ArrayList<Server> getServers() {
		@Cleanup PreparedStatement ps = server_List.select("*");
		@Cleanup ResultSet rs = ps.executeQuery();
		ArrayList<Server> list = new ArrayList<Server>();
		
		while (rs.next()) {
			Server server = new Server();
			server.setId(rs.getInt("id"));
			server.setName(rs.getString("name"));
			server.setAddress(rs.getString("address"));
			server.setPort(rs.getInt("port"));
		}
		
		return list;
	}
}
