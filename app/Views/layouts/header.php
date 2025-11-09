<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= isset($settings['site_name']) ? esc($settings['site_name']) : 'Sistem Pemilihan Ketua OSIS' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .site-header { background: <?= isset($settings['header_color']) ? esc($settings['header_color']) : '#0d6efd' ?>; color: #fff; padding: 12px 0; }
        .candidate-photo { width: 100%; height: 200px; object-fit: cover; }
    </style>
</head>
<body>
<header class="site-header mb-4">
    <div class="container d-flex align-items-center">
        <img src="<?= isset($settings['logo']) ? esc($settings['logo']) : 'https://via.placeholder.com/60' ?>" height="50" class="me-3" alt="logo">
        <h3 class="mb-0"><?= isset($settings['site_name']) ? esc($settings['site_name']) : 'Pemilihan Ketua OSIS' ?></h3>
    </div>
</header>
<div class="container">
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
