<div class="container">
    <div class="login-container">
        <div id="output"></div>
        <div class="avatar"></div>
        <div class="form-box">
            <?php
            $mensaje = validation_errors();
            if($mensaje!=""){ ?>
                <div class="animated fadeInUp alert alert-danger">
                    <?php echo lang('log_in'); ?>
                </div>
            <?php }else{ ?>
                <div class="animated fadeInUp alert alert-success">
                    <?php echo lang('ingrese').' '.lang('usuario').' '.lang('password'); ?>
                </div>
            <?php } ?>

            <?php echo form_open('usuarios/verifylogin'); ?>
                <input type="text"     id="username" name="username" placeholder="<?php echo lang('usuario')?>" autofocus>
                <input type="password" id="password" name="password" placeholder="<?php echo lang('password')?>" autocomplete="off">
                <button class="btn btn-info btn-block login" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>