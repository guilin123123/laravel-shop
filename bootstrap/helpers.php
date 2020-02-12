<?php

function test_helper() {
    return 'OK';
}

// 将请求的路由名称转换为CSS类名称
function route_class()
{
    return str_replace('.','-',\Illuminate\Support\Facades\Route::currentRouteName());
}
