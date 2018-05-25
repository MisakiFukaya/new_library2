<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookstate $bookstate
 */
?>
<div id="right_top">
  <h1>資料情報の変更・削除</h1>
  変更する項目を入力してください<br>
  廃棄の場合は蔵書冊数を変更してください
</div>
<div id="right_center">

  <pre>
    <?php var_dump($new_test); ?>
  </pre>
  <?= $this->Form->create($bookstate,['type'=>'post','url'=>['controller'=>'Bookstates','action'=>'edit']]) ?>
  <table border="1">
        <?php
        $i='1';
            // echo $this->Form->control('book_id');
            echo $this->Form->control('book'.$i.'.isbn');
            echo $this->Form->control('book'.$i.'.name');
            echo $this->Form->control('book'.$i.'.author');
            echo $this->Form->control('book'.$i.'.publisher');
            echo $this->Form->control('book'.$i.'.publish_date');
            echo $this->Form->control('book'.$i.'.arrival_date');
            echo $this->Form->control('book'.$i.'.delete_date');
            echo $this->Form->control('book'.$i.'.state');

            echo '<br>';
            $i='2';

            echo $this->Form->control('book'.$i.'.isbn');
            echo $this->Form->control('book'.$i.'.name');
            echo $this->Form->control('book'.$i.'.author');
            echo $this->Form->control('book'.$i.'.publisher');
            echo $this->Form->control('book'.$i.'.publish_date');
            echo $this->Form->control('book'.$i.'.arrival_date');
            echo $this->Form->control('book'.$i.'.delete_date');
            echo $this->Form->control('book'.$i.'.state');

        ?>
      </table>


        foreach ($bookstate as $value) {
          echo '<tr><td></td><td>'.'<br>'.'</td></tr>';
            echo '<tr><td>ISBN番号</td><td>'.$this->Form->control('book.'.$i.'.isbn',['value'=>$value->book->isbn,'label'=>'']).'</td></tr>';
            echo '<tr><td>タイトル</td><td>'.$this->Form->control('book.'.$i.'.name',['value'=>$value->book->name,'label'=>'']).'</td></tr>';
            echo '<tr><td>著者名</td><td>'.$this->Form->control('book.'.$i.'.author',['value'=>$value->book->author,'label'=>'']).'</td></tr>';
            echo '<tr><td>出版社コード</td><td>'.$this->Form->control('book.'.$i.'.publisher',['value'=>$value->book->publisher_id,'label'=>'']).'</td></tr>';
            echo '<tr><td>出版日</td><td>'.$this->Form->control('book.'.$i.'.publish_date',['value'=>$value->book->publish_date,'label'=>'']).'</td></tr>';
            echo '<tr><td>入荷年月日</td><td>'.$this->Form->control('book.'.$i.'.arrival_date',['value'=>$value->arrival_date,'label'=>'']).'</td></tr>';
            echo '<tr><td>廃棄日年月日</td><td>'.$this->Form->control('book.'.$i.'.delete_date',['value'=>$value->delete_date,'label'=>'']).'</td></tr>';
            echo '<tr><td>蔵書冊数</td><td>'.$this->Form->control('book.'.$i.'.state',['value'=>$value->state,'label'=>'']).'</td></tr>';
            $i++;
          }?>
      </table>
    </div>
    <div id="right_under">
      <?= $this->Form->button(__('登録'),['class'=>'under_button']) ?>
      <?= $this->Form->end() ?>
      <button class="under_button">情報検索画面へ</button>
    </div>
