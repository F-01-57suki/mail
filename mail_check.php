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
  $email = "メール未入力";
else:
  if(!preg_match("/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@[A-Za-z0-9_.-]+\.[A-Za-z0-9]+$/",$email)):
    $errors['email'] = "メールアドレスを正しく入力してください。";
  endif;
endif;

if(count($errors) !== 0):
  foreach($errors as $value):
    echo "<p>",$value,"</p>";
  endforeach;
else:
  $_SESSION['name'] = $name;
  $_SESSION['email'] = $email;
  $_SESSION['message'] = $message;
  $_SESSION['kinds'] = $kinds;
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>メールフォーム‐確認</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <h1>送信確認</h1>
      <p><i class="fas fa-envelope"></i></p>
    </header>
    <div id="wrapper">
      <main>
        <form action="mail_done.php" method="POST" id="mf">
          <table>
            <tbody>
              <tr><th id="firstchild">‐お名前‐<br><span class="span_th">必須</span></th></tr>
              <tr><td><?php echo $name; ?></td></tr>
              <tr><th>‐メールアドレス‐</th></tr>
              <tr><td><?php echo $email; ?></td></tr>
              <tr><th>‐お問い合わせ種別‐</th></tr>
              <tr><td><?php echo $kinds_arr[$kinds]; ?></td></tr>
              <tr><th>‐お問い合わせ内容‐<br><span class="span_th">必須</span></th></tr>
              <tr><td><?php echo nl2br($message); ?>
              </td></tr>
              <tr>
                <td colspan="2" class="btntd">
                  <input type="hidden" name="token" value="<?php echo $_POST['token']; ?>">
                  <input type="button" value="戻る" onClick="history.go(-1)">
                  <input type="submit" value="送信">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </main>
    </div>
  </body>
</html>
<?php endif; ?>