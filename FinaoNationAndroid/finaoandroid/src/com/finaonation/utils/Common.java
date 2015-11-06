
package com.finaonation.utils;

import android.content.Context;
import android.content.Intent;

public final class Common {

    public static final String SENDER_ID = "671974724262";

    public static final String TAG = "HighPointAndroid";

    public static final String DISPLAY_MESSAGE_ACTION = "com.highpointmobile.utils.DISPLAY_MESSAGE";

    public static final String EXTRA_MESSAGE = "message";

    public static void displayMessage(Context context, String message) {
        Intent intent = new Intent(DISPLAY_MESSAGE_ACTION);
        intent.putExtra(EXTRA_MESSAGE, message);
        context.sendBroadcast(intent);
    }
}
