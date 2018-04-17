@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Client</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <div class="text-right padding-10">
              <a href="{{url('/backend/client/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Client</a>
            </div>
            <table class="table">
              <thead>
              <tr>
                <th>Company Name</th>
                <th>Contact Person</th>
              </tr>
              </thead>
              <tbody>
              @foreach($clients as $client)
                <tr id="{{$client->id}}" class="edit" style="cursor:pointer;">
                  <td>{{$client->company_name}}</td>
                  <td>{{$client->contactPerson->name}}</td>
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
      window.location.href = "{{url('backend/client')}}" + "/" + id + "/edit";
    });
  </script>
@endsection
