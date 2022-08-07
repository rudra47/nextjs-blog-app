@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Coupon List</h4>
            </div>
        </div>
        @include('admin.includes.validation_error')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create coupon')
                        <a href="{{route('admin.coupons.create')}}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add New Coupon</a>
                    @endcan
                    <br>
                    <br>
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Code</th>
                                <th>Coupon Type</th>
                                <th>Limit</th>
                                <th>Discount Amount</th>
                                <th>Min Amount</th>
                                <th>Valid To</th>
                                <th>Status</th>
                                @if(auth()->user()->can('update coupon') || auth()->user()->can('delete coupon'))
                                <th>Action</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @if($coupons)
                                @foreach($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>
                                            @if ($coupon->coupon_type == \App\Models\Coupon::TYPE_ONE_TIME_USE)
                                                <span class="text-capitalize">{{\App\Models\Coupon::TYPE_ONE_TIME_USE}}</span>
                                            @elseif($coupon->coupon_type == \App\Models\Coupon::TYPE_UNLIMITED_USE)
                                                <span class="text-capitalize">{{\App\Models\Coupon::TYPE_UNLIMITED_USE}}</span>
                                            @elseif($coupon->coupon_type == \App\Models\Coupon::TYPE_USE_LIMIT)
                                                <span class="text-capitalize">{{\App\Models\Coupon::TYPE_USE_LIMIT}}</span>
                                            @endif
                                        </td>
                                        {{-- <td>{{ optional($coupon->store)->name }}</td> --}}
                                        <td>{{ $coupon->limit }}</td>
                                        <td>$ {{ number_format($coupon->discount_amount, 2) }}</td>
                                        <td>$ {{ number_format($coupon->minimum_amount, 2) }}</td>
                                        <td>{{ $coupon->valid_to }}</td>
                                        <td>
                                            @if ($coupon->status == \App\Models\Coupon::STATUS_ACTIVE)
                                                <p class="badge badge-success">Active</p>
                                            @else
                                                <p class="badge badge-danger">Inactive</p>
                                            @endif
                                        </td>

                                        @if(auth()->user()->can('update coupon') || auth()->user()->can('delete coupon'))
                                        <td class="text-center">
                                            <a href="#" onclick="return false;" class="dropdown-toggle dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                @can('update coupon')
                                                <a class="dropdown-item btn btn-sm btn-info" href="{{route('admin.coupons.edit', $coupon->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                                @endcan
                                                @can('delete coupon')
                                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" id="delete-form-{{ $coupon->id }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item btn btn-sm btn-danger" onclick="return makeDeleteRequest(event, {{ $coupon->id }})" type="submit" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
@push('style')
    @include('admin.includes.styles.datatable')
@endpush

@push('script')
    @include('admin.includes.scripts.datatable')
@endpush
