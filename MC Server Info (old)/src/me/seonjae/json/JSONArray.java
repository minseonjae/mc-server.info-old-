package me.seonjae.json;

import lombok.SneakyThrows;

import java.io.Writer;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

public class JSONArray<T> extends ArrayList<T> {

	private static final long serialVersionUID = -6811545611433443577L;
	
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
			out.write("[\n\t" + space.toString());
			JSONValue.toString(list.get(0), out, count + 1);
			for (int i = 1; i < list.size(); i++) {
				out.write(",\n\t" + space.toString());
				JSONValue.toString(list.get(i), out, count + 1);
			}
			out.write("\n" + space.toString() + "]");
		}
	}
}
