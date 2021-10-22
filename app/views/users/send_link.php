<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php flash('reset_pass'); ?>
            <form action="<?php echo URLROOT; ?>/users/send_link" method="POST">
                <div class="form-group">
                    <label for="email">Enter your email to send the resetting password link</label>
                    <input type="email" name="email" class="form-control form-control-lg mt-2
                        <?php echo (!empty($data['email_err']))?'is-invalid' : '' ?>"  value="<?php if(isset($_COOKIE["user_email"])) { echo $_COOKIE["user_email"] ; }  ?>"
                    <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Send link" class="btn btn-primary col-12 mt-2">
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>






