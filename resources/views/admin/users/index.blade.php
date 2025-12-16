@extends('layouts.admin')

@section('title', __('User Management'))

@section('content')

<style>
    .social-icon {
        font-size: 12px;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        color: white !important;
        margin-right: 4px;
        display: inline-block;
        text-decoration: none;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .social-icon:hover { opacity: 0.8; color: white; }
    .social-google { background-color: #db4437; }
    .social-facebook { background-color: #4267B2; }

    .btn-action {
        font-size: 12px !important; 
        padding: 3px 6px !important; 
        display: inline-flex;
        align-items: center;
        gap: 2px; 
        height: 28px; 
        line-height: 1;
    }
    .btn-action .material-symbols-outlined {
        font-size: 14px !important; 
    }
</style>

<div class="card-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">👤 {{ __('User Management') }}</h3>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light"> 
                <tr>
                    <th class="fw-bold text-center" style="width: 50px;">ID</th>
                    <th class="fw-bold text-center" style="width: 70px;">{{ __('Avatar') }}</th>
                    <th class="fw-bold text-center" style="min-width: 200px;">{{ __('Full name') }}</th> 
                    <th class="fw-bold text-center" style="min-width: 220px;">{{ __('contact') }}</th> 
                    <th class="fw-bold text-center" style="width: 200px;">{{ __('Address') }}</th>
                    <th class="fw-bold text-center" style="width: 120px;">{{ __('Link') }}</th>
                    <th class="fw-bold text-center" style="width: 100px;">{{ __('Role') }}</th>
                    <th class="fw-bold text-center" style="width: 110px;">{{ __('Booking Date') }}</th>
                    <th class="fw-bold text-center" style="width: 130px;">{{ __('Actions') }}</th> </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $user->id }}</td>
                        
                        <td class="text-center">
                            @php
                                $avatarSrc = asset('assets/img/default-user.png'); 
                                if ($user->avatar) {
                                    if (Str::startsWith($user->avatar, ['http://', 'https://'])) {
                                        $avatarSrc = $user->avatar; 
                                    } else {
                                        $avatarSrc = asset('storage/' . $user->avatar); 
                                    }
                                }
                            @endphp
                            <img src="{{ $avatarSrc }}" alt="{{ $user->name }}" class="avatar-sm shadow-sm" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        </td>

                        <td class="text-center">
                            <div class="text-center">{{ $user->name }}</div>
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-truncate" style="max-width: 200px;" title="{{ $user->email }}">
                                    <i class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">mail</i> {{ $user->email }}
                                </span>
                                <span class="text-muted mt-1">
                                    <i class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">call</i> {{ $user->phone ?? '---' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $user->address }}">
                                {{ $user->address ?? 'Chưa cập nhật' }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($user->google_id)
                                <a href="mailto:{{ $user->email }}" class="social-icon social-google" title="Google Email">G</a>
                            @endif
                            @if($user->facebook_id)
                                <a href="https://www.facebook.com/profile.php?id={{ $user->facebook_id }}" target="_blank" class="social-icon social-facebook" title="Facebook Profile">F</a>
                            @endif
                            @if(!$user->google_id && !$user->facebook_id)
                                <span class="text-muted small">---</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                @if ($user->role === 'admin') <span class="badge bg-danger">ADMIN</span>
                                @else <span class="badge bg-primary">USER</span> @endif
                            </div>
                        </td>

                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="btn btn-warning btn-sm btn-action text-white" title="{{ __('Edit') }}">
                                    <span class="material-symbols-outlined">edit</span>
                                    {{ __('Edit') }}
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-action" {{ $user->id === auth()->id() ? 'disabled' : '' }} title="{{ __('Delete') }}">
                                        <span class="material-symbols-outlined">delete</span>
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <div class="d-flex flex-column align-items-center">
                                <span class="material-symbols-outlined fs-1 mb-2">folder_off</span>
                                <span>{{ __('No users found') }}</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    @endif

</div>
@endsection