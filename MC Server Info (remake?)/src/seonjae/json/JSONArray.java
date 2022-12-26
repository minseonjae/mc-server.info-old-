package seonjae.json;

import java.io.Writer;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

import lombok.SneakyThrows;

public class JSONArray<T> extends ArrayList<T> {
	
	public JSONArray() {}
	public JSONArray(Collection<T> collection) {
		super(collection);
	}

	@SneakyThrows
	public static void toString(List<?> list, Writer out, int count) {
		if (list == null) out.write("null");
		else if (list.size() == 0) out.write("[]");
		else {
			StringBuilder space = new StringBuilder();
			for (int i = 0; i < count; i++) space.append("\t");
			out.write("[\r\n\t" + space.toString());
			boolean first = true;
			for (Object o : list) {
				if (first) first = false;
				else out.write(",\r\n\t" + space.toString());
				JSONValue.toString(o, out, count + 1);
			}
			out.write("\r\n" + space.toString() + "]");
		}
	}	
	@SneakyThrows
	public static void toString(Object[] array, Writer out, int count) {
		if (array == null) out.write("null");
		else if (array.length == 0) out.write("[]");
		else {
			StringBuilder space = new StringBuilder();
			for (int i = 0; i < count; i++) space.append("\t");
			out.write("[\r\n\t" + space.toString());
			boolean first = true;
			for (Object o : array) {
				if (first) first = false;
				else out.write(",\r\n\t" + space.toString());
				JSONValue.toString(o, out, count + 1);
			}
			out.write("\r\n" + space.toString() + "]");
		}
	}
}
