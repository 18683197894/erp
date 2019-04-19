@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane" id="myform"lay-filter="component-form-group">
         <div class="layui-row layui-col-space10" >
          <div class="layui-col-lg6">
              <label class="layui-form-label">项目</label>
              <div class="layui-input-block">
                <select name="project_id" lay-verify="required">
                  <option value=""></option>
                  @foreach($project as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">采购时间</label>
              <div class="layui-input-block">
                 <input type="text" name="plan_time" lay-verify="required" id="plan_time1" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">材料编号</label>
              <div class="layui-input-block">
                <select name="material_id" lay-verify="required" lay-search>
                  <option value="">直接搜索或选择</option>
                  @foreach($material as $v)
                  <option value="{{ $v->id }}">{{ $v->code }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">数量</label>
              <div class="layui-input-block">
                <input name="num" value="" lay-verify="required|num" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
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
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane" id="myform"lay-filter="edit">
        <input type="hidden" name="id" value="">
         <div class="layui-row layui-col-space10" >
          <div class="layui-col-lg6">
              <label class="layui-form-label">项目</label>
              <div class="layui-input-block">
                <select name="project_id" lay-verify="required">
                  <option value=""></option>
                  @foreach($project as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">采购时间</label>
              <div class="layui-input-block">
                 <input type="text" name="plan_time" lay-verify="required" id="plan_time2" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">材料编号</label>
              <div class="layui-input-block">
                <select name="material_id" lay-verify="required" lay-search>
                  <option value="">直接搜索或选择</option>
                  @foreach($material as $v)
                  <option value="{{ $v->id }}">{{ $v->code }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">数量</label>
              <div class="layui-input-block">
                <input name="num" value="" lay-verify="required|num" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="edit" lay-filter="edit">立即提交</button>
              </div>
            </div>
          </div> 
        </form>
      </div>
</div>
<div class="layui-card order" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane" id="myform"lay-filter="order">
          <div class="layui-row layui-col-space10" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">序号</label>
              <div class="layui-input-block">
                <input type="text" name="id" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">项目</label>
              <div class="layui-input-block">
                <input type="text" name="project_name" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">采购时间</label>
              <div class="layui-input-block">
                <input type="text" name="plan_time" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">材料编号</label>
              <div class="layui-input-block">
                <input type="text" name="code" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">名称</label>
              <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">数量</label>
              <div class="layui-input-block">
                <input name="num" value="" lay-verify="required" placeholder="请输入" class="layui-input" disabled>
              </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">单价</label>
              <div class="layui-input-block">
                <input name="univalent" value="" lay-verify="required" placeholder="请输入" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">合计</label>
              <div class="layui-input-block">
                <input type="text" name="total" lay-verify="required" class="layui-input" disabled>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">下单时间</label>
              <div class="layui-input-block">
                <input name="order_time" id="plan_time3" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">备注</label>
              <div class="layui-input-block">
                <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否推荐</label>
              <div class="layui-input-inline">
                <input type="checkbox" name="recommend"  lay-skin="switch" value="2"lay-text="推荐|不推荐">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否完成</label>
              <div class="layui-input-inline">
                <input type="checkbox" name="status"  lay-skin="switch" value="2" lay-text="完成|未完成">
              </div>
            </div>
          </div>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="order" lay-filter="order">立即提交</button>
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

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增计划','.add',0.45,0.5)">新增计划</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
	<script type="text/html" id="order">
	  <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="order" >进入</a>
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
      ,url: '/supplier/plan'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料品类'
      ,where:{name:$('#name').val(),_token:token,class:$('#class').val()}
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:120}
        ,{field:'project_name', title:'项目',unresize:true}
        ,{field:'plan_time', title:'采购时间',unresize:true}
        ,{field:'code', title:'材料编号',unresize:true}
        ,{field:'name', title:'名称',unresize:true}
        ,{field:'num', title:'数量',unresize:true,width:130}
        ,{field:'univalent', title:'单价',unresize:true,width:130}
        ,{field:'total', title:'合计',unresize:true,width:130}
        ,{toolbar:'#order', title:'下单',unresize:true,width:100}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',width:120}
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
    laydate.render({
      elem: '#plan_time1' //指定元素
    });
    laydate.render({
      elem: '#plan_time2' //指定元素
    });
    laydate.render({
      elem: '#plan_time3' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除该计划吗', function(index){
        	$.ajax({
          	url:'{{ url("/supplier/plan-del") }}',
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
      }else if(obj.event === 'edit')
      {   
          form.val('edit',{
            'project_id' : data.project_id,
            'plan_time' : data.plan_time,
            'material_id' : data.material_id,
            'num' : data.num,
            'order_time' : data.ordet_time,
            'remarks' : data.remarks,
            'id' : data.id
          })
          var width = ($(window).width() * 0.45)+'px';
          var height = ($(window).height() * 0.5)+'px';
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
      }else if(obj.event === 'order')
      {   
          form.val('order',{
            'project_name' : data.project_name,
            'plan_time' : data.plan_time,
            'code' : data.code,
            'num' : data.num,
            'name' : data.name,
            'univalent' : data.univalent,
            'total' :  parseFloat(data.univalent * data.num).toFixed(2),
            'recommend' : data.recommend == 2 ?1 :0,
            'status' : data.status == 2 ?1 :0,
            'remarks' : data.remarks,
            'order_time' : data.order_time,
            'id' : data.id
          })
          var width = ($(window).width() * 0.75)+'px';
          var height = ($(window).height() * 0.85)+'px';
            order = layer.open({
            type : 1,
            title : '采购下单',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.order')
          })
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      $.ajax({
        url : '{{ url("/supplier/plan-add") }}',
        type : 'post',
        data : {data:data,_token:token},        
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
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
      $.ajax({
        url : '{{ url("/supplier/plan-edit") }}',
        type : 'post',
        data : {data:data,_token:token},        
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
          layMsgError('新增失败');
        }
      })
      return false;
    })
    form.on('submit(order)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/supplier/plan-order") }}',
        type : 'post',
        data : data,        
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(order);
            layMsgOk(res.msg);
            tab.reload();
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
      'num' : function(value)
      {
        if(value)
        {
          s= /^\d{1,10}$/;
          if(!s.test(value))
          {
            return '请输入整数 (MIN:1 MAX:10)';
          }
        }
      }
    })
  });
  </script>
@endsection