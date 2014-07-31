<?php namespace Teman\Cck\Controllers;


use Illuminate\Support\Facades\View;

abstract class CckController extends \Controller{


    protected $model;


    public function __construct(){

    }


    public function index(){

        return View::make('cck::index');

    }


}