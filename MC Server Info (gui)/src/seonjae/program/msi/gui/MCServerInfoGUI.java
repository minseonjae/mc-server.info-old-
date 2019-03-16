package seonjae.program.msi.gui;

import java.awt.Font;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JTextArea;
import javax.swing.JScrollPane;
import javax.swing.SwingConstants;

import lombok.Getter;
import seonjae.util.StringUtil;
import seonjae.program.msi.MCSI;

public class MCServerInfoGUI extends JFrame {
	
	@Getter
	private JTextArea serverTextArea, threadTextArea;
	
	public MCServerInfoGUI() {
		super("MCServerInfo");
		
		setSize(635, 520);
		
		setResizable(false);
		
		setLocationRelativeTo(null);
		
		setDefaultCloseOperation(EXIT_ON_CLOSE);
		
		setLayout(null);
		
		addWindowListener(new WindowAdapter() {
			public void windowClosed(WindowEvent e) {
				MCSI.getFileManager().saveServerLog();
				MCSI.getFileManager().saveThreadLog();
			}
		});
		
		JLabel label1 = new JLabel("Thread Log");
		label1.setHorizontalAlignment(SwingConstants.LEFT);
		label1.setBounds(10, 5, 100, 15);
		add(label1);
		
		JScrollPane pane1 = new JScrollPane();
		pane1.setBounds(10, 25, 280, 455);
		add(pane1);
		threadTextArea = new JTextArea();
		threadTextArea.setEditable(false);
		threadTextArea.setFont(new Font("나눔고딕", Font.PLAIN, 12));
		pane1.setViewportView(threadTextArea);

		JLabel label2 = new JLabel("Server Log");
		label2.setHorizontalAlignment(SwingConstants.LEFT);
		label2.setBounds(300, 5, 100, 15);
		add(label2);
		
		JScrollPane pane2 = new JScrollPane();
		pane2.setBounds(300, 25, 320, 455);
		add(pane2);
		serverTextArea = new JTextArea();
		serverTextArea.setEditable(false);
		serverTextArea.setFont(new Font("나눔고딕", Font.PLAIN, 12));
		pane2.setViewportView(serverTextArea);
	}
	
	public void appendThreadLog(String message) {
		threadTextArea.append(StringUtil.dateString("yyyy-MM-dd a hh:mm:ss - ") + message + "\n");
		if (getThreadLog().length > 149) {
			MCSI.getFileManager().saveThreadLog();
			threadTextArea.setText(null);
		}
		threadTextArea.setCaretPosition(threadTextArea.getDocument().getLength());
	}
	public void appendServerLog(String message) {
		serverTextArea.append(StringUtil.dateString("yyyy-MM-dd a hh:mm:ss - ") + message + "\n");
		if (getServerLog().length > 149) {
			MCSI.getFileManager().saveServerLog();
			serverTextArea.setText(null);
		}
		serverTextArea.setCaretPosition(serverTextArea.getDocument().getLength());
	}
	
	public String[] getThreadLog() {
		return threadTextArea.getText().split("\n");
	}
	public String[] getServerLog() {
		return serverTextArea.getText().split("\n");
	}
}
