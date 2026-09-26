<?= view('templates/header') ?>

<div class="content-wrap">
    <section class="page-intro directory-intro">
        <div>
            <span class="eyebrow">Staff directory</span>
            <h1>User Accounts</h1>
            <p>Identity and account metadata for staff users stored in the POS database.</p>
        </div>
        <div class="record-count" aria-label="<?= esc(count($users)) ?> user records">
            <strong><?= esc(count($users)) ?></strong>
            <span>Total records</span>
        </div>
    </section>

    <section class="table-panel" aria-labelledby="user-table-title">
        <div class="table-toolbar">
            <div>
                <span class="section-kicker">Database directory</span>
                <h2 id="user-table-title">Staff user records</h2>
            </div>
            <span class="data-label">users table</span>
        </div>

            <div class="table-scroll" tabindex="0">
                <table>
                    <caption class="sr-only">Staff user account records</caption>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($users === []): ?>
                            <tr>
                                <td class="empty-state" colspan="4">No user accounts found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><span class="row-id">#<?= esc($user['id']) ?></span></td>
                                    <td><span class="username"><?= esc($user['username']) ?></span></td>
                                    <td><strong><?= esc($user['full_name']) ?></strong></td>
                                    <td><time datetime="<?= esc($user['created_at'], 'attr') ?>"><?= esc(date('M j, Y · g:i A', strtotime($user['created_at']))) ?></time></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    </section>
</div>

<?= view('templates/footer') ?>
