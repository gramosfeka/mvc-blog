<?php require APPROOT . '/views/inc/header.php'?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h1>Post title</h1>
                <img src="#" style="width: 450px;height: 400px;">
                <p class="lead">Post body</p>
                <hr>
                <p>Category: Category name</p>
                <hr>
                Tags:

                <span class="badge badge-secondary">{{$tag->name}}</span>

            </div>

        </div>

    </div>

<?php require APPROOT . '/views/inc/footer.php'?>