package com.finaonation.utils;

import org.apache.http.client.HttpClient;
import org.apache.http.conn.ClientConnectionManager;
import org.apache.http.conn.scheme.PlainSocketFactory;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.conn.ssl.SSLSocketFactory;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.tsccm.ThreadSafeClientConnManager;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpParams;

public class SingleTon {
	private static SingleTon instance;
	private HttpClient httpClient;

	private SingleTon() {
		initHttpClient();
	}

	public static SingleTon getInstance() {
		try {
			if (instance != null) {
				return instance;
			} else {
				instance = new SingleTon();
				return instance;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return instance;
	}

	@SuppressWarnings("unused")
	private void initHttpClient() {
		try {
			HttpParams httpParameters = new BasicHttpParams();
			// Set the timeout in milliseconds until a connection is
			// established.
			int timeoutConnection = 7000;
			// HttpConnectionParams.setConnectionTimeout(httpParameters,
			// timeoutConnection);
			// Set the default socket timeout (SO_TIMEOUT)
			// in milliseconds which is the timeout for waiting for data.
			int timeoutSocket = 15000;
			// HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
			httpParameters
					.setParameter("http.connection-manager.max-total", 10);
			// Create and initialize scheme registry
			SchemeRegistry schemeRegistry = new SchemeRegistry();
			schemeRegistry.register(new Scheme("http", PlainSocketFactory
					.getSocketFactory(), 80));
			schemeRegistry.register(new Scheme("https", SSLSocketFactory
					.getSocketFactory(), 443));

			ClientConnectionManager cm = new ThreadSafeClientConnManager(
					httpParameters, schemeRegistry);// (params, schemeRegistry);
			httpClient = new DefaultHttpClient(cm, httpParameters);
		} catch (Exception e) {
			e.printStackTrace();
		}

	}

	public HttpClient getHttpClient() {
		if (httpClient == null) {
			initHttpClient();
		}
		return httpClient;
	}
}
