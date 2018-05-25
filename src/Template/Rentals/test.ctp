<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\User $user
*/
?>
<div id="right_top">
  <h1>貸出</h1>
  <?=$this->Form->create(null,['type'=>'post','url'=>['controller'=>'Rentals','action'=>'test']]) ?>
  <?=$this->Form->text('Rentals.find') ?>
  <?=$this->Form->button('検索',['type'=>'submit']) ?>
  <?=$this->Form->end() ?>
  <?php echo $rental_allow.'冊借りることが出来ます' ?>
</div>
<div id="right_center">
  <?=$this->Flash->render()?>
  <br>
  <pre>
    <?php  var_dump($dump);?>
  </pre>


  <table id="test_table" border="1">
    <?php if (!empty($user)): ?>
      <tr>
        <th scope="row"><?= __('ユーザーId') ?></th>
        <td><?= $this->Number->format($user->id) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('名前') ?></th>
        <td><?= h($user->last_name) ?><?= h($user->first_name) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('郵便番号') ?></th>
        <td><?= h($user->postal) ?><?= h($user->address) ?></td>

      </tr>
      <tr>
        <th scope="row"><?= __('電話番号') ?></th>
        <td><?= h($user->tel) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('Email') ?></th>
        <td><?= h($user->email) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('パスワード') ?></th>
        <td><?= h($user->password) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('会員種別') ?></th>
        <td><?= h($user->role) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('生年月日') ?></th>
        <td><?= h($user->birthday->format('Y年m月d日')) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('入会年月日') ?></th>
        <td><?= h($user->add_date->format('Y年m月d日')) ?></td>
      </tr>
      <tr>
        <th scope="row"><?= __('退会年月日') ?></th>
        <td><?= h($user->delete_date) ?></td>
      </tr>
    <?php else:?>
      <td>idに対応する会員情報がありません</td>
    <?php endif;?>
  </table>

  <h4><?= __('貸出情報') ?></h4>

  <table class="test_table" border="1">
    <?php if (!empty($user->rentals)): ?>

      <tr>
        <th scope="col"><?= __('貸出Id') ?></th>
        <th scope="col"><?= __('資料台帳Id') ?></th>
        <th scope="col"><?= __('会員番号') ?></th>
        <th scope="col"><?= __('予約Id') ?></th>
        <th scope="col"><?= __('貸出日') ?></th>
        <th scope="col"><?= __('返却期限') ?></th>
        <th scope="col"><?= __('返却日') ?></th>
        <th scope="col"><?= __('督促状有無') ?></th>
        <th scope="col"><?= __('状態') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php $i=0; ?>
      <?php foreach ($user->rentals as $rentals): ?>
        <tr>
          <td><?= h($rentals->id) ?></td>
          <td><?= h($rentals->bookstate_id) ?></td>
          <td><?= h($rentals->user_id) ?></td>
          <td><?= h($rentals->reservation_id) ?></td>
          <td><?= h($rentals->rent_date->format('Y年m月d日')) ?></td>
          <td><?= h($rentals->limit_date->format('Y年m月d日')) ?></td>
          <td><?= h($rentals->return_date) ?></td>
          <td>
            <?php if($rentals->pressing_letter>0){
              echo "有";
            }else{
              echo "無";
            }
            ?>
          </td>
          <td><?php echo $return_check[$i]; ?></td>
          <td class="actions">
            <?= $this->Html->link(__('詳細'), ['controller' => 'Rentals', 'action' => 'view', $rentals->id]) ?>
            <?php echo "<br>"; ?>
            <?= $this->Html->link(__('変更'), ['controller' => 'Rentals', 'action' => 'edit', $rentals->id]) ?>
            <?php echo "<br>"; ?>
            <?= $this->Form->postLink(__('削除'), ['controller' => 'Rentals', 'action' => 'delete', $rentals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentals->id)]) ?>
          </td>
          <?php $i++; ?>
        </tr>
      <?php endforeach; ?>
    <?php else:?>
      <td>貸出情報はありません</td>
    <?php endif; ?>
  </table>

  <h4><?= __('予約情報') ?></h4>
  <table class="test_table" border="1">
    <?php if (!empty($user->reservations)): ?>
      <tr>
        <th scope="col"><?= __('予約Id') ?></th>
        <th scope="col"><?= __('会員番号') ?></th>
        <th scope="col"><?= __('資料台帳Id') ?></th>
        <th scope="col"><?= __('資料目録Id') ?></th>
        <th scope="col"><?= __('予約日') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php foreach ($user->reservations as $reservations): ?>
        <tr>
          <td><?= h($reservations->id) ?></td>
          <td><?= h($reservations->user_id) ?></td>
          <td><?= h($reservations->bookstate_id) ?></td>
          <td><?= h($reservations->book_id) ?></td>
          <td><?= h($reservations->date->format('Y年m月d日')) ?>
          </td>
          <td class="actions">
            <?= $this->Html->link(__('詳細'), ['controller' => 'Reservations', 'action' => 'view', $reservations->id]) ?>
            <?php echo "<br>"; ?>
            <?= $this->Html->link(__('変更'), ['controller' => 'Reservations', 'action' => 'edit', $reservations->id]) ?>
            <?php echo "<br>"; ?>
            <?= $this->Form->postLink(__('削除'), ['controller' => 'Reservations', 'action' => 'delete', $reservations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservations->id)]) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else:?>
      <td>予約情報はありません</td>
    <?php endif; ?>
  </table>


</div>

<div id="right_under">
  <?=$this->Form->create(null,['type'=>'post','url'=>['controller'=>'Rentals','action'=>'test']]) ?>
  <?=$this->Form->button('登録',['type'=>'submit']) ?>
  <?=$this->Form->end() ?>

<div class="users view large-9 medium-8 columns content">




</div>
