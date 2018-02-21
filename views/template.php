<html>
<head>
    <title><?= $this->e($pageTitle) ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/js/bootstrap/css/bootstrap.min.css" type="text/css"/>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12" style="padding:20px;">
            <img class="mb-4" src="/img/lezhnev.png" alt="" width="72" height="72">
        </div>
    </div>

    <!-- flashes -->
    <?php $this->insert('flashes') ?>
</div>

<?= $this->section('content') ?>

<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/bootstrap/js/bootstrap.min.js"></script>
<?= $this->section('footer') ?>
</body>
</html>