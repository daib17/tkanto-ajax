<div class="main-container">
    <div class="col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
        <br><br>
        <h3>Password Recovery</h3>
        <br>
        <h5>Enter your student email account</h5>
        <form method="POST">
            <input type="hidden" name="route" value="pass_recovery">
            <div class="form-group">
                <input type="text" class="form-control-lg mt-2 w-100" placeholder="Email" name="email" value="<?= $email ?>" required>
                <small class=" text-left form-text error-message"><?= $emailError ?></small>
            </div>
            <br>
            <?php if ($button == "send" && !$isValid && !$emailError): ?>
                <div class="alert alert-danger" role="alert">
                    Account with email <b><?= $email ?></b> not found in our database.
                </div>
            <?php endif; ?>
            <?php if ($button != "send" || ($button == "send" && !$isValid)): ?>
                <button class="btn btn-lg btn-info btn-block font-weight-bold mt-3" type="submit" name="button" value="send">Send</button>
            <?php endif; ?>
            <?php if ($button == "send" && $isValid): ?>
                <div class="alert alert-success" role="alert">
                    An email has been sent to <b><?= $email ?></b>.
                </div>
            <?php endif; ?>
        </form>
        <form>
            <button class="btn btn-lg btn-secondary btn-block font-weight-bold mt-4 mb-3" type="submit">Back to login</button>
        </form>
    </div>
</div>
