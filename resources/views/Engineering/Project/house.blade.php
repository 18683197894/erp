@extends('public')

@section('css')

@endsection

@section('open')


@endsection

@section('content')
<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<form class="layui-form" id="query" lay-filter='query' >
      <div class="layui-input-inline">
        <select name="project_id" lay-verify="">
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
      <button class="layui-btn" lay-submit="query" lay-filter="query" style="margin-left: 5px;">查询</button>
      <a class="layui-btn layui-btn-primary" onclick="reset()">重置</a>
    </form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>




  <script type="text/html" id="schedule">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="schedule">进度更新</a>
  </script>
  <script type="text/html" id="album">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="album">查看相册</a>
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
  
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/house'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '工程项目'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'id', title:'序号',fixed: 'left',unresize:true,width:60}
        ,{field:'project_name', title:'项目名称',unresize:true,width:120}
        ,{field:'room_number', title:'房号',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'huxing_name', title:'户型',unresize:true}
        ,{field:'acreage', title:'面积',unresize:true}
        ,{title:'施工相册',unresize:true,width:120,toolbar:'#album'}
        ,{field:'schedule_name',title:'工程完成度',unresize:true,width:140}
        ,{fixed: 'right',title:'施工进度',width:300,align:'center',toolbar:'#schedule'}
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

    form.on('submit(query)',function(data){
      data = data.field;
      data._token = token;
      tab.reload({where:data});
      return false;
    });

    laydate.render({
      elem: '#time1' //指定元素
    });
    laydate.render({
      elem: '#time2' //指定元素
    });
    laydate.render({
      elem: '#time3' //指定元素
    });
    laydate.render({
      elem: '#time4' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){

      } else if(obj.event === 'edit'){
          $('.edit').find("input[name='room_number']").val(data.room_number);
          $('.edit').find("input[name='acreage']").val(data.acreage);
          $('.edit').find("input[name='id']").val(data.id);
          $('.edit').find('.floor').find("dd[lay-value='"+data.floor+"']").click();
          $('.edit').find('.building').find("dd[lay-value='"+data.building+"']").click();
          $('.edit').find('.unit').find("dd[lay-value='"+data.unit+"']").click();
          $('.edit').find('.huxing_id').find("dd[lay-value='"+data.huxing_id+"']").click();
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.8)+'px';
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
      }else if(obj.event === 'schedule')
      {   
        openMax('施工进度','/engineering/house/schedule?house_id='+data.id,function(){
          tab.reload();
        });
      }else if(obj.event === 'album')
      { 
        openMax('施工相册','/engineering/house/album?house_id='+data.id);
      }
    });

  });
  </script>
@endsection