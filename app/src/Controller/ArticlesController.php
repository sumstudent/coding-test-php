<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index','view']);
    }

    public function index()
    {
        $articles = $this->Articles->find()->toArray(); // Fetches all articles as an array
        return $this->jsonResponse(200, $articles);
    }

    public function view($id)
    {
        $article = $this->Articles->get($id); //Fetches the article by id
        return $this->jsonResponse(200, $article);
    }

    public function add()
    {
        $article = $this->Articles->newEntity();

        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->user_id = $this->Auth->user('id'); // Assign the current user's ID

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the article. Please, try again.'));
        }

        $this->set(compact('article'));
    }
}
