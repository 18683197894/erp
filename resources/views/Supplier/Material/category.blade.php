@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form" id="myform"lay-filter="component-form-group">
         <div class="layui-form-item" >
              <label class="layui-form-label">品类</label>
              <div class="layui-input-block">
                <input name="name" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
          </div>
	      <div class="layui-form-item">
	        <label class="layui-form-label">分类</label>
	          <div class="layui-input-block">
	            <select name="class" lay-verify="required">
	              <option value=""></option>
	              <option value="主材">主材</option>
	              <option value="辅材">辅材</option>
	              <option value="家电">家电</option>
	              <option value="家具">家具</option>
	            </select>
	          </div>
	      </div>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
              </div>
            </div>
          </div> 
        </form>
      </div>
</div>
<div class="layui-card edit" style="display:none">
      <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
        <form class="layui-form" id="edit"lay-filter="edit">
          <input type="hidden" name="id" value="">
          <div class="layui-form-item" >
              <label class="layui-form-label">品类</label>
              <div class="layui-input-block">
                <input name="name" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
          </div>
	      <div class="layui-form-item">
	        <label class="layui-form-label">分类</label>
	          <div class="layui-input-block">
	            <select name="class" lay-verify="required">
	              <option value=""></option>
	              <option value="主材">主材</option>
	              <option value="辅材">辅材</option>
	              <option value="家电">家电</option>
	              <option value="家具">家具</option>
	            </select>
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
		<form class="layui-form">
		<div class="layui-input-inline">
		<input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="品类搜索" autocomplete="off">
        <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
        <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
        <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<div class="layui-input-inline">
			<select name="class" id="class" lay-verify="required">
			  <option value=""></option>
			  <option {{ isset($request['class']) && $request['class'] == '主材'?'selected':'' }} value="主材">主材</option>
			  <option {{ isset($request['class']) && $request['class'] == '辅材'?'selected':'' }} value="辅材">辅材</option>
			  <option {{ isset($request['class']) && $request['class'] == '家电'?'selected':'' }} value="家电">家电</option>
			  <option {{ isset($request['class']) && $request['class'] == '家具'?'selected':'' }} value="家具">家具</option>
			</select>
		</div>
		<a class="layui-btn">搜索</a>
	</form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增品类','.add',0.4,0.5)">新增品类</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
	<script type="text/html" id="material">
	  <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="material">进入</a>
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
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/supplier/category'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料品类'
      ,where:{name:$('#name').val(),_token:token,class:$('#class').val()}
      ,cols: [[
         {field:'name', title:'品类',fixed: 'left',unresize:true}
        ,{field:'class', title:'分类',unresize:true}
        ,{toolbar:'#material', title:'材料',unresize:true,width:200}
        ,{fixed: 'right', title:'操作',fixed: 'right', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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

    $('.demoTable .layui-btn').on('click',function(){
      var name = $('#name').val();
      var class_re = $('#class').val();
      $('#name').attr('val',name);
      $('#class').attr('val',class_re);
    	tab.reload({where:{name:name,_token:token,class:class_re},page:{curr:1}});
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
      elem: '#start' //指定元素
    });
    laydate.render({
      elem: '#end' //指定元素
    });
    laydate.render({
      elem: '#start2' //指定元素
    });
    laydate.render({
      elem: '#end2' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除品类: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/supplier/category-del") }}',
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
      } else if(obj.event === 'edit'){
          document.getElementById("edit").reset();
          form.val("edit", {
            "id" : data.id,
            'name' : data.name,
            'class' : data.class
          }); 
          var width = ($(window).width() * 0.4)+'px';
          var height = ($(window).height() * 0.5)+'px';
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
      }else if(obj.event === 'material')
      {   
        var name = $('#name').attr('val');
        var class_re = $('#class').attr('val');
        var page = tab.config.page.curr;
        var limit = tab.config.page.limit;
        window.location.href="/supplier/material?category_id="+data.id+"&name="+name+"&class="+class_re+"&page="+page+"&limit="+limit;
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;

      $.ajax({
        url : '{{ url("/supplier/category-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
            $('#name').val('');
            $('#page').val(1);
            tab.config.page.curr = 1;
            tab.reload({
              where : {_token:token},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('新增失败');
        }
      })
      return false;
    })
    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/supplier/category-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk(res.msg);
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