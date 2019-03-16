package seonjae.program.msi.manager;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.util.Arrays;

import lombok.Cleanup;
import lombok.Getter;
import lombok.SneakyThrows;
import seonjae.json.JSON;
import seonjae.json.JSONFile;
import seonjae.json.JSONFormat;
import seonjae.util.StringUtil;
import seonjae.program.msi.MCSI;

public class FileManager {
	
	@Getter
	private File folder, dataFolder, listFolder, chartFolder, logFolder;
	
	@Getter
	private JSONFile config, versionConfig;
	
	public void loadConfig() {
		if (config == null) {
			config = new JSONFile("config.json", new JSONFormat() {
				public void initalJSON(JSON json) {
					JSON timeout = new JSON();
					timeout.put("data", 1000);
					timeout.put("thread", 30000);
					json.put("time-out", timeout);
					json.put("chart-size", 12);
					json.put("folder", "API/");
				}
			}).load();
		} else config.load();
		JSON timeout = config.getJSON("time-out");
		MCSI.setTimeout_Data(timeout.getInt("data"));
		MCSI.setTimeout_Thread(timeout.getInt("thread"));
		MCSI.setChart_Size(config.getInt("chart-size"));
		folder = new File(config.getString("folder"));
		dataFolder = new File(folder.getPath() + "/Data/");
		chartFolder = new File(folder.getPath() + "/Chart/");
		listFolder = new File(folder.getPath() + "/List/");
		logFolder = new File("log/");
		if (!dataFolder.exists()) dataFolder.mkdirs();
		if (!chartFolder.exists()) chartFolder.mkdirs();
		if (!listFolder.exists()) listFolder.mkdirs();
		if (!logFolder.exists()) logFolder.mkdirs();
	}
	public void loadVersion() {
		MCSI.getVersion().clear();
		if (versionConfig == null) {
			versionConfig = new JSONFile("version.json", new JSONFormat() {
				public void initalJSON(JSON json) {
					json.put("1.12.2", Arrays.asList());
				}
			}).load();
		} else versionConfig.load();
		for (String v : versionConfig.getJSON().keySet())
			MCSI.getVersion().put(v, versionConfig.getStringList(v));
	}
	
	@SneakyThrows
	public boolean saveThreadLog() {
		File folder = new File("log/" + StringUtil.dateString("yyyy-MM-dd") + "/");
		if (!folder.exists()) folder.mkdirs();
		
		File file;
		
		for (int i = 1;; i++) if (!(file = new File(folder.getPath() + "/thread " + i + ".log")).exists()) break;
		
		String log = String.join("\n", MCSI.getGui().getThreadLog());

		@Cleanup FileOutputStream fos = new FileOutputStream(file);
		@Cleanup OutputStreamWriter osw = new OutputStreamWriter(fos, Charset.forName("UTF-8"));
		@Cleanup BufferedWriter bw = new BufferedWriter(osw);
		
		bw.write(log);
		
		return true;
	}
	@SneakyThrows
	public boolean saveServerLog() {
		File folder = new File("log/" + StringUtil.dateString("yyyy-MM-dd") + "/");
		if (!folder.exists()) folder.mkdirs();
		
		File file;
		
		for (int i = 1;; i++) if (!(file = new File(folder.getPath() + "/server " + i + ".log")).exists()) break;
		
		String log = String.join("\n", MCSI.getGui().getThreadLog());

		@Cleanup FileOutputStream fos = new FileOutputStream(file);
		@Cleanup OutputStreamWriter osw = new OutputStreamWriter(fos, Charset.forName("UTF-8"));
		@Cleanup BufferedWriter bw = new BufferedWriter(osw);
		
		bw.write(log);
		
		return true;
	}
}
