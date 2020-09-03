@extends('admin.layouts.master')

@section('title', '公司列表')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                公司列表
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-shopping-bag"></i>公司</a></li>
                <li class="active">公司列表</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            @if(session('msg'))
                @if(session('msg')=='')
                    <div class="alert alert-success text-center">{{'Success'}}</div>
                @else
                    <div class="alert alert-danger text-center">{{session('msg')}}</div>
                @endif
            @endif

            @if(session('msgs'))
                <div class="alert-danger alert text-center">
                    @foreach(session('msgs') as $msg)
                        {{$msg}} <br>

                    @endforeach
                </div>
        @endif

        <!--------------------------
              | Your Page Content Here |
              -------------------------->

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>匯入</label><br>
                                    <div class="inline">
                                        <form action="{{ route('admin_company.import') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" class="form-control-file">
                                            <button class="btn btn-success btn-sm">匯入公司</button>
                                        </form>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-hover" style="width: 100%">

                                <thead style="background-color: lightgray">
                                <tr>
                                    <th class="text-center" style="width:30%">名稱</th>
                                    <th class="text-center" style="width:20%">統編</th>
                                    <th class="text-center" style="width:20%">是否激活</th>
                                    <th class="text-center" style="width:10%">創立時間</th>
                                    <th class="text-center" style="width:20%">其他</th>


                                </tr>
                                </thead>
                                @foreach ($companies as $company)
                                    <tr class="text-center">
                                        @if($company->id==0)
                                            @continue
                                        @endif
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->tax_id }}</td>
                                        <td>
                                            @if($company->is_active == 0)
                                                否
                                            @elseif($company->is_active == 1)
                                                是
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('Y-m-d', strtotime($company->create_date))}}
                                        </td>

                                        <td><a class="btn btn-primary btn-sm"
                                               href="{{route('admin_company.edit',$company->id)}}">編輯 </a></td>


                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            {{ $companies->links()}}
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
