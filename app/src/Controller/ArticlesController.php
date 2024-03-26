<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    public function index()
    {
        $articles = $this->Articles->find()->toArray(); // Fetch all articles as an array
        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']); // Serialize articles to JSON
    }
}
