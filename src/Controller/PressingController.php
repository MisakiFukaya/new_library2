<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
*
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/

class PressingController extends AppController
{
  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function initialize(){
    $this->viewBuilder()->setLayout('main');
    $this->loadModel('Rentals');
    $this->loadModel('Users');
    $this->loadModel('Books');
    $this->loadModel('Bookstates');
    $this->loadComponent('Paginator');
  }


  public function index(){
    $this->paginate = [
      'contain' => ['Bookstates', 'Users', 'Reservations']
    ];
    $this->delay_check;

    $rentals = $this->Rentals->find('all');
    $this->delay_check($this->Rentals->id);
    
    $this->set(compact('rentals'));

  }

  private function delay_check($rental_id){//rentals_idより延滞判定 返り値 配列 delay=>boolean diff_days=>返却期限との差
    $limit_date = $this->Rentals->get($rental_id)->limit_date;  //rental_idに対応したlimit_dateを取得
    $today_date = Time::now();

    $diff_days = $limit_date->diff($today_date)->days;

    if($limit_date>$today_date){ //延滞していない
      $return = ['delay'=>false,'diff_days'=>$diff_days];  //連想配列を返す、diff_daysは日数

    }else{ //延滞中
      $return = ['delay'=>true,'diif_days'=>$diff_days]; //delayがtrueの連想配列、diff_daysは日数

    }
    return $return;
  }

} //classの閉じ括弧
