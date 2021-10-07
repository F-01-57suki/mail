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

//送信先アドレス
$email = 'f0157suki@gmail.com';
//言語と文字コードを設定
mb_language('japanese');
mb_internal_encoding('UTF-8');

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$message = $_SESSION['message'];
$kinds = $kinds_arr[$_SESSION['kinds']];
$subject = "ポートフォリオフォームからのメール";
$body = $name."\r\n".$email."\r\n".$kinds."\r\n".$comment."\r\n";
$from="From:info@aaa.aa";
//送信
$result = mb_send_mail($email,$subject,$body,$from);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>お問い合わせ‐送信完了</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <h1>メール送信完了</h1>
      <p><i class="fas fa-envelope"></i></p>
    </header>
    <div id="wrapper">
      <main>
        <?php if($result): ?>
        <p>送信完了しました。</p>
        <?php else: ?>
        <p>送信に失敗しました。時間をおいて、再度お試しください。</p>
        <?php endif; ?>
      </main>
    </div>
  </body>
</html>