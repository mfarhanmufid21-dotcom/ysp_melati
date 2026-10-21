<?php
/**
 * <head> bersama untuk halaman informasi.
 * Variabel: $title, $description, $canonical (opsional)
 */
$title       = $title ?? 'YSP Jasmine';
$description = $description ?? 'Toko bunga melati online YSP Jasmine.';
$canonical   = $canonical ?? current_url();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | YSP Jasmine</title>
    <meta name="description" content="<?= esc($description) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= esc($canonical) ?>">
    <meta property="og:title" content="<?= esc($title) ?> | YSP Jasmine">
    <meta property="og:description" content="<?= esc($description) ?>">
    <meta property="og:image" content="<?= base_url('uploads/gambar2.png') ?>">
    <meta property="og:url" content="<?= esc($canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
</head>
