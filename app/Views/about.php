<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
        <span class="eyebrow">About the project</span>
        <h1>CodeIgniter 4 POS System</h1>
        <p>A complete retail operations workspace for secure inventory, customer, staff, and single-product sales management.</p>
        </div>
    </section>

    <section class="about-section">
        <div class="about-block">
            <span class="section-kicker">Assessment context</span>
            <h2>The Complete Point-of-Sale System</h2>
            <p>The Midterm Project was created for IT0049 &mdash; Web System Technologies by Isaiah Ezekiel P. Vicencio and extends the TFA1–TFA4 foundation into an integrated sales application.</p>
        </div>

        <div class="about-block">
            <span class="section-kicker">Access control</span>
            <h2>Verified staff sessions</h2>
            <p>CodeIgniter validates login requests, verifies stored password hashes, regenerates the session identifier, and protects every product, customer, staff, and sales-management route.</p>
        </div>

        <div class="about-block">
            <span class="section-kicker">Application flow</span>
            <h2>Clear MVC responsibilities</h2>
            <div class="process" aria-label="Application request flow">
                <span>Database</span>
                <span aria-hidden="true">&rarr;</span>
                <span>Model</span>
                <span aria-hidden="true">&rarr;</span>
                <span>Controller</span>
                <span aria-hidden="true">&rarr;</span>
                <span>View</span>
                <span aria-hidden="true">&rarr;</span>
                <span>HTML</span>
            </div>
        </div>

        <div class="about-block">
            <span class="section-kicker">Transaction integrity</span>
            <h2>Reliable stock movement</h2>
            <p>Every sale uses the database product price, a conditional stock decrement, and a single database transaction so insufficient inventory cannot create partial or negative-stock sales.</p>
        </div>
    </section>
</div>

<?= view('templates/footer') ?>
