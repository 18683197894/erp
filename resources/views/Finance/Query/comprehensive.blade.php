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
      ,url: '/finance/query/comprehensive'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '综合成控'
      ,cols: [[
         {field:'id',fixed: 'left', title:'序号',unresize:true,width:'6%',rowspan:2}
        ,{field:'name', title:'项目名称',unresize:true,width:'10%',rowspan:2}
        ,{title:'收入',unresize:true,align:'center',colspan: 3}
        ,{title:'支出',unresize:true,align:'center',colspan: 4}
        ,{fixed: 'right',field:'price_surplus',title:'项目剩余费用',unresize:true,width:'10%',rowspan:2}
      ],[
         {field:'total_should', title:'总应收',unresize:true,rowspan:2}
        ,{field:'total_money', title:'总实收',unresize:true,rowspan:2}
        ,{field:'income_difference', title:'收入差额',unresize:true,rowspan:2}
        ,{field:'material_price', title:'材料费用',unresize:true}
        ,{field:'artificial_price', title:'人工费用',unresize:true}
        ,{field:'other_price', title:'其他费用',unresize:true}
        ,{field:'total_zhichu', title:'支出总费用',unresize:true}
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

      }else if(obj.event === 'plan')
      {   
        
      }

    });

  });
  </script>
@endsection