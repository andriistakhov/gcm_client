package com.android_helper.pushclient.app;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class SettingsActivity extends ActionBarActivity implements View.OnClickListener {

    private static final String LOG_TAG = "settings_activity";

    TextView tvSettingsAppVersion;
    TextView tvSettingsRegId;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        tvSettingsAppVersion = (TextView) findViewById(R.id.tvSettingsAppVersion);
        tvSettingsAppVersion.setText(String.valueOf(getIntent().getIntExtra(Constants.PROPERTY_APP_VERSION, 0)));

        tvSettingsRegId = (TextView) findViewById(R.id.tvSettingsRegId);
        tvSettingsRegId.setText(getIntent().getStringExtra(Constants.PROPERTY_REG_ID));

        Button btnClearRegId = (Button) findViewById(R.id.btnClearRegId);
        btnClearRegId.setOnClickListener(this);

    }

    @Override
    public void onClick (View v){
        final SharedPreferences prefs = getSharedPreferences(MainActivity.class.getSimpleName(),
                Context.MODE_PRIVATE);
        Log.i(LOG_TAG, "Registration ID clearing");
        SharedPreferences.Editor editor = prefs.edit();
        editor.remove(Constants.PROPERTY_REG_ID);
        editor.remove(Constants.PROPERTY_APP_VERSION);
        editor.commit();

        tvSettingsAppVersion.setText("?");
        tvSettingsRegId.setText(Constants.REG_ID_IS_EMPTY);

    }

}
