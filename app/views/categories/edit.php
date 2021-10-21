<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Edit Category</h1>

            <form method="POST" action="<?php echo URLROOT; ?>/categories/update/<?php echo $data['id']; ?> ">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name"
                           class="form-control <?php echo (!empty($data['errors']['name_err'])) ? 'is-invalid' : '' ?>"
                           value="<?php echo $data['name'] ?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['name_err'] ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="EDIT" class="btn btn-primary col-12 mt-2">
                    </div>
            </form>
            <div class="col">
                <form method="POST" action="<?php echo URLROOT; ?>/categories/delete/<?php echo $data['id']?>">
                    <input type="submit" value="Delete" class="btn btn-danger col-12 mt-2">
                </form>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>