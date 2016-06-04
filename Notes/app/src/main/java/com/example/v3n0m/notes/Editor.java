package com.example.v3n0m.notes;

import android.content.ContentValues;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.RatingBar;
import android.widget.TextView;

public class Editor extends AppCompatActivity {

    public static final int REQUEST_CODE = 23655;
    public static final String CHOSEN_DATE = "Chosen Date";
    private String action;
    private EditText textEditor;
    private String oldText;
    private RatingBar priorityEditor;
    private float oldPriority;
    private TextView alarmDisplay;
    private String oldAlarm = "None";
    private String noteFilter;
    private String dateTime;
    private String noteID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_editor);

        textEditor = (EditText) findViewById(R.id.editText);
        priorityEditor = (RatingBar) findViewById(R.id.ratingBar);
        alarmDisplay = (TextView) findViewById(R.id.alarmDisplay);

        Intent intent = getIntent();
        Uri uri = intent.getParcelableExtra(NotesContentProvider.CONTENT_ITEM_TYPE);

        if (uri == null) {
            //change title if selected to add new note
            action = Intent.ACTION_INSERT;
            setTitle("Add new note");
        } else {
            //handle editing of an old note
            action = Intent.ACTION_EDIT;
            noteID = uri.getLastPathSegment();
            Log.d("debug", noteID);
            noteFilter = DatabaseHelper.NOTE_ID + " = " + noteID;

            //select the db row that is being edited
            Cursor cursor = getContentResolver().query(uri, DatabaseHelper.COLUMNS, noteFilter, null, null);
            cursor.moveToFirst();
            //TODO add other fields
            oldText = cursor.getString(cursor.getColumnIndex(DatabaseHelper.NOTE_TEXT));
            textEditor.setText(oldText);
            textEditor.requestFocus();

            oldPriority = cursor.getFloat(cursor.getColumnIndex(DatabaseHelper.PRIORITY));
            priorityEditor.setRating(oldPriority);


            oldAlarm = cursor.getString(cursor.getColumnIndex(DatabaseHelper.NOTE_ALARM));

            cursor.close();
        }

        dateTime = oldAlarm;
        alarmDisplay.setText("Alarm time: " + oldAlarm);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if (action.equals(Intent.ACTION_EDIT)) {

            // Inflate the menu; this adds items to the action bar if it is present.
            getMenuInflater().inflate(R.menu.menu_editor, menu);
        }
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        switch (id) {
            case android.R.id.home:
                saveNote();
                break;
            case R.id.action_delete_note:
                deleteNote();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    private void saveNote() {
        //save note
        String text = textEditor.getText().toString();
        float priority = priorityEditor.getRating();

        //handle adding new notes or editing existing one
        switch (action) {
            case Intent.ACTION_INSERT:
                //handle adding a new note
                if (text.length() == 0) {
                    setResult(RESULT_CANCELED);
                } else {
                    insertNoteToDatabase(text, priority, dateTime);
                }
                break;
            case Intent.ACTION_EDIT:
                //handle editing a note
                if (oldText.equals(text) && oldPriority == priority && oldAlarm.equals(dateTime)) {
                    setResult(RESULT_CANCELED);
                } else {
                    updateNote(text, priority, dateTime);
                }
        }
        finish();
    }

    private void deleteNote() {
        if (!oldAlarm.equals("None")){

            Intent intent = new Intent(this, AlarmService.class);
            intent.putExtra("noteID", noteID);
            intent.setAction(AlarmService.CANCEL);
            startService(intent);

        }
        getContentResolver().delete(NotesContentProvider.CONTENT_URI, noteFilter, null);

        setResult(RESULT_OK);

        finish();
    }

    private void insertNoteToDatabase(String noteText, float priority, String alarm) {
        ContentValues values = new ContentValues();
        values.put(DatabaseHelper.NOTE_TEXT, noteText);
        values.put(DatabaseHelper.PRIORITY, priority);
        values.put(DatabaseHelper.NOTE_ALARM, alarm);
        //add insertion for other data
        Uri temp = getContentResolver().insert(NotesContentProvider.CONTENT_URI, values);
        String newNoteID = temp.getLastPathSegment();
        if (!dateTime.equals("None")){

            Intent intent = new Intent(this, AlarmService.class);
            intent.putExtra("noteID", newNoteID);
            intent.setAction(AlarmService.CREATE);
            startService(intent);

        }
        setResult(RESULT_OK);
    }

    private void updateNote(String noteText, float priority, String alarm) {
        ContentValues values = new ContentValues();
        values.put(DatabaseHelper.NOTE_TEXT, noteText);
        values.put(DatabaseHelper.PRIORITY, priority);
        values.put(DatabaseHelper.NOTE_ALARM, alarm);
        getContentResolver().update(NotesContentProvider.CONTENT_URI, values, noteFilter, null);

        Intent intent = new Intent(this, AlarmService.class);
        intent.putExtra("noteID", noteID);
        if (!alarm.equals(oldAlarm)){

            if (alarm.equals("None")){
                intent.setAction(AlarmService.CANCEL);
            }
            else if (oldAlarm.equals("None")){

                intent.setAction(AlarmService.CREATE);
            }
            else {
                Log.d("Alarm Debug", "Update from Editor");
                intent.setAction(AlarmService.UPDATE);
            }
            startService(intent);
        }

        setResult(RESULT_OK);

    }

    @Override
    public void onBackPressed() {
        //save note when returning
        saveNote();
    }

    public void setAlarm(View view) {
        Intent intent = new Intent(this, DateTimePicker.class);
        intent.putExtra(CHOSEN_DATE, dateTime);
        startActivityForResult(intent, REQUEST_CODE);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == REQUEST_CODE && resultCode == RESULT_OK){

                dateTime = data.getExtras().getString(CHOSEN_DATE);
            alarmDisplay.setText("Alarm time: " + dateTime);

            }}

    public void removeAlarm(View view) {
        dateTime = "None";
        alarmDisplay.setText("Alarm time: " + dateTime);

    }
}


