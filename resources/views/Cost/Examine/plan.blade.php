@extends('public')

@section('css')

@endsection
@section('open')

@endsection

@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form" id="query" lay-filter='query' >
    <div class="layui-input-inline">
      <select name="project_id" id="class" lay-verify="">
        <option value="">请选择项目</option>
        @foreach($project as $v)
        <option  value="{{ $v->id }}">{{ $v->name }}</option>
        @endforeach
      </select>
    </div>
      <div class="layui-input-inline">
        <select name="building" lay-verify="">
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
        <select name="unit" lay-verify="">
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
        <select name="floor" lay-verify="">
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
        <input name="room_number" value="" lay-verify="" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
      </div>
      <button class="layui-btn" lay-submit="query" lay-filter="query" style="margin-left: 5px;">查询</button>
      <a class="layui-btn layui-btn-primary" onclick="reset()">重置</a>
    </form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  </script>
  <script type="text/html" id="plan">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="plan">进入</a>
  </script>
  <script type="text/html" id="detailed">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="detailed">进入</a>
  </script>
</div>

@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    token = $("meta[name='csrf-token']").attr('content');
  
      tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/cost/examine/plan'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '施工计划审核'
      ,cols: [[
         {field:'id',fixed: 'left',title:'序号',unresize:true,width:80}
        ,{field:'project_name',title:'项目名称',unresize:true,width:120}
        ,{field:'building', title:'楼栋',unresize:true,width:80}
        ,{field:'unit', title:'单元',unresize:true,width:80}
        ,{field:'floor', title:'楼层',unresize:true,width:80}
        ,{field:'room_number', title:'房号',unresize:true,width:80}
        ,{field:'huxing_name', title:'户型',unresize:true,width:80}
        ,{title:'施工计划',unresize:true, toolbar: '#plan',width:100}
        ,{field:'settlement_price', title:'施工计划合计',unresize:true,width:100}
        ,{title:'成控明细',unresize:true, toolbar: '#detailed',width:100}
        ,{field:'budget_price', title:'成控明细合计',unresize:true,width:100}
        ,{title:'是否核准',unresize:true,width:120, templet:function(d){
          if(d.is_examine_b == 1)
          {
            return '<input type="checkbox" name="switch" id="'+d.id+'" checked="checked" lay-text="是|否" lay-filter="examine" lay-skin="switch" >';
          }else
          {
            return '<input type="checkbox" name="switch"  id="'+d.id+'" lay-text="是|否" lay-filter="examine" lay-skin="switch">'
          }
        }}
        ,{field:'examine_remarks_b', title:'备注',unresize:true}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:80}
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
  form.on('submit(query)',function(data){
    data = data.field;
    data._token = token;
    tab.reload({where:data});
    return false;
  });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          // layer.alert(JSON.stringify(data));
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'detailed')
      {
        openMax('详细','/cost/estimate/detailed?house_id='+data.id,function(){
          tab.reload();
        });
      }else if(obj.event === 'plan')
      {
        openMax('施工计划','/cost/examine/plan-plan?house_id='+data.id);
      }else if(obj.event === 'edit')
      {
        layer.prompt({
          title : '编辑备注'
          ,formType: 2
          ,value: data.examine_remarks_b
        }, function(value, index){
          $.ajax({
            url:'{{ url("/cost/examine/plan-edit") }}',
            type : 'post',
            data : {id:data.id,examine_remarks_b:value,_token:token},
            success : function(res)
            { 
              res = $.parseJSON(res);
              if(res.code == 200)
              {
                obj.update({
                  examine_remarks_b: value
                });
                layer.close(index);
                layMsgOk(res.msg);
              }else
              {
                layMsgError(res.msg);
              }
            },
            error : function(error)
            {
              layMsgError('操作失败');
            }
          })
          
        });
      }
    });
    form.on('switch(examine)',function(data){
      $.ajax({
        url : '{{ url("/cost/examine/plan-band") }}',
        type : 'post',
        data : {id:data.elem.id,is_examine_b:data.elem.checked,_token:token},
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            // layMsgOk(res.msg);
          }else
          {
            layMsgError(res.msg);
            tab.reload();
          }
        },
        error : function(error)
        {
          layMsgError('操作失败');
          tab.reload();
        }
      });
    })
  });

  </script>
@endsection

