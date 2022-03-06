<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- スタイルシート -->
  <link rel="stylesheet" href="css/list.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/reset.css">
  <!-- フォント -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
  <title>一覧画面</title>
  <?php
    // ホットペッパーAPI
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $hotpepper_API = $_ENV["HOTPEPPER_API"];
    // データ受け取り
    $latitude =  $_POST['latitude']; 
    $longitude = $_POST['longitude'];
    $ranges = $_POST['ranges'];
    $start = $_POST['start'];
    $genre = $_POST['genre'];
    $order =$_POST['order'];
    $budget =$_POST['budget'];
    $keyword =$_POST['keyword'];
    $ktai_coupon = $_POST['ktai_coupon'];
    $api = $hotpepper_API;
    // クエリをまとめる
    $query = [
      'key' => $api,
      'lat' => $latitude,
      'lng' => $longitude,
      'range' => $ranges,
      'start' => $start, 
      'genre' => $genre,
      'order' => $order,
      'budget' => $budget,
      'keyword' => $keyword,
      'ktai_coupon' => $ktai_coupon,
      'format' => 'json', 
    ];
    // グルメサーチAPIからjsonを取得
    $url = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?';
    $url .= http_build_query($query);
    $response = file_get_contents($url);
    $json = json_decode($response, true);

    //ページネート用API
    if(isset($_POST['page'])){
      $latitude = $_POST['page_latitude']; 
      $longitude = $_POST['page_longitude'];
      $range = $_POST['ranges'];
      $genre = $_POST['genre'];
      $order = $_POST['order'];
      $start = $_POST['start'];
      $budget = $_POST['budget'];
      $keyword = $_POST['keyword'];
      $ktai_coupon = $_POST['ktai_coupon'];
      // クエリをまとめる
      $query = [
        'key' => $api, 
        'lat' => $latitude,
        'lng' => $longitude,
        'range' => $range,
        'start' => $start,
        'genre' => $genre,
        'order' => $order,
        'budget' => $budget,
        'keyword' => $keyword,
        'ktai_coupon' => $ktai_coupon,
        'count' => 10,
        'format' => 'json', 
      ];
      // グルメサーチAPIからjsonを取得
      $url = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?';
      $url .= http_build_query($query);
      $response = file_get_contents($url);
      $json = json_decode($response, true);
    }
    //半径代入

    switch($ranges){
      case "1":
        $show_range = "300m";
        break;
      case "2";
        $show_range = "500m";
        break;
      case "3":
        $show_range = "1km";
        break;
      case "4":
        $show_range = "2km";
        break;
      case "5":
        $show_range = "3km";
        break;
    }
  ?>
