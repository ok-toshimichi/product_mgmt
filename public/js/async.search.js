window.addEventListener('DOMContentLoaded', function () {

  $('.search-icon').on('click', function () {

    let keyword = $('.search_product').val();
    let selected_name = $('.company_num').val();

    if (!keyword && !selected_name) {
      return false;
    } else if (!keyword) {
      keyword = null;
    } else if (!selected_name) {
      selected_name = null;
    }


    $.ajax({
      type: 'GET',
      url: 'asyncSearch/' + keyword + '/' + selected_name,
      data: {
        'search_product': keyword,
        'company_num': selected_name,
      },
      dataType: 'json',

    }).done(function (data) {
      alert("通信に成功しました");

    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
      console.log('どんまい！');
      console.log("XMLHttpRequest : " + XMLHttpRequest.status);
      console.log("textStatus     : " + textStatus);
      console.log("errorThrown    : " + errorThrown.message);
    });

  });

});
