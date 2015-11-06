package com.finaonation.addfinao;

import java.util.ArrayList;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.beanclasses.FinaosListPojo;
import com.finaonation.beanclasses.GettingFinaosList;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.profile.CreateNewFinao;
import com.finaonation.utils.FinaoCustomProgress;

public class SelectFinaoToPost extends Activity {
	ListView Sel_lv;
	ProgressDialog pDialog;
	FinaoListAdapter finaoListAdapter;
	String _UserID, Find_id = "null";
	SharedPreferences Finao_Preferences;
	ArrayList<String> imageList;
	ArrayList<FinaosListPojo> Finao_List_Data = new ArrayList<FinaosListPojo>();
	TextView Header;
	String headerToken;

	@SuppressWarnings("deprecation")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.selectfinaotopost);
		Sel_lv = (ListView) findViewById(R.id.selectfinaotopostlvid);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		_UserID = Finao_Preferences.getString("User_ID", "");
		imageList = getIntent().getStringArrayListExtra("list");

		Header = (TextView) findViewById(R.id.header);

		Sel_lv.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int pos,
					long arg3) {
				FinaosListPojo flp = Finao_List_Data.get(pos);
				Find_id = flp.getF_FinaoId();
				nextClicked(null);

			}
		});

	}

	@Override
	protected void onResume() {
		super.onResume();
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		pDialog = new ProgressDialog(this);
		new FinaolistAsyrcTask(headerToken).execute(headerToken);
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			exitByBackKey();

			return true;
		}
		return super.onKeyDown(keyCode, event);
	}

	@SuppressWarnings("unused")
	protected void exitByBackKey() {

		AlertDialog alertbox = new AlertDialog.Builder(this)
				.setMessage("Do you want to exit application?")
				.setPositiveButton("Yes",
						new DialogInterface.OnClickListener() {

							// do something when the button is clicked
							public void onClick(DialogInterface arg0, int arg1) {
								System.exit(0);
							}
						})
				.setNegativeButton("No", new DialogInterface.OnClickListener() {

					// do something when the button is clicked
					public void onClick(DialogInterface arg0, int arg1) {
					}
				}).show();

	}

	public void backClicked(View view) {
		//finish();
		exitByBackKey();
	}

	public void Create_finao(View v) {
		Intent i = new Intent(getApplicationContext(), CreateNewFinao.class);
		startActivity(i);
	}

	public void nextClicked(View v) {
		if (Find_id.equalsIgnoreCase("null")) {
			Toast.makeText(getApplicationContext(),
					"Please Select the Finao..", Toast.LENGTH_SHORT).show();
		} else {
			Intent intent = new Intent(getApplicationContext(),
					AddFinaoPage.class);
			intent.putExtra("finaoid", Find_id);
			startActivity(intent);
		}
	}

	private class FinaolistAsyrcTask extends AsyncTask<String, Void, Integer> {
		String thisHeaderToken;
		String Loading_Msg = "Loading FINAOs";
		GettingFinaosList gs;

		public FinaolistAsyrcTask(String headerToken) {
			thisHeaderToken = headerToken;
			Log.i("FinaolistAsyrcTask ", thisHeaderToken);
			gs = new GettingFinaosList(thisHeaderToken);
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(SelectFinaoToPost.this,
					"FINAO Nation", Loading_Msg);
		}

		protected Integer doInBackground(String... params) {
			headerToken = params[0];
			Finao_List_Data = gs.GetFinaosList(_UserID, "user", "0",
					headerToken);
			return 0;
		}

		protected void onPostExecute(Integer result) {
			super.onPostExecute(result);
			if (null != pDialog && pDialog.isShowing()) {
				pDialog.dismiss();
			}
			int no = Finao_List_Data.size();
			if (no != 0) {
				finaoListAdapter = new FinaoListAdapter(SelectFinaoToPost.this,
						Finao_List_Data);
				Sel_lv.setAdapter(finaoListAdapter);
			} else {
				Sel_lv.setAdapter(null);
				Header.setVisibility(View.VISIBLE);

				// Toast.makeText(SelectFinaoToPost.this, "No FINAO Items",
				// Toast.LENGTH_SHORT).show();
			}
		}
	}

	public class FinaoListAdapter extends BaseAdapter {
		Context con;
		ArrayList<FinaosListPojo> Adapter_List = new ArrayList<FinaosListPojo>();
		ViewHolder holder = null;

		public FinaoListAdapter(Activity mActivity,
				ArrayList<FinaosListPojo> finao_List_Data) {
			con = mActivity;
			Adapter_List = finao_List_Data;
		}

		@Override
		public int getCount() {
			return Adapter_List.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		private class ViewHolder {
			TextView Finao_Title;
			ImageView Finao_status;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) con
					.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.finaos_inflater, null);
				holder = new ViewHolder();
				holder.Finao_Title = (TextView) convertView
						.findViewById(R.id.Finao_Title);
				holder.Finao_status = (ImageView) convertView
						.findViewById(R.id.imageView2);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			final FinaosListPojo flp = Adapter_List.get(position);
			holder.Finao_Title.setText(flp.getF_FinaoTitle());

			if (flp.getF_Finao_Status().equalsIgnoreCase("1")) {
				holder.Finao_status.setImageResource(R.drawable.btnaheadhover);
			} else if (flp.getF_Finao_Status().equalsIgnoreCase("0")) {
				holder.Finao_status
						.setImageResource(R.drawable.btnontrackhover);
			} else if (flp.getF_Finao_Status().equalsIgnoreCase("2")) {
				holder.Finao_status.setImageResource(R.drawable.btnbehindhover);
			}
			return convertView;
		}
	}

	public void Settingsclick(View v) {
		Intent in = new Intent(SelectFinaoToPost.this, SettingActivity.class);
		overridePendingTransition(R.anim.slide_in, R.anim.slide_out);
		startActivity(in);
	}
}
