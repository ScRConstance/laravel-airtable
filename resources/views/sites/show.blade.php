@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item active" aria-current="page">
                            Sites
                        </li>
                    </ol>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($site)
                        <table class="table">
                            <tr>
                                <th>ID</th><td>{{ $site->id }}</td>
                            </tr>
                            <tr>
                                <th>User ID</th><td>{{ $site->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th><td>{{ $site->name }}</td>
                            </tr>
                            <tr>
                                <th>Type</th><td>{{ $site->type }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th><td>{{ $site->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th><td>{{ $site->updated_at }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="text-center">
                            <p>You have not created any sites yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
