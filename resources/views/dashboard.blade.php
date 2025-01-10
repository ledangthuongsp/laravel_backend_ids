@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Danh sách người dùng</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->avatarUrl)
                                <img src="{{ $user->avatarUrl }}" alt="Avatar" width="50" height="50">
                            @else
                                <img src="{{ asset('default-avatar.jpg') }}" alt="Avatar" width="50" height="50">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-info">Xem</a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Sửa</a>
                            
                            <!-- Delete Button with Confirmation -->
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}">
                                Xóa
                            </button>

                            <!-- Modal Confirmation -->
                            <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa người dùng này không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
