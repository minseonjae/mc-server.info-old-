package me.seonjae.program.msi.thread;

import me.seonjae.program.msi.MSI;
import me.seonjae.util.StringUtil;

public class StatusThread
extends Thread {
    @Override
    public void run() {
        String kkmm = StringUtil.dateString("kk:mm");
        String yyyyMMddkkmm = StringUtil.dateString("yyyy년 MM월 dd일 kk시 mm분");
        int mm = Integer.parseInt(StringUtil.dateString("mm"));

        MSI.log("서버 정보를 불러옵니다.");

        if (mm % 10 == 0) {
            MSI.log("서버 차트를 저장 시작");
        }

        int i = MSI.getStatusManager().loadStatus(yyyyMMddkkmm, kkmm, mm);

        MSI.log("Status Thread 1");
        MSI.getVersionManager().loadServerVersion();

        MSI.log("Status Thread 2");
        MSI.getTopManager().loadServerPlayersTop(yyyyMMddkkmm, kkmm, mm);

        MSI.log("Status Thread 3");
        if (i == 1 || i == 3) {
            MSI.getTopManager().loadServerAllDayPeakPlayersTop();
        }

        MSI.log("Status Thread 4");
        if (i > 1 || i < 4) {
            MSI.getTopManager().loadServerDayPeakPlayersTop();
        }

        MSI.log("서버 정보를 불러왔습니다.");
        MainThread.start = true;
    }
}

