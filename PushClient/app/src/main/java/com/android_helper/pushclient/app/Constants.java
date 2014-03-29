package com.android_helper.pushclient.app;

public class Constants {
    public static final String REG_ID_IS_EMPTY = "-";
    public static final String EXTRA_MESSAGE = "message";
    public static final String PROPERTY_REG_ID = "registration_id";
    public static final String PROPERTY_APP_VERSION = "appVersion";
    public static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    public static final String USER_NAME = "userName";
    public static final String USER_EMAIL = "some.email@gmail.com";

    static final String REGISTER_URL = "http://projects.android-helper.com.ua/gcmClient/register.php";

    /**
     * Substitute you own sender ID here. This is the project number you got
     * from the API Console, as described in "Getting Started."
     */
    static final String GOOGLE_SENDER_ID = "767680602912";
}
