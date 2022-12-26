package me.seonjae.program.msi.manager;

import java.io.DataOutputStream;
import java.io.File;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.InetSocketAddress;
import java.net.Socket;
import java.nio.charset.Charset;
import java.util.Collections;

import lombok.Cleanup;
import lombok.SneakyThrows;
import me.seonjae.json.JSON;
import me.seonjae.json.JSONFile;
import me.seonjae.json.JSONFormat;
import me.seonjae.program.msi.MSI;
import me.seonjae.program.msi.thread.BannerThread;
import me.seonjae.util.StringUtil;
import org.xbill.DNS.Lookup;
import org.xbill.DNS.Record;
import org.xbill.DNS.SRVRecord;

public class StatusManager {
    public int loadStatus(String time1, String time2, int mm) {
        int code = 0;
        for (File f : MSI.getFileManager().getListFolder().listFiles()) {
            if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
            String name = f.getName().substring(0, f.getName().length() - 5);
            JSONFile jsonf1 = new JSONFile(f.getPath(), new JSONFormat(){

                @Override
                public void initalJSON(JSON json) {
                    json.put("ip", "X");
                    json.put("port", 25565);
                }
            }).load();
            final JSON json = this.get(name, jsonf1.getString("ip"), jsonf1.getInt("port"));
            new JSONFile(MSI.getFileManager().getStatusFolder().getPath() + "/" + name + ".json", new JSONFormat(){

                @Override
                public void initalJSON(JSON jso) {
                    jso.addJSON(json);
                }
            }).save();
            new BannerThread(name, json).start();
            JSONFile jsonf2 = new JSONFile(MSI.getFileManager().getAllDayPeakFolder().getPath() + "/" + name + ".json", new JSONFormat(){

                @Override
                public void initalJSON(JSON json) {
                    json.put("time", "X");
                    json.put("players", 0);
                }
            }).load();
            JSONFile jsonf3 = new JSONFile(MSI.getFileManager().getDayPeakFolder().getPath() + "/" + name + ".json", new JSONFormat(){

                @Override
                public void initalJSON(JSON json) {
                    json.put("day", "00");
                    json.put("time", "X");
                    json.put("players", 0);
                }
            }).load();
            if (mm % 10 == 0) {
                MSI.getChartManager().saveServerData(name, time2, json.getLong("players"));
            }
            if (json.getLong("players") > jsonf2.getLong("players")) {
                jsonf2.getJSON().put("time", time1);
                jsonf2.getJSON().put("players", json.getLong("players"));
                jsonf2.save();
                code = code == 2 ? 3 : 1;
            }
            String day = StringUtil.dateString("dd");
            if (!jsonf3.getString("day").equals(day)) {
                jsonf3.setPath(MSI.getFileManager().getYesterPeakFolder().getPath() + "/" + name + ".json");
                jsonf3.save();
                jsonf3.setPath(MSI.getFileManager().getDayPeakFolder().getPath() + "/" + name + ".json");
                jsonf3.getJSON().put("day", day);
                jsonf3.getJSON().put("time", time2);
                jsonf3.getJSON().put("players", json.getLong("players"));
                jsonf3.save();
                code = code == 1 ? 3 : 2;
                continue;
            }
            if (json.getLong("players") <= jsonf3.getLong("players")) continue;
            jsonf3.getJSON().put("time", time2);
            jsonf3.getJSON().put("players", json.getLong("players"));
            jsonf3.save();
            code = code == 1 ? 3 : 2;
        }
        return code;
    }


    @SneakyThrows
    public JSON get(String name, String ip, int port) {
        JSON json = new JSON();
        json.put("ip", ip);
        json.put("port", port);
        json.put("protocol", -1);
        json.put("version", "?");
        json.put("motd", "?");
        json.put("players", 0);
        json.put("maxplayers", 0);
        json.put("ping", -1);
        json.put("srv", false);
        ip = ip.toLowerCase();
        Record[] srv = new Lookup("_Minecraft._tcp." + ip, 33).run();
        if (srv != null) {
            SRVRecord record = (SRVRecord)srv[0];
            ip = record.getTarget().toString();
            port = record.getPort();
            json.put("srv", true);
        }
        @Cleanup Socket socket = new Socket();
        socket.connect(new InetSocketAddress(ip, port), 1000);

        long startT = System.currentTimeMillis();

        @Cleanup DataOutputStream dos = new DataOutputStream(socket.getOutputStream());
        @Cleanup InputStream is = socket.getInputStream();
        @Cleanup InputStreamReader isr = new InputStreamReader(is, Charset.forName("UTF-16BE"));

        dos.write(new byte[]{-2, 1});

        int packetid = is.read();
        if (packetid != 255) {
            JSON jSON = json;
            return jSON;
        }

        int l = isr.read();
        if (l < 1 && l > -2) {
            JSON jSON = json;
            return jSON;
        }

        char[] c = new char[l];
        if (isr.read(c, 0, l) != l) {
            JSON jSON = json;
            return jSON;
        }

        long stopT = System.currentTimeMillis();

        String a = new String(c);

        if (a.startsWith("§")) {
            String[] info = a.split(" ");
            json.put("protocol", info[1]);
            json.put("version", info[2]);
            json.put("motd", info[3]);
            json.put("players", info[4]);
            json.put("maxplayers", info[5]);
        } else {
            String[] info = a.split("§");
            json.put("protocol", "?");
            json.put("version", "?");
            json.put("motd", info[0]);
            json.put("players", info[1]);
            json.put("maxplayers", info[2]);
        }
        json.put("ping", stopT - startT);
        return json;
    }
}

