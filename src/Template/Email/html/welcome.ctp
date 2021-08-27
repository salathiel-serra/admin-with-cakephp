Olá, <?= $name ?>

<p> 
  Está tudo pronto para você começar utilizar a aplicação Admin-With-CakePHP, 
  precisamos que você confirme o seu e-mail através do link abaixo.
</p>

<p>
  <?= "<a href='".$host_name."/users/confirm-email/".$email_verification_code."'> Confirmar e-mail </a>" ?>
</p>

<p> 
  Atenciosamento, <br>
  Equipe Admin-With-CakePHP
</p>