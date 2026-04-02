@extends('admin.panel')

@section('content')
<style>
    .coupon-preview {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border-radius: 20px;
        padding: 30px;
        position: sticky;
        top: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        transition: 0.4s;
    }

    /* Glass effect overlay */
    .coupon-preview::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        transform: rotate(25deg);
    }

    /* Hover Animation */
    .coupon-preview:hover {
        transform: translateY(-5px) scale(1.02);
    }
    .coupon-divider {
        border-top: 2px dashed rgba(255,255,255,0.5);
        margin: 20px 0;
    }
    /* Title */
    .preview-title {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    /* Discount Big Text */
    .preview-discount {
        font-size: 40px;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Expiry */
    #previewExpiry {
        font-size: 14px;
        opacity: 0.9;
    }

    /* Divider line */
    .coupon-divider {
        border-top: 2px dashed rgba(255,255,255,0.5);
        margin: 20px 0;
    }

    /* Decorative circles (ticket style) */
    .coupon-preview::after {
        content: "";
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 120%;
        height: 30px;
        background: radial-gradient(circle, transparent 10px, #fff 11px);
        background-size: 30px 30px;
    }
</style>
    <div class="container py-4 fade-in">

        <div class="row g-4">

            <!-- ================= FORM ================= -->
            <div class="col-lg-7">
                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Create Coupon</h5>
                    </div>

                    <div class="card-body">

                        {{-- Success --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">

                                <!-- Name -->
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" placeholder=" "
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}">
                                    <label>Coupon Name</label>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Code -->
                                <div class="col-md-6 form-group">
                                    <input type="text" name="code" id="couponCode" placeholder=" "
                                           class="form-control"
                                           value="{{ old('code') }}" readonly>
                                    <label>Coupon Code</label>
                                </div>

                                <!-- Generate Button FULL WIDTH -->
                                <div class="col-12">
                                    <button type="button" class="btn btn-dark w-100" id="generateCodeBtn">
                                        🎲 Generate Coupon Code
                                    </button>
                                </div>

                                <!-- Usage -->
                                <div class="col-md-6 form-group">
                                    <input type="number" name="usage_limit" placeholder=" "
                                           class="form-control @error('usage_limit') is-invalid @enderror"
                                           value="{{ old('usage_limit') }}">
                                    <label>Usage Limit</label>
                                    @error('usage_limit') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Expiry -->
                                <div class="col-md-6 form-group">
                                    <input type="date" name="expiry_date"
                                           class="form-control @error('expiry_date') is-invalid @enderror">
                                    <label>Expiry Date</label>
                                    @error('expiry_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Type -->
                                <div class="col-md-6 form-group">
                                    <select name="type" id="discountType"
                                            class="form-control @error('type') is-invalid @enderror">
                                        <option value=""></option>
                                        <option value="percentage" {{ old('type')=='percentage'?'selected':'' }}>Percentage</option>
                                        <option value="fixed" {{ old('type')=='fixed'?'selected':'' }}>Fixed</option>
                                    </select>
                                    <label>Discount Type</label>
                                    @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Discount -->
                                <div class="col-md-6">
                                    <label class="mb-1 fw-semibold">Discount Value</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="discountSymbol">%</span>
                                        <input type="number"
                                               id="discountInput"
                                               name="discount"
                                               class="form-control @error('discount') is-invalid @enderror"
                                               value="{{ old('discount') }}">
                                    </div>
                                    @error('discount') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                            </div>

                            <div class="text-end mt-4">
                                <button class="btn btn-success px-4 py-2">
                                    💾 Save Coupon
                                </button>
                                <a href="{{ route('coupon.index') }}" class="btn btn-secondary">Back</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- ================= PREVIEW ================= -->
            <div class="col-lg-5">
                <div class="coupon-preview shadow">

                    <div class="preview-title" id="previewName">
                        🎟️ Coupon Code
                    </div>

                    <div class="preview-discount mt-2" id="previewDiscount">
                        0%
                    </div>

                    <div class="coupon-divider"></div>

                    <div id="previewExpiry">
                        ⏳ Expires: --
                    </div>

                    <button class="btn btn-light btn-sm mt-3 w-100" onclick="copyCode()">
                        📋 Copy Code
                    </button>

                </div>
            </div>

        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}
<script>

    const nameInput = document.querySelector('[name="name"]');
    const discountInput = document.getElementById('discountInput');
    const typeSelect = document.getElementById('discountType');
    const expiryInput = document.querySelector('[name="expiry_date"]');

    const previewName = document.getElementById('previewName');
    const previewDiscount = document.getElementById('previewDiscount');
    const previewExpiry = document.getElementById('previewExpiry');
    const symbol = document.getElementById('discountSymbol');

    /* ================= AUTO GENERATE ON LOAD ================= */
    window.addEventListener('load', () => {
        if (!document.getElementById('couponCode').value) {
            generateCode();
        }
    });

    /* ================= NAME ================= */
    if(nameInput){
        nameInput.addEventListener('input', () => {
            previewName.innerText = nameInput.value || document.getElementById('couponCode').value;
        });
    }

    /* ================= TYPE ================= */
    if(typeSelect){
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
    }

    /* ================= DISCOUNT ================= */
    if(discountInput){
        discountInput.addEventListener('input', updateDiscount);
    }

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

    /* ================= EXPIRY ================= */
    if(expiryInput){
        expiryInput.addEventListener('change', () => {
            previewExpiry.innerText = expiryInput.value
                ? "⏳ Expires: " + expiryInput.value
                : "⏳ Expires: --";
        });
    }

    /* ================= GENERATE CODE ================= */
    document.getElementById('generateCodeBtn').addEventListener('click', generateCode);

    function generateCode(){
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';

        for (let i = 0; i < 8; i++) {
            code += chars[Math.floor(Math.random() * chars.length)];
        }

        document.getElementById('couponCode').value = code;
        previewName.innerText = code;
    }

    /* ================= COPY ================= */
    function copyCode() {
        let code = document.getElementById('couponCode').value;
        navigator.clipboard.writeText(code);

        alert("Copied: " + code);
    }

    /* ================= FORM VALIDATION ================= */
    document.querySelector('form').addEventListener('submit', function(e){

        const code = document.getElementById('couponCode').value;

        if(!code){
            e.preventDefault();
            alert("Please generate coupon code");
            return;
        }

    });
</script>

@endsection
