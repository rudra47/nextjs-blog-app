@extends('admin.layouts.master')
@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Category List</h4>
            </div>
        </div>
        @include('admin.includes.validation_error')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create category')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add New Category</a>
                    @endcan
                    <br>
                    <br>
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th width="10%">#SL</th>
                                <th>Name</th>
                                @if(auth()->user()->can('update category') || auth()->user()->can('delete category'))
                                <th width="10%" class="text-center">Action</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @if($categories)
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td class="text-center">
                                            <a href="#" onclick="return false;" class="dropdown-toggle dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            @if(auth()->user()->can('update category') || auth()->user()->can('delete category'))
                                            <div class="dropdown-menu">
                                                @can('update category')
                                                <a class="dropdown-item btn btn-sm btn-info" href="{{route('admin.categories.edit', $category->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                                @endcan

                                                @can('delete category')
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" id="delete-form-{{ $category->id }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item btn btn-sm btn-danger" onclick="return makeDeleteRequest(event, {{ $category->id }})" type="submit" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                            @endif
                                        </td>
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
