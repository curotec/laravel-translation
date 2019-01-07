@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

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

                    <form method="POST" action="{{route('uploadfile')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                            <label for="csv_file">Upload .xlsx file to convert</label>
                            <input type="file" class="form-control-file" name="csv_file" id="csv_file">
                            @if ($errors->has('csv_file'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('csv_file') }}</strong>
                                  </span>
                            @endif
                          </div>
                          <input type="submit" value="Convert and download" class="btn btn-primary">
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
