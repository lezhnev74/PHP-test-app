<?php $this->layout('template', ['pageTitle' => translate('http.labels.signup')]) ?>

    <form method="post" action="/signup" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <h1 class="h3 mb-3 font-weight-normal"><?= $this->e(translate('http.labels.signup')) ?></h1>
                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 col-md-4">

                    <input type="hidden" name="csrf_token" value="<?= $this->e($csrf) ?>">

                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.email')) ?></label>
                        <input type="text" class="form-control" required
                               id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.password')) ?></label>
                        <input type="password" class="form-control" id="pwd" required
                               minlength="6" name="password">
                    </div>
                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.passwordConfirm')) ?></label>
                        <input type="password" class="form-control" id="pwdRe" required
                               minlength="6" name="password2">
                    </div>

                </div>

                <div class="col-xs-12 col-md-4">


                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.first_name')) ?></label>
                        <input type="text" class="form-control" id="first_name" required
                               minlength="1" name="first_name">
                    </div>
                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.last_name')) ?></label>
                        <input type="text" class="form-control" id="last_name"
                               required
                               minlength="1" name="last_name">
                    </div>
                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.passport')) ?></label>
                        <input type="text" class="form-control" id="passport"
                               required minlength="1" name="passport">
                    </div>

                </div>

                <div class="col-xs-12 col-md-4">


                    <div class="form-group">
                        <label><?= $this->e(translate('http.labels.photo')) ?></label>
                        <input type="file" class="form-control" id="photo" required name="photo">
                    </div>

                </div>

            </div>


            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <hr>
                    <button type="submit" class="btn btn-primary"><?= $this->e(translate('http.labels.signup')) ?></button>
                    <hr>
                    <a href="/login"><?= $this->e(translate('http.labels.login')) ?></a>
                </div>
            </div>
        </div>
    </form>


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
                var password2 = $("#pwdRe").val();
                if (password.length < 6) {
                    reportError("#pwd", error_messages.password);
                    return false;
                }
                if (password2 != password) {
                    reportError("#pwdRe", error_messages.passwordConfirmation);
                    return false;
                }

                // 3. Validate names and passport
                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                var passport = $("#passport").val();
                if (!first_name.trim().length) {
                    reportError("#first_name", error_messages.first_name);
                    return false;
                }
                if (!last_name.trim().length) {
                    reportError("#last_name", error_messages.last_name);
                    return false;
                }
                if (!passport.trim().length) {
                    reportError("#password", error_messages.passport);
                    return false;
                }

                // 4. Validate file field
                // Taken from: https://stackoverflow.com/a/7977314/1637031
                var photo = $('#photo');

                if (!isImage(photo.val())) {
                    reportError("#photo", error_messages.photo);
                    return false;
                }

                // Maybe extension is not enough, so I will try to check the mime type of browser supports it
                var allowed = ['image/gif', 'image/png', 'image/jpeg'];
                var photoMime = document.getElementById('photo').files[0].type;
                if (!$.inArray(allowed, photoMime.toLowerCase())) {
                    $("#photo").addClass("is-invalid");
                    return false;
                }

            });
        });
    </script>
<?php $this->end() ?>