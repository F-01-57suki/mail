<?php
session_start();
header('X-FRAME-OPTIONS: SAMEORIGIN');
$_SESSION['token'] = uniqid('',true);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>お問い合わせ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <h1>お問い合わせ</h1>
      <p><i class="fas fa-envelope"></i></p>
    </header>
    <div id="wrapper">
      <main>
        <form action="mail_check.php" method="POST" id="mf">
          <table>
            <tbody>
              <tr><th id="firstchild">お名前<br><span class="span_th">必須</span></th></tr>
              <tr><td><input name="name" type="text" size="50" required></td></tr>
              <tr><th>メールアドレス</th></tr>
              <tr><td>
                <input name="email" type="email" size="50">
                <p class="form_p">※ご依頼や返信が必要な場合は、<span class="span_td">必ずご入力</span>ください。</p>
              </td></tr>
              <tr><th>お問い合わせ種別</th></tr>
              <tr><td>
                <select name="kinds">
                  <option value="0">ご意見・ご感想</option>
                  <option value="1">不具合の報告</option>
                  <option value="2">お仕事のご依頼</option>
                  <option value="3">その他</option>
                </select>
              </td></tr>
              <tr><th>お問い合わせ内容<br><span class="span_th">必須</span></th></tr>
              <tr><td>
                <textarea name="message" cols="50" rows="10" maxlength="400" placeholder="400文字以内でご記入ください。" required></textarea>
                <p class="form_p">※不具合の報告は、発生画面や現象を詳細にご入力ください。</p>
              </td></tr>
              <tr>
                <td colspan="2">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                  <input type="submit" value="確認画面" id="button">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </main>
    </div>
  </body>
</html>
