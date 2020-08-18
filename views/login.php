<h1 class="my-4">Login</h1>
<div class="card bg-light">
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo (isset($_COOKIE['remember_username'])) ?  $_COOKIE['remember_username'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <a href="<?php echo Config::getParams('url'); ?>?page=registration&action=index">Not registered? Create an account</a>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember_me"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-dark"  name="submit">Submit</button>
        </form>
    </div>
</div>
