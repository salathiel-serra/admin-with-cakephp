<?= $this->Form->create($user, ['class'=>'form-signin']) ?>
    <h1 class="h3 mb-3 font-weight-normal"> Redefinir senha </h1>

    <?= $this->Flash->render(); ?>

    <div class="form-group">
      <?php 
        echo $this->Form->control('email', [
            'class'       => 'form-control', 
            'placeholder' => 'Seu e-mail registrado',
            'label'       => false
        ]);  
    ?>
    </div>

    <?= $this->Form->button(__('Redefinir'), ['class' => 'btn btn-large btn-warning btn-block']) ?>

    <p class="text-center">
        <hr>
        <?= $this->Html->link(__('Clique aqui para acessar'), [
            'controller' => 'Users', 'action' => 'login'
        ]) ?> 
    </p>
<?= $this->Form->end() ?>
