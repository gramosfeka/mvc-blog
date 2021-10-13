<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('register_success'); ?>
                <?php flash('reset_pass'); ?>
                <h2>Login</h2>
                <form action="<?php echo URLROOT; ?>/users/login" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control form-control-lg
                        <?php echo (!empty($data['email_err']))?'is-invalid' : '' ?>"  value="<?php if(isset($_COOKIE["user_email"])) { echo $_COOKIE["user_email"] ; }  ?>"
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control form-control-lg
                        <?php echo (!empty($data['password_err']))?'is-invalid' : '' ?>"  value="<?php if(isset($_COOKIE["user_password"])) { echo $_COOKIE["user_password"]; }?>">
                        <span class="invalid-feedback"><?php echo $data['password_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <div>
                            <input type="checkbox"  <?php if(isset($_COOKIE["user_email"])) { ?> checked <?php } ?> name="remember" id="remember"/>
                            <label for="remember">Remember me</label>
                         </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-primary col-12 mt-2">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT ?>/users/register" class="btn btn-secondary col-12 mt-2">No account? Register</a>
                        </div>


                    </div>
                        <div class="row">

                            <div class="col">
                                <a href="<?php echo URLROOT ?>/users/send_link" class="btn btn-link col-12 mt-2">Forogt Password?</a>
                            </div>

                        </div>

                </form>







            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>






