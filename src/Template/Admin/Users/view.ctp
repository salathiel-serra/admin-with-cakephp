<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Usuário</h2>
    </div>
    <div class="p-2">
        <span class="d-none d-md-block">
            <?= $this->Html->link(__('Listar'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-info btn-sm']) ?>

            <?= $this->Html->link(__('Editar usuário'), ['controller' => 'Users', 'action' => 'edit', $user->id], ['class' => 'btn btn-warning btn-sm']) ?>
            <?= $this->Html->link(__('Editar senha'), ['controller' => 'Users', 'action' => 'editPassword', $user->id], ['class' => 'btn btn-warning btn-sm']) ?>

            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['class' => 'btn btn-danger btn-sm', 'confirm' => __('Você deseja realmente excluir: {0}?', $user->name)]) ?>

        </span>
        <div class="dropdown d-block d-md-none">
            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ações
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                <?= $this->Html->link(__('Listar'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'dropdown-item']) ?>

                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $user->id], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link(__('Editar senha'), ['controller' => 'Users', 'action' => 'editPassword', $user->id], ['class' => 'dropdown-item']) ?>

                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['class' => 'dropdown-item', 'confirm' => __('Você deseja realmente excluir: {0}?', $user->name)]) ?>                                    
            </div>
        </div>
    </div>
</div><hr>
<?= $this->Flash->render() ?>

<dl class="row text-center">
<dt class="col-sm-3">Foto</dt>
    <dd class="col-sm-9" style="margin-bottom:30px;">
        <div class="img-profile">
            <?php 
            if(!empty($user->image)) { 
                echo $this->Html->image('../files/user/'.$user->id.'/'.$user->image,
                ['class'=>'rounded-circle', 'width' => '120', 'height' => '120']); ?>
                
                <div class="edit">
                    <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>',
                        ['controller' => 'Users', 'action' => 'changeUserImage', $user->id],
                        ['escape' => false]
                    ) ?>
                    
                </div>

                <?php 
            } else { 
                echo $this->Html->image('../files/user/avatar-default.jpeg',
                ['class'=>'rounded-circle', 'width' => '120', 'height' => '120']);  ?>

                <div class="edit">
                    <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>',
                        ['controller' => 'Users', 'action' => 'changeUserImage', $user->id],
                        ['escape' => false]
                    ) ?>
                    
                </div>
                <?php 
            } 
            ?>
        </div>
    </dd>

    <dt class="col-sm-3">Nome</dt>
    <dd class="col-sm-9"><?= h($user->name) ?></dd>

    <dt class="col-sm-3">E-mail</dt>
    <dd class="col-sm-9"><?= h($user->email) ?></dd>

    <dt class="col-sm-3">Usuário</dt>
    <dd class="col-sm-9"><?= h($user->username) ?></dd>

    <dt class="col-sm-3 text-truncate">Cadastro</dt>
    <dd class="col-sm-9"><?= h($user->created) ?></dd>

    <dt class="col-sm-3 text-truncate">Alteração</dt>
    <dd class="col-sm-9"><?= h($user->modified) ?></dd>

</dl>