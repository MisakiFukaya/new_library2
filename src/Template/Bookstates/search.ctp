<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 */
?>

<div id="right_top">

<h1>資料検索</h1>
<?= $this->Form->create(null,
['type'=>'post',
'url'=>['controller'=>'Bookstates',
'action'=>'search']])?>


<div>isbn<?= $this->Form->text('Bookstates.find') ?>
  <?= $this->Form->button('検索',['type'=>'submit']) ?></div>
<div><?= $this->Form->end() ?></div>
</div>

<div id="right_center">

  <pre>
  <?php
//var_dump($bookstates[0]);
//var_dump($count);
//print_r($books);


   ?>
 </pre>
 <?= $this->Form->create(null,
 ['type'=>'post',
 'url'=>['controller'=>'Bookstates',
 'action'=>'edit']])?>

 <?= $this->Form->create(null,
 ['type'=>'post',
 'url'=>['controller'=>'Bookstates',
 'action'=>'edit']])?>

  <h3><?= __('Bookstates') ?></h3>

  <table  border='1' id="test_table">
    <tr>
      <th scope="col"><?= $this->Paginator->sort('bookstate_id') ?></th>
      <th scope="col"><?= $this->Paginator->sort('ISBN番号') ?></th>
      <th scope="col"><?= $this->Paginator->sort('区分') ?></th>
      <th scope="col"><?= $this->Paginator->sort('タイトル') ?></th>
      <th scope="col"><?= $this->Paginator->sort('著者名') ?></th>
      <th scope="col"><?= $this->Paginator->sort('出版社名') ?></th>
      <th scope="col"><?= $this->Paginator->sort('出版日') ?></th>
      <th scope="col"><?= $this->Paginator->sort('資料ID') ?></th>
      <th scope="col"><?= $this->Paginator->sort('入荷年月日') ?></th>
      <th scope="col"><?= $this->Paginator->sort('廃棄年月日') ?></th>
      <th scope="col"><?= $this->Paginator->sort('蔵書冊数') ?></th>
      <th scope="col"><?= $this->Paginator->sort('変更・削除') ?></th>
    </tr>
    <?php $i=0;?>
    <?php foreach ($bookstates as $bookstate): ?>
      <tr>


        <td><?= h($bookstate->id)  ?></td>
        <td><?= h($bookstate->book->isbn)  ?></td>
        <td><?= h($bookstate->book->category->category)  ?></td>
        <td><?= h($bookstate->book->name) ?></td>
        <td><?= h($bookstate->book->author) ?></td>
        <td><?= h($bookstate->book->publisher->publisher) ?></td>
        <td><?= h($bookstate->book->publish_date) ?></td>
        <td><?= h($this->Number->format($bookstate->book->id)) ?></td>
        <td><?= h($bookstate->arrival_date) ?></td>
        <td><?= h($bookstate->delete_date) ?></td>
        <td><?= h($count[$i]) ?></td>
        <td><?= $this->Form->checkbox('bookstate_id[]',['value' => $bookstate->id,'hiddenField' => false])?></td>


      </tr>
      <?php $i++;?>
    <?php endforeach; ?>


  </table>

  <div class="paginator">
    <ul class="pagination">
      <?= $this->Paginator->first('<< ' . __('first')) ?>
      <?= $this->Paginator->prev('< ' . __('previous')) ?>
      <?= $this->Paginator->numbers() ?>
      <?= $this->Paginator->next(__('next') . ' >') ?>
      <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>

  </div>
</div>
<div id="right_under">


  <?= $this->Form->button(__('変更・削除画面へ'),['class'=>'under_button','type'=>'submit']) ?>

  <?= $this->Form->end() ?>
</div>
