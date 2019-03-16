package seonjae.program.msi.thread;

import java.io.File;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;

import seonjae.json.JSON;
import seonjae.json.JSONFile;
import seonjae.json.JSONFormat;
import seonjae.util.NumberUtil;
import seonjae.util.StringUtil;
import seonjae.program.msi.MCSI;

public class StatsThread extends Thread{
	public void run() {
		MCSI.getGui().appendServerLog("서버 통계 시작");
		
		HashMap<String, Integer> servers1 = new HashMap<>();
		HashMap<String, Integer> servers2 = new HashMap<>();
		HashMap<String, Integer> servers3 = new HashMap<>();

		HashMap<String, Integer> version = new HashMap<>();
		
		MCSI.getFileManager().loadVersion();
		
		int players = 0;
		
		for (File f : MCSI.getFileManager().getDataFolder().listFiles()) {
			if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
			JSONFile jsonf = new JSONFile(f.getPath()).load();
			String name = f.getName().substring(0, f.getName().length() - 5);
			
			File listf = new File(MCSI.getFileManager().getListFolder().getPath() + "/" + f.getName());
			if (listf.exists()) {
				JSONFile listJSON = new JSONFile(listf.getPath()).load();
				if (listJSON.get("ban") != null) if (listJSON.getBoolean("ban")) continue;
			}
			
			if (!jsonf.getJSON("peak").getJSON("today").getString("time").equals("?")) servers2.put(name, jsonf.getJSON("peak").getJSON("today").getInt("players"));
			if (!jsonf.getJSON("peak").getJSON("allday").getString("time").equals("?")) servers3.put(name, jsonf.getJSON("peak").getJSON("allday").getInt("players"));
			
			if (!jsonf.getBoolean("online")) continue;
			
			players += jsonf.getInt("players");
			servers1.put(name, jsonf.getInt("players"));
			boolean add = true;
			test : for (String v : MCSI.getVersion().keySet()) {
				if (MCSI.getVersion().get(v).contains(jsonf.getString("version"))) {
					version.put(v, version.get(v) == null ? 1 : version.get(v) + 1);
					add = false;
					break test;
				}
			}
			if (add) version.put(jsonf.getString("version"), version.get(jsonf.getString("version")) == null ? 1 : version.get(jsonf.getString("version")) + 1);
		}
		
		String[] name1 = servers1.keySet().toArray(new String[servers1.size()]);
		String[] name2 = servers2.keySet().toArray(new String[servers2.size()]);
		String[] name3 = servers3.keySet().toArray(new String[servers3.size()]);
		
		for (int i = 0; i < servers1.size(); i++) {
			for (int j = 0; j < servers1.size() - (i + 1); j++) {
				if (servers1.get(name1[j]) < servers1.get(name1[j + 1])) {
					String temp1 = name1[j + 1];
					name1[j + 1] = name1[j];
					name1[j] = temp1;
				}
			}
		}
		for (int i = 0; i < servers2.size(); i++) {
			for (int j = 0; j < servers2.size() - (i + 1); j++) {
				if (servers2.get(name2[j]) < servers2.get(name2[j + 1])) {
					String temp1 = name2[j + 1];
					name2[j + 1] = name2[j];
					name2[j] = temp1;
				}
			}
		}
		for (int i = 0; i < servers3.size(); i++) {
			for (int j = 0; j < servers3.size() - (i + 1); j++) {
				if (servers3.get(name3[j]) < servers3.get(name3[j + 1])) {
					String temp1 = name3[j + 1];
					name3[j + 1] = name3[j];
					name3[j] = temp1;
				}
			}
		}
		
		new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/PlayersTop.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("top", Arrays.asList(name1));
			}
		}).save();
		
		new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/AlldayPlayersTop.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("top", Arrays.asList(name3));
			}
		}).save();
		
		new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/Version.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				for (String name : version.keySet()) json.put(name, version.get(name));
			}
		}).save();
		
		JSONFile today = new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/TodayPlayersTop.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("day", "00");
				json.put("top", Arrays.asList());
			}
		}).load();
		JSONFile uptime = new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/uptime.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("uptime", 0);
			}
		}).load();
		
		String day = StringUtil.dateString("dd");
		
		if (NumberUtil.getInteger(StringUtil.dateString("mm")) % 10 == 0) {
			
			String time = StringUtil.dateString("kk:mm");
			
			JSONFile chart1 = new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/Chart.json", new JSONFormat() {
				public void initalJSON(JSON json) {
					json.put("time", Arrays.asList());
					json.put("players", Arrays.asList());
				}
			}).load();
			List<String> times1 = chart1.getStringList("time");
			List<Integer> players1 = chart1.getIntegerList("players");
			
			if (times1.size() >= MCSI.getChart_Size()) {
				times1.remove(0);
				players1.remove(0);
			}
			
			times1.add(time);
			players1.add(players);
			
			chart1.getJSON().put("time", times1);
			chart1.getJSON().put("players", players1);
			
			chart1.save();
			
			JSONFile chart2 = new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/" + StringUtil.dateString("yyyy-MM-dd") + "/Chart.json", new JSONFormat() {
				public void initalJSON(JSON json) {
					json.put("time", Arrays.asList());
					json.put("players", Arrays.asList());
				}
			}).load();
			List<String> times2 = chart2.getStringList("time");
			List<Integer> players2 = chart2.getIntegerList("players");
			
			if (times2.size() >= MCSI.getChart_Size()) {
				times2.remove(0);
				players2.remove(0);
			}
			
			times2.add(time);
			players2.add(players);
			
			chart2.getJSON().put("time", times2);
			chart2.getJSON().put("players", players2);
			
			chart2.save();
		}
		
		if (!today.getString("day").equals(day)) {
			uptime.getJSON().put("uptime", 0);
			today.getJSON().put("day", day);
			new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/YesterdayPlayersTop.json", new JSONFormat() {
				public void initalJSON(JSON json) {
					json.put("top", today.getStringList("top"));
				}
			}).save();
		} else uptime.getJSON().put("uptime", uptime.getInt("uptime") + 1);
		
		uptime.save();
		
		today.getJSON().put("top", Arrays.asList(name2));
		today.save();
		
		JSONFile playersf = new JSONFile(MCSI.getFileManager().getFolder().getPath() + "/Players.json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("players", 0);
				JSON peak = new JSON();
				peak.put("day", 00);
				JSON allday = new JSON();
				allday.put("time", "?");
				allday.put("players", 0);
				peak.put("allday", allday);
				JSON today = new JSON();
				today.put("time", "?");
				today.put("players", 0);
				peak.put("today", today);
				JSON yesterday = new JSON();
				yesterday.put("time", "?");
				yesterday.put("players", 0);
				peak.put("yesterday", yesterday);
				json.put("peak", peak);
			}
		}).load();
		playersf.getJSON().put("players", players);
		JSON peak = playersf.getJSON("peak");
		if (peak.getJSON("allday").getInt("players") < players) {
			peak.getJSON("allday").put("time", StringUtil.dateString("yyyy-MM-dd a hh:mm:ss"));
			peak.getJSON("allday").put("players", players);
		}
		
		if (!peak.getString("day").equals(day)) {
			peak.put("day", day);
			peak.getJSON("yesterday").put("players", peak.getJSON("today").getInt("players"));
			peak.getJSON("yesterday").put("time", peak.getJSON("today").getString("time"));
			peak.getJSON("today").put("players", 0);
			peak.getJSON("today").put("time", "?");
		}
		
		if (peak.getJSON("today").getInt("players") < players) {
			peak.getJSON("today").put("players", players);
			peak.getJSON("today").put("time", StringUtil.dateString("a hh:mm:ss"));
		}
		
		playersf.save();
		
		MCSI.getGui().appendServerLog("서버 통계 저장 성공");
	}
}
