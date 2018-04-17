<div class="sidebar" data-background-color="white" data-active-color="danger">
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="#" class="simple-text">
        {{env('APP_NAME')}}
      </a>
    </div>

    <ul class="nav">
      <li class="active">
        <a href="/backend/user">
          <i class="fa fa-user"></i>
          <p>User</p>
        </a>
      </li>
      <li>
        <a href="/backend/client">
          <i class="fa fa-building"></i>
          <p>Client</p>
        </a>
      </li>
      {{--<li>--}}
        {{--<a href="/backend/item">--}}
          {{--<i class="fa fa-briefcase"></i>--}}
          {{--<p>Item</p>--}}
        {{--</a>--}}
      {{--</li>--}}
      <li>
        <a href="/backend/quotation">
          <i class="fa fa-file-o"></i>
          <p>Quotation</p>
        </a>
      </li>
      <li>
        <a href="/backend/invoice">
          <i class="fa fa-files-o"></i>
          <p>Invoice</p>
        </a>
      </li>
    </ul>
  </div>
</div>
