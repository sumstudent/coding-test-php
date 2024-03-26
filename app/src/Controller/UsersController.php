<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\UnauthorizedException;
use Firebase\JWT\JWT; //using json web tokens

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
    }

    public function login() {
        $this->request->allowMethod('post');

        $email = $this->request->getData('email');
        $password = $this->request->getData('password');

        $user = $this->Users->findByEmail($email)->first();

        if (!$user || !password_verify($password, $user->password)) {
            return $this->jsonResponse(401, ['error' => 'Invalid email or password']);
        }

        $token = $this->generateJwtToken($user->id);

        return $this->jsonResponse(200, ['token' => $token]);
    }

    private function generateJwtToken($userId) {
        $expirationTime = time() + 864000; // 10 days in seconds
    
        $payload = [
            'sub' => $userId,
            'exp' => $expirationTime,
            'iat' => time(),
            'iss' => 'your_issuer',
        ];
    
        $secretKey = 'your_secret_key';
        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public function register() {
        $this->request->allowMethod('post');

        $user = $this->Users->newEmptyEntity();
        $data = $this->request->getData();
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        $user = $this->Users->patchEntity($user, $data);
        if ($this->Users->save($user)) {
            $token = $this->generateJwtToken($user->id); //gen token with exp 10 ten days
            return $this->jsonResponse(200, ['token' => $token]);
        } else {
            return $this->jsonResponse(400, ['error' => 'User registration failed', 'validation_errors' => $user->getErrors()]);
        }
    }

    public function logout() {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->jsonResponse(200, ['success' => 'User has been logged out']);
        }
    }

}