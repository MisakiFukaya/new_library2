<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reservations Controller
 *
 * @property \App\Model\Table\ReservationsTable $Reservations
 *
 * @method \App\Model\Entity\Reservation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReservationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize(){
       $this->viewBuilder()->setLayout('main');
     }

    public $components = array('Paginator', 'Flash');

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Bookstates', 'Books', 'Rentals']
        ];

        //会員IDでの検索処理
        if($this->request->is('post')){
            $find = $this->request->getData('id');
            if(empty($find)){
            $reservations = $this->Reservations->find('all');
          }else{
            $reservations = $this->Reservations->find()->where(['user_id'=>$find]);
          }
        }else{
            $reservations = $this->Reservations->find('all');
        }
        //ここまで追加

        $reservations = $this->paginate($reservations);

        $this->set(compact('reservations'));
    }

    /**
     * View method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reservation = $this->Reservations->get($id, [
            'contain' => ['Users', 'Bookstates', 'Books', 'Rentals']
        ]);

        $this->set('reservation', $reservation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reservation = $this->Reservations->newEntity();
        if ($this->request->is('post')) {
            $reservation = $this->Reservations->patchEntity($reservation, $this->request->getData());
            if ($this->Reservations->save($reservation)) {
                $this->Flash->success(__('予約台帳に予約情報を記録しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('予約に失敗しました。もう一度お試しください。'));
        }
        $users = $this->Reservations->Users->find('list', ['limit' => 200]);
        $bookstates = $this->Reservations->Bookstates->find('list', ['limit' => 200]);
        $books = $this->Reservations->Books->find('list', ['limit' => 200]);
        $this->set(compact('reservation', 'users', 'bookstates', 'books'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reservation = $this->Reservations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reservation = $this->Reservations->patchEntity($reservation, $this->request->getData());
            if ($this->Reservations->save($reservation)) {
                $this->Flash->success(__('予約情報は正常に変更されました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('予約情報の変更に失敗しました。もう一度お試しください。'));
        }
        $users = $this->Reservations->Users->find('list', ['limit' => 200]);
        $bookstates = $this->Reservations->Bookstates->find('list', ['limit' => 200]);
        $books = $this->Reservations->Books->find('list', ['limit' => 200]);
        $this->set(compact('reservation', 'users', 'bookstates', 'books'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reservation = $this->Reservations->get($id);
        if ($this->Reservations->delete($reservation)) {
            $this->Flash->success(__('予約は正常に削除されました。'));
        } else {
            $this->Flash->error(__('削除に失敗しました。もう一度お試しください。'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
