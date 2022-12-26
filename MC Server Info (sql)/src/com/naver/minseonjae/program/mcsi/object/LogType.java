package com.naver.minseonjae.program.mcsi.object;

import lombok.Getter;

public enum LogType {
	
	INFO("정보"), WARNING("경고"), DANGER("위험");
	
	private LogType(String name) {
		this.name = name;
	}
	
	@Getter
	private String name;
}
