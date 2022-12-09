<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;   // Requestの受け取り、受け渡しに必要

class registerProductData extends Controller
{
    /**
     * 商品情報登録/更新時に呼び出します。
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
     * @param Request $request
     * @return $data
     */
    public function __invoke(ProductRequest $request) {

        // 箱  : $imageいう名前の変数(function同様に、中身が分かるものがよい)
        // 中身: $request内のimageをfileメソッドで取得
        // 画像関係の実装をする際は、シンボリックリンクを貼ることをお忘れなく!
        $image = $request->file('image');

        // もし画像が登録されていたら(空でなければ)
        if (!empty($image)) {
            // 箱  : $image_pathという名前の変数(function同様に、中身が分かるものがよい)
            // 中身: getPathname()で画像のパスを取得します。
            $image_path = $image->getPathname();

            // if文開始前で宣言した$imageの中身の続きで、
            // $request->file('image')->storeAs('', $image_path, 'public');
            // と同じ意味になります！
            // $image_pathで取得した名前で、publicディレクトリに画像を保存する処理です
            $image->storeAs('', $image_path, 'public');
        }

        // 箱  : $result_dataという名前の変数(function同様に、中身が分かるものがよい)
        // 中身: 空の配列
        // 結果取得用で空の配列を作っておき、欲しいデータを突込んでいきます。
        $result_data = [];
        $result_data['id'] = $request->input('id');
        $result_data['company_id'] = $request->input('company_id');
        $result_data['product_name'] = $request->input('product_name');
        $result_data['price'] = $request->input('price');
        $result_data['stock'] = $request->input('stock');
        $result_data['comment'] = $request->input('comment');
        $result_data['image'] = $image;

        // 呼び出し元に、$result_dataを返却します。
        return $result_data;
    }
}
