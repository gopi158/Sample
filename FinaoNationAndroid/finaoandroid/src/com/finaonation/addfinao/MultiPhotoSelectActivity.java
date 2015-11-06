package com.finaonation.addfinao;

import java.util.ArrayList;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.Bitmap.CompressFormat;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.util.SparseBooleanArray;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.GridView;
import android.widget.ImageView;

import com.finaonation.finao.R;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.utils.Constants;
import com.nostra13.universalimageloader.cache.disc.naming.HashCodeFileNameGenerator;
import com.nostra13.universalimageloader.cache.memory.impl.UsingFreqLimitedMemoryCache;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;
import com.nostra13.universalimageloader.core.assist.SimpleImageLoadingListener;

/**
 * @author Paresh Mayani (@pareshmayani)
 */
public class MultiPhotoSelectActivity extends Activity {
	private static final String TAG = "MultiPhotoSelectActivity";
	private ArrayList<String> imageUrls;
	private DisplayImageOptions options;
	private ImageAdapter mImageAdapter;
	protected ImageLoader imageLoader = ImageLoader.getInstance();
	private static final int REQUEST_CODE_CROP_IMAGE = 33;
	public static final String TEMP_PHOTO_FILE_NAME = "temp_photo.jpg";
	int uriListSize;

	private ArrayList<String> uriArray;

