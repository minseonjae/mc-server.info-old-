package seonjae.program.mcsi.thread;

import java.io.File;
import java.util.ArrayList;

import lombok.Getter;
import seonjae.json.JSONConfig;
import seonjae.program.mcsi.api.MCSI;
import seonjae.program.mcsi.api.object.Log;
import seonjae.program.mcsi.api.object.Time;

public class MainThread extends Thread{
	
	@Getter
	private ArrayList<GetInfoThread> threadList = new ArrayList<GetInfoThread>();
	
	public void run() {
		while (true) {
			Time time = new Time();
			
			if (time.getNSecond() == 0) {
				
				MCSI.createFolder();
				
				File[] files = MCSI.getServer_List_Folder().listFiles();
				
				Log.debug("MainThread.files - " + files.length);
				
				if (files.length == 0) {
					JSONConfig json = new JSONConfig(new File(MCSI.getServer_List_Folder(), "test.json"));

					json.addDefault("name", "TEST");
					json.addDefault("ip", "localhost");
					json.addDefault("port", 25565);
					json.addDefault("ban.all", false);
					json.addDefault("ban.top", false);
					json.addDefault("ban.stats", false);
					
					json.save();
					
					Log.debug("MainThread.json.new - " + json.saveToString2());
				}
				
				StringBuilder names = new StringBuilder();
				
				for (File file : files) {
					if (file.isDirectory() || !file.getName().endsWith(".json")) continue;
					
					JSONConfig json = new JSONConfig(file);
					
					json.addDefault("name", "TEST");
					json.addDefault("ip", "localhost");
					json.addDefault("port", 25565);
					json.addDefault("ban.all", false);
					json.addDefault("ban.top", false);
					json.addDefault("ban.stats", false);
					
					json.load();
					
					Log.debug("MainThread.json.for - " + json.saveToString2());
					
					if (json.getBoolean("ban.all")) {
						if (names.length() > 0) names.append(", ");
						String name = json.getString("name");
						names.append(name);
						Log.debug("MainThread.for.ban.all - " + name);
						continue;
					}
					
				}
				
				Log.msg(threadList.size() + "개의 정보 쓰레드 작동!");
				Log.msg("제외 된 서버 : [" + names.toString() + "]");
			}
		}
	}
}
