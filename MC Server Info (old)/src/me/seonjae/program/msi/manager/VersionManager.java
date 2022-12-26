/*
 * Decompiled with CFR 0.150.
 */
package me.seonjae.program.msi.manager;

import java.io.File;
import me.seonjae.json.JSON;
import me.seonjae.json.JSONFile;
import me.seonjae.json.JSONFormat;
import me.seonjae.program.msi.MSI;

public class VersionManager {
    public void loadServerVersion() {
        final JSON data = new JSON();
        for (File f : MSI.getFileManager().getStatusFolder().listFiles()) {
            if (f.isDirectory() || !f.getName().endsWith(".json")) continue;
            JSONFile jsonf = new JSONFile(f.getPath()).load();
            boolean add = true;
            for (String version : MSI.getVersion().keySet()) {
                if (!MSI.getVersion().get(version).contains(jsonf.getString("version"))) continue;
                data.put(version, data.get(version) == null ? 1 : Integer.parseInt(data.get(version).toString()) + 1);
                add = false;
                break;
            }
            if (!add) continue;
            data.put(jsonf.getString("version"), data.get(jsonf.getString("version")) == null ? 1 : Integer.parseInt(data.get(jsonf.getString("version")).toString()) + 1);
        }
        new JSONFile(String.valueOf(MSI.getFileManager().getDefaultFolder().getPath()) + "/Version.json", new JSONFormat(){

            @Override
            public void initalJSON(JSON json) {
                json.addJSON(data);
            }
        }).save();
    }
}

