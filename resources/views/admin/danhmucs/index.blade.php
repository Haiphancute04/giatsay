@extends('layouts.admin')

@section('title', __('Category Management'))

@section('content')

<div class="card-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">📂 {{ __('Category Management') }}</h3>

        <a href="{{ route('admin.danh-mucs.create') }}" class="btn btn-primary btn-add">
            <span class="material-symbols-outlined">add</span>
            {{ __('Add New Category') }}
        </a>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="table-responsive">
        <table class="table table-custom table-bordered align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center" style="width: 60px;">ID</th>
                    <th class="fw-bold text-center">{{ __('Category Name') }}</th>
                    <th class="fw-bold text-center">Slug</th>
                    <th class="fw-bold text-center"style="width: 190px;">{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($danhMucs as $danhMuc)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $danhMuc->id }}</td>
                        <td class="text-center">{{ $danhMuc->tendanhmuc }}</td>
                        <td class="text-center">{{ $danhMuc->tendanhmuc_slug }}</td>

                        <td class="text-center">
                            <a href="{{ route('admin.danh-mucs.edit', $danhMuc->id) }}"
                               class="btn btn-warning btn-action text-white">
                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                                {{ __('Edit') }}
                            </a>

                            <form action="{{ route('admin.danh-mucs.destroy', $danhMuc->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('{{ __('Are you sure delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action">
                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            {{ __('No service description available.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $danhMucs->links() }}
    </div>

</div>
@endsection