<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('/home');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('/schedule', 'HomeController@schedule');

Route::get('/homex', 'HomeController@mikrotik_addsecreate');
Route::get('/homey', 'HomeController@mikrotik_disablesecreate');
Route::get('/homez', 'HomeController@mikrotik_status');
Route::get('/homexy', 'HomeController@wa');
Route::get('/xendit', 'HomeController@xendit');
Route::get('/halo', 'PagesController@halo');

Route::get('/customer','CustomerController@index');
Route::get('/customer/create','CustomerController@create');
Route::get('/customer/search','CustomerController@search');
Route::post('/customer','CustomerController@store');
Route::post('/customer/{id}/file','CustomerController@uploadFile');
Route::post('/customer/wa','CustomerController@wa_customer');
Route::patch('/customer/update/status','CustomerController@update_status');
Route::get('/customer/{id}','CustomerController@show');
Route::get('/customer/{id}/edit','CustomerController@edit');
Route::patch('/customer/{id}','CustomerController@update');
Route::delete('/customer/{id}','CustomerController@destroy');



Route::get('/ticket','TicketController@index');
Route::get('/myticket','TicketController@myticket');
Route::get('/uncloseticket','TicketController@uncloseticket');

Route::get('/ticket/{id}/create','TicketController@create');
Route::get('/ticket/{id}/edit','TicketController@edit');

Route::get('/ticket/{id}','TicketController@show');
Route::get('/ticket/view/{id}','TicketController@view');
Route::get('/ticket/print/{id}','TicketController@print_ticket');


Route::post('/ticket','TicketController@store');
Route::post('/ticket/search','TicketController@search');
Route::patch('/ticket/{id}/editticket','TicketController@editticket');
Route::patch('/ticket/{id}/assign','TicketController@updateassign');
Route::post('/ticket/wa_ticket','TicketController@wa_ticket');


Route::post('/ticketdetail','TicketdetailController@store');
Route::get('/invoice/bulk','InvoiceController@invoicehandle');

// Route::get('/invoice/make','InvoiceController@index');
Route::get('/invoice','InvoiceController@index');
Route::get('/invoice/{id}','InvoiceController@show');
Route::get('/invoice/{id}/create','InvoiceController@create');
Route::post('/invoice','InvoiceController@store');
Route::get('/invoice/{id}/delete/{cid}','InvoiceController@destroy');


Route::post('/suminvoice/createinvoice','InvoiceController@createinvoice');
Route::get('/suminvoice','SuminvoiceController@index');
Route::get('/suminvoice/transaction','SuminvoiceController@transaction');
Route::post('/suminvoice/transaction','SuminvoiceController@searchtransaction');
Route::get('/suminvoice/mytransaction','SuminvoiceController@mytransaction');
Route::post('/suminvoice/mytransaction','SuminvoiceController@searchmytransaction');
Route::post('/suminvoice/verify/{id}','SuminvoiceController@verify');


Route::get('/suminvoice/{id}','SuminvoiceController@show');

Route::get('/suminvoice/{id}/print','SuminvoiceController@print');
Route::get('/suminvoice/{id}/viewinvoice','SuminvoiceController@print');
Route::get('/suminvoice/{id}/dotmatrix','SuminvoiceController@dotmatrix');
Route::post('/suminvoice','SuminvoiceController@store');
Route::post('/suminvoice/search','SuminvoiceController@search');
Route::post('/suminvoice/find','SuminvoiceController@searchinv');
Route::patch('/suminvoice/{id}','SuminvoiceController@update');
Route::patch('/suminvoice/{id}/faktur','SuminvoiceController@faktur');
Route::delete('/suminvoice/{id}','SuminvoiceController@destroy');
//Route::post('/suminvoice/xendit',function (){})->middleware(['xenditauth']);
Route::post('/xenditcallback/invoice','XenditCallbackController@update')->middleware(['xenditauth']);

//User
Route::get('/user','UserController@index');
Route::get('/user/create','UserController@create');
Route::post('/user','UserController@store');
Route::get('/user/{id}/edit','UserController@edit');
Route::patch('/user/{id}','UserController@update');
Route::get('/user/{id}/myprofile','UserController@myprofile');

