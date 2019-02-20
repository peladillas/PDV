<div class="container">
    <div class="login-container">
        <div id="output"></div>
        <div class="avatar"></div>
        <div class="form-box">
            <?php
            $mensaje = validation_errors();
            if($mensaje!=""){ ?>
                <div class="animated fadeInUp alert alert-danger">
                    Login incorrecto
                </div>
            <?php }else{ ?>
                <div class="animated fadeInUp alert alert-success">
                    Ingrese usuario y pass
                </div>
            <?php } ?>

            <?php echo form_open('verifylogin'); ?>
                <input type="text"     id="username" name="username" placeholder="Usuario" autofocus>
                <input type="password" id="password" name="password" placeholder="Pass" autocomplete="off">
                <button class="btn btn-info btn-block login" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>