<div class="logs">
    <?= $this->getDbLogs()?>
    
</div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
    const PATH = '<?= PATH?>';
    const ADMIN = '<?= ADMIN?>';
</script>
<!-- jQuery -->
<script src="<?= PATH ?>/adminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= PATH ?>/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= PATH ?>/adminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= PATH ?>/adminLTE/dist/js/demo.js"></script>
<script src="<?= PATH ?>/adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?= PATH ?>/adminLTE/plugins/select2/js/select2.full.js"></script>
<script src="<?= PATH ?>/adminLTE/override.js"></script>
</body>
</html>