	@SuppressWarnings("deprecation")
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.ac_image_grid);

		uriListSize = getIntent().getIntExtra("size", 0);
		uriArray = new ArrayList<String>();

		final String[] columns = { MediaStore.Images.Media.DATA,
				MediaStore.Images.Media._ID };
		final String orderBy = MediaStore.Images.Media.DATE_TAKEN;
		Cursor imagecursor = managedQuery(
				MediaStore.Images.Media.EXTERNAL_CONTENT_URI, columns, null,
				null, orderBy + " DESC");
		if (null != imagecursor) {
			this.imageUrls = new ArrayList<String>();

			for (int i = 0; i < imagecursor.getCount(); i++) {
				imagecursor.moveToPosition(i);
				int dataColumnIndex = imagecursor
						.getColumnIndex(MediaStore.Images.Media.DATA);
				imageUrls.add(imagecursor.getString(dataColumnIndex));

				System.out.println("=====> Array path => " + imageUrls.get(i));
			}

			ImageLoaderConfiguration config = new ImageLoaderConfiguration.Builder(
					getApplicationContext())
					.memoryCacheExtraOptions(150, 150)
					.discCacheExtraOptions(480, 800, CompressFormat.JPEG, 75)
					.threadPoolSize(3)
					// default
					.threadPriority(Thread.NORM_PRIORITY - 1)
					// default
					.denyCacheImageMultipleSizesInMemory()
					.memoryCache(
							new UsingFreqLimitedMemoryCache(2 * 1024 * 1024))
					// default
					.memoryCacheSize(2 * 1024 * 1024)
					.discCacheSize(50 * 1024 * 1024)
					.discCacheFileCount(100)
					.discCacheFileNameGenerator(new HashCodeFileNameGenerator()) // default

					.tasksProcessingOrder(QueueProcessingType.FIFO) // default
					.defaultDisplayImageOptions(
							DisplayImageOptions.createSimple()) // default
					.enableLogging().build();

			// Get instance from ImageLoader
			ImageLoader.getInstance().init(config);
			options = new DisplayImageOptions.Builder()
					.showStubImage(R.drawable.stub_image)
					.showImageForEmptyUri(R.drawable.image_for_empty_url)
					.cacheInMemory().cacheOnDisc().build();

			mImageAdapter = new ImageAdapter(this, imageUrls);

			GridView gridView = (GridView) findViewById(R.id.gridview);
			gridView.setAdapter(mImageAdapter);
		} else {
			Log.i("MultiPhotoSelectActivity",
					"ZZZ3 ------ Cursor returned nullin create");
		}
	}

	@Override
	protected void onStop() {
		imageLoader.stop();
		super.onStop();
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);

		if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:
				ArrayList<String> list = data.getStringArrayListExtra("result");

				if (list != null) {
					for (int i = 0; i < list.size(); i++) {
						uriArray.add(list.get(i));
						if (Constants.LOG)
							Log.i(TAG, "uriArray" + list.get(i));
					}
					mImageAdapter.notifyDataSetChanged();
				}
				break;
			case RESULT_CANCELED:
				// imageTaken = null;
				break;
			}
		}
	}

	public void btnChoosePhotosClick(View v) {

		ArrayList<String> selectedItems = mImageAdapter.getCheckedItems();

		if (uriListSize == 0) {
			if (selectedItems.size() > 4) {
				showAlert("Please select only 4 images", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);
				imageLoader.stop();
				finish();
			}
		} else if (uriListSize == 1) {
			if (selectedItems.size() > 3) {
				showAlert("Please select only 3 image", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);
				imageLoader.stop();
				finish();
			}
		} else if (uriListSize == 2) {
			if (selectedItems.size() > 2) {
				showAlert("Please select only 2 image", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);
				imageLoader.stop();
				finish();
			}
		} else if (uriListSize == 3) {
			if (selectedItems.size() > 3) {
				showAlert("Please select only 1 image", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);
				imageLoader.stop();
				finish();
			}
		}
	}

	public class ImageAdapter extends BaseAdapter {

		ArrayList<String> mList;
		LayoutInflater mInflater;
		Context mContext;
		SparseBooleanArray mSparseBooleanArray;

		public ImageAdapter(Context context, ArrayList<String> imageList) {
			mContext = context;
			mInflater = LayoutInflater.from(mContext);
			mSparseBooleanArray = new SparseBooleanArray();
			mList = new ArrayList<String>();
			this.mList = imageList;

		}

		public ArrayList<String> getCheckedItems() {
			ArrayList<String> mTempArry = new ArrayList<String>();

			for (int i = 0; i < mList.size(); i++) {
				if (mSparseBooleanArray.get(i)) {
					mTempArry.add(mList.get(i));
				}
			}

			return mTempArry;
		}

		@Override
		public int getCount() {
			return imageUrls.size();
		}

		@Override
		public Object getItem(int position) {
			return null;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {

			if (convertView == null) {
				convertView = mInflater.inflate(R.layout.row_multiphoto_item,
						null);
			}

			CheckBox mCheckBox = (CheckBox) convertView
					.findViewById(R.id.checkBox1);
			final ImageView imageView = (ImageView) convertView
					.findViewById(R.id.imageView1);
			imageView.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					startCropImage(imageUrls.get(position));
				}
			});
			imageLoader.displayImage("file://" + imageUrls.get(position),
					imageView, options, new SimpleImageLoadingListener() {
						@Override
						public void onLoadingComplete(Bitmap loadedImage) {
							Animation anim = AnimationUtils.loadAnimation(
									MultiPhotoSelectActivity.this,
									R.anim.fade_in);
							imageView.setAnimation(anim);
							anim.start();
						}
					});

			mCheckBox.setTag(position);
			mCheckBox.setChecked(mSparseBooleanArray.get(position));
			mCheckBox.setOnCheckedChangeListener(mCheckedChangeListener);

			return convertView;
		}

		OnCheckedChangeListener mCheckedChangeListener = new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(CompoundButton buttonView,
					boolean isChecked) {
				mSparseBooleanArray.put((Integer) buttonView.getTag(),
						isChecked);

			}
		};
	}

	private void startCropImage(String imagePath) {

		Intent intent = new Intent(this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);

		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);

		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

	public void showAlert(final String displayText, String title) {
		AlertDialog.Builder alertbox = new AlertDialog.Builder(
				MultiPhotoSelectActivity.this);
		alertbox.setMessage(displayText);
		alertbox.setTitle(title);
		alertbox.setNeutralButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dlg, int button) {

			}
		});
		alertbox.show();
	}

}