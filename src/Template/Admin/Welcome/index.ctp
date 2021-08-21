<h2> Bem vindo, <?= $user['name']; ?></h2>
<li><?= $this->Html->link(__('Sair'), ['controller' => 'users','action' => 'logout']) ?></li>