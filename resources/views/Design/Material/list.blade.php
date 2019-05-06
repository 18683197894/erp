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
            <label class="layui-form-label">区域</label>
            <div class="layui-input-block">
              <select name="region" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">土建部分</option>
                <option value="2">客餐厅厨房区域</option>
                <option value="3">卫生间区域</option>
                <option value="4">卧室区域</option>
                <option value="5">强弱电工程部分</option>
                <option value="6">其他项目</option>
                <option value="7">卫浴洁具类</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">位置</label>
            <div class="layui-input-block">
              <input name="position" value="" lay-verify="required" placeholder="请输入位置" autocomplete="off" class="layui-input" type="text">
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
            <label class="layui-form-label">人工费用</label>
            <div class="layui-input-block">
              <input name="artificial_price" value="" lay-verify="price" placeholder="请输入人工费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">施工说明/备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
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
    <form class="layui-form layui-form-pane" lay-filter="edit">
      <input type="hidden" name="id" value="">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">区域</label>
            <div class="layui-input-block">
              <select name="region" lay-verify="required">
                <option value="">请选择</option>
                <option value="1">土建部分</option>
                <option value="2">客餐厅厨房区域</option>
                <option value="3">卫生间区域</option>
                <option value="4">卧室区域</option>
                <option value="5">强弱电工程部分</option>
                <option value="6">其他项目</option>
                <option value="7">卫浴洁具类</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg6">
            <label class="layui-form-label">位置</label>
            <div class="layui-input-block">
              <input name="position" value="" lay-verify="required" placeholder="请输入位置" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6">
            <label class="layui-form-label">材料编号</label>
            <div class="layui-input-block">
              <input name="code" value="" lay-verify="required" placeholder="请输入材料编号" autocomplete="off" class="layui-input" type="text" disabled>
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
            <label class="layui-form-label">人工费用</label>
            <div class="layui-input-block">
              <input name="artificial_price" value="" lay-verify="price" placeholder="请输入人工费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">施工说明/备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
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
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增材料','.add',0.6,0.8)">新增材料</button>
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
  }).use(['index', 'table'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    token = $("meta[name='csrf-token']").attr('content');
    house_id = {{ $house->id }};
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/material/list'
      ,where:{_token:token,house_id:house_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料清单'
      ,cols: [[
         {field:'id',fixed: 'left',title:'序号',unresize:true,width:80}
        ,{field:'region_name',title:'区域',unresize:true,width:120}
        ,{field:'position', title:'位置',unresize:true,width:100}
        ,{field:'code', title:'材料编码',unresize:true,width:100}
        ,{field:'class_a',title:'一级分类',unresize:true,width:100}
        ,{field:'class_b',title:'二级分类',unresize:true,width:100}
        ,{field:'brand', title:'品牌',unresize:true,width:100}
        ,{field:'name', title:'材料名称',unresize:true,width:100}
        ,{field:'spec', title:'规格',unresize:true,width:100}
        ,{field:'model', title:'型号',unresize:true,width:100}
        ,{field:'color', title:'颜色',unresize:true,width:100}
        ,{field:'metering', title:'计量单位',unresize:true,width:100}
        // ,{field:'parts_num', title:'配件套数',unresize:true,width:100}
        // ,{field:'place', title:'产地',unresize:true,width:100}
        ,{field:'num', title:'数量',unresize:true,width:100}
        ,{field:'standard_price', title:'销售价',unresize:true,width:100}
        ,{field:'promotion_price', title:'促销价',unresize:true,width:100}
        ,{field:'settlement_price', title:'结算价',unresize:true,width:100}
        ,{field:'artificial_price', title:'人工费',unresize:true,width:100}
        ,{field:'total', title:'总价',unresize:true,width:100}
        ,{field:'remarks', title:'施工说明/备注',unresize:true,width:120}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:115}
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
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除材料: '+data.code+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/material/list-del") }}',
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
          'id':data.id,
          'code':data.code,
          'num':data.num,
          'artificial_price':data.artificial_price,
          'remarks':data.remarks,
          'position':data.position,
          'region':data.region
        });
        var width = ($(window).width() *  0.6)+'px';
        var height = ($(window).height() * 0.8)+'px';
          edit = layer.open({
          type: 1,
          title: '编辑',
          fix: false, //不固定
          maxmin: true,
          shadeClose: true,
          shade: 0.4, //开启最大化最小化按钮
          area: [width, height],
          content: $('.edit')
          });  
      }
    });
    form.on('submit(add)',function(data)
    {
      data = data.field;
      data._token = token;
      data.house_id = house_id;
      $.ajax('/design/material/list-add',{
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
    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/design/material/list-edit") }}',
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
    });
  });

  </script>
@endsection

