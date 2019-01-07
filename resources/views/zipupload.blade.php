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

                    <form method="POST" action="{{route('uploadzipphpfile')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="form-group{{ $errors->has('zipfile') ? ' has-error' : '' }}">
                            <label for="zipfile">Upload ZIP containing php files to convert</label>
                            <input type="file" class="form-control-file" name="zipfile" id="zipfile">
                            @if ($errors->has('zipfile'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('zipfile') }}</strong>
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
