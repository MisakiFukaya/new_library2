<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\Time;

class RentalsController extends AppController
{
  public function initialize(){
    $this->loadComponent('Flash');
    $this->viewBuilder()->setLayout('main');
    $this->loadModel('Users');
    $this->loadModel('Books');
    $this->loadModel('Bookstates');
  }

  private function limit_date($bookstate_id){//bookstate_idより返却期限算出 返り値 DATETIME
    $publish_date = $this->Bookstates->get($bookstate_id,['contain'=>'Books'])->book->publish_date;
    $newbook_limit = $publish_date->modify('+3 month');
    $today_date = Time::now();

    if($newbook_limit > $rent_date ){
      $limit_date = $today_date->modify('+10 days');
    }else{
      $limit_date = $today_date->modify('+15 days');
    }
    return $limit_date;
  }

  private function delay_check($rental_id){//rentals_idより延滞判定 返り値 連想配列 delay=>boolean diff_days=>返却期限との差
    $limit_date = $this->Rentals->get($rental_id)->limit_date;
    $today_date = Time::now();

    $diff_days = $limit_date->diff($today_date)->days;

    if($limit_date>$today_date){//正常
      $return = ['delay'=>false,'diff_days'=>$diff_days];

    }else{//延滞中
      $return = ['delay'=>true,'diif_days'=>$diff_days];

    }
    return $return;
  }

  private function rental_check($return_check){


  }


  public function index()
  {


    if($this->request->is('post')){

      $query = $this->request->data['Rentals']['find'];
      $condition = ['conditions'=>['Users.id'=>$query],'contain'=>['Users']];
      $rentals = $this->Rentals->find('all',$condition);
      //$users = $this->paginate($this->Users);
      $this->set(compact('rentals','users'));
      //echo "<pre>".print_r($this->set(compact('rentals')))."</pre>";


    }else{
      //$condition = ['contain' => ['Bookstates', 'Users', 'Reservations']];
      //$data = $this->Rentals->find('all')->contain('Users');
    }

    $params = array(
      'return_date' => array(
        '' >= 5,
      )
    );

    $count = $this->Rentals->find()->where(['Rentals.return_date'=>null])->count();
    $this->set(compact('rentals','users','count'));

  }




  public function test(){
    if($this->request->is('post')){

      $query = $this->request->data['Rentals']['find'];
      $user = $this->Users->get($query, [
        'contain' => ['Rentals', 'Reservations']
      ]);//idより

      $rental_count=0;//貸出中カウント
      $entai_count=0;//延滞数
      $rental_allow=5;

      foreach ($user->rentals as $rentals) {
        if(empty($rentals->return_date)){
          $rental_count++;
        }
        $dump[]=$this->delay_check($rentals->id);



        if($this->delay_check($rentals->id)['delay']){

          $return_check[]="延滞中";
          $entai_count++;
          $rental_count--;
        }else{
          $return_check[]="期間内";

        }


        /*

        $rentbook = $this->Bookstates->get($rentals->bookstate_id,['contain'=>'Books'])->book;
        //$publish_date[]=$rentbook->publish_date;
        $shikan = $rentbook->publish_date->modify('+3 month');

        $rent_date=$rentals->rent_date;
        if($shikan > $rent_date ){
        if($rentals->rent_date->wasWithinLast(10)){
        if(empty($rentals->return_date)){
        $return_check[]="レンタル期間内です";
      }else{
      $return_check[]="返却済";
    }
  }else{
  if(empty($rentals->return_date)){
  $return_check[]="<font color='red'>延滞中</font>";
  $entai_count++;
  $rental_count--;
}else{
$return_check[]="返却済";
}
}
}else{



}*/

$rental_allow=5-$rental_count;

}

if($entai_count>0){
  $rental_allow=0;
  $this->Flash->error(__('貸出期間を超過している本が存在しています。'));
}


$this->set(compact('user', 'rental_allow','return_check','dump','rentbook'));
}else{
  //$this->set('user', $user);
  //$condition = ['contain' => ['Bookstates', 'Users', 'Reservations']];
  //$data = $this->Rentals->find('all')->contain('Users');
}



}
/**
* View method
*
* @param string|null $id Rental id.
* @return \Cake\Http\Response|void
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
public function view($id = null)
{
  $rental = $this->Rentals->get($id, [
    'contain' => ['Bookstates', 'Users', 'Reservations']
  ]);
  $this->set('rental', $rental);
}
/**
* Add method
*
* @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
*/
public function add()
{
  $rental = $this->Rentals->newEntity();
  if ($this->request->is('post')) {
    $rental = $this->Rentals->patchEntity($rental, $this->request->getData());
    if ($this->Rentals->save($rental)) {
      $this->Flash->success(__('貸出が完了しました。'));
      return $this->redirect(['action' => 'index']);
    }
    $this->Flash->error(__('貸出に失敗しました。始めからやり直して下さい。'));
  }
  $bookstates = $this->Rentals->Bookstates->find('list', ['limit' => 200]);
  $users = $this->Rentals->Users->find('list', ['limit' => 200]);
  $reservations = $this->Rentals->Reservations->find('list', ['limit' => 200]);
  $this->set(compact('rental', 'bookstates', 'users', 'reservations'));
}

public function search(){
  //下のコード何？
  $this->paginate = [
    'contain' => ['Bookstates', 'Users', 'Reservations']
  ];
  $rentals = $this->paginate($this->Rentals);

  $this->set(compact('rentals'));
}

public function returncheck(){

  if($this->request->is('post')){

    $query = $this->request->data['Rentals']['find'];
    $condition = ['conditions'=>['Users.id'=>$query],'contain'=>['Users']];
    $rentals = $this->Rentals->find('all',$condition);
    //$users = $this->paginate($this->Users);
    $this->set(compact('rentals','users'));
    //echo "<pre>".print_r($this->set(compact('rentals')))."</pre>";


  }else{
    //$condition = ['contain' => ['Bookstates', 'Users', 'Reservations']];
    //$data = $this->Rentals->find('all')->contain('Users');
  }
}

/**
* Edit method
*
* @param string|null $id Rental id.
* @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
* @throws \Cake\Network\Exception\NotFoundException When record not found.
*/
public function edit($id = null)
{
  $rental = $this->Rentals->get($id, [
    'contain' => []
  ]);
  if ($this->request->is(['patch', 'post', 'put'])) {
    $rental = $this->Rentals->patchEntity($rental, $this->request->getData());
    if ($this->Rentals->save($rental)) {
      $this->Flash->success(__('The rental has been saved.'));
      return $this->redirect(['action' => 'index']);
    }
    $this->Flash->error(__('The rental could not be saved. Please, try again.'));
  }
  $bookstates = $this->Rentals->Bookstates->find('list', ['limit' => 200]);
  $users = $this->Rentals->Users->find('list', ['limit' => 200]);
  $reservations = $this->Rentals->Reservations->find('list', ['limit' => 200]);
  $this->set(compact('rental', 'bookstates', 'users', 'reservations'));
}
/**
* Delete method
*
* @param string|null $id Rental id.
* @return \Cake\Http\Response|null Redirects to index.
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
public function delete($id = null)
{
  $this->request->allowMethod(['post', 'delete']);
  $rental = $this->Rentals->get($id);
  if ($this->Rentals->delete($rental)) {
    $this->Flash->success(__('The rental has been deleted.'));
  } else {
    $this->Flash->error(__('The rental could not be deleted. Please, try again.'));
  }
  return $this->redirect(['action' => 'index']);
}

}
