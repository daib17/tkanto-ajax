<div class="main-container">
    <div class="login-content text-center col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
        <img src="img/logo.png" alt="">
        <br><br>
        <form method="POST">
            <!-- <input type="hidden" name="route" value="login"> -->
            <div class="form-group">
                <input type="text" name="user" class="form-control-lg w-100" placeholder="Username or Email" value="<?= $user ?>" autocomplete="username">
            </div>
            <div class="form-group">
                <input type="password" name="pass" class="form-control-lg mt-2 w-100" placeholder="Password" value="<?= $pass ?>" autocomplete="new-password">
            </div>
            <div class="error-message">
                <p><?= $msg ?></p>
            </div>
            <div class="pt-3">
                <button class="btn btn-lg btn-info btn-block  font-weight-bold" type="submit">Log in</button>
            </div>
        </form>
        <form>
            <input type="hidden" name="route" value="register">
            <button class="btn btn-lg btn-light btn-block mt-5" type="submit">New student? Register here</button>
        </form>
        <form>
            <input type="hidden" name="route" value="pass_recovery">
            <button class="btn btn-lg btn-light btn-block mt-3 mb-3" type="submit">Forgot password?</button>
        </form>
    </div>
</div>
