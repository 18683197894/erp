@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item" >
            <label class="layui-form-label">开发商名称</label>
            <div class="layui-input-block">
              <input name="company_name" value="" lay-verify="required" placeholder="请输入公司名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">开发商地址</label>
            <div class="layui-input-block">
              <textarea name="company_address" lay-verify="required" placeholder="请输入公司地址" class="layui-textarea"></textarea>
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
        <form class="layui-form" lay-filter="component-form-group">
        	<input type="hidden" name="id" value="id">
          <div class="layui-form-item" >
            <label class="layui-form-label">开发商名称</label>
            <div class="layui-input-block">
              <input name="company_name" value="" lay-verify="required" placeholder="请输入公司名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">开发商地址</label>
            <div class="layui-input-block">
              <textarea name="company_address" lay-verify="required" placeholder="请输入公司地址" class="layui-textarea"></textarea>
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
		  <input class="layui-input" name="name" value="{{ isset($request['company_name'])?$request['company_name']:'' }}" val="{{ isset($request['company_name'])?$request['company_name']:'' }}" id="name" placeholder="公司名搜索" autocomplete="off">
      <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
      <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<button class="layui-btn" style="margin-left: 5px;">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('录入','.add',0.5,0.6)">录入开发商</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="contacts">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="check">进入</a>
  </script>
  <script type="text/html" id="information">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="information">进入</a>
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
      ,url: '/commerce/company'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '开发商'
      ,where:{company_name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'company_name', title:'开发商公司名称',fixed: 'left',unresize:true}
        ,{field:'company_address', title:'开发商公司地址',unresize:false,width:500}
        ,{field:'created_at', title:'信息录入时间',unresize:true}
        ,{title:'核心联系人', toolbar:'#contacts',unresize:true}
        ,{title:'核心信息', toolbar:'#information',unresize:true}
        ,{fixed:'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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
    	name = $('#name').val();
      $('#name').attr('val',name);
    	tab.reload({where:{company_name:name,_token:token},page:{curr:1}});
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
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除开发商: '+data.company_name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/company-del") }}',
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
		  $('.edit').find("input[name='company_name']").val(data.company_name);
          $('.edit').find("textarea[name='company_address']").val(data.company_address);
          $('.edit').find("input[name='id']").val(data.id);
          var width = ($(window).width() * 0.5)+'px';
          var height = ($(window).height() * 0.6)+'px';
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
      }else if(obj.event === 'check')
      {   
        layui.full(openMax('项目联系人','/developer/contacts?company_id='+data.id));

        // var name = $('#name').attr('val');
        // var page = tab.config.page.curr;
        // var limit = tab.config.page.limit;
        // window.location.href="/developer/contacts?company_id="+data.id+"&company_name="+name+"&page="+page+"&limit="+limit;
      }else if(obj.event === 'information')
      {
        layui.full(openMax('核心信息','/developer/information?company_id='+data.id));
        // var name = $('#name').attr('val');
        // var page = tab.config.page.curr;
        // var limit = tab.config.page.limit;
        // window.location.href="/developer/information?company_id="+data.id+"&company_name="+name+"&page="+page+"&limit="+limit;
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/developer/company-add") }}',
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
          layMsgError('录入失败');
        }
      })
      return false;
    })
    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/developer/company-edit") }}',
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