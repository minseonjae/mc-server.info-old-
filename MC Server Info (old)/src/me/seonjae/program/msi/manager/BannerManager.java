package me.seonjae.program.msi.manager;

import java.awt.Color;
import java.awt.Font;
import java.awt.Graphics2D;
import java.awt.RenderingHints;
import java.awt.font.FontRenderContext;
import java.awt.geom.Rectangle2D;
import java.awt.image.BufferedImage;
import java.awt.image.RenderedImage;
import java.io.File;
import javax.imageio.ImageIO;

import lombok.SneakyThrows;
import me.seonjae.json.JSON;
import me.seonjae.program.msi.category.MCColor;

public class BannerManager {

    @SneakyThrows(Exception.class)
    public void create(File out, JSON json) {
        BufferedImage img = ImageIO.read(new File("BasicBanner.png"));
        Font font1 = new Font("나눔고딕", 0, 24);
        Font font2 = new Font("나눔고딕", 0, 14);
        Graphics2D g2d = img.createGraphics();
        g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
        g2d.setFont(font1);
        this.setText(g2d, font1, json.get("ip").toString(), 30, 70, 0);
        int fh = 120;
        int fw = 30;
        String motd = "§7" + json.get("motd").toString();
        String[] motdsp = motd.split("§");
        if (motdsp.length < 2) {
            this.setText(g2d, font1, motd, fw, fh, 0);
        } else {
            String[] arrstring = motdsp;
            int n = motdsp.length;
            for (int i = 0; i < n; ++i) {
                String msg = arrstring[i];
                if (msg.length() < 1) continue;
                String startS = msg.substring(0, 1);
                MCColor mc = MCColor.getByCode(startS);
                if (startS.equalsIgnoreCase("m") || startS.equalsIgnoreCase("n") || startS.equalsIgnoreCase("o") || startS.equalsIgnoreCase("l")) {
                    String string = msg = msg.length() > 1 ? msg.substring(1) : "";
                }
                if (mc == null) {
                    fw = setText(g2d, font1, msg, fw, fh, 0);
                    continue;
                }
                g2d.setColor(mc.getColor());
                fw = this.setText(g2d, font1, msg.substring(1), fw, fh, 0);
            }
        }
        g2d.setColor(new Color(255, 255, 255));
        setText(g2d, font1, json.get("players") + " / " + json.get("maxplayers"), 500, 70, 1);
        g2d.setFont(font2);
        setText(g2d, font2, json.get("version").toString(), 632, 155, 2);
        g2d.dispose();
        ImageIO.write((RenderedImage)img, "png", out);
    }

    private int setText(Graphics2D g2d, Font font, String text, int x, int y, int type) {
        FontRenderContext frc = new FontRenderContext(null, true, true);
        Rectangle2D r2d = font.getStringBounds(text, frc);
        if (type == 0) {
            g2d.drawString(text, x, y);
            return x + (int)r2d.getWidth();
        }
        if (type == 1) {
            g2d.drawString(text, x - (int)(r2d.getWidth() * 0.9 / 2.0), y);
            return x + (int)r2d.getWidth() / 2;
        }
        g2d.drawString(text, x - (int)r2d.getWidth(), y);
        return x - (int)r2d.getWidth();
    }
}

