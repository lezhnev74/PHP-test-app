<?php /** @var \SignupForm\Account\Model\Profile $profile */ ?>
<?php $this->layout('template', ['pageTitle' => translate('http.labels.profile')]) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h1 class="h3 mb-3 font-weight-normal"><?= $this->e(translate('http.labels.profile')) ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <table class="table table-bordered">
                <tr>
                    <td><?= $this->e(translate('http.labels.email')) ?></td>
                    <td><?= $this->e($profile->getCredentials()->getLogin()) ?></td>
                </tr>
                <tr>
                    <td><?= $this->e(translate('http.labels.photo')) ?></td>
                    <td><img src="/<?= $this->e($profile->getPhotoRelativePath()) ?>" style="width:30px;"></td>
                </tr>
                <tr>
                    <td><?= $this->e(translate('http.labels.first_name')) ?></td>
                    <td><?= $this->e($profile->getPassport()->getFirstName()) ?></td>
                </tr>
                <tr>
                    <td><?= $this->e(translate('http.labels.last_name')) ?></td>
                    <td><?= $this->e($profile->getPassport()->getLastName()) ?></td>
                </tr>
                <tr>
                    <td><?= $this->e(translate('http.labels.passport')) ?></td>
                    <td><?= $this->e($profile->getPassport()->getNumber()) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
