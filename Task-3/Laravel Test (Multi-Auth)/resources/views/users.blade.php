@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users List to Approve</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <table class="table">
                            <tr>
                                <th>SN</th>
                                <th>User name</th>
                                <th>Email</th>
                                <th>Action</th>
                                
                            </tr>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    
                                    <td><a href="{{ route('admin.users.approve', $user->id) }}"
                                           class="btn btn-primary btn-sm">Approve</a></td>
                                    <td><a href="{{ route('admin.users.decline', $user->id) }}"
                                            class="btn btn-danger btn-sm">Decline</a></td>       
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No users found.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection