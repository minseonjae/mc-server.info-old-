package seonjae.program.mcsi.api.object;

import lombok.Getter;
import seonjae.util.NumberUtil;
import seonjae.util.StringUtil;

public class Time {
	
	@Getter
	private String year, month, day, hour, minute, second;
	
	@Getter
	private long timeMillis;
	
	public Time() {
		this(System.currentTimeMillis());
	}
	public Time(long timeMillis) {
		this.timeMillis = timeMillis;
		String[] date = StringUtil.buildDateString(timeMillis, "yyyy-MM-dd-kk-mm-ss").split("-");
		year = date[0];
		month = date[1];
		day = date[2];
		hour = date[3];
		minute = date[4];
		second = date[5];
	}
	
	public long getNYear() {
		return NumberUtil.getInteger(year);
	}
	public long getNMonth() {
		return NumberUtil.getInteger(month);
	}
	public long getNDay() {
		return NumberUtil.getInteger(day);
	}
	public long getNHour() {
		return NumberUtil.getInteger(hour);
	}
	public long getNMinute() {
		return NumberUtil.getInteger(minute);
	}
	public long getNSecond() {
		return NumberUtil.getInteger(second);
	}
	
	public long getDayMillis() {
		return 86400000;
	}
	public long getHourMillis() {
		return 3600000;
	}
	public long getMinuteMillis() {
		return 60000;
	}
	
	public Time getLowerTime(long timeMillis) {
		return new Time(getTimeMillis() - timeMillis);
	}
	public Time getRaiseTime(long timeMillis) {
		return new Time(getTimeMillis() + timeMillis);
	}
	
	public String toString() {
		return toString2() + " " + toString3();
	}
	public String toString2() {
		return year + "-" + month + "-" + day;
	}
	public String toString3() {
		return hour + ":" + minute;
	}
	public String toString4() {
		return hour + ":" + minute + ":" + second;
	}
}
