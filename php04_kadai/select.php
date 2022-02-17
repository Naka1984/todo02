<?php
  // 0. SESSION開始！！
session_start();
$user_id = $_SESSION['user_id'];  //user_idと紐づいたTodoを読み込む
$kanri_flg = $_SESSION['kanri_flg'];

// 1. ログインチェック処理！
// 以下、セッションID持ってたら、ok
// 持ってなければ、閲覧できない処理にする。

if(!isset($_SESSION['chk_ssid'] )|| $_SESSION['chk_ssid']!= session_id()){
    echo 'LOGIN Error:';
    exit();
}



//１．関数群の読み込み
require_once('funcs.php');

if ($kanri_flg == 0) {      //管理者権限があるかチェックする。なければselect2.phpに移動
    redirect('select2.php');
}

//２．データ登録SQL作成
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM posts WHERE user_id=:id');
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>メインページ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="sidemenu.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet"  href="css/styles.css"/>
</head>


<body>
  <div class="slidemenu slidemenu-left">
    <div class="slidemenu-header">
     
        <img src='<?php echo $_SESSION["user_photo"]; ?>' style="padding-top: 30px ">
        <div class='user_photo'><p style='font-size:large'><?=  $_SESSION['name'],'&nbsp;&nbsp;&nbsp' ?></p></div>
        <div class='user_logintime'>最終ログイン:2022/02/17 15:05</div>
    </div>
    <div class="slidemenu-body">
      <ul class="slidemenu-content">
        <li><a class="menu-item" href="https://docs.google.com/spreadsheets/d/1G_TBZlJnlL_nCz1jNHsmEgABRg7OpRYusg7abPzh3HM/edit#gid=1124570819">要件定義書トップ</a></li>
        <li><a class="menu-item" href="https://docs.google.com/spreadsheets/d/1G_TBZlJnlL_nCz1jNHsmEgABRg7OpRYusg7abPzh3HM/edit#gid=983649554">サイトマップ</a></li>
        <li><a class="menu-item" href="https://docs.google.com/spreadsheets/d/1G_TBZlJnlL_nCz1jNHsmEgABRg7OpRYusg7abPzh3HM/edit#gid=1241013620">WBS・ガントチャート</a></li>
        <li><a class="menu-item" href="https://forms.gle/mn2725gzD3wfit7a6">アンケート（回答）</a></li>
        <li><a class="menu-item" href="https://docs.google.com/forms/d/1UUTsoORpdGR1F9vGzVATOZ1EjTnIOTXmNXC6DRK0kiY/edit">アンケート（質問・設定）</a></li>
        <li><a class="menu-item" href="">アンケート（集計）</a></li>
        <li><a class="menu-item" href="user_data.php">ユーザー設定</a></li>
        <!--<li><a class="menu-item" href="">Menu 8</a></li>
        <li><a class="menu-item" href="">Menu 9</a></li>
        <li><a class="menu-item" href="">Menu 10</a></li>
        <li><a class="menu-item" href="">Menu 11</a></li>
        <li><a class="menu-item" href="">Menu 12</a></li>
        <li><a class="menu-item" href="">Menu 13</a></li>
        <li><a class="menu-item" href="">Menu 14</a></li>
        <li><a class="menu-item" href="">Menu 15</a></li>
        <li><a class="menu-item" href="">Menu 16</a></li>
        <li><a class="menu-item" href="">Menu 17</a></li>
        <li><a class="menu-item" href="">Menu 18</a></li>
        <li><a class="menu-item" href="">Menu 19</a></li>
        <li><a class="menu-item" href="">Menu 20</a></li>
        <li><a class="menu-item" href="">Menu 21</a></li>
        <li><a class="menu-item" href="">Menu 22</a></li>
        <li><a class="menu-item" href="">Menu 23</a></li>
        <li><a class="menu-item" href="">Menu 24</a></li>
        <li><a class="menu-item" href="">Menu 25</a></li>
        <li><a class="menu-item" href="">Menu 26</a></li>
        <li><a class="menu-item" href="">Menu 27</a></li>
        <li><a class="menu-item" href="">Menu 28</a></li>
        <li><a class="menu-item" href="">Menu 29</a></li> -->
        <li><a class="menu-item" href="logout.php">ログアウト</a></li> 
      </ul>
    </div>
  </div>

  <div id="main"  style='background-color:aliceblue'>
    <header id="header">
      <span class="button menu-button-left">
      </span>
      <div><a href="select.php"><img src="img/signers_logo_baner.png" alt="ロゴ" style="padding-left: 60px; padding-top: 5px "></a></div>
    
    </header>
    <!-- <div id="contents">
      <h1>SpSlideMenu Demo</h1>
      <p><a href="demo1.html">Demo 1</a> : Standard</p>
      <p><a href="demo2.html">Demo 2</a> : No Header</p>
      <p><a href="demo3.html">Demo 3</a> : Right</p>
      <p><a href="demo4.html">Demo 4</a> : Left And Right</p> -->
    <!-- </div> -->
  


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <div class='col-10 mx-auto' style='margin-top:10%';>
    <div><p style='font-size:xx-large'>Todo</p></div>
    <div><p style='text-align:right'><a href="index.php">新規作成</a></p><br></div>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>記事ID</th>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>タイトル</th>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>本文</th>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>最終更新日</th>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>編集</th>
            <th scope="col" style='text-align:center;  background-color:lightsteelblue'>削除</th>
          </tr>
        </thead>
        <tbody>
            
          <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
              <td  style='text-align:center;'><?php echo $row["id"]; ?></td>
              <td style='text-align:center;'><?php echo $row["title"]; ?></td>
              <td><?php echo $row["content"]; ?></td>
              <td><?php echo $row["time"]; ?></td>
              <td  style='text-align:center;'><a href="post_detail.php?id=<?php echo $row['id'];?>">編集</a></td>
              <td style='text-align:center;'><a href="post_delete.php?id=<?php echo $row['id'];?>">削除</a></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
  </div>
 

  <script type="text/javascript" src="sp-slidemenu.js"></script>
  <script>
    var menu = SpSlidemenu({
      main : '#main',
      button: '.menu-button-left',
      slidemenu : '.slidemenu-left',
      direction: 'left'
    });
  </script>

</div>
</body>

</html>
