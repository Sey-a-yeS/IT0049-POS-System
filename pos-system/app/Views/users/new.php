<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">User Accounts</span>
            <h1>New User</h1>
            <p>Create a staff user with a unique username.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="new-user-title">
        <div class="form-panel-heading">
            <span class="section-kicker">User details</span>
            <h2 id="new-user-title">Create user account</h2>
        </div>
        <?= view('users/form', [
            'user'        => [],
            'errors'      => $errors,
            'formAction'  => site_url('users'),
            'submitLabel' => 'Create user',
            'allowAvatar' => false,
            'avatarUrl'   => '',
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
