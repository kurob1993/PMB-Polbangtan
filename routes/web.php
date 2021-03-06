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

Route::get('/', 'WelcomeController@index')->name('frontend.index');
Route::get('jadwal-pmb', 'WelcomeController@jadwal')->name('frontend.jadwal');
Route::get('informasi-pendaftaran', 'WelcomeController@informasi')->name('frontend.informasi');
Route::get('brosur-pmb', 'WelcomeController@brosur')->name('frontend.brosur');
Route::get('dokumen-pmb', 'WelcomeController@dokumen')->name('frontend.dokumen');
Route::resource('post', 'PostController');

Route::get('/register-success', function () {
    return view('auth.success');
});
Route::get('/aktifasi', 'WelcomeController@aktifasi')->name('aktifasi');
Route::get('/aktifasi-resend', 'WelcomeController@aktifasi_resend')->name('aktifasi.resend');
Route::post('/aktifasi-send', 'WelcomeController@aktifasi_send')->name('aktifasi.send');
Route::get('/viewfile', 'ViewFileController@index')->name('viewfile');

Auth::routes();

Route::group(['middleware' => 'auth'], function ()
{
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::put('/profile/{id}/update', 'HomeController@update')->name('profile.update');

    Route::group(['middleware' => 'roles', 'roles' => 'administrator'], function ()
    {
		Route::get('admin', 'Admin\AdminController@index');
		Route::resource('admin/roles', 'Admin\RolesController');
		Route::resource('admin/permissions', 'Admin\PermissionsController');
		Route::resource('admin/users', 'Admin\UsersController');
		Route::resource('admin/pages', 'Admin\PagesController');
		Route::resource('admin/activitylogs', 'Admin\ActivityLogsController')->only([
		    'index', 'show', 'destroy'
		]);
		Route::resource('admin/settings', 'Admin\SettingsController');
		Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
		Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
		
		Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
	});

    Route::group(['middleware' => 'roles', 'roles' => ['siswa', 'admin_pusat']], function ()
    {
        Route::resource('siswa', 'SiswaController');
        Route::resource('pegawai', 'PegawaiController');
    });

    Route::group(['middleware' => 'roles', 'roles' => ['siswa', 'admin_pusat', 'operator']], function ()
    {
        Route::resource('pendaftaran', 'PendaftaranController');
    });

    Route::group(['middleware' => 'roles', 'roles' => 'siswa'], function ()
    {
		Route::get('pemilihan-jalur', 'PendaftaranController@jalur')->name('pilih-jalur');
		Route::post('jalur/simpan-jalur', 'PendaftaranController@store_jalur')->name('store-jalur');
		Route::get('jurusan/pemilihan-jurusan', 'PendaftaranController@jurusan')->name('pilih-jurusan');
		Route::post('jurusan/simpan-jurusan', 'PendaftaranController@store_jurusan')->name('store-jurusan');
		Route::resource('prestasi', 'PrestasiController');
		Route::get('resume', 'PendaftaranController@resume')->name('pendaftaran.resume');
        Route::get('siswa/kartu/cetak', 'SiswaController@kartu')->name('siswa.kartu');
	});

    Route::group(['middleware' => 'roles', 'roles' => 'admin_pusat'], function ()
    {
        Route::resource('verifikasi-dokumen', 'VerifikasiDokumenController');
        Route::resource('tes-wawancara', 'WawancaraController');
        Route::get('tes-wawancara/download/pdf', 'WawancaraController@pdf')->name('tes-wawancara.pdf');
        Route::get('tes-wawancara/download/xls', 'WawancaraController@xls')->name('tes-wawancara.xls');
        Route::resource('tes-kesehatan', 'TesKesehatanController');
        Route::resource('verifikasi-akhir', 'VerifikasiAkhirController');

        Route::resource('cms', 'ContentController');
		Route::resource('jadwal', 'JadwalController');
    });

    Route::group(['middleware' => 'roles', 'roles' => 'operator'], function ()
    {
        Route::resource('tes-tulis', 'TesTulisController');
        Route::get('tes-tulis/download/pdf', 'TesTulisController@pdf')->name('tes-tulis.pdf');
        Route::get('tes-tulis/download/xls', 'TesTulisController@xls')->name('tes-tulis.xls');
    });

    Route::group(['namespace' => 'Api', 'prefix' => 'api'], function () {
        Route::group(['prefix' => '/siswa'], function () {
            Route::get('/', 'SiswaController@index')->name('api.siswa');
        });
        Route::group(['prefix' => '/verifikasi-dokumen'], function () {
            Route::get('/', 'VerifikasiDokumenController@index')->name('api.verifikasi');
        });
        Route::group(['prefix' => '/tes-tulis'], function () {
            Route::get('/', 'TesTulisController@index')->name('api.tulis');
        });
        Route::group(['prefix' => '/tes-wawancara'], function () {
            Route::get('/', 'WawancaraController@index')->name('api.wawancara');
        });
        Route::group(['prefix' => '/tes-kesehatan'], function () {
            Route::get('/', 'TesKesehatanController@index')->name('api.kesehatan');
        });
    });
});