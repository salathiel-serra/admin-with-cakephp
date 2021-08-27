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
            ->setViewVars([
                'name' => $user->name, 
                'email_verification_code' => $user->email_verification_code,
                'host_name' => $user->host_name
            ])
            ->setSubject('Confirme o seu e-mail | Admin-With-CakePHP');
    }

    public function resetPassword($user)
    {
        $this->setTo($user->email)
            ->setProfile('envemail')
            ->setEmailFormat('html')
            ->setTemplate('reset_password')
            ->setLayout('user')
            ->setViewVars([
                'name' => $user->name, 
                'username' => $user->username,
                'password_temporary' => $user->password_temporary,
                'host_name' => $user->host_name
            ])
            ->setSubject('Redefinir senha | Admin-With-CakePHP');
    }
}
