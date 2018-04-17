@extends('_layouts.base-backend')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('_partials.messages')
      <div class="card">
        <div class="header">
          <h4 class="title">Item Template</h4>
        </div>
        <div class="content container-fluid">
          <div class="col-md-12">
            <div class="text-right padding-10">
              <a href="{{url('/backend/item/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Item Template</a>
            </div>
            <table class="table">
              <thead>
              <tr>
                <th>Item Code</th>
                <th>Unit Cost</th>
              </tr>
              </thead>
              <tbody>
              @foreach($items as $item)
                <tr id="{{$item->id}}" class="edit" style="cursor:pointer;">
                  <td>{{$item->item_code}}</td>
                  <td>{{$item->unit_cost}}</td>
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
      window.location.href = "{{url('backend/item')}}" + "/" + id + "/edit";
    });
  </script>
@endsection
