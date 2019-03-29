@extends('public')

@section('css')
<style type="text/css">

</style>
@endsection
@section('open')
<div class="layui-card add" style="display:none">
    <form class="layui-form layui-form-pane" id="myform"  style="margin: 15px;" lay-filter="add">
      <input type="hidden" name="material_id" value="">
      <div class="layui-form-item" >
        <label class="layui-form-label">材料编码</label>
        <div class="layui-input-block">
          <input name="code" value="" lay-verify="code" readonly="readonly" placeholder="" autocomplete="off" class="layui-input" type="text">
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-col-lg6">
          <label class="layui-form-label">位置</label>
          <div class="layui-input-block">
            <input name="position" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
        <div class="layui-col-lg6">
          <label class="layui-form-label">数量</label>
          <div class="layui-input-block">
            <input name="num" value="" lay-verify="required|num" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-col-lg6">
          <label class="layui-form-label">其他费用</label>
          <div class="layui-input-block">
            <input name="other_price" value="" lay-verify="other_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>
        <div class="layui-col-lg6">
          <label class="layui-form-label">费用说明</label>
          <div class="layui-input-block">
            <input name="other_explain" value="" lay-verify="other_explain" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
          </div>
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
          <div class="layui-footer">
            <button class="layui-btn" style="margin-top: 10px;" lay-submit="" lay-filter="add">立即提交</button>
          </div>
        </div>
      </div> 
    
  </form>
</div>
@endsection

@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form">
      <div class="layui-input-inline">
          <select name="class_id" id="class_id" lay-filter="required" lay-verify="required">
            <option value="">选择类别</option>
            <option value="主材">主材</option>
            <option value="辅材">辅材</option>
            <option value="家电">家电</option>
            <option value="家居">家居</option>
          </select>
      </div>
      <div class="layui-input-inline">
          <select name="category_id" id="category_id" lay-filter="required" lay-verify="required">
            <option value="">选择品类</option>
            @foreach($categroy as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
      </div>
      <div class="layui-input-inline">
        <input class="layui-input" name="code" value=""  id="code" placeholder="编号搜索" autocomplete="off">
      </div>
        <a class="layui-btn">搜索</a>
      <input type="hidden" name="house_id" id="house_id" value="{{ $house->id }}">
    </form>

	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="add">选取</a>
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
    ,table = layui.table
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/material/list-selection'
      ,where:{_token:token,house_id:$('#house_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料'
      ,cols: [[
         {field:'category_name',fixed: 'left',  title:'品类',unresize:true,width:120}
        ,{field:'class_name',title:'类别',unresize:true,width:120}
        ,{field:'code', title:'编码',unresize:true,width:120}
        ,{field:'brand', title:'品牌',unresize:true,width:120}
        ,{field:'model', title:'型号',unresize:true,width:120}
        ,{field:'spec', title:'规格',unresize:true,width:120}
        ,{field:'color', title:'颜色',unresize:true,width:120}
        ,{field:'metering', title:'计量单位',unresize:true,width:120}
        ,{field:'parts_num', title:'配件套数',unresize:true,width:120}
        ,{field:'place', title:'产地',unresize:true,width:120}
        ,{field:'sale_price', title:'标准价',unresize:true,width:120}
        ,{field:'promotion_price', title:'促销价',unresize:true,width:120}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:80}
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
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'add':
          
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    $('.demoTable .layui-btn').on('click',function(){
      var code = $('#code').val();      
      var category_id = $('#category_id').val();
      var class_id = $('#class_id').val();
      tab.reload({where:{code:code,class_id:class_id,category_id:category_id,_token:token},page:{curr:1}});
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'add'){
          form.val('add',{
            'material_id':data.id,
            'code':data.code,
            'num':1,
            'other_price':'',
            'other_explain':'',
            'remarks':'',
            'position':''
          });
          var width = ($(window).width() *  0.6)+'px';
          var height = ($(window).height() * 0.8)+'px';
            add = layer.open({
            type: 1,
            title: '确认材料',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4, //开启最大化最小化按钮
            area: [width, height],
            content: $('.add')
            });     
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      data.house_id = $("#house_id").val();
      $.ajax({
        url : '{{ url("/design/material/list-selection-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(add);
            layMsgOk(res.msg);
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('选取失败');
        }
      });
      return false;
    });
    form.verify({
      'other_price' : function(value)
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
      },
      'num':function(value)
      {
        s = /^[1-9][0-9]*[0-9]*$/;
        if(!s.test(value))
        {
          return '请输入整数 (MIN:1 MAX:3)';
        }
      }
    })
  });

  </script>
@endsection

