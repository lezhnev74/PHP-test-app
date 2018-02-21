<?php foreach (array_get($flash, 'info', []) as $message): ?>
    <div class="alert alert-info"><?= $this->e($message) ?></div>
<?php endforeach; ?>
<?php foreach (array_get($flash, 'error', []) as $message): ?>
    <div class="alert alert-danger"><?= $this->e($message) ?></div>
<?php endforeach; ?>
