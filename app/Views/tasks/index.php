<?= view('templates/header') ?>

<div class="content-wrap">
    <section class="page-intro directory-intro">
        <div>
            <span class="eyebrow">Complete schedule</span>
            <h1>All tasks</h1>
            <p>Every task in the database, ordered by its scheduled date.</p>
        </div>
        <div class="record-count" aria-label="<?= esc(count($tasks)) ?> total tasks">
            <strong><?= esc(count($tasks)) ?></strong>
            <span>Total tasks</span>
        </div>
    </section>

    <section class="table-panel" aria-labelledby="all-task-title">
        <div class="table-toolbar">
            <div>
                <span class="section-kicker">Task register</span>
                <h2 id="all-task-title">All scheduled tasks</h2>
            </div>
            <span class="data-label">ordered by task_date</span>
        </div>

        <div class="table-scroll" tabindex="0">
            <table>
                <caption class="sr-only">All tasks ordered by date</caption>
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
                            <td class="empty-state" colspan="5">No tasks found.</td>
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
</div>

<?= view('templates/footer') ?>
