<?= view('templates/header') ?>

<div class="content-wrap">
    <section class="page-intro home-intro">
        <div>
            <span class="eyebrow">Overview</span>
            <h1>Point-of-sale workspace</h1>
            <p>Browse customer contact information and staff account details from one focused management interface.</p>
        </div>
        <div class="intro-actions">
            <?php if (session('isLoggedIn') === true): ?>
                <a class="button button-primary" href="<?= site_url('customers') ?>">View customers</a>
                <a class="button button-secondary" href="<?= site_url('users') ?>">View staff users</a>
            <?php else: ?>
                <a class="button button-primary" href="<?= site_url('login') ?>">Staff login</a>
            <?php endif; ?>
        </div>
    </section>

    <section class="workspace-overview" aria-labelledby="system-overview-title">
        <div class="overview-copy">
            <span class="section-kicker">System overview</span>
            <h2 id="system-overview-title">A focused directory for essential POS accounts.</h2>
            <p>The application demonstrates a clean CodeIgniter MVC workflow with database-backed account listings, validated forms, profile-image preparation, and session-based access control.</p>
        </div>
        <dl class="system-facts">
            <div><dt>Framework</dt><dd>CodeIgniter 4</dd></div>
            <div><dt>Data source</dt><dd>MySQL database</dd></div>
            <div><dt>Access</dt><dd>Authenticated staff</dd></div>
        </dl>
    </section>

    <?php if (session('isLoggedIn') === true): ?>
        <section class="directory-section" aria-labelledby="directory-title">
            <div class="section-heading">
                <div>
                    <span class="section-kicker">Quick access</span>
                    <h2 id="directory-title">Account directories</h2>
                </div>
                <p>Open a database-backed directory to review its current records.</p>
            </div>

            <div class="directory-grid">
                <a class="directory-link" href="<?= site_url('customers') ?>">
                    <span class="directory-index" aria-hidden="true">01</span>
                    <span class="directory-copy">
                        <strong>Customer Accounts</strong>
                        <span>Review, create, and edit customer contact information.</span>
                    </span>
                    <span class="directory-arrow" aria-hidden="true">&rarr;</span>
                </a>

                <a class="directory-link" href="<?= site_url('users') ?>">
                    <span class="directory-index" aria-hidden="true">02</span>
                    <span class="directory-copy">
                        <strong>User Accounts</strong>
                        <span>Review, create, edit, and manage staff profile pictures.</span>
                    </span>
                    <span class="directory-arrow" aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </section>
    <?php else: ?>
        <section class="directory-section" aria-labelledby="security-title">
            <div class="section-heading">
                <div>
                    <span class="section-kicker">Protected workspace</span>
                    <h2 id="security-title">Account management requires a staff session.</h2>
                </div>
                <p>Sign in with an initialized staff account to manage customer and user records.</p>
            </div>
        </section>
    <?php endif; ?>
</div>

<?= view('templates/footer') ?>
