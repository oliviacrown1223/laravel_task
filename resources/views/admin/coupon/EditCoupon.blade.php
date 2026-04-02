@extends('admin.panel')

@section('content')

    <style>
        .card-modern {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: none;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 10px rgba(79,70,229,0.25);
            border-color: #6366f1;
        }

        .btn-modern {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .coupon-preview {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            transition: 0.4s;
        }

        .coupon-preview:hover {
            transform: scale(1.03);
        }

        .preview-title {
            font-size: 20px;
            font-weight: bold;
        }

        .preview-discount {
            font-size: 38px;
            font-weight: bold;
            margin: 10px 0;
        }

        .divider {
            border-top: 2px dashed rgba(255,255,255,0.5);
            margin: 15px 0;
        }
    </style>

    <div class="container py-4">

        <div class="row g-4">

            <!-- FORM -->
            <div class="col-lg-7">
                <div class="card card-modern p-4">

                    <h4 class="mb-4">✏️ Edit Coupon</h4>

                    <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name"
                                       value="{{ old('name', $coupon->name) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Coupon Code</label>
                                <input type="text" name="code" id="couponCode"
                                       value="{{ old('code', $coupon->code) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Usage Limit</label>
                                <input type="number" name="usage_limit"
                                       value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Expiry Date</label>
                                <input type="date" name="expiry_date"
                                       value="{{ old('expiry_date', $coupon->expiry_date) }}"
                                       class="form-control">
                            </div>
                          {{--  <td>
                            <span >
                                {{}}
                            </span>
                            </td>--}}
                            <div class="col-md-6">
                                <label>Used Count</label>
                                <input type="number" name="used_count"
                                       value="{{ old('used_count',  $coupon->used_count )}}" readonly
                                       class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" id="discountType" class="form-select">
                                    <option value="percentage" {{ $coupon->type=='percentage'?'selected':'' }}>Percentage</option>
                                    <option value="fixed" {{ $coupon->type=='fixed'?'selected':'' }}>Fixed</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Discount</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="symbol">%</span>
                                    <input type="number" name="discount" id="discountInput"
                                           value="{{ old('discount', $coupon->discount) }}"
                                           class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button class="btn btn-success btn-modern">
                                💾 Update Coupon
                            </button>
                            <a href="{{ route('coupon.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </form>
                </div>
            </div>

            <!-- LIVE PREVIEW -->
            <div class="col-lg-5">
                <div class="coupon-preview">

                    <div class="preview-title" id="previewName">
                        {{ $coupon->code }}
                    </div>

                    <div class="preview-discount" id="previewDiscount">
                        {{ $coupon->type == 'fixed' ? '₹'.$coupon->discount : $coupon->discount.'%' }}
                    </div>

                    <div class="divider"></div>

                    <div id="previewExpiry">
                        ⏳ Expires: {{ $coupon->expiry_date }}
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script>
        const nameInput = document.querySelector('[name="name"]');
        const codeInput = document.getElementById('couponCode');
        const discountInput = document.getElementById('discountInput');
        const typeSelect = document.getElementById('discountType');
        const expiryInput = document.querySelector('[name="expiry_date"]');

        const previewName = document.getElementById('previewName');
        const previewDiscount = document.getElementById('previewDiscount');
        const previewExpiry = document.getElementById('previewExpiry');
        const symbol = document.getElementById('symbol');

        function updatePreview(){
            previewName.innerText = codeInput.value;

            let val = discountInput.value || 0;
            let type = typeSelect.value;

            previewDiscount.innerText = type === 'fixed'
                ? '₹' + val
                : val + '%';

            symbol.innerText = type === 'fixed' ? '₹' : '%';

            previewExpiry.innerText = expiryInput.value
                ? "⏳ Expires: " + expiryInput.value
                : "⏳ Expires: --";
        }

        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', updatePreview);
        });

        window.addEventListener('load', updatePreview);
    </script>

@endsection
