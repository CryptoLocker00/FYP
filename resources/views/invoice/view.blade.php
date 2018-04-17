@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Invoice</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <table class="table">
              <thead>
              <tr>
                <th>Invoice No.</th>
                <th>Quotation No.</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
              @foreach($invoices as $invoice)
                <tr id="{{$invoice->id}}" class="edit" style="cursor:pointer;">
                  <td>{{$invoice->invoice_no}}</td>
                  <td>{{$invoice->quotation->quotation_no}}</td>
                  <td>{{$invoice->date}}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $('.table').DataTable();

    $(document).on('click', 'tr.edit', function () {
      var id = $(this).attr("id");
      window.location.href = "{{url('backend/invoice')}}" + "/" + id + "/edit";
    });
  </script>
@endsection
