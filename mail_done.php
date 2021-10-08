<?php
session_start();
header('X-FRAME-OPTIONS: SAMEORIGIN');

if(!(hash_equals($_POST['token'],$_SESSION['token']))):
  echo "正しくアクセスして下さい";
  $_SESSION = array();
  if(isset($_COOKIE[session_name()])):
    setcookie(session_name(),'',time()-1000);
  endif;
  session_destroy();
  die();
endif;

$kinds_arr = array("ご意見・ご感想","不具合の報告","お仕事のご依頼","その他");

//言語と文字コードを設定
mb_language("japanese"); 
mb_internal_encoding("UTF-8");

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$kinds = $kinds_arr[$_SESSION['kinds']];
$message = $_SESSION['message'];

$to = "f0157suki@gmail.com";
$subject = "ポートフォリオからのメール";
$body = "差出人：".$name."\r\nメアド：".$email."\r\n種別：".$kinds."\r\n本文：\r\n".$message;
$from="From:".$email;

//送信
$result = mb_send_mail($to,$subject,$body,$from);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>メールフォーム‐送信完了</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <?php if($result): ?>
      <h1>送信が完了しました！</h1>
      <p><i class="fas fa-paper-plane"></i></p>
      <?php else: ?>
      <h1>送信に失敗しました…。</h1>
      <p><i class="fas fa-dizzy"></i></p>
      <?php endif; ?>
    </header>
    <div id="wrapper">
      <main>
        <div id="done">
          <?php if($result): ?>
          <p>お問い合わせありがとうございました。<br><br>※多忙時は返信にお時間を頂く場合がございます。<br>お急ぎの用件は<a href="https://twitter.com/mg_oyu">TwitterのDMへ</a>ご連絡下さい。</p>
          <?php else: ?>
          <p>お手数ですが、時間をおいて再度お試しください。</p>
          <?php endif; ?>
        </div>
      </main>
    </div>
  </body>
</html>