package seonjae.program.msi.thread;

import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.InetSocketAddress;
import java.net.Socket;
import java.nio.charset.Charset;
import java.util.Arrays;
import java.util.List;

import org.xbill.DNS.Lookup;
import org.xbill.DNS.Record;
import org.xbill.DNS.SRVRecord;
import org.xbill.DNS.TextParseException;
import org.xbill.DNS.Type;

import lombok.Cleanup;
import lombok.Getter;

import seonjae.json.JSON;
import seonjae.json.JSONFile;
import seonjae.json.JSONFormat;
import seonjae.util.NumberUtil;
import seonjae.util.StringUtil;
import seonjae.program.msi.MCSI;

public class DataThread extends Thread {
	
	public DataThread(String name, String ip, int port) {
		this.serverName = name;
		this.ip = ip;
		this.port = port;
	}
	
	private String ip;
	private int port;
	
	private JSONFile data;

	@Getter
	private String serverName;
	
	public void run() {
		data = new JSONFile(MCSI.getFileManager().getDataFolder().getPath() + "/" + serverName + ".json", new JSONFormat() {
			public void initalJSON(JSON json) {
				json.put("version", "?");
				json.put("protocol", -1);
				json.put("motd", "?");
				json.put("players", 0);
				json.put("maxplayers", 0);
				json.put("ping", 0);
				json.put("srv", false);
				json.put("online", false);
				
				JSON uptime = new JSON();
				uptime.put("get", 0);
				uptime.put("check", 0);
				json.put("uptime", uptime);
				
				JSON last = new JSON();
				last.put("get", "?");
				last.put("check", "?");
				json.put("last", last);
				
				JSON peak = new JSON();
				peak.put("day", "00");
				
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
		JSON uptime = data.getJSON("uptime");
		
		uptime.put("check", uptime.getInt("check") + 1);
		
		data.getJSON().put("online", false);
		
		try {
			Record[] record = new Lookup("_Minecraft._tcp." + ip, Type.SRV).run();
			if (record != null) {
				SRVRecord srv = (SRVRecord) record[0];
				ip = srv.getTarget().toString();
				port = srv.getPort();
				data.getJSON().put("srv", true);
			} else data.getJSON().put("srv", false);
		} catch (TextParseException e) {
			data.getJSON().put("srv", false);
		}
		
		data.getJSON("last").put("check", StringUtil.dateString("yyyy-MM-dd a hh:mm:ss"));
		
		try {
			@Cleanup Socket socket = new Socket();
			
			socket.connect(new InetSocketAddress(ip, port), MCSI.getTimeout_Data());

			long startT = System.currentTimeMillis();
			
			@Cleanup DataOutputStream dos = new DataOutputStream(socket.getOutputStream());
			@Cleanup InputStream is = socket.getInputStream();
			@Cleanup InputStreamReader isr = new InputStreamReader(is, Charset.forName("UTF-16BE"));
			
			dos.write(new byte[] {(byte) 0xFE, (byte) 0x01});
			int packetid = is.read();
			if (packetid != 0xFF) throw new Exception();
			int l = isr.read();
			if (l < 1 && l > -2) throw new Exception();
			char[] c = new char[l];
			if (isr.read(c, 0, l) != l) throw new Exception();
			long stopT = System.currentTimeMillis();
			String a = new String(c);
			if (a.startsWith("§")) {
				String[] info = a.split("\0");
				data.getJSON().put("protocol", NumberUtil.getInteger(info[1]));
				data.getJSON().put("version", info[2]);
				data.getJSON().put("motd", info[3]);
				data.getJSON().put("players", NumberUtil.getInteger(info[4]));
				data.getJSON().put("maxplayers", NumberUtil.getInteger(info[5]));
			} else {
				String[] info = a.split("§");
				data.getJSON().put("protocol", "?");
				data.getJSON().put("version", "?");
				data.getJSON().put("motd", info[0]);
				data.getJSON().put("players", NumberUtil.getInteger(info[1]));
				data.getJSON().put("maxplayers", NumberUtil.getInteger(info[2]));
			}
			data.getJSON("last").put("get", StringUtil.dateString("yyyy-MM-dd a hh:mm:ss"));
			data.getJSON().put("ping", stopT - startT);
			data.getJSON().put("online", true);
		} catch (Exception e) {
			e.printStackTrace();
		}

		JSON peak = data.getJSON("peak");
		
		String day = StringUtil.dateString("dd");
		
		if (!peak.getString("day").equals(day)) {
			peak.put("day", day);
			peak.getJSON("yesterday").put("players", peak.getJSON("today").getInt("players"));
			peak.getJSON("yesterday").put("time", peak.getJSON("today").getString("time"));
			peak.getJSON("today").put("players", 0);
			peak.getJSON("today").put("time", "?");
			uptime.put("check", 1);
			uptime.put("get", 0);
		}
		
		if (data.getJSON().getBoolean("online")) {
			
			if (peak.getJSON("allday").getInt("players") < data.getInt("players")) {
				peak.getJSON("allday").put("players", data.getInt("players"));
				peak.getJSON("allday").put("time", StringUtil.dateString("yyyy-MM-dd a hh:mm:ss"));
			}
			
			if (peak.getJSON("today").getInt("players") < data.getInt("players")) {
				peak.getJSON("today").put("players", data.getInt("players"));
				peak.getJSON("today").put("time", StringUtil.dateString("a hh:mm:ss"));
			}
			
			uptime.put("get", uptime.getInt("get") + 1);
		}
		
		saveData();
		
		String mm = StringUtil.dateString("mm");
		
		if (NumberUtil.getInteger(mm) % 10 == 0) {
			int players = data.getInt("players");
			String time = StringUtil.dateString("kk:mm");
			
			JSONFile chart1 = new JSONFile(MCSI.getFileManager().getChartFolder().getPath() + "/" + serverName + ".json", new JSONFormat() {
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
			
			JSONFile chart2 = new JSONFile(MCSI.getFileManager().getChartFolder().getPath() + "/" + StringUtil.dateString("yyyy-MM-dd") + "/" + serverName + ".json", new JSONFormat() {
				public void initalJSON(JSON json) {
					json.put("time", Arrays.asList());
					json.put("players", Arrays.asList());
				}
			}).load();
			List<String> times2 = chart2.getStringList("time");
			List<Integer> players2 = chart2.getIntegerList("players");
			
			times2.add(time);
			players2.add(players);
			
			chart2.getJSON().put("time", times2);
			chart2.getJSON().put("players", players2);
			
			chart2.save();
		}
	}
	
	public void saveData() {
		data.save();
	}
}
