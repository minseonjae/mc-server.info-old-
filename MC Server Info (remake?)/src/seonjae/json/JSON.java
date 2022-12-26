package seonjae.json;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

import seonjae.util.NumberUtil;

public class JSON extends LinkedHashMap<String, Object> implements Map<String, Object> {
	
	public void removeAll(Collection<String> list) {
		for (String n : list) if (this.containsKey(n)) this.remove(n);
	}
	public void removeAll(Map<String, ?> map) {
		removeAll(map.keySet());
	}
	
	public JSON getJson(String name) {
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
		ArrayList<Integer> list = new ArrayList<>();
		getLongList(name).forEach(i -> list.add(i > 2100000000 ? Integer.parseInt(i + "") : 0));
		return list;
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
	public String toString2() {
		return toString(this).replace("\t", "").replace("\n", "").replace("\r", "");
	}
	public String toString(int count) {
		return toString(this, count);
	}
	
	private String toString(JSON json) {
		return toString(json, 0);
	}
	private String toString(JSON json, int count) {
		StringWriter out = new StringWriter();
		if (json == null) return "null";
		StringBuilder space = new StringBuilder();
		for (int i = 0; i < count; i++) space.append("\t"); 
		boolean first = true;
		Iterator<Entry<String, Object>> iter = json.entrySet().iterator();
		out.write("{\r\n");
		while (iter.hasNext()) {
			if (first) first = false;
			else out.write(",\r\n");
			Entry<String, Object> entry = iter.next();
			out.write(space.toString() + "\t\"" + entry.getKey() + "\":");
			JSONValue.toString(entry.getValue(), out, count + 1);
		}
		out.write("\r\n" + space.toString() + "}");
		return out.toString();
	}
}
