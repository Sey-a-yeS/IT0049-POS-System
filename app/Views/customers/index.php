<?= view('templates/header') ?>

<section class="page-banner compact-banner">
    <div class="container">
        <span class="eyebrow">Account directory</span>
        <h1>Customer Accounts</h1>
        <p>Contact information for the POS System's sample customers.</p>
    </div>
</section>

<section class="section table-section">
    <div class="container">
        <div class="table-card">
            <div class="table-card-heading">
                <div>
                    <h2>Customers</h2>
                    <p><?= esc(count($customers)) ?> records available</p>
                </div>
                <span class="data-badge">Static data</span>
            </div>

            <div class="table-scroll">
                <table>
                    <caption class="sr-only">Customer account records</caption>
                    <thead>
                        <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><strong><?= esc($customer['full_name']) ?></strong></td>
                                <td><a href="mailto:<?= esc($customer['email'], 'attr') ?>"><?= esc($customer['email']) ?></a></td>
                                <td><?= esc($customer['phone']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= view('templates/footer') ?>
