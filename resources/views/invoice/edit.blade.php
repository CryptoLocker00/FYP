@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Edit Invoice</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">

            <form method="POST" id="delete-frm" action="{{url('backend/invoice/delete')}}">
              {{ method_field('DELETE') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$invoice->id}}">
            </form>

            <form method="POST" action="{{url('backend/invoice/update')}}">
              {{ method_field('PATCH') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $invoice->id }}">
              @include('invoice._partial.invoice_fields')
              @include('invoice._partial.invoice_item_fields')

              <div class="form-group">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{route('invoice.pdf', ['invoice'=> $invoice->id])}}" class="btn btn-link" target="_blank">View PDF</a>

                  <button type="button" id="delete-btn" class="btn btn-danger pull-right">Delete</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
    $(document).ready(function () {
      $('#delete-btn').click(function () {
        bootbox.confirm("Are you sure you want to delete this item ?", function (result) {
          if ( result )
            $('#delete-frm').submit();
        });
      })
    });
  </script>
@endsection
