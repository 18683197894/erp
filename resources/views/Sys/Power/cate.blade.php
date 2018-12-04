@extends('public')

@section('css')

@endsection

@section('content')


<div class="layui-card-body">
  <div class="demoTable" style="padding-bottom: 10px">
    <div class="layui-input-inline">
      <input class="layui-input" name="cate_name" id="cate_name" placeholder="分类名搜索" autocomplete="off">
    </div>
    <button class="layui-btn">搜索</button>
    </div>
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  
  <script type="text/html" id="test-table-toolbar-toolbarDemo">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
      <button class="layui-btn layui-btn-sm" lay-event="cate_add">新增分类</button>
    </div>
  </script>
   
  <script type="text/html" id="test-table-toolbar-barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  </script>
</div>
  
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/power/cate'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'id', title:'ID', fixed: 'left', unresize: true,width:100}
        ,{field:'cate_name', title:'分类名'}
        ,{field:'url', title:'权限',width:400}
        ,{field:'created_at', title:'创建时间'}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
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

    $('.demoTable .layui-btn').on('click',function(){
    	cate_name = $('#cate_name').val();
    	tab.reload({where:{cate_name:cate_name,_token:token},page:{curr:1}});
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
        layer.confirm('确定删除权限分类ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/cate-del") }}',
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
        case 'cate_add':
          layer.prompt({title:'新增分类'},function(value,index){
            $.ajax({
              url : '{{ url("/power/cate-add") }}',
              type : 'post',
              data : {cate_name:value,_token:token},
              success : function(res)
              {
                res = $.parseJSON(res);
                if(res.code == 200)
                {
                  layer.close(index);
                  layMsgOk(res.msg);
                  $('#cate_name').val('');
                  tab.reload({
                    page:{curr:1},
                    where:{_token:token}
                  });
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
          })
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
        layer.confirm('确定删除权限分类: '+data.cate_name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/cate-del") }}',
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
        layer.prompt({
        	title : '修改权限名'
          ,formType: 2
          ,value: data.cate_name
        }, function(value, index){
          $.ajax({
          	url:'{{ url("/power/cate-edit") }}',
          	type : 'post',
          	data : {id:data.id,cate_name:value,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{
      					obj.update({
      						cate_name: value
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
  
  });
  </script>
@endsection