<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use DomainException;
use RuntimeException;
use Throwable;

class SaleService
{
    public function __construct(private readonly ?BaseConnection $connection = null)
    {
    }

    /**
     * @return array{id: int, total_price: string}
     */
    public function record(int $productId, ?int $customerId, int $quantity, int $staffId): array
    {
        if ($quantity < 1) {
            throw new DomainException('Quantity must be a positive whole number.');
        }

        $db = $this->connection ?? db_connect();
        $db->transBegin();

        try {
            $product = $db->table('products')
                ->select('id, price, stock_quantity')
                ->where('id', $productId)
                ->where('is_archived', 0)
                ->get()
                ->getRowArray();

            if ($product === null) {
                throw new DomainException('The selected product is unavailable.');
            }

            if ($customerId !== null) {
                $customerExists = $db->table('customers')
                    ->where('id', $customerId)
                    ->where('is_archived', 0)
                    ->countAllResults() === 1;

                if (! $customerExists) {
                    throw new DomainException('The selected customer is unavailable.');
                }
            }

            $staffExists = $db->table('users')
                ->where('id', $staffId)
                ->where('is_archived', 0)
                ->countAllResults() === 1;

            if (! $staffExists) {
                throw new DomainException('The authenticated staff account is unavailable.');
            }

            $updated = $db->table('products')
                ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
                ->where('id', $productId)
                ->where('is_archived', 0)
                ->where('stock_quantity >=', $quantity)
                ->update();

            if (! $updated || $db->affectedRows() !== 1) {
                throw new DomainException('Insufficient stock for the requested quantity.');
            }

            $totalPrice = $this->multiplyMoney((string) $product['price'], $quantity);
            $inserted   = $db->table('sales')->insert([
                'product_id' => $productId,
                'customer_id' => $customerId,
                'sold_by' => $staffId,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (! $inserted || $db->affectedRows() !== 1) {
                throw new RuntimeException('The sale could not be recorded.');
            }

            $saleId = (int) $db->insertID();

            if ($db->transStatus() === false) {
                throw new RuntimeException('The sale transaction failed.');
            }

            $db->transCommit();

            return ['id' => $saleId, 'total_price' => $totalPrice];
        } catch (Throwable $exception) {
            $db->transRollback();
            throw $exception;
        }
    }

    private function multiplyMoney(string $price, int $quantity): string
    {
        if (preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $price, $matches) !== 1) {
            throw new RuntimeException('The product price is invalid.');
        }

        $fraction = str_pad($matches[2] ?? '', 2, '0');
        $cents    = ((int) $matches[1] * 100) + (int) $fraction;
        $total    = $cents * $quantity;

        return intdiv($total, 100) . '.' . str_pad((string) ($total % 100), 2, '0', STR_PAD_LEFT);
    }
}
