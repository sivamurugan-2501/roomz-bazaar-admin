<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about','HomeController@about');

Route::get('/logins', function () {
    return view('login');
})->name('admin_login');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/online-property','GeneralInfoController@addForm')->name('add-edit-property');
Route::post('addProperty','GeneralInfoController@addInsert')->name('add-edit-property-handler');
Route::post('addProperty/{id}','GeneralInfoController@addInsert1');
Route::post('addProperty/section3/{id}','GeneralInfoController@addInsert2');
Route::post('addProperty/section4/{id}','GeneralInfoController@addInsert3');

/*Edit property*/
Route::post('/addProperty/update/{id}','GeneralInfoController@addUpdate');
Route::post('/addProperty/update2/{id}','GeneralInfoController@addUpdate2');
Route::post('/addProperty/update3/{id}','GeneralInfoController@addUpdate3');
Route::post('/addProperty/update4/{id}','GeneralInfoController@addUpdate4');

Route::post('/add_insert','GeneralInfoController@addInsert');

Route::get('list_view/{id}','GeneralInfoController@listView');

Route::get('/edit/{id}','GeneralInfoController@editUpdate');

Route::post('/update/add_update/{id}','GeneralInfoController@addUpdate');


Route::get('delete/{id}','GeneralInfoController@addDelete');


// below route  just display list of proerty types
Route::get("/master/property_type", function(){
 return view("portal.master.property-type",["pageTitle"=>"Property Type","pageHeading" => "Property Type"]);
})->name("manage-property-type")->middleware("auth");


// below route will open same view/page with form to add new property type
Route::get("/master/property_type/mode/{mode}", function($mode = 0){
 return view("portal.master.property-type",["pageTitle"=>"Property Type","pageHeading" => "Property Type", "mode" => $mode]);
})->name("add-property-type")->middleware("auth");

// below route will open same view/page with form to edit selected property type
Route::get("/master/property_type/{id}", function($id=0){
 return view("portal.master.property-type",["pageTitle"=>"Property Type","pageHeading" => "Property Type","id"=>$id]);
})->name("update-property-type")->middleware("auth");

// below route will manage db operation of saving data, via post method
Route::post("/master/property-type/add",
	'MasterPropertyType_Controller@add'
)->name("add-property-type-do");

// below route will manage db operation of update and save data, via post method
Route::post("/master/property-type/update",
	'MasterPropertyType_Controller@update'
)->name("update-property-type-do");
