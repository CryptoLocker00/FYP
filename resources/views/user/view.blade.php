@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">User</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <div class="text-right padding-10">
              <a href="{{url('/backend/user/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;User</a>
            </div>
            <table class="table">
              <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
              </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                <tr id="{{$user->id}}" class="edit" style="cursor:pointer;">
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
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
      window.location.href = "{{url('backend/user')}}" + "/" + id + "/edit";
    });
  </script>
@endsection
