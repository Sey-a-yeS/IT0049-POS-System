<?php
$fullName = old('full_name', $customer['full_name'] ?? '');
$email    = old('email', $customer['email'] ?? '');
$phone    = old('phone', $customer['phone'] ?? '');
?>

<?php if ($errors !== []): ?>
    <div class="form-errors" role="alert" aria-labelledby="customer-form-errors">
        <strong id="customer-form-errors">Please correct the highlighted fields.</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="account-form" action="<?= esc($formAction, 'attr') ?>" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="form-field<?= isset($errors['full_name']) ? ' has-error' : '' ?>">
        <label for="full_name">Full name <span aria-hidden="true">*</span></label>
        <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc($fullName, 'attr') ?>" autocomplete="name" aria-describedby="full_name_help<?= isset($errors['full_name']) ? ' full_name_error' : '' ?>">
        <small id="full_name_help">Enter the customer's complete name.</small>
        <?php if (isset($errors['full_name'])): ?>
            <span class="field-error" id="full_name_error"><?= esc($errors['full_name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-field<?= isset($errors['email']) ? ' has-error' : '' ?>">
        <label for="email">Email address <span aria-hidden="true">*</span></label>
        <input id="email" name="email" type="email" maxlength="100" value="<?= esc($email, 'attr') ?>" autocomplete="email" aria-describedby="email_help<?= isset($errors['email']) ? ' email_error' : '' ?>">
        <small id="email_help">Use a valid email address such as name@example.com.</small>
        <?php if (isset($errors['email'])): ?>
            <span class="field-error" id="email_error"><?= esc($errors['email']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-field<?= isset($errors['phone']) ? ' has-error' : '' ?>">
        <label for="phone">Phone number</label>
        <input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($phone, 'attr') ?>" autocomplete="tel" aria-describedby="phone_help<?= isset($errors['phone']) ? ' phone_error' : '' ?>">
        <small id="phone_help">Optional. Maximum of 20 characters.</small>
        <?php if (isset($errors['phone'])): ?>
            <span class="field-error" id="phone_error"><?= esc($errors['phone']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button class="button button-primary" type="submit"><?= esc($submitLabel) ?></button>
        <a class="button button-secondary" href="<?= site_url('customers') ?>">Cancel</a>
    </div>
</form>
