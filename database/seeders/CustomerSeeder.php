<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample customers
        Customer::create([
            'name' => 'Acme Corporation',
            'email' => 'accounts@acme.com',
            'phone' => '(555) 123-4567',
            'address' => '123 Main Street',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postal_code' => '94105',
            'country' => 'USA',
            'notes' => 'Key customer, always pays on time.',
        ]);

        Customer::create([
            'name' => 'Globex Inc.',
            'email' => 'billing@globex.com',
            'phone' => '(555) 987-6543',
            'address' => '456 Market Street',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
            'notes' => 'Contact John for invoicing matters.',
        ]);

        Customer::create([
            'name' => 'Stark Industries',
            'email' => 'finance@stark.com',
            'phone' => '(555) 555-1234',
            'address' => '789 Tech Blvd',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'postal_code' => '90001',
            'country' => 'USA',
        ]);

        // Create additional customers with factory
        Customer::factory(5)->create();
    }
}
