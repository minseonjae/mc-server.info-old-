package seonjae.program.mcsi.api.util;

import java.io.File;
import java.util.Arrays;
import java.util.LinkedHashMap;
import java.util.List;

import seonjae.json.JSONFile;
import seonjae.program.mcsi.api.object.Time;

public class FileUtil {

	public boolean savePeak(String file, long players, Time time, boolean all) {
		return savePeak(new File(file), players, time, all);
	}
	public boolean savePeak(File file, long players, Time time, boolean all) {
		try {
			JSONFile json = new JSONFile(file);
			
			json.addDefault("players", Arrays.asList());
			json.addDefault("time", Arrays.asList());
			
			json.load();
			
			List<Long> playersList = json.getLongList("players");
			List<String> timeList = json.getStringList("time");
			
			if ((playersList.size() < 1 ? 0 : playersList.get(playersList.size() - 1)) >= players) throw new Exception();
			
			playersList.add(players);
			timeList.add(all ? time.toString() : time.toString3());
			
			json.set("players", playersList);
			json.set("time", timeList);
			
			json.save();
			
			return true;
		} catch (Exception e) {
			return false;
		}
	}
	public boolean saveChart(String path, String file, long players, Time time, boolean hour, int t) {
		return saveChart(new File(path, file), players, time, hour, t);
	}
	public boolean saveChart(String file, long players, Time time, boolean hour, int t) {
		return saveChart(new File(file), players, time, hour, t);
	}
	public boolean saveChart(File file, long players, Time time, boolean hour, int t) {
		try {
			
			if (hour) {
				if (time.getNHour() % t != 0) throw new Exception();
			} else {
				if (time.getNMinute() % t != 0) throw new Exception();
			}
			
			JSONFile json = new JSONFile(file);
			
			json.addDefault("players", Arrays.asList());
			json.addDefault("time", Arrays.asList());
			
			json.load();
			
			List<Long> playersList = json.getLongList("players");
			List<String> timeList = json.getStringList("time");
			
			playersList.add(players);
			timeList.add(time.toString3());
			
			json.save();
			
			return true;
		} catch (Exception e) {
			return false;
		}
	}
	
	public boolean saveCalculatedChartTop(List<File> files, File file) {
		try {
			JSONFile json = new JSONFile(file);

			json.addDefault("players", Arrays.asList());
			json.addDefault("time", Arrays.asList());
			
			json.load();
			
			LinkedHashMap<String, Long> map = new LinkedHashMap<>();
			
			for (File f : files) {
				if (!f.exists()) continue;
				JSONFile chart = new JSONFile(f);

				chart.addDefault("players", Arrays.asList());
				chart.addDefault("time", Arrays.asList());
				
				chart.load();
				
				List<Long> playersList = chart.getLongList("players");
				List<String> timeList = chart.getStringList("time");
				
				for (int i = 0; i < playersList.size(); i++) map.put(timeList.get(i), playersList.get(i));
			}
			
			String[] times = map.keySet().toArray(new String[map.size()]);
			Long[] players = map.values().toArray(new Long[map.size()]);
			
			for (int i = 0; i < times.length; i++) {
				for (int j = 0; j < times.length - (i + 1); j++) {
					if (players[j] < players[j + 1]) {
						String temp1 = times[j + 1];
						times[j + 1] = times[j];
						times[j] = temp1;
						long temp2 = players[j + 1];
						players[j + 1] = players[j];
						players[j] = temp2;
					}
				}
			}
			
			json.set("time", times);
			json.set("players", players);
			
			json.save();
			
			return true;
		} catch (Exception e) {
			return false;
		}
	}
}
