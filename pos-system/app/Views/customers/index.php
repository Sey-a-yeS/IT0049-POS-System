<?= view('templates/header') ?>

<div class="content-wrap">
    <?php if ($success = session('success')): ?>
        <div class="flash-message" role="status"><?= esc($success) ?></div>
    <?php endif; ?>

    <section class="page-intro directory-intro">
        <div>
            <span class="eyebrow">Account directory</span>
            <h1>Customer Accounts</h1>
            <p>Contact details and account metadata for customers stored in the POS database.</p>
        </div>
        <div class="record-count" aria-label="<?= esc(count($customers)) ?> customer records">
            <strong><?= esc(count($customers)) ?></strong>
            <span>Total records</span>
        </div>
    </section>

    <section class="table-panel" aria-labelledby="customer-table-title">
        <div class="table-toolbar">
            <div>
                <span class="section-kicker">Database directory</span>
                <h2 id="customer-table-title">Customer records</h2>
            </div>
            <div class="toolbar-actions">
                <span class="data-label">customers table</span>
                <a class="button button-primary" href="<?= site_url('customers/new') ?>">New Customer</a>
            </div>
        </div>

            <div class="table-scroll" tabindex="0">
                <table>
                    <caption class="sr-only">Customer account records</caption>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($customers === []): ?>
                            <tr>
                                <td class="empty-state" colspan="6">No customer accounts found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><span class="row-id">#<?= esc($customer['id']) ?></span></td>
                                    <td><strong><?= esc($customer['full_name']) ?></strong></td>
                                    <td><a href="mailto:<?= esc($customer['email'], 'attr') ?>"><?= esc($customer['email']) ?></a></td>
                                    <td><a class="quiet-link" href="tel:<?= esc($customer['phone'], 'attr') ?>"><?= esc($customer['phone']) ?></a></td>
                                    <td><time datetime="<?= esc($customer['created_at'], 'attr') ?>"><?= esc(date('M j, Y · g:i A', strtotime($customer['created_at']))) ?></time></td>
                                    <td><a class="action-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    </section>
</div>

<?= view('templates/footer') ?>
