var geolocation;
var lat_me;
var lon_me;
var useragent;

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

    useragent = navigator.userAgent;

    if(useragent.indexOf('iPhone') !== -1 || useragent.indexOf('Android') !== -1){
        try{
            if(typeof(navigator.geolocation) == 'undefined'){
                geolocation = google.gears.factory.create('beta.geolocation');

            }else{
                geolocation = navigator.geolocation;
            }

        }catch(e){}
    }

    if(geolocation){
        var watchId,marker_me;
        var successCallback = function(position){
            lat_me = position.coords.latitude;
            lon_me = position.coords.longitude;

            //if(mobile == ''){
                if(typeof(navigator.geolocation) != 'undefined'){
                    if(position.coords.accuracy < 300){ // || processingTime > 15000
                        geolocation.clearWatch(watchId);
                    }
                }
            //}

            if(
                typeof(lat_me) != 'undefined' && typeof(lon_me) != 'undefined'
                && typeof(shop_lat) != 'undefined' && typeof(shop_lon) != 'undefined'
            ){
                //alert(lat_me); //TEST
                //alert(lon_me); //TEST

                if(typeof(marker_me) != 'undefined') marker_me.setMap(null);
                marker_me = map.addMarker({
                    lat:lat_me,
                    lng:lon_me,
                    icon:icon_me,
                    title:"現在地",
                    infoWindow:{
                      content:'現在地'
                    }
                });

                $('#start_travel').show();
                $('#start_travel').click(function(e){ //start_travelをクリックしたらルート案内
                    e.preventDefault();
                    map.travelRoute({
                        origin: [lat_me,lon_me], //出発点の緯度経度
                        destination: [shop_lat,shop_lon], //目標地点の緯度経度
                        travelMode: 'walking', //モード（walking,driving）
                        step: function(e){
                            //$('#instructions').append('<li>'+e.instructions+'</li>'); //ルートをテキスト表示
                            //$('#instructions li:eq('+e.step_number+')').delay(450*e.step_number).fadeIn(200, function(){
                                //map.setCenter(e.end_location.lat(), e.end_location.lng());
                                map.setCenter(lat_me,lon_me);
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
        var errorCallback = function(error){
            //alert(error.code);
            //alert(error.message);
        }

        //位置情報取得時に設定するオプション
        var GeolocationOption = {
            enableHighAccuracy:true, //より精度の高い位置情報を取得する（true, false）
            gearsLocationProviderUrls:[], //純粋にGPSだけの情報を取得
            timeout:60000, //タイムアウトまでの時間（単位：ミリ秒）
            maximumAge:27000 //位置情報の有効期限（単位：ミリ秒）
        };
        watchId = geolocation.watchPosition(successCallback,errorCallback,GeolocationOption);
        //watchId = geolocation.getCurrentPosition(successCallback,errorCallback,GeolocationOption);
    }
});