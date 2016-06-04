package com.example.v3n0m.notes;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;


public class DatabaseHelper extends SQLiteOpenHelper {

    private static final String NAME = "notes.db";
    private static final int VERSION = 1;

    public static final String NOTES_TABLE = "notes";
    public static final String NOTE_ID = "_id";
    public static final String NOTE_TEXT = "text";
    public static final String NOTE_CREATED = "created";
    public static final String PRIORITY = "priority";
    public static final String NOTE_ALARM = "alarm";

    private static final String TABLE_CREATE =
            "CREATE TABLE " + NOTES_TABLE + " (" +
                    NOTE_ID + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    NOTE_TEXT + " TEXT, " +
                    PRIORITY + " INTEGER default 0, " +
                    NOTE_CREATED + " TEXT default CURRENT_TIMESTAMP, " +
                    NOTE_ALARM + " TEXT default 'None'"+
                    ")";

    public static final String[] COLUMNS = {NOTE_ID, NOTE_TEXT, PRIORITY, NOTE_CREATED, NOTE_ALARM};

    public DatabaseHelper(Context context){
        super(context, NAME, null, VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(TABLE_CREATE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXIST " + NAME);
        onCreate(db);
    }
}
