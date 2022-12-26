package me.seonjae.program.msi.thread;

import lombok.SneakyThrows;
import me.seonjae.util.StringUtil;

public class MainThread extends Thread {

    public static boolean start = true;

    @Override
    @SneakyThrows(Exception.class)
    public void run() {
        while (true) {
            if (Integer.parseInt(StringUtil.dateString("ss")) == 0 && start) {
                start = false;
                new StatusThread().start();
            }
            Thread.sleep(500L);
        }
    }
}

