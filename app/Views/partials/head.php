<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="baseurl" content="<?= baseUrl() ?>">

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.24/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="<?= assetsUrl("css/main.min.css") ?>">

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.24/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.24/dist/js/uikit-icons.min.js"></script>

    
    <title><?= $title ?? APPNAME; ?></title>
</head>
<body class="uk-background-muted">

    <?php $this->insert('partials/header') ?>