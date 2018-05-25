<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新宿図書館システム</title>
  <?=$this->Html->css('mainstyle.css')?>


</head>
<body>
  <div id="container">
    <div id="left">
      <div id="logo">
        <font color="white">新宿図書館システム</font>
      </div>

      <div id="search_box">
        <br>

        <!-- 検索結果を会員検索ページに送る-->
        <?= $this->Form->create(null,
        ['type'=>'get',
        'name'=>'searchform',
        'url'=>['controller'=>'Users',
        'action'=>'']])?>

        <?= $this->Form->text('Users.find') ?>
        <?= $this->Form->button('検索',['onclick'=>'PageChange()']) ?>
        <?= $this->Form->end() ?></div>

        <!-- ラジオボタンで分岐させる-->
        <script type="text/javascript">
        function PageChange(){
        if (document.change.user.checked){//console.log("usersです");
        document.searchform.action="/library_system/Users/search";
        }
        else if(document.change.bookstate.checked){//console.log("資料です");
        document.searchform.action="/library_system/Bookstates/search";
        }
      //  document.searchform.submit();
        }
        </script>

          <form name="change" id="radio">
          <input type="radio" name ="topage" value="1" id="user" checked="checked"><font color="">会員</font>
          <input type="radio" name ="topage" value="2" id="bookstate"><font color="">資料</font>
          </form>

        <div id="menu">
          <br>
          <a href=""><font color="black"><a href="http://localhost/library_system/Users/">・会員管理</font></a><br><br>
          <a href=""><font color="black"><a href="http://localhost/library_system/bookstates/">・資料管理</font></a><br><br>
          <a href=""><font color="black"><a href="http://localhost/library_system/rentals/">・貸出</font></a><br><br>
          <a href=""><font color="black"><a href="http://localhost/library_system/rentals/returncheck/">・返却</font></a><br><br>
          <a href=""><font color="black">・予約</font></a><br><br>
          <a href=""><font color="black"><s>・督促状管理</s></font></a>
        </div>


        <div id="left_footer">
        </div>


      </div>
      <div id="right">
        <?=$this->Flash->render()?>
        <div id="content">
          <?=$this->fetch('content')?>
        </div>

      </div>




    </div>

  </body>
  </html>
