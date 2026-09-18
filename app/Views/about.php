<?= view('templates/header') ?>

<section class="page-banner">
    <div class="container narrow">
        <span class="eyebrow">About the project</span>
        <h1>CodeIgniter 4 POS System</h1>
        <p>This learning project demonstrates how a request moves through explicit routes, controllers, and views in a simple MVC application.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <div class="content-card">
            <h2>Technical Formative Assessment 1</h2>
            <p>The application was created for IT0049 &mdash; Web System Technologies. It uses dedicated controllers to prepare page data and reusable views to present a consistent, responsive interface.</p>

            <div class="process" aria-label="Application request flow">
                <span>Route</span>
                <span aria-hidden="true">&rarr;</span>
                <span>Controller</span>
                <span aria-hidden="true">&rarr;</span>
                <span>View</span>
                <span aria-hidden="true">&rarr;</span>
                <span>HTML</span>
            </div>

            <h2>Temporary data</h2>
            <p>Customer and user records currently come from static PHP arrays inside their controllers. The views receive those arrays and use <code>foreach</code> loops to build the account tables. No database, model, migration, or external API is used in this first version.</p>
        </div>
    </div>
</section>

<?= view('templates/footer') ?>
