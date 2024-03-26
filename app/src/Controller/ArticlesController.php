<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{

    /**
     * beforeFilter method
     *
     * @param \Cake\Event\EventInterface $event The event instance
     * @return void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * index method
     *
     * @return \Cake\Http\Response Returns the JSON response
     */
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

    /**
     * view method
     *
     * @param int $id The ID of the article
     * @return \Cake\Http\Response Returns the JSON response
     */
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

    /**
     * add method
     *
     * @return \Cake\Http\Response Returns the JSON response
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $requestData = $this->request->input('json_decode', true);
        $article = $this->Articles->newEntity($requestData);

        if ($this->Articles->save($article)) {
            return $this->jsonResponse(201, ['message' => 'Article has been saved.']);
        } else {
            // Debugging: Check for validation errors
            $errors = $article->getErrors();
            // Debugging: Log or display validation errors
            debug($errors);

            return $this->jsonResponse(400, ['error' => 'Unable to add the article.']);
        }
    }

    /**
     * edit method
     *
     * @param int|null $id The ID of the article
     * @return \Cake\Http\Response Returns the JSON response
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id);

        if ($this->request->is(['post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                return $this->jsonResponse(200, ['message' => 'Article has been updated.']);
            } else {
                return $this->jsonResponse(400, ['error' => 'Unable to update the article.']);
            }
        }
    }

    /**
     * delete method
     *
     * @param int|null $id The ID of the article
     * @return \Cake\Http\Response Returns the JSON response
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->find()->where(['id' => $id])->first();
        if (!$article) {
            return $this->jsonResponse(404, ['error' => 'Article not found']);
        }
        if ($this->Articles->delete($article)) {
            return $this->jsonResponse(200, ['message' => 'Article has been deleted.']);
        } else {
            return $this->jsonResponse(400, ['error' => 'Unable to delete the article.']);
        }
    }
}
