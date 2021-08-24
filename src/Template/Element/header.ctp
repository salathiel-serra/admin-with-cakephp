<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle text-light mr-3">
        <span class="navbar-toggler-icon"></span>
    </a>
    <a class="navbar-brand" href="#">Admin-With-CakePHP</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    
                    <?php if(!empty($userLogged['image'])) { ?>
                        <?= $this->Html->image('../files/user/'.$userLogged['id'].'/'.$userLogged['image'],
                        ['class'=>'rounded-circle', 'width' => '50', 'height' => '50']) ?>
                    <?php } else { ?>
                        <?= $this->Html->image('../files/user/avatar-default.jpeg',
                        ['class'=>'rounded-circle', 'width' => '50', 'height' => '50']) ?>
                    <?php }?>

                    &nbsp;
                    <span class="d-none d-sm-inline"> 
                        <?= current( str_word_count( $userLogged['name'],2 ) ); ?> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#"><i class="fas fa-user"></i> </a>
                    <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>                
    </div>
</nav>