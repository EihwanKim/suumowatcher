<!-- File: src/Template/Pages/home.ctp -->
<?php if (!$isAuthorized): ?>
<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create(null, [
        'url' => ['controller' => 'Users', 'action' => 'login']
    ]) ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>
<?php endif; ?>