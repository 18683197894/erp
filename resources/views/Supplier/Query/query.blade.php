@extends('public')

@section('css')

@endsection

@section('content')
<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form">
		<div class="layui-input-inline">
			<select name="project_id" id="class" lay-verify="required">
        <option value="">请选择项目</option>
        @foreach($project as $v)
			  <option  value="{{ $v->id }}">{{ $v->name }}</option>
			  @endforeach
      </select>
		</div>
    <div class="layui-input-inline">
        <select name="unit" lay-verify="required">
          <option value="">请选择单元</option>
          <option value="1">1单元</option>
          <option value="2">2单元</option>
          <option value="3">3单元</option>
          <option value="4">4单元</option>
          <option value="5">5单元</option>
          <option value="6">6单元</option>
          <option value="7">7单元</option>
          <option value="8">8单元</option>
          <option value="9">9单元</option>
          <option value="10">10单元</option>
        </select>
      </div>
      <div class="layui-input-inline">
        <select name="building" lay-verify="required">
          <option value="">请选择楼栋</option>
          <option value="1">1栋</option>
          <option value="2">2栋</option>
          <option value="3">3栋</option>
          <option value="4">4栋</option>
          <option value="5">5栋</option>
          <option value="6">6栋</option>
          <option value="7">7栋</option>
          <option value="8">8栋</option>
          <option value="9">9栋</option>
          <option value="10">10栋</option>
          <option value="11">11栋</option>
          <option value="12">12栋</option>
          <option value="13">13栋</option>
          <option value="14">14栋</option>
          <option value="15">15栋</option>
        </select>
      </div>
      <div class="layui-input-inline">
        <select name="floor" lay-verify="required">
          <option value="">请选择楼层</option>
          <option value="1">1层</option>
          <option value="2">2层</option>
          <option value="3">3层</option>
          <option value="4">4层</option>
          <option value="5">5层</option>
          <option value="6">6层</option>
          <option value="7">7层</option>
          <option value="8">8层</option>
          <option value="9">9层</option>
          <option value="10">10层</option>
          <option value="11">11层</option>
          <option value="12">12层</option>
          <option value="13">13层</option>
          <option value="14">14层</option>
          <option value="15">15层</option>
          <option value="16">16层</option>
          <option value="17">17层</option>
          <option value="18">18层</option>
          <option value="19">19层</option>
          <option value="20">20层</option>
          <option value="21">21层</option>
          <option value="22">22层</option>
          <option value="23">23层</option>
          <option value="24">24层</option>
          <option value="25">25层</option>
          <option value="26">26层</option>
          <option value="27">27层</option>
          <option value="28">28层</option>
          <option value="29">29层</option>
          <option value="30">30层</option>
        </select>
      </div>
      <div class="layui-input-inline">
        <input name="room_number" value="" lay-verify="required" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
      </div>
      <button class="layui-btn" lay-submit="" lay-filter="query">查询</button>
    </form>

	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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

  var tab = table.render({
    elem: '#test-table-toolbar'
    ,url: '/supplier/query'
    ,where:{_token:token}
    ,method:'post'
    ,toolbar: '#test-table-toolbar-toolbarDemo'
    ,title: '材料清单'
    ,cols: [[
       {field:'category',fixed: 'left',  title:'品类',unresize:true,width:120}
      ,{field:'class',title:'类别',unresize:true,width:120}
      ,{field:'position', title:'位置',unresize:true,width:120}
      ,{field:'code', title:'编码',unresize:true,width:120}
      ,{field:'brand', title:'品牌',unresize:true,width:120}
      ,{field:'model', title:'型号',unresize:true,width:120}
      ,{field:'spec', title:'规格',unresize:true,width:120}
      ,{field:'color', title:'颜色',unresize:true,width:120}
      ,{field:'metering', title:'计量单位',unresize:true,width:120}
      ,{field:'parts_num', title:'配件套数',unresize:true,width:120}
      ,{field:'place', title:'产地',unresize:true,width:120}
      ,{field:'standard_price', title:'标准价',unresize:true,width:120}
      ,{field:'promotion_price', title:'促销价',unresize:true,width:120}
      ,{field:'settlement_price', title:'结算价',unresize:true,width:120}
      ,{field:'other_price', title:'其他费用',unresize:true,width:120}
      ,{field:'other_explain', title:'费用说明',unresize:true,width:120}
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