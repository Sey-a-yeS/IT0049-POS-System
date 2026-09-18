<?= view('templates/header') ?>

<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Simple. Organized. Reliable.</span>
            <h1>A clear starting point for everyday point-of-sale management.</h1>
            <p class="hero-copy">Welcome to the POS System. Browse customer contact information and staff account details from one clean, easy-to-use interface.</p>
            <div class="hero-actions">
                <a class="button button-primary" href="<?= site_url('customers') ?>">View Customers</a>
                <a class="button button-secondary" href="<?= site_url('users') ?>">View Staff Users</a>
            </div>
        </div>

        <aside class="hero-panel" aria-label="System overview">
            <span class="status-dot" aria-hidden="true"></span>
            <span class="status-label">System ready</span>
            <h2>POS Essentials</h2>
            <p>The first version focuses on straightforward account viewing while demonstrating the core CodeIgniter MVC workflow.</p>
            <div class="summary-row">
                <span>Data source</span>
                <strong>Static arrays</strong>
            </div>
            <div class="summary-row">
                <span>Framework</span>
                <strong>CodeIgniter 4</strong>
            </div>
        </aside>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Quick access</span>
                <h2>Account directories</h2>
            </div>
            <p>Choose a directory to view the sample records provided by its controller.</p>
        </div>

        <div class="feature-grid">
            <a class="feature-card" href="<?= site_url('customers') ?>">
                <span class="card-icon" aria-hidden="true">C</span>
                <div>
                    <h3>Customer Accounts</h3>
                    <p>Review customer names, email addresses, and phone numbers.</p>
                    <span class="card-link">Open directory <span aria-hidden="true">&rarr;</span></span>
                </div>
            </a>

            <a class="feature-card" href="<?= site_url('users') ?>">
                <span class="card-icon card-icon-warm" aria-hidden="true">U</span>
                <div>
                    <h3>User Accounts</h3>
                    <p>Review staff usernames, full names, and assigned roles.</p>
                    <span class="card-link">Open directory <span aria-hidden="true">&rarr;</span></span>
                </div>
            </a>
        </div>
    </div>
</section>

<?= view('templates/footer') ?>
