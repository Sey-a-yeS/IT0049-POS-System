<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
        <span class="eyebrow">About the project</span>
        <h1>CodeIgniter 4 POS System</h1>
        <p>This learning project demonstrates how database records move through CodeIgniter models, controllers, and views in a simple MVC application.</p>
        </div>
    </section>

    <section class="about-section">
        <div class="about-block">
            <span class="section-kicker">Assessment context</span>
            <h2>Technical Formative Assessment 3</h2>
            <p>The application was created for IT0049 &mdash; Web System Technologies. It extends the database-backed account directories with validated create and edit forms plus safe user avatar uploads.</p>
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
            <span class="section-kicker">Editable records</span>
            <h2>Validated account workflows</h2>
            <p>Customer and user records are created and updated through CodeIgniter models. Server-side validation protects required fields and unique usernames, while avatar uploads are prepared as display-ready JPG or PNG files.</p>
        </div>
    </section>
</div>

<?= view('templates/footer') ?>
