<?php include 'admin_nav.php'; ?>
<div class="card">
  <div class="card-body">
    <h5><?= isset($candidate) ? 'Edit' : 'Tambah' ?> Kandidat</h5>
    <form action="/admin/candidates/save" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= isset($candidate) ? $candidate['id'] : '' ?>">
      <div class="mb-3">
        <label>Nama Kandidat</label>
        <input name="name" class="form-control" value="<?= isset($candidate) ? esc($candidate['name']) : '' ?>" required>
      </div>
      <div class="mb-3">
        <label>Deskripsi singkat</label>
        <textarea name="description" class="form-control" rows="3"><?= isset($candidate) ? esc($candidate['description']) : '' ?></textarea>
      </div>
      <div class="mb-3">
        <label>Foto Kandidat</label>
        <input type="file" name="photo" class="form-control">
        <?php if (isset($candidate) && $candidate['photo']): ?>
            <img src="<?= $candidate['photo'] ?>" width="150" class="mt-2">
        <?php endif; ?>
      </div>
      <button class="btn btn-primary"><?= isset($candidate) ? 'Update' : 'Simpan' ?></button>
    </form>
  </div>
</div>
