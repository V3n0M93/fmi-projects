package com.example.v3n0m.notes;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.support.v4.app.NotificationCompat;

public class AlarmReceiver extends BroadcastReceiver {
    @Override
    public void onReceive(Context context, Intent intent) {
        String noteID = intent.getStringExtra("noteID");

        Uri uri = Uri.parse(NotesContentProvider.CONTENT_URI + "/" + noteID);

        NotificationCompat.Builder notification = new NotificationCompat.Builder(context)
                .setSmallIcon(R.drawable.notes)
                .setContentTitle("Click to see Note.")
                .setTicker("Note alarm.");

        Intent intentToPass = new Intent(context, Editor.class);
        intentToPass.putExtra(NotesContentProvider.CONTENT_ITEM_TYPE, uri);
        PendingIntent pendingIntent = PendingIntent.getActivity(context, 0, intentToPass, PendingIntent.FLAG_UPDATE_CURRENT);

        notification.setContentIntent(pendingIntent);
        notification.setDefaults(NotificationCompat.DEFAULT_LIGHTS);
        notification.setAutoCancel(true);

        NotificationManager notificationManager = (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);

        notificationManager.notify(1, notification.build());

    }
}