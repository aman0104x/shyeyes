@extends('layout.master')

@section('content')
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- <div class="dating-container" style="background-color: #eb6db4cf; padding: 40px 0;"> -->
        <div class="dating-card" style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden; margin: 20px auto; max-width: 900px;">
            <div class="dating-card-header" style="background: linear-gradient(135deg, #eb6db4cf 0%, #ff9a8b 100%); color: white; padding: 30px; border-radius: 20px 20px 0 0; text-align: center;">
                <h2 style="margin-bottom: 5px; font-size: 2rem; font-weight: 700;">Account Info</h2>
                <p style="font-size: 1rem; opacity: 0.9;">Manage your payment details including QR code, UPI, and bank information.</p>
            </div>
            <div class="dating-card-body" style="padding: 40px;">
                <!-- @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: 8px;">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size: 1.5rem; color: #155724;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif -->

                <form action="{{ route('admin.payment-settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="qr_code" style="font-weight: 600; color: #555;"><i class="fas fa-qrcode" style="color: #ff6b6b; margin-right: 8px;"></i> Upload QR Code Image</label>
                        <input type="file" class="form-control" id="qr_code" name="qr_code" accept="image/*" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('qr_code')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="upi" style="font-weight: 600; color: #555;"><i class="fas fa-mobile-alt" style="color: #ff6b6b; margin-right: 8px;"></i> UPI ID</label>
                        <input type="text" class="form-control" id="upi" name="upi" 
                               value="{{ old('upi', $paymentSetting->upi) }}" 
                               placeholder="Enter UPI ID (e.g., username@upi)" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('upi')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="phone_number" style="font-weight: 600; color: #555;"><i class="fas fa-phone" style="color: #ff6b6b; margin-right: 8px;"></i> Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" 
                               value="{{ old('phone_number', $paymentSetting->phone_number) }}" 
                               placeholder="Enter phone number" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('phone_number')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="holder_name" style="font-weight: 600; color: #555;"><i class="fas fa-user" style="color: #ff6b6b; margin-right: 8px;"></i> Account Holder Name</label>
                        <input type="text" class="form-control" id="holder_name" name="holder_name" 
                               value="{{ old('holder_name', $paymentSetting->holder_name) }}" 
                               placeholder="Enter account holder name" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('holder_name')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="bank_name" style="font-weight: 600; color: #555;"><i class="fas fa-university" style="color: #ff6b6b; margin-right: 8px;"></i> Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" 
                               value="{{ old('bank_name', $paymentSetting->bank_name) }}" 
                               placeholder="Enter bank name" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('bank_name')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="account_number" style="font-weight: 600; color: #555;"><i class="fas fa-credit-card" style="color: #ff6b6b; margin-right: 8px;"></i> Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" 
                               value="{{ old('account_number', $paymentSetting->account_number) }}" 
                               placeholder="Enter account number" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('account_number')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="ifsc_code" style="font-weight: 600; color: #555;"><i class="fas fa-money-check-alt" style="color: #ff6b6b; margin-right: 8px;"></i> IFSC Code</label>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" 
                               value="{{ old('ifsc_code', $paymentSetting->ifsc_code) }}" 
                               placeholder="Enter IFSC code" style="border-radius: 10px; padding: 14px; border: 1px solid #ddd;">
                        @error('ifsc_code')
                            <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-center mt-5">
                        <button type="submit" class="btn btn-primary" style="padding: 15px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; background: linear-gradient(45deg, #ff6b6b, #ff4c4c); border: none; box-shadow: 0 4px 15px rgba(255, 76, 76, 0.4);">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toast notification functions
        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };

        function showToast(type, title, message, duration = 3000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            toast.innerHTML = `
                <div class="toast-header">
                    <span class="toast-title">${icons[type]} ${title}</span>
                    <button class="toast-close" onclick="closeToast(this.parentElement.parentElement)">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;
            
            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 100);
            
            // Auto close after duration
            setTimeout(() => closeToast(toast), duration);
        }

        function closeToast(toast) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.parentElement.removeChild(toast);
                }
            }, 300);
        }

        // Show success message from session if exists
        @if(session('success'))
            showToast('success', 'Success', '{{ session('success') }}');
        @endif

        // Show validation errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                showToast('error', 'Error', '{{ $error }}');
            @endforeach
        @endif
    </script>

    <style>
        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 300px;
            max-width: 400px;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast-header {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toast-title {
            font-weight: 600;
            font-size: 14px;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #999;
        }

        .toast-close:hover {
            color: #666;
        }

        .toast-body {
            padding: 12px 16px;
            font-size: 14px;
            color: #666;
        }

        .toast-success {
            border-left: 4px solid #28a745;
        }

        .toast-success .toast-header {
            background-color: #d4edda;
            color: #155724;
        }

        .toast-error {
            border-left: 4px solid #dc3545;
        }

        .toast-error .toast-header {
            background-color: #f8d7da;
            color: #721c24;
        }

        .toast-warning {
            border-left: 4px solid #ffc107;
        }

        .toast-warning .toast-header {
            background-color: #fff3cd;
            color: #856404;
        }

        .toast-info {
            border-left: 4px solid #17a2b8;
        }

        .toast-info .toast-header {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
@endsection
