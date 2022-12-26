package me.seonjae.program.msi.manager;

import java.io.File;
import java.util.Arrays;
import java.util.HashMap;
import me.seonjae.json.JSON;
import me.seonjae.json.JSONFile;
import me.seonjae.json.JSONFormat;
import me.seonjae.program.msi.MSI;
import me.seonjae.util.StringUtil;

public class TopManager {
    public void loadServerPlayersTop(String time1, String time2, int mm) {
        HashMap<String, Long> map = new HashMap<>();
        long players = 0;
        for (File f : MSI.getFileManager().getStatusFolder().listFiles()) {
            if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
            JSONFile jsonf = new JSONFile(f.getPath()).load();
            players += jsonf.getLong("players").longValue();
            map.put(f.getName().substring(0, f.getName().length() - 5), jsonf.getLong("players"));
        }
        String[] name = map.keySet().toArray(new String[map.size()]);
        for (int i = 0; i < map.size(); ++i) {
            for (int j = 0; j < map.size() - (i + 1); ++j) {
                if (map.get(name[j]) >= map.get(name[j + 1])) continue;
                String temp1 = name[j + 1];
                name[j + 1] = name[j];
                name[j] = temp1;
            }
        }
        new JSONFile(MSI.getFileManager().getDefaultFolder().getPath() + "/" + "PlayersTop.json", new JSONFormat() {
            @Override
            public void initalJSON(JSON json) {
                json.put("list", Arrays.asList(name));
            }
        }).save();
        
        JSONFile jsonfi = new JSONFile(MSI.getFileManager().getDefaultFolder().getPath() + "/" + "Players.json");
        jsonfi.getJSON().put("players", players);
        jsonfi.save();
        if (mm % 10 == 0) {
            MSI.getChartManager().saveAllServerData(time2, players);
        }
        JSONFile jsonf1 = new JSONFile(MSI.getFileManager().getPeakFolder().getPath() + "/AllDay.json", new JSONFormat() {

            @Override
            public void initalJSON(JSON json) {
                json.put("time", "X");
                json.put("players", 0);
            }
        }).load();
        JSONFile jsonf2 = new JSONFile(MSI.getFileManager().getPeakFolder().getPath() + "/Day.json", new JSONFormat(){

            @Override
            public void initalJSON(JSON json) {
                json.put("day", "00");
                json.put("time", "X");
                json.put("players", 0);
            }
        }).load();
        if (players > jsonf1.getLong("players")) {
            jsonf1.getJSON().put("time", time1);
            jsonf1.getJSON().put("players", players);
            jsonf1.save();
        }
        String day = StringUtil.dateString("dd");
        if (!jsonf2.getString("day").equals(day)) {
            jsonf2.setPath(MSI.getFileManager().getPeakFolder().getPath() + "/Yester.json");
            jsonf2.save();
            jsonf2.setPath(MSI.getFileManager().getPeakFolder().getPath() + "/Day.json");
            jsonf2.getJSON().put("day", day);
            jsonf2.getJSON().put("time", time2);
            jsonf2.getJSON().put("players", players);
            jsonf2.save();
        } else if (players > jsonf2.getLong("players")) {
            jsonf2.getJSON().put("time", time2);
            jsonf2.getJSON().put("players", players);
            jsonf2.save();
        }
    }

    public void loadServerAllDayPeakPlayersTop() {
        HashMap<String, Long> map = new HashMap<>();
        for (File f : MSI.getFileManager().getAllDayPeakFolder().listFiles()) {
            if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
            JSONFile jsonf = new JSONFile(f.getPath()).load();
            map.put(f.getName().substring(0, f.getName().length() - 5), jsonf.getLong("players"));
        }
        final String[] name = map.keySet().toArray(new String[map.size()]);
        for (int i = 0; i < map.size(); ++i) {
            for (int j = 0; j < map.size() - (i + 1); ++j) {
                if (map.get(name[j]) >= map.get(name[j + 1])) continue;
                String temp = name[j + 1];
                name[j + 1] = name[j];
                name[j] = temp;
            }
        }
        new JSONFile(MSI.getFileManager().getPeakFolder().getPath() + "/AllDayTop.json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("list", Arrays.asList(name));
            }
        }).save();
    }

    public void loadServerDayPeakPlayersTop() {
        HashMap<String, Long> map = new HashMap<>();
        for (File f : MSI.getFileManager().getDayPeakFolder().listFiles()) {
            if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
            JSONFile jsonf = new JSONFile(f.getPath()).load();
            map.put(f.getName().substring(0, f.getName().length() - 5), jsonf.getLong("players"));
        }
        String[] name = map.keySet().toArray(new String[map.size()]);
        for (int i = 0; i < map.size(); ++i) {
            for (int j = 0; j < map.size() - (i + 1); ++j) {
                if (map.get(name[j]) >= map.get(name[j + 1])) continue;
                String temp1 = name[j + 1];
                name[j + 1] = name[j];
                name[j] = temp1;
            }
        }
        JSONFile jsonf = new JSONFile(MSI.getFileManager().getPeakFolder().getPath() + "/DayTop.json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("day", "00");
                json.put("list", Arrays.asList(new Object[0]));
            }
        }).load();

        String day = StringUtil.dateString("dd");
        if (!jsonf.getString("day").equals(day)) {
            jsonf.setPath(MSI.getFileManager().getPeakFolder().getPath() + "/YesterTop.json");
            jsonf.save();
            jsonf.setPath(MSI.getFileManager().getPeakFolder().getPath() + "/DayTop.json");
            jsonf.getJSON().put("day", day);
        }
        jsonf.getJSON().put("list", Arrays.asList(name));
        jsonf.save();
    }
}

