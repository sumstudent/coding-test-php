<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function index()
    {
        // Fetch all articles from the database
        $articles = $this->Articles->find()->toArray();

        // Check if any articles were found
        if ($articles === null || empty($articles)) {
            // Return a 404 Not Found response
            return $this->jsonResponse(404, ['error' => 'No articles found']);
        }

        // Respond with a JSON representation of the articles and a 200 OK status
        return $this->jsonResponse(200, $articles);
    }

    public function view($id)
    {
        // Fetch the article from the database by its ID
        $article = $this->Articles->get($id);

        // Check if the article was found
        if ($article === null) {
            // Return a 404 Not Found response
            return $this->jsonResponse(404, ['error' => 'Article not found']);
        }

        // Respond with a JSON representation of the article and a 200 OK status
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
