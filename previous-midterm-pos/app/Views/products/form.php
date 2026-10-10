<?php
$name  = $errors !== [] ? old('name', $product['name'] ?? '') : ($product['name'] ?? '');
$price = $errors !== [] ? old('price', $product['price'] ?? '') : ($product['price'] ?? '');
$stock = $errors !== [] ? old('stock_quantity', $product['stock_quantity'] ?? '0') : ($product['stock_quantity'] ?? '0');
?>

<?php if ($errors !== []): ?>
    <div class="form-errors" role="alert" aria-labelledby="product-errors">
        <strong id="product-errors">Please correct the highlighted fields.</strong>
        <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<form class="account-form" action="<?= esc($formAction, 'attr') ?>" method="post" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="form-field<?= isset($errors['name']) ? ' has-error' : '' ?>">
        <label for="name">Product name <span aria-hidden="true">*</span></label>
        <input id="name" name="name" type="text" maxlength="100" value="<?= esc($name, 'attr') ?>">
        <?php if (isset($errors['name'])): ?><span class="field-error"><?= esc($errors['name']) ?></span><?php endif; ?>
    </div>
    <div class="form-grid-two">
        <div class="form-field<?= isset($errors['price']) ? ' has-error' : '' ?>">
            <label for="price">Price (PHP) <span aria-hidden="true">*</span></label>
            <input id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" inputmode="decimal" value="<?= esc($price, 'attr') ?>">
            <?php if (isset($errors['price'])): ?><span class="field-error"><?= esc($errors['price']) ?></span><?php endif; ?>
        </div>
        <div class="form-field<?= isset($errors['stock_quantity']) ? ' has-error' : '' ?>">
            <label for="stock_quantity">Stock quantity <span aria-hidden="true">*</span></label>
            <input id="stock_quantity" name="stock_quantity" type="number" min="0" step="1" inputmode="numeric" value="<?= esc($stock, 'attr') ?>">
            <?php if (isset($errors['stock_quantity'])): ?><span class="field-error"><?= esc($errors['stock_quantity']) ?></span><?php endif; ?>
        </div>
    </div>
    <div class="form-field<?= isset($errors['image']) ? ' has-error' : '' ?>">
        <label for="image">Product image</label>
        <?php if ($imageUrl !== ''): ?>
            <div class="current-avatar product-preview"><img src="<?= esc($imageUrl, 'attr') ?>" alt="Current product image"><span>The current image remains when no replacement is selected.</span></div>
        <?php endif; ?>
        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
        <small>Optional JPG or PNG. Maximum 2 MB; saved as a 720 × 540 display image.</small>
        <?php if (isset($errors['image'])): ?><span class="field-error"><?= esc($errors['image']) ?></span><?php endif; ?>
    </div>
    <div class="form-actions"><button class="button button-primary" type="submit"><?= esc($submitLabel) ?></button><a class="button button-secondary" href="<?= site_url('products') ?>">Cancel</a></div>
</form>
