@extends('public')

@section('css')
<style type="text/css">

</style>
@endsection

@section('open')
@endsection

@section('content')
          @foreach($department as $v)
          <div class="layui-card-body">
            <div class="layui-collapse" lay-accordion="">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">{{ $v->name }}</h2>
                <div class="layui-colla-content layui-show">
                            <table class="layui-table">
          
                            <thead>
                              <tr>
                                <th>姓名</th>
                                <th>头像</th>
                                <th>职务</th>
                                <th>手机</th>
                                <th>邮箱</th>
                                <th>个性签名</th>
                              </tr> 
                            </thead>
                            <tbody>
                              @foreach($v->Users as $val)
                              <tr>
                                <td>{{ $val->username }}</td>
                                <td>
                                  <div class="layui-inline">
                                    <img style="width:50px;height:50px;border-radius: 50px;" src="{{ !empty($val->head_portrait)?$val->head_portrait:env('USER_HEAD_PORTRAIT') }}">
                                  </div>
                                </td>
                                <td>{{ $val->post }}</td>
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->motto }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          </div>
              </div>

            </div>
          </div>
          @endforeach
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form'], function(){
    $ = layui.jquery
    ,admin = layui.admin
    ,element = layui.element
    ,router = layui.router()
    ,form = layui.form
    ,layer = layui.layer;

    element.render('collapse');
    token = $("meta[name='csrf-token']").attr('content');

  });
  </script>
@endsection