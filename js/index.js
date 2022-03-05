var load = document.getElementById("load");
var  search_buttton = document.getElementById("search_buttton");
load.textContent="現在地取得中です！";
//位置情報取得までボタン操作禁止
search_buttton.disabled=true;
//対応判定
if( navigator.geolocation )
{
  // 現在地を取得
  navigator.geolocation.getCurrentPosition(
    function success(position) {
      var latitude  = position.coords.latitude;//緯度
      var longitude = position.coords.longitude;//経度
      document.getElementById("latitude").value = latitude;
      document.getElementById("longitude").value = longitude;
      
      var latlng = new google.maps.LatLng( latitude , longitude ) ;
      //書き出し
      var map = new google.maps.Map( document.getElementById( 'map' ) , {
          zoom: 15 ,
          center: latlng ,
      } ) ;
      // マーカー
      new google.maps.Marker( {
          map: map ,
          position: latlng ,
      } ) ;
      load.textContent="現在地";
      search_buttton.disabled=false;
    },
    function( error )
    {
      var errorInfo = [
        "原因不明のエラーが発生しました。" ,// 0:UNKNOWN_ERROR:原因不明のエラー
        "位置情報の取得が許可されませんでした。" ,// 1:PERMISSION_DENIED:利用者が位置情報の取得を許可しなかった
        "電波状況などで位置情報が取得できませんでした。" ,// 2:POSITION_UNAVAILABLE:電波状況などで位置情報が取得できなかった
        "位置情報の取得に時間がかかり過ぎてタイムアウトしました。"// 3:TIMEOUT:位置情報の取得に時間がかかり過ぎた
      ] ;
      // エラー番号
      var errorNo = error.code ;
      // エラーメッセージ
      var errorMessage = "[エラー番号: " + errorNo + "]\n" + errorInfo[ errorNo ] ;
      // アラート表示
      alert( errorMessage ) ;
      // HTMLに書き出し
      document.getElementById("result").innerHTML = errorMessage;
    } ,
    {
      "enableHighAccuracy": false,
      "timeout": 8000,
      "maximumAge": 2000,
    }
  ) ;
}
// 対応していない場合
else
{
  // エラーメッセージ
  var errorMessage = "お使いの端末は、GeoLacation APIに対応していません。" ;
  // アラート表示
  alert( errorMessage ) ;
  // HTMLに書き出し
  document.getElementById( 'result' ).innerHTML = errorMessage ;
}
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 8,
    center: { lat: 35.658611, lng: 139.745556 },
  });
}
