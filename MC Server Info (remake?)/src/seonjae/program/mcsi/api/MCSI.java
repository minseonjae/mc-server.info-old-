package seonjae.program.mcsi.api;

import java.io.File;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.UtilityClass;
import seonjae.json.JSONConfig;
import seonjae.util.StringUtil;

@UtilityClass
public class MCSI {
	
	@Getter
	@Setter
	private static int timeout_socket, timeout_data_thread, timeout_stats_thread;
	
	@Getter
	@Setter
	private static String date;
	
	@Getter
	private static HashMap<String, List<String>> version = new HashMap<>();
	
	@Getter
	private static JSONConfig versionConfig, config;
	
	@Getter
	private static File main_Folder, server_Main_Folder, all_Main_Folder,
			server_List_Folder, server_Data_Folder, server_Chart_Folder, server_Peak_Folder, server_Top_Folder,
			all_Chart_Folder, all_Peak_Folder, all_Top_Folder;
	
	public void changeDate() {
		config.set("date", StringUtil.dateString("yyyy-MM-dd"));
		
		date = config.getString("date");
		
		config.save();
	}
	public boolean checkDate() {
		return config.getString("date").equals(StringUtil.dateString("yyyy-MM-dd"));
	}
	
	public void loadVersionConfig() {
		version.clear();
		
		versionConfig = new JSONConfig(new File("version.json"));
		
		versionConfig.addDefault("1.12.2", Arrays.asList());
		
		versionConfig.load();
		
		versionConfig.getKeys().forEach(key -> version.put(key, versionConfig.getStringList(key)));
	}
	
	public void loadConfig() {
		config = new JSONConfig(new File("config.json"));
		
		config.addDefault("date", "1970-01-01");
		config.addDefault("timeout.socket", 1000);
		config.addDefault("timeout.thread.data", 15000);
		config.addDefault("timeout.thread.stats", 15000);
		config.addDefault("folder.main", "API/");
		config.addDefault("folder.server.main", "Server/");
		config.addDefault("folder.server.list", "List/");
		config.addDefault("folder.server.data", "Data/");
		config.addDefault("folder.server.chart", "Chart/");
		config.addDefault("folder.server.peak", "Peak/");
		config.addDefault("folder.server.top", "Top/");
		config.addDefault("folder.all.main", "All/");
		config.addDefault("folder.all.chart", "Chart/");
		config.addDefault("folder.all.peak", "Peak/");
		config.addDefault("folder.all.top", "Top/");
		
		config.load();
		
		date = config.getString("date");
		
		timeout_socket = config.getInt("timeout.socket");
		timeout_data_thread = config.getInt("timeout.thread.data");
		timeout_stats_thread = config.getInt("timeout.thread.stats");
		
		createFolder();
	}
	
	public void createFolder() {
		main_Folder = createFolder(config.getString("folder.main"));
		
		server_Main_Folder = createFolder(config.getString("folder.server.main"));
		server_List_Folder = createFolder(config.getString("folder.server.list"));
		server_Data_Folder = createFolder(config.getString("folder.server.data"));
		server_Chart_Folder = createFolder(config.getString("folder.server.chart"));
		server_Peak_Folder = createFolder(config.getString("folder.server.peak"));
		server_Top_Folder = createFolder(config.getString("folder.server.top"));
		
		all_Main_Folder = createFolder(config.getString("folder.all.main"));
		all_Chart_Folder = createFolder(config.getString("folder.all.chart"));
		all_Peak_Folder = createFolder(config.getString("folder.all.peak"));
		all_Top_Folder = createFolder(config.getString("folder.all.top"));
	}
	
	private File createFolder(String path) {
		File file = new File(path);
		if (!file.exists()) file.mkdirs();
		return file;
	}
}
