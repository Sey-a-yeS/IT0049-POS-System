<?= view('templates/header') ?>

<div class="content-wrap">
    <section class="page-intro dashboard-intro">
        <div>
            <span class="eyebrow">Retail operations</span>
            <h1>Point-of-sale dashboard</h1>
            <p>Monitor inventory and recent transactions, then move directly into the day’s core management workflows.</p>
        </div>
        <div class="intro-actions">
            <a class="button button-primary" href="<?= site_url('sales/new') ?>">Record Sale</a>
            <a class="button button-secondary" href="<?= site_url('products/new') ?>">New Product</a>
        </div>
    </section>

    <section class="metric-grid" aria-label="POS summary">
        <a class="metric-card" href="<?= site_url('products') ?>"><span>Active products</span><strong><?= esc($metrics['products']) ?></strong></a>
        <a class="metric-card" href="<?= site_url('customers') ?>"><span>Customers</span><strong><?= esc($metrics['customers']) ?></strong></a>
        <a class="metric-card" href="<?= site_url('users') ?>"><span>Active staff</span><strong><?= esc($metrics['staff']) ?></strong></a>
        <a class="metric-card" href="<?= site_url('sales') ?>"><span>Recorded sales</span><strong><?= esc($metrics['sales']) ?></strong></a>
        <a class="metric-card metric-card-alert" href="<?= site_url('products') ?>"><span>Low stock</span><strong><?= esc($metrics['low_stock']) ?></strong></a>
    </section>

    <section class="table-panel" aria-labelledby="recent-sales-title">
        <div class="table-toolbar">
            <div>
                <span class="section-kicker">Latest activity</span>
                <h2 id="recent-sales-title">Recent sales</h2>
            </div>
            <a class="button button-secondary" href="<?= site_url('sales') ?>">View history</a>
        </div>
        <div class="table-scroll" tabindex="0">
            <table>
                <caption class="sr-only">Five most recent sales</caption>
                <thead><tr><th scope="col">Sale</th><th scope="col">Product</th><th scope="col">Customer</th><th scope="col">Staff</th><th scope="col">Qty</th><th scope="col">Total</th></tr></thead>
                <tbody>
                    <?php if ($recentSales === []): ?>
                        <tr><td class="empty-state" colspan="6">No sales have been recorded yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentSales as $sale): ?>
                            <tr>
                                <td><span class="row-id">#<?= esc($sale['id']) ?></span></td>
                                <td><strong><?= esc($sale['product_name']) ?></strong></td>
                                <td><?= esc($sale['customer_name'] ?? 'Walk-in customer') ?></td>
                                <td><?= esc($sale['staff_name']) ?></td>
                                <td><?= esc($sale['quantity']) ?></td>
                                <td><strong>₱<?= esc(number_format((float) $sale['total_price'], 2)) ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?= view('templates/footer') ?>
