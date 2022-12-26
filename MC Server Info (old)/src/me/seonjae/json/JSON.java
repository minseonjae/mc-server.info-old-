package me.seonjae.json;

import me.seonjae.util.NumberUtil;

import java.io.StringWriter;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

public class JSON extends LinkedHashMap<String, Object> implements Map<String, Object> {

	private static final long serialVersionUID = -6428936330382311122L;
	
	public void addJSON(JSON json) {
		for (String n : json.keySet()) put(n, json.get(n));
	}
	public void removeJSON(JSON json) {
		for (String n : json.keySet()) remove(n);
	}
	
	public JSON getJSON(String name) {
		return (JSON) get(name);
	}
	public String getString(String name) {
		return get(name).toString();
	}
	public Boolean getBoolean(String name) {
		return Boolean.parseBoolean(getString(name));
	}
	public Long getLong(String name) {
		return NumberUtil.getLong(getString(name));
	}
	public Integer getInt(String name) {
		return NumberUtil.getInteger(getString(name));
	}
	public Double getDouble(String name) {
		return NumberUtil.getDouble(getString(name));
	}
	public Float getFloat(String name) {
		return NumberUtil.getFloat(getString(name));
	}
	
	public List<Object> getList(String name) {
		return (List<Object>) get(name);
	}
	public List<String> getStringList(String name) {
		return (List<String>) get(name);
	}
	public List<Integer> getIntegerList(String name) {
		return (List<Integer>) get(name);
	}
	public List<Long> getLongList(String name) {
		return (List<Long>) get(name);
	}
	public List<Double> getDoubleList(String name) {
		return (List<Double>) get(name);
	}
	public List<Float> getFloatList(String name) {
		return (List<Float>) get(name);
	}
	
	public String toString() {
		return toString(this);
	}
	public String toString(int count) {
		return toString(this, count);
	}
	
	public static String toString(JSON json) {
		return toString(json, 0);
	}
	public static String toString(JSON json, int count) {
		StringWriter out = new StringWriter();
		if (json == null) return "null";
		StringBuilder space = new StringBuilder();
		for (int i = 0; i < count; i++) space.append("\t"); 
		boolean first = true;
		Iterator<Entry<String, Object>> iter = json.entrySet().iterator();
		out.write("{\n");
		while (iter.hasNext()) {
			if (first) first = false;
			else out.write(",\n");
			Entry<String, Object> entry = iter.next();
			out.write(space.toString() + "\t\"" + entry.getKey() + "\":");
			JSONValue.toString(entry.getValue(), out, count + 1);
		}
		out.write("\n" + space.toString() + "}");
		return out.toString();
	}
}
