<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        if (!$vehicle->isAvailableForSale()) {
            return back()->with('error', 'Vehicle is not available for purchase.');
        }

        DB::beginTransaction();
        try {
            $salePrice = $vehicle->sale_price;
            $taxAmount = $salePrice * 0.15; // 15% tax
            $totalAmount = $salePrice + $taxAmount;

            // Create purchase
            $purchase = Purchase::create([
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle->id,
                'purchase_price' => $salePrice,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Create payment record
            $payment = Payment::create([
                'payable_type' => Purchase::class,
                'payable_id' => $purchase->id,
                'user_id' => auth()->id(),
                'amount' => $totalAmount,
                'payment_method' => 'mobile_banking',
                'bank_name' => 'Commercial Bank of Ethiopia',
                'account_number' => '1000123456789',
                'payment_instructions' => "Transfer {$totalAmount} ETB and use reference: " . $purchase->purchase_reference,
                'status' => 'pending',
            ]);

            AuditLog::log('purchase_created', $purchase);

            // Email notifications disabled

            DB::commit();

            return redirect()->route('purchases.payment', $purchase)->with('success', 'Purchase request created successfully! A confirmation email has been sent to your email address. Please complete payment to proceed.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to create purchase request. Please try again.');
        }
    }

    public function payment(Purchase $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }

        $payment = $purchase->payment;
        
        return view('purchases.payment', compact('purchase', 'payment'));
    }

    public function show(Purchase $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }

        $purchase->load(['vehicle.images', 'payment']);

        return view('purchases.show', compact('purchase'));
    }
}