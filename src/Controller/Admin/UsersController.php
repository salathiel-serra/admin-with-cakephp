<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    use MailerAwareTrait;

    //----- Permite acesso à metódos/views sem autenticação
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'register', 'logout', 'confirmEmail', 'resetPassword', 'updatePassword'
        ]);
    }

    public function index()
    {
        $this->paginate = [
            'limit' => 20
        ];

        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set('user', $user);
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
           
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger(__('Erro ao cadastrar usuário.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado com sucesso.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'view', $id]);
            }
            $this->Flash->danger(__('Erro ao atualizar usuário.'));
        }
        $this->set(compact('user'));
    }

    public function editPassword($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
           
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Senha do usuário: '.$user->name.', atualizada com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger(__('Erro ao atualizar senha do usuário: '.$user->name));
        }
        $this->set(compact('user'));
    }

    public function resetPassword()
    {
        $user = $this->Users->newEntity();
    
        if ($this->request->is('post')) {
            $userTable = TableRegistry::get('Users');
            $temporaryPassword = $userTable->getTemporaryPassword( $this->request->getData()['email'] );

            if ($temporaryPassword) {
                if ($temporaryPassword->password_temporary == "") {
                    $user->id = $temporaryPassword->id;
                    $user->password_temporary = Security::hash( $this->request->getData()['email'] . $temporaryPassword->id . date("Y-m-d H:i:s"), 'sha256', false);

                    $userTable->save($user);

                    $temporaryPassword->password_temporary = $user->password_temporary;
                }
                /**
                 * Trecho abaixo para utilizar em servidor de hospedagem
                 * $user->host_name = Router::fullBaseUrl().$this->request->getAttribute('webroot').$this->request->getParam('prefix');
                */
                
                $temporaryPassword->host_name = "http://localhost:8765/admin"; 

                $this->getMailer('User')->send('resetPassword', [$temporaryPassword]);

                $this->Flash->success(__('E-mail enviado com sucesso, verifique a sua caixa de entrada.'));
                return $this->redirect(['controller' => 'Users','action' => 'login']);
            } 
            $this->Flash->danger(__('Erro: O e-mail informado não foi localizado!'));
        }

        $this->set(compact('user'));
    }

    // 'http://localhost:8765/admin/users/update-password/098d89f44ba2c0bf2fa58ea51afba2e3ffecabbae0de2156b6b93ca7e8d094ac'
    public function updatePassword($password_temporary = NULL)
    {
        $userTable = TableRegistry::get('Users');
        $user = $userTable->getCurrentPassword($password_temporary);
        
        if ($user) {

            if ($this->request->is(['patch','post','put'])) {
                $user = $this->Users->patchEntity( $user, $this->request->getData() );
                $user->password_temporary = NULL;
                if ($this->Users->save($user)) {
                   
                    $this->Flash->success(__('Senha redefinida com sucesso'));
                    return $this->redirect(['controller' => 'Users','action' => 'login']);
                
                } else {
                    $this->Flash->danger(__('Erro ao redefinir senha'));
                }
            }
            
            $this->set( compact('user'));
        } else {
            $this->Flash->danger(__('Erro: Link inválido'));
            return $this->redirect(['controller' => 'Users','action' => 'login']);
        }        
    }

    public function changeUserImage($id = NULL)
    {
        $user = $this->Users->get($id);

        $oldImage = $user->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->newEntity();
            
            $user->id    = $id;
            $user->image = $this->Users->slugUploadResizedImage( $this->request->getData()['image']['name'] );

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $path = WWW_ROOT.'files'.DS.'user'.DS.$id.DS;
                
                $imageRequest = $this->request->getData()['image'];
                $imageRequest['name'] = $user->image;

                if ($this->Users->uploadResizedImage($imageRequest, $path, 150, 150) ) {

                    $this->Users->deleteFile($path, $oldImage, $user->image);

                    $this->Flash->success(__('Foto atualizada com sucesso'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'view', $id]);

                } else {
                    $user->image = $oldImage;
                    $this->Users->save($user);
                    $this->Flash->danger(__('Erro ao atualizar foto. Falha ao realizar upload'));
                }

            } else {
                $this->Flash->danger(__('Erro ao atualizar foto'));
            }
        }

        $this->set( compact('user') );
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        $path = WWW_ROOT.'files'.DS.'user'.DS.$user->id.DS;
        $this->Users->deleteDirectory($path);
        
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário removido com sucesso.'));
        } else {
            $this->Flash->danger(__('Erro ao remover usuário.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //----- Os métodos abaixo são referentes ao acesso e saída da aplicação
    public function login()
    {
        if ($this->request->is('post')) {
            
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->redirect($this->Auth->redirectUrl());;
            } else {
                $this->Flash->danger(__('Usuário e/ou senha incorreto(s)'));
            }
        }
    }

    public function logout()
    {
        $this->Flash->success(__('Usuário deslogado com sucesso!'));
        return $this->redirect( $this->Auth->logout() );
    }

    //----- Os métodos abaixo permitem ao usuário logado acessar/atualizar seus dados
    public function profile() 
    {
        $userId = $this->Auth->user('id');
        $user   = $this->Users->get($userId);

        $this->set(compact('user'));
    }

    public function editProfile()
    {
        $userId = $this->Auth->user('id');
        $user   = $this->Users->get($userId, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Perfil atualizado com sucesso.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
            }
            $this->Flash->danger(__('Erro ao atualizar perfil.'));
        }

        $this->set( compact('user') );
    }

    public function editProfilePassword()
    {
        $userId = $this->Auth->user('id');
        $user   = $this->Users->get($userId, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Senha atualizada com sucesso.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
            }

            $this->Flash->danger(__('Erro ao atualizar senha.'));
        }

        $this->set( compact('user') );
    }

    public function changeProfileImage()
    {
        $userId = $this->Auth->user('id');
        $user = $this->Users->get($userId);

        $oldImage = $user->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->newEntity();
            
            $user->id    = $userId;
            $user->image = $this->Users->slugUploadResizedImage( $this->request->getData()['image']['name'] );

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $path = WWW_ROOT.'files'.DS.'user'.DS.$userId.DS;
                
                $imageRequest = $this->request->getData()['image'];
                $imageRequest['name'] = $user->image;

                if ($this->Users->uploadResizedImage($imageRequest, $path, 150, 150) ) {

                    $this->Users->deleteFile($path, $oldImage, $user->image);

                    $this->Flash->success(__('Foto atualizada com sucesso'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'profile']);

                } else {
                    $user->image = $oldImage;
                    $this->Users->save($user);
                    $this->Flash->danger(__('Erro ao atualizar foto. Falha ao realizar upload'));
                }

            } else {
                $this->Flash->danger(__('Erro ao atualizar foto'));
            }
        }

        $this->set( compact('user') );
    }

    //----- Os métodos abaixo são referentes ao cadastro externo
    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            $baseCode = $this->request->getData('password') . $this->request->getData('email');
            $user->email_verification_code = Security::hash($baseCode, 'sha256', false);

            if ($this->Users->save($user)) {
                /**
                 * Trecho abaixo para utilizar em servidor de hospedagem
                 * $user->host_name = Router::fullBaseUrl().$this->request->getAttribute('webroot').$this->request->getParam('prefix');
                */
                
                $user->host_name = "http://localhost:8765/admin"; 

                // Enviando E-mail
                // $this->getMailer('User')->send('registerUser', [$user]);

                $this->Flash->success(__('Cadastro realizado com sucesso.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
            $this->Flash->danger(__('Erro ao realizar cadastro.'));
        }
        $this->set(compact('user'));
    }

    public function confirmEmail($email_verification_code = NULL)
    {
        $userTable    = TableRegistry::get('Users');
        $confirmEmail = $userTable->getConfirmEmail($email_verification_code);

        if ($confirmEmail) {
            $user                 = $this->Users->newEntity();
            $user->id             = $confirmEmail->id;
            $user->email_verified = '1';
            
            if ($userTable->save($user)) {
                $this->Flash->success(__('E-mail confirmado com sucesso!'));
            } else {
                $this->Flash->danger(__('Erro: E-mail não foi confirmado'));
            }
        } else {
            $this->Flash->danger(__('Erro: E-mail e/ou código de verificação inválido(s)'));
        }

        $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
