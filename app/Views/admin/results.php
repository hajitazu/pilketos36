<?php include 'admin_nav.php'; ?>
<h4>Hasil Pemungutan Suara</h4>
<?php if ($is_open): ?>
<form action="/admin/end" method="post" onsubmit="return confirm('Akhiri pemungutan suara?')">
    <?= csrf_field() ?>
    <button class="btn btn-danger mb-3">Akhiri Pemungutan Suara</button>
</form>
<?php else: ?>
<div class="alert alert-warning">Pemungutan suara telah ditutup.</div>
<?php endif; ?>

<table class="table">
<thead><tr><th>Kandidat</th><th>Suara</th></tr></thead>
<tbody>
<?php foreach ($candidates as $c): ?>
<tr>
    <td><?= esc($c['name']) ?></td>
    <td><?= $c['votes'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (!empty($candidates)): ?>
<h5>Pemenang: <?= esc($candidates[0]['name']) ?> (<?= $candidates[0]['votes'] ?> suara)</h5>
<?php endif; ?>
