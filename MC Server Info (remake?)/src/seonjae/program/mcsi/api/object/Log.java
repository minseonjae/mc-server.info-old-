package seonjae.program.mcsi.api.object;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.UtilityClass;
import seonjae.util.StringUtil;

@UtilityClass
public class Log {
	
	@Getter
	@Setter
	private static boolean debugMode = false;
	
	public void msg(Object message) {
		System.out.println("[ " + StringUtil.dateString() + " ] : " + message);
	}
	public void debug(Object message) {
		if (debugMode) System.out.println("[ debug ] : " + message);
	}
}
