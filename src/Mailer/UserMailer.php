<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'User';

    public function registerUser($user)
    {
        $this->setTo($user->email)
                ->setProfile('envemail')
                ->setEmailFormat('html')
                ->setTemplate('welcome')
                ->setLayout('user')
                ->setViewVars(['name' => $user->name])
                ->setSubject('Bem vindo(a)');
    }
}
