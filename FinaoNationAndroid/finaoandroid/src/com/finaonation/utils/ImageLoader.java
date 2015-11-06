package com.finaonation.utils;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Collections;
import java.util.Map;
import java.util.WeakHashMap;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import com.finaonation.finao.R;
import android.os.Handler;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Log;
import android.widget.ImageView;

public class ImageLoader {
	private static final String TAG = "ImageLoader";
	MemoryCache memoryCache = new MemoryCache();
	FileCache fileCache;
	private Map<ImageView, String> imageViews = Collections
			.synchronizedMap(new WeakHashMap<ImageView, String>());
	ExecutorService executorService;
	Handler handler = new Handler();// handler to display images in UI thread

	public ImageLoader(Context context) {
		fileCache = new FileCache(context);
		executorService = Executors.newFixedThreadPool(5);
	}

	final int stub_id = R.drawable.loading;

	public void DisplayImage(String urlW, ImageView imageView, boolean scale, boolean inSample) {
		String url = urlW.replaceAll(" ", "%20");
		imageViews.put(imageView, url);
		Bitmap bitmap = memoryCache.get(url);
		if (bitmap != null) {
			if (scale) {
				int bwidth = bitmap.getWidth();
				int bheight = bitmap.getHeight();
				int ivwidth = imageView.getWidth();
				int ivheight = imageView.getHeight();
				if (ivwidth == 0 && ivheight == 0) {
					ivwidth = bwidth;
					ivheight = bheight;
				}

				int new_width = ivwidth;
				int new_height = (int) Math.floor((double) bheight
						* ((double) new_width / (double) bwidth));
				try {
					Bitmap newbitMap = Bitmap.createBitmap(bitmap, 0, 0,
							new_width, new_height);
					imageView.setImageBitmap(newbitMap);
				} catch (Exception ex) {
					imageView.setImageBitmap(bitmap);
				}
				imageView.setScaleType(ImageView.ScaleType.CENTER_CROP);
			} else {
				imageView.setImageBitmap(bitmap);
			}
		} else {
			queuePhoto(url, imageView, scale,inSample);
			imageView.setImageResource(stub_id);
		}
	}

	private void queuePhoto(String url, ImageView imageView, boolean scale, boolean inSample) {
		PhotoToLoad p = new PhotoToLoad(url, imageView);
		executorService.submit(new PhotosLoader(p, scale,inSample));
	}

	private Bitmap getBitmap(String url, boolean inSample) {
		File f = fileCache.getFile(url);
		// from SD cache
		Bitmap b = decodeFile(f, inSample);
		if (b != null)
			return b;
		// from web
		try {
			Bitmap bitmap = null;
			URL imageUrl = new URL(url);
			HttpURLConnection conn = (HttpURLConnection) imageUrl
					.openConnection();
			conn.setConnectTimeout(30000);
			conn.setReadTimeout(30000);
			conn.setInstanceFollowRedirects(true);
			InputStream is = conn.getInputStream();
			OutputStream os = new FileOutputStream(f);
			Utils.CopyStream(is, os);
			os.close();
			conn.disconnect();
			bitmap = decodeFile(f, inSample);
			return bitmap;
		} catch (Throwable ex) {
			ex.printStackTrace();
			if (ex instanceof OutOfMemoryError) {
				Log.e(TAG, "getBitmap OutOfMemoryError " + url);
				memoryCache.clear();
			} else
				Log.e(TAG, "getBitmap catch " + ex.getMessage() + " " + url);
			return null;
		}
	}

