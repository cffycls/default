<?php

use think\facade\Route;

Route::group('v1', function () {
    Route::rest([
        'create' => ['POST', '', 'v1/user/save'],
        'update' => ['PUT', '', 'v1/user/update'],
        'delete' => ['DELETE', '', 'v1/user/delete'],
        'select' => ['GET', '', 'v1/user/select'],
    ]);
});

