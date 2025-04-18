<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        
        return view('invoices.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());
        
        // Handle invoice items
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price']
                ]);
            }
        }
        
        // Recalculate invoice totals
        $this->recalculateInvoice($invoice);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $customers = Customer::orderBy('name')->get();
        $invoice->load('items');
        
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        
        // Delete removed items
        if ($request->has('item_ids')) {
            $invoice->items()->whereNotIn('id', $request->item_ids)->delete();
        } else {
            $invoice->items()->delete();
        }
        
        // Update existing items and add new ones
        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                if (isset($item['id'])) {
                    $invoiceItem = $invoice->items()->find($item['id']);
                    if ($invoiceItem) {
                        $invoiceItem->update([
                            'description' => $item['description'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'total' => $item['quantity'] * $item['unit_price']
                        ]);
                    }
                } else {
                    $invoice->items()->create([
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => $item['quantity'] * $item['unit_price']
                    ]);
                }
            }
        }
        
        // Recalculate invoice totals
        $this->recalculateInvoice($invoice);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
    
    /**
     * Recalculate invoice totals based on items.
     */
    private function recalculateInvoice(Invoice $invoice): void
    {
        $invoice->refresh();
        
        $subtotal = $invoice->items->sum('total');
        $tax = $invoice->tax ?? 0;
        $discount = $invoice->discount ?? 0;
        $total = $subtotal + $tax - $discount;
        
        $invoice->update([
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }
}
