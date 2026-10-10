<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Customer Accounts</span>
            <h1>New Customer</h1>
            <p>Add a customer using the required contact fields.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="new-customer-title">
        <div class="form-panel-heading">
            <span class="section-kicker">Customer details</span>
            <h2 id="new-customer-title">Create customer account</h2>
        </div>
        <?= view('customers/form', [
            'customer'    => [],
            'errors'      => $errors,
            'formAction'  => site_url('customers'),
            'submitLabel' => 'Create customer',
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
