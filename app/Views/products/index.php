<?= view('templates/header') ?>
<div class="content-wrap">
    <?php if ($success = session('success')): ?><div class="flash-message" role="status"><?= esc($success) ?></div><?php endif; ?>
    <section class="page-intro directory-intro"><div><span class="eyebrow">Inventory control</span><h1>Products</h1><p>Active sellable products, authoritative prices, and current on-hand stock.</p></div><div class="record-count"><strong><?= esc(count($products)) ?></strong><span>Active products</span></div></section>
    <section class="table-panel" aria-labelledby="products-title">
        <div class="table-toolbar"><div><span class="section-kicker">Catalog</span><h2 id="products-title">Product inventory</h2></div><a class="button button-primary" href="<?= site_url('products/new') ?>">New Product</a></div>
        <div class="table-scroll" tabindex="0"><table>
            <caption class="sr-only">Active product inventory</caption>
            <thead><tr><th scope="col">Image</th><th scope="col">Product</th><th scope="col">Price</th><th scope="col">Stock</th><th scope="col">Created</th><th scope="col">Actions</th></tr></thead>
            <tbody>
                <?php if ($products === []): ?><tr><td class="empty-state" colspan="6">No active products found.</td></tr><?php else: ?>
                    <?php foreach ($products as $product): ?><tr>
                        <td><img class="product-thumbnail" src="<?= esc($product['image_url'], 'attr') ?>" alt="<?= esc($product['name'], 'attr') ?> product image"></td>
                        <td><strong><?= esc($product['name']) ?></strong><span class="mobile-subtext">#<?= esc($product['id']) ?></span></td>
                        <td><strong>₱<?= esc(number_format((float) $product['price'], 2)) ?></strong></td>
                        <td><span class="stock-badge<?= (int) $product['stock_quantity'] <= 5 ? ' stock-low' : '' ?>"><?= esc($product['stock_quantity']) ?> units</span></td>
                        <td><time datetime="<?= esc($product['created_at'], 'attr') ?>"><?= esc(date('M j, Y', strtotime($product['created_at']))) ?></time></td>
                        <td><div class="row-actions"><a class="action-link" href="<?= site_url('products/' . $product['id'] . '/edit') ?>">Edit</a><form action="<?= site_url('products/' . $product['id'] . '/archive') ?>" method="post"><?= csrf_field() ?><button class="action-link action-link-danger" type="submit" data-confirm="Archive this product? It will no longer be available for new sales.">Archive</button></form></div></td>
                    </tr><?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table></div>
    </section>
</div>
<?= view('templates/footer') ?>
