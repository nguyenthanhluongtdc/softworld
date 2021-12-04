function GetPrice(type){
    var name;
    var res = $.ajax({
       type: 'post',
       url: 'index.php',
       data: 'adminajax=1&type='+type,
       async: false
    }).responseText;

    if(res != ''){
        $('#order_price').val(res);
        $('#order_price_v').html(res);
    }
}
