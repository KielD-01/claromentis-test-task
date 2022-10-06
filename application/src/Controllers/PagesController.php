<?php

namespace KielD01\ClaromentisTestTask\Controllers;

class PagesController extends Controller
{
    public function index() {
        return $this->render('home');
    }

    public function upload() {
        return $this->render('home');
    }
}