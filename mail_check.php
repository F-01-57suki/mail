<?php
session_start();
header('X-FRAME-OPTIONS: SAMEORIGIN');

if(!(hash_equals($_POST['token'],$_SESSION['token']))):
  echo "正しくアクセスして下さい！";
  $_SESSION = array();
  if(isset($_COOKIE[session_name()])):
    setcookie(session_name(),'',time()-1000);
  endif;
  session_destroy();
  die();
endif;

$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
$email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
$message = htmlspecialchars($_POST['message'],ENT_QUOTES,'UTF-8');
$kinds_arr = array("ご意見・ご感想","不具合の報告","お仕事のご依頼","その他");
$kinds = $_POST['kinds'];

//必須
$errors = array();
if($name == ''):
  $errors['name'] = "お名前は入力必須です。";
endif;
if($message == ''):
  $errors['message'] = "お問い合わせ内容は入力必須です。";
endif;

//任意
if($email == ''):
  $email = "NotEntered";
else:
  if(preg_match("/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@[A-Za-z0-9_.-]+\.[A-Za-z0-9]+$/",$email)):
    $errors['email'] = "メールアドレスを正しく入力してください。";
  endif;
endif;
if($kinds == ''):
  $kinds = 3;
endif;

if(count($errors) === 0){
  $_SESSION['name']=$name;
  $_SESSION['mail']=$mail;
  $_SESSION['kinds']=$kinds;
  $_SESSION['comment']=$comment;
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>お問い合わせ‐確認</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <h1>メール送信確認</h1>
      <p><i class="fas fa-envelope"></i></p>
    </header>
    <div id="wrapper">
      <main>
        <form action="mail_check.php" method="POST">
          <table>
            <tbody>
              <tr>
                <th>お名前<br><span class="span_th">必須</span></th>
                <td><?php echo $name; ?></td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><?php echo $email; ?></td>
              </tr>
              <tr>
                <th>お問い合わせ種別</th>
                <td><?php echo $kinds_arr[$kinds]; ?></td>
              </tr>
              <tr>
                <th>お問い合わせ内容<br><span class="span_th">必須</span></th>
                <td><?php echo nl2br($comment); ?></td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="hidden" name="token" value="<?php echo $_POST['token']; ?>">
                  <input type="submit" value="送信">
                  <input type="button" value="戻る" onClick="history.go(-1)">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </main>
    </div>
  </body>
</html>