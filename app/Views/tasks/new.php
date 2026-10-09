<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Task management</span>
            <h1>New task</h1>
            <p>Add a dated task to the active schedule.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="new-task-title">
        <div class="form-panel-heading">
            <span class="section-kicker">Task details</span>
            <h2 id="new-task-title">Create an active task</h2>
        </div>
        <?= view('tasks/form', [
            'task'        => [],
            'errors'      => $errors,
            'formAction'  => site_url('tasks'),
            'submitLabel' => 'Create task',
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
