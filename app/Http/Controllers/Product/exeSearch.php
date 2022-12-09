<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;    // Product.phpと連携
use App\Models\Company;    // Company.phpと連携

class exeSearch extends Controller
{
    /**
     * 商品一覧画面を表示
     * 
     * functionの名前は自由です。が、機能が分かる名前にしましょう！
     * 今回はコード規約に沿ってロワーキャメルとします
     * 
     * このコメントの部分はPHPDoc(ぴーえいちぴーどっく)と言います。
     * 現場でも使うので、どういう機能なのかを書く習慣をつけましょう！
     * 「/**」と打ってEnterキー押すと、自動で作ってくれます。
     * 自分で見返すときはもちろん、いつか来る改修案件の時、すごく助かります。
     * 
     * Requestクラス(useしていますね！)で受け取ったデータを$requestとして使います
     * 
     * ↓の@paramには引数を、@returnには返り値を書きます
     * 
     * @param Request $request    リクエスト($request)は、ブラウザからユーザーが送る情報のことです(例:ログイン時のメールアドレス＆パスワード)
     * @return view
     */
    public function __invoke(Request $request) {

        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // 箱  : $pcompany_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Companyクラス(Company.php)のインスタンス
        $company_instance = new Company();

        // 箱  ： $keywordという名前の変数(function同様に、中身が分かるものがよい)
        // 中身： 検索窓(lineup.blade.phpのname属性がkeywordのinputタグ)に入力された文字を取得します
        $keyword = $request->input('keyword');

        // 箱  ： $selected_nameという名前の変数(function同様に、中身が分かるものがよい)
        // 中身： セレクトボックスで選択されたメーカー名に紐づくcompany_idを取得します
        $selected_name = $request->input('company_id');

        // try catchを入れることで、正常な処理の時はtryを。エラーがあった際のみcatchに書いた内容が実行されます
        try {

            // 箱  ： $product_listという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Product.phpのsearchProductByParamsにアクセス
            $product_list = $product_instance->searchProductByParams($keyword, $selected_name);

            // 箱  ： $company_dataという名前の変数(function同様に、中身が分かるものがよい)
            // 中身： Company.phpのcompanyInfoにアクセス
            $company_data = $company_instance->companyInfo();

        } catch (\Throwable $e) {
            // 何らかのエラーが起きた際は、こちらの処理を実行

            // エラーメッセージだけだと、ユーザーが困ってしまうので本来は、エラーページを返します
            // 今回はページ作るの面倒だったので、エラーメッセージを返します
            throw new \Exception($e->getMessage());
        }

        // 〜 余談 〜
        // compact()に渡すものが多いなと思ったら、まとめ方があります
        // view(今回だと'/resources/views/product/lineup.blade.php')でのデータの表示のさせ方(書き方)も変わってきます
        $data = [
            'product_list' => $product_list,
            'company_data' => $company_data,
            'keyword'      => $keyword,
        ];
        // $dataで渡すものをまとめなかった場合↓
        // return view('product.lineup', compact('product_list', 'company_data', 'keyword'));

        // '/resources/views/product/lineup.blade.php'に渡したい変数(showLineupで定義したもの)を、compact()関数を用いて渡す。
        // このとき変数に$は付けない
        return view('product.lineup', compact('data'));
    }
}
