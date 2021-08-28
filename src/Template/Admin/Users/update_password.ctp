<?= $this->Form->create($user, ['class'=>'form-signin']) ?>
    <h1 class="h3 mb-3 font-weight-normal"> Alterar senha </h1>

    <?= $this->Flash->render(); ?>

    <div class="form-group">
      <?php 
        echo $this->Form->control('password', [
            'class'       => 'form-control', 
            'placeholder' => 'Senha',
            'label'       => false
          ]); 
      ?>
    </div>

    <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-large btn-success btn-block']) ?>

    <p class="text-center">
        <hr>
        <?= $this->Html->link(__('Clique aqui para acessar'), [
            'controller' => 'Users', 'action' => 'login'
        ]) ?> 
    </p>
<?= $this->Form->end() ?>
