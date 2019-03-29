@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card demand" style="display:none">
  <form class="layui-form layui-form-pane" style="padding: 15px;" lay-filter="demand">
    <input type="hidden" name="house_id" value="">
    <div class="layui-form-item" >
      <div class="layui-row layui-col-space10">
        <div class="layui-col-lg6">
          <label class="layui-form-label">装修层次</label>
          <div class="layui-input-block">
            <input name="arrangement" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
          </div>
        </div>

        <div class="layui-col-lg6">
          <label class="layui-form-label">装修风格</label>
          <div class="layui-input-block">
            <select name="style" lay-search="" lay-verify="required">
              <option value="">直接选择或搜索选择</option>
              @foreach($style as $v)
              <option value="{{ $v }}">{{ $v }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="layui-form-item layui-form-text" >
      <label class="layui-form-label">喜好</label>
      <div class="layui-input-block">
        <textarea cols="30" rows="2" name="like" lay-verify="required" placeholder="请输入" class="layui-textarea"></textarea>
      </div>
    </div>
    <div class="layui-form-item layui-form-text" >
      <label class="layui-form-label">房改需求</label>
      <div class="layui-input-block">
        <textarea cols="30" rows="2" name="demand" lay-verify="required" placeholder="请输入" class="layui-textarea"></textarea>
      </div>
    </div>
    <div class="layui-form-item ">
      <div class="layui-footer">
          <button class="layui-btn" style="margin-top: 10px;" lay-submit="" lay-filter="demand">立即更新</button>
      </div>
    </div> 
  </form>
</div>
@endsection

@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
    <form class="layui-form" id="query" lay-filter='query' >
    <div class="layui-input-inline">
      <select name="project_id" id="class" lay-verify="">
        <option value="">请选择项目</option>
        @foreach($project as $v)
        <option  value="{{ $v->id }}">{{ $v->name }}</option>
        @endforeach
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
      <button class="layui-btn" lay-submit="query" lay-filter="query">查询</button>
      <a class="layui-btn layui-btn-primary" onclick="reset()">重置</a>
    </form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="demand">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="demand">反馈</a>
  </script>
  <script type="text/html" id="drawing">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="drawing">管理图纸</a>
  </script>
  <script type="text/html" id="material">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="material">进入</a>
  </script>
</div>

@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    token = $("meta[name='csrf-token']").attr('content');
  
      tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/query'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '设计图纸'
      ,cols: [[
         {field:'project_name',fixed: 'left',title:'项目名称',unresize:true,width:120}
        ,{field:'building', title:'楼栋',unresize:true,width:80}
        ,{field:'unit', title:'单元',unresize:true,width:80}
        ,{field:'floor', title:'楼层',unresize:true,width:80}
        ,{field:'room_number', title:'房号',unresize:true,width:80}
        ,{field:'huxing_name', title:'户型',unresize:true,width:80}
        ,{field:'acreage', title:'面积',unresize:true,width:80}
        ,{title:'设计图纸',unresize:true, toolbar:'#drawing'}
        ,{title:'材料清单',unresize:true, toolbar:'#material'}
        ,{title:'装修需求',unresize:true, toolbar: '#demand'}
        ,{field:'total', title:'合同金额',unresize:true,width:100}
        ,{field:'money', title:'实付金额',unresize:true,width:100}
        ,{field:'cost',fixed:'right', title:'成本合计',unresize:true,width:120}
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
  form.on('submit(query)',function(data){
    data = data.field;
    data._token = token;
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
      if(obj.event === 'drawing')
      {
        openMax('管理图纸','/design/manage/drawing?house_id='+data.id);
      }else if(obj.event === 'demand')
      { 
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.8)+'px';
          if(!data.demand)
          {
            data.demand = new Array();
          }
          form.val("demand", {
            "house_id" : data.id,
            'arrangement' : data.demand.arrangement,
            'style' : data.demand.style,
            'like' : data.demand.like,
            'demand' : data.demand.demand
          }); 
          demand = layer.open({
            type : 1,
            title : '编辑',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.demand')
          })
      }
    });
    form.on('submit(demand)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("design/owner/demand-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(demand);
            layMsgOk(res.msg);
            $('#name').val('');
            tab.reload({
              where : {_token:token,user_id:$('#user_id').val()},
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
  });

  </script>
@endsection

