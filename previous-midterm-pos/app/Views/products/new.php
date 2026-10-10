<?= view('templates/header') ?>
<div class="content-wrap content-wrap-narrow">
    <section class="page-intro"><div><span class="eyebrow">Inventory</span><h1>New product</h1><p>Add stock with a server-validated price, quantity, and optional prepared image.</p></div></section>
    <section class="form-panel" aria-labelledby="new-product-title">
        <div class="form-panel-heading"><span class="section-kicker">Product details</span><h2 id="new-product-title">Create inventory record</h2></div>
        <?= view('products/form', ['product' => [], 'errors' => $errors, 'formAction' => site_url('products'), 'submitLabel' => 'Create product', 'imageUrl' => '']) ?>
    </section>
</div>
<?= view('templates/footer') ?>
