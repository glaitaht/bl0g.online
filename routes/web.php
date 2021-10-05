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
Route::get('/', 'App\Http\Controllers\PostsController@index'); //get ile url'den bilgi alıyor, eğer hiçbir bilgi yoksa postcontroller'in index fonksiyonunu çalıştırıyor.

Route::get('/category/{id}', 'App\Http\Controllers\PagesController@category');//kullanıcı bi kategorideki postları görmek isterse bu url'ye yönleniyor
Route::get('/categories', 'App\Http\Controllers\PagesController@categories');//adminin kategorilerin hepsini görebilmesini sağlayan rota
Route::post('/catadd', 'App\Http\Controllers\PagesController@catadd');//admin kategori ekledi, bilgiler taşınıyor
Route::post('/catedt/{id}', 'App\Http\Controllers\PagesController@catedt');//admin kategoriyi düzenledi, bilgiler taşınıyor
Route::post('/catdel/{id}', 'App\Http\Controllers\PagesController@catdel');//admin kategoriyi sildi, bilgiler taşınıyor

Route::post('/search', 'App\Http\Controllers\PagesController@searcher');//kullanıcı sitede arama yapınca bu rota çalıştı
Route::get('/searched', 'App\Http\Controllers\PagesController@searched');//admin sitede yapılan aramaları kontrol edince bu rota çalıştı

Route::post('/commented', 'App\Http\Controllers\PagesController@commenter');//kullanıcı yorum yapınca çalışacak rota
Route::get('/comments', 'App\Http\Controllers\PagesController@comments');//adminin yorumları görebileceği sayfa
Route::post('/comacc/{id}', 'App\Http\Controllers\PagesController@comacc');//yapılan yorumu onaylama
Route::post('/comdel/{id}', 'App\Http\Controllers\PagesController@comdel');//yapılan yorumu silme

Route::get('/aboutus', 'App\Http\Controllers\PagesController@aboutus');//adminler hakkındaki bilgiyi gösterecek rota
Route::post('/sended', 'App\Http\Controllers\PagesController@sended');//adminler sayfasındaki bize ulaş butonuyla mesaj gönderten rota

Route::get('/adminPanel', 'App\Http\Controllers\PagesController@adminControl');//admini ilk girişinde karşılayan panel
Route::get('/postDetails', 'App\Http\Controllers\PagesController@postDetails');//adminin bütün yazıları görmesi ve işlemesi için gerekli rota
Route::get('/deleteIt/{id}', 'App\Http\Controllers\PagesController@deleter');//admin postu siliyor 
Route::get('/newOne', 'App\Http\Controllers\PagesController@create');//admin yeni yazı oluşturuyor
Route::get('/newCategory', 'App\Http\Controllers\PagesController@newCategory');//admin yeni kategori oluşturuyor
Route::get('/deleteCategory/{id}', 'App\Http\Controllers\PagesController@deleteCategory');//admin kategori siliyor
Route::get('/editCategory/{id}', 'App\Http\Controllers\PagesController@editCategory');//admin kategori düzenliyor
Route::get('/users', 'App\Http\Controllers\PagesController@users');//admin yeni kullanıcıları görüyor
Route::get('/allOfUsers', 'App\Http\Controllers\PagesController@allOfUsers');//admin bütün kullanıcıları görüyor
Route::post('/admacc/{id}', 'App\Http\Controllers\PagesController@admacc'); //admin kullanıcılara admin yetkisi veriyor
Route::post('/admdel/{id}', 'App\Http\Controllers\PagesController@admdel');// admin başka adminin yetkisini alıyor
Route::post('/usacc/{id}', 'App\Http\Controllers\PagesController@usacc');//admin yeni kullanıcıyı onaylıyor
Route::post('/usdel/{id}', 'App\Http\Controllers\PagesController@usdel');//admin yeni kullanıcıyı siliyor
Route::get('/aboutMe', 'App\Http\Controllers\PagesController@aboutMe');//admin yalnızca kendisine ait bilgileri değiştiriyor
Route::post('/abMeEd/{id}', 'App\Http\Controllers\PagesController@abMeEd');//admin bilgilerini değiştirdi, bilgiler taşınıyor
Route::get('/contacts', 'App\Http\Controllers\PagesController@contacts');//admin siteye gelen mesajlara bakıyor
Route::get('/contact/{id}', 'App\Http\Controllers\PagesController@contact');//admin mesaja tıkladıysa mesaj okundu oluyor
Route::post('/reply/{id}', 'App\Http\Controllers\PagesController@reply');//admin mesaja cevap veriyor
Route::get('/messagesForMe', 'App\Http\Controllers\PagesController@messagesForMe');//kullanıcı siteye yazdığı mesajlara cevap var mı diye bakıyor
Route::get('/changePass', 'App\Http\Controllers\PagesController@changePass');//kullanıcı şifresini değiştiriyor
Route::post('/changeIt/{id}', 'App\Http\Controllers\PagesController@changeIt');//kullanıcı şifresini değiştirdi, bilgiler taşınıyor

Auth::routes(); //laravelin kendi üye sistemini kullandık

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); 

Route::resource('posts','App\Http\Controllers\PostsController'); //posts rotası için posts contolleri'ı atadık
