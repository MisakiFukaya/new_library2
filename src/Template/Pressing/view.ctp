<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rental $rental
 */
?>

<div class="rentals view large-9 medium-8 columns content">
    <h3><?= h($rental->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bookstate') ?></th>
            <td><?= $rental->has('bookstate') ? $this->Html->link($rental->bookstate->id, ['controller' => 'Bookstates', 'action' => 'view', $rental->bookstate->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $rental->has('user') ? $this->Html->link($rental->user->id, ['controller' => 'Users', 'action' => 'view', $rental->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reservation') ?></th>
            <td><?= $rental->has('reservation') ? $this->Html->link($rental->reservation->id, ['controller' => 'Reservations', 'action' => 'view', $rental->reservation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($rental->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pressing Letter') ?></th>
            <td><?= $this->Number->format($rental->pressing_letter) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rent Date') ?></th>
            <td><?= h($rental->rent_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Return Date') ?></th>
            <td><?= h($rental->return_date) ?></td>
        </tr>
    </table>
</div>
