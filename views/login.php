<?php $this->layout('template', ['pageTitle' => 'Please log in']) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <form method="post" action="/login" enctype="multipart/form-data">

                <input type="hidden" name="<?= $this->e($csrf['name']) ?>" value="<?= $this->e($csrf['value']) ?>">

                <img class="mb-4" src="/img/lezhnev.png" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Регистрация на сайте</h1>

                <div class="form-group">
                    <label for="exampleInputEmail1">Электронная почта</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           placeholder="Введите электроонную почту">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Придумайте пароль</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Повторите пароль</label>
                    <input type="password" class="form-control" id="pwdRe" placeholder="Пароль">
                </div>

                <button type="submit" class="btn btn-primary">Войти на сайт</button>

            </form>

        </div>
    </div>
</div>

