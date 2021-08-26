<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Editar Foto</h2>
    </div>
	<div class="p-2">
	    <span class="d-none d-md-block">
      <?= $this->Html->link(__('Exibir perfil'), ['controller' => 'Users', 'action' => 'profile'], ['class' => 'btn btn-primary btn-sm']); ?>
	    </span>
	    <div class="dropdown d-block d-md-none">
	        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	            Ações
	        </button>
	        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
	            <?= $this->Html->link(__('Exibir perfil'), ['controller' => 'Users', 'action' => 'profile'], ['class' => 'dropdown-item']) ?>                                 
	        </div>
	    </div>
	</div>
</div><hr>
<?= $this->Flash->render() ?>

<?= $this->Form->create($user, ['enctype' => 'multipart/form-data']) ?>
  <div class="row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Foto <small>(150x150)</small> </label> <br>
        <?= $this->Form->file('image', ['label' => false, 'onchange' => 'imagePreview()']) ?>
    </div>
    <div class="form-group col-md-6 text-center">
        <?php
            if ($user->image != NULL) {
                $image = '../../files/user/'.$user->id.'/'.$user->image;
            } else {
                $image = '../../files/user/preview_img.png';
            }
        ?>

        <img src="<?= $image ?>" alt="<?= $user->name ?>" class="img-thumbnail" style="width:150px; height:150px;" id="image-preview">
    </div>
  </div>
  <p>
      <span class="text-danger">* </span>Campo obrigatório
  </p>
  <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>

