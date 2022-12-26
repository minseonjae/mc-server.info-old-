package com.naver.minseonjae.program.mcsi;

import java.text.SimpleDateFormat;
import java.util.Date;

import com.naver.minseonjae.program.mcsi.object.LogType;

import lombok.experimental.UtilityClass;

@UtilityClass
public class MCSI {
	
	public void log(Object message) {
		i_log(message);
	}
	public void i_log(Object message) {
		n_log(LogType.INFO, message);
	}
	public void d_log(Object message) {
		n_log(LogType.DANGER, message);
	}
	public void w_log(Object message) {
		n_log(LogType.WARNING, message);
	}
	public void n_log(LogType type, Object message) {
		System.out.println(new SimpleDateFormat("[ yyyy-MM-dd kk:mm:ss ").format(new Date()) + type.getName() + " ] : " + message);
	}
}
