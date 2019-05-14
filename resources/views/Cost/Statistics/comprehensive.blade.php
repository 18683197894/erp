@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card edit" style="display:none">
  <div class="layui-card-body" style="padding: 15px">
    <form class="layui-form layui-form-pane" id="myform" lay-filter="edit">
      <input type="hidden" name="id" value="">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg12">
            <label class="layui-form-label">项目名称</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" disabled placeholder="" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div>
          <label class="layui-form-label" style="width: 100%;">预估</label>
      </div>
      <br>
      <br>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">材料成本</label>
            <div class="layui-input-block">
              <input name="material_price" value="" lay-verify="price" disabled placeholder="请输入材料成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">人工成本</label>
            <div class="layui-input-block">
              <input name="artificial_price" value="" lay-verify="price" disabled placeholder="请输入人工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">管理费用</label>
            <div class="layui-input-block">
              <input name="manage_price" value="" lay-verify="price" placeholder="请输入管理费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">其他费用</label>
            <div class="layui-input-block">
              <input name="other_price" value="" lay-verify="price" placeholder="请输入其他费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div>
          <label class="layui-form-label" style="width: 100%;">已用</label>
      </div>
      <br>
      <br>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">材料成本</label>
            <div class="layui-input-block">
              <input name="material_price_re" value="" lay-verify="price" placeholder="请输入材料成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">人工成本</label>
            <div class="layui-input-block">
              <input name="artificial_price_re" value="" lay-verify="price" placeholder="请输入人工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">管理费用</label>
            <div class="layui-input-block">
              <input name="manage_price_re" value="" lay-verify="price" placeholder="请输入管理费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">其他费用</label>
            <div class="layui-input-block">
              <input name="other_price_re" value="" lay-verify="price" placeholder="请输入其他费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
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
  <script type="text/html" id="operation">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  </script>
</div>
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/cost/comprehensive'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '综合成控'
      ,cols: [[
         {field:'id',fixed: 'left', title:'序号',unresize:true,width:80,rowspan:2}
        ,{field:'name', title:'项目名称',unresize:true,width:140,rowspan:2}
        ,{title:'预估',unresize:true,align:'center',colspan: 5}
        ,{title:'已用',unresize:true,align:'center',colspan: 5}
        ,{field:'difference', title:'合计差值',unresize:true,width:120,rowspan:2}
        ,{fixed: 'right',title:'操作',unresize:true,width:80,toolbar:'#operation',rowspan:2}
      ],[
         {field:'material_price', title:'材料成本',unresize:true}
        ,{field:'artificial_price', title:'人工成本',unresize:true}
        ,{field:'manage_price', title:'管理费用',unresize:true}
        ,{field:'other_price', title:'其他费用',unresize:true}
        ,{field:'total', title:'合计',unresize:true}
        ,{field:'material_price_re', title:'材料成本',unresize:true}
        ,{field:'artificial_price_re', title:'人工成本',unresize:true}
        ,{field:'manage_price_re', title:'管理费用',unresize:true}
        ,{field:'other_price_re', title:'其他费用',unresize:true}
        ,{field:'total_re', title:'合计',unresize:true}
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
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'edit'){
          var width = ($(window).width() * 0.7)+'px';
          var height = ($(window).height() * 0.7)+'px';
          form.val('edit',{
            'id':data.id,
            'name':data.name,
            'material_price':data.material_price,
            'artificial_price':data.artificial_price,
            'manage_price':data.manage_price,
            'other_price':data.other_price,
            'material_price_re':data.material_price_re,
            'artificial_price_re':data.artificial_price_re,
            'manage_price_re':data.manage_price_re,
            'other_price_re':data.other_price_re
          })
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
      }else if(obj.event === 'plan')
      {   
        
      }

    });
    form.on('submit(edit)',function(data)
    {
      data = data.field;
      data._token = token;
      $.ajax('/cost/comprehensive-edit',{
        data : data,
        type : 'post',
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk(res.msg);
            tab.reload()
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(data)
        {
          layMsgError('编辑失败');
        }
      });
      return false;
    });
    form.verify({
      'price' : function(value)
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
        if(value)
        {
          s = /^[1-9]\d{0,4}$/;
          if(!s.test(value))
          {
            return '请输入整数 (MIN:1 MAX:5)';
          }
        }
      }
    })
  });
  </script>
@endsection