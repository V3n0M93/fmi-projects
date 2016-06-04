package com.example.v3n0m.notes;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

public class AlarmSetOnRestart extends BroadcastReceiver {
    public AlarmSetOnRestart() {
    }

    @Override
    public void onReceive(Context context, Intent intent) {
        // TODO: This method is called when the BroadcastReceiver is receiving
        // an Intent broadcast.

        Intent service = new Intent(context, AlarmService.class);
        service.setAction(AlarmService.RECREATE);
        context.startService(service);
    }
}


