@extends('admin.layouts.master')

@section('title', '編輯投票')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                編輯投票
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-shopping-bag"></i> 投票</a></li>
                <li class="active">編輯投票</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->
            <div class="container">

                <form enctype="multipart/form-data" class="well form-horizontal" onsubmit="return validateForm()"
                      action="{{ route('admin_vote.update',$vote->id) }}" method="post">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                &times;
                            </button>
                            <h4><i class="icon fa fa-ban"></i> 錯誤！</h4>
                            請修正以下表單錯誤：
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <fieldset>

                        <div class=" col-md-12 form-group">
                            <label class=" control-label">投票類別</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <select name="type" class="form-control">
                                        <option @if($vote->type == 0) selected @endif value="0">單選</option>
                                        <option @if($vote->type == 1) selected @endif value="1">多選</option>
                                    </select>
                                </div>
                            </div>
                            <label class="control-label">選項類別</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <select name="option_type" class="form-control" onchange="option_type_changed(this)"
                                            id="option_type_select">
                                        <option @if($vote->option_type == 0) selected @endif value="0">純文字</option>
                                        <option @if($vote->option_type == 1) selected @endif value="1">圖片</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class=" control-label">投票名稱</label>
                            <div class=" inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="text" class="form-control" name="title" placeholder="請輸入標題" id="title"
                                           value="{{ old('title', $vote->title) }}">

                                </div>
                            </div>
                            <label class=" control-label">截止日期</label>
                            <div class=" inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="datetime-local" class="form-control" name="deadline" id="deadline"
                                           value="{{ old('deadline',date('Y-m-d\TH:i', strtotime($vote->deadline))) }}">

                                </div>
                            </div>
                            <label class=" control-label">狀態</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                        <span class="input-group-addon"><i
                                                    class="glyphicon glyphicon-envelope"></i></span>
                                    <select name="is_active" class="form-control">
                                        <option value="0" @if($vote->is_active ==0 ) selected @endif>停用</option>
                                        <option value="1" @if($vote->is_active ==1 ) selected @endif>正常</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>

                            function add_option() {
                                var option_count = document.getElementById('option_count').value;
                                option_count = parseInt(option_count) + 1;
                                document.getElementById('option_count').value = option_count;

                                var option_select = document.getElementById('option_type_select');
                                var option_type = option_select.options[option_select.selectedIndex].value;
                                var type = 'hidden';
                                if (option_type == 0) {
                                    type = 'hidden';
                                } else if (option_type == 1) {
                                    type = 'file';
                                }


                                html = '<div class="input-group" id="options' + option_count + '">\n' +
                                    '                                    <span class="input-group-addon">\n' +
                                    '                                        <a onclick="add_option()" class="glyphicon glyphicon-plus-sign"></a>\n' +
                                    '                                        <a onclick="delete_option(' + option_count + ')" class="glyphicon glyphicon-minus-sign"></a>\n' +

                                    '                                    </span>\n' +
                                    '                                        <input type="text" class="form-control" name="options[]" placeholder="請輸入選項">\n' +
                                    '                                        <input class="form-control" type="' + type + '" name="image_url[]" style="width: 100%" onchange="fileUpload(this,' + option_count + ')">\n' +
                                    '\n' +
                                    '<input type="hidden" name="has_image[]" id="has_image' + option_count + '" value="0">' +

                                    '                                </div>';


                                // var option_list_node = document.getElementById('option_list');
                                $("#option_list").append(html);

                            }

                            function delete_option(count) {
                                var node_string = 'options' + count;
                                var option_node = document.getElementById(node_string);
                                var parent_node = document.getElementById('option_list');
                                parent_node.removeChild(option_node);

                            }

                            function option_type_changed(option_select) {
                                var option_type = option_select.options[option_select.selectedIndex].value;
                                var image_nodes = document.getElementsByName('image_url[]');
                                var images = document.getElementsByName('oldimg');

                                if (option_type == 0) {
                                    for (let i = 0; i < image_nodes.length; i++) {
                                        image_nodes[i].type = 'hidden'
                                    }
                                    for (var i = 0; i < images.length; i++) {
                                        images[i].style.display = 'none'
                                    }
                                    return;


                                } else if (option_type == 1) {
                                    for (let i = 0; i < image_nodes.length; i++) {
                                        image_nodes[i].type = 'file'
                                    }
                                    for (var i = 0; i < images.length; i++) {
                                        images[i].style.display = ''
                                    }
                                    return;

                                }

                                return;
                            }

                            function fileUpload(input, num) {
                                console.log(input.value);
                                var has_image_node_string = 'has_image' + num;
                                var has_image_node = document.getElementById(has_image_node_string);
                                if (input.value == '' || input.value == null) {
                                    has_image_node.value = 0;
                                }
                                var parts = input.value.split('.');
                                var ext = parts[parts.length - 1];
                                ext = ext.toLowerCase();
                                console.log(ext);
                                if (ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif' || ext == 'svg') {
                                    console.log(input.files[0].size);
                                    if (input.files[0].size > 300000) {
                                        alert('檔案超過300000bytes!!');
                                        input.value = null;
                                        has_image_node.value = 0;
                                        return
                                    }

                                    has_image_node.value = 1;
                                    return;
                                } else {
                                    alert('上傳檔案必須是圖片檔唷！！！！！！');
                                    input.value = null;
                                    has_image_node.value = 0;

                                }

                            }

                            function validateForm() {
                                var title = document.getElementById('title').value;
                                if (title == null || title == '') {
                                    alert('投票標題不能為空');
                                    return false;
                                }
                                var option_nodes = document.getElementsByName('options[]');
                                for (let i = 0; i < option_nodes.length; i++) {
                                    if (option_nodes[i].value == null || option_nodes[i].value == '') {
                                        alert('投票選項不能為空');
                                        return false;
                                    }
                                }
                                var deadline = Date.parse(document.getElementById('deadline').value);
                                var now = new Date();
                                now = Date.parse(now);
                                if (deadline <= now) {
                                    alert('投票截止時間不能比現在早！');
                                    return false;
                                }


                                return true;


                            }


                        </script>


                        <div class="col-md-12  form-group">
                            <label class="control-label">選項</label>
                            <input type="hidden" id="option_count" name="option_count"
                                   value="{{count($vote->vote_options)}}">
                            <div class=" inputGroupContainer" id="option_list">
                                @php($option_count = 1)
                                @php($img_css = 'hidden')
                                @if($vote->option_type == 1)
                                    @php($img_css = 'file')
                                @endif
                                @foreach($vote->vote_options as $vote_option)

                                    <div class="input-group" id="options{{$option_count}}">
                                    <span class="input-group-addon">
                                        <a onclick="add_option()" class="glyphicon glyphicon-plus-sign"></a>
                                        @if($option_count > 2)
                                            <a onclick="delete_option({{$option_count}})"
                                               class="glyphicon glyphicon-minus-sign"></a>

                                        @endif
                                    </span>
                                        <input type="text" class="form-control" name="options[]" placeholder="請輸入選項"
                                               value="{{ old('options',$vote_option->name) }}">


                                        <input class="form-control" type="{{$img_css}}" name="image_url[]"
                                               style="width: 100%"
                                               onchange="fileUpload(this,{{$option_count}})">
                                        <input type="hidden" name="has_image[]" id="has_image{{$option_count}}"
                                               value="0">
                                        <input type="hidden" name="old_image[]" value="{{$vote_option->image_url}}">
                                        @if($vote->option_type == 1)
                                            <img name="oldimg" style="display: block" id="img{{$option_count}}"
                                                 src="{{$vote_option->image_url}}" width="532" height="141">
                                        @endif


                                    </div>
                                    @php($option_count += 1)
                                @endforeach
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <a class="btn btn-danger" href="{{ URL::previous() }}">取消</a>
                                <button type="submit" class="btn btn-primary">確認送出</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
