<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookstate $bookstate
 */
?>
<div id="right_top">
  <h1>変更完了</h1>
  変更内容が反映されました。<br>
</div>
<div id="right_center">
  <pre>
<?php
var_dump($new_post);
 ?>
  </pre>
  <table id="test_table">
        <?php
        $i=0;
        foreach ($new_test as $value) {
          // echo $this->request->getData('book.'.$i.'.isbn').'<br>';
          // echo $this->request->getData('book.'.$i.'.name').'<br>';
          // echo $this->request->getData('book.'.$i.'.author').'<br>';
          // echo $this->request->getData('book.'.$i.'.publisher').'<br>';
          // echo $this->request->getData('book.'.$i.'.publish_date').'<br>';
          // echo $this->request->getData('book.'.$i.'.arrival_date').'<br>';
          // echo $this->request->getData('book.'.$i.'.delete_date').'<br>';
          // echo $this->request->getData('book.'.$i.'.state').'<br>';
          echo h($value->book->isbn);
          echo h($value->book->name);
          echo h($value->book->author);
          echo h($value->book->publisher_id);
          echo h($value->book->publish_date);
          echo h($value->arrival_date);
          echo h($value->delete_date);
          echo h($value->state);
          $i++;
          echo '<hr>';
          }
        ?>
      </table>
    </div>
    <div id="right_under">
      <button class="under_button">情報検索画面へ</button>
    </div>
