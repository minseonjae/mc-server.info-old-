package seonjae.program.mcsi.api.util;

import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.InetSocketAddress;
import java.net.Socket;

import org.xbill.DNS.Lookup;
import org.xbill.DNS.Record;
import org.xbill.DNS.SRVRecord;
import org.xbill.DNS.Type;

import lombok.Cleanup;
import lombok.experimental.UtilityClass;
import seonjae.program.mcsi.api.MCSI;

@UtilityClass
public class SocketUtil {
	public Object[] getSRVRecord(String ip, int port) {
		try {
			Record[] record = new Lookup("_Minecraft._tcp." + ip, Type.SRV).run();
			if (record == null) throw new Exception();
			SRVRecord srv = (SRVRecord) record[0];
			return new Object[] {srv.getTarget().toString(), srv.getPort(), true};
		} catch (Exception e) {
			return new Object[] {ip, port, false};
		}
	}
	public Object[] getMCServerInfo(String ip, int port) {
		try {
			long start = System.currentTimeMillis();
			
			@Cleanup Socket socket = new Socket();
			socket.connect(new InetSocketAddress(ip, port), MCSI.getTimeout_socket());
			
			@Cleanup DataOutputStream dos = new DataOutputStream(socket.getOutputStream());
			InputStream is = socket.getInputStream();
			@Cleanup InputStreamReader isr = new InputStreamReader(socket.getInputStream(), "UTF-16BE");
			
			dos.write(new byte[] {(byte) 0xFE, (byte) 0x01});
			
			int packet1 = is.read();		
			if (packet1 != 0xFF) throw new Exception();
			
			int packet2 = isr.read();
			if (packet2 < 1 && packet2 > -1) throw new Exception();
			
			char[] data = new char[packet2];
			if (isr.read(data, 0, packet2) != packet2) throw new Exception();
			
			return new Object[] {System.currentTimeMillis() - start, new String(data)};
		} catch (Exception e) {
			return null;
		}
	}
}
