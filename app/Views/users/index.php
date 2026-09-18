<?= view('templates/header') ?>

<section class="page-banner compact-banner">
    <div class="container">
        <span class="eyebrow">Staff directory</span>
        <h1>User Accounts</h1>
        <p>Account and role information for the POS System's sample staff.</p>
    </div>
</section>

<section class="section table-section">
    <div class="container">
        <div class="table-card">
            <div class="table-card-heading">
                <div>
                    <h2>Staff Users</h2>
                    <p><?= esc(count($users)) ?> records available</p>
                </div>
                <span class="data-badge">Static data</span>
            </div>

            <div class="table-scroll">
                <table>
                    <caption class="sr-only">Staff user account records</caption>
                    <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><span class="username"><?= esc($user['username']) ?></span></td>
                                <td><strong><?= esc($user['full_name']) ?></strong></td>
                                <td><span class="role-badge"><?= esc($user['role']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= view('templates/footer') ?>
