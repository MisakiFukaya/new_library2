<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Bookstates Controller
*
* @property \App\Model\Table\BookstatesTable $Bookstates
*
* @method \App\Model\Entity\Bookstate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class BookstatesController extends AppController
{
  public function initialize(){
    $this->viewBuilder()->setLayout('main');
    $this->loadComponent('RequestHandler');
    $this->loadComponent('Flash');
    $this->loadModel('Books');
    $this->loadModel('Publishers');
    $this->loadModel('Categories');

  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $this->paginate = [
      'contain' => ['Books']
    ];
    $bookstates = $this->paginate($this->Bookstates);

    $this->set(compact('bookstates'));
  }

  /**
  * View method
  *
  * @param string|null $id Bookstate id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $bookstate = $this->Bookstates->get($id, [
      'contain' => ['Books', 'Rentals', 'Reservations']
    ]);

    $this->set('bookstate', $bookstate);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $bookstate = $this->Bookstates->newEntity();
    $book = $this->Books->newEntity();
    if ($this->request->isPost()) {
      $isbn = $this->request->data['Bookstates']['isbn'];
      $book_ids=$this->Books->find('all',['conditions' => ['isbn' => $isbn]]);
      foreach ($book_ids as $book_ids) {
        $book_id= $book_ids->id;
      }

      if (empty($book_id)) {
        //ISBN番号がない場合の処理→bookstatesとbooksに値を保存
        $isbn = $this->request->data['Bookstates']['isbn'];
        $category_id = $this->request->data['Bookstates']['category_id'];
        $name = $this->request->data['Bookstates']['name'];
        $author = $this->request->data['Bookstates']['author'];
        $publisher = $this->request->data['Bookstates']['publisher'];
        $publish_date = $this->request->data['Bookstates']['publish_date'];
        $book_entity =['isbn'=>$isbn,'category_id'=>$category_id,'name'=>$name,'author'=>$author,'publisher'=>$publisher,'publish_date'=>$publish_date];

        $arrival_date = $this->request->data['Bookstates']['arrival_date'];
        $delete_date = $this->request->data['Bookstates']['delete_date'];
        $state = $this->request->data['Bookstates']['state'];
        $bookstate_entity =['arrival_date'=>$arrival_date,'delete_date'=>$delete_date,'state'=>$state];

        $book = $this->Books->newEntity();
        $bookstate = $this->Bookstates->newEntity();
        $book = $this->Books->patchEntity($book, $book_entity);
        $bookstate = $this->Bookstates->patchEntity($bookstate, $bookstate_entity);

        if ($this->Books->save($book) && $this->Bookstates->save($bookstate)) {
          $this->Flash->success(__('bookとstateに書き込みました'));
          return $this->redirect(['action' => 'index']);
        }
        $bookstate = $this->request->data['Bookstates']['delete_date'];
      }else {
        //ISBN番号がある場合の処理→bookstatesだけに値を保存

        $arrival_date = $this->request->data['Bookstates']['arrival_date'];
        $delete_date = $this->request->data['Bookstates']['delete_date'];
        $state = $this->request->data['Bookstates']['state'];


      }
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookstate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $id=1;
        $bookstate = $this->Bookstates->get($id, [
            'contain' => ['Books']
        ]);
        $test_post=$this->request->getData('bookstate_id');
        $new_test=$this->request->getData();
        /*

        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookstate = $this->Bookstates->patchEntity($bookstate, $this->request->getData());
            if ($this->Bookstates->save($bookstate)) {
                $this->Flash->success(__('The bookstate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookstate could not be saved. Please, try again.'));
        }*/
        $books = $this->Bookstates->Books->find('list', ['limit' => 200]);
        $categories = $this->Books->Categories->find('list', ['limit' => 200]);
        $publishers = $this->Books->Publishers->find('list', ['limit' => 200]);
        $this->set(compact('bookstate', 'books', 'categories', 'publishers','test_post','new_test'));
.
    }

  /**
  * Edit method
  *
  * @param string|null $id Bookstate id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit()
  {
    if ($this->request->isPost()) {
      $this->request->getData();
      $new_post = $this->request->getData('bookstate_id');
      foreach ($new_post as $id) {
        $bookstate[] = $this->Bookstates->get($id, [
          'contain' => ['Books']
        ]);
      }
      $new_post=$this->request->getData('bookstate_id');
      $new_test=$this->request->getData();
      // if ($this->request->is(['patch', 'post', 'put'])) {
      //     $bookstate = $this->Bookstates->patchEntity($bookstate, $this->request->getData());
      //     if ($this->Bookstates->save($bookstate)) {
      //         $this->Flash->success(__('The bookstate has been saved.'));
      //
      //         return $this->redirect(['action' => 'index']);
      //     }
      //     $this->Flash->error(__('The bookstate could not be saved. Please, try again.'));
      // }
      $books = $this->Bookstates->Books->find('list', ['limit' => 200]);
      $categories = $this->Books->Categories->find('list', ['limit' => 200]);
      $publishers = $this->Books->Publishers->find('list', ['limit' => 200]);
      $this->set(compact('bookstate', 'books', 'categories', 'publishers','new_test','new_post'));
    }


 
  }
  public function done()
  {
    //$category_idと$publisherが取れていない・・・
      $new_test = $this->request->getData();
      foreach ($new_test['book'] as $value) {
        $isbn = $value['isbn'];
        $category_id = $value['category_id'];
        $name = $value['name'];
        $author = $value['author'];
        $publisher = $value['publishers']->publisher;
        $publish_date = $value['publish_date'];
        $book_entity =['isbn'=>$isbn,'category_id'=>$category_id,'name'=>$name,'author'=>$author,'publisher'=>$publisher,'publish_date'=>$publish_date];
$new_post[] = $book_entity;
        $arrival_date = $value['arrival_date'];
        $delete_date = $value['delete_date'];
        $state = $value['state'];
        $bookstate_entity =['arrival_date'=>$arrival_date,'delete_date'=>$delete_date,'state'=>$state];

        $book = $this->Books->newEntity();
        $bookstate = $this->Bookstates->newEntity();

      }
      if ($this->request->is(['patch', 'post', 'put'])) {
          $book = $this->Books->patchEntity($book, $book_entity);
          $bookstate = $this->Books->patchEntity($bookstate, $bookstate_entity);
        if ($this->Books->save($book) && $this->Bookstates->save($bookstate)) {
          $this->Flash->success(__('The bookstate has been saved.'));
          return $this->redirect(['action' => 'index']);

        }else {
          $this->Flash->error(__('The bookstate could not be saved. Please, try again.'));
        }
    $books = $this->Bookstates->Books->find('list', ['limit' => 200]);
    $categories = $this->Books->Categories->find('list', ['limit' => 200]);
    $publishers = $this->Books->Publishers->find('list', ['limit' => 200]);
    $this->set(compact('bookstate', 'books', 'categories', 'publishers','new_test','new_post'));
  }
}
  /**
  * Delete method
  *
  * @param string|null $id Bookstate id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $bookstate = $this->Bookstates->get($id);
    if ($this->Bookstates->delete($bookstate)) {
      $this->Flash->success(__('The bookstate has been deleted.'));
    } else {
      $this->Flash->error(__('The bookstate could not be deleted. Please, try again.'));
    }


    return $this->redirect(['action' => 'index']);
  }

  public function search()
  {
    if ($this->request->isPost()){
      $find = $this->request->data['Bookstates']['find'];


      $condition = ['conditions'=> ['or'=>['name like'=>'%'.$find.'%','isbn like'=>'%'.$find.'%']],
      'order'=>['isbn'=>'asc']];
      $bookstates = $this->Bookstates->find('all',$condition)->contain(['Books' => ["Publishers","Categories"],'Books'])->toArray();
      $count[] = $this->Bookstates->find('all',$condition)->contain('Books')->count();
      //$books=$this->Books->find('all',$condition)->contain('Publishers');
    }else {
      $bookstates = $this->Bookstates->find('all')->contain(['Books' => ["Publishers","Categories"],'Books'])->toArray();

      foreach ($bookstates as $bookstate) {
        $condition = ['conditions'=>['book_id'=>$bookstate->book_id]];
        $count[] = $this->Bookstates->find('all',$condition)->contain('Books')->count();
      }
      //$count = $this->Bookstates->find('all')->contain('Books')->count();
      //$books=$this->Books->find('all')->contain('Publishers')->toArray();
      //$books=$this->Books->find('all')->contain('Books','Publishers','Categories');
    }
    $data=$this->paginate($this->Bookstates->find());


    $this->set(compact('bookstates', 'count'));

  }

}
