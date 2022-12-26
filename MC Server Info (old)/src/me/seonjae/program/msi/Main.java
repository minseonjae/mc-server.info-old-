/*
 * Decompiled with CFR 0.150.
 */
package me.seonjae.program.msi;

import me.seonjae.program.msi.MSI;
import me.seonjae.program.msi.thread.MainThread;

public class Main {
    public static void main(String[] args) {
        MSI.log("\uc11c\ubc84 \uc815\ubcf4\ub97c \uc218\uc9d1\ud569\ub2c8\ub2e4!");
        MSI.getFileManager().init();
        new MainThread().start();
    }
}

