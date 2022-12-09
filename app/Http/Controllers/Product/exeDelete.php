<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;    // Product.phpと連携

class exeDelete extends Controller
{
    /**
     * 商品情報を削除
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
     * ↓の@paramには引数、@returnには返り値を書きます。
     * 
     * @param $id
     * @return redirect
     */
    public function __invoke($id) {

        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // 削除対象の商品idがない場合
        if (empty($id)) {
            // configフォルダのmessageファイル内にある、message1を取得
            // '該当する商品がありません'というエラーメッセージを表示
            \Session::flash('err_msg', config('message.message1'));

            // '/resources/views/product/lineup.blade.php'にリダイレクトします。
            // route()の中身を変えることで、遷移先を指定できます。
            return redirect(route('product.lineup'));
        }

        // トランザクションの開始
        // DB内容を変更する際は、トランザクションを使いましょう！
        // なんらかのエラーが起きた時、一部のデータは成功で更新、一部のデータは失敗でそのままということを防いでくれます。
        \DB::beginTransaction();

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {
            // Product.phpのdeleteProductにアクセス
            // 選択したidの商品を削除したいので、引数に$id(ルートパラメータ)を渡します。
            $product_instance->deleteProduct($id);

            // DBへの変更内容を確定します
            \DB::commit();

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行

            // DBへの変更内容を無かったことにします
            \DB::rollback();

            // 現場では、自作のエラーページを返したりします
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // configフォルダのmessageファイル内にある、message4を取得
        // '商品を削除しました'というメッセージを表示
        \Session::flash('err_msg', config('message.message4'));

        // '/resources/views/product/lineup.blade.php'にリダイレクトします。
        // route()の中身を変えることで、遷移先を指定できます。
        return redirect(route('product.lineup'));

    }
}
