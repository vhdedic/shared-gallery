<h1 class="my-4 display-4 text-center"><?php echo Config::getParams('app_name'); ?></h1>
<hr class="my-4">
<div class="text-center">
    <a href="#" class="btn btn-lg btn-dark">Images</a>
<?php if (!isset($_SESSION["username"])){ ?>
    <a href="<?php echo Config::getParams('url'); ?>?page=login&action=index" class="btn btn-lg btn-dark">Login</a>
<?php    } ?>
</div>
