@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item active" aria-current="page">
                            Fetches data from table in Airtable
                        </li>
                    </ol>
                </div>

                <div class="card-body">
                    @if(count($items))
                        <table class="table">
                            <tbody>
                                @foreach($items as $item)
                                    @if(isset($item["parents"]))
                                        @foreach($item["parents"] as $child)
                                        <tr>
                                            <td>{{ $child }}</td>
                                        </tr>
                                        @endforeach
                                        @php
                                        $is_child = true;
                                        @endphp
                                    <tr>
                                        <td>|____ {{ $item["number"] }}</td>
                                    </tr>
                                    @else
                                        <tr>
                                            <td>{{ $item["number"] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($item["children"]))
                                        @if(isset($is_child) && $is_child == true)
                                        @foreach($item["children"] as $child)
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|____ {{ $child }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                            @foreach($item["children"] as $child)
                                                <tr>
                                                    <td>|____ {{ $child }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>Can not process data.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
