package com.finaonation.utils;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;

import com.facebook.android.AsyncFacebookRunner;
import com.facebook.android.Facebook;

public class Util {

	// Facebook APP ID
	private static String APP_ID = "424392384305767";

	// Instance of Facebook Class
	public static Facebook facebook = new Facebook(APP_ID);
	public static AsyncFacebookRunner mAsyncRunner;
	static String line;

	public static String convertHttpResponseToString(HttpResponse response) {
		String responseString = null;
		BufferedReader bufferedReader = null;
		try {
			if (response != null && !response.equals("")) {

				try {
					bufferedReader = new BufferedReader(new InputStreamReader(
							response.getEntity().getContent()));
				} catch (IllegalStateException e1) {
					e1.printStackTrace();
				} catch (Exception e1) {
					e1.printStackTrace();
				}
				StringBuffer stringBuffer = new StringBuffer("");
				String lineString = "";
				String NLString = System.getProperty("line.separator");
				try {
					while ((lineString = bufferedReader.readLine()) != null) {
						stringBuffer.append(lineString + NLString);
					}
				} catch (Exception e) {
					e.printStackTrace();
				}
				responseString = stringBuffer.toString();
			}
		} catch (Exception e) {
			responseString = null;
		} finally {
			if (bufferedReader != null) {
				try {
					bufferedReader.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}

		return responseString;
	}

	public static void CopyStream(InputStream is, OutputStream os) {
		final int buffer_size = 1024;
		try {
			byte[] bytes = new byte[buffer_size];
			for (;;) {
				int count = is.read(bytes, 0, buffer_size);
				if (count == -1)
					break;
				os.write(bytes, 0, count);
			}
		} catch (Exception ex) {
		}
	}

	public static String convertResponseToString(HttpResponse response) {
		StringBuilder sb = null;
		HttpEntity entity = response.getEntity();
		InputStream is;
		try {
			is = entity.getContent();
			// if(Constants.LOG)
			// Log.i("", "response"+response);

			BufferedReader reader = new BufferedReader(new InputStreamReader(
					is, "UTF-8"), 8);
			sb = new StringBuilder();
			while ((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}
			is.close();
		} catch (IllegalStateException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}

		return sb.toString();
	}
}
