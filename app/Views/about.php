<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">About the project</span>
            <h1>Tasks for Today Management System</h1>
            <p>A focused CodeIgniter 4 application for reviewing today's priorities and the complete task schedule.</p>
        </div>
    </section>

    <section class="about-section">
        <div class="about-block">
            <span class="section-kicker">Assessment context</span>
            <h2>Technical Summative Assessment 1</h2>
            <p>This application was developed for IT0049 &mdash; Web System Technologies.</p>
        </div>

        <div class="about-block">
            <span class="section-kicker">Developer</span>
            <h2>Isaiah Ezekiel P. Vicencio</h2>
            <p>The system demonstrates database-backed task filtering, ordered task retrieval, and a single user profile using CodeIgniter MVC conventions.</p>
        </div>

        <div class="about-block">
            <span class="section-kicker">Application flow</span>
            <h2>Clear MVC responsibilities</h2>
            <div class="process" aria-label="Application request flow">
                <span>MySQL</span>
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
    </section>
</div>

<?= view('templates/footer') ?>
