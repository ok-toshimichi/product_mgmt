<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;   // Requestの受け取り、受け渡しに必要
use App\Models\Product;    // Product.phpと連携

class exeStore extends Controller
{
    /**
     * 商品情報の登録
     * 
     * functionの名前は自由です。が、機能が分かる名前にしましょう！
     * 今回はコード規約に沿ってロワーキャメルとします
     * 
     * このコメントの部分はPHPDoc(ぴーえいちぴーどっく)と言います。
     * 現場でも使うので、どういう機能なのかを書く習慣をつけましょう！
     * 「/**」と打ってEnterキー押すと、自動で作ってくれます。
     * 自分で見返すときはもちろん、いつか来る改修案件の時、すごく助かります。
     * 
     * ProductRequestクラス(useしていますね！)で受け取ったデータを$requestとして使います
     * ↓の@paramには引数、@returnには返り値を書きます。
     *
     * @param ProductRequest $request
     * @return redirect
     */
    public function __invoke(ProductRequest $request) {

        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // 箱  ： $registerproductdata_instanceいう名前の変数(function同様に、中身が分かるものがよい)
        // 中身: registerProductDataクラス(registerProductData.php)のインスタンス
        $registerproductdata_instance = app()->make('App\Http\Controllers\Product\registerProductData');

        // 箱  ： $register_dataいう名前の変数(function同様に、中身が分かるものがよい)
        // 中身: $registerproductdata_instanceに$requestを渡してあげる。渡った$requestをregisterProductData.php側で加工する。
        $register_data = $registerproductdata_instance($request);


        // トランザクションの開始
        // DB内容を変更する際は、トランザクションを使いましょう！
        // なんらかのエラーが起きた時、一部のデータは成功で更新、一部のデータは失敗でそのままということを防いでくれます。
        \DB::beginTransaction();

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {
            // Product.phpのcreateProductにアクセス
            // 欲しいデータを揃えた$insert_dataを使いたいので、引数として渡します。
            $product_instance->createProduct($register_data);

            // DBへの変更内容を確定します
            \DB::commit();

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行

            // DBへの変更内容を無かったことにします
            \DB::rollback();

            // 現場では、自作のエラーページを返します
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // configフォルダのmessageファイル内にある、message2を取得
        // '商品を登録しました！'というメッセージを表示
        \Session::flash('err_msg', config('message.message2'));

        // '/resources/views/product/lineup.blade.php'にリダイレクトします。
        // route()の中身を変えることで、遷移先を指定できます。
        return redirect(route('product.lineup'));

    }
}