	// decodes image and scales it to reduce memory consumption
	private Bitmap decodeFile(File f, boolean inSample) {
		try {
			// decode image size
			BitmapFactory.Options o = new BitmapFactory.Options();
			o.inJustDecodeBounds = true;
			FileInputStream stream1 = new FileInputStream(f);
			BitmapFactory.decodeStream(stream1, null, o);
			stream1.close();

			// Find the correct scale value. It should be the power of 2.
			final int REQUIRED_SIZE = 300;
			int width_tmp = o.outWidth, height_tmp = o.outHeight;
			int scale = 3;
			if(!inSample)
				scale = 1;
			while (true) {
				if (width_tmp / 2 < REQUIRED_SIZE
						|| height_tmp / 2 < REQUIRED_SIZE)
					break;
				width_tmp /= 2;
				height_tmp /= 2;
				scale *= 2;
			}
			Log.i(TAG, "inSampleSize " + scale);
			// decode with inSampleSize
			BitmapFactory.Options o2 = new BitmapFactory.Options();
			o2.inSampleSize = scale;
			FileInputStream stream2 = new FileInputStream(f);
			Bitmap bitmap = BitmapFactory.decodeStream(stream2, null, o2);
			stream2.close();
			return bitmap;
		} catch (FileNotFoundException e) {
			Log.i(TAG, "decodeFile FileNotFoundException " + e.getMessage());
		} catch (IOException e) {
			Log.e(TAG, "decodeFile IOException" + e.getMessage());
			e.printStackTrace();
		} catch (Exception e) {
			Log.e(TAG, "decodeFile Exception" + e.getMessage());
			e.printStackTrace();
			}
		return null;
	}

	// Task for the queue
	private class PhotoToLoad {
		public String url;
		public ImageView imageView;

		public PhotoToLoad(String u, ImageView i) {
			url = u;
			imageView = i;
		}
	}

	private class PhotosLoader implements Runnable {

		PhotoToLoad photoToLoad;
		boolean thisScale = false;
		boolean thisinSample = true;

		PhotosLoader(PhotoToLoad photoToLoad, boolean scale, boolean inSample) {
			this.photoToLoad = photoToLoad;
			thisScale = scale;
			thisinSample = inSample;
		}

		@Override
		public void run() {
			try {
				if (imageViewReused(photoToLoad))
					return;
				Bitmap bmp = getBitmap(photoToLoad.url, thisinSample);
				if (bmp != null)
					memoryCache.put(photoToLoad.url, bmp);
				if (imageViewReused(photoToLoad))
					return;
				BitmapDisplayer bd = new BitmapDisplayer(bmp, photoToLoad,
						thisScale);
				handler.post(bd);
			} catch (Exception th) {
				Log.e(TAG, "PhotosLoader run converting result "
						+ photoToLoad.url + " " + th.getMessage());
				th.printStackTrace();
			}
		}
	}

	private boolean imageViewReused(PhotoToLoad photoToLoad) {
		String tag = imageViews.get(photoToLoad.imageView);
		if (tag == null || !tag.equals(photoToLoad.url))
			return true;
		return false;
	}

	// Used to display bitmap in the UI thread
	private class BitmapDisplayer implements Runnable {
		Bitmap bitmap;
		PhotoToLoad photoToLoad;
		boolean thisScale = false;

		public BitmapDisplayer(Bitmap b, PhotoToLoad p, boolean scale) {
			thisScale = scale;
			bitmap = b;
			photoToLoad = p;
		}

		public void run() {
			if (imageViewReused(photoToLoad))
				return;
			if (bitmap != null) {
				if (thisScale) {
					int bwidth = bitmap.getWidth();
					int bheight = bitmap.getHeight();
					int ivwidth = photoToLoad.imageView.getWidth();
					int ivheight = photoToLoad.imageView.getHeight();
					if (ivwidth == 0 && ivheight == 0) {
						ivwidth = bwidth;
						ivheight = bheight;
					}

					int new_width = ivwidth;
					int new_height = (int) Math.floor((double) bheight
							* ((double) new_width / (double) bwidth));
					try {
						Bitmap newbitMap = Bitmap.createBitmap(bitmap, 0, 0,
								new_width, new_height);
						photoToLoad.imageView.setImageBitmap(newbitMap);
					} catch (Exception ex) {
						photoToLoad.imageView.setImageBitmap(bitmap);
					}
					photoToLoad.imageView
							.setScaleType(ImageView.ScaleType.CENTER_CROP);
				} else {
					photoToLoad.imageView.setImageBitmap(bitmap);
				}
			} else
				photoToLoad.imageView.setImageResource(R.drawable.noimage);
		}
	}

	public void clearCache() {
		memoryCache.clear();
		fileCache.clear();
	}

}
