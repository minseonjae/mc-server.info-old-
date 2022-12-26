/*
 * Decompiled with CFR 0.150.
 */
package me.seonjae.program.msi.manager;

import java.util.Arrays;
import java.util.List;
import me.seonjae.json.JSON;
import me.seonjae.json.JSONFile;
import me.seonjae.json.JSONFormat;
import me.seonjae.program.msi.MSI;
import me.seonjae.util.StringUtil;

public class ChartManager {
    public void saveAllServerData(String time, long players) {
        JSONFile jsonf1 = new JSONFile(MSI.getFileManager().getDefaultFolder().getPath() + "/Chart.json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("time", Arrays.asList());
                json.put("players", Arrays.asList());
            }
        }).load();
        JSONFile jsonf2 = new JSONFile(MSI.getFileManager().getChartFolder().getPath() + "/All/" + StringUtil.dateString("yyyy년 MM월 dd일") + ".json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("time", Arrays.asList());
                json.put("players", Arrays.asList());
            }
        }).load();
        List<Object> time1 = jsonf1.getList("time"), time2 = jsonf2.getList("time"),
                players1 = jsonf1.getList("players"), players2 = jsonf2.getList("players");

        if (time1.size() >= MSI.getChartInfoCount()) {
            time1.remove(0);
            players1.remove(0);
        }
        time1.add(time);
        time2.add(time);
        players1.add(players);
        players2.add(players);
        jsonf1.getJSON().put("time", time1);
        jsonf1.getJSON().put("players", players1);
        jsonf2.getJSON().put("time", time2);
        jsonf2.getJSON().put("players", players2);
        jsonf1.save();
        jsonf2.save();
    }

    public void saveServerData(String name, String time, long players) {
        JSONFile jsonf1 = new JSONFile(MSI.getFileManager().getChartFolder().getPath() + "/" + name + ".json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("time", Arrays.asList());
                json.put("players", Arrays.asList());
            }
        }).load();
        JSONFile jsonf2 = new JSONFile(MSI.getFileManager().getChartFolder().getPath() + "/" + StringUtil.dateString("yyyy년 MM월 dd일") + "/" + name + ".json", new JSONFormat(){
            @Override
            public void initalJSON(JSON json) {
                json.put("time", Arrays.asList());
                json.put("players", Arrays.asList());
            }
        }).load();
        List<Object> time1 = jsonf1.getList("time"), time2 = jsonf2.getList("time"),
                players1 = jsonf1.getList("players"), players2 = jsonf2.getList("players");

        if (time1.size() >= MSI.getChartInfoCount()) {
            time1.remove(0);
            players1.remove(0);
        }

        time1.add(time);
        time2.add(time);
        players1.add(players);
        players2.add(players);
        jsonf1.getJSON().put("time", time1);
        jsonf1.getJSON().put("players", players1);
        jsonf2.getJSON().put("time", time2);
        jsonf2.getJSON().put("players", players2);
        jsonf1.save();
        jsonf2.save();
    }
}

