Olá, <?= $name ?>

<p>
  Você solicitou uma alteração de senha. <br>
  Seguindo o link abaixo você poderá alterar sua senha. <br> <br>
  Para continuar o processo, clique no link abaixo. 
</p>

<p>
  <?= "<a href='".$host_name."/users/update-password/".$password_temporary."'> Clique aqui </a>" ?>
  
  <br>

  <strong> Usuário: </strong> <?= $username ?> <br><br>
</p>


<small>
  Se você não solicitou essa alteração, nenhuma ação é necessária. <br>
  Sua senha permanecerá a mesma até que você ative este código
</small>

<br> <br>

<p> 
  Atenciosamento, <br>
  Equipe Admin-With-CakePHP
</p>