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

// new add property UI

/*Route::get('/addTest',function(){
	return view('portal.property.add-edit-property',["pageTitle"=>"Property Add","pageHeading" => "Add Property"]);
})->name("add-edit-property1");*/

/* Country Master Routes Starts Here: 2017-10-21 */
Route::get('/countries/', 'CountriesController@index')->name('countries.index');
Route::get('/countries/add', 'CountriesController@addedit')->name('countries.add');
Route::post('/countries/insert', 'CountriesController@savedata')->name('countries.insert');
Route::get('/countries/edit/{id}', 'CountriesController@addedit')->name('countries.edit');
Route::post('/countries/update/{id}', 'CountriesController@savedata')->name('countries.update');
Route::get('/countries/delete/{id}', 'CountriesController@delete')->name('countries.delete');
Route::post('/countries/search', 'CountriesController@search')->name('countries.search');
/* Country Master Routes Ends Here: 2017-10-21 */

/* Country Master Routes For Searching States Starts: 2018-07-22 */
Route::post('/countries/search/state', 'CountriesController@searchstates')->name('countries.searchstates');
/* Country Master Routes For Searching States Ends: 2018-07-22 */

/* State Master Routes Starts Here: 2017-10-21 */
Route::get('/states/{country_code}', 'StatesController@index')->name('states.index');
Route::get('/states/add/{country_code}', 'StatesController@addedit')->name('states.add');
Route::post('/states/insert', 'StatesController@savedata')->name('states.insert');
Route::get('/states/edit/{country_code}/{id}', 'StatesController@addedit')->name('states.edit');
Route::post('/states/update/{id}', 'StatesController@savedata')->name('states.update');
Route::get('/states/delete/{country_code}/{id}', 'StatesController@delete')->name('states.delete');
Route::post('/states/search', 'StatesController@search')->name('states.search');
/* State Master Routes Ends Here: 2017-10-21 */

/* State Master Routes For Searching Cities Starts: 2018-07-22 */
Route::post('/states/search/city', 'StatesController@searchcities')->name('states.searchcities');
/* State Master Routes For Searching Cities Ends: 2018-07-22 */

/* City Master Routes Starts Here: 2017-10-21 */
Route::get('/cities/{state_id}', 'CitiesController@index')->name('cities.index');
Route::get('/cities/add/{state_id}', 'CitiesController@addedit')->name('cities.add');
Route::post('/cities/insert', 'CitiesController@savedata')->name('cities.insert');
Route::get('/cities/edit/{state_id}/{id}', 'CitiesController@addedit')->name('cities.edit');
Route::post('/cities/update/{id}', 'CitiesController@savedata')->name('cities.update');
Route::get('/cities/delete/{state_id}/{id}', 'CitiesController@delete')->name('cities.delete');
Route::post('/cities/search', 'CitiesController@search')->name('cities.search');
/* City Master Routes Ends Here: 2017-10-21 */

/* Roles Master Routes Starts Here: 2017-10-22 */
Route::get('/roles/', 'RolesController@index')->name('roles.index');
Route::get('/roles/add/', 'RolesController@addedit')->name('roles.add');
Route::post('/roles/insert', 'RolesController@savedata')->name('roles.insert');
Route::get('/roles/edit/{id}', 'RolesController@addedit')->name('roles.edit');
Route::post('/roles/update/{id}', 'RolesController@savedata')->name('roles.update');
Route::get('/roles/delete/{id}', 'RolesController@delete')->name('roles.delete');
Route::post('/roles/search', 'RolesController@search')->name('roles.search');
/* Roles Master Routes Ends Here: 2017-10-22 */

/* Backend Users Master Routes Starts Here: 2017-10-22 */
Route::get('/admin_users/', 'BackendUsersController@index')->name('backendusers.index');
Route::get('/admin_users/add/', 'BackendUsersController@addedit')->name('backendusers.add');
Route::post('/admin_users/insert', 'BackendUsersController@savedata')->name('backendusers.insert');
Route::get('/admin_users/edit/{id}', 'BackendUsersController@addedit')->name('backendusers.edit');
Route::post('/admin_users/update/{id}', 'BackendUsersController@savedata')->name('backendusers.update');
Route::get('/admin_users/delete/{id}', 'BackendUsersController@delete')->name('backendusers.delete');
Route::post('/admin_users/search', 'BackendUsersController@search')->name('backendusers.search');
/* Backend Users Master Routes Ends Here: 2017-10-22 */

/* Property Management Routes Starts Here: 2018-07-08 */
Route::get('/property/', 'PropertyController@index')->name('property.index');
Route::get('/property/add/', 'PropertyController@addedit')->name('property.add');
Route::post('/property/insert', 'PropertyController@savedata')->name('property.insert');
Route::get('/property/edit/{id}', 'PropertyController@addedit')->name('property.edit');
Route::post('/property/update/{id}', 'PropertyController@savedata')->name('property.update');
Route::get('/property/delete/{id}', 'PropertyController@delete')->name('property.delete');
Route::post('/property/search', 'PropertyController@search')->name('property.search');
Route::post('/property/deletepropertyimage', 'PropertyController@deletepropertyimage')->name('property.deletepropertyimage');
/* Property Management Routes Ends Here: 2018-07-08 */

/* Property Type Master Routes Starts Here: 2018-08-22 */
Route::get('/property_type_master/', 'PropertyTypeMasterController@index')->name('propertytypemaster.index');
Route::get('/property_type_master/add/', 'PropertyTypeMasterController@addedit')->name('propertytypemaster.add');
Route::post('/property_type_master/insert', 'PropertyTypeMasterController@savedata')->name('propertytypemaster.insert');
Route::get('/property_type_master/edit/{id}', 'PropertyTypeMasterController@addedit')->name('propertytypemaster.edit');
Route::post('/property_type_master/update/{id}', 'PropertyTypeMasterController@savedata')->name('propertytypemaster.update');
Route::get('/property_type_master/delete/{id}', 'PropertyTypeMasterController@delete')->name('propertytypemaster.delete');
Route::post('/property_type_master/search', 'PropertyTypeMasterController@search')->name('propertytypemaster.search');
/* Property Type Master Routes Ends Here: 2018-08-22 */