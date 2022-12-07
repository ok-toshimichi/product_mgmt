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

/**
 * シングルアクションコントローラーの読み込み
 * ProductContoller 1つに全ての処理を書いていると、「どこに書いたっけ？この処理・・・」という経験あるかと思います。
 * アクション毎にコントローラーを分けておけば、その心配もなくなり、ファットコントローラー(記述量が多く、改修しにくいコントローラーのこと)も防げます。
 */
use App\Http\Controllers\Product\showList;
use App\Http\Controllers\Product\exeSearch;
use App\Http\Controllers\Product\showCreate;
use App\Http\Controllers\Product\showDetail;
use App\Http\Controllers\Product\showEdit;
use App\Http\Controllers\Product\exeStore;
use App\Http\Controllers\Product\exeUpdate;
use App\Http\Controllers\Product\exeDelete;

// 最初のページはログイン完了しました！の画面(ただし、その画面はユーザー認証ありきなので、ログイン画面に飛びます)
Route::get('/', 'HomeController@index')->name('root');

/**
 * ユーザー認証
 */
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/**
 * 商品関連のルートをまとめる
 * prefixを使うことで、urlがproductで始まるものをまとめて管理できます。
 * middlewareを使うことで、ログインしているかどうかの判定を行うことができます。
 * Route::groupとすれば、そのグループ内に書いてあるルート全てに、↑のprefixとmiddlewareを適用できます。
 */
Route::group(['prefix' => 'product', 'middleware' => 'auth'], function (){
    // 一覧画面の表示
    Route::get('lineup', Product\showList::class)->name('product.lineup');

    // 商品検索
    Route::get('search', Product\exeSearch::class)->name('product.search');

    // 登録画面の表示
    Route::get('create', Product\showCreate::class)->name('product.create');

    // 詳細画面の表示
    Route::get('{id}', Product\showDetail::class)->name('product.detail');

    // 編集画面の表示
    Route::get('edit/{id}', Product\showEdit::class)->name('product.edit');

    // 商品情報を登録
    Route::post('store', Product\exeStore::class)->name('product.store');

    // 商品情報を更新
    Route::post('update', Product\exeUpdate::class)->name('product.update');

    // 商品情報を削除
    Route::post('delete/{id}', Product\exeDelete::class)->name('product.delete');

});
