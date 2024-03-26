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

    public function view($id){
        $article = $this->Articles->get($id); //Fetches the article by id
        $this->set(compact('article'));
        $this->viewBuilder()->setOption('serialize', ['article']); //into the route for single article
    }
}
