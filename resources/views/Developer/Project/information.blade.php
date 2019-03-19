@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group"> 
          <div class="layui-form-item">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-inline">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="start">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-inline">
              <input type="text" name="title" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-inline">
              <textarea name="content" lay-verify="required" style="width: 400px; height: 150px;" autocomplete="off" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">标签</label>
            <div class="layui-input-inline">
              <input type="text" name="label" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
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
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="edit"lay-filter="component-form-group"> 
          <input type="hidden" name="id" value="">
          <div class="layui-form-item">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-inline">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="start">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-inline">
              <input type="text" name="title" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-inline">
              <textarea name="content" lay-verify="required" style="width: 400px; height: 150px;" autocomplete="off" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">标签</label>
            <div class="layui-input-inline">
              <input type="text" name="label" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
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
		<div class="layui-input-inline">
			<input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
			<input class="layui-input" name="name" id="name" placeholder="标题搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增信息','.add',0.5,0.8)">新增信息</button>
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
  }).use(['index', 'table','layedit','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/developer/project/information'
      ,where:{_token:token,project_id:$('#project_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '用户数据表'
      ,cols: [[
         {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'title', title:'标题',unresize:true}
        ,{field:'time', title:'时间',unresize:true}
        ,{field:'content', title:'内容',unresize:true,width:420}
        ,{field:'label', title:'标签',unresize:true}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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

    laydate.render({
      elem: '#start' //指定元素
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
          	name.push(n.title);
          	id.push(n.id);
          });
        layer.confirm('确定删除信息: '+name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/information-del") }}',
          	type : 'post',
          	data : {id:id,_token:token},
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
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除信息: '+data.title+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/information-del") }}',
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
    			$('.edit').find("input[name='title']").val(data.title);
    			$('.edit').find("input[name='time']").val(data.time);
    			$('.edit').find("input[name='label']").val(data.label);
          $('.edit').find('textarea[name="content"]').html(data.content);
    			$('.edit').find("input[name='id']").val(data.id);
    			var width = ($(window).width() * 0.5)+'px';
    			var height = ($(window).height() * 0.8)+'px';
    				edit = layer.open({
    			type : 1,
    			title : '编辑联系人',
    			fix: false, //不固定
    			maxmin: true,
    			shadeClose: true,
    			shade: 0.4,
    			area : [width,height],
    			content : $('.edit')
    			})
          }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      data.project_id = $('#project_id').val();
      $.ajax({
        url : '{{ url("/developer/project/information-add") }}',
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
            tab.reload({
              where : {_token:token,project_id:$('#project_id').val()},
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
        url : '{{ url("/developer/project/information-edit") }}',
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

