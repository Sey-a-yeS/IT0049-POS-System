<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Task management</span>
            <h1>Edit task</h1>
            <p>Update the selected active task without changing its archive state.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="edit-task-title">
        <div class="form-panel-heading">
            <span class="section-kicker">Task #<?= esc($task['id']) ?></span>
            <h2 id="edit-task-title">Update task details</h2>
        </div>
        <?= view('tasks/form', [
            'task'        => $task,
            'errors'      => $errors,
            'formAction'  => site_url('tasks/' . $task['id']),
            'submitLabel' => 'Save changes',
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
