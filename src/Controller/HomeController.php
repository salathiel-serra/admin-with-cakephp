<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
    //----- Permite acesso à metódos/views sem autenticação
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
    }

    public function index()
    {
        $home = "Bem vindo!";
        $this->set(compact('home'));
    }
}