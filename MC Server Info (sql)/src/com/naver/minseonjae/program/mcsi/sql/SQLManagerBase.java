package com.naver.minseonjae.program.mcsi.sql;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;

import com.naver.minseonjae.program.mcsi.MCSI;

import lombok.Cleanup;
import lombok.Getter;
import lombok.SneakyThrows;

@Getter
public class SQLManagerBase {
	
	private Connection connection = null;
	
	public boolean connect(String address, int port, String database, String user, String password) {
		try {

			connection = DriverManager.getConnection("jdbc:mysql://" + address + ":" + port + "/" + database + "?autoReconnect=true", user, password);
			
			createTable();

			MCSI.log("MySql에 연결되었습니다.");
		} catch(Exception e) {
			e.printStackTrace();
			
			MCSI.log("MySql에 연결할 수 없습니다.");
			return false;
		}

		onConnected();

		return true;
	}
	
	public void close() {
		try {
			if(connection == null) return;
			
			connection.close();
			
			MCSI.log("MySql과의 연결을 종료했습니다.");
		} catch(Exception e) {
			e.printStackTrace();
			
			MCSI.log("MySql과의 연결을 종료하는 중 오류가 발생했습니다.");
		}
	}

	public void onConnected() { }

	public boolean isConnected() {
		return connection != null;
	}
	
	@SneakyThrows(SQLException.class)
	public void update(String sql) {
		sql = sql.replace("\\", "\\\\");

		@Cleanup PreparedStatement state = connection.prepareStatement(sql);
		state.executeUpdate();
	}
	
	public void updatef(String sql, Object...args) {
		update(String.format(sql, args));
	}
	
	@SneakyThrows(SQLException.class)
	public PreparedStatement getPreparedStatement(String sql) {
		return connection.prepareStatement(sql);
	}
	
	public PreparedStatement getPreparedStatementf(String sql, Object...args) {
		return getPreparedStatement(String.format(sql, args));
	}
	
	public void createTable() { }
	
	public void createTable(String name, String calumn) {
		update("create table if not exists " + name + " (" + calumn + ")");
	}
	
	public void deleteTable(String name) {
		update("drop table " + name);
	}
	
	public void truncateTable(String name) {
		update("truncate table " + name);
	}
	
}