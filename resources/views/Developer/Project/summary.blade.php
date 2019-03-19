@extends('public')

@section('css')

@endsection

@section('content')
<div class="layui-card-body">
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	  </div>
	</script>
</div>
@endsection

@section('js')
<script type="text/javascript">
layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/commerce/summary'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '项目进度总汇'
      ,cols: [[
         // {type: 'checkbox', fixed: 'left'}
        {field:'company_name', title:'开发商',fixed: 'left',unresize:true}
        ,{field:'name', title:'项目名称',unresize:true}
        ,{field:'source', title:'项目地址',unresize:true}
        ,{field:'appointments_name', title:'当前进度',unresize:true}
        ,{field:'label', title:'状态',unresize:true}
        ,{field:'now_result', title:'洽谈结果',unresize:true}
        ,{field:'next_stage', title:'下阶段攻坚重点',unresize:true}
        ,{field:'remarks', title:'备注',unresize:true}
        ,{field:'user_name', title:'负责人',unresize:true}
      ]]
      ,page: true
    ,parseData: function(res){ //res 即为原始返回的数据
	    return {
	      "code": res.code, //解析接口状态
	      "msg": res.msg, //解析提示文本
	      "count": res.total, //解析数据长度
	      "data": res.data //解析数据列表
	    };
	  }
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          // layer.alert(JSON.stringify(data));
        break;
        case 'getCheckLength':
          // var data = checkStatus.data;
          // layer.msg('选中了：'+ data.length + ' 个');
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
      }
    });
  });
</script>
@endsection