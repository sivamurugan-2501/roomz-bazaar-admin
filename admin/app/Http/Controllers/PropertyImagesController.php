<?php

namespace App\Http\Controllers;
use App\PropertyImages;
use Illuminate\Http\Request;
use Session;
use DB;
class PropertyImagesController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
    }
}
