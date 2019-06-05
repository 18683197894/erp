<?php
  $label = App\Model\Sys\Menu::where('url',\Request::getRequestUri())
                                ->with(['Menu'=>function($query){
                                  return $query->with(['Menu'])->get();
                                }])
                                ->first();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/layui/css/layui.css') }}" media="all">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/admin.css') }}" media="all">
  <style type="text/css">
    .layui-table-tips-main{
      word-wrap: break-word;word-break: break-all;overflow: hidden;max-height: 1000px;
    }
  </style>
  @yield('css')
</head>
  @yield('open')
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
        @if(!empty($label) || isset($url))
          <div class="layui-card-header">
            <div class="layui-card-body">
              @if(!empty($label))
              <span class="layui-breadcrumb" lay-filter="breadcrumb">
                    @if(!empty($label->Menu->Menu))
                    <a href="{{ $label->Menu->Menu->url == '#'?'javascript:;':$label->Menu->Menu->url }}">{{ $label->Menu->Menu->title }}</a>
                    @endif
                    <a href="{{ $label->Menu->url == '#'?'javascript:;':$label->url }}">{{ $label->Menu->title }}</a>
                    <a><cite>{{ $label->title}}</cite></a>      
              </span>
              @elseif(isset($url))
              <span class="layui-breadcrumb" lay-filter="breadcrumb">
                <a href="{{ $url }}">返回上一页</a>
                <a><cite>{{ $title }}</cite></a>
              </span>
              @endif
              <br>
            </div>
          </div>
        @endif

  @yield('content')
        </div>
      </div>
    </div>
</div>

    


  <script src="{{ asset('/layui/layuiadmin/layui/layui.js') }}"></script>  
  <script src="{{ asset('/layui/layuiadmin/layui/custom.js') }}"></script>  
  <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
  <script type="text/javascript">
      $.ajax('/app/message-unread',{
        type : 'post',
        data : {_token:'{{ csrf_token() }}'},
        success : function(res)
        { 
            var res = $.parseJSON(res);

            if(res.data.letter > 0 || res.data.notice > 0 || res.data.sys > 0)
            { 
              $("#Uiunread",window.parent.document).remove();
              $("#Fuunread",window.parent.document).append('<span id="Uiunread" class="layui-badge-dot"></span>');
            }else
            {
              $("#Uiunread",window.parent.document).remove();
            }

        },
        error:function(error)
        {
          $("#Uiunread",window.parent.document).remove();
        }
      }) 
  </script>
  @yield('js')

</body>
</html>