package seonjae.util;

import java.io.File;
import java.net.URL;
import java.net.URLClassLoader;
import java.nio.charset.Charset;
import java.util.Arrays;
import java.util.Locale;

import javax.tools.DiagnosticCollector;
import javax.tools.JavaCompiler;
import javax.tools.JavaFileObject;
import javax.tools.StandardJavaFileManager;
import javax.tools.ToolProvider;

import lombok.Cleanup;
import lombok.SneakyThrows;
import lombok.experimental.UtilityClass;

@UtilityClass
public class JavaUtil {
	
	public String setJAVA_HOME(String path) {
		return System.setProperty("java.home", path);
	}
	public String getJAVA_HOME() {
		return System.getProperty("java.home");
	}
	
	public JavaCompiler getSystemCompiler() {
		return ToolProvider.getSystemJavaCompiler();
	}
	
	@SneakyThrows(Exception.class)
	public void compile(File out, File... in) {
		JavaCompiler compiler = getSystemCompiler();
		if (compiler == null) throw new Exception();
		DiagnosticCollector<JavaFileObject> diagnostics = new DiagnosticCollector<>();
		@Cleanup StandardJavaFileManager manager = compiler.getStandardFileManager(diagnostics, Locale.KOREA, Charset.forName("UTF-8"));
		compiler.getTask(null, manager, diagnostics, Arrays.asList("-d", out.getAbsolutePath(), "-g", "-proc:none"), null, manager.getJavaFileObjects(in)).call();
	}
	
	@SneakyThrows(Exception.class)
	public ClassLoader loadFolderClass(File folder) {
		return new URLClassLoader(new URL[] {folder.toURL()});
	}
}
