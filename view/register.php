<div class="main-container">
    <div class="register-content text-center col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
        <h3>Create new account</h3>
        <br>
        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control-lg mt-2 w-100" placeholder="First Name" name="fname" value="<?= $fname ?>" maxlength="25" required>
                <small class="text-left form-text error-message"><?= $fnameError ?></small>
            </div>
            <div class="form-group">
                <input type="text" class="form-control-lg mt-2 w-100" placeholder="Last Name" name="lname" value="<?= $lname ?>" maxlength="25" required>
                <small class="text-left form-text error-message"><?= $lnameError ?></small>
            </div>
            <div class="form-group">
                <input type="text" class="form-control-lg mt-2 w-100" placeholder="Email" name="email" value="<?= $email ?>" required>
                <small class=" text-left form-text error-message"><?= $emailError ?></small>
            </div>
            <div class="form-group">
                <input type="text" class="form-control-lg mt-2 w-100" placeholder="Phone Number" name="phone" value="<?= $phone ?>" maxlength="15" required>
                <small class="text-left form-text error-message"><?= $phoneError ?></small>
            </div>
            <div class="form-group">
                <input type="password" name="pass" class="form-control-lg mt-2 w-100" placeholder="Password" name="password" value="<?= $pass ?>" maxlength="15" required>
                <small class="text-left form-text error-message"><?= $passError ?></small>
            </div>
            <div class="form-group">
                <input type="password" class="form-control-lg mt-2 w-100" placeholder="Confirm Password" name="pass2" value="<?= $pass2 ?>" maxlength="15" required>
                <small class="text-left form-text error-message"><?= $pass2Error ?></small>
            </div>
            <?php if (!$isValid): ?>
                <button class="btn btn-lg btn-info btn-block font-weight-bold mt-5 mb-3" type="submit" name="registerBtn" value="register">Register</button>
            <?php endif; ?>
        </form>
        <?php if ($isValid): ?>
            <form>
                <input type="hidden" name="route" value="login">
                <input type="hidden" name="user" value="<?= $uname ?>">
                <div class="alert alert-success mt-3">
                    Account created. Username: <b><?= $uname ?></b>
                </div>
                <button class="btn btn-lg btn-secondary btn-block font-weight-bold mt-4 mb-3" type="submit">Back to login</button>
            </form>
        <?php else: ?>
            <form>
                <input type="hidden" name="route" value="login">
                <button class="btn btn-lg btn-light btn-block mt-5 mb-3" type="submit">Already registered? Log me in</button>
            </form>
        <?php endif; ?>
    </div>
</div>
