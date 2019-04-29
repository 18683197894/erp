@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
  <div class="layui-card-body" style="padding: 15px">
    <form class="layui-form layui-form-pane" id="myform"lay-filter="component-form-group">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">项目</label>
            <div class="layui-input-block">
              <select name="project_id" lay-verify="required">
                <option value="">请选择</option>
                @foreach($project as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">面积</label>
            <div class="layui-input-block">
              <input name="acreage" value="" lay-verify="acreage" placeholder="请输入面积" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">房号</label>
            <div class="layui-input-block">
              <input name="room_number" value="" lay-verify="required" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">楼层</label>
            <div class="layui-input-block">
              <select name="floor" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
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
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">楼栋</label>
            <div class="layui-input-block">
              <select name="building" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
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
            <div class="layui-col-lg6">
              <label class="layui-form-label">单元</label>
              <div class="layui-input-block">
                <select name="unit" lay-verify="required">
                  <option value="">请选择</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
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
        </div>
      </div>
<!--       <div class="layui-form-item">
        <label class="layui-form-label">绑定业主</label>
          <div class="layui-input-inline">
            <select name="house_id" lay-search="" lay-verify="">
              <option value="">直接选择或搜索选择</option>
              <option value="22">222</option>
              <option value="22">222</option>
            </select>
          </div>
      </div> -->

        <br>
      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
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
    <form class="layui-form ">
      <div class="layui-form-item">
        <div class="layui-input-inline">
          <select name="project_id" id="project_id" val="{{ isset($request['project_id'])?$request['project_id']:'' }}" lay-filter="required" lay-verify="required">
            <option value="">选择项目</option>
            @foreach($project as $c)
            <option value="{{ $c->id }}" @if(isset($request['project_id']) && $request['project_id'] == $c->id) selected @endif>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="layui-input-inline">
          <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="房号搜索" autocomplete="off">
          <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
          <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
        </div>
        <a class="layui-btn">搜索</a>
      </div>
    </form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增房屋','.add',0.6,0.65)">新增房屋</button>
	    <button class="layui-btn layui-btn-sm" onclick="openMax('户型管理','/desing/house/huxing')">户型管理</button>
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
  }).use(['index', 'table','form','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/house'
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '房屋信息'
      ,where:{_token:token}
      ,cols: [[
        {field:'project_name',title:'项目名称',fixed: 'left',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'room_number', title:'房号',unresize:true}
        ,{field:'huxing_name', title:'户型',unresize:true}
        ,{field:'acreage', title:'面积',unresize:true}
        ,{field:'user_name', title:'业主',unresize:true}
        ,{field:'user_phone', title:'联系方式',unresize:true}
        // ,{title:'装修需求',unresize:true, toolbar: '#demand'}
        // ,{title:'设计图纸',unresize:true, toolbar:'#drawing'}
        // ,{title:'材料清单',unresize:true, toolbar:'#material'}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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
      var project_id = $('#project_id').val();
      $('#project_id').attr('val',project_id);
    	tab.reload({where:{name:name,project_id:project_id,_token:token},page:{curr:1}});
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
        layer.confirm('确定删除房号: '+data.room_number+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/house-del") }}',
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
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.6)+'px';
          	edit = layer.open({
            type : 2,
            title : '编辑',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : '/design/house-edit?house_id='+data.id
            
          })
      }
    });
    editClose = function(msg)
    {
      layer.close(edit);
      layMsgOk(msg);
      tab.reload();
    }
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/design/house-add") }}',
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
        if(value)
        {
          s = /^\d{1,3}\.\d{1,2}$/;
          sS = /^\d{1,3}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MAX:3 保留小数点2位)';
          }
        }
      }
    })
  });
  </script>
@endsection