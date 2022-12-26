package seonjae.util;

import java.lang.reflect.Field;
import java.lang.reflect.Method;

import lombok.experimental.UtilityClass;

@UtilityClass
public class ReflectionUtil {
	
	public Method getMethod(Class<?> clazz, String name) {
		for (Method m : clazz.getMethods()) if (m.getName().equals(name)) return m;
		return null;
	}
	public Method getMethod(Class<?> clazz, String name, Class<?>... list) {
		for (Method m : clazz.getMethods()) if (m.getName().equals(name)) if (ClassListEquals(m.getParameterTypes(), list)) return m;
		return null;
	}
	public Method getDeclaredMethods(Class<?> clazz, String name) {
		for (Method m : clazz.getDeclaredMethods()) if (m.getName().equals(name)) return m;
		return null;
	}
	public Method getDeclaredMethods(Class<?> clazz, String name, Class<?>... list) {
		for (Method m : clazz.getMethods()) if (m.getName().equals(name)) if (ClassListEquals(m.getParameterTypes(), list)) return m;
		return null;
	}
	public Field getField(Class<?> clazz, String name) {
		for (Field f : clazz.getFields()) if (f.getName().equals(name)) return f;
		return null;
	}
	public Field getDeclaredField(Class<?> clazz, String name) {
		for (Field f : clazz.getDeclaredFields()) if (f.getName().equals(name)) return f;
		return null;
	}
	
	public boolean ClassListEquals(Class<?>[] list1, Class<?>[] list2) {
		if (list1.length != list2.length) return false;
		for (int i = 0; i < list1.length; i++) if (list1[i] != list2[i]) return false;
		return true;
	}
}