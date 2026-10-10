<?= view('templates/header') ?>

<div class="content-wrap">
    <section class="page-intro directory-intro">
        <div>
            <span class="eyebrow">Daily focus</span>
            <h1>Tasks for today</h1>
            <p><?= esc(date('l, F j, Y', strtotime($today))) ?> &mdash; only tasks scheduled for today are shown here.</p>
        </div>
        <div class="record-count" aria-label="<?= esc(count($tasks)) ?> tasks scheduled today">
            <strong><?= esc(count($tasks)) ?></strong>
            <span>Due today</span>
        </div>
    </section>

    <section class="table-panel" aria-labelledby="today-task-title">
        <div class="table-toolbar">
            <div>
                <span class="section-kicker">Today's schedule</span>
                <h2 id="today-task-title">Current tasks</h2>
            </div>
            <div class="toolbar-actions">
                <span class="data-label">active tasks</span>
                <?php if (session('isLoggedIn') === true): ?>
                    <a class="button button-primary" href="<?= site_url('tasks/new') ?>">New Task</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-scroll" tabindex="0">
            <table>
                <caption class="sr-only">Tasks scheduled for today</caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Task</th>
                        <th scope="col">Status</th>
                        <th scope="col">Task Date</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tasks === []): ?>
                        <tr>
                            <td class="empty-state" colspan="5">No tasks are scheduled for today.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><span class="row-id">#<?= esc($task['id']) ?></span></td>
                                <td><strong><?= esc($task['title']) ?></strong></td>
                                <td><span class="status-badge"><?= esc(ucwords(str_replace('_', ' ', $task['status']))) ?></span></td>
                                <td><time datetime="<?= esc($task['task_date'], 'attr') ?>"><?= esc(date('M j, Y', strtotime($task['task_date']))) ?></time></td>
                                <td><time datetime="<?= esc($task['created_at'], 'attr') ?>"><?= esc(date('M j, Y · g:i A', strtotime($task['created_at']))) ?></time></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div class="page-action">
        <a class="button button-primary" href="<?= site_url('tasks') ?>">View all tasks</a>
    </div>
</div>

<?= view('templates/footer') ?>
