package com.finaonation.addfinao;

import java.util.ArrayList;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.CursorLoader;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.media.ThumbnailUtils;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.SparseBooleanArray;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.GridView;
import android.widget.ImageView;

import com.finaonation.finao.R;

public class MultiVideoSelectActivity extends Activity {

	private ArrayList<String> imageUrls;
	private ImageAdapter imageAdapter;
	int uriListSize;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.ac_image_grid);
		uriListSize = getIntent().getIntExtra("size", 0);
		final String[] columns = { MediaStore.Video.Media.DATA };
		CursorLoader loader = new CursorLoader(this,
				MediaStore.Video.Media.EXTERNAL_CONTENT_URI, columns, null,
				null, null);
		Cursor cursor = loader.loadInBackground();
		this.imageUrls = new ArrayList<String>();

		for (int i = 0; i < cursor.getCount(); i++) {
			cursor.moveToPosition(i);
			int dataColumnIndex = cursor
					.getColumnIndexOrThrow(MediaStore.Video.Thumbnails.DATA);
			imageUrls.add(cursor.getString(dataColumnIndex));
		}

		imageAdapter = new ImageAdapter(this, imageUrls);

		GridView gridView = (GridView) findViewById(R.id.gridview);
		gridView.setAdapter(imageAdapter);
	}

	@Override
	protected void onStop() {
		super.onStop();
	}

	public void btnChoosePhotosClick(View v) {

		ArrayList<String> selectedItems = imageAdapter.getCheckedItems();

		if (uriListSize == 0) {
			if (selectedItems.size() > 1) {
				showAlert("Please select only 1 Video", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);

				finish();
			}
		} else if (uriListSize == 1) {
			if (selectedItems.size() > 1) {
				showAlert("Please select only 1 image", "Alert");
			} else {
				Intent returnIntent = new Intent();
				returnIntent.putExtra("result", selectedItems);
				setResult(RESULT_OK, returnIntent);
				finish();
			}
		}
	}

	public class ImageAdapter extends BaseAdapter {

		ArrayList<String> mList;
		LayoutInflater mInflater;
		Context mContext;
		SparseBooleanArray mSparseBooleanArray;
		ViewHolder holder = null;

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

		private class ViewHolder {
			CheckBox mCheckBox;
			ImageView imageView;
		}

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {

			if (convertView == null) {
				convertView = mInflater.inflate(R.layout.row_multiphoto_item,
						null);
				holder = new ViewHolder();
				holder.mCheckBox = (CheckBox) convertView
						.findViewById(R.id.checkBox1);
				holder.imageView = (ImageView) convertView
						.findViewById(R.id.imageView1);
				convertView.setTag(holder);
			}

			@SuppressWarnings("unused")
			Bitmap thumb = ThumbnailUtils.createVideoThumbnail(
					imageUrls.get(position),
					MediaStore.Images.Thumbnails.MINI_KIND);

			holder.imageView.setImageBitmap(ThumbnailUtils
					.createVideoThumbnail(imageUrls.get(position),
							MediaStore.Images.Thumbnails.MINI_KIND));
			holder.mCheckBox.setTag(position);
			holder.mCheckBox.setChecked(mSparseBooleanArray.get(position));
			holder.mCheckBox.setOnCheckedChangeListener(mCheckedChangeListener);

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

	public void showAlert(final String displayText, String title) {
		AlertDialog.Builder alertbox = new AlertDialog.Builder(
				MultiVideoSelectActivity.this);
		alertbox.setMessage(displayText);
		alertbox.setTitle(title);
		alertbox.setNeutralButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dlg, int button) {

			}
		});
		alertbox.show();
	}

}