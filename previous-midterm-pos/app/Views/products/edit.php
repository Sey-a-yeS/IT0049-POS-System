<?= view('templates/header') ?>
<div class="content-wrap content-wrap-narrow">
    <section class="page-intro"><div><span class="eyebrow">Inventory</span><h1>Edit product</h1><p>Update product details without changing its historical sales.</p></div></section>
    <section class="form-panel" aria-labelledby="edit-product-title">
        <div class="form-panel-heading"><span class="section-kicker">Product #<?= esc($product['id']) ?></span><h2 id="edit-product-title">Update inventory record</h2></div>
        <?= view('products/form', ['product' => $product, 'errors' => $errors, 'formAction' => site_url('products/' . $product['id']), 'submitLabel' => 'Save changes', 'imageUrl' => $imageUrl]) ?>
    </section>
</div>
<?= view('templates/footer') ?>
