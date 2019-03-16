package seonjae.json;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.util.List;

import lombok.Cleanup;
import lombok.Getter;
import lombok.Setter;
import lombok.SneakyThrows;
import seonjae.util.NumberUtil;

public class JSONFile {
	
	public JSONFile() {}
	public JSONFile(String path) {
		this.path = path;
	}
	public JSONFile(JSONFormat format) {
		format.initalJSON(jSON);
	}
	public JSONFile(String path, JSONFormat format) {
		this(path);
		format.initalJSON(jSON);
	}
	
	@Setter
	@Getter
	private String path = "config.json";
	
	public File getFile() {
		return new File(path);
	}
	
	@Setter
	@Getter
	private JSON jSON = new JSON();
	
	@SneakyThrows
	public JSONFile save() {
		File file = getFile();
		String name = file.getName(), path = file.getPath().substring(0, file.getPath().length() - file.getName().length());
		if (name.endsWith(".json") && path.length() > 1) {
			File folder = new File(path);
			if (!folder.exists()) folder.mkdirs();
		}
		@Cleanup FileOutputStream fos = new FileOutputStream(file);
		@Cleanup OutputStreamWriter osw = new OutputStreamWriter(fos, Charset.forName("UTF-8"));
		@Cleanup BufferedWriter bw = new BufferedWriter(osw);
		bw.write(jSON.toString());
		return this;
	}
	@SneakyThrows
	public JSONFile load() {
		File file = getFile();
		if (!file.exists()) save();
		boolean save = false;
		@Cleanup FileInputStream fis = new FileInputStream(file);
		@Cleanup InputStreamReader isr = new InputStreamReader(fis, Charset.forName("UTF-8"));
		@Cleanup BufferedReader br = new BufferedReader(isr);
		StringBuilder sb = new StringBuilder();
		String line;
		while ((line = br.readLine()) != null) {
			sb.append(line);
		}
		JSON loadJSON = (JSON) new JSONParser().parse(sb.toString());
		for (String name : jSON.keySet()) if (loadJSON.get(name) == null) save = true; 
		jSON.addJSON(loadJSON);
		if (save) save();
		return this;
	}
	
	public void set(String name, Object value) {
		jSON.put(name, value);
	}
	
	public Object get(String name) {
		return jSON.get(name);
	}
	public JSON getJSON(String name) {
		return (JSON) jSON.get(name);
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
}
