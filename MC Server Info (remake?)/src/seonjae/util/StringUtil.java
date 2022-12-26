package seonjae.util;

import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Date;
import java.util.List;

import lombok.experimental.UtilityClass;

@UtilityClass
public class StringUtil {
	
	public String[] toArray(List<String> list) {
		return list.toArray(new String[list.size()]);
	}
	public List<String> toList(String[] array) {
		return Arrays.asList(array);
	}
	
	public String repeatString(String str, int count) {
		StringBuilder sb = new StringBuilder();
		for (int i = 0; i < count; i++) sb.append(str);
		return sb.toString();
	}
	
	public String connectString(List<String> list, String connectChar) {
		return connectString(toArray(list), connectChar);
	}
	public String connectString(String[] array, String connectChar) {
		return connectString(array, 0, connectChar);
	}
	public String connectString(String[] array, int start, String connectChar) {
		StringBuilder sb = new StringBuilder();
		for (int i = start; i < array.length; i++) 
			if (array[i] != null)
				sb.append((sb.length() < 1 ? "" : connectChar) + array[i]);
		return sb.toString();
	}
	
	public String dateString() {
		return new SimpleDateFormat("yyyy-MM-dd kk:mm:ss").format(new Date());
	}
	public String dateString(String pattern) {
		return new SimpleDateFormat(pattern).format(new Date());
	}
	
	public String buildDateString(long time) {
		return new SimpleDateFormat("yyyy-MM-dd kk:mm:ss").format(new Date(time));
	}
	public String buildDateString(long time, String pattern) {
		return new SimpleDateFormat(pattern).format(new Date(time));
	}
}
