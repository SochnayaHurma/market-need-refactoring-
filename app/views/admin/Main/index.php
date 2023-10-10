
      <!-- Default box -->
      <div class="card">
        <div class="card-body">
          <div class="conteiner-fluid">
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?=$orders?></h3>
                    <p>Заказов</p>
                  </div>
                  <div class="icon"><i class="fas fa-shopping-bag"></i></div>
                  <a href="<?=ADMIN.'/order'?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?=$new_orders?></h3>
                    <p>Новых заказов</p>
                  </div>
                  <div class="icon"><i class="fa-solid fa-cart-flatbed-suitcase"></i></div>
                  <a 
                    href="<?=ADMIN.'/orders?status=0'?>" 
                    class="small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?=$users?></h3>
                    <p>Пользователей</p>
                  </div>
                  <div class="icon"><i class="fas fa-user-friends"></i></div>
                  <a href="<?=ADMIN.'/user'?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?=$products?></h3>
                    <p>Продуктов</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-barcode"></i>
                  </div>
                  <a href="<?=ADMIN.'/product'?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->