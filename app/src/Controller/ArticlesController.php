<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    public function index()
    {
        $articles = $this->Articles->find()->toArray(); // Fetches all articles as an array
        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']); //into the route for all articles
    }

    public function view($id)
    {
        $article = $this->Articles->get($id); //Fetches the article by id
        $this->set(compact('article'));
        $this->viewBuilder()->setOption('serialize', ['article']); //into the route for single article
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
