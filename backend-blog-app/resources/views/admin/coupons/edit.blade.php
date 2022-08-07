@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Update Product</h4>
            </div>
        </div>
        @include('admin.includes.validation_error')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body m-t-10">
                    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Code</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" id="code" value="{{ $coupon->code ?? old('code') }}" class="form-control" name="code" placeholder="Enter product code"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Coupon Type</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control" id="coupon_type" name="coupon_type" required>
                                        <option value="">Select anyone</option>
                                        <option {{ $coupon->coupon_type == App\Models\Coupon::TYPE_ONE_TIME_USE ? 'selected' : ''}} value="{{App\Models\Coupon::TYPE_ONE_TIME_USE}}">One Time Use</option>
                                        <option {{ $coupon->coupon_type == App\Models\Coupon::TYPE_UNLIMITED_USE ? 'selected' : ''}} value="{{App\Models\Coupon::TYPE_UNLIMITED_USE}}">Unlimited Use</option>
                                        <option {{ $coupon->coupon_type == App\Models\Coupon::TYPE_USE_LIMIT ? 'selected' : ''}} value="{{App\Models\Coupon::TYPE_USE_LIMIT}}">Use Limit</option>
                                    </select>
                                </div>
                            </div>
                            <div id="limitDiv">
                            @if ($coupon->coupon_type == App\Models\Coupon::TYPE_USE_LIMIT)
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-12 col-form-label">Limit</label>
                                    <div class="col-lg-6 col-sm-12">
                                        <input type="number" id="limit" value="{{ $coupon->limit ?? old('limit') }}" class="form-control" name="limit" placeholder="Enter coupon use limit">
                                    </div>
                                </div>
                            @endif
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Select Categories</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control js-example-placeholder-multiple" multiple="multiple" name="category_ids[]" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $coupon->categories->contains($category)? 'selected' : ''}} >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Minimum Ammount</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="number" id="minimum_amount" value="{{ $coupon->minimum_amount ?? old('minimum_amount') }}" class="form-control" name="minimum_amount" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Discount Type</label>
                                <div class="col-lg-6 col-sm-12">
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option value="">Select anyone</option>
                                        <option {{ $coupon->discount_type == App\Models\Coupon::DISCOUNT_PERCENTAGE ? 'selected' : ''}} value="{{App\Models\Coupon::DISCOUNT_PERCENTAGE}}">Percentage</option>
                                        <option {{ $coupon->discount_type == App\Models\Coupon::DISCOUNT_FIXED_AMOUNT ? 'selected' : ''}} value="{{App\Models\Coupon::DISCOUNT_FIXED_AMOUNT}}">Fixed Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Discount Amount</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="number" id="discount_amount" value="{{ $coupon->discount_amount ?? old('discount_amount') }}" class="form-control" name="discount_amount" placeholder="Enter product discount amount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Valid from</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="date" id="valid_from" value="{{ $coupon->valid_from ?? old('valid_from') }}" class="form-control" name="valid_from" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-12 col-form-label">Valid to</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="date" id="valid_to" value="{{ $coupon->valid_to ?? old('valid_to') }}" class="form-control" name="valid_to" placeholder="Enter product minimum amount"  required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="mb-3 col-lg-2 col-sm-12 col-form-label">Status</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status_yes" value="{{ \App\Models\Coupon::STATUS_ACTIVE }}"
                                           name="status" class="custom-control-input" {{ $coupon->status == \App\Models\Coupon::STATUS_ACTIVE? 'checked' : '' }} >
                                    <label class="custom-control-label" for="status_yes">Active</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status_no" value="{{ \App\Models\Coupon::STATUS_INACTIVE }}"
                                           name="status" class="custom-control-input" {{ $coupon->status == \App\Models\Coupon::STATUS_INACTIVE? 'checked' : '' }} >
                                    <label class="custom-control-label" for="status_no">Inactive</label>
                                </div>
                            </div><br>


                            <div class="form-group">
                                <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <a class="btn btn-secondary waves-effect" href="{{ route('admin.coupons.index') }}">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row" id="limitDivClone">
        <label class="col-lg-2 col-sm-12 col-form-label">Limit</label>
        <div class="col-lg-6 col-sm-12">
            <input type="number" value="" class="form-control" name="limit" placeholder="Enter coupon use limit">
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
            let limitDivClone = $('#limitDivClone').clone();
            if (couponType === "{{App\Models\Coupon::TYPE_USE_LIMIT}}") {
                $('#limitDiv').html(limitDivClone);
            }else{
                $('#limitDiv').html('');
            }
        });
    </script>
@endpush
