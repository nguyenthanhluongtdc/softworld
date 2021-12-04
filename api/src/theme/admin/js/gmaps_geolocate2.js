var geolocation;
//var lat_me;
//var lon_me;
var useragent;
var watchId;
var marker_me;

var icon_me = new google.maps.MarkerImage('http://www.google.com/mapfiles/gadget/arrowSmall80.png',
    new google.maps.Size(64,64),
    new google.maps.Point(0,0),
    new google.maps.Point(0,32)
);

$(document).ready(function(){
    $('#start_travel').hide();
    
    map = new GMaps({
        div: '#map_canvas', //Mapを表示するid名
        lat: shop_lat, //中心緯度
        lng: shop_lon, //中心経度,
        zoom: 17 //ズームレベル
    });
    map.addMarker({
        lat:shop_lat,
        lng:shop_lon,
        title:shop_name,
        infoWindow:{
          content:shop_name
        }
    });
});

document.addEventListener("DOMContentLoaded",function(){
    var position_options = {
        enableHighAccuracy: true,    // 高精度を要求する
        timeout: 60000,              // 最大待ち時間（ミリ秒）
        maximumAge: 0                // キャッシュ有効期間（ミリ秒）
    };
    // 現在位置情報を取得
    watchId = navigator.geolocation.watchPosition(monitor,null,position_options);
},false);

// 位置情報取得完了時の処理
function monitor(pos){    
    if(
        typeof(pos.coords.latitude) != 'undefined' && typeof(pos.coords.longitude) != 'undefined'
        && typeof(shop_lat) != 'undefined' && typeof(shop_lon) != 'undefined'
    ){
        $('#lat_me').html(pos.coords.latitude);
        $('#lon_me').html(pos.coords.longitude);
        
        if(typeof(marker_me) != 'undefined') marker_me.setMap(null);
        marker_me = map.addMarker({
            lat:pos.coords.latitude,
            lng:pos.coords.longitude,
            icon:icon_me,
            title:"現在地",
            infoWindow:{
              content:'現在地'
            }
        });
        //$('#lat_me').html(lat_me);
        //$('#lon_me').html(lon_me);
        
        $('#start_travel').show();
        $('#start_travel').click(function(e){ //start_travelをクリックしたらルート案内
            e.preventDefault();
            map.travelRoute({
                origin: [pos.coords.latitude,pos.coords.longitude], //出発点の緯度経度
                destination: [shop_lat,shop_lon], //目標地点の緯度経度
                travelMode: 'walking', //モード（walking,driving）
                step: function(e){
                    //$('#instructions').append('<li>'+e.instructions+'</li>'); //ルートをテキスト表示
                    //$('#instructions li:eq('+e.step_number+')').delay(450*e.step_number).fadeIn(200, function(){
                        //map.setCenter(e.end_location.lat(), e.end_location.lng());
                        map.setCenter(pos.coords.latitude,pos.coords.longitude);
                        map.drawPolyline({
                            path: e.path,
                            strokeColor:'#131540', //ルートの色
                            strokeOpacity:0.6, //ルートの透明度
                            strokeWeight:6 //ルート線の太さ
                        });
                    //});
                }
            });
        });
    }
}
