@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Add Category</h4>
            </div>
        </div>
        @include('admin.includes.validation_error')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body m-t-10">
                    <form action="{{ route('admin.categories.store') }}" method="post">
                        @csrf
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label for="name" class="col-lg-2 col-sm-12 col-form-label">Category Name</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" id="name" value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter category name" autofocus required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                        <i class="fa fa-save"></i> Submit
                                    </button>
                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.categories.index') }}">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
