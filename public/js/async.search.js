window.addEventListener('DOMContentLoaded', function () {

  $('.search-icon').on('click', function () {

    let keyword = $('.search_product').val();
    let selected_name = $('.company_num').val();
    let lowest_price = $(`.LowestPrice`).val();
    let highest_price = $(`.HighestPrice`).val();
    let minimum_number = $(`.MinimumNumber`).val();
    let maximum_number = $(`.MaximumNumber`).val();

    $.ajax({
      type: 'GET',
      url: 'asyncSearch',
      data: {
        'keyword': keyword,
        'selected_name': selected_name,
        'lowest_price': lowest_price,
        'highest_price': highest_price,
        'minimum_number': minimum_number,
        'maximum_number': maximum_number,
      },
      dataType: 'json',

    }).done(function (data) {
      alert("通信に成功しました");
      console.log(data);

      //再検索時に以前の検索結果を消す
      $('.product-table tbody').children().remove();
      $('.text-center mt-5 search-null').remove();

      let html = '';

      $.each(data, function (index, value) {
        let id = value.id;
        let product_name = value.product_name;
        let image = value.image;
        let price = value.price;
        let stock = value.stock;
        let company_name = value.company_name;

        if (image === null) {
          image = '/noimage.png';
        }

        html = `
          <tr class="product-list">
            <td class="col-xs-2">${id}</td>
            <td class="col-xs-2"><img src="/storage${image}" class="w-25 h-25"></td>
            <td class="col-xs-3">${product_name}</td>
            <td class="col-xs-2">${price}</td>
            <td class="col-xs-2">${stock}</td>
            <td class="col-xs-3">${company_name}</td>
            <td class="col-xs-5"><a class="btn btn-info" href="/product/${id}">詳細</a></td>
          </tr>
        `;

        $('.product-table tbody').append(html);

        $(function() {
          $(".tablesorter").tablesorter();
        });
      });

      // 検索結果がなかったときの処理
      if (!data.length) {
        $('.product-table tbody').after('<p class="text-center mt-5 search-null">商品が見つかりません</p>');
      }

    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
      console.log('どんまい！');
      console.log("XMLHttpRequest : " + XMLHttpRequest.status);
      console.log("textStatus     : " + textStatus);
      console.log("errorThrown    : " + errorThrown.message);
    });

  });

  $(function() {
    $(".tablesorter").tablesorter();
  });

});
