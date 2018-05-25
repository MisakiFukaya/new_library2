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

       /* @okabe l66~76*/
       /*$books = $this->Books->newEntity();
       if ($this->request->isPost()) {
       $book_id = $this->requestdata[''][''];
       $bookstate_entity =['book_id'=>$book_id,'arrival_date'=>$arr_date];
       $bookstate = $this->Bookstates->patchEntity($bookstate, $this->request->getData());
       $book = $this->Books->patchEntity($books, $this->request->getData());
       if ($this->Bookstates->save($bookstate) && $this->Books->save($books)) {*/

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

           $bookstate_entity =['book_id'=>$book_id,'arrival_date'=>$arrival_date,'delete_date'=>$delete_date,'state'=>$state];
           $bookstate = $this->Bookstates->patchEntity($bookstate, $bookstate_entity);

           if ($this->Bookstates->save($bookstate)) {
             $this->Flash->success(__('bookstateだけに書き込みました'));
             return $this->redirect(['action' => 'index']);
           }
         }
       }
       // $books = $this->Bookstates->Books->find('list', ['limit' => 200]);
       // $categories = $this->Books->Categories->find('list', ['limit' => 200]);
       // $publishers = $this->Books->Publishers->find('list', ['limit' => 200]);

       $this->set(compact('bookstate','book'));
     }

    /**
     * Edit method
     *
     * @param string|null $id Bookstate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookstate = $this->Bookstates->get($id, [
            'contain' => ['Books']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookstate = $this->Bookstates->patchEntity($bookstate, $this->request->getData());
            if ($this->Bookstates->save($bookstate)) {
                $this->Flash->success(__('The bookstate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookstate could not be saved. Please, try again.'));
        }
        $books = $this->Bookstates->Books->find('list', ['limit' => 200]);
        $categories = $this->Books->Categories->find('list', ['limit' => 200]);
        $publishers = $this->Books->Publishers->find('list', ['limit' => 200]);
        $this->set(compact('bookstate', 'books', 'categories', 'publishers'));
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
        if ($this->request->isGet()){
          $find = $this->request->data['Users']['find'];

  //@tani l154~217
        /*  $condition = ['conditions'=> ['or'=>['name like'=>'%'.$find.'%','isbn like'=>'%'.$find.'%']],
                        'order'=>['isbn'=>'asc']];
          $data = $this->Bookstates->find('all',$condition)->join([
            'book' => [
            'table' => 'Books',
            'type' => 'INNER',
            'conditions' => 'book.id = Bookstates.book_id',
        ],
        'publisher' => [
            'table' => 'Publishers',
            'type' => 'INNER',
            'conditions' => 'publisher.id = book.publisher_id',
        ],
        'category' => [
            'table' => 'Categories',
            'type' => 'INNER',
            'conditions' => 'category.id = book.category_id',
        ]
        ])->select([
          'isbn'=>'book.isbn',
          'category'=>'category.category',
          'name'=>'book.name',
          'author'=>'book.author',
          'publisher'=>'publisher.publisher',
          'publish_date'=>'book.publish_date',
          'book_id'=>'book.id',
          'arrival_date'=>'bookstates.arrival_date',
          'delete_date'=>'bookstates.delete_date',
          'state'=>'bookstates.state',

          ])->toArray();
        }else {
          $data = $this->Bookstates->find()->join([
            'book' => [
            'table' => 'Books',
            'type' => 'INNER',
            'conditions' => 'book.id = Bookstates.book_id',
        ],
        'publisher' => [
            'table' => 'Publishers',
            'type' => 'INNER',
            'conditions' => 'publisher.id = book.publisher_id',
        ],
        'category' => [
            'table' => 'Categories',
            'type' => 'INNER',
            'conditions' => 'category.id = book.category_id',
        ]
        ])->select([
          'isbn'=>'book.isbn',
          'category'=>'category.category',
          'name'=>'book.name',
          'author'=>'book.author',
          'publisher'=>'publisher.publisher',
          'publish_date'=>'book.publish_date',
          'book_id'=>'book.id',
          'arrival_date'=>'bookstates.arrival_date',
          'delete_date'=>'bookstates.delete_date',
          'state'=>'bookstates.state',

          ])->toArray();
        }
        $this->set('bookstates',$data);*/


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
