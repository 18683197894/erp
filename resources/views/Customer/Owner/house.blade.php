@extends('public')

@section('css')
<!-- <style type="text/css">
.layui-table-cell {
    height: auto;
    line-height: 48px;
}
</style> -->
@endsection

@section('open')
<div class="layui-card add" style="display:none">
    <form class="layui-form layui-form-pane" id="myform"  style="margin: 15px;" lay-filter="component-form-group">
      <div class="layui-form-item">
        <label class="layui-form-label">绑定房屋</label>
          <div class="layui-input-block">
            <select name="house_id" lay-search="" lay-verify="required">
              <option value="">直接选择或搜索选择</option>
              @foreach($house as $p)
              <option value="{{ $p->id }}">{{ $p->Project->name.$p->unit.'单元'.$p->building.'栋'.$p->floor.'层'.$p->room_number.'号' }}</option>
              @endforeach
            </select>
          </div>
      </div>
      <div class="layui-form-item" >
        <label class="layui-form-label">装修金额</label>
        <div class="layui-input-block">
          <input name="total" value="" lay-verify="total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
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

<div class="layui-card edit" style="display:none">
  <form class="layui-form layui-form-pane" id="edit"  style="margin: 15px;" lay-filter="edit">
    <input type="hidden" name="house_id" value="">
    <div class="layui-form-item" >
      <label class="layui-form-label">装修金额</label>
      <div class="layui-input-block">
        <input name="total" value="" lay-verify="required|total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
      </div>
    </div>

    <div class="layui-form-item ">
      <div class="layui-footer">
          <button class="layui-btn" style="margin-top: 10px;" lay-submit="" lay-filter="edit">立即提交</button>
      </div>
    </div> 
</form>
</div>
<div class="layui-card demand" style="display:none">
  <form class="layui-form layui-form-pane" style="margin: 15px;" lay-filter="demand">
    <input type="hidden" name="house_id" value="">
    <div class="layui-form-item" >
      <label class="layui-form-label">装修层次</label>
      <div class="layui-input-block">
        <input name="arrangement" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
      </div>
    </div>
    <div class="layui-form-item" >
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
<!-- 	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
			<input class="layui-input" name="name" id="name" placeholder="姓名搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div> -->
      <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">

	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增房屋','.add',0.3,0.4)">新增房屋</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="schedule">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="schedule">进入</a>
  </script>
  <script type="text/html" id="engineering-schedule">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="engineering-schedule">查看</a>
  </script>
  <script type="text/html" id="album">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="album">查看</a>
  </script>
  <script type="text/html" id="demand">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="demand">反馈</a>
  </script>
</div>

@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/customer/owner/house'
      ,where:{_token:token,user_id:$('#user_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预约拜访'
      ,cols: [[
         {title:'楼盘',fixed: 'left',unresize:true,width:100,templet:function(d){
          return d.project.name;
        }}
        ,{field:'room_number', title:'房号',unresize:true}
        ,{field:'floor', title:'楼层',unresize:true}
        ,{field:'building', title:'楼栋',unresize:true}
        ,{field:'unit', title:'单元',unresize:true}
        ,{title:'户型',unresize:true,templet:function(d){
          if(d.huxing)
          {
            return d.huxing.name;
          }else
          {
            return '';
          }
        }}
        ,{field:'acreage', title:'面积',unresize:true}
        ,{title:'已付款',unresize:true,width:120,templet:function(d){
          if(d.owner_schedules[0])
          {
            var total = 0;
            $.each(d.owner_schedules,function(i,n){
              total += parseFloat(n.money);
            });
            return total;
          }else
          {
            return '';
          }
        }}
        ,{field:'total', title:'装修金额',width:110,unresize:true}
        // ,{title:'当前进度',unresize:true,width:110,templet:function(d){
        //   if(d.owner_schedules[0])
        //   {
        //     return d.owner_schedules[0]['person'];
        //   }else
        //   {
        //     return '';
        //   }
        // }}
        ,{title:'跟进进度',unresize:true,toolbar: '#schedule'}
        ,{title:'施工进度',unresize:true,toolbar: '#engineering-schedule'}
        ,{title:'相册',unresize:true,toolbar: '#album'}
        ,{title:'需求',unresize:true,toolbar: '#demand'}
        ,{fixed: 'right', title:'操作',fixed: 'right', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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
      elem: '#start' //指定元素
    });
    laydate.render({
      elem: '#re_start' //指定元素
    });
    // $('.demoTable .layui-btn').on('click',function(){
    // 	name = $('#name').val();
    // 	tab.reload({where:{name:name,_token:token,user_id:$('#user_id').val()},page:{curr:1}});
    // });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          if(data.length <= 0) return false;
          var id = new Array();
          var name = new Array();
          $.each(data,function(i,n){
          	name.push(n.name);
          	id.push(n.id);
          });
        layer.confirm('确定删除联系人: '+name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/contacts-del") }}',
          	type : 'post',
          	data : {id:id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{

					layer.close(index);
					layMsgOk(res.msg);
					// location.reload(true);
					tab.reload();
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
          // layer.alert(JSON.stringify(data));
        break;
        case 'getCheckLength':
          // var data = checkStatus.data;
          // layer.msg('选中了：'+ data.length + ' 个');
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
        layer.confirm('确定删除房号: '+data.room_number+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/customer/owner/house-del") }}',
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
        
      		form.val("edit", {
            "total" : data.total,
            'house_id' : data.id 
          }); 
    			var width = ($(window).width() * 0.3)+'px';
    			var height = ($(window).height() * 0.4)+'px';
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
        var width = ($(window).width() * 1)+'px';
        var height = ($(window).height() * 1)+'px';
        var schedule = layer.open({
          type: 2,
          title: '房号: '+data.room_number,
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: [width, height],
          content: '{{ url("/customer/owner/house/schedule") }}?house_id='+data.id,
          end:function(){
            tab.reload();
          }
        });        
      }else if(obj.event === 'engineering-schedule')
      {
        var width = ($(window).width() *  1)+'px';
        var height = ($(window).height() * 1)+'px';
        var schedule = layer.open({
          type: 2,
          title: '房号: '+data.room_number,
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: [width, height],
          content: '{{ url("/customer/owner/house/engineering-schedule") }}?house_id='+data.id
        });     
      }else if(obj.event === 'album')
      {
        var width = ($(window).width() *  1)+'px';
        var height = ($(window).height() * 1)+'px';
        var schedule = layer.open({
          type: 2,
          title: '房号: '+data.room_number,
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: [width, height],
          content: '{{ url("/customer/owner/house/album") }}?house_id='+data.id
        });     
      }else if(obj.event === 'demand')
      {
          var width = ($(window).width() * 0.75)+'px';
          var height = ($(window).height() * 0.85)+'px';
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
        url : '{{ url("customer/owner/house/demand-edit") }}',
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
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      data.user_id = $('#user_id').val();
      $.ajax({
        url : '{{ url("/customer/owner/house-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
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
    form.on('submit(edit)',function(data){
      data = data.field;
      data.user_id = $('#user_id').val();
      data._token = token;
      $.ajax({
        url : '{{ url("/customer/owner/house-edit") }}',
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
      })
      return false;
    })
    form.verify({
      'total' : function(value)
      {
        if(value)
        {
          s = /^\d{5,8}\.\d{1,2}$/;
          sS = /^\d{5,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:5 MAX:8 保留小数点2位)';
          }
        }
      }
    })
  });
  </script>
@endsection

