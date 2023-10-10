<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="user/cabinet"><?php __('tpl_cabinet'); ?></a></li>
            <li class="breadcrumb-item active"><?php __('user_credentials_title'); ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">
        <div class="col-12">
            <h1 class="section-title"><?=___('user_credentials_title')?></h1>
        </div>
        <?php $this->getPart('parts/cabinet_sidebar')?>
        <div class="col-md-9 order-md-1">
            <form class="row g-3" method="POST">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input id="email" 
                            placeholder="name@example.com" 
                            type="email" 
                            value="<?=$_SESSION['user']['email']?>" 
                            name="email" 
                            class="form-control"
                            disabled>
                        <label for="email"><?=___('tpl_signup_email_input')?></label>
                    </div>
                </div>
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input id="password" 
                            placeholder="password" 
                            type="password"  
                            name="password" 
                            class="form-control">
                        <label for="password"><?=___('tpl_signup_password_input')?></label>
                    </div>
                </div>                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input id="name" 
                            placeholder="Name" 
                            type="text" 
                            value="<?=$_SESSION['user']['name']?>" 
                            name="name" 
                            class="form-control"
                            required>
                        <label for="name"><?=___('tpl_signup_name_input')?></label>
                    </div>
                </div>                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input id="address" 
                            placeholder="Address" 
                            type="text" 
                            value="<?=$_SESSION['user']['address']?>" 
                            name="address" 
                            class="form-control"
                            required>
                        <label for="address"><?=___('tpl_signup_address_input')?></label>
                    </div>
                </div>
                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-danger"><?=___('user_credentials_save_btn')?></button>
                </div>
            </form>
        </div>
    </div>
</div>