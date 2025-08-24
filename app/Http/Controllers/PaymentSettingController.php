<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentSetting;

class PaymentSettingController extends Controller
{
    /**
     * Display the payment settings form.
     */
    public function index()
    {
        // Get the first payment setting or create a new one if none exists
        $paymentSetting = PaymentSetting::firstOrNew();

        return view('admin.payment-settings.index', compact('paymentSetting'));
    }

    /**
     * Update the payment settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upi' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ]);

        // Get the first payment setting or create a new one
        $paymentSetting = PaymentSetting::firstOrNew();

        // Handle QR code image upload
        if ($request->hasFile('qr_code')) {
            $qrCodeFile = $request->file('qr_code');
            $qrCodeName = time() . '_' . $qrCodeFile->getClientOriginalName();
            $qrCodePath = $qrCodeFile->storeAs('qr_codes', $qrCodeName, 'public');
            $validated['qr_code'] = $qrCodePath;
        } else {
            // Keep the existing QR code if no new file is uploaded
            unset($validated['qr_code']);
        }

        $paymentSetting->fill($validated);
        $paymentSetting->save();

        return redirect()->route('admin.payment-settings.index')
            ->with('success', 'Account info updated successfully.');
    }

    /**
     * Display the payment settings view.
     */
    public function show()
    {
        $paymentSetting = PaymentSetting::firstOrNew();
        return view('admin.payment-settings.view', compact('paymentSetting'));
    }
}
