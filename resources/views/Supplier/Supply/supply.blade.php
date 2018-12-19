@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商编码</label>
              <div class="layui-input-inline">
                <input name="code" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商名称</label>
              <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">品牌</label>
              <div class="layui-input-inline">
                <input type="text" name="brand" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">子品牌</label>
              <div class="layui-input-inline">
                <input name="sonbrand" value="" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">经营范围</label>
              <div class="layui-input-inline">
                <input type="text" name="range" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">联系人</label>
              <div class="layui-input-inline">
                <input type="text" name="contacts" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">电话</label>
              <div class="layui-input-inline">
                <input name="phone" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">合同开始时间</label>
              <div class="layui-input-inline">
                <input type="text" name="start" lay-verify="" id="start" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">合同结束时间</label>
              <div class="layui-input-inline">
                <input type="text" name="end" lay-verify="" id="end" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
               <input name="address" lay-verify="required" placeholder="请输入" class="layui-input">
            </div>
          </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
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
        <input type="hidden" name="id" value="id">
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商编码</label>
              <div class="layui-input-inline">
                <input name="code" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商名称</label>
              <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">品牌</label>
              <div class="layui-input-inline">
                <input type="text" name="brand" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">子品牌</label>
              <div class="layui-input-inline">
                <input name="sonbrand" value="" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">经营范围</label>
              <div class="layui-input-inline">
                <input type="text" name="range" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">联系人</label>
              <div class="layui-input-inline">
                <input type="text" name="contacts" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">电话</label>
              <div class="layui-input-inline">
                <input name="phone" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">合同开始时间</label>
              <div class="layui-input-inline">
                <input type="text" name="start" lay-verify="" id="start2" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">合同结束时间</label>
              <div class="layui-input-inline">
                <input type="text" name="end" lay-verify="" id="end2" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
              <input name="address" lay-verify="required" placeholder="请输入" class="layui-input">
            </div>
          </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
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
		<input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="供应商搜索" autocomplete="off">
        <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
        <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<a class="layui-btn">搜索</a>
	</form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增品类','.add',0.8,0.9)">新增品类</button>
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
      ,url: '/supplier/supply'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '供应商'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'code', title:'供应商编码',fixed: 'left',unresize:true}
        ,{field:'name', title:'供应商名称',unresize:true}
        ,{field:'brand', title:'品牌',unresize:true}
        ,{field:'sonbrand', title:'子品牌',unresize:true}
        ,{field:'range', title:'经营范围',unresize:true}
        ,{field:'contacts', title:'联系人',unresize:true}
        ,{field:'phone', title:'电话',unresize:true}
        ,{field:'start', title:'合同开始时间',unresize:true}
        ,{field:'end', title:'合同结束时间',unresize:true}
        ,{field:'address', title:'地址',unresize:true}
        ,{field:'remarks', title:'备注',unresize:true}
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
      $('#name').attr('val',name);
    	tab.reload({where:{name:name,_token:token},page:{curr:1}});
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          
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
        layer.confirm('确定删除供应商: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/supplier/supply-del") }}',
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
            'code' : data.code,
            'brand' : data.brand,
            'sonbrand' : data.sonbrand,
            'range' : data.range,
            'contacts' : data.contacts,
            'phone' : data.phone,
            'range' : data.range,
            'start' : data.start,
            'end' : data.end,
            'address' : data.address,
            'remarks' : data.remarks
          }); 
          var width = ($(window).width() * 0.8)+'px';
          var height = ($(window).height() * 0.9)+'px';
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
      data._token = token;

      $.ajax({
        url : '{{ url("/supplier/supply-add") }}',
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
        url : '{{ url("/supplier/supply-edit") }}',
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