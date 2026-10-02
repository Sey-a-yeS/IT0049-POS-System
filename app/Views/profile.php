<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Account profile</span>
            <h1>Developer profile</h1>
            <p>The single demonstration user stored in the application database.</p>
        </div>
    </section>

    <section class="profile-panel" aria-labelledby="profile-title">
        <?php if ($user === null): ?>
            <p class="empty-profile">No user profile found.</p>
        <?php else: ?>
            <div class="profile-heading">
                <span class="profile-avatar" aria-hidden="true"><?= esc(strtoupper(substr($user['full_name'], 0, 1))) ?></span>
                <div>
                    <span class="section-kicker">Database user</span>
                    <h2 id="profile-title"><?= esc($user['full_name']) ?></h2>
                    <p>@<?= esc($user['username']) ?></p>
                </div>
            </div>

            <dl class="profile-details">
                <div><dt>Username</dt><dd><?= esc($user['username']) ?></dd></div>
                <div><dt>Full name</dt><dd><?= esc($user['full_name']) ?></dd></div>
                <div><dt>Email</dt><dd><a href="mailto:<?= esc($user['email'], 'attr') ?>"><?= esc($user['email']) ?></a></dd></div>
                <div><dt>Created</dt><dd><time datetime="<?= esc($user['created_at'], 'attr') ?>"><?= esc(date('F j, Y · g:i A', strtotime($user['created_at']))) ?></time></dd></div>
            </dl>
        <?php endif; ?>
    </section>
</div>

<?= view('templates/footer') ?>
