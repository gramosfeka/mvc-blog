<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" aria-current="page" href="<?php echo URLROOT; ?>">Home</a>
                </li>
                <!--                <li class="nav-item">
                    <a class="nav-link" href="<?php /*echo URLROOT;*/?>/pages/about">About</a>
                </li>-->
            </ul>
            <ul class="navbar-nav ml-auto mb-2 mb-md-0">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user_name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo URLROOT; ?>/articles/">Articles</a>
                            <?php if(isAdmin()): ?>
                                <a class="dropdown-item" href="<?php echo URLROOT; ?>/categories/">Categories</a>
                                <a class="dropdown-item" href="<?php echo URLROOT; ?>/tags/">Tags</a>
                            <?php endif ; ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" aria-current="page" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                        </div>
                    </li>
                <?php  else: ?>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="<?php echo URLROOT; ?>/users/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT;?>/users/login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    </div>
</nav>