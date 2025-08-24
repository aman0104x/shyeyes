@extends('layout.master')

@section('content')
<div class="dating-container" style="background-color: #f8f9fa; padding: 40px 0; min-height: 100vh;">
    <div class="dating-card" style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden; margin: 20px auto; max-width: 900px;">
        <div class="dating-card-header" style="background: linear-gradient(135deg, #eb6db4cf 0%, #ff9a8b 100%); color: white; padding: 30px; border-radius: 20px 20px 0 0; text-align: center;">
            <h2 style="margin-bottom: 5px; font-size: 2rem; font-weight: 700;">Account Information</h2>
            <p style="font-size: 1rem; opacity: 0.9;">View your payment details including QR code, UPI, and bank information.</p>
        </div>
        <div class="dating-card-body" style="padding: 40px;">
            <!-- QR Code Display -->
            @if($paymentSetting->qr_code)
            <div class="info-section mb-5">
                <h4 style="color: #eb6db4cf; margin-bottom: 20px; font-weight: 600;">
                    <i class="fas fa-qrcode" style="margin-right: 10px;"></i>QR Code
                </h4>
                <div class="qr-code-container text-center">
                    @php
                        $qrCodePath = 'storage/' . $paymentSetting->qr_code;
                        $qrCodeExists = file_exists(public_path($qrCodePath));
                    @endphp
                    @if($qrCodeExists)
                    <img src="{{ asset($qrCodePath) }}" 
                         alt="QR Code" 
                         style="max-width: 250px; height: auto; border-radius: 10px; border: 2px solid #eee;">
                    @else
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px dashed #ddd;">
                        <i class="fas fa-image" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                        <p style="color: #999; margin: 0;">QR Code image not found</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- UPI Information -->
            @if($paymentSetting->upi)
            <div class="info-section mb-4">
                <h4 style="color: #eb6db4cf; margin-bottom: 15px; font-weight: 600;">
                    <i class="fas fa-mobile-alt" style="margin-right: 10px;"></i>UPI Details
                </h4>
                <div class="info-card" style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #eb6db4cf;">
                    <p style="margin: 0; font-size: 1.1rem; color: #555;">
                        <strong>UPI ID:</strong> {{ $paymentSetting->upi }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Phone Number -->
            @if($paymentSetting->phone_number)
            <div class="info-section mb-4">
                <h4 style="color: #eb6db4cf; margin-bottom: 15px; font-weight: 600;">
                    <i class="fas fa-phone" style="margin-right: 10px;"></i>Phone Number
                </h4>
                <div class="info-card" style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #eb6db4cf;">
                    <p style="margin: 0; font-size: 1.1rem; color: #555;">
                        <strong>Phone:</strong> {{ $paymentSetting->phone_number }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Bank Information -->
            @if($paymentSetting->bank_name || $paymentSetting->account_number || $paymentSetting->ifsc_code || $paymentSetting->holder_name)
            <div class="info-section mb-4">
                <h4 style="color: #eb6db4cf; margin-bottom: 15px; font-weight: 600;">
                    <i class="fas fa-university" style="margin-right: 10px;"></i>Bank Account Details
                </h4>
                <div class="info-card" style="background: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 4px solid #eb6db4cf;">
                    @if($paymentSetting->holder_name)
                    <p style="margin: 0 0 10px 0; font-size: 1.1rem; color: #555;">
                        <strong>Account Holder:</strong> {{ $paymentSetting->holder_name }}
                    </p>
                    @endif
                    @if($paymentSetting->bank_name)
                    <p style="margin: 0 0 10px 0; font-size: 1.1rem; color: #555;">
                        <strong>Bank Name:</strong> {{ $paymentSetting->bank_name }}
                    </p>
                    @endif
                    @if($paymentSetting->account_number)
                    <p style="margin: 0 0 10px 0; font-size: 1.1rem; color: #555;">
                        <strong>Account Number:</strong> {{ $paymentSetting->account_number }}
                    </p>
                    @endif
                    @if($paymentSetting->ifsc_code)
                    <p style="margin: 0; font-size: 1.1rem; color: #555;">
                        <strong>IFSC Code:</strong> {{ $paymentSetting->ifsc_code }}
                    </p>
                    @endif
                </div>
            </div>
            @endif

            <!-- No Data Message -->
            @if(!$paymentSetting->exists || (!$paymentSetting->qr_code && !$paymentSetting->upi && !$paymentSetting->phone_number && !$paymentSetting->bank_name && !$paymentSetting->account_number && !$paymentSetting->ifsc_code && !$paymentSetting->holder_name))
            <div class="alert alert-info text-center" style="background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460; border-radius: 10px; padding: 20px;">
                <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 15px;"></i>
                <h5 style="margin-bottom: 10px;">No Payment Information Available</h5>
                <p style="margin: 0;">Please update your payment settings to add payment information.</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-primary" style="padding: 12px 30px; border-radius: 50px; font-size: 1rem; font-weight: 600; background: linear-gradient(45deg, #eb6db4cf, #ff9a8b); border: none; box-shadow: 0 4px 15px rgba(235, 109, 180, 0.4); margin-right: 15px;">
                    <i class="fas fa-edit" style="margin-right: 8px;"></i>Edit Settings
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" style="padding: 12px 30px; border-radius: 50px; font-size: 1rem; font-weight: 600; border: 2px solid #6c757d; color: #6c757d;">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .info-section {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }
    
    .info-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .qr-code-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        display: inline-block;
    }
</style>
@endsection
