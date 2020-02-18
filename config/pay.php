<?php

return [
    'alipay' => [
        'app_id'         => '2016101900722651',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAi8jMZNq6JwBr3uct7ely9ghA44DxnlhQfJxgZ0Bqx9++R2Qvnvg4XYsx5NOerKRcoLm0OqOS5nZguDar1mwNKvFn9Sv6sKVSoDo0p7U6pZNgxoe/rdKwaibFgFl11GIhSj05QQ8EUVqZxJo+6GzDNr6ZE91GHHlmV4x0w99uKhQ8JN/FYIjrxGvzEAuybrQ/xou8SyScFlyNU0GAKtg/8hMkJBMDRjyVRhNnWssUV/EqbTrF2dQRNAuBaMPTZVcoKGfNLUflW8OBXIeyma4Qzw228s95BZJZ34stAQ/XwGrpbHZoTCOTaGf6L3HNl87jyMvW89UTrd+yyuOM5GomvwIDAQAB',
        'private_key'    => 'MIIEogIBAAKCAQEAi8jMZNq6JwBr3uct7ely9ghA44DxnlhQfJxgZ0Bqx9++R2Qvnvg4XYsx5NOerKRcoLm0OqOS5nZguDar1mwNKvFn9Sv6sKVSoDo0p7U6pZNgxoe/rdKwaibFgFl11GIhSj05QQ8EUVqZxJo+6GzDNr6ZE91GHHlmV4x0w99uKhQ8JN/FYIjrxGvzEAuybrQ/xou8SyScFlyNU0GAKtg/8hMkJBMDRjyVRhNnWssUV/EqbTrF2dQRNAuBaMPTZVcoKGfNLUflW8OBXIeyma4Qzw228s95BZJZ34stAQ/XwGrpbHZoTCOTaGf6L3HNl87jyMvW89UTrd+yyuOM5GomvwIDAQABAoIBAB3u5+YI+Kf1bSQUeT9jKF0LM2oEaLkxzDqC+hniL3uRrBt5lsECAn/1mL+ZmXb602MPoUqVUJXNb7TC8FVAWimB/HMB8fL11BW/oRrwshhW0PhyhVdhsKlqmAx+G79ZLCvLpIEMCC6rqhXxudrnv33vnrQkRClAzeudhjuTkvGrgvuuT+bXKHlm18bvFPtWqU7X9bY99O9wY3lfNXVhfHu3J1mp4DeSDqLhFGSMW/FAF3yEvy7euJlIWsOwS7YrCbsSyaEynpP09cn1TKiEWuq+b2LDMnMHy4/hyv6vHRMK84Vp+qNy1UxDQ9Uonlohu0JjnfubWSwl4EceK3mA/AECgYEA/r4r/ttyOi6gcX+r74E7MnH8otblqCp8592B7OKJz6uiNRYA3oZIQ6VFvah/va08DeXTRbkW+WsSGW4ovnxjOQBRx9vou7L1TKV14CZXcsROBqLz8DHrJXzrka/JwEM4azgnvGvvuTehWJ55bB8utozWS9CrQy5HSfcDaN+BOQECgYEAjHlk8ZXHSHfIM36qCsEwcH/p99AwTT4Ll2sej7ucg6l/p0dA6q3j7y4t9E+FhQsq3VRcTkNKJSyXaZVYuvipzY3KamAkifarE90jST3yC2W/r7TU1gUxPq3mOLIY5NkY1dRUgferr02foRWTu8n7Gl7SHKUgm0d3M8zKKs+Zn78CgYA7UdNy5G0ECWmJJH7IJeLAC3UWAk62SzaM07L2k4Yd2szJ6dbH+qMHRYwo7vzYEWgDoHoDKWelKv6q91D7koGUe3OPw7C9TJ38fCcnzCXe7sFwoC+HxkgIkb9VTIcBg2W26fuuz7+h9MdYmIaT2+sHzWH1g6Dt4u/s1F1x5WH1AQKBgCf7za2t8kFARu3RWdkh0AXVguUUjwsNZAM/bD2BKzWWo00bzPB/emdz/4SQtfJ+kT7aakOkh5A5NwfIiK7/ZGWrvDe3Ee9rFJrc0NRiG2j/FyaOFB6u76tlmCf/GXLaEGWcwEkWE/ob4BnbqGdFQIHrB2c74SIRn25RFiJFYPbFAoGAWgnZ9eVlEMSWAQow8bHcvHjPggRL0ea5W3NeDd2VEu6W6+0uT+FUJCqvqITQmvOJvOBCtiXj2Ffxcn8kxofnTGcZxzWXgxgey3x0+jdB6HfKZoap0ybcxBGkmhE8s1r9nqvI6n6ARovFAHzhqBykPf7uYK9eXssFusQz1fyaaMg=',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
