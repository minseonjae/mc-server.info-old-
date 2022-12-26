package me.seonjae.program.msi;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.UtilityClass;
import me.seonjae.program.msi.manager.BannerManager;
import me.seonjae.program.msi.manager.ChartManager;
import me.seonjae.program.msi.manager.FileManager;
import me.seonjae.program.msi.manager.StatusManager;
import me.seonjae.program.msi.manager.TopManager;
import me.seonjae.program.msi.manager.VersionManager;

@UtilityClass
public class MSI {

    @Getter
    @Setter
    private int timeout = 1000;

    @Getter
    @Setter
    private int chartInfoCount = 12;

    @Getter
    private HashMap<String, List<Object>> version = new HashMap();

    @Getter
    private BannerManager bannderManager = new BannerManager();

    @Getter
    private ChartManager chartManager = new ChartManager();

    @Getter
    private FileManager fileManager = new FileManager();

    @Getter
    private StatusManager statusManager = new StatusManager();

    @Getter
    private TopManager topManager = new TopManager();

    @Getter
    private VersionManager versionManager = new VersionManager();

    public static void log(Object msg) {
        System.out.println(String.valueOf(new SimpleDateFormat("[ yyyy-MM-dd kk:mm:ss ] :: ").format(new Date())) + msg);
    }
}

