package com.example.v3n0m.notes;

import android.app.AlarmManager;
import android.app.IntentService;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;

public class AlarmService extends IntentService {

    public static final String name = "Alarm Service";

    public static final String CREATE = "CREATE";
    public static final String CANCEL = "CANCEL";
    public static final String RECREATE = "RECREATE";
    public static final String UPDATE = "UPDATE";


    public AlarmService() {
        super(name);
    }

    @Override
    protected void onHandleIntent(Intent intent) {
        String action = intent.getAction();
        String noteID = intent.getStringExtra("noteID");

        switch (action) {
            case CREATE:
                updateAlarm(noteID, CREATE);
                break;
            case CANCEL:
                updateAlarm(noteID, CANCEL);
                break;
            case RECREATE:
                Cursor cursor = getContentResolver().query(NotesContentProvider.CONTENT_URI, DatabaseHelper.COLUMNS, null, null, null);
                cursor.moveToFirst();
                while (!cursor.isAfterLast()) {
                    noteID = String.valueOf(cursor.getInt(cursor.getColumnIndex(DatabaseHelper.NOTE_ID)));
                    String date = cursor.getString(cursor.getColumnIndex(DatabaseHelper.NOTE_ALARM));
                    if (!date.equals("None")) {
                        updateAlarm(noteID, CREATE);
                    }
                    cursor.moveToNext();
                }
                cursor.close();
                break;
            case UPDATE:
                updateAlarm(noteID, CANCEL);
                updateAlarm(noteID, CREATE);
                break;
        }
    }

    private void updateAlarm(String noteID, String action) {
        AlarmManager alarmManager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        Uri uri = Uri.parse(NotesContentProvider.CONTENT_URI + "/" + noteID);
        String noteFilter = DatabaseHelper.NOTE_ID + " = " + uri.getLastPathSegment();

        Cursor cursor = getContentResolver().query(uri, DatabaseHelper.COLUMNS, noteFilter, null, null);
        cursor.moveToFirst();
        Intent intent = new Intent(this, AlarmReceiver.class);


        intent.putExtra("noteID", cursor.getString(cursor.getColumnIndex(DatabaseHelper.NOTE_ID)));

        PendingIntent pendingIntent = PendingIntent.getBroadcast(this, 0, intent,
                PendingIntent.FLAG_UPDATE_CURRENT);


        if (action.equals(CREATE)) {
            String dateText = cursor.getString(cursor.getColumnIndex(DatabaseHelper.NOTE_ALARM));


            SimpleDateFormat dateFormatter = new SimpleDateFormat("yyyy.MM.dd HH:mm");
            Calendar date = Calendar.getInstance();
            try {
                date.setTime(dateFormatter.parse(dateText));
            } catch (ParseException e) {
                e.printStackTrace();
            }
            alarmManager.set(AlarmManager.RTC_WAKEUP, date.getTimeInMillis(), pendingIntent);


        } else {
            pendingIntent.cancel();
            alarmManager.cancel(pendingIntent);
        }
        cursor.close();
    }

}
