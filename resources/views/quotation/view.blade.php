@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Quotation</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <div class="text-right padding-10">
              <form method="POST" action="{{url('/backend/quotation/create')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Quotation</button>
              </form>
            </div>
            <table class="table">
              <thead>
              <tr>
                <th>Quotation No.</th>
                <th>Company Name</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
              @foreach($quotations as $quotation)
                <tr id="{{$quotation->id}}" class="edit" style="cursor:pointer;">
                  <td>{{$quotation->quotation_no}}</td>
                  <td>{{$quotation->client->company_name ?? '-'}}</td>
                  <td>{{$quotation->quotation_date}}</td>
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
      window.location.href = "{{url('backend/quotation')}}" + "/" + id + "/edit";
    });
  </script>
@endsection
