@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item active" aria-current="page">
                            Transform structure from Airtable base to project database
                        </li>
                    </ol>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        {{ $msg }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
