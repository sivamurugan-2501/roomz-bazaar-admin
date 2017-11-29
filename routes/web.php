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

Route::get('/manage-property/list','GeneralInfoController@listProperty')->name('list-property');
Route::get('/manage-property/{id?}/{step?}','GeneralInfoController@addForm')->name('add-edit-property');

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

/*--------- Below Routes are for master moddules ----------------------------------------------------------------------*/

		#Master Property Route ---------------------------------------------------
		// below route  just display list of proerty types
		Route::get("/master/property_type", function(){
		 return view("portal.master.property-type",["pageTitle"=>"Property Type","pageHeading" => "Property Type"]);
		})->name("manage-property-type")->middleware("auth");


		// below route will open view/page with form to add new property type
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
		#Master Property Type Route ends here -----------------------------------------


		#Master Amenities ---------------------------------------------------

		// Route - view/page with form to add new property type
		Route::get("/master/amenities/","Amenities_Controller@show")->name("master_amenities")->middleware('auth');
		Route::get("/master/amenities/{mode}/","Amenities_Controller@show")->name("add-master-amenities")->middleware('auth');
	    Route::post("/master/amenities/add/","Amenities_Controller@add")->name("add-master-amenities-do")->middleware('auth');
	    Route::get("/master/amenities/id/{id}/","Amenities_Controller@update_form")->name("update-master-amenities")->middleware('auth');
	    Route::post("/master/amenities/update/","Amenities_Controller@update")->name("update-master-amenities-do")->middleware('auth');

/*--------- End of Routes for master modules ------------------------------------------------------------------------------*/

/* Country Master Routes Starts Here: 2017-10-21 */
Route::get('/countries/', 'CountriesController@index')->name('countries.index');
Route::get('/countries/add', 'CountriesController@addedit')->name('countries.add');
Route::post('/countries/insert', 'CountriesController@savedata')->name('countries.insert');
Route::get('/countries/edit/{id}', 'CountriesController@addedit')->name('countries.edit');
Route::post('/countries/update/{id}', 'CountriesController@savedata')->name('countries.update');
Route::get('/countries/delete/{id}', 'CountriesController@delete')->name('countries.delete');
/* Country Master Routes Ends Here: 2017-10-21 */

/* State Master Routes Starts Here: 2017-10-21 */
Route::get('/states/{country_code}', 'StatesController@index')->name('states.index');
Route::get('/states/add/{country_code}', 'StatesController@addedit')->name('states.add');
Route::post('/states/insert', 'StatesController@savedata')->name('states.insert');
Route::get('/states/edit/{country_code}/{id}', 'StatesController@addedit')->name('states.edit');
Route::post('/states/update/{id}', 'StatesController@savedata')->name('states.update');
Route::get('/states/delete/{country_code}/{id}', 'StatesController@delete')->name('states.delete');
/* State Master Routes Ends Here: 2017-10-21 */

/* City Master Routes Starts Here: 2017-10-21 */
Route::get('/cities/{state_id}', 'CitiesController@index')->name('cities.index');
Route::get('/cities/add/{state_id}', 'CitiesController@addedit')->name('cities.add');
Route::post('/cities/insert', 'CitiesController@savedata')->name('cities.insert');
Route::get('/cities/edit/{state_id}/{id}', 'CitiesController@addedit')->name('cities.edit');
Route::post('/cities/update/{id}', 'CitiesController@savedata')->name('cities.update');
Route::get('/cities/delete/{state_id}/{id}', 'CitiesController@delete')->name('cities.delete');

 // Added by Siva for AJAX request
Route::post('ajax/cities/{state_id}', 'CitiesController@ajaxCall')->name('cities.ajaxCall');

/* City Master Routes Ends Here: 2017-10-21 */

