<?php
$username = old('username', $user['username'] ?? '');
$fullName = old('full_name', $user['full_name'] ?? '');
?>

<?php if ($errors !== []): ?>
    <div class="form-errors" role="alert" aria-labelledby="user-form-errors">
        <strong id="user-form-errors">Please correct the highlighted fields.</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="account-form" action="<?= esc($formAction, 'attr') ?>" method="post"<?= $allowAvatar ? ' enctype="multipart/form-data"' : '' ?> novalidate>
    <?= csrf_field() ?>

    <div class="form-field<?= isset($errors['username']) ? ' has-error' : '' ?>">
        <label for="username">Username <span aria-hidden="true">*</span></label>
        <input id="username" name="username" type="text" maxlength="50" value="<?= esc($username, 'attr') ?>" autocomplete="username" aria-describedby="username_help<?= isset($errors['username']) ? ' username_error' : '' ?>">
        <small id="username_help">Usernames must be unique.</small>
        <?php if (isset($errors['username'])): ?>
            <span class="field-error" id="username_error"><?= esc($errors['username']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-field<?= isset($errors['full_name']) ? ' has-error' : '' ?>">
        <label for="full_name">Full name <span aria-hidden="true">*</span></label>
        <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc($fullName, 'attr') ?>" autocomplete="name" aria-describedby="full_name_help<?= isset($errors['full_name']) ? ' full_name_error' : '' ?>">
        <small id="full_name_help">Enter the staff user's complete name.</small>
        <?php if (isset($errors['full_name'])): ?>
            <span class="field-error" id="full_name_error"><?= esc($errors['full_name']) ?></span>
        <?php endif; ?>
    </div>

    <?php if ($allowAvatar): ?>
        <div class="form-field avatar-field<?= isset($errors['avatar']) ? ' has-error' : '' ?>">
            <label for="avatar">Profile picture</label>
            <div class="current-avatar">
                <img src="<?= esc($avatarUrl, 'attr') ?>" alt="Current avatar for <?= esc($user['full_name'], 'attr') ?>">
                <span>The current image remains when no replacement is selected.</span>
            </div>
            <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" aria-describedby="avatar_help<?= isset($errors['avatar']) ? ' avatar_error' : '' ?>">
            <small id="avatar_help">Optional JPG or PNG only. Maximum size: 2 MB.</small>
            <?php if (isset($errors['avatar'])): ?>
                <span class="field-error" id="avatar_error"><?= esc($errors['avatar']) ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <button class="button button-primary" type="submit"><?= esc($submitLabel) ?></button>
        <a class="button button-secondary" href="<?= site_url('users') ?>">Cancel</a>
    </div>
</form>
