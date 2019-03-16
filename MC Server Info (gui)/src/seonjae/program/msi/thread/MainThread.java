package seonjae.program.msi.thread;

import java.io.File;
import java.util.ArrayList;

import lombok.Getter;
import lombok.SneakyThrows;
import seonjae.json.JSON;
import seonjae.json.JSONFile;
import seonjae.json.JSONFormat;
import seonjae.program.msi.MCSI;
import seonjae.util.StringUtil;

public class MainThread extends Thread {
	
	@Getter
	private ArrayList<DataThread> list = new ArrayList<>();
	
	@SneakyThrows
	public void run() {
		while (true) {
			if (Integer.parseInt(StringUtil.dateString("ss")) == 0) {
				
				MCSI.getGui().appendServerLog("서버 데이터 로딩");
				
				File folder = new File(MCSI.getFileManager().getListFolder().getPath());
				
				if (!folder.exists()) folder.mkdirs();
				
				for (File f : folder.listFiles()) {
					if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
					JSONFile info = new JSONFile(f.getPath(), new JSONFormat() {
						public void initalJSON(JSON json) {
							json.put("ip", "X");
							json.put("port", 25565);
						}
					}).load();
					DataThread dt = new DataThread(f.getName().substring(0, f.getName().length() - 5),
							info.getString("ip"), info.getInt("port"));
					list.add(dt);
					dt.start();
				}
				MCSI.getGui().appendThreadLog(list.size() + "개의 쓰레드 작동");
				Thread.sleep(MCSI.getTimeout_Thread());
				for (DataThread dt : list) 
					if (dt.isAlive()) {
						MCSI.getGui().appendServerLog(dt.getServerName() + " 데이터 저장 실패");
						dt.stop();
						dt.saveData();
					}
				list.clear();
				MCSI.getGui().appendServerLog("서버 데이터 로딩 완료");
				
				StatsThread st = new StatsThread();
				
				st.start();
				MCSI.getGui().appendThreadLog("서버 통계 쓰레드 작동");
				
				new Thread() {
					@SneakyThrows
					public void run() {
						Thread.sleep(10000);
						if (st.isAlive()) {
							st.stop();
							MCSI.getGui().appendServerLog("서버 통계 저장 실패");
						}
					}
				}.start();
			}
			Thread.sleep(500);
		}
	}
}