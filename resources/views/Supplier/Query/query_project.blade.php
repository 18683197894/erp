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
    ,url: '/supplier/query-project'
    ,where:{_token:token}
    ,method:'post'
    ,toolbar: '#test-table-toolbar-toolbarDemo'
    ,title: '材料清单'
    ,cols: [[
       {field:'category',fixed: 'left',  title:'品类',unresize:true,width:120}
      ,{field:'class',title:'类别',sort:true,unresize:true}
      ,{field:'code', title:'编码',unresize:true}
      ,{field:'brand', title:'品牌',unresize:true}
      ,{field:'model', title:'型号',unresize:true}
      ,{field:'spec', title:'规格',unresize:true}
      ,{field:'color', title:'颜色',unresize:true}
      ,{field:'metering', title:'计量单位',unresize:true}
      ,{field:'parts_num', title:'配件套数',unresize:true}
      ,{field:'place', title:'产地',unresize:true,width:120}
      ,{field:'num',fixed: 'right',title:'数量',unresize:true,sort:true,width:120}
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