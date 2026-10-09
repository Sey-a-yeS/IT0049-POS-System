<?php
$taskTitle = old('title', $task['title'] ?? '');
$taskDate  = old('task_date', $task['task_date'] ?? '');
$status    = old('status', $task['status'] ?? 'pending');
$statuses  = [
    'pending'     => 'Pending',
    'in_progress' => 'In progress',
    'completed'   => 'Completed',
];
?>

<?php if ($errors !== []): ?>
    <div class="form-errors" role="alert" aria-labelledby="task-form-errors">
        <strong id="task-form-errors">Please correct the highlighted fields.</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="account-form" action="<?= esc($formAction, 'attr') ?>" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="form-field<?= isset($errors['title']) ? ' has-error' : '' ?>">
        <label for="title">Task title <span aria-hidden="true">*</span></label>
        <input id="title" name="title" type="text" maxlength="150" value="<?= esc($taskTitle, 'attr') ?>" aria-describedby="title_help<?= isset($errors['title']) ? ' title_error' : '' ?>">
        <small id="title_help">Required. Maximum of 150 characters.</small>
        <?php if (isset($errors['title'])): ?>
            <span class="field-error" id="title_error"><?= esc($errors['title']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-field<?= isset($errors['task_date']) ? ' has-error' : '' ?>">
        <label for="task_date">Task date <span aria-hidden="true">*</span></label>
        <input id="task_date" name="task_date" type="date" value="<?= esc($taskDate, 'attr') ?>" aria-describedby="task_date_help<?= isset($errors['task_date']) ? ' task_date_error' : '' ?>">
        <small id="task_date_help">Choose the date when this task should appear.</small>
        <?php if (isset($errors['task_date'])): ?>
            <span class="field-error" id="task_date_error"><?= esc($errors['task_date']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-field<?= isset($errors['status']) ? ' has-error' : '' ?>">
        <label for="status">Status <span aria-hidden="true">*</span></label>
        <select id="status" name="status" aria-describedby="status_help<?= isset($errors['status']) ? ' status_error' : '' ?>">
            <?php foreach ($statuses as $value => $label): ?>
                <option value="<?= esc($value, 'attr') ?>"<?= $status === $value ? ' selected' : '' ?>><?= esc($label) ?></option>
            <?php endforeach; ?>
        </select>
        <small id="status_help">Choose Pending, In progress, or Completed.</small>
        <?php if (isset($errors['status'])): ?>
            <span class="field-error" id="status_error"><?= esc($errors['status']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button class="button button-primary" type="submit"><?= esc($submitLabel) ?></button>
        <a class="button button-secondary" href="<?= site_url('tasks') ?>">Cancel</a>
    </div>
</form>
