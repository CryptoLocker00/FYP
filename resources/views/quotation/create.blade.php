@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Create Quotation</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <form method="POST" action="{{url('backend/quotation/create')}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @include('quotation._partial.quotation_fields')
              @include('quotation._partial.quotation_item_fields')

              <div class="form-group">
                <div class="col-md-12">
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