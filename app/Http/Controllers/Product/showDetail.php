<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;    // Product.phpと連携

class showDetail extends Controller
{
    /**
     * 商品情報詳細画面を表示
     *  
     * functionの名前は自由です。が、機能が分かる名前にしましょう！
     * 今回はコード規約に沿ってロワーキャメルとします
     * 
     * このコメントの部分はPHPDoc(ぴーえいちぴーどっく)と言います。
     * 現場でも使うので、どういう機能なのかを書く習慣をつけましょう！
     * 「/**」と打ってEnterキー押すと、自動で作ってくれます。
     * 自分で見返すときはもちろん、いつか来る改修案件の時、すごく助かります。
     * 
     * 引数に指定している$idは変数として定義されてないのになんで使えるの？と思ったそこのあなた。
     * これはルートパラメータと言います。分からなければ、ググりましょう！
     * 
     * ↓の@paramには引数、@returnには返り値を書きます。
     *
     * @param [int] $id
     * @return view
     */
    public function __invoke($id) {

        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {
            // 箱  ： $product_listという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Product.phpのproductDetailにアクセス
            // 選択した商品のidを持つ情報のみ表示したいので、引数に$id(ルートパラメータ)を渡します
            $product = $product_instance->productDetail($id);

            // もし、該当商品がない場合
            if (is_null($product)) {
                // configフォルダのmessageファイル内にある、message1を取得
                // '該当商品がありません'というエラーメッセージを表示
                \Session::flash('err_msg', config('message.message1'));

                // 一覧画面へリダイレクトさせる
                return redirect(route('product.lineup'));
            }

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行

            // 現場では、自作のエラーページを返します
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // '/resources/views/product/detail.blade.php'に渡したい変数(showDetailで定義したもの)を、compact()関数を用いて渡す。
        // このとき変数に$は付けない
        return view('product.detail', compact('product'));

    }
}
