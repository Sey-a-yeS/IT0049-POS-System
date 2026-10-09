'use strict';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach((button) => {
        button.addEventListener('click', (event) => {
            if (! window.confirm(button.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    const form = document.querySelector('[data-sale-form]');

    if (! form) {
        return;
    }

    const product = form.querySelector('[name="product_id"]');
    const quantity = form.querySelector('[name="quantity"]');
    const saleLayout = form.closest('.sale-layout');
    const stock = saleLayout?.querySelector('[data-available-stock]');
    const total = saleLayout?.querySelector('[data-sale-total]');

    if (! product || ! quantity || ! stock || ! total) {
        return;
    }

    const refresh = () => {
        const option = product.options[product.selectedIndex];
        const available = Number.parseInt(option?.dataset.stock ?? '0', 10);
        const unitPrice = Number.parseFloat(option?.dataset.price ?? '0');
        const units = Number.parseInt(quantity.value, 10);

        stock.textContent = Number.isInteger(available) ? `${available} units available` : 'Select a product';
        total.textContent = Number.isInteger(units) && units > 0 && Number.isFinite(unitPrice)
            ? `₱${(unitPrice * units).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
            : '₱0.00';
    };

    product.addEventListener('change', refresh);
    quantity.addEventListener('input', refresh);
    refresh();
});
