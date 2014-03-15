package com.android_helper.pushclient.app;

import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class SettingsActivity extends ActionBarActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        TextView tvSettingsAppVersion = (TextView)findViewById(R.id.tvSettingsAppVersion);
        tvSettingsAppVersion.setText(String.valueOf(getIntent().getIntExtra(Constants.PROPERTY_APP_VERSION, 0)));

        TextView tvSettingsRegId = (TextView)findViewById(R.id.tvSettingsRegId);
        tvSettingsRegId.setText(getIntent().getStringExtra(Constants.PROPERTY_REG_ID));

        Button btnClearRegId = (Button)findViewById(R.id.btnClearRegId);
        btnClearRegId.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });
    }

}
