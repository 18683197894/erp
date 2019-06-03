@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card edit" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="edit">
      <input type="hidden" name="id">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">预算费用</label>
            <div class="layui-input-block">
              <input name="price_budget" value="" lay-verify="required|price" placeholder="请输入预算费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">施工阶段</label>
            <div class="layui-input-block">
              <input name="construction_stage" value="" lay-verify="" placeholder="请输入施工阶段" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item layui-form-text" >
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
          <textarea name="finance_remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
        </div>
      </div>
        <br>
      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="edit" lay-filter="edit">立即提交</button>
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
      ,url: '/finance/query/budget'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '综合成控'
      ,cols: [[
         {field:'id',fixed: 'left', title:'序号',unresize:true,width:'6%'}
        ,{field:'name', title:'项目名称',unresize:true}
        ,{field:'price_budget', title:'预算费用',unresize:true}
        ,{field:'construction_stage', title:'施工阶段',unresize:true}
        ,{field:'price_already', title:'已用费用',unresize:true}
        ,{field:'price_surplus', title:'剩余费用',unresize:true}
        ,{field:'finance_remarks',title:'备注',unresize:true,width:'20%'}
        ,{fixed: 'right', title:'操作', toolbar: '#operation',unresize:true,width:'8%'}
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
        form.val('edit', {
            'id' : data.id,
            "price_budget" : data.price_budget,
            "construction_stage" : data.construction_stage,
            "finance_remarks" : data.finance_remarks
          }); 
          var width = ($(window).width() * 0.5)+'px';
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
      }
    });
    form.on('submit(edit)',function(data){
       data = data.field
      ,data._token = token
      $.ajax({
        url : '{{ url("/finance/query/budget-edit") }}',
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
          layMsgError('新增失败');
        }
      })
      return false;
    })
    form.verify({
      price : function(value)
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
      }
    });
  });
  </script>
@endsection