package com.example.v3n0m.notes;

import android.app.LoaderManager;
import android.content.CursorLoader;
import android.content.Intent;
import android.content.Loader;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.CursorAdapter;
import android.widget.ListView;
import android.widget.SimpleCursorAdapter;

public class MainActivity extends AppCompatActivity implements LoaderManager.LoaderCallbacks<Cursor> {

    private static final int OPEN_EDITOR_CODE = 999;
    private CursorAdapter adapter;
    private String sortOrder = "text";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // handle query to the database
        String[] columns = {DatabaseHelper.NOTE_TEXT};
        int[] to = {R.id.list_note_item};
        adapter = new SimpleCursorAdapter(this, R.layout.list_note, null, columns, to, 0);

        // send the data to the UI
        ListView list = (ListView) findViewById(android.R.id.list);
        list.setAdapter(adapter);

        //set listener for opening an existing nite
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                        @Override
                                        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                                            Intent intent = new Intent(MainActivity.this, Editor.class);
                                            Uri uri = Uri.parse(NotesContentProvider.CONTENT_URI + "/" + id);
                                            intent.putExtra(NotesContentProvider.CONTENT_ITEM_TYPE, uri);
                                            startActivityForResult(intent, OPEN_EDITOR_CODE);
                                        }
                                    }
        );


        getLoaderManager().initLoader(0, null, this);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        String term = "";
        switch (id) {
            case R.id.action_sort_by_date:
                term = DatabaseHelper.NOTE_CREATED;
                break;
            case R.id.action_sort_by_name:
                term = DatabaseHelper.NOTE_TEXT;
                break;
            case R.id.action_sort_by_priority:
                term = DatabaseHelper.PRIORITY;
                break;
        }


        if (sortOrder.contains(term + " DESC")) {
            sortOrder = term + " ASC";
        } else sortOrder = term + " DESC";
        getLoaderManager().restartLoader(0, null, this);

        return super.onOptionsItemSelected(item);
    }

    @Override
    public Loader<Cursor> onCreateLoader(int id, Bundle args) {
        return new CursorLoader(this, NotesContentProvider.CONTENT_URI, null, null, null, sortOrder);
    }

    @Override
    public void onLoadFinished(Loader<Cursor> loader, Cursor data) {
        adapter.swapCursor(data);
    }

    @Override
    public void onLoaderReset(Loader<Cursor> loader) {
        adapter.swapCursor(null);
    }


    //add new note
    public void openEditor(View view) {
        Intent intent = new Intent(this, Editor.class);
        startActivityForResult(intent, OPEN_EDITOR_CODE);
    }

    @Override
    //refresh list after adding a note
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == OPEN_EDITOR_CODE && resultCode == RESULT_OK) {
            getLoaderManager().restartLoader(0, null, this);
        }
    }
}
