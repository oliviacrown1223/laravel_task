@extends('admin.panel')

@section('content')

    <style>

        /* ===== Layout Animation ===== */
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity:0; transform: translateY(20px);}
            to {opacity:1; transform: translateY(0);}
        }

        /* ===== Card ===== */
        .card {
            border-radius: 18px;
            overflow: hidden;
        }

        /* ===== Floating Labels ===== */
        .form-group {
            position: relative;
        }

        .form-group input,
        .form-group select {
            height: 50px;
            border-radius: 10px;
        }

        .form-group label {
            position: absolute;
            top: 12px;
            left: 15px;
            background: #fff;
            padding: 0 5px;
            font-size: 13px;
            color: #888;
            transition: 0.2s;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label,
        .form-group select:focus + label,
        .form-group select:not([value=""]) + label {
            top: -8px;
            font-size: 11px;
            color: #6366f1;
        }

        /* ===== Inputs ===== */
        .form-control:focus {
            box-shadow: 0 0 12px rgba(99,102,241,0.25);
            border-color: #6366f1;
        }

        /* ===== Button Animation ===== */
        .btn-success {
            transition: 0.3s;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* ===== Coupon Preview ===== */
        .coupon-preview {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border-radius: 18px;
            padding: 25px;
            position: sticky;
            top: 20px;
            animation: fadeIn 0.8s ease;
        }

        .preview-title {
            font-size: 20px;
            font-weight: bold;
        }

        .preview-discount {
            font-size: 26px;
            font-weight: 600;
        }

        /* Hover effect */
        .coupon-preview:hover {
            transform: scale(1.02);
            transition: 0.3s;
        }

    </style>

    <div class="container py-4 fade-in">

        <div class="row">

            <!-- LEFT SIDE FORM -->
            <div class="col-md-7">
                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">
                        <h5>Create Coupon</h5>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <!-- Name -->
                                <div class="col-md-6 mb-4 form-group">
                                    <input type="text" name="name" placeholder=" "
                                           class="form-control"
                                           value="{{ old('name') }}">
                                    <label>Coupon Name</label>
                                </div>

                                <!-- Usage -->
                                <div class="col-md-6 mb-4 form-group">
                                    <input type="number" name="usage_limit" placeholder=" "
                                           class="form-control"
                                           value="{{ old('usage_limit') }}">
                                    <label>Usage Limit</label>
                                </div>

                                <!-- Expiry -->
                                <div class="col-md-6 mb-4 form-group">
                                    <input type="date" name="expiry_date"
                                           class="form-control">
                                    <label>Expiry Date</label>
                                </div>

                                <!-- Type -->
                                <div class="col-md-6 mb-4 form-group">
                                    <select name="type" id="discountType" class="form-control">
                                        <option value=""></option>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                    <label>Discount Type</label>
                                </div>

                                <!-- Discount -->
                                <div class="col-md-12 mb-4">
                                    <label class="mb-2">Discount Value</label>

                                    <div class="input-group">
                                        <span class="input-group-text" id="discountSymbol">%</span>

                                        <input type="number"
                                               id="discountInput"
                                               name="discount"
                                               class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="text-end">
                                <button class="btn btn-success px-4">
                                    Save Coupon
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE LIVE PREVIEW -->
            <div class="col-md-5">
                <div class="coupon-preview shadow">

                    <div class="preview-title" id="previewName">
                        Coupon Name
                    </div>

                    <div class="preview-discount mt-3" id="previewDiscount">
                        0%
                    </div>

                    <div class="mt-3" id="previewExpiry">
                        Expires: --
                    </div>

                </div>
            </div>

        </div>
    </div>


    <script>

        /* Elements */
        const nameInput = document.querySelector('[name="name"]');
        const discountInput = document.getElementById('discountInput');
        const typeSelect = document.getElementById('discountType');
        const expiryInput = document.querySelector('[name="expiry_date"]');

        const previewName = document.getElementById('previewName');
        const previewDiscount = document.getElementById('previewDiscount');
        const previewExpiry = document.getElementById('previewExpiry');
        const symbol = document.getElementById('discountSymbol');

        /* Live Name */
        nameInput.addEventListener('input', () => {
            previewName.innerText = nameInput.value || "Coupon Name";
        });

        /* Type Change */
        typeSelect.addEventListener('change', function () {
            if (this.value === 'percentage') {
                symbol.innerText = '%';
                discountInput.max = 100;
            } else {
                symbol.innerText = '₹';
                discountInput.removeAttribute('max');
            }
            updateDiscount();
        });

        /* Discount */
        discountInput.addEventListener('input', updateDiscount);

        function updateDiscount() {
            let val = discountInput.value || 0;
            let type = typeSelect.value;

            if (type === 'percentage' && val > 100) {
                discountInput.value = 100;
                val = 100;
            }

            previewDiscount.innerText = type === 'fixed'
                ? '₹' + val
                : val + '%';
        }

        /* Expiry */
        expiryInput.addEventListener('change', () => {
            previewExpiry.innerText = expiryInput.value
                ? "Expires: " + expiryInput.value
                : "Expires: --";
        });

        /* Auto Generate Name */
        nameInput.addEventListener('blur', () => {
            if (!nameInput.value) {
                let code = "SAVE" + Math.floor(Math.random()*100);
                nameInput.value = code;
                previewName.innerText = code;
            }
        });

    </script>

@endsection
