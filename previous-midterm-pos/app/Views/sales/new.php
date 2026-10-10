<?= view('templates/header') ?>
<?php $selectedProduct = old('product_id', ''); $selectedCustomer = old('customer_id', ''); $quantity = old('quantity', '1'); ?>
<div class="content-wrap content-wrap-narrow">
    <section class="page-intro"><div><span class="eyebrow">Checkout</span><h1>Record sale</h1><p>Choose one product and quantity. The server uses the database price and commits stock and sale history together.</p></div></section>
    <section class="sale-layout">
        <div class="form-panel sale-form-panel">
            <div class="form-panel-heading"><span class="section-kicker">Transaction details</span><h2>New sale</h2></div>
            <?php if ($errors !== []): ?><div class="form-errors" role="alert"><strong>The sale could not be completed.</strong><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
            <form class="account-form" action="<?= site_url('sales') ?>" method="post" novalidate data-sale-form>
                <?= csrf_field() ?>
                <input type="hidden" name="sale_nonce" value="<?= esc($saleNonce, 'attr') ?>">
                <div class="form-field<?= isset($errors['product_id']) ? ' has-error' : '' ?>">
                    <label for="product_id">Product <span aria-hidden="true">*</span></label>
                    <select id="product_id" name="product_id">
                        <option value="">Select a product</option>
                        <?php foreach ($products as $product): ?><option value="<?= esc($product['id'], 'attr') ?>" data-price="<?= esc($product['price'], 'attr') ?>" data-stock="<?= esc($product['stock_quantity'], 'attr') ?>"<?= (string) $selectedProduct === (string) $product['id'] ? ' selected' : '' ?>><?= esc($product['name']) ?> — ₱<?= esc(number_format((float) $product['price'], 2)) ?></option><?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['product_id'])): ?><span class="field-error"><?= esc($errors['product_id']) ?></span><?php endif; ?>
                </div>
                <div class="form-field<?= isset($errors['customer_id']) ? ' has-error' : '' ?>">
                    <label for="customer_id">Customer</label>
                    <select id="customer_id" name="customer_id"><option value="">Walk-in customer</option><?php foreach ($customers as $customer): ?><option value="<?= esc($customer['id'], 'attr') ?>"<?= (string) $selectedCustomer === (string) $customer['id'] ? ' selected' : '' ?>><?= esc($customer['full_name']) ?></option><?php endforeach; ?></select>
                    <small>Optional. Leave as walk-in when no customer account is used.</small>
                    <?php if (isset($errors['customer_id'])): ?><span class="field-error"><?= esc($errors['customer_id']) ?></span><?php endif; ?>
                </div>
                <div class="form-field<?= isset($errors['quantity']) ? ' has-error' : '' ?>">
                    <label for="quantity">Quantity <span aria-hidden="true">*</span></label>
                    <input id="quantity" name="quantity" type="number" min="1" step="1" inputmode="numeric" value="<?= esc($quantity, 'attr') ?>">
                    <?php if (isset($errors['quantity'])): ?><span class="field-error"><?= esc($errors['quantity']) ?></span><?php endif; ?>
                </div>
                <div class="form-actions"><button class="button button-primary" type="submit">Complete sale</button><a class="button button-secondary" href="<?= site_url('/') ?>">Cancel</a></div>
            </form>
        </div>
        <aside class="sale-summary" aria-live="polite"><span class="section-kicker">Sale preview</span><p data-available-stock>Select a product</p><strong data-sale-total>₱0.00</strong><small>The browser preview is informational. The final total and stock validation are recalculated securely on the server.</small></aside>
    </section>
</div>
<?= view('templates/footer') ?>
