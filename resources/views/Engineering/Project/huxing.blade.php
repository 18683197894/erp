@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card dwg_upload" style="display:none">
      <div class="layui-card-body">
        <div class="layui-upload-drag" id="dwg_upload" lay-data="">
          <i class="layui-icon"></i>
          <p>点击上传，或将文件拖拽到此处</p>
        </div>
      </div>
</div>
<div class="layui-card effect_image" style="display:none">
      <div class="layui-card-body">
        <div class="layui-upload-drag" id="effect_image" lay-data="">
          <i class="layui-icon"></i>
          <p>点击上传，或将图片拖拽到此处</p>
        </div>
      </div>
</div>
@endsection

@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
			<input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
			<input class="layui-input" name="name" id="name" placeholder="户型搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" lay-event="add">新增户型</button>
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
  }).use(['index', 'table','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/project/huxing'
      ,where:{_token:token,project_id:$('#project_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '项目联系人'
      ,cols: [[
         {type: 'checkbox', fixed: 'left'}
        ,{field:'name', title:'户型',unresize:true}
        ,{field:'dwg_image', title:'DWG平面图',unresize:true,templet:function(d){
          if(d.dwg_image !== '')
          {       
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='dwg_upload'><i class='layui-icon'></i>上传文件</a><a href='/huxing/download?a="+d.id+"&c=dwg_image' target='_blank' class='layui-btn layui-btn-xs layui-btn-normal'>下载</a>"      
          }else
          {
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='dwg_upload'><i class='layui-icon'></i>上传文件</a>"      

          }
        }}
        ,{field:'effect_image', title:'IMG效果图',unresize:true,templet:function(d){
          if(d.effect_image !== '')
          {       
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='effect_image'><i class='layui-icon'></i>上传图片</a><a href='"+d.effect_image+"' target='_blank' class='layui-btn layui-btn-xs layui-btn-normal'>查看</a>"      
          }else
          {
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='effect_image'><i class='layui-icon'></i>上传图片</a>"      

          }
        }}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:110}
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
    	name = $('#name').val();
    	tab.reload({where:{name:name,_token:token,project_id:$('#project_id').val()},page:{curr:1}});
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          if(data.length <= 0) return false;
          var id = new Array();
          var name = new Array();
          $.each(data,function(i,n){
          	name.push(n.name);
          	id.push(n.id);
          });
        layer.confirm('确定删除户型: '+name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/project/huxing-del") }}',
          	type : 'post',
          	data : {id:id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{

    					layer.close(index);
    					layMsgOk(res.msg);
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
        case 'add':
          layer.prompt({title:'新增户型'},function(value,index){
            value = value.toUpperCase();
            $.ajax({
              url : '{{ url("/engineering/project/huxing-add") }}',
              type : 'post',
              data : {name:value,project_id:$('#project_id').val(),_token:token},
              success : function(res)
              {
                res = $.parseJSON(res);
                if(res.code == 200)
                {
                  layer.close(index);
                  layMsgOk(res.msg);
                  $('#name').val('');
                  tab.reload({
                    page:{curr:1},
                    where:{_token:token,project_id:$('#project_id').val()}
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
        layer.confirm('确定删除户型: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/project/huxing-del") }}',
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
      }else if(obj.event === 'dwg_upload')
      { 
          var re_data = "{data:{id:"+data.id+",_token:'"+token+"'}}";
          $('.dwg_upload').find("#dwg_upload").attr('lay-data',re_data);
          var width = ($(window).width() * 0.3)+'px';
          var height = ($(window).height() * 0.5)+'px';
            dwg_upload = layer.open({
            type : 1,
            title : '上传DWG平面图',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : ['288px','210px'],
            content : $('.dwg_upload')
          })
      }else if(obj.event === 'effect_image')
      { 
          var re_data = "{data:{id:"+data.id+",_token:'"+token+"'}}";
          $('.effect_image').find("#effect_image").attr('lay-data',re_data);
          var width = ($(window).width() * 0.3)+'px';
          var height = ($(window).height() * 0.5)+'px';
            effect_image = layer.open({
            type : 1,
            title : '上传平面效果图',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : ['288px','210px'],
            content : $('.effect_image')
          })
      }else if(obj.event == 'edit')
      {
        layer.prompt({
          title : '修改户型'
          ,formType: 3
          ,value: data.name
        }, function(value, index){
          value = value.toUpperCase();
          $.ajax({
            url:'{{ url("/engineering/project/huxing-edit") }}',
            type : 'post',
            data : {id:data.id,project_id:data.project_id,name:value,_token:token},
            success : function(res)
            { 
              res = $.parseJSON(res);
              if(res.code == 200)
              {
                obj.update({
                  name: value
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
        })
      }
    });

    upload.render({
      elem: '#dwg_upload'
      ,url: '{{ url("/engineering/project/huxing-upload") }}'
      ,method : 'post'
      ,field:'dwg_upload'
      ,accept: 'file' //普通文件
      ,exts :'dwg'
      ,done: function(res){
        layer.close(dwg_upload);
        if(res.code == 200)
        {
          layMsgOk(res.msg);
          tab.reload();
        }else
        {
          layMsgError(res.msg);
        }
      }
    });
    upload.render({
      elem: '#effect_image'
      ,url: '{{ url("/engineering/project/huxing-upload") }}'
      ,method : 'post'
      ,field:'effect_image'
      ,accept: 'image' //普通文件
      ,exts :'jpg|png|jpeg'
      ,done: function(res){
        layer.close(effect_image);
        if(res.code == 200)
        {
          layMsgOk(res.msg);
          tab.reload();
        }else
        {
          layMsgError(res.msg);
        }
      }
    });
  });

  </script>
@endsection

