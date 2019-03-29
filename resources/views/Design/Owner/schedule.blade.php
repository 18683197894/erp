@extends('public')

@section('css')
@endsection
@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="margin:15px;padding:0px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group"> 
          <div class="layui-form-item">
            <div class="layui-col-lg6">
              <label class="layui-form-label">时间</label>
              <div class="layui-input-block">
                <input type="text" name="time" lay-verify="required" class="layui-input" id="start">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">洽谈性质</label>
              <div class="layui-input-block">
                <input name="person" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">支付金额</label>
              <div class="layui-input-block">
                <input name="money" value="" lay-verify="total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">支付备注</label>
              <div class="layui-input-block">
                <input name="money_remarks" value="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">跟进结果</label>
            <div class="layui-input-block">
              <textarea name="result" lay-verify="required" placeholder="" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">跟进人</label>
            <div class="layui-input-block">
              <input name="username" lay-verify="required" placeholder="" class="layui-input"></input>
            </div>
          </div>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="add" lay-filter="add">立即提交</button>
              </div>
            </div>
          </div>
        </form>
      </div>
</div>
<div class="layui-card edit" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="edit"lay-filter="edit"> 
          <input type="hidden" name="id" value="">
          <div class="layui-form-item">
            <div class="layui-col-lg6">
              <label class="layui-form-label">时间</label>
              <div class="layui-input-block">
                <input type="text" name="time" lay-verify="required" class="layui-input" id="start2">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">洽谈性质</label>
              <div class="layui-input-block">
                <input name="person" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">支付金额</label>
              <div class="layui-input-block">
                <input name="money" value="" lay-verify="total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">支付备注</label>
              <div class="layui-input-block">
                <input name="money_remarks" value="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">跟进结果</label>
            <div class="layui-input-block">
              <textarea name="result" lay-verify="required" placeholder="" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">跟进人</label>
            <div class="layui-input-block">
              <input name="username" lay-verify="required" placeholder="" class="layui-input"></input>
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
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
<input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增','.add',0.5,0.75)">新增</button>
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
  }).use(['index', 'table','layedit','laydate','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,upload = layui.upload
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
       elem: '#test-table-toolbar'
      ,url: '/design/owner/schedule'
      ,where:{_token:token,user_id:$('#user_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '房屋跟进'
      ,cols: [[
        {field:'time',fixed:'left',title:'时间',unresize:true,width:140}
        ,{field:'person', title:'洽谈性质',unresize:true,width:140}
        ,{field:'money', title:'支付金额',unresize:true,width:140}
        ,{field:'money_remarks', title:'支付备注',unresize:true}
        ,{field:'result', title:'跟进结果',unresize:true,width:400}
        ,{field:'username',title:'跟进人',unresize:true,width:140}
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

    laydate.render({
      elem: '#start2' //指定元素
    });

    $('.demoTable .layui-btn').on('click',function(){
    	schedule_id = $('#schedule_id').val();
    	tab.reload({where:{schedule_id:schedule_id,_token:token,user_id:$('#user_id').val()},page:{curr:1}});
    });

    //选完文件后不自动上传
    upload.render({
      elem: '#test-upload-change'
      ,url: '/upload/'
      ,auto: false
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
        layer.confirm('确定删除: '+data.length+' 张图片吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/project/house/album-del") }}',
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
        layer.confirm('确定删除当前跟进信息吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/owner/schedule-del") }}',
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
            'time' : data.time,
            'person' : data.person,
            'money' : data.money,
            'money_remarks' : data.money_remarks,
            'result' : data.result,
            'username' : data.username
          }); 
    			var width = ($(window).width() * 0.5)+'px';
    			var height = ($(window).height() * 0.75)+'px';
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
      }
    });
    form.on('submit(add)',function(data){
      	data = data.field;
        data.user_id = $('#user_id').val();
        data._token=token;
        $.ajax({
          url : '{{ url("/design/owner/schedule-add") }}',
          type : 'post',
          data : data,
          success : function(res)
          { 
            var res = $.parseJSON(res);
            if(res.code == 200)
            {
              layer.close(opens);
              layMsgOk(res.msg);
              $('#name').val('');
              tab.reload({
                where : {_token:token,user_id:$('#user_id').val()},
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
        url : '{{ url("/design/owner/schedule-edit") }}',
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
    form.verify({
      'total' : function(value)
      {
        if(value)
        {
          s = /^\d{1,8}\.\d{1,2}$/;
          sS = /^\d{1,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:1 MAX:8 保留小数点2位)';
          }
        }
      }
    })
  });
  </script>
@endsection

