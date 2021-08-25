<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Usuário</h2>
    </div>
    <div class="p-2">
        <span class="d-none d-md-block">
            <?= $this->Html->link(__('Editar perfil'), ['controller' => 'Users', 'action' => 'editProfile'], ['class' => 'btn btn-warning btn-sm']) ?>
            <?= $this->Html->link(__('Editar senha'), ['controller' => 'Users', 'action' => 'editProfilePassword'], ['class' => 'btn btn-danger btn-sm']) ?>
        </span>
        <div class="dropdown d-block d-md-none">
            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ações
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                <?= $this->Html->link(__('Editar perfil'), ['controller' => 'Users', 'action' => 'editProfile'], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link(__('Editar senha'), ['controller' => 'Users', 'action' => 'editProfilePassword'], ['class' => 'dropdown-item']) ?>
            </div>
        </div>
    </div>
</div><hr>
<?= $this->Flash->render() ?>

<dl class="row">
    <dt class="col-sm-3">Foto</dt>
    <dd class="col-sm-9" style="margin-bottom:30px;">
        <?php 
            if(!empty($userLogged['image'])) { 
                echo $this->Html->image('../files/user/'.$userLogged['id'].'/'.$userLogged['image'],
                ['class'=>'rounded-circle', 'width' => '120', 'height' => '120']);
            } else {
                echo $this->Html->image('../files/user/avatar-default.jpeg',
                ['class'=>'rounded-circle', 'width' => '120', 'height' => '120']);
            } 
        ?>
        <?= $this->Html->link(__('Alterar foto'), ['action' => 'changeProfileImage'], ['class' => 'btn btn-sm btn-outline-primary']); ?>
        
    </dd>

    <dt class="col-sm-3"> Nome </dt>
    <dd class="col-sm-9"> <?= $user['name'] ?> </dd>

    <dt class="col-sm-3"> E-mail </dt>
    <dd class="col-sm-9"> <?= $user['email'] ?> </dd>

    <dt class="col-sm-3"> Usuário </dt>
    <dd class="col-sm-9"> <?= $user['username'] ?> </dd>
</dl>