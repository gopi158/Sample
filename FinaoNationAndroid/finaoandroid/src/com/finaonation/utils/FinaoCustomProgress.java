package com.finaonation.utils;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.view.WindowManager;

import com.finaonation.finao.R;

public final class FinaoCustomProgress extends AlertDialog {

	public FinaoCustomProgress(Context context) {
		super(context);
	}

	public FinaoCustomProgress(Context context, int theme) {
		super(context, theme);
	}

	public static ProgressDialog show(Context context, CharSequence title,
			CharSequence message) {
		return show(context, title, message, false);
	}

	public static ProgressDialog show(Context context, CharSequence title,
			CharSequence message, boolean indeterminate) {
		return show(context, title, message, indeterminate, false, null);
	}

	public static ProgressDialog show(Context context, CharSequence title,
			CharSequence message, boolean indeterminate, boolean cancelable) {
		return show(context, title, message, indeterminate, cancelable, null);
	}

	public static ProgressDialog show(Context context, CharSequence title,
			CharSequence message, boolean indeterminate, boolean cancelable,
			OnCancelListener cancelListener) {
		ProgressDialog dialog = new ProgressDialog(context, R.style.DialogTheme);
		dialog.setTitle(title);
		dialog.setMessage(message);
		dialog.setIndeterminate(indeterminate);
		dialog.setCancelable(cancelable);
		dialog.setOnCancelListener(cancelListener);
		dialog.setIcon(R.drawable.logo_finao);
		dialog.getWindow().clearFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);
		dialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
		dialog.show();
		return dialog;
	}
}
