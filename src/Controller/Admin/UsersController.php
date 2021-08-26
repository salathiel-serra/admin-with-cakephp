<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 20
        ];

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
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

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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

    public function changeUserImage($id = NULL)
    {
        $user = $this->Users->get($id);

        $imageOld = $user->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->newEntity();
            
            $user->id    = $id;
            $user->image = $this->Users->slugSingleUpload( $this->request->getData()['image']['name'] );

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $path = WWW_ROOT.'files'.DS.'user'.DS.$id.DS;
                
                $imageRequest = $this->request->getData()['image'];
                $imageRequest['name'] = $user->image;

                if ($this->Users->singleUpload($imageRequest, $path) ) {

                    if (!is_null($imageOld) AND ($imageOld !== $user->image)) {
                        unlink( $path . $imageOld );
                    }

                    $this->Flash->success(__('Foto atualizada com sucesso'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'view', $id]);

                } else {
                    $user->image = $imageOld;
                    $this->Users->save($user);
                    $this->Flash->danger(__('Erro ao atualizar foto. Falha ao realizar upload'));
                }

            } else {
                $this->Flash->danger(__('Erro ao atualizar foto'));
            }
        }

        $this->set( compact('user') );
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário removido com sucesso.'));
        } else {
            $this->Flash->danger(__('Erro ao remover usuário.'));
        }

        return $this->redirect(['action' => 'index']);
    }

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

        $imageOld = $user->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->newEntity();
            
            $user->id    = $userId;
            $user->image = $this->Users->slugSingleUpload( $this->request->getData()['image']['name'] );

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $path = WWW_ROOT.'files'.DS.'user'.DS.$userId.DS;
                
                $imageRequest = $this->request->getData()['image'];
                $imageRequest['name'] = $user->image;

                if ($this->Users->singleUpload($imageRequest, $path) ) {

                    if (!is_null($imageOld) AND ($imageOld !== $user->image)) {
                        unlink( $path . $imageOld );
                    }

                    $this->Flash->success(__('Foto atualizada com sucesso'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'profile']);

                } else {
                    $user->image = $imageOld;
                    $this->Users->save($user);
                    $this->Flash->danger(__('Erro ao atualizar foto. Falha ao realizar upload'));
                }

            } else {
                $this->Flash->danger(__('Erro ao atualizar foto'));
            }
        }

        $this->set( compact('user') );
    }
}
