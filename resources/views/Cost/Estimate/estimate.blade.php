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
        <select name="project_id" lay-verify="">
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
      <a class="layui-btn" lay-submit="query" lay-filter="query" style="margin-left: 5px;">查询</a>
      <a class="layui-btn layui-btn-primary" onclick="reset()">重置</a>
    </form>
  </div>
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  </script>
  <script type="text/html" id="drawing">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="drawing">管理图纸</a>
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
      ,url: '/cost/estimate'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预估测算'
      ,cols: [[
         {field:'id',title:'序号',fixed: 'left',unresize:true,width:80}
        ,{field:'project_name',title:'项目名称',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'room_number', title:'房号',unresize:true}
        ,{field:'huxing_name', title:'户型',unresize:true}
        ,{title:'设计图纸',unresize:true, toolbar:'#drawing',width:100}
        ,{field:'template_name',title:'样板套装',unresize:true,width:120}
        ,{field:'concept_price', title:'概算价',unresize:true,rowspan:2}
        ,{field:'budget_price', title:'预算价',unresize:true,rowspan:2}
        ,{field:'settlement_price', title:'结算价',unresize:true,rowspan:2}
        ,{field:'difference_price',title:'金额差异',unresize:true,width:120}
        ,{title:'详细',unresize:true, toolbar:'#detailed'}
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
      if(obj.event === 'edit')
      {
        layer.prompt({
          title : '修改概算价'
          ,formType: 0
          ,value: data.concept_price
        }, function(value, index){
          if(value)
          {
            s = /^\d{1,8}\.\d{1,2}$/;
            sS = /^\d{1,8}$/;
            if(!s.test(value) && !sS.test(value))
            {
              layMsgError('请输入整数 (MIN:1 MAX:8 保留小数点2位)');
              return false;
            }
          }
          $.ajax({
            url:'{{ url("/cost/estimate-edit") }}',
            type : 'post',
            data : {id:data.id,concept_price:value,_token:token},
            success : function(res)
            { 
              res = $.parseJSON(res);
              if(res.code == 200)
              {
                obj.update({
                  concept_price: value
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
      }else if(obj.event === 'drawing')
      {
        openMax('管理图纸','/design/manage/drawing?house_id='+data.id);
      }else if(obj.event === 'detailed')
      {
        openMax('详细','/cost/estimate/detailed?house_id='+data.id,function(){
          tab.reload();
        });
      }
    });
  });

  </script>
@endsection

