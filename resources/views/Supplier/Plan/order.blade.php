@extends('public')

@section('css')

@endsection

@section('open')
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
  <div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form">
      <div class="layui-input-inline">
       <select name="status" id="status" lay-verify="required">
          <option value=""></option>
          <option value="2">完成</option>
          <option value="1">未完成</option>
       </select>
      </div>
      <div class="layui-input-inline">
          <input class="layui-input" name="code" value="" id="code" placeholder="编码搜索" autocomplete="off">
      </div>
      <a class="layui-btn">搜索</a>
    </form>
  </div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
	<script type="text/html" id="order">
	  <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="order">进入</a>
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
      ,url: '/supplier/order'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料品类'
      ,where:{name:$('#name').val(),_token:token,class:$('#class').val()}
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:120}
        ,{field:'project_name', title:'项目',unresize:true,width:130}
        ,{field:'code', title:'材料编号',unresize:true,width:130}
        ,{field:'plan_time', title:'采购时间',unresize:true,width:130}
        ,{field:'order_time', title:'下单时间',unresize:true,width:130}
        ,{field:'remarks', title:'备注',unresize:true}
        ,{field:'is_recommend', title:'是否推荐',unresize:true,width:120}
        ,{field:'is_status', title:'是否完成',unresize:true,width:120}
        ,{fixed: 'right',toolbar:'#order', title:'操作',width:100}
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
      elem: '#plan_time3' //指定元素
    });

    $('.demoTable .layui-btn').on('click',function(){
      var code = $('#code').val();
      var status = $('#status').val();
      $('#code').attr('val',code);
      tab.reload({where:{code:code,_token:token,status:status},page:{curr:1}});
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        
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