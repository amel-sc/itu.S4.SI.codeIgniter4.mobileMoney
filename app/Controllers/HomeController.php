<?php

namespace App\Controllers;

class HomeController extends BaseController {
    // home page
    public function index() {
        return view('home/index', [
            'title' => 'Home'
        ]);
    }
}