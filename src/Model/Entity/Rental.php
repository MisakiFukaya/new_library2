<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rental Entity
 *
 * @property int $id
 * @property int $bookstate_id
 * @property int $user_id
 * @property int $reservation_id
 * @property \Cake\I18n\FrozenTime $rent_date
 * @property \Cake\I18n\FrozenTime $return_date
 * @property int $pressing_letter
 *
 * @property \App\Model\Entity\Bookstate $bookstate
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Reservation $reservation
 */
class Rental extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'bookstate_id' => true,
        'user_id' => true,
        'reservation_id' => true,
        'rent_date' => true,
        'limit_date'=>true,
        'return_date' => true,
        'pressing_letter' => true,
        'bookstate' => true,
        'user' => true,
        'reservation' => true
    ];
}
