<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Editar Usuário</h2>
    </div>
    <div class="p-2">
        <span class="d-none d-md-block">
            <?= $this->Html->link(__('Listar'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-info btn-sm']) ?>

            <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $user->id], ['class' => 'btn btn-warning btn-sm']) ?>

            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['class' => 'btn btn-danger btn-sm', 'confirm' => __('Você deseja realmente excluir: {0}?', $user->name)]) ?>

        </span>
        <div class="dropdown d-block d-md-none">
            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ações
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                <?= $this->Html->link(__('Listar'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'dropdown-item']) ?>

                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $user->id], ['class' => 'dropdown-item']) ?>

                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['class' => 'dropdown-item', 'confirm' => __('Você deseja realmente excluir: {0}?', $user->name)]) ?>                                    
            </div>
        </div>
    </div>
</div><hr>
<?= $this->Flash->render() ?>

<?= $this->Form->create($user) ?>
<div class="form-row">
    <div class="form-group col-md-12">
        <label><span class="text-danger">*</span> Nome</label>
        <?= $this->Form->control('name', ['class' => 'form-control', 'placeholder' => 'Nome completo', 'label' => false]) ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> E-mail</label>
        <?= $this->Form->control('email', ['class' => 'form-control', 'placeholder' => 'Seu melhor e-mail', 'label' => false]) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Usuário</label>
        <?= $this->Form->control('username', ['class' => 'form-control', 'placeholder' => 'Nome de usuário', 'label' => false]) ?>
    </div>
</div>

<p>
    <span class="text-danger">* </span>Campo obrigatório
</p>
<div class="text-right">
    <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-success']) ?>
</div>
<?= $this->Form->end() ?>