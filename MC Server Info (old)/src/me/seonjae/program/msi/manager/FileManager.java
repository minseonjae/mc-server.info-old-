package me.seonjae.program.msi.manager;

import java.io.File;
import java.util.Arrays;

import lombok.Getter;
import me.seonjae.json.JSON;
import me.seonjae.json.JSONFile;
import me.seonjae.json.JSONFormat;
import me.seonjae.program.msi.MSI;

public class FileManager {

    @Getter
    private File defaultFolder, listFolder, statusFolder, bannerFolder,
            peakFolder, allDayPeakFolder, dayPeakFolder, yesterPeakFolder,
            chartFolder,
            configFile;

    public void init() {
        loadSetting();
        JSONFile jsonf = new JSONFile("path.json", new JSONFormat() {

            @Override
            public void initalJSON(JSON json) {
                json.put("Default-Folder", "");
                json.put("List-Folder", "ServerList/");
                json.put("Status-Folder", "ServerStatus/");
                json.put("Banner-Folder", "ServerBanner/");
                json.put("Peak-Folder", "ServerPeak/");
                json.put("Chart-Folder", "ServerChart/");
            }
        }).load();
        defaultFolder = new File(jsonf.getString("Default-Folder"));
        listFolder = new File(defaultFolder.getPath() + "/" + jsonf.getString("List-Folder"));
        if (!listFolder.exists()) {
            listFolder.mkdirs();
        }
        statusFolder = new File(defaultFolder.getPath() + "/" + jsonf.getString("Status-Folder"));
        if (!statusFolder.exists()) {
            statusFolder.mkdirs();
        }
        bannerFolder = new File(defaultFolder.getPath() + "/" + jsonf.getString("Banner-Folder"));
        if (!bannerFolder.exists()) {
            bannerFolder.mkdirs();
        }
        peakFolder = new File(defaultFolder.getPath() + "/" + jsonf.getString("Peak-Folder"));
        if (!peakFolder.exists()) {
            peakFolder.mkdirs();
        }
        allDayPeakFolder = new File(peakFolder.getPath() + "/AllDay/");
        if (!allDayPeakFolder.exists()) {
            allDayPeakFolder.mkdirs();
        }
        dayPeakFolder = new File(peakFolder.getPath() + "/Day/");
        if (!dayPeakFolder.exists()) {
            dayPeakFolder.mkdirs();
        }
        yesterPeakFolder = new File(peakFolder.getPath() + "/Yester/");
        if (!yesterPeakFolder.exists()) {
            yesterPeakFolder.mkdirs();
        }
        chartFolder = new File(defaultFolder.getPath() + "/" + jsonf.getString("Chart-Folder"));
        if (!chartFolder.exists()) {
            chartFolder.mkdirs();
        }
    }

    private void loadSetting() {
        JSONFile jsonf1 = new JSONFile(new JSONFormat(){

            @Override
            public void initalJSON(JSON json) {
                json.put("timeout", 1000);
                json.put("save-size", 12);
            }
        }).load();
        MSI.setTimeout(jsonf1.getInt("timeout"));
        MSI.setChartInfoCount(jsonf1.getInt("save-size"));
        JSONFile jsonf2 = new JSONFile("version.json", new JSONFormat(){

            @Override
            public void initalJSON(JSON json) {
                json.put("1.12.2", Arrays.asList());
            }
        }).load();
        for (String name : jsonf2.getJSON().keySet()) {
            MSI.getVersion().put(name, jsonf2.getList(name));
        }
    }
}

