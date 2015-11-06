package com.finaonation.profile;

import java.io.InputStream;
import java.net.URL;

import android.app.Activity;
import android.app.ProgressDialog;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.widget.ImageView;

import com.finaonation.finao.R;
import com.finaonation.utils.Constants;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class DisplayHomeImages extends Activity {

	public static final String TAG = "DisplayHomeImages";
	ImageView iv;
	URL url;
	InputStream is;
	Bitmap bmp = null;
	ImageLoader imageLoader;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.displayhomeimages);
		imageLoader = new ImageLoader(this);
		iv = (ImageView) findViewById(R.id.imageView2);
		Bundle b = getIntent().getExtras();
		if (b != null) {
			FinaoServiceLinks fs = new FinaoServiceLinks();
			String path = b.getString("ProfilePicPath");
			String str = fs.FinaoImagesLink();
			String u = str + path;
			if (Constants.LOG)
				Log.v("image URL", u);
			imageLoader.DisplayImage(u, iv, false, true);
		}
	}

	private class DisplayImageAssync extends AsyncTask<Void, Void, Bitmap> {

		String imgpath;
		ProgressDialog pDialog = new ProgressDialog(DisplayHomeImages.this);

		public DisplayImageAssync(String path) {
			this.imgpath = path;
		}

		protected void onPreExecute() {

			pDialog.setMessage("Loading Image Please Wait");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected Bitmap doInBackground(Void... params) {

			try {
				FinaoServiceLinks fs = new FinaoServiceLinks();
				String str = fs.FinaoImagesLink();
				String path = str + imgpath;
				path = path.replaceAll(" ", "%20");
				if (Constants.LOG)
					Log.i(TAG, "url :" + url);
				is = new java.net.URL(path).openStream();
				bmp = BitmapFactory.decodeStream(is);
			} catch (Exception e) {
				e.printStackTrace();
			}
			return bmp;
		}

		protected void onPostExecute(Bitmap result) {

			pDialog.dismiss();
			iv.setImageBitmap(result);
		}
	}

}
