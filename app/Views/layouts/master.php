<html>
    <head>
        <title>Site Title</title>
        <!-- <link rel="stylesheet" href="<?= base_url("public/css/style.css") ?>" /> -->
         <?= link_tag("public/css/style.css")?>
    </head>
    <body>
        
        <?= $this->include('partials/header')?>
        <?= $this->renderSection("body-contents") ?>
        <?= $this->include('partials/footer') ?>

        <!-- <script src="<?= base_url("public/js/script.js") ?>"></script> -->
         <?= script_tag("public/js/script.js") ?>
    </body>
</html>