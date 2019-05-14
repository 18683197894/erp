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
}).use(['index', 'table','form'], function(){
  admin = layui.admin
  ,$ = layui.jquery
  ,form = layui.form
  ,table = layui.table;
  token = $("meta[name='csrf-token']").attr('content');
  house_id = '{{ $house->id }}';

  var tab = table.render({
    elem: '#test-table-toolbar'
    ,url: '/cost/examine/material-supplier'
    ,where:{_token:token,house_id:house_id}
    ,method:'post'
    ,toolbar: '#test-table-toolbar-toolbarDemo'
    ,title: '材料清单'
    ,cols: [[
       {field:'class_a',fixed: 'left',  title:'一级分类',unresize:true,width:120}
      ,{field:'class_b', title:'二级分类',unresize:true,width:120}
      ,{field:'code', title:'编码',unresize:true,width:120}
      ,{field:'brand', title:'品牌',unresize:true,width:120}
      ,{field:'model', title:'型号',unresize:true,width:120}
      ,{field:'spec', title:'规格',unresize:true,width:120}
      ,{field:'color', title:'颜色',unresize:true,width:120}
      ,{field:'metering', title:'计量单位',unresize:true,width:120}
      ,{field:'parts_num', title:'配件套数',unresize:true,width:120}
      ,{field:'place', title:'产地',unresize:true,width:120}
      ,{field:'purchase_price', title:'采购价',unresize:true,width:120}
      // ,{field:'standard_price', title:'标准价',unresize:true,width:120}
      // ,{field:'promotion_price', title:'促销价',unresize:true,width:120}
      // ,{field:'settlement_price', title:'结算价',unresize:true,width:120}
      ,{field:'artificial_price', title:'人工费用',unresize:true,width:120}
      ,{field:'num', title:'数量',unresize:true,width:120}
      ,{field:'total', title:'总价',unresize:true,width:120}
      ,{field:'remarks', title:'备注',unresize:true,width:120}
      ,{field:'created_at',fixed: 'right', title:'时间',unresize:true,width:120}
    ]]
  ,parseData: function(res){ //res 即为原始返回的数据
    return {
      "code": res.code, //解析接口状态
      "msg": res.msg, //解析提示文本
      "count": res.total, //解析数据长度
      "data": res.data //解析数据列表
    };
  }
  });

  form.on('submit(query)',function(data){
    data = data.field;
    tab.reload({where:{data:data,_token:token}});
    return false;
  });


});
</script>
@endsection