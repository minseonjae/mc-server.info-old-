package seonjae.json;

import java.io.StringWriter;
import java.io.Writer;
import java.util.List;

import lombok.SneakyThrows;

public class JSONValue {

	
	public static String toString(Object value) {
		StringWriter out = new StringWriter();
		toString(value, out, 0);
		return out.toString();
	}
	@SneakyThrows
	public static void toString(Object value, Writer out, int count) {
		if (value == null) out.write("null");
		else if (value instanceof String) out.write("\"" + escape(value.toString()) + "\"");
		else if (value instanceof Double) {
			if (((Double) value).isInfinite() || ((Double) value).isNaN()) out.write("null");
			else out.write(value.toString());
		} else if (value instanceof Float) {
			if (((Float) value).isInfinite() || ((Float) value).isNaN()) out.write("null");
			else out.write(value.toString());
		} else if (value instanceof Number) out.write(value.toString());
		else if (value instanceof Boolean) out.write(value.toString());
		else if (value instanceof JSON) out.write(((JSON) value).toString(count));
		else if (value instanceof List) JSONArray.toString((List<?>) value, out, count);
	}
	
	public static String escape(String s){
		if(s==null) return null;
        StringBuffer sb = new StringBuffer();
        escape(s, sb);
        return sb.toString();
    }
	public static void escape(String s, StringBuffer sb) {
    	final int len = s.length();
		for (int i=0;i<len;i++) {
			char ch=s.charAt(i);
			switch(ch){
			case '"':
				sb.append("\\\"");
				break;
			case '\\':
				sb.append("\\\\");
				break;
			case '\b':
				sb.append("\\b");
				break;
			case '\f':
				sb.append("\\f");
				break;
			case '\n':
				sb.append("\\n");
				break;
			case '\r':
				sb.append("\\r");
				break;
			case '\t':
				sb.append("\\t");
				break;
			case '/':
				sb.append("\\/");
				break;
			default:
               if((ch>='\u0000' && ch<='\u001F') || (ch>='\u007F' && ch<='\u009F') || (ch>='\u2000' && ch<='\u20FF')){
					String ss=Integer.toHexString(ch);
					sb.append("\\u");
					for(int k=0;k<4-ss.length();k++) sb.append('0');
					sb.append(ss.toUpperCase());
				} else sb.append(ch);
			}
		}
	}
}
