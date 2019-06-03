@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card add" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" id="myform" lay-filter="component-form-group">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">项目总收入</label>
            <div class="layui-input-block">
              <input name="price_project" value="{{ $price_project }}" disabled lay-verify="required" placeholder="请输入项目总收入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">部门提成比例</label>
            <div class="layui-input-block">
              <input name="royalty" value="" lay-verify="required" placeholder="请输入部门提成比例" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">提成金额</label>
            <div class="layui-input-block">
              <input name="royalty_price" value="" lay-verify="required|price" placeholder="请输入提成金额" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">平均月提成</label>
            <div class="layui-input-block">
              <input name="royalty_month" value="" lay-verify="required|price" placeholder="请输入平均月提成" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">已发费用</label>
            <div class="layui-input-block">
              <input name="already_price" value="" lay-verify="required|price" placeholder="请输入已发费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
          </div>
        </div>
      </div> 
      <input class="reset" type="reset" name="" value="重置" style="display:none">
    </form>
  </div>
</div>
<div class="layui-card edit" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="edit">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">项目总收入</label>
            <div class="layui-input-block">
              <input name="price_project" value="" disabled lay-verify="required" placeholder="请输入项目总收入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">部门提成比例</label>
            <div class="layui-input-block">
              <input name="royalty" value="" lay-verify="required" placeholder="请输入部门提成比例" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">提成金额</label>
            <div class="layui-input-block">
              <input name="royalty_price" value="" lay-verify="required|price" placeholder="请输入提成金额" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">平均月提成</label>
            <div class="layui-input-block">
              <input name="royalty_month" value="" lay-verify="required|price" placeholder="请输入平均月提成" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">已发费用</label>
            <div class="layui-input-block">
              <input name="already_price" value="" lay-verify="required|price" placeholder="请输入已发费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
          </div>
        </div>
      </div> 
      <input class="reset" type="reset" name="" value="重置" style="display:none">
    </form>
  </div>
</div>
@endsection

@section('content')

<div class="layui-card-body">
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-toolbarDemo">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增','.add',0.5,0.55)">新增</button>
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
  }).use(['index', 'table','upload','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    ,laydate = layui.laydate
    ,token = $("meta[name='csrf-token']").attr('content')
    ,department_id = '{{ $department->id }}'
    ,project_id = '{{ $project->id }}'

      tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/finance/project/income'
      ,where:{_token:token,department_id:department_id,project_id:project_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料管理'
      ,cols: [[
         {field:'id',fixed: 'left',title:'序号',unresize:true,width:'6%'}
        ,{field:'department_name',title:'部门',unresize:true}
        ,{field:'price_project',title:'项目总收入',unresize:true}
        ,{field:'royalty', title:'部门提成比例',unresize:true}
        ,{field:'royalty_price', title:'提成金额',unresize:true}
        ,{field:'royalty_month', title:'平均月提成',unresize:true}
        ,{field:'already_price', title:'已发费用',unresize:true}
        ,{field:'created_at', title:'创建时间',unresize:true}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:'9%'}
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
        case 'getCheckData':
          var data = checkStatus.data;
          // layer.alert(JSON.stringify(data));
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'edit')
      { 
          form.val('edit', {
            'id' : data.id,
            'price_project' : data.price_project,
            'royalty' : data.royalty,
            'royalty_price' : data.royalty_price,
            'royalty_month' : data.royalty_month,
            'already_price' : data.already_price,
            'already_price' : data.already_price,
            
          }); 
          var width = ($(window).width() * 0.5)+'px';
          var height = ($(window).height() * 0.55)+'px';
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
      }else if(obj.event === 'del')
      {
        layer.confirm('确定删除当前数据吗', function(index){
        $.ajax({
          url:'{{ url("/finance/project/income-del") }}',
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
      }
    });
    form.on('submit(edit)',function(data){
       data = data.field
      ,data._token = token
      $.ajax({
        url : '{{ url("/finance/project/price-edit") }}',
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
    form.on('submit(add)',function(data){
       data = data.field
      ,data._token = token
      ,data.project_id = project_id
      ,data.department_id = department_id
      $.ajax({
        url : '{{ url("/finance/project/income-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
            tab.config.page.curr = 1;
            tab.reload({
              where : {_token:token,department_id:department_id,project_id:project_id},
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

