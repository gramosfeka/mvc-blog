<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h3>Add New Article</h3>
            </div>
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" action="<?php echo URLROOT ?>/articles/create">

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input class="form-control  <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '' ?>" type="text" id="title" name="title"
                               value="">
                        <span class="invalid-feedback"><?php echo $data['title_err'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category_id">
                          <?php foreach ($data['categories'] as $category) : ?>
                            <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                          <?php endforeach;?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['category_err'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags:</label>
                        <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                            <?php foreach ($data['tags'] as $tag) : ?>
                                <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                            <?php endforeach;?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['tags_err'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input name="image" type="file" class="form-control <?php echo (!empty($data['image_err'])) ? 'is-invalid' : '' ?>" id="image">
                        <span class="invalid-feedback"><?php echo $data['image_err'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="body">Description:</label>
                        <textarea class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor"
                                  rows="10"></textarea>
                        <span class="invalid-feedback"><?php echo $data['body_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input name="created_at" type="date" class="form-control <?php echo (!empty($data['created_at_err'])) ? 'is-invalid' : '' ?>" id="created_at">
                        <span class="invalid-feedback"><?php echo $data['created_at_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-success btn-lg mt-2 btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
</script>

