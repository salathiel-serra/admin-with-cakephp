<?= $this->Form->create($user, ['class'=>'form-signin']) ?>
    <h1 class="h3 mb-3 font-weight-normal"> Cadastrar </h1>

    <?= $this->Flash->render(); ?>

    <div class="form-group">
      <?php 
        echo $this->Form->control('name', [
                'class'       => 'form-control', 
                'placeholder' => 'Nome completo',
                'label'       => false
            ]); 
        echo $this->Form->control('username', [
            'class'       => 'form-control', 
            'placeholder' => 'Usuário',
            'label'       => false
          ]); 
        echo $this->Form->control('email', [
              'class'       => 'form-control', 
              'placeholder' => 'Seu melhor e-mail',
              'label'       => false
          ]); 
        echo $this->Form->control('password', [
            'class'       => 'form-control', 
            'placeholder' => 'Senha',
            'label'       => false
          ]); 
      ?>
    </div>

    <?= $this->Form->button(__('Cadastrar'), ['class' => 'btn btn-large btn-success btn-block']) ?>

    <p class="text-center">
        <hr>
        <?= $this->Html->link(__('Clique aqui para acessar'), [
            'controller' => 'Users', 'action' => 'login'
        ]) ?> 
    </p>
<?= $this->Form->end() ?>
