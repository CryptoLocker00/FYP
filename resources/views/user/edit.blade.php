@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Edit User</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <form method="POST" id="delete-frm" action="{{url('backend/user/delete')}}">
              {{ method_field('DELETE') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$user->id}}">
            </form>

            <form method="POST" class="form-horizontal" action="{{url('backend/user/update')}}">
              {{ method_field('PATCH') }}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$user->id}}">

              @include('user._partial.fields')

              <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="button" id="delete-btn" class="btn btn-danger">Delete</button>
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
        bootbox.confirm("Are you sure you want to delete this user ?", function (result) {
          if (result)
            $('#delete-frm').submit();
        });
      })
    });
  </script>
@endsection