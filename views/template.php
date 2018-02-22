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
        <div class="col-xs-12 col-md-6" style="padding:20px;">
            <img class="mb-4" src="/img/lezhnev.png" alt="" width="72" height="72">
        </div>
        <div class="col-xs-12 col-md-6" style="padding:20px;">
            <?= translate('http.labels.language') ?>:
            <ul>
            <?php foreach(config('translation.supported') as $key=>$title): ?>
                <li><a href="/lang/<?=$key?>"><?= $title ?></a></li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- flashes -->
    <?php $this->insert('flashes') ?>
</div>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12" style="padding:20px;">
            <span class="text-muted">lezhnev.work@gmail.com</span><br>
            <span><a href="https://github.com/lezhnev74/PHP-test-app">GitHub Repo</a></span>
        </div>
    </div>
</div>


<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/bootstrap/js/bootstrap.min.js"></script>
<?= $this->section('footer') ?>
</body>
</html>