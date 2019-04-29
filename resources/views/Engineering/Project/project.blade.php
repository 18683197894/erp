@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card edit" style="display:none">
    <div class="layui-card-body" style="padding: 15px;">
      <form class="layui-form" lay-filter="edit">
        <input type="hidden" name="id" value="">
        <div class="layui-form-item">
          <label class="layui-form-label">入场时间</label>
          <div class="layui-input-block">
            <input type="text" name="admission_time" lay-verify="required" class="layui-input" id="time3">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">完成时间</label>
          <div class="layui-input-block">
            <input type="text" name="estimate_time" lay-verify="required" class="layui-input" id="time4">
          </div>
        </div>
        <div class="layui-form-item ">
          <div class="layui-input-block">
          <br>
            <div class="layui-footer">
              <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
            </div>
          </div>
        </div> 
      </form>
    </div>
</div>
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
  		<button class="layui-btn" lay-submit="query" lay-filter="query">查询</button>
      <a class="layui-btn layui-btn-primary" onclick="reset()">重置</a>
    </form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>


	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	</script>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('layui/city/JAreaData.js') }}"></script>
<script type="text/javascript" src="{{ asset('layui/city/JAreaSelect.js') }}"></script>
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','code','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/project'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '工程项目'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:80}
        ,{field:'project_name', title:'项目名称',unresize:true,width:120}
        ,{field:'room_number', title:'房号',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'huxing_name', title:'户型',unresize:true}
        ,{field:'acreage', title:'装修总面积',unresize:true,width:110}
        ,{field:'admission_time', title:'入场时间',unresize:true,width:200}
        ,{field:'estimate_time', title:'预计完成时间',unresize:true,width:200}
        ,{fixed: 'right', title:'操作',fixed: 'right', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:100}
      ]]
      ,page: {curr:$('#page').val(),limit:$('#limit').val()}
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
          if(data.length <= 0) return false;
          var id = new Array();
          $.each(data,function(i,n){
          	id.push(n.id);
          });
        layer.confirm('确定删除权限ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/rule-del") }}',
          	type : 'post',
          	data : {id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{

					layer.close(index);
					layMsgOk(res.msg);
					// location.reload(true);
					tab.reload();
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
    laydate.render({
      elem: '#time3' //指定元素
    });
    laydate.render({
      elem: '#time4' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除项目: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/project-del") }}',
          	type : 'post',
          	data : {id:data.id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{
          			obj.del();
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
      }else if(obj.event === 'edit'){
        form.val('edit',{
          'id':data.id,
          'admission_time':data.admission_time,
          'estimate_time':data.estimate_time
        })
        var width = ($(window).width() * 0.35)+'px';
        var height = ($(window).height() * 0.45)+'px';
      	edit = layer.open({
        type : 1,
        title : '编辑',
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        shade: 0.4,
        area : [width,height],
        content : $('.edit')
      })
      }else if(obj.event === 'house')
      {   
        var name = $('#name').attr('val');
        var page = tab.config.page.curr;
        var limit = tab.config.page.limit;
        window.location.href="/engineering/project/house?project_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }else if(obj.event == 'huxing')
      {
        var name = $('#name').attr('val');
        var page = tab.config.page.curr;
        var limit = tab.config.page.limit;
        window.location.href="/engineering/project/huxing?project_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }
    });
    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/engineering/project-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk('编辑成功');
            tab.reload();
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('编辑失败');
        }
      })
      return false;
    })
  });
  </script>
@endsection