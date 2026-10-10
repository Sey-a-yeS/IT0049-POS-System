<?= view('templates/header') ?>
<div class="content-wrap">
    <?php if ($success = session('success')): ?><div class="flash-message" role="status"><?= esc($success) ?></div><?php endif; ?>
    <section class="page-intro directory-intro"><div><span class="eyebrow">Transaction register</span><h1>Sales history</h1><p>Immutable sale records joined to their product, customer, and staff identities.</p></div><div class="intro-actions"><a class="button button-primary" href="<?= site_url('sales/new') ?>">Record Sale</a></div></section>
    <section class="table-panel" aria-labelledby="sales-title"><div class="table-toolbar"><div><span class="section-kicker">Recorded transactions</span><h2 id="sales-title">Complete sales history</h2></div><span class="data-label">newest first</span></div>
        <div class="table-scroll" tabindex="0"><table><caption class="sr-only">Sales history</caption><thead><tr><th scope="col">Sale</th><th scope="col">Product</th><th scope="col">Customer</th><th scope="col">Staff</th><th scope="col">Quantity</th><th scope="col">Total</th><th scope="col">Date</th></tr></thead><tbody>
            <?php if ($sales === []): ?><tr><td class="empty-state" colspan="7">No sales have been recorded.</td></tr><?php else: ?><?php foreach ($sales as $sale): ?><tr><td><span class="row-id">#<?= esc($sale['id']) ?></span></td><td><strong><?= esc($sale['product_name']) ?></strong></td><td><?= esc($sale['customer_name'] ?? 'Walk-in customer') ?></td><td><?= esc($sale['staff_name']) ?></td><td><?= esc($sale['quantity']) ?></td><td><strong>₱<?= esc(number_format((float) $sale['total_price'], 2)) ?></strong></td><td><time datetime="<?= esc($sale['created_at'], 'attr') ?>"><?= esc(date('M j, Y · g:i A', strtotime($sale['created_at']))) ?></time></td></tr><?php endforeach; ?><?php endif; ?>
        </tbody></table></div>
    </section>
</div>
<?= view('templates/footer') ?>