</head>
<body>
  <div class="main">
  <?php if($json['results']['results_available'] == 0): ?>
    <p class="find font">条件に一致するものが見つかりませんでした…</p>
  <?php else:?>
    <p class="find font">現在地から半径<?= $show_range ;?>で、<?= $json['results']['results_available']; ?>件見つかりました。</p>
  <?php endif;?>
  <!-- ページバック -->
  <button onclick="location.href='index.php'" class="back_button font">検索画面に戻る</button>
  <!-- 並び順 -->
  <?php 
    if($json['results']['results_available'] != 0): if($order == "1"):
  ?>
    <p class="font sort_text">店名かな順で表示しています。</p>
  <?php elseif($order == "4"): ?>
    <p class="font sort_text">おすすめ順で表示しています。</p>
  <?php else:?>
    <p class="font sort_text">距離順で表示しています。</p>
  <?php 
    endif;
    endif;
  ?>
  <!-- ページネーション -->
  <div class="pagenate">
  <?php 
    if($json['results']['results_available'] > 10):
    $i = ceil($json['results']['results_available']/10);
    for($j=0; $j<$i; $j++):
  ?>
    <form method="POST" class="search_form">
      <input type="hidden" name="page_latitude" id="latitude" value="<?= $latitude?>">
      <input type="hidden" name="page_longitude" id="longitude" value="<?= $longitude?>">
      <input type="hidden" name="ranges" value="<?= $ranges;?>">
      <input type="hidden" name="start" value="<?= $j*10+1;?>">
      <input type="hidden" name="genre" value="<?= $genre;?>">
      <input type="hidden" name="order" value="<?= $order;?>">
      <input type="hidden" name="budget" value="<?= $budget;?>">
      <input type="hidden" name="ktai_coupon" value="<?= $ktai_coupon;?>">
      <input type="hidden" value="10" name="count">
      <input type="hidden" value="page" name="page">
      <input class="page_button font"  value="<?= $j+1;?>" type="submit" <?php if($json['results']['results_start'] == $j*10+1){echo "style = 'background-color:rgba(123, 123, 123, 0.755) ;' " ;}?>>
    </form>
  <?php 
    endfor;
    endif;
  ?>
  </div>
  <?php
    for($k=0; $k<$json['results']['results_returned'];$k++):
  ?>
  <div class="card">
    <div class="card_left">
      <div class="card_img">
        <img  src="<?= $json["results"]["shop"][$k]["logo_image"]; ?>" alt="サムネイル">
      </div>
      <div class="card_content">
        <div class="name">
          <p class="font shop_name"><?= $json["results"]["shop"][$k]["name"]; ?></p>
        </div>
        <table>
          <tr>
            <td class="td_left" align="right">
              <p class="font card_title">最寄り駅：</p>
            </td>
            <td class="td_right">
              <p class="font station card_text"><?php echo $json["results"]["shop"][$k]["station_name"]; ?>駅</p>
            </td>
          </tr>
          <tr>
            <td class="td_left" align="right">
              <p class="font card_title">アクセス：</p>
            </td>
            <td>
              <p class="font shop_access card_text"><?php echo $json["results"]["shop"][$k]["access"]; ?></p>
            </td>
          </tr>
          <tr>
            <td class="td_left" align="right">
              <p class="font card_title">ジャンル：</p>
            </td>
            <td>
              <p class="font card_text"><?=  $json["results"]["shop"][$k]["genre"]["name"];?></p>
            </td>
          </tr>
          <tr>
            <td class="td_left" align="right">
              <p class="font card_title">平均予算：</p>
            </td>
            <td>
              <p class="font card_text"><?=  $json["results"]["shop"][$k]["budget"]["average"];?></p>
            </td>
          </tr>
          <tr>
            <td class="td_left" align="right">
              <p class="font card_title">メッセージ：</p>
            </td>
            <td>
              <p class="font card_text catch"><?=  $json["results"]["shop"][$k]["catch"];?></p>
            </td>
          </tr>
          <tr class="coupon_responsive">
            <td colspan="2" align="center"">
            <?php if($json["results"]["shop"][$k]["ktai_coupon"] == 0):?>
              <p class="coupon_text">クーポンあり！!</p>
            <?php endif; ?>
            </td>
          </tr>
          <tr class="img_responsive">
            <td align="center" colspan="2" class="img_responsive">
              <img  src="<?= $json["results"]["shop"][$k]["logo_image"]; ?>" alt="サムネイル">
            </td>
            
          </tr>
          <tr>
            <td class="td_left" align="center" colspan="2">
              <form action="show.php" method="POST">
                <input type="hidden" value="<?= $json["results"]["shop"][$k]["id"];?>" name="id">
                <input type="submit" value="詳細" class="font detail_button">
              </form>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="coupon">
      <?php if($json["results"]["shop"][$k]["ktai_coupon"] == 0):?>
        <p class="coupon_text">クーポンあり！!</p>
      <?php endif; ?>
    </div>
  </div>
  <?php endfor; ?>
    <!-- ページネーション -->
    <div class="pagenate">
  <?php 
    if($json['results']['results_available'] > 10):
    $i = ceil($json['results']['results_available']/10);
    for($j=0; $j<$i; $j++):
  ?>
    <form method="POST" class="search_form">
      <input type="hidden" name="page_latitude" id="latitude" value="<?= $latitude?>">
      <input type="hidden" name="page_longitude" id="longitude" value="<?= $longitude?>">
      <input type="hidden" name="ranges" value="<?= $ranges;?>">
      <input type="hidden" name="start" value="<?= $j*10+1;?>">
      <input type="hidden" name="genre" value="<?= $genre;?>">
      <input type="hidden" name="order" value="<?= $order;?>">
      <input type="hidden" name="budget" value="<?= $budget;?>">
      <input type="hidden" name="ktai_coupon" value="<?= $ktai_coupon;?>">
      <input type="hidden" value="10" name="count">
      <input type="hidden" value="page" name="page">
      <input class="page_button font"  value="<?= $j+1;?>" type="submit" <?php if($json['results']['results_start'] == $j*10+1){echo "style = 'background-color:rgba(123, 123, 123, 0.755) ;' " ;}?>>
    </form>
  <?php 
    endfor;
    endif;
  ?>
  </div>
  <!-- ページバック -->
  <?php if($json['results']['results_available'] > 10): ?>
    <button onclick="location.href='index.php'" class="back_button back_button_bottom font">検索画面に戻る</button>
  <?php endif; ?>
</body>
</html>
