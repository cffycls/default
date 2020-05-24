<?php

namespace App\Http\Controllers;


use App\Model\Rest;

class RestController extends Controller
{
    //查询所有
    public function index()
    {
        return Rest::all();
    }
}
