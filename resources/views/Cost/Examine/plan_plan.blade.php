@extends('public')

@section('css')

@endsection

@section('open')

@endsection

@section('content')
<div class="layui-card-body">
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
</div>
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
    house_id = {{ $house->id }};
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/construction/plan'
      ,where:{_token:token,house_id:house_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '施工计划'
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:80}
        ,{field:'time', title:'时间',unresize:true,width:120}
        ,{field:'name', title:'工序名称',unresize:true,width:140}
        ,{field:'code', title:'材料编号',unresize:true,width:120}
        ,{field:'material_name', title:'所需材料',unresize:true,width:120}
        ,{field:'num', title:'数量',unresize:true}
        ,{field:'total', title:'预计金额',unresize:true}
        ,{field:'artificial_price', title:'人工成本',unresize:true}
        ,{field:'other_price', title:'其他费用',unresize:true}
        ,{fixed: 'right',field:'count', title:'合计',unresize:true}
        // ,{fixed: 'right',title:'操作',unresize:true,width:120,toolbar:'#operation'}
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

  });
  </script>
@endsection