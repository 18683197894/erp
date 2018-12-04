@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card add" style="display:none">
    <form class="layui-form layui-form-pane" style="margin: 15px;" id="myform"lay-filter="component-form-group">
      <div class="layui-col-md6">
          <div class="layui-form-item" >
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>

          <div class="layui-form-item" >
            <label class="layui-form-label">职务</label>
            <div class="layui-input-block">
              <input name="post" value="" lay-verify="required" placeholder="请输入职务" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">电话</label>
            <div class="layui-input-block">
              <input name="phone" value="" lay-verify="required" placeholder="请输入电话" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">喜好</label>
            <div class="layui-input-block">
              <textarea cols="30" rows="2" name="like" placeholder="请输入喜好" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">重要信息</label>
            <div class="layui-input-block">
              <textarea name="important_information" placeholder="请输入重要信息" class="layui-textarea"></textarea>
            </div>
          </div>
      </div>
      <div class="layui-col-md6" style="padding-left: 15px;">
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">侧要信息</label>
            <div class="layui-input-block">
              <textarea name="side_information" placeholder="请输入侧要信息" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
            </div>
          </div>
      </div>
      <div class="layui-col-md12">
          <div class="layui-form-item ">
            <div class="layui-input-block">
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
              </div>
            </div>
          </div> 
      </div>
    </form>
</div>
<div class="layui-card edit" style="display:none">
    <form class="layui-form layui-form-pane" style="margin: 15px;" id="edit" lay-filter="component-form-group">
      <div class="layui-col-md6">
        <div class="layui-form-item" >
          <label class="layui-form-label">姓名</label>
          <div class="layui-input-block">
            <input name="name" value="" lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
        <input type="hidden" name="id" value="">
        <div class="layui-form-item" >
          <label class="layui-form-label">职务</label>
          <div class="layui-input-block">
            <input name="post" value="" lay-verify="required" placeholder="请输入职务" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
        <div class="layui-form-item" >
          <label class="layui-form-label">电话</label>
          <div class="layui-input-block">
            <input name="phone" value="" lay-verify="required" placeholder="请输入电话" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
        <div class="layui-form-item layui-form-text" >
          <label class="layui-form-label">喜好</label>
          <div class="layui-input-block">
            <textarea cols="30" rows="2" name="like" placeholder="请输入喜好" class="layui-textarea"></textarea>
          </div>
        </div>
        <div class="layui-form-item layui-form-text" >
          <label class="layui-form-label">重要信息</label>
          <div class="layui-input-block">
            <textarea name="important_information" placeholder="请输入重要信息" class="layui-textarea"></textarea>
          </div>
        </div>
      </div>
      <div class="layui-col-md6" style="padding-left: 15px">
        <div class="layui-form-item layui-form-text" >
          <label class="layui-form-label">侧要信息</label>
          <div class="layui-input-block">
            <textarea name="side_information" placeholder="请输入侧要信息" class="layui-textarea"></textarea>
          </div>
        </div>
        <div class="layui-form-item layui-form-text" >
          <label class="layui-form-label">备注</label>
          <div class="layui-input-block">
            <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
          </div>
        </div>
      </div>
      <div class="layui-col-md12">
        <div class="layui-form-item ">
          <div class="layui-input-block">
            <div class="layui-footer">
              <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
            </div>
          </div>
        </div>
      </div> 
    </form>
</div>
@endsection

@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
			<input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
			<input class="layui-input" name="name" id="name" placeholder="姓名搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增联系人','.add',0.8,0.9)">新增联系人</button>
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
    ,form = layui.form
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/developer/project/contacts'
      ,where:{_token:token,project_id:$('#project_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '项目联系人'
      ,cols: [[
         {type: 'checkbox', fixed: 'left'}
        ,{field:'name', title:'姓名',unresize:true,width:110}
        ,{field:'post', title:'职务',unresize:false,width:110}
        ,{field:'phone', title:'电话',unresize:true,width:110}
        ,{field:'like', title:'喜好',unresize:true}
        ,{field:'important_information', title:'重要信息',unresize:true}
        ,{field:'side_information', title:'侧要信息',unresize:true,}
        ,{field:'remarks', title:'备注',unresize:true}
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
        layer.confirm('确定删除联系人: '+name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/contacts-del") }}',
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
        layer.confirm('确定删除联系人: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/contacts-del") }}',
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
			$('.edit').find("input[name='name']").val(data.name);
			$('.edit').find("input[name='post']").val(data.post);
			$('.edit').find("input[name='phone']").val(data.phone);
			$('.edit').find("textarea[name='like']").val(data.like);
			$('.edit').find("textarea[name='important_information']").val(data.important_information);
			$('.edit').find("textarea[name='side_information']").val(data.side_information);
			$('.edit').find("textarea[name='remarks']").val(data.remarks);
			$('.edit').find("input[name='id']").val(data.id);
			var width = ($(window).width() * 0.8)+'px';
			var height = ($(window).height() * 0.9)+'px';
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
        url : '{{ url("/developer/project/contacts-add") }}',
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
        url : '{{ url("/developer/project/contacts-edit") }}',
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

