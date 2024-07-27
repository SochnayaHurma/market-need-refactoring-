<div class="card">
    <div class="card-body">
        <form action="" class="row" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="required">E-mail</label>
                    <input 
                      type="email" 
                      name="email" 
                      class="form-control" 
                      id="email"
                      value="<?=$user['email']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="required">Пароль</label>
                    <input 
                      type="password" 
                      name="password" 
                      class="form-control" 
                      id="password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="required">Имя</label>
                    <input 
                      type="name" 
                      name="name" 
                      class="form-control" 
                      id="name"
                      value="<?=$user['name']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address" class="required">Адрес</label>
                    <input 
                      type="text" 
                      name="address" 
                      class="form-control" 
                      id="address"
                      value="<?=$user['address']?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role" class="required">Роль</label>
                    <select name="role" class="form-control" id="role">
                        <option 
                          value="user"
                          <?=$user['role'] == 'user' ? 'selected' : ''?>>Пользователь</option>
                        <option 
                          value="admin"
                          <?=$user['role'] == 'admin' ? 'selected' : ''?>>Администратор</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>
        </form>
    </div>
</div>