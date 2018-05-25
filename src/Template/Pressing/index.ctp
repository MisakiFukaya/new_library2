<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rental[]|\Cake\Collection\CollectionInterface $rentals
 */
?>
<div id="right_top">
  <h3>督促状管理画面</h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Rental'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div id="right_center">
    <h3><?= __('貸出情報') ?></h3>
    <table id="test_table" border="1">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id',) ?></th>
                <th scope="col"><?= $this->Paginator->sort('bookstate_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reservation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rent_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('return_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('limit_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pressing_letter') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentals as $rental):
              ?>
            <tr>
                <td><?= $this->Number->format($rental->id) ?></td>
                <td><?= h($rental->id) ?></td>
                <td><?= h($rental->bookstate_id) ?></td>
                <td><?= h($rental->last_name) ?></td>
                <td><?= h($rental->first_name) ?></td>
                <td><?= h($rental->user_id) ?></td>
                <td><?= h($rental->rent_date) ?></td>
                <td><?= h($rental->return_date) ?></td>
                <td><?= h($rental->limit_date) ?></td>
                <td><?= $this->Number->format($rental->pressing_letter) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rental->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rental->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rental->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rental->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
