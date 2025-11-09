<?php include 'admin_nav.php'; ?>
<div class="card mb-3">
  <div class="card-body">
    <h5>Pengaturan Website</h5>
    <form action="/admin/settings/save" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label>Nama Website</label>
        <input name="site_name" class="form-control" value="<?= isset($settings['site_name']) ? esc($settings['site_name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label>Warna Header (CSS)</label>
        <input name="header_color" class="form-control" value="<?= isset($settings['header_color']) ? esc($settings['header_color']) : '#0d6efd' ?>">
      </div>
      <div class="mb-3">
        <label>Logo (png/jpg)</label>
        <input type="file" name="logo" class="form-control">
      </div>
      <div class="mb-3">
        <label>Banner</label>
        <input type="file" name="banner" class="form-control">
      </div>
      <div class="mb-3">
        <label>Favicon</label>
        <input type="file" name="favicon" class="form-control">
      </div>
      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
