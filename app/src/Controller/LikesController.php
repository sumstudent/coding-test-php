<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\BadRequestException;

/**
 * Likes Controller
 */
class LikesController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void {
        parent::initialize();
        // Load authentication component
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * View method
     *
     * @param int|null $id The article ID
     * @return \Cake\Http\Response|null|void Returns the JSON response or null
     */
    public function view($id = null) {
        // Check if ID is provided
        if ($id === null) {
            return $this->jsonResponse(400, ['error' => 'Invalid ID']);
        }

        // Load Likes model
        $this->loadModel('Likes');

        // Check if article has likes
        if (!$this->Likes->exists(['article_id' => $id])) {
            return $this->jsonResponse(400, ['error' => 'This article has no likes.']);
        }

        // Count the number of likes for the article
        $count = $this->Likes->find()
            ->where(['article_id' => $id])
            ->count();
    
        // Return the count of likes
        return $this->jsonResponse(200, ['likes' => $count]);
    }

    /**
     * CountLikes method
     *
     * @return \Cake\Http\Response|null|void Returns the JSON response or null
     */
    public function countLikes() {
        $this->request->allowMethod('post');

        // Get user ID from authentication
        $userId = $this->request->getAttribute('identity')->get('sub');
        $articleId = $this->request->getData('article_id');

        // Check if user ID and article ID are provided
        if (!$userId || !$articleId) {
            return $this->jsonResponse(400, ['error' => 'Invalid request data.']);
        }

        // Load Likes model
        $this->loadModel('Likes');

        // Check if user already liked the article
        if ($this->Likes->exists(['user_id' => $userId, 'article_id' => $articleId])) {
            return $this->jsonResponse(400, ['error' => 'You have already liked this article.']);
        }

        // Create a new like entity
        $like = $this->Likes->newEntity(['user_id' => $userId, 'article_id' => $articleId]);

        // Save the like
        if (!$this->Likes->save($like)) {
            return $this->jsonResponse(400, ['error' => 'Failed to save like.']);
        }

        // Count the number of likes for the article
        $count = $this->Likes->find()->where(['article_id' => $articleId])->count();

        // Return the count of likes
        return $this->jsonResponse(200, ['likes' => $count]);
    }

    /**
     * Unlike method
     *
     * @param int|null $id The article ID
     * @return \Cake\Http\Response|null|void Returns the JSON response or null
     */
    public function unlike($id = null) {
        $this->request->allowMethod('delete');
        $userId = $this->request->getAttribute('identity')->get('sub');
        $articleId = $this->request->getAttribute('params')['id'];

        // Check if user ID and article ID are provided
        if (!$userId || !$articleId) {
            return $this->jsonResponse(400, ['error' => 'Invalid request data.']);
        }

        // Load Likes model
        $this->loadModel('Likes'); 

        // Check if user already liked the article
        if (!$this->Likes->exists(['user_id' => $userId, 'article_id' => $articleId])) {
            return $this->jsonResponse(400, ['error' => 'You didn\'t like this article!']);
        }

        // Return error message for unlike
        return $this->jsonResponse(400, ['error' => 'You can\'t cancel like on this article!']);
    }
}
