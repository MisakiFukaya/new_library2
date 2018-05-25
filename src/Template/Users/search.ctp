<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
*/
?>

<div id="right_top">
  <h1>会員情報検索</h1>

  <?= $this->Form->create(null,['type'=>'post','url'=>['controller'=>'Users','action'=>'search']]) ?>
  <?=$this->Form->text('Users.query')?>
  <?=$this->Form->submit('検索')?>
  <?=$this->Form->end()?>

</div>
<div id="right_center">
  <?=$this->Flash->render()?>


  <h3><?= __('会員情報') ?></h3>

  <table  border='1' id="test_table">
    <tr>


      <th scope="col"><?= $this->Paginator->sort('id',['label'=>'会員番号']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('last_name',['label'=>'姓']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('first_name',['label'=>'名']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('postal',['label'=>'郵便番号']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('address',['label'=>'住所']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('tel',['label'=>'電話番号']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('email',['label'=>'E-mail']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('birthday',['label'=>'生年月日']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('password',['label'=>'パスワード']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('role',['label'=>'会員種別']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('add_date',['label'=>'入会年月日']) ?></th>
      <th scope="col"><?= $this->Paginator->sort('delete_date',['label'=>'退会年月日']) ?></th>
      <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $this->Number->format($user->id) ?></td>
        <td><?= h($user->last_name) ?></td>
        <td><?= h($user->first_name) ?></td>
        <td><?= h($user->postal) ?></td>
        <td><?= h($user->address) ?></td>
        <td><?= h($user->tel) ?></td>
        <td><?= h($user->email) ?></td>
        <td><?= h($user->birthday) ?></td>
        <td><?= h($user->password) ?></td>
        <td><?= h($user->role) ?></td>
        <td><?= h($user->add_date) ?></td>
        <td><?= h($user->delete_date) ?></td>
        <td class="actions">
          <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
          <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
          <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
        </td>
      </tr>
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
  <button class="under_button">登録</button>


  <button class="under_button">情報検索画面へ</button>
</div>
