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
        $this->request->allowMethod('post');
        $requestData = $this->request->input('json_decode', true);
        $article = $this->Articles->newEntity($requestData);

        if ($this->Articles->save($article)) {
            return $this->jsonResponse(201, ['message' => 'The article has been saved.']);
        } else {
            return $this->jsonResponse(400, ['error' => 'Unable to add the article.']);
        }
    }

    public function edit($id = null) {
        $article = $this->Articles->get($id);

        if ($this->request->is(['post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            if ($this->Articles->save($article)) {
                return $this->jsonResponse(200, ['message' => 'The article has been updated.']);
            } else {
                return $this->jsonResponse(400, ['error' => 'Unable to update the article.']);
            }
        }
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
    
        $article = $this->Articles->find()->where(['id' => $id])->first();
    
        if (!$article) {
            return $this->jsonResponse(404, ['error' => 'Article not found']);
        }
    
        if ($this->Articles->delete($article)) {
            return $this->jsonResponse(200, ['message' => 'The article has been deleted.']);
        } else {
            return $this->jsonResponse(400, ['error' => 'Unable to delete the article.']);
        }
    }
}
