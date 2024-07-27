<?php $this->getPart('admin/parts/header')?>

<?php $this->getPart('admin/parts/sidebar')?>
/**
@var $this \dopler_core\View
*/
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1><?= $title ?? '' ?></h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Success!</h5>
          <?= $_SESSION['success']; unset($_SESSION['success'])?>
        </div>
      <?php endif;?>
      <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <?= $_SESSION['errors']; unset($_SESSION['errors'])?>
        </div>
      <?php endif;?>
      <?= $this->content ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->getPart('admin/parts/footer')?>