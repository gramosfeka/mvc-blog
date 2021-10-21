<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h3>Edit Article</h3>
            </div>
            <div class="card-body">
        <form method="POST" enctype="multipart/form-data"
              action="<?php echo URLROOT; ?>/articles/update/<?php echo $data['id']?>">

            <div class="form-group">
                <label for="title">Title:</label>
                <input class="form-control  <?php echo (!empty($data['errors']['title_err'])) ? 'is-invalid' : '' ?>" type="text" id="title" name="title"
                       value="<?php echo $data['title'] ?>">
                <span class="invalid-feedback"><?php echo $data['errors']['title_err'] ?></span>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control <?php echo (!empty($data['errors']['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category_id">
                    <?php foreach ($data['categories'] as $category) : ?>
                     <?php if($category->id == $data['article']->category_id){?>
                        <option selected="selected"  value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                        <?php }else{?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                    <?php }?>

        <?php endforeach;?>
                </select>
                <span class="invalid-feedback"><?php echo $data['errors']['category_err'] ?></span>
            </div>

            <div class="form-group">
                <label for="tags">Tags:</label>
                <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['errors']['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                    <?php foreach ($data['tags'] as $tag) : ?>
                        <?php if(in_array($tag->name, $data['articleTags'])) : ?>
                            <option  selected="selected" value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                        <?php else : ?>
                            <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
                <span class="invalid-feedback"><?php echo $data['errors']['tags_err'] ?></span>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input name="image" type="file" class="form-control <?php echo (!empty($data['errors']['image_err'])) ? 'is-invalid' : '' ?>" id="image">
                <span class="invalid-feedback"><?php echo $data['errors']['image_err'] ?></span>
            </div>
            <div class="form-group">
                <label for="body">Description:</label>
                <textarea class="form-control <?php echo (!empty($data['errors']['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor"
                          rows="10"><?php echo $data['body'] ?></textarea>
                <span class="invalid-feedback"><?php echo $data['errors']['body_err'] ?></span>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input name="created_at" type="date" value="<?php echo $data['created_at'] ?>" class="form-control <?php echo (!empty($data['errors']['created_at_err'])) ? 'is-invalid' : '' ?>" id="created_at">
                <span class="invalid-feedback"><?php echo $data['errors']['created_at_err'] ?></span>
            </div>
            <div class="row">
                <div class="col">
                  <input type="submit" value="Update" class="btn btn-success col-12 mt-2 btn-block">
                </div>
        </form>
        <div class="col">
            <form method="POST" action="<?php echo URLROOT; ?>/articles/delete/<?php echo $data['id']?>">
                <input type="submit" value="Delete" class="btn btn-danger col-12 mt-2">
            </form>
        </div>
            </div>
        </div>
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
