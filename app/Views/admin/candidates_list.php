<?php include 'admin_nav.php'; ?>
<div class="mb-2">
    <a href="/admin/candidates/new" class="btn btn-success">Tambah Kandidat</a>
</div>
<table class="table table-striped">
    <thead><tr><th>Foto</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($candidates as $c): ?>
        <tr>
            <td style="width:120px"><img src="<?= $c['photo'] ?: 'https://via.placeholder.com/120' ?>" width="100"></td>
            <td><?= esc($c['name']) ?></td>
            <td><?= esc($c['description']) ?></td>
            <td>
                <a href="/admin/candidates/edit/<?= $c['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="/admin/candidates/delete/<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kandidat?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
