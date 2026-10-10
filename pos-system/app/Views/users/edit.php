<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">User Accounts</span>
            <h1>Edit User</h1>
            <p>Update account details and optionally replace the profile picture.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="edit-user-title">
        <div class="form-panel-heading">
            <span class="section-kicker">User #<?= esc($user['id']) ?></span>
            <h2 id="edit-user-title">Update user account</h2>
        </div>
        <?= view('users/form', [
            'user'        => $user,
            'errors'      => $errors,
            'formAction'  => site_url('users/' . $user['id']),
            'submitLabel' => 'Save changes',
            'allowAvatar' => true,
            'avatarUrl'   => $avatarUrl,
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
