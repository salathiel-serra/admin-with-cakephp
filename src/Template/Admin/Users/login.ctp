<?= $this->Form->create('post', ['class'=>'form-signin']) ?>
    <?= $this->Html->image('logo-admin-with-cakephp.jpg', [
        'class' => 'mb-4', 
        'alt'   => 'Logo do sistema: Admin with CakePHP',
        'width' => '72', 
        'height'=> '72'
    ]) ?>

    <h1 class="h3 mb-3 font-weight-normal"> Área Restrita </h1>

    <?= $this->Flash->render(); ?>

    <div class="form-group">
        <?php
            echo $this->Form->control('username', [
                'class'       => 'form-control', 
                'placeholder' => 'Usuário',
                'label'       => false
            ]);
            echo $this->Form->control('password', [
                'class'       => 'form-control', 
                'placeholder' => 'Senha',
                'label'       => false
            ]);
        ?>
    </div>

    <?= $this->Form->button(__('Acessar'), ['class' => 'btn btn-large btn-primary btn-block']) ?>

    <p class="text-center">
        <hr>
        Esqueceu a senha? <br>

        <?= $this->Html->link(__('Não possui cadastro?'), [
            'controller' => 'Users', 'action' => 'register'
        ]) ?> 
    </p>
<?= $this->Form->end() ?>
