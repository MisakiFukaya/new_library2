<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookstate $bookstate
 */
?>
<div id="right_top">
  <h1>資料詳細</h1>

<br>


</div>
<div id="right_center">
  <?= $this->Form->create($bookstate,['type'=>'post','url'=>['controller'=>'Bookstates','action'=>'view']]) ?>


    <table border='1' id="test_table">
        <tr>
            <th scope="col"><?= __('タイトル') ?></th>
            <td><?= $bookstate->has('book') ? $this->Html->link($bookstate->book->name, ['controller' => 'Books', 'action' => 'view', $bookstate->book->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="col"><?= __('蔵書冊数') ?></th>
            <td><?= $this->Number->format($bookstate->state) ?></td>
        </tr>
        <tr>
            <th scope="col"><?= __('入荷年月日') ?></th>
            <td><?= h($bookstate->arrival_date) ?></td>
        </tr>

        <tr>
            <th scope="col"><?= __('廃棄年月日') ?></th>
            <td><?= h($bookstate->delete_date) ?></td>
        </tr>
        <tr>
            <th scope="col"><?= __('出版社ID') ?></th>
            <td><?= $bookstate->has('book') ? $this->Html->link($bookstate->book->publisher_id, ['controller' => 'Books', 'action' => 'view', $bookstate->book->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="col"><?= __('Isbn番号') ?></th>
            <td><?= $bookstate->has('book') ? $this->Html->link($bookstate->book->isbn, ['controller' => 'Books', 'action' => 'view', $bookstate->book->id]) : '' ?> </td>
        </tr>
        <tr>
            <th scope="col"><?= __('著者名') ?></th>
            <td><?= $bookstate->has('book') ? $this->Html->link($bookstate->book->author, ['controller' => 'Books', 'action' => 'view', $bookstate->book->id]) : '' ?> </td>
        </tr>
        <tr>
            <th scope="col"><?= __('出版日') ?></th>
            <td><?= $bookstate->has('book') ? $this->Html->link($bookstate->book->publish_date, ['controller' => 'Books', 'action' => 'view', $bookstate->book->id]) : '' ?> </td>
        </tr>

    </table>
    <div class="related">
        <h4><?= __('Related Rentals') ?></h4>
        <?php if (!empty($bookstate->rentals)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Bookstate Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Reservation Id') ?></th>
                <th scope="col"><?= __('Rent Date') ?></th>
                <th scope="col"><?= __('Return Date') ?></th>
                <th scope="col"><?= __('Pressing Letter') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($bookstate->rentals as $rentals): ?>
            <tr>
                <td><?= h($rentals->id) ?></td>
                <td><?= h($rentals->bookstate_id) ?></td>
                <td><?= h($rentals->user_id) ?></td>
                <td><?= h($rentals->reservation_id) ?></td>
                <td><?= h($rentals->rent_date) ?></td>
                <td><?= h($rentals->return_date) ?></td>
                <td><?= h($rentals->pressing_letter) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Rentals', 'action' => 'view', $rentals->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Rentals', 'action' => 'edit', $rentals->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rentals', 'action' => 'delete', $rentals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentals->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reservations') ?></h4>
        <?php if (!empty($bookstate->reservations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Bookstate Id') ?></th>
                <th scope="col"><?= __('Book Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($bookstate->reservations as $reservations): ?>
            <tr>
                <td><?= h($reservations->id) ?></td>
                <td><?= h($reservations->user_id) ?></td>
                <td><?= h($reservations->bookstate_id) ?></td>
                <td><?= h($reservations->book_id) ?></td>
                <td><?= h($reservations->date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Reservations', 'action' => 'view', $reservations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Reservations', 'action' => 'edit', $reservations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reservations', 'action' => 'delete', $reservations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

<div id="right_under">
  <?= $this->Form->create($bookstate,['type'=>'post','url'=>['controller'=>'Bookstates','action'=>'edit']]) ?>

  <?= $this->Form->button(__('編集'),['class'=>'under_button']) ?>
  <?= $this->Form->end() ?>


  <button class="under_button">情報検索画面へ</button>
</div>
