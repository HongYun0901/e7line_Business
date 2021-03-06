<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/123.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

    {{--        <!-- search form (Optional) -->--}}
    {{--        <form role="form" action="{{route('products.search')}}" method="get" class="sidebar-form">--}}
    {{--            <div class="input-group">--}}
    {{--                <input type="text" name="namebesearch" class="form-control" placeholder="Search Product...">--}}
    {{--                <span class="input-group-btn">--}}
    {{--              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
    {{--              </button>--}}
    {{--            </span>--}}
    {{--            </div>--}}
    {{--        </form>--}}
    {{--        <!-- /.search form -->--}}

    <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">管理系統</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ (request()->is('/'))? 'active' : '' }}">
                <a href="{{ route('admin_dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>首頁</span>
                </a>
            </li>


            <li class="treeview{{ (request()->is('products*'))? ' active' : '' }}">


                @if(Auth::user()->level == 2)
                    <a href="#">
                        <i class="fa fa-address-book"></i>
                        <span>權限</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin_permission.index')}}">權限列表</a></li>
                    </ul>

                    <a href="#">
                        <i class="fa fa-address-book"></i>
                        <span>公司</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin_company.index')}}">公司列表</a></li>
                    </ul>

                @endif

{{--                @php($user_module = \App\Module::where('name','=','管理員查看')->first())--}}
                    {{--                @php($permission = \App\CompanyPermission::where('module_id','=',$user_module->id)--}}
                    {{--                        ->where('company_id','=',Auth::user()->company_id)->first()->permission)--}}

                    {{--                @if($permission < 2 or Auth::user()->level == 2)--}}
                    <a href="#">
                        <i class="fa fa-address-book"></i>
                        <span>管理員</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin_users.index')}}">管理員列表</a></li>
                        @if(Auth::user()->level >= 1)
                            <li><a href="{{route('admin_users.create')}}">新增管理員</a></li>
                        @endif
                    </ul>

{{--                @endif--}}

                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>公告</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin_announcement.index')}}">公告列表</a></li>
                    <li><a href="{{route('admin_announcement.create')}}">新增公告</a></li>
                </ul>
                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>規定</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin_info.index')}}">規定列表</a></li>
                    <li><a href="{{route('admin_info.create')}}">新增規定</a></li>
                </ul>

                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>投票</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin_vote.index')}}">投票列表</a></li>
                    <li><a href="{{route('admin_vote.create')}}">新增投票</a></li>
                </ul>


            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
