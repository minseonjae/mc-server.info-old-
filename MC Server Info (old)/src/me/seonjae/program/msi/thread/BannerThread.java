package me.seonjae.program.msi.thread;

import java.io.File;

import lombok.SneakyThrows;
import me.seonjae.json.JSON;
import me.seonjae.program.msi.MSI;

public class BannerThread extends Thread {

    private String name;
    private JSON json;

    public BannerThread(String name, JSON json) {
        this.name = name;
        this.json = json;
    }

    @Override
    @SneakyThrows(Exception.class)
    public void run() {
        boolean run = true;
        while (run) {
            try {
                MSI.getBannderManager().create(new File(String.valueOf(MSI.getFileManager().getBannerFolder().getPath()) + "/" + this.name + ".png"), this.json);
                run = false;
            } catch (Exception e) {
                run = true;
                Thread.sleep(100L);
            }
        }
    }
}

