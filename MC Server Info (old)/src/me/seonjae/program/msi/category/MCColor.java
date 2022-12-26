/*
 * Decompiled with CFR 0.150.
 */
package me.seonjae.program.msi.category;

import java.awt.Color;

public enum MCColor {
    BLACK("0", new Color(0, 0, 0)),
    DARK_BLUE("1", new Color(0, 0, 170)),
    DARK_GREEN("2", new Color(0, 170, 0)),
    DRAK_AQUA("3", new Color(0, 170, 170)),
    DARK_RED("4", new Color(230, 0, 0)),
    DARK_PURPLE("5", new Color(170, 0, 170)),
    GOLD("6", new Color(255, 170, 0)),
    GRAY("7r", new Color(170, 170, 170)),
    DARK_GRAY("8", new Color(85, 85, 85)),
    BLUE("9", new Color(85, 85, 255)),
    GREEN("a", new Color(85, 255, 85)),
    AQUA("b", new Color(85, 255, 255)),
    RED("c", new Color(255, 85, 85)),
    LIGHT_PURPLE("d", new Color(255, 85, 255)),
    YELLOW("e", new Color(255, 255, 85)),
    WHITE("f", new Color(255, 255, 255));

    private String code;
    private Color color;

    private MCColor(String code, Color color) {
        this.code = code;
        this.color = color;
    }

    public static MCColor getByCode(String code) {
        for (MCColor mc : MCColor.values()) {
            if (!mc.getCode().contains(code)) continue;
            return mc;
        }
        return null;
    }

    public String getCode() {
        return this.code;
    }

    public Color getColor() {
        return this.color;
    }
}

