package seonjae.program.msi;

import java.util.HashMap;
import java.util.List;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.UtilityClass;
import seonjae.program.msi.gui.MCServerInfoGUI;
import seonjae.program.msi.manager.FileManager;
import seonjae.program.msi.thread.MainThread;

@UtilityClass
public class MCSI {
	
	@Getter
	private static MainThread mainThread = new MainThread();
	
	@Getter
	private static MCServerInfoGUI gui = new MCServerInfoGUI();
	
	@Getter
	private static FileManager fileManager = new FileManager();
	
	@Getter
	@Setter
	private static int timeout_Data = 1000, timeout_Thread = 30000, chart_Size = 12;
	
	@Getter
	private static HashMap<String, List<String>> version = new HashMap<>();
}
