<?php

use App\Http\Requests\TestRequest;
use Illuminate\Http\Request;

Route::get('/', function (Request $r) {
    return $r->get('test');
});

Route::get('/form', function (TestRequest $r) {

//    private $mustHaveEnglishNumbers = ['phone_number'];
//    private $mustHaveFarsiNumbers = ['post_content'];

    return "phone_number=" . $r->get("phone_number") .
        "post_content=" . $r->get("post_content");
});
