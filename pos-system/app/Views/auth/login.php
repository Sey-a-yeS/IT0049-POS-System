<?= view('templates/header') ?>

<div class="content-wrap login-shell">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Protected workspace</span>
            <h1>Staff login</h1>
            <p>Sign in with an existing staff username and its locally initialized password.</p>
        </div>
    </section>

    <section class="form-panel login-panel" aria-labelledby="login-form-title">
        <div class="form-panel-heading">
            <span class="section-kicker">Authentication</span>
            <h2 id="login-form-title">Access the management console</h2>
        </div>

        <?php if ($authError !== null): ?>
            <div class="form-errors" role="alert">
                <strong><?= esc($authError) ?></strong>
            </div>
        <?php endif; ?>

        <?php if ($errors !== []): ?>
            <div class="form-errors" role="alert" aria-labelledby="login-errors-title">
                <strong id="login-errors-title">Please correct the highlighted fields.</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="account-form" action="<?= site_url('login') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="form-field<?= isset($errors['username']) ? ' has-error' : '' ?>">
                <label for="username">Username <span aria-hidden="true">*</span></label>
                <input id="username" name="username" type="text" maxlength="50" value="<?= esc($oldUsername, 'attr') ?>" autocomplete="username" autofocus>
                <?php if (isset($errors['username'])): ?>
                    <span class="field-error"><?= esc($errors['username']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-field<?= isset($errors['password']) ? ' has-error' : '' ?>">
                <label for="password">Password <span aria-hidden="true">*</span></label>
                <input id="password" name="password" type="password" maxlength="255" value="" autocomplete="current-password">
                <?php if (isset($errors['password'])): ?>
                    <span class="field-error"><?= esc($errors['password']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button class="button button-primary" type="submit">Sign in</button>
            </div>
        </form>
    </section>
</div>

<?= view('templates/footer') ?>
