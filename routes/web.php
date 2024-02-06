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

// use App\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use DB;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/home');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //master
    Route::resource('master/unit', 'master\UnitController');
    Route::resource('master/satuan', 'master\SatuanController');
    Route::resource('master/uraian', 'master\UraianController');
    Route::resource('master/pegawai', 'master\PegawaiController');
    Route::get('master/import', function() {
        return view('import');
    });
    Route::post('toexcel/all', 'HomeController@toexcel');
    // Route::get('master/import', function() {
    //     return view('import');
    // });
    //transaksi
    Route::post('transaksi/alkes/import', 'transaksi\AlkesController@import');
    Route::post('transaksi/alkes/toexcel', 'transaksi\AlkesController@toexcel');
    Route::resource('transaksi/alkes', 'transaksi\AlkesController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/atk/import', 'transaksi\AtkController@import');
    Route::post('transaksi/atk/toexcel', 'transaksi\AtkController@toexcel');
    Route::resource('transaksi/atk', 'transaksi\AtkController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/bhp/import', 'transaksi\BhpController@import');
    Route::post('transaksi/bhp/toexcel', 'transaksi\BhpController@toexcel');
    Route::resource('transaksi/bhp', 'transaksi\BhpController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/bhp_cov_19/import', 'transaksi\Bhp_cov_19Controller@import');
    Route::post('transaksi/bhp_cov_19/toexcel', 'transaksi\Bhp_cov_19Controller@toexcel');
    Route::resource('transaksi/bhp_cov_19', 'transaksi\Bhp_cov_19Controller')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/cetak/import', 'transaksi\CetakController@import');
    Route::post('transaksi/cetak/toexcel', 'transaksi\CetakController@toexcel');
    Route::resource('transaksi/cetak', 'transaksi\CetakController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/obat/import', 'transaksi\ObatController@import');
    Route::post('transaksi/obat/toexcel', 'transaksi\ObatController@toexcel');
    Route::post('transaksi/obat/periodesebelum', 'transaksi\ObatController@periodesebelum');
    Route::resource('transaksi/obat', 'transaksi\ObatController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/rumah_tangga/import', 'transaksi\Rumah_tanggaController@import');
    Route::post('transaksi/rumah_tangga/toexcel', 'transaksi\Rumah_tanggaController@toexcel');
    Route::resource('transaksi/rumah_tangga', 'transaksi\Rumah_tanggaController')->only([
        'index', 'store', 'destroy'
    ]);
    Route::post('transaksi/sarpras/import', 'transaksi\SarprasController@import');
    Route::post('transaksi/sarpras/toexcel', 'transaksi\SarprasController@toexcel');
    Route::resource('transaksi/sarpras', 'transaksi\SarprasController')->only([
        'index', 'store', 'destroy'
    ]);
    
     Route::post('gudang/alkes/import', 'gudang\GudangAlkesController@import');
    Route::post('gudang/alkes/toexcel', 'gudang\GudangAlkesController@toexcel');
    Route::resource('gudang/alkes', 'gudang\GudangAlkesController');

    Route::post('gudang/atk/import', 'gudang\GudangATKController@import');
    Route::post('gudang/atk/toexcel', 'gudang\GudangATKController@toexcel');
    Route::resource('gudang/atk', 'gudang\GudangATKController');

    Route::post('gudang/bhp/import', 'gudang\GudangBhpController@import');
    Route::post('gudang/bhp/toexcel', 'gudang\GudangBhpController@toexcel');
    Route::resource('gudang/bhp', 'gudang\GudangBhpController');

    Route::post('gudang/cetak/import', 'gudang\GudangCetakController@import');
    Route::post('gudang/cetak/toexcel', 'gudang\GudangCetakController@toexcel');
    Route::resource('gudang/cetak', 'gudang\GudangCetakController');

    Route::post('gudang/rumahtangga/import', 'gudang\GudangRumahTanggaController@import');
    Route::post('gudang/rumahtangga/toexcel', 'gudang\GudangRumahTanggaController@toexcel');
    Route::resource('gudang/rumahtangga', 'gudang\GudangRumahTanggaController');

    Route::post('gudang/obat/import', 'gudang\GudangObatController@import');
    Route::post('gudang/obat/toexcel', 'gudang\GudangObatController@toexcel');
    Route::resource('gudang/obat', 'gudang\GudangObatController');

    Route::post('gudang/sarpras/import', 'gudang\GudangSarprasController@import');
    Route::post('gudang/sarpras/toexcel', 'gudang\GudangSarprasController@toexcel');
    Route::resource('gudang/sarpras', 'gudang\GudangSarprasController');
    
    
    
    
    
    Route::get('remun', 'transaksi\RemunController@index');
    
    Route::get('remunbaru', 'transaksi\RemunBaruController@index');

    Route::get('remun/target', 'transaksi\RemunController@target');
    Route::post('remun/target', 'transaksi\RemunController@savetarget');

    Route::get('remun/ibadah', 'transaksi\RemunController@ibadah');
    Route::post('remun/ibadah', 'transaksi\RemunController@saveibadah');
    Route::get('remun/ibadah/print', 'transaksi\RemunController@ibadah_print');

    Route::get('remun/rater', 'transaksi\RemunController@rater');
    Route::post('remun/rater', 'transaksi\RemunController@saverater');

    Route::get('remun/des', 'transaksi\RemunController@des');
    Route::post('remun/des', 'transaksi\RemunController@savedes');

    Route::get('remun/tiga60', 'transaksi\RemunController@tiga60');
    Route::post('remun/tiga60', 'transaksi\RemunController@savetiga60');
    Route::get('/grading', 'transaksi\RemunController@grading');
    
    Route::get('transaksi/gizi', function() {
        return view('import');
    });
    
    Route::get('remun/tiga60/gendef', 'transaksi\RemunController@gendef360');
    Route::get('remun/target/gen', 'transaksi\RemunController@gentarget');
});
// Route::get('pwsgen', function(Request $request) {
//     // $res = $request->get('pws');
//     $res = User::whereNull('comment')->get();
//     foreach ($res as $key => $item) {
//         User::where('id', $item->id)->update(['password' => Hash::make($item->password), 'comment' => 0]);
//     }
//     // DB::select("UPDATE users u
//     // SET u.`password` = ". Hash::make("u.`password`") . ", u.`comment` = 0
//     // WHERE u.`comment` is null");
//     return "Ok";
// });
// Route::resource('resep', 'ResepController');