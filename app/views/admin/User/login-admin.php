<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>LTE
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php if (!empty($_SESSION['errors'])):?>
                <div class="alert alert-danger alert-dismissible">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fas fa-ban"></i>
                    <?= $_SESSION['errors']; unsert($_SESSION['errors'])?>
                </div>
            <?php endif?>
            <form method="post">
                <div class="input-group mb-3">
                    <input required placeholder="Email" type="email" name="email" class="form-controll">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input required placeholder="Pssword" type="password" name="password" class="form-controll">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>