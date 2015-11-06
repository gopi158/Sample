package com.finaonation.profile;

import java.util.ArrayList;

import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap.CompressFormat;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;

import com.finaonation.beanclasses.TrendingDetailPojo;
import com.finaonation.finao.R;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;
import com.nostra13.universalimageloader.cache.disc.naming.HashCodeFileNameGenerator;
import com.nostra13.universalimageloader.cache.memory.impl.UsingFreqLimitedMemoryCache;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageLoadingListener;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;

public class FullScreenFinalDetails extends Activity {

	private ImageView mFinaoGallery = null;
	ImageLoadingListener loadingListner;
	DisplayImageOptions imgDisplayOptions;
	public ImageLoader imageLoader;
	private FullScreenFinalDetails mActivity = null;
	private int position = 0;
	ArrayList<TrendingDetailPojo> mFinao_List_Data = null;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		setContentView(R.layout.fullscreen_finaoimage);
		mActivity = this;
		ImageLoaderConfiguration config = new ImageLoaderConfiguration.Builder(
				mActivity)
				.memoryCacheExtraOptions(150, 150)
				.discCacheExtraOptions(480, 800, CompressFormat.JPEG, 75)
				.threadPoolSize(3)
				// default
				.threadPriority(Thread.NORM_PRIORITY - 1)
				// default
				.denyCacheImageMultipleSizesInMemory()
				.memoryCache(new UsingFreqLimitedMemoryCache(2 * 1024 * 1024))
				// default
				.memoryCacheSize(2 * 1024 * 1024)
				.discCacheSize(50 * 1024 * 1024).discCacheFileCount(100)
				.discCacheFileNameGenerator(new HashCodeFileNameGenerator()) // default

				.tasksProcessingOrder(QueueProcessingType.FIFO) // default
				.defaultDisplayImageOptions(DisplayImageOptions.createSimple()) // default
				.enableLogging().build();

		// Get instance from ImageLoader
		ImageLoader.getInstance().init(config);

		imgDisplayOptions = new DisplayImageOptions.Builder().cacheInMemory()
				.cacheOnDisc().showImageForEmptyUri(R.drawable.app_icon)
				.cacheInMemory().cacheOnDisc()
				.showImageForEmptyUri(R.drawable.noimage)
				// .showImageOnFail(R.string.error_loading)
				// .imageScaleType(ImageScaleType.EXACT)
				.build();
		imageLoader = ImageLoader.getInstance();
		imageLoader.init(config);
		mFinaoGallery = (ImageView) findViewById(R.id.finaoFulImages);
		getIntentValues();

		FinaoServiceLinks finaoServices = new FinaoServiceLinks();
		if (mFinao_List_Data != null && mFinao_List_Data.size() > 0) {
			TrendingDetailPojo tp = mFinao_List_Data.get(position);
			imageLoader.displayImage(
					finaoServices.FinaoFullImagesLink()
							+ tp.getUpload_File_Path(), mFinaoGallery);
		}

		/*
		 * mFinaoGallery.setAdapter(new MyFullScreenAdapter(mActivity));
		 * mFinaoGallery.setSelection(position);
		 */
	}

	@SuppressWarnings("unchecked")
	private void getIntentValues() {
		mFinao_List_Data = new ArrayList<TrendingDetailPojo>();
		mFinao_List_Data = (ArrayList<TrendingDetailPojo>) getIntent()
				.getExtras().getSerializable("finaoListImages");
		position = getIntent().getExtras().getInt("position");
		if (Constants.LOG)
			Log.v("Finao list data", "Full ScreenTest: " + mFinao_List_Data
					+ "pos " + position);
	}

	class MyFullScreenAdapter extends BaseAdapter {
		Context c = null;

		public MyFullScreenAdapter(FullScreenFinalDetails mActivity) {
			c = mActivity;
		}

		@Override
		public int getCount() {
			return mFinao_List_Data.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		@Override
		public View getView(int pos, View convertView, ViewGroup parent) {

			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			View v = li.inflate(R.layout.finao_image, null);
			ImageView iv = (ImageView) v.findViewById(R.id.finaoFulImages);
			FinaoServiceLinks finaoServices = new FinaoServiceLinks();
			if (mFinao_List_Data != null && mFinao_List_Data.size() > 0) {
				TrendingDetailPojo tp = mFinao_List_Data.get(pos);
				imageLoader.displayImage(finaoServices.FinaoFullImagesLink()
						+ tp.getUpload_File_Path(), iv);
			}
			return v;
		}

	}
}
