package com.finaonation.finao;

import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.MediaPlayer.OnCompletionListener;
import android.media.MediaPlayer.OnPreparedListener;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;
import android.widget.MediaController;
import android.widget.VideoView;

import com.finaonation.utils.Constants;

@SuppressWarnings("unused")
public class Videoplayer extends Activity {
	private static String TAG = "Videoplayer";
	private VideoView videoPlayer;
	private AudioManager mAudioManager;
	MediaController mediaController;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		setContentView(R.layout.activity_videoplayer);

		Intent intent = getIntent();
		String url = intent.getStringExtra("videourl");
		int seektime = intent.getIntExtra("seektime", 0);
		Log.i("intent values", "url is " + url + "," + "seektime is " + ""
				+ seektime);

		// new gettingRstp(url).execute();
		videoPlayer = (VideoView) findViewById(R.id.videoPlayer);
		mediaController = new MediaController(this);
		mediaController.setAnchorView(videoPlayer);
		videoPlayer.setMediaController(mediaController);
		videoPlayer.setVideoURI(Uri.parse(url));
		videoPlayer.seekTo(seektime);
		videoPlayer.start();
		if (Constants.LOG)
			Log.i(TAG, "url:" + url);
		videoPlayer.setOnCompletionListener(new OnCompletionListener() {

			@Override
			public void onCompletion(MediaPlayer mp) {
				finish();
			}
		});

	}

	private class gettingRstp extends AsyncTask<String, String, String> {
		String URL;

		public gettingRstp(String url) {
			URL = url;
		}

		ProgressDialog pDialog;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(Videoplayer.this);
			pDialog.setMessage("Loading Video...");
			pDialog.setCancelable(false);
			pDialog.show();
		}

		@Override
		protected String doInBackground(String... params) {
			// TODO Auto-generated method stub
			String rstpuri = getUrlVideoRTSP(URL);
			if (Constants.LOG)
				Log.i(TAG, "rstpuri:" + rstpuri);
			return rstpuri;
		}

		protected void onPostExecute(String obj) {
			super.onPostExecute(obj);
			if (Constants.LOG)
				Log.i(TAG, "onPostExecute rstpuri obj is:" + obj);
			mediaController.setAnchorView(videoPlayer);
			videoPlayer.setMediaController(mediaController);
			videoPlayer.setVideoURI(Uri.parse(obj));
			videoPlayer.setOnPreparedListener(new OnPreparedListener() {

				public void onPrepared(MediaPlayer mp) {
					pDialog.dismiss(); // or hide any popup or what ever
					videoPlayer.start(); // start the video
				}
			});

		}

	}

	public static String getUrlVideoRTSP(String urlYoutube) {
		try {
			String gdy = "http://gdata.youtube.com/feeds/api/videos/";
			DocumentBuilder documentBuilder = DocumentBuilderFactory
					.newInstance().newDocumentBuilder();
			String id = extractYoutubeId(urlYoutube);
			if (id != null) {
				URL url = new URL(gdy + id);
				HttpURLConnection connection = (HttpURLConnection) url
						.openConnection();
				Document doc = documentBuilder.parse(connection
						.getInputStream());
				Element el = doc.getDocumentElement();
				NodeList list = el.getElementsByTagName("media:content");// /media:content
				String cursor = urlYoutube;
				for (int i = 0; i < list.getLength(); i++) {
					Node node = list.item(i);
					if (node != null) {
						NamedNodeMap nodeMap = node.getAttributes();
						HashMap<String, String> maps = new HashMap<String, String>();
						for (int j = 0; j < nodeMap.getLength(); j++) {
							Attr att = (Attr) nodeMap.item(j);
							maps.put(att.getName(), att.getValue());
						}
						if (maps.containsKey("yt:format")) {
							String f = maps.get("yt:format");
							if (maps.containsKey("url")) {
								cursor = maps.get("url");
							}
							if (f.equals("1"))
								return cursor;
						}
					}
				}
				return cursor;
			}
		} catch (Exception ex) {
			if (Constants.LOG)
				Log.e("Get Url Video RTSP Exception======>>", ex.toString());
		}
		return urlYoutube;

	}

	protected static String extractYoutubeId(String url)
			throws MalformedURLException {
		String id = null;
		try {
			String query = new URL(url).getQuery();
			if (query != null) {
				String[] param = query.split("&");
				for (String row : param) {
					String[] param1 = row.split("=");
					if (param1[0].equals("v")) {
						id = param1[1];
					}
				}
			} else {
				if (url.contains("embed")) {
					id = url.substring(url.lastIndexOf("/") + 1);
				}
			}
		} catch (Exception ex) {
			Log.e("Exception", ex.toString());
		}
		if (Constants.LOG)
			Log.e(TAG, "id is " + id);
		return id;
	}

	@Override
	public void onBackPressed() {
		Intent returnIntent = new Intent();
		returnIntent.putExtra("seektime", videoPlayer.getCurrentPosition());
		setResult(RESULT_OK, returnIntent);
		finish();
	}

}
