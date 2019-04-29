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
            <label class="layui-form-label">工序名称</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" placeholder="请输入工序名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-block">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="time_1">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">材料编号</label>
            <div class="layui-input-block">
              <select name="material_id" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($material as $v)
                <option value="{{ $v->id }}">{{ $v->code }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">数量</label>
            <div class="layui-input-block">
              <input name="num" value="" lay-verify="required|num" placeholder="请输入数量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">人工成本</label>
            <div class="layui-input-block">
              <input name="artificial_price" value="" lay-verify="price" placeholder="请输入人工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">其他费用</label>
            <div class="layui-input-block">
              <input name="other_price" value="" lay-verify="price" placeholder="请输入其他费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
        <br>
      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="add" lay-filter="add">立即提交</button>
          </div>
        </div>
      </div> 
    </form>
  </div>
</div>
<div class="layui-card edit" style="display:none">
  <div class="layui-card-body" style="padding: 15px">
    <form class="layui-form layui-form-pane" id="edit"lay-filter="edit">
      <input type="hidden" name="id" value="">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">工序名称</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" placeholder="请输入工序名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-block">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="time_2">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">材料编号</label>
            <div class="layui-input-block">
              <input name="code" value="" lay-verify="required" placeholder="请输入数量" autocomplete="off" class="layui-input" disabled type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">数量</label>
            <div class="layui-input-block">
              <input name="num" value="" lay-verify="required|num" placeholder="请输入数量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">人工成本</label>
            <div class="layui-input-block">
              <input name="artificial_price" value="" lay-verify="price" placeholder="请输入人工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">其他费用</label>
            <div class="layui-input-block">
              <input name="other_price" value="" lay-verify="price" placeholder="请输入其他费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
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
  <script type="text/html" id="test-table-toolbar-toolbarDemo">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增计划','.add',0.5,0.6
      )">新增计划</button>
    </div>
  </script>
  <script type="text/html" id="operation">
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
    house_id = {{ $house->id }};
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/construction/plan'
      ,where:{_token:token,house_id:house_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '施工计划'
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:80}
        ,{field:'time', title:'时间',unresize:true,width:120}
        ,{field:'name', title:'工序名称',unresize:true,width:140}
        ,{field:'code', title:'材料编号',unresize:true,width:120}
        ,{field:'material_name', title:'所需材料',unresize:true,width:120}
        ,{field:'num', title:'数量',unresize:true}
        ,{field:'total', title:'预计金额',unresize:true}
        ,{field:'artificial_price', title:'人工成本',unresize:true}
        ,{field:'other_price', title:'其他费用',unresize:true}
        ,{field:'count', title:'合计',unresize:true}
        ,{fixed: 'right',title:'操作',unresize:true,width:120,toolbar:'#operation'}
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
      elem: '#time_1', //指定元素
      elem: '#time_2' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除工序: '+data.name+' 吗', function(index){
          $.ajax({
            url:'{{ url("/engineering/construction/plan-del") }}',
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
          
          var width = ($(window).width() * 0.5)+'px';
          var height = ($(window).height() * 0.6)+'px';
          form.val('edit',{
            'id':data.id,
            'name':data.name,
            'time':data.time,
            'code':data.code,
            'num':data.num,
            'artificial_price':data.artificial_price,
            'other_price':data.other_price
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
        openMax('施工计划','/engineering/construction/plan?house_id='+data.id,function(){
          tab.reload();
        });
      }

    });

    form.on('submit(add)',function(data)
    {
      data = data.field;
      data._token = token;
      data.house_id = house_id;
      $.ajax('/engineering/construction/plan-add',{
        data : data,
        type : 'post',
        success : function(res)
        {
          layer.close(opens);
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layMsgOk(res.msg);
            tab.reload({
              where : {_token:token,house_id:house_id},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(data)
        {
          layMsgError('新增失败');
        }
      });
      return false;
    });
    form.on('submit(edit)',function(data)
    {
      data = data.field;
      data._token = token;
      $.ajax('/engineering/construction/plan-edit',{
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