@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item" >
            <label class="layui-form-label">房号</label>
            <div class="layui-input-block">
              <input name="room_number" value="" lay-verify="required" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">楼层</label>
            <div class="layui-input-block">
              <select name="floor" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">楼栋</label>
            <div class="layui-input-block">
              <select name="building" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">单元</label>
            <div class="layui-input-block">
              <select name="unit">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">户型</label>
            <div class="layui-input-block">
              <select name="huxing_id">
                <option value="">请选择</option>
                @foreach($huxing as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">面积</label>
            <div class="layui-input-block">
              <input name="acreage" value="" lay-verify="acreage" placeholder="请输入面积" autocomplete="off" class="layui-input" type="text">
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
          <div class="layui-form-item" >
            <label class="layui-form-label">房号</label>
            <div class="layui-input-block">
              <input name="room_number" value="" lay-verify="required" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item floor">
            <label class="layui-form-label">楼层</label>
            <div class="layui-input-block">
              <select name="floor" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item building">
            <label class="layui-form-label">楼栋</label>
            <div class="layui-input-block">
              <select name="building" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item unit">
            <label class="layui-form-label">单元</label>
            <div class="layui-input-block">
              <select name="unit">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item huxing_id">
            <label class="layui-form-label">户型</label>
            <div class="layui-input-block">
              <select name="huxing_id">
                <option value="">请选择</option>
                @foreach($huxing as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">面积</label>
            <div class="layui-input-block">
              <input name="acreage" value="" lay-verify="acreage" placeholder="请输入面积" autocomplete="off" class="layui-input" type="text">
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
      <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">
		  <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="项目名搜索" autocomplete="off">
      <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
      <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增房号','.add',0.6,0.8)">新增房号</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="schedule">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="schedule">进度更新</a>
  </script>
  <script type="text/html" id="album">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="album">查看相册</a>
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
  }).use(['index', 'table','form','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/project/house'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '工程项目'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'room_number', title:'房号',fixed: 'left',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{field:'huxing_name', title:'户型',unresize:true}
        ,{field:'acreage', title:'总面积',unresize:true}
        ,{field:'schedule_name', title:'当前进度',unresize:true,width:230}
        ,{title:'进度更新',unresize:true,toolbar: '#schedule'}
        ,{title:'相册',unresize:true,toolbar: '#album'}
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
        layer.confirm('确定删除房号: '+data.room_number+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/project/house-del") }}',
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
          $('.edit').find("input[name='room_number']").val(data.room_number);
          $('.edit').find("input[name='acreage']").val(data.acreage);
          $('.edit').find("input[name='id']").val(data.id);
          $('.edit').find('.floor').find("dd[lay-value='"+data.floor+"']").click();
          $('.edit').find('.building').find("dd[lay-value='"+data.building+"']").click();
          $('.edit').find('.unit').find("dd[lay-value='"+data.unit+"']").click();
          $('.edit').find('.huxing_id').find("dd[lay-value='"+data.huxing_id+"']").click();
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.8)+'px';
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
      }else if(obj.event === 'schedule')
      {   
        var width = ($(window).width() * 1)+'px';
        var height = ($(window).height() * 1)+'px';
        var schedule = layer.open({
          type: 2,
          title: '房号: '+data.room_number,
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: [width, height],
          content: '{{ url("engineering/project/house/schedule") }}?house_id='+data.id,
          end:function(){
            tab.reload();
          }
        });
      }else if(obj.event === 'album')
      {   
        var width = ($(window).width() * 1)+'px';
        var height = ($(window).height() * 1)+'px';
        var album = layer.open({
          type: 2,
          title: '房号: '+data.room_number,
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: [width, height],
          content: '{{ url("engineering/project/house/album") }}?house_id='+data.id,
          end:function(){
            // tab.reload();
          }
        });
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      if(data.province == '0' || data.city == '0' || data.dist == '0')
      {
        layMsgError('请选择地址');
        return false;
      }
      data.re_address = area1.getAreaString()+data.address;

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
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      data.project_id = $('#project_id').val();
      $.ajax({
        url : '{{ url("/engineering/project/house-add") }}',
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
        url : '{{ url("/engineering/project/house-edit") }}',
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
      'room_number' : function(value)
      {
        if(value.length >= 10)
        {
          return '字数超出限制 (MAX:10)';
        }
      },
      
      'acreage' : function(value)
      {
        s = /^\d{1,3}\.\d{1,2}$/;
        sS = /^\d{1,3}$/;
        if(!s.test(value) && !sS.test(value))
        {
          return '请输入整数 (MAX:3 保留小数点2位)';
        }
      }
    })
  });
  </script>
@endsection