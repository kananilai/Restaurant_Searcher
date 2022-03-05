<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/show.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/reset.css">
  <title>店舗詳細</title>
  <!-- フォント -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
  <?php
    // ホットペッパーAPI
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $hotpepper_API = $_ENV["HOTPEPPER_API"];

    $id = $_POST['id'];
    // クエリをまとめる
    $query = [
        'key' => $hotpepper_API, 
        'id' => $id,
        'format' => 'json',
    ];
    // グルメサーチAPIからjsonを取得
    $url = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?';
    $url .= http_build_query($query);
    $response = file_get_contents($url);
    $json = json_decode($response, true);
  ?>
</head>
<body>
  <div class="card">
    <div class="form_img">
      <img src="img/form.png" alt="バインダー画像"></img> 
    </div>
    <div class="shop_top">
      <div class="logo_img">
        <img src="<?= $json["results"]["shop"][0]["logo_image"]; ?>" alt="サムネイル">
      </div>
      <p class="shop_name font"><?= $json["results"]["shop"][0]["name"]; ?></p>
    </div>
    <p class="shop_address font"><span>住所：</span><?= $json["results"]["shop"][0]["address"]; ?></p>
    <p class="shop_open font"><?= $json["results"]["shop"][0]["open"]; ?></p>
    <div class="shop_img">
      <img src="<?= $json["results"]["shop"][0]["photo"]["pc"]["l"]; ?>" alt="サムネイル">
    </div>
    <div class="url">
      <a class="font" href="<?= $json["results"]["shop"][0]["urls"]["pc"];?>">ホットペッパーグルメで見る</a>
    </div>
  </div>
  <button  class="back_button" onclick="history.back()" class="back_button font">一覧に戻る</button>
</body>
</html>
