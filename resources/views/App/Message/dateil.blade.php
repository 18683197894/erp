@extends('public')

@section('css')

@endsection

@section('content')
  <div class="layui-fluid" id="LAY-app-message-detail">
    <div class="layui-card layuiAdmin-msg-detail">
     
        <div class="layui-card-header">
          <h1>{{ $model->msg->title }}</h1>
          <p>
            <span>{{ $model->msg->created_at }}</span>
          </p>
        </div>
        <div class="layui-card-body layui-text">
          <div class="layadmin-text">
            @php echo $model->msg->content; @endphp
          </div>
          
          <div style="padding-top: 30px;">
            <a href="{{ url('/app/message') }}"  class="layui-btn layui-btn-primary layui-btn-sm">返回上级</a>
          </div>
        </div>
   
    </div>
  </div>
@endsection


@section('js')
 <script src="{{ asset('/layui/layuiadmin/layui/layui.js') }}"></script>   
  <script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index']);
  </script>
@endsection