<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        
        // Create some sample invoices for each customer
        foreach ($customers as $customer) {
            // Create a paid invoice
            $invoice1 = Invoice::create([
                'customer_id' => $customer->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
                'issue_date' => Carbon::now()->subDays(30),
                'due_date' => Carbon::now()->subDays(15),
                'subtotal' => 0, // Will be calculated
                'tax' => 50,
                'discount' => 25,
                'total' => 0, // Will be calculated
                'notes' => 'Thank you for your business!',
                'status' => 'paid',
            ]);
            
            // Add 2-4 items to the invoice
            $itemCount = rand(2, 4);
            $subtotal = 0;
            
            for ($i = 0; $i < $itemCount; $i++) {
                $quantity = rand(1, 5);
                $unitPrice = rand(50, 200);
                $total = $quantity * $unitPrice;
                $subtotal += $total;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice1->id,
                    'description' => 'Service Item ' . ($i + 1),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $total,
                ]);
            }
            
            // Update the invoice with calculated totals
            $total = $subtotal + $invoice1->tax - $invoice1->discount;
            $invoice1->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
            
            // Create a pending invoice
            $invoice2 = Invoice::create([
                'customer_id' => $customer->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
                'issue_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(10),
                'subtotal' => 0, // Will be calculated
                'tax' => 25,
                'discount' => 0,
                'total' => 0, // Will be calculated
                'notes' => 'Payment due within 15 days',
                'status' => 'sent',
            ]);
            
            // Add 1-3 items to the invoice
            $itemCount = rand(1, 3);
            $subtotal = 0;
            
            for ($i = 0; $i < $itemCount; $i++) {
                $quantity = rand(1, 3);
                $unitPrice = rand(75, 250);
                $total = $quantity * $unitPrice;
                $subtotal += $total;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice2->id,
                    'description' => 'Product Item ' . ($i + 1),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $total,
                ]);
            }
            
            // Update the invoice with calculated totals
            $total = $subtotal + $invoice2->tax - $invoice2->discount;
            $invoice2->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        }
    }
}
