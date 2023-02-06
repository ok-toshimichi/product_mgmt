<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;    // Product.phpと連携
use App\Models\Company;    // Company.phpと連携

class exeAsyncSearch extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $keyword, $selected_name
     * @return json
     */
    public function __invoke($keyword, $selected_name)
    {
        // 箱  : $product_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Productクラス(Product.php)のインスタンス
        $product_instance = new Product();

        // 箱  : $pcompany_instanceという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: Companyクラス(Company.php)のインスタンス
        $company_instance = new Company();

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

        $data = [
            'product_list' => $product_list,
            'company_data' => $company_data,
            'keyword'      => $keyword,
        ];

        // このとき変数に$は付ける？
        return response()->json($data);
    }
}
