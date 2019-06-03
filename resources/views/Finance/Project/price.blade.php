@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card yes" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="yes">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">应收费用</label>
            <div class="layui-input-block">
              <input type="text" name="price_should" disabled class="layui-input">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">实收费用</label>
            <div class="layui-input-block">
              <input type="text" name="price_money" disabled  class="layui-input">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">收入差额</label>
            <div class="layui-input-block">
              <input type="text" name="price_difference" disabled class="layui-input">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg8">
            <label class="layui-form-label" style="width:30%;">设计部实收费用</label>
            <div class="layui-input-block" style="width:70%;margin-left: 30%;">
              <input type="text" name="price_design" disabled class="layui-input">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="layui-card no" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="no">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">提报时间</label>
            <div class="layui-input-block">
              <input type="text" name="propose_time" disabled class="layui-input">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">付款时间</label>
            <div class="layui-input-block">
              <input type="text" name="payment_time" disabled  class="layui-input">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">持续时间</label>
            <div class="layui-input-block">
              <input type="text" name="last_time" disabled class="layui-input">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="layui-card add" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" id="myform" lay-filter="component-form-group">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用属性</label>
            <div class="layui-input-block">
              <select name="price_cost" lay-verify="required">
                <option value="1">收入</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">用途</label>
            <div class="layui-input-block">
              <select name="price_purpose" lay-verify="required">
                <option value="">请选择用途</option>
                <option value="装修款">装修款</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用名称</label>
            <div class="layui-input-block">
              <input name="price_name" value="" lay-verify="required" placeholder="请输入费用名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">收款时间</label>
            <div class="layui-input-block">
              <input type="text" name="payment_time" lay-verify="required" placeholder="请选择收款时间" class="layui-input" id="start1">
            </div>
          </div>
          <div class="layui-col-lg4">
              <label class="layui-form-label">应收费用</label>
              <div class="layui-input-block">
                <input name="price_should" value="" lay-verify="required|price" placeholder="请输入应收费用" autocomplete="off" class="layui-input" type="text">
              </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">实收费用</label>
            <div class="layui-input-block">
              <input type="text" name="price_money" lay-verify="required|price" placeholder="请输入实收费用" class="layui-input">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">房屋</label>
          <div class="layui-input-block">
            <select name="house_id"  lay-verify="required" lay-search="">
              <option value="">直接选择或搜索选择</option>
              @foreach($house as $p)
              <option value="{{ $p->id }}">{{ $p->project->name.$p->building.'栋'.$p->unit.'单元'.$p->floor.'层'.$p->room_number.'号' }}</option>
              @endforeach
            </select>
          </div>
      </div>
      <div class="layui-form-item layui-form-text" >
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
          <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
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
<div class="layui-card add_re" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="component-form-group">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用属性</label>
            <div class="layui-input-block">
              <select name="price_cost" lay-verify="required">
                <option value="0">支出</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">用途</label>
            <div class="layui-input-block">
              <select name="price_purpose" lay-verify="required">
                <option value="">请选择用途</option>
                <option value="材料费用">材料费用</option>
                <option value="人工费用">人工费用</option>
                <option value="其他费用">其他费用</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用名称</label>
            <div class="layui-input-block">
              <input name="price_name" value="" lay-verify="required" placeholder="请输入费用名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">付款金额</label>
            <div class="layui-input-block">
              <input name="price_money" value="" lay-verify="required|price" placeholder="请输入付款金额" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">提报时间</label>
            <div class="layui-input-block">
              <input type="text" name="propose_time" lay-verify="required" placeholder="请选择提报时间" class="layui-input" id="start2">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">付款时间</label>
            <div class="layui-input-block">
              <input type="text" name="payment_time" lay-verify="required" placeholder="请选择付款时间" class="layui-input" id="start3">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">房屋</label>
        <div class="layui-input-block">
          <select name="house_id"  lay-verify="required" lay-search="">
            <option value="">直接选择或搜索选择</option>
            @foreach($house as $p)
            <option value="{{ $p->id }}">{{ $p->project->name.$p->building.'栋'.$p->unit.'单元'.$p->floor.'层'.$p->room_number.'号' }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="layui-form-item layui-form-text" >
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
          <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
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
<div class="layui-card edit_yes" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="edit_yes">
      <input type="hidden" name="id">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用属性</label>
            <div class="layui-input-block">
              <select name="price_cost" lay-verify="required">
                <option value="1">收入</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">用途</label>
            <div class="layui-input-block">
              <select name="price_purpose" lay-verify="required">
                <option value="">请选择用途</option>
                <option value="装修款">装修款</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用名称</label>
            <div class="layui-input-block">
              <input name="price_name" value="" lay-verify="required" placeholder="请输入费用名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">收款时间</label>
            <div class="layui-input-block">
              <input type="text" name="payment_time" lay-verify="required" placeholder="请选择收款时间" class="layui-input" id="start4">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">应收费用</label>
            <div class="layui-input-block">
              <input name="price_should" value="" lay-verify="required|price" placeholder="请输入应收费用" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">实收费用</label>
            <div class="layui-input-block">
              <input type="text" name="price_money" lay-verify="required|price" placeholder="请输入实收费用" class="layui-input">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item layui-form-text" >
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
          <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
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
<div class="layui-card edit_no" style="display:none">
  <div class="layui-card-body">
    <form class="layui-form layui-form-pane" lay-filter="edit_no">
      <input type="hidden" name="id">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用属性</label>
            <div class="layui-input-block">
              <select name="price_cost" lay-verify="required">
                <option value="0">支出</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">用途</label>
            <div class="layui-input-block">
              <select name="price_purpose" lay-verify="required">
                <option value="">请选择用途</option>
                <option value="材料费用">材料费用</option>
                <option value="人工费用">人工费用</option>
                <option value="其他费用">其他费用</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">费用名称</label>
            <div class="layui-input-block">
              <input name="price_name" value="" lay-verify="required" placeholder="请输入费用名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg4">
            <label class="layui-form-label">付款金额</label>
            <div class="layui-input-block">
              <input name="price_money" value="" lay-verify="required|price" placeholder="请输入付款金额" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">提报时间</label>
            <div class="layui-input-block">
              <input type="text" name="propose_time" lay-verify="required" placeholder="请选择提报时间" class="layui-input" id="start5">
            </div>
          </div>
          <div class="layui-col-lg4">
            <label class="layui-form-label">付款时间</label>
            <div class="layui-input-block">
              <input type="text" name="payment_time" lay-verify="required" placeholder="请选择付款时间" class="layui-input" id="start6">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item layui-form-text" >
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
          <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
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
  <div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form" id="query" lay-filter='query' >
      <div class="layui-input-inline">
        <select name="project_id" lay-verify="">
          <option value="{{ $project->id }}">{{ $project->name }}</option>
        </select>
      </div>
      <div class="layui-input-inline">
        <select name="building" lay-verify="">
          <option value="">请选择楼栋</option>
          <option value="1">1栋</option>
          <option value="2">2栋</option>
          <option value="3">3栋</option>
          <option value="4">4栋</option>
          <option value="5">5栋</option>
          <option value="6">6栋</option>
          <option value="7">7栋</option>
          <option value="8">8栋</option>
          <option value="9">9栋</option>
          <option value="10">10栋</option>
          <option value="11">11栋</option>
          <option value="12">12栋</option>
          <option value="13">13栋</option>
          <option value="14">14栋</option>
          <option value="15">15栋</option>
        </select>
      </div>
      <div class="layui-input-inline">
          <select name="unit" lay-verify="">
            <option value="">请选择单元</option>
            <option value="1">1单元</option>
            <option value="2">2单元</option>
            <option value="3">3单元</option>
            <option value="4">4单元</option>
            <option value="5">5单元</option>
            <option value="6">6单元</option>
            <option value="7">7单元</option>
            <option value="8">8单元</option>
            <option value="9">9单元</option>
            <option value="10">10单元</option>
          </select>
        </div>
        <div class="layui-input-inline">
          <select name="floor" lay-verify="">
            <option value="">请选择楼层</option>
            <option value="1">1层</option>
            <option value="2">2层</option>
            <option value="3">3层</option>
            <option value="4">4层</option>
            <option value="5">5层</option>
            <option value="6">6层</option>
            <option value="7">7层</option>
            <option value="8">8层</option>
            <option value="9">9层</option>
            <option value="10">10层</option>
            <option value="11">11层</option>
            <option value="12">12层</option>
            <option value="13">13层</option>
            <option value="14">14层</option>
            <option value="15">15层</option>
            <option value="16">16层</option>
            <option value="17">17层</option>
            <option value="18">18层</option>
            <option value="19">19层</option>
            <option value="20">20层</option>
            <option value="21">21层</option>
            <option value="22">22层</option>
            <option value="23">23层</option>
            <option value="24">24层</option>
            <option value="25">25层</option>
            <option value="26">26层</option>
            <option value="27">27层</option>
            <option value="28">28层</option>
            <option value="29">29层</option>
            <option value="30">30层</option>
          </select>
        </div>
      <div class="layui-input-inline">
        <input name="room_number" value="" lay-verify="" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
      </div>
      <div class="layui-input-inline">
        <select name="price_cost" lay-verify="">
          <option value="">请选择费用属性</option>
          <option value="1">收入</option>
          <option value="0">支出</option>
        </select>
      </div>
      <button class="layui-btn" lay-submit="query" lay-filter="query" style="margin-left: 5px;">查询</button>
      <a class="layui-btn layui-btn-primary" onclick="reset({'department_id':'{{$department->id}}','project_id':'{{$project->id}}'})">重置</a>
    </form>
  </div>
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-toolbarDemo">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增收入','.add',0.6,0.8)">新增收入</button>
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增支出','.add_re',0.6,0.8)">新增支出</button>
    </div>
  </script>
  <script type="text/html" id="more">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="more">进入</a>
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
      ,url: '/finance/project/price'
      ,where:{_token:token,department_id:department_id,project_id:project_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料管理'
      ,cols: [[
         {field:'id',fixed: 'left',title:'序号',unresize:true,width:'4%'}
        ,{field:'department_name',title:'部门',unresize:true,width:'6%'}
        ,{field:'building', title:'楼栋',unresize:true,width:'5%'}
        ,{field:'unit', title:'单元',unresize:true,width:'5%'}
        ,{field:'floor', title:'楼层',unresize:true,width:'5%'}
        ,{field:'room_number', title:'房号',unresize:true,width:'5%'}
        ,{field:'price_cost_name', title:'费用属性',unresize:true,width:'7%'}
        ,{field:'price_purpose', title:'用途',unresize:true,width:'7%'}
        ,{field:'price_money', title:'费用金额',unresize:true,width:'8%'}
        ,{field:'price_name', title:'费用名称',unresize:true,width:'10%'}
        ,{field:'payment_time', title:'收款/付款时间',unresize:true,width:'8%'}
        ,{field:'remarks', title:'备注',unresize:true}
        ,{title:'更多',unresize:true, toolbar:'#more',width:'7%'}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:'8%'}
        // ,{field:'room_number', title:'应收费用',unresize:true}
        // ,{field:'room_number', title:'实收费用',unresize:true}
        // ,{field:'room_number', title:'设计部实收金额',unresize:true}
        // ,{field:'room_number', title:'收款时间',unresize:true}
        // ,{field:'room_number', title:'收入差额',unresize:true}
        // ,{field:'propose_time', title:'提报时间',unresize:true}
        // ,{field:'payment_time', title:'付款时间',unresize:true}
        // ,{field:'last_time', title:'持续时间',unresize:true}
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

  laydate.render({
    elem: '#start1' //指定元素
  });
  laydate.render({
    elem: '#start2' //指定元素
  });
  laydate.render({
    elem: '#start3' //指定元素
  });
  laydate.render({
    elem: '#start4' //指定元素
  });
  laydate.render({
    elem: '#start5' //指定元素
  });
  laydate.render({
    elem: '#start6' //指定元素
  });
  form.on('submit(query)',function(data){
    data = data.field;
    data._token = token;
    data.project_id = project_id;
    data.department_id = department_id;
    tab.reload({where:data});
    return false;
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
      if(obj.event === 'more')
      { 
        var cost = data.price_cost == 1 ?'yes':'no';
          form.val(cost, {
            "price_should" : data.price_should,
            'price_money' : data.price_money,
            'price_difference' : data.price_difference,
            'propose_time' : data.propose_time,
            'payment_time' : data.payment_time,
            'last_time' : data.last_time,
            'price_design' : data.price_design
          }); 
          var width = ($(window).width() * 0.5)+'px';
          var height = ($(window).height() * 0.4)+'px';
            yes = layer.open({
            type : 1,
            title : '更多',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.'+cost)
          })
      }else if(obj.event === 'edit')
      { 
        var cost = data.price_cost == 1 ?'edit_yes':'edit_no';
          form.val(cost, {
            'id' : data.id,
            "price_should" : data.price_should,
            'price_money' : data.price_money,
            'price_difference' : data.price_difference,
            'propose_time' : data.propose_time,
            'payment_time' : data.payment_time,
            'last_time' : data.last_time,
            'price_purpose':data.price_purpose,
            'price_name':data.price_name,
            'remarks':data.remarks,
          }); 
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.7)+'px';
            edit = layer.open({
            type : 1,
            title : '编辑',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.'+cost)
          })
      }else if(obj.event === 'del')
      {
        layer.confirm('确定删除费用: '+data.price_name+' 吗', function(index){
        $.ajax({
          url:'{{ url("/finance/project/price-del") }}',
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
        url : '{{ url("/finance/project/price-add") }}',
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

