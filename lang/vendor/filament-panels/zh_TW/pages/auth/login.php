<?php

return [

    'title' => '登入',

    'heading' => '登入帳號',

    'actions' => [

        'register' => [
            'before' => '或',
            'label' => '註冊新帳號',
        ],

    ],

    'form' => [

        'email' => [
            'label' => '電子郵件',
        ],

        'password' => [
            'label' => '密碼',
        ],

        'remember' => [
            'label' => '記住我',
        ],

        'actions' => [

            'authenticate' => [
                'label' => '登入',
            ],

        ],

    ],

    'messages' => [

        'failed' => '所提供的帳號密碼與資料庫中的記錄不相符。',

    ],

    'notifications' => [

        'throttled' => [
            'title' => '嘗試登入次數過多',
            'body' => '請在 :seconds 秒後重試。',
        ],

    ],

];
