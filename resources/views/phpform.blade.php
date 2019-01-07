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

                    <form method="POST" action="{{route('uploadphpfile')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="form-group{{ $errors->has('phpfile') ? ' has-error' : '' }}">
                            <label for="phpfile">Upload .php file to convert</label>
                            <input type="file" class="form-control-file" name="phpfile" id="phpfile">
                            @if ($errors->has('phpfile'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('phpfile') }}</strong>
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
