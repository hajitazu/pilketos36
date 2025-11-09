<div class="row">
    <?php if (empty($candidates)): ?>
        <div class="col-12">
            <div class="alert alert-info">Belum ada kandidat. Hubungi admin.</div>
        </div>
    <?php endif; ?>

    <?php foreach ($candidates as $c): ?>
    <div class="col-md-4">
        <div class="card mb-3">
            <img src="<?= $c['photo'] ?: 'https://via.placeholder.com/600x400' ?>" class="card-img-top candidate-photo" alt="Foto kandidat">
            <div class="card-body">
                <h5 class="card-title"><?= esc($c['name']) ?></h5>
                <p class="card-text"><?= esc($c['description']) ?></p>
                <form action="/voting/vote" method="post" onsubmit="return confirm('Yakin memilih <?= esc($c['name']) ?>?')">
                    <?= csrf_field() ?>
                    <input type="hidden" name="candidate_id" value="<?= $c['id'] ?>">
                    <button class="btn btn-success w-100">Vote</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
