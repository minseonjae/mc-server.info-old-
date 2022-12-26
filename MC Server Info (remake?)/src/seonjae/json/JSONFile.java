package seonjae.json;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.util.List;
import java.util.Set;

import lombok.Cleanup;
import lombok.Getter;
import lombok.NonNull;
import lombok.Setter;
import lombok.SneakyThrows;
import seonjae.util.NumberUtil;

public class JSONFile {
	
	public JSONFile(@NonNull File file) {
		if (!file.getPath().substring(file.getPath().length() - 5).equalsIgnoreCase(".json")) 
			for (int i = 0; i < 100; i++) 
				System.out.println("Not JSON!!");;
		
		this.file = file;
	}
	
	@Setter
	@Getter
	private File file;
	
	protected JSON values = new JSON(), defaults = new JSON();
	
	@SneakyThrows(IOException.class)
	public void createFile() {
		if (file.exists()) return;
		
		int len = (int) file.getPath().length() - file.getName().length();
		int last = len < 0 ? 0 : len;
		
		new File(file.getPath().substring(0, last)).mkdirs();
		
		file.createNewFile();
	}
	
	public void deleteFile() {
		if (!file.exists()) return;
		file.delete();
	}
	
	public void clearDefaults() {
		defaults.clear();
	}
	public void clearValues() {
		values.clear();
	}
	
	public JSON saveToJson() {
		JSON json = new JSON();	
		
		defaults.keySet().forEach(key -> json.put(key, values.containsKey(key) ? values.get(key) : defaults.get(key)));
		values.keySet().forEach(key -> {
			if (!json.containsKey(key)) json.put(key, values.get(key));
		});
		
		return json;
	}
	public String saveToString() {
		return saveToJson().toString();
	}
	public String saveToString2() {
		return saveToJson().toString2();
	}
	
	@SneakyThrows
	public JSONFile save() {
		if (!file.exists()) createFile();
		
		@Cleanup FileOutputStream fos = new FileOutputStream(file);
		@Cleanup OutputStreamWriter osw = new OutputStreamWriter(fos, "UTF-8");
		@Cleanup BufferedWriter bw = new BufferedWriter(osw);
		
		bw.write(saveToString());
		return this;
	}
	@SneakyThrows
	public JSONFile saveDefaults() {
		if (!file.exists()) createFile();

		@Cleanup FileOutputStream fos = new FileOutputStream(file);
		@Cleanup OutputStreamWriter osw = new OutputStreamWriter(fos, "UTF-8");
		@Cleanup BufferedWriter bw = new BufferedWriter(osw);
		
		bw.write(saveToString());
		return this;
	}
	@SneakyThrows(Exception.class)
	public JSONFile load() {
		if (!file.exists()) save();
		
		@Cleanup FileInputStream fis = new FileInputStream(file);
		@Cleanup InputStreamReader isr = new InputStreamReader(fis, "UTF-8");
		@Cleanup BufferedReader br = new BufferedReader(isr);
		
		StringBuilder sb = new StringBuilder();
		String line = "";
		
		while ((line = br.readLine()) != null) {
			sb.append(line);
		}
		
		clearValues();
		values.putAll((JSON) new JSONParser().parse(sb.toString()));
		values = saveToJson();
		
		return this;
	}
	
	public void addDefault(String name, Object value) {
		defaults.put(name, value);
	}
	public Object getDefault(String name) {
		return defaults.get(name);
	}
	public void set(String name, Object value) {
		values.put(name, value);
	}
	
	public Set<String> getKeys() {
		return values.keySet();
	}
	
	public Object get(String name) {
		return values.get(name);
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
	public Short getShort(String name) {
		return NumberUtil.getShort(getString(name));
	}
	
	public List<Object> getList(String name) {
		return values.getList(name);
	}
	public List<String> getStringList(String name) {
		return values.getStringList(name);
	}
	public List<Integer> getIntegerList(String name) {
		return values.getIntegerList(name);
	}
	public List<Long> getLongList(String name) {
		return values.getLongList(name);
	}
	public List<Double> getDoubleList(String name) {
		return values.getDoubleList(name);
	}
	public List<Float> getFloatList(String name) {
		return values.getFloatList(name);
	}
}
