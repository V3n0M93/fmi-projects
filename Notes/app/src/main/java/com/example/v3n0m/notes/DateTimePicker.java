package com.example.v3n0m.notes;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.TimePicker;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

public class DateTimePicker extends AppCompatActivity {

    private DatePicker datePicker;
    private TimePicker timePicker;
    private SimpleDateFormat dateFormatter;
    private String dateTime;
    private Calendar date;
    private Button button;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_date_time_picker);

        datePicker = (DatePicker) findViewById(R.id.date_picker);
        timePicker = (TimePicker) findViewById(R.id.time_picker);
        button = (Button) findViewById(R.id.date_time_set);

        dateFormatter = new SimpleDateFormat("yyyy.MM.dd HH:mm");

        //If date in database is set then use that date
        //If it isn't then use current date
        Intent intent = getIntent();
        dateTime = intent.getStringExtra(Editor.CHOSEN_DATE);
        date = Calendar.getInstance();
        if (dateTime.equals("None")) {
            date.setTime(new Date(System.currentTimeMillis()));
        } else {
            try {
                date.setTime(dateFormatter.parse(dateTime));
            } catch (ParseException e) {
                e.printStackTrace();
            }
        }

        datePicker.updateDate(date.get(Calendar.YEAR), date.get(Calendar.MONTH), date.get(Calendar.DAY_OF_MONTH));
        timePicker.setCurrentHour(date.get(Calendar.HOUR));
        timePicker.setCurrentMinute(date.get(Calendar.MINUTE));




    }


    @Override

    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_date_time_picker, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        if (id == android.R.id.home){
            setResult(RESULT_CANCELED);
            finish();
        }
        return true;
    }


    public void setTime(View view) {
        date.set(datePicker.getYear(), datePicker.getMonth(), datePicker.getDayOfMonth(),
                timePicker.getCurrentHour(), timePicker.getCurrentMinute());
        dateTime = dateFormatter.format(date.getTime());

        Intent result = new Intent();
        result.putExtra(Editor.CHOSEN_DATE, dateTime);
        setResult(RESULT_OK, result);
        finish();

    }

    @Override
    public void onBackPressed() {
        setResult(RESULT_CANCELED);
        finish();
    }
}
