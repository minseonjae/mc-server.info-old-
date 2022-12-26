package seonjae.json;

import java.io.File;
import java.util.Set;

public class JSONConfig extends JSONFile{
	
	public JSONConfig(File file) {
		super(file);
	}
	
	public void addDefault(String name, Object value) {
		String[] msg = name.split("\\.");
		JSON json = defaults;
		for (int i = 0; i < msg.length - 1; i++) {
			Object o = json.get(msg[i]);
			if (o instanceof JSON) json = (JSON) o;	
			else json.put(msg[i], json = new JSON());
		}
		json.put(msg[msg.length - 1], value);
	}
	public void set(String name, Object value) {
		String[] msg = name.split("\\.");
		JSON json = values;
		for (int i = 0; i < msg.length - 1; i++) {
			Object o = json.get(msg[i]);
			if (o instanceof JSON) json = (JSON) o;	
			else json.put(msg[i], json = new JSON());
		}
		json.put(msg[msg.length - 1], value);
	}
	
	public Object get(String name) {
		String[] msg = name.split("\\.");
		JSON json = values;
		for (int i = 0; i < msg.length - 1; i++) {
			Object o = json.get(msg[i]);
			if (o instanceof JSON) json = (JSON) o;	
			else return null;
		}
		return json.get(msg[msg.length - 1]);
	}
	
	public Set<String> getKeys(String name) {
		String[] msg = name.split("\\.");
		JSON json = values;
		for (int i = 0; i < msg.length - 1; i++) {
			Object o = json.get(msg[i]);
			if (o instanceof JSON) json = (JSON) o;	
			else return null;
		}
		Object var = json.get(msg[msg.length - 1]);
		return var instanceof JSON ? ((JSON) var).keySet() : null;
	}
}
