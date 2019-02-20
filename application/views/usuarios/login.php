<div class="container">
    <div class="login-container">
        <div id="output"></div>
        <div class="avatar"></div>
        <div class="form-box">
            <?php
            $mensaje = validation_errors();
            if( $mensaje != "" ){
                echo '<div class="alert alert-danger animated fadeInUp">'.lang('login_incorrecto').'</div>';
            } else {
                echo '<div class="alert alert-danger animated fadeInUp">'.lang('ingrese_usuario').'</div>';
            }

            echo form_open('usuarios/verifylogin');
                echo '<input type="text"     id="username" name="username" placeholder="Usuario" autofocus>';
                echo '<input type="password" id="password" name="password" placeholder="Pass" autocomplete="off">';
                echo '<button class="btn btn-info btn-block login" type="submit">Login</button>';
            echo form_close();
            ?>
        </div>
    </div>
</div>