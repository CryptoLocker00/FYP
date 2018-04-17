@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Edit Quotation</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">

            <form method="POST" id="invoice-frm" action="{{url('backend/invoice/create')}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$quotation->id}}">
            </form>

            <form method="POST" id="delete-frm" action="{{url('backend/quotation/delete')}}">
              {{ method_field('DELETE') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$quotation->id}}">
            </form>

            <form method="POST" action="{{url('backend/quotation/update')}}">
              {{ method_field('PATCH') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $quotation->id }}">
              @include('quotation._partial.quotation_fields')
              @include('quotation._partial.quotation_item_fields')

              <div class="form-group">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="button" id="invoice-btn" class="btn btn-info">Updated to Invoice</button>
                  <a href="{{url('/backend/quotation/'.$quotation->id.'/pdf')}}" class="btn btn-link" target="_blank">View PDF</a>
                  <button type="button" id="delete-btn" class="btn btn-danger pull-right">Delete</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    @include('quotation._partial.quotation_item_clone')
  </div>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
    $(document).ready(function () {
      $('#delete-btn').click(function () {
        bootbox.confirm("Are you sure you want to delete this item ?", function (result) {
          if (result)
            $('#delete-frm').submit();
        });
      })
    });

    $(document).ready(function () {
      $('#invoice-btn').click(function () {
        bootbox.confirm("Once this change to invoice it can't return to quotation are you sure ?", function (result) {
          if (result)
            $('#invoice-frm').submit();
        });
      })
    });
  </script>
@endsection