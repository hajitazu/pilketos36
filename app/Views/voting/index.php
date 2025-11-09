<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Masuk Voting</h4>
                <p>Masukkan token Anda (contoh: 9A001)</p>
                <form action="/voting/login" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" name="token" class="form-control" placeholder="Token (misal: 9A001)" required>
                    </div>
                    <button class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
