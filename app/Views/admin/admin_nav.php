<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="/admin/dashboard">Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/admin/settings">Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/candidates">Kandidat</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/results">Hasil</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/admin/logout">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
