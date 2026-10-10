<?= view('templates/header') ?>

<div class="content-wrap">
    <?php if ($success = session('success')): ?>
        <div class="flash-message" role="status"><?= esc($success) ?></div>
    <?php endif; ?>

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
            <div class="toolbar-actions">
                <span class="data-label">users table</span>
                <a class="button button-primary" href="<?= site_url('users/new') ?>">New User</a>
            </div>
        </div>

            <div class="table-scroll" tabindex="0">
                <table>
                    <caption class="sr-only">Staff user account records</caption>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Username</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($users === []): ?>
                            <tr>
                                <td class="empty-state" colspan="6">No user accounts found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><span class="row-id">#<?= esc($user['id']) ?></span></td>
                                    <td><img class="avatar-thumbnail" src="<?= esc($user['avatar_url'], 'attr') ?>" alt="Avatar for <?= esc($user['full_name'], 'attr') ?>"></td>
                                    <td><span class="username"><?= esc($user['username']) ?></span></td>
                                    <td><strong><?= esc($user['full_name']) ?></strong></td>
                                    <td><time datetime="<?= esc($user['created_at'], 'attr') ?>"><?= esc(date('M j, Y · g:i A', strtotime($user['created_at']))) ?></time></td>
                                    <td><a class="action-link" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    </section>
</div>

<?= view('templates/footer') ?>
