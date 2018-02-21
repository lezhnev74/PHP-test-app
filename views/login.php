<?php $this->layout('template', ['pageTitle' => 'Please log in']) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <form method="post" action="/login" enctype="multipart/form-data">

                <input type="hidden" name="csrf_token" value="<?= $this->e($csrf) ?>">

                <div class="form-group">
                    <label for="exampleInputEmail1">Электронная почта</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           placeholder="Введите электроонную почту">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Придумайте пароль</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Пароль">
                </div>

                <button type="submit" class="btn btn-primary">Войти на сайт</button>

            </form>

        </div>
    </div>
</div>

