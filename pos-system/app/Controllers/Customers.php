<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'      => 'Customer Accounts',
            'activePage' => 'customers',
            'customers'  => $customerModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('customers/index', $data);
    }

    public function new(): string
    {
        return view('customers/new', [
            'title'      => 'New Customer',
            'activePage' => 'customers',
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        $validation = service('validation');
        $validation->setRules($this->customerRules());

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('customers/new'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $customerModel = new CustomerModel();
        $customerModel->insert($this->customerData());

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer created successfully.');
    }

    public function edit(int $id): string
    {
        $customerModel = new CustomerModel();
        $customer      = $customerModel->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/edit', [
            'title'      => 'Edit Customer',
            'activePage' => 'customers',
            'customer'   => $customer,
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $customerModel = new CustomerModel();

        if ($customerModel->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $validation = service('validation');
        $validation->setRules($this->customerRules());

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url("customers/{$id}/edit"))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $customerModel->update($id, $this->customerData(false));

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function customerRules(): array
    {
        return [
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
            'email' => [
                'label' => 'Email address',
                'rules' => 'required|valid_email|max_length[100]',
            ],
            'phone' => [
                'label' => 'Phone number',
                'rules' => 'permit_empty|max_length[20]',
            ],
        ];
    }

    /**
     * @return array<string, string|null>
     */
    private function customerData(bool $includeCreatedAt = true): array
    {
        $phone = trim((string) $this->request->getPost('phone'));

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => $phone === '' ? null : $phone,
        ];

        if ($includeCreatedAt) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $data;
    }
}
