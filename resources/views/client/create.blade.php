@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Create Client</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <form method="POST" class="form-horizontal" action="{{url('backend/client/create')}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @include('client._partial.fields')

              <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
