package com.example.v3n0m.notes;

import android.content.ContentProvider;
import android.content.ContentValues;
import android.content.UriMatcher;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.net.Uri;

public class NotesContentProvider extends ContentProvider {

    private static final String AUTHORITY = "com.example.v3n0m.notes.notescontentprovider";
    private static final String BASEPATH = "notes";
    public static final Uri CONTENT_URI = Uri.parse("content://" + AUTHORITY + "/" + BASEPATH);
    public static final String CONTENT_ITEM_TYPE = "note";

    private static final int NOTES_ID = 2;

    private  static final UriMatcher uriMatcher = new UriMatcher(UriMatcher.NO_MATCH);
    static {
        uriMatcher.addURI(AUTHORITY,BASEPATH, 1);
        uriMatcher.addURI(AUTHORITY,BASEPATH + "/#", 2);
    }

   private SQLiteDatabase db;

    @Override
    public boolean onCreate() {
        DatabaseHelper helper = new DatabaseHelper(getContext());
        db = helper.getWritableDatabase();
        return true;
    }

    @Override
    public Cursor query(Uri uri, String[] projection, String selection, String[] selectionArgs, String sortOrder) {
        //if URI ends in ID add a where clause to the query
        //in order to return a single note
        if (uriMatcher.match(uri) ==  NOTES_ID){
            selection = DatabaseHelper.NOTE_ID + " = " + uri.getLastPathSegment();
        }
        return db.query(DatabaseHelper.NOTES_TABLE, DatabaseHelper.COLUMNS, selection, null ,null ,null, sortOrder);
    }

    @Override
    public String getType(Uri uri) {
        return null;
    }

    @Override
    public Uri insert(Uri uri, ContentValues values) {
        long id = db.insert(DatabaseHelper.NOTES_TABLE, null, values);
        return Uri.parse(BASEPATH + "/" + id);
    }

    @Override
    public int delete(Uri uri, String selection, String[] selectionArgs) {
        return db.delete(DatabaseHelper.NOTES_TABLE, selection, selectionArgs);
    }

    @Override
    public int update(Uri uri, ContentValues values, String selection, String[] selectionArgs) {
        return db.update(DatabaseHelper.NOTES_TABLE, values, selection, selectionArgs);
    }
}
