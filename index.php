<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索画面</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/reset.css">
  <!-- フォント -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
  <!-- Google Map -->
  <?php
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $map_API = $_ENV["MAP_API"];
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=<?= $map_API;?>"></script> 
</head>
<body>
  <div>
    <p id="load" class="font load"></p>
    <div id="map" class="map"></div>
    <form action="list.php" method="POST" class="search_form">
      <table>
        <tr>
          <td class="row" align="right">
            <label class="font label_text">現在地から半径</label>
          </td>
          <td class="row">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" value="1" name="start">
            <input type="hidden" value="10" name="count">
            <select id="ranges" name="ranges" class="select">
              <option value="1">300m</option>
              <option value="2">500m</option>
              <option value="3">1km</option>
              <option value="4">2km</option>
              <option value="5">3km</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="row" align="right">
            <label class="font label_text">並び順</label>
          </td>
          <td class="row">
          <select id="order" name="order" class="select">
              <option value="">距離順</option>
              <option value="4">オススメ順</option>
              <option value="1">店名かな順</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="row" align="right">
            <label class="font label_text">カテゴリを絞る</label>
          </td>
          <td class="row">
            <select id="genre" name="genre" class="select">
              <option value="">選択可能です。</option>
              <option value="G001">居酒屋</option>
              <option value="G002">ダイニングバー・バル</option>
              <option value="G003">創作料理</option>
              <option value="G004">和食</option>
              <option value="G005">洋食</option>
              <option value="G006">イタリアン・フレンチ</option>
              <option value="G007">中華</option>
              <option value="G008">焼肉・ホルモン</option>
              <option value="G009">アジア・エスニック料理</option>
              <option value="G017">韓国料理</option>
              <option value="G010">各国料理</option>
              <option value="G011">カラオケ・パーティ</option>
              <option value="G012">バー・カクテル</option>
              <option value="G016">お好み焼き・もんじゃ</option>
              <option value="G013">ラーメン</option>
              <option value="G014">カフェ・スイーツ</option>
              <option value="G015">その他グルメ</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="row" align="right">
            <label class="font label_text">予算で絞る</label>
          </td>
          <td class="row">
            <select id="budget" name="budget" class="select">
              <option value="">選択可能です。</option>
              <option value="B009">～500円</option>
              <option value="B010">501～1000円</option>
              <option value="B011">1001～1500円</option>
              <option value="B001">1501～2000円</option>
              <option value="B002">2001～3000円</option>
              <option value="B003">3001～4000円</option>
              <option value="B008">4001～5000円</option>
              <option value="B004">5001～7000円</option>
              <option value="B005">7001～10000円</option>
              <option value="B006">10001～15000円</option>
              <option value="B012">15001～20000円</option>
              <option value="B013">20001～30000円</option>
              <option value="B014">30001円～</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="row">
            <label class="font label_text" align="right">キーワードで絞る</label>
          </td>
          <td class="row">
            <input rowspan=”2″ type="text" name="keyword" class="keyword_input" size="25" placeholder="例）〇〇駅">
            <small class="keyword_note">店名、住所、駅名、お店ジャンルをで絞り込みが可能です。</small>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="row" align="center">
            <button type="submit" class="font search_buttton"  id="search_buttton">検索する</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <footer class="footer">
    <p class="credit">Powered by <a href="http://webservice.recruit.co.jp/" class="footer_link">ホットペッパー Webサービス</a></p>
  </footer>
  <script src="js/index.js"></script>
</body>
</html>
