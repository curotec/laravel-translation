@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard - Download Demo Format Files</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                      <div class="alert alert-danger">
                        {{ session('error') }}
                      </div>
                    @endif

                    <ul>
                      <li><a href="{{route('demosingleexcel')}}">Single Excel File</a></li>
                      <li><a href="{{route('demosinglephp')}}">Single PHP File</a></li>
                      <li><a href="{{route('demomultipleexcel')}}">Excel File with multiple sheets</a></li>
                      <li><a href="{{route('demomultiplezip')}}">Zip file containing Laravel translation files(PHP) in folder</a></li>
                    </ul>

                    <p>Note: Use " | " for nested keys in Excel sheets. For more reference download the demo files.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
