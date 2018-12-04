@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item">
          <label class="layui-form-label">选择项目</label>
          <div class="layui-input-block">
            <select name="project_id" lay-filter="required" lay-search="" lay-verify="required">
              <option value="">直接选择或搜索选择</option>
              @foreach($project as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">入场时间</label>
            <div class="layui-input-block">
              <input type="text" name="admission_time" lay-verify="required" class="layui-input" id="time1">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">完成时间</label>
            <div class="layui-input-block">
              <input type="text" name="estimate_time" lay-verify="required" class="layui-input" id="time2">
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
          <input type="hidden" name="project_id" value="">
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
		<div class="layui-input-inline">
		  <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="项目名搜索" autocomplete="off">
      <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
      <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增项目','.add',0.4,0.6)">新增项目</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="house">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="house">进入</a>
  </script>
    <script type="text/html" id="huxing">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="huxing">进入</a>
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
      ,url: '/engineering/project'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '工程项目'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'name', title:'项目名称',fixed: 'left',unresize:true}
        ,{field:'re_address', title:'项目地址',unresize:true,width:300}
        ,{field:'fangshu', title:'房数',unresize:true}
        ,{field:'acreage', title:'总面积',unresize:true}
        ,{field:'admission_time', title:'入场时间',unresize:true}
        ,{field:'estimate_time', title:'预计完成时间',unresize:true}
        ,{title:'进度',unresize:true,toolbar:'#house'}
        ,{title:'户型',unresize:true,toolbar:'#huxing'}
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

    layui.code();
    var area1 = $("#area-select-box-1").JAreaSelect();
    var area2 = $("#area-select-box-2").JAreaSelect({prov: 0, city: 0, dist: 0});

    $('.demoTable .layui-btn').on('click',function(){
    	name = $('#name').val();
      $('#name').attr('val',name);
    	tab.reload({where:{name:name,_token:token},page:{curr:1}});
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
      elem: '#time1' //指定元素
    });
    laydate.render({
      elem: '#time2' //指定元素
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
      } else if(obj.event === 'edit'){
		      $('.edit').find("input[name='admission_time']").val(data.admission_time);
		      $('.edit').find("input[name='estimate_time']").val(data.estimate_time);
          $('.edit').find("input[name='project_id']").val(data.id);
            var width = ($(window).width() * 0.4)+'px';
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
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/engineering/project-add") }}',
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