//Plan

Route::get('/plan','PlanController@index');
Route::get('/plan/create','PlanController@create');
Route::get('/plan/{id}/edit','PlanController@edit');
Route::get('/plan/{id}','PlanController@null');
Route::post('/plan','PlanController@store');
Route::delete('/plan/{id}','PlanController@destroy');
Route::patch('/plan/{id}','PlanController@update');

Route::get('/distpoint','DistpointController@index');
Route::get('/distpoint/create','DistpointController@create');
Route::post('/distpoint','DistpointController@store');
Route::get('/distpoint/{id}/edit','DistpointController@edit');
Route::patch('/distpoint/{id}','DistpointController@update');
Route::get('/distpoint/{id}','DistpointController@show');
Route::delete('/distpoint/{id}','DistpointController@destroy');

Route::get('bank','BankController@index');
Route::get('/bank/create','BankController@create');
Route::get('/bank/{id}/edit','BankController@edit');
Route::get('/bank/{id}','BankController@null');
Route::post('/bank','BankController@store');
Route::delete('/bank/{id}','BankController@destroy');
Route::patch('/bank/{id}','BankController@update');

Route::get('device','DeviceController@null');
Route::get('/device/{id}','DeviceController@index');
Route::post('/device','DeviceController@store');
Route::patch('/device/{id}','DeviceController@update');
Route::delete('/device/{cust}/{id}','DeviceController@destroy');

Route::get('accounting','accountingController@index');
// Route::get('/accounting/{id}','accountingController@index');
Route::post('/accounting','accountingController@store');
Route::patch('/accounting/{id}','accountingController@update');

Route::delete('/accounting/{cust}/{id}','accountingController@destroy');

Route::get('akun', 'AkunController@index');
Route::get('jurnal', 'jurnalController@jurnal');
Route::post('jurnal', 'jurnalController@jurnal');
Route::get('jurnal/bukubesar', 'jurnalController@bukubesar');
Route::post('jurnal/bukubesar', 'jurnalController@bukubesar');
Route::get('jurnal/report', 'jurnalController@index');
Route::delete('/jurnal/{id}','jurnalController@destroy');

Route::get('jurnal/ccreate', 'jurnalController@ccreate');
Route::get('jurnal/generaldel/{id}', 'jurnalController@generaldel');
Route::post('/jurnal/store','jurnalController@store');
Route::post('/jurnal/cupdate','jurnalController@cupdate');
Route::post('/jurnal/trxstore','jurnalController@trxstore');
Route::get('/jurnal/trxcreate','jurnalController@trxcreate');
Route::post('/jurnal/trxupdate','jurnalController@trxupdate');
Route::get('/jurnal/closed','jurnalController@closed');
Route::post('/jurnal/closed','jurnalController@closestore');
Route::post('/jurnal/closeupdate','jurnalController@closeupdate');
Route::get('/jurnal/jpenutup','jurnalController@jpenutup');
Route::post('/jurnal/penutup','jurnalController@penutup');


Route::post('/jurnal/cstore','jurnalController@cstore');
Route::get('/jurnal/cstore','jurnalController@ccreate');
Route::post('/jurnal/create','jurnalController@create');
Route::get('/jurnal/create','jurnalController@index');





Route::post('/file','FileController@store');
Route::delete('/file/{id}','FileController@destroy');

//Site

Route::get('/xx', function(){
    $config = array();
    $config['center'] = 'auto';
    $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';

    app('map')->initialize($config);

    // set up the marker ready for positioning
    // once we know the users location
    $marker = array();
    app('map')->add_marker($marker);

    $map = app('map')->create_map();
    echo "<html><head><script type=text/javascript>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";
});



Route::get('/maps','SiteController@maps');
Route::get('/site','SiteController@index');
Route::get('/site/create','SiteController@create');
Route::get('/site/{id}/edit','SiteController@edit');
Route::get('/site/{id}','SiteController@null');
Route::post('/site','siteController@store');
Route::delete('/site/{id}','SiteController@destroy');
Route::patch('/site/{id}','siteController@update');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
