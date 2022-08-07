@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Add Coupon</h4>
            </div>
        </div>
        @include('admin.includes.validation_error')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body m-t-10">
                    <form action="{{ route('admin.coupons.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Code</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" id="code" value="{{ old('code') }}" class="form-control" name="code" placeholder="Enter product code"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Coupon Type</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control" id="coupon_type" name="coupon_type" required>
                                        <option value="">Select anyone</option>
                                        <option value="{{App\Models\Coupon::TYPE_ONE_TIME_USE}}">One Time Use</option>
                                        <option value="{{App\Models\Coupon::TYPE_UNLIMITED_USE}}">Unlimited Use</option>
                                        <option value="{{App\Models\Coupon::TYPE_USE_LIMIT}}">Use Limit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="limitDiv" style="display: none;">
                                <label class="col-lg-2 col-sm-12 col-form-label">Limit</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="number" id="limit" value="{{ old('limit') }}" class="form-control" name="limit" placeholder="Enter coupon use limit">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Select Categories</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control js-example-placeholder-multiple" multiple="multiple" name="category_ids[]" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Minimum Ammount</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="number" id="minimum_amount" value="{{ old('minimum_amount') }}" class="form-control" name="minimum_amount" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Discount Type</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option value="">Select anyone</option>
                                        <option value="{{App\Models\Coupon::DISCOUNT_PERCENTAGE}}">Percentage</option>
                                        <option value="{{App\Models\Coupon::DISCOUNT_FIXED_AMOUNT}}">Fixed Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Discount Amount</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="number" id="discount_amount" value="{{ old('discount_amount') }}" class="form-control" name="discount_amount" placeholder="Enter product discount amount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Valid from</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="date" id="valid_from" value="{{ old('valid_from') }}" class="form-control" name="valid_from" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Valid to</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="date" id="valid_to" value="{{ old('valid_to') }}" class="form-control" name="valid_to" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="mb-3 col-lg-2 col-sm-12 col-form-label">Status</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status_yes" value="{{ \App\Models\Coupon::STATUS_ACTIVE }}"
                                           name="status" class="custom-control-input" checked="">
                                    <label class="custom-control-label" for="status_yes">Active</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status_no" value="{{ \App\Models\Coupon::STATUS_INACTIVE }}"
                                           name="status" class="custom-control-input">
                                    <label class="custom-control-label" for="status_no">Inactive</label>
                                </div>
                            </div><br>


                            <div class="form-group">
                                <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <a class="btn btn-secondary waves-effect" href="{{ route('admin.products.index') }}">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    @include('admin.includes.styles.summernote')
@endpush

@push('script')
    @include('admin.includes.scripts.summernote')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#product-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#product-image").change(function() {
            readURL(this);
        });

        $('#coupon_type').on('change',function() {
            let couponType = $(this).val();
            if (couponType === "{{App\Models\Coupon::TYPE_USE_LIMIT}}") {
                $('#limitDiv').show();
            }else{
                $('#limitDiv').hide();
            }

        });
    </script>
@endpush

