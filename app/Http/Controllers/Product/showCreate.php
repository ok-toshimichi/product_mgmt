<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Company;    // Company.phpと連携

class showCreate extends Controller
{
    /**
     * 商品情報登録画面を表示
     * 
     * functionの名前は自由です。が、機能が分かる名前にしましょう！
     * 今回はコード規約に沿ってロワーキャメルとします
     * 
     * このコメントの部分はPHPDoc(ぴーえいちぴーどっく)と言います。
     * 現場でも使うので、どういう機能なのかを書く習慣をつけましょう！
     * 「/**」と打ってEnterキー押すと、自動で作ってくれます。
     * 自分で見返すときはもちろん、いつか来る改修案件の時、すごく助かります。
     * 
     * ↓の@returnには返り値を書きます。
     * 
     * @return view
     */
    public function __invoke() {

        // 箱  : $pcompany_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Companyクラス(Company.php)のインスタンス
        $company_instance = new Company();

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {
            // 箱  ： $selectItemsという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Company.phpのcompanyInfoにアクセス
            $selectItems = $company_instance->companyInfo();

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行

            // 現場では、自作のエラーページを返します
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // '/resources/views/product/form.blade.php'に渡したい変数(showCreateで定義したもの)を、compact()関数を用いて渡す。
        // このとき変数に$は付けない
        return view('product.form', compact('selectItems'));

    }
}
