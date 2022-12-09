<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;    // Product.phpと連携
use App\Models\Company;    // Company.phpと連携

class showEdit extends Controller
{
    /**
     * 商品情報編集画面を表示
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
     * 
     * @param $id
     * @return view
     */
    public function __invoke($id) {

        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // 箱  : $pcompany_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Companyクラス(Company.php)のインスタンス
        $company_instance = new Company();

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {
            // 箱  ： $product_listという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Product.phpのproductDetailにアクセス
            // 選択した商品のidを持つ情報のみ表示したいので、引数に$id(ルートパラメータ)を渡します
            $product = $product_instance->productDetail($id);
            
            // 箱  ： $company_dataという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Company.phpのcompanyInfoにアクセス
            $company_list = $company_instance->companyInfo();

            // 該当idを持つ商品が見つからなかった場合
            if (is_null($product)) {
                // configフォルダのmessageファイル内にある、message1を取得
                // '該当する商品がありません'というエラーメッセージを表示
                \Session::flash('err_msg', config('message.message1'));

                // '/resources/views/product/lineup.blade.php'にリダイレクトします。
                // route()の中身を変えることで、遷移先を指定できます。
                return redirect(route('product.lineup'));
            }

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行
            // 現場では、自作のエラーページを返したりします
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // '/resources/views/product/edit.blade.php'に渡したい変数(showEditで定義したもの)を、compact()関数を用いて渡す。
        // このとき変数に$は付けない
        return view('product.edit', compact('product', 'company_list'));

    }
}
