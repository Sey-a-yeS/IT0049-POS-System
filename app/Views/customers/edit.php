<?= view('templates/header') ?>

<div class="content-wrap content-wrap-narrow">
    <section class="page-intro">
        <div>
            <span class="eyebrow">Customer Accounts</span>
            <h1>Edit Customer</h1>
            <p>Update the selected customer's contact details.</p>
        </div>
    </section>

    <section class="form-panel" aria-labelledby="edit-customer-title">
        <div class="form-panel-heading">
            <span class="section-kicker">Customer #<?= esc($customer['id']) ?></span>
            <h2 id="edit-customer-title">Update customer account</h2>
        </div>
        <?= view('customers/form', [
            'customer'    => $customer,
            'errors'      => $errors,
            'formAction'  => site_url('customers/' . $customer['id']),
            'submitLabel' => 'Save changes',
        ]) ?>
    </section>
</div>

<?= view('templates/footer') ?>
