<?php $this->layout('template', ['pageTitle' => translate('http.labels.login')]) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h1 class="h3 mb-3 font-weight-normal"><?= $this->e(translate('http.labels.login')) ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <form method="post" action="/login">

                <input type="hidden" name="csrf_token" value="<?= $this->e($csrf) ?>">

                <div class="form-group">
                    <label><?= $this->e(translate('http.labels.email')) ?></label>
                    <input type="email" class="form-control" required id="email" name="email">
                </div>
                <div class="form-group">
                    <label><?= $this->e(translate('http.labels.password')) ?></label>
                    <input type="password" class="form-control" id="pwd" required minlength="6" name="password">
                </div>

                <button type="submit" class="btn btn-primary"><?= $this->e(translate('http.labels.login')) ?></button>
                <hr>
                <a href="/signup"><?= $this->e(translate('http.labels.signup')) ?></a>

            </form>

        </div>
    </div>
</div>

<?php $this->push('footer') ?>
<script src="/js/helper.js"></script>
<script>
    // Dictionary for messages
    var error_messages = <?= json_encode($error_messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>;

    $(function () {
        $("form").submit(function () {
            // Flush previous error state
            flushErrors();

            // Here I will not rely on built-in validation API (from browser) and will manually validate each field

            // 1. validate email
            var email = $("#email").val();
            var emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!emailRegExp.test(email)) {
                reportError("#email", error_messages.email);
                return false;
            }

            // 2. validate password and confirmation
            var password = $("#pwd").val();
            if (password.length < 6) {
                reportError("#pwd", error_messages.password);
                return false;
            }
        });
    });
</script>
<?php $this->end() ?>
