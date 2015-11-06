package com.finaonation.utils;

import com.nostra13.universalimageloader.cache.disc.naming.HashCodeFileNameGenerator;
import com.nostra13.universalimageloader.cache.memory.impl.UsingFreqLimitedMemoryCache;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageLoadingListener;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;
import android.app.Application;
import android.graphics.Bitmap.CompressFormat;

public class MyImageLoader extends Application{
	
	ImageLoadingListener loadingListner;
	DisplayImageOptions imgDisplayOptions;
	ImageLoader imageLoader;

	
	@Override
	public void onCreate() {
		// TODO Auto-generated method stub
		super.onCreate();
		
		ImageLoaderConfiguration config = new ImageLoaderConfiguration.Builder(
				getApplicationContext())
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
		
	}
}
