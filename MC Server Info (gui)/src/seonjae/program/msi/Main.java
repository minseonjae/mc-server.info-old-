package seonjae.program.msi;

public class Main {
	
	public static void main(String[] args) {
		MCSI.getGui().setVisible(true);
		MCSI.getFileManager().loadConfig();
		MCSI.getFileManager().loadVersion();
		MCSI.getMainThread().start();
		MCSI.getGui().appendThreadLog("메인 쓰레드 시작");
	}
}
