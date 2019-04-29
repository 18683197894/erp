@extends('public')

@section('css')
<style type="text/css">
	.layui-table-cell{
    height:80px;
    line-height: 80px;
}
</style>
@endsection
@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group"> 
          <div class="layui-form-item">
            <label class="layui-form-label">拍摄时间</label>
            <div class="layui-input-block">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="start">
            </div>
          </div>
     	  <div class="layui-form-item">
            <label class="layui-form-label">进度</label>
            <div class="layui-input-block">
              <select name="schedule_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($schedule as $c)
                <option value="{{ $c->id }}">{{ $c->stage.' '.$c->matter.' '.$c->details }}</option>
                @endforeach
              </select>
            </div>
          </div>
        <div class="layui-form-item">
            <label class="layui-form-label">类别</label>
            <div class="layui-input-block">
              <select name="class" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                <option value="玄关">玄关</option>
                <option value="阳台">阳台</option>
                <option value="客厅">客厅</option>
                <option value="餐厅">餐厅</option>
                <option value="餐厅">厨房</option>
                <option value="主卧">主卧</option>
                <option value="主卧">次卧</option>
                <option value="书房">书房</option>
                <option value="卫生间">卫生间</option>
                <option value="洗手间">洗手间</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
		      <div class="layui-col-md12">
		        <div class="layui-card">
		          <div class="layui-card-body">
		            <div class="layui-upload">
		              <button type="button" class="layui-btn layui-btn-normal" id="test-upload-change">选择文件</button>
		            </div>
		          </div>
		        </div>
		      </div>
          </div>
	        
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
              </div>
            </div>
          </div> 
        </form>
      </div>
</div>
<div class="layui-card edit" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="edit"lay-filter="edit"> 
          <input type="hidden" name="id" value="">
          <div class="layui-form-item">
            <label class="layui-form-label">拍摄时间</label>
            <div class="layui-input-block">
              <input type="text" name="time" lay-verify="required" class="layui-input" id="start2">
            </div>
          </div>
     	  <div class="layui-form-item">
            <label class="layui-form-label">进度</label>
            <div class="layui-input-block">
              <select name="schedule_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($schedule as $c)
                <option value="{{ $c->id }}">{{ $c->stage.' '.$c->matter.' '.$c->details }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">类别</label>
            <div class="layui-input-block">
              <select name="class" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                <option value="玄关">玄关</option>
                <option value="阳台">阳台</option>
                <option value="客厅">客厅</option>
                <option value="餐厅">餐厅</option>
                <option value="餐厅">厨房</option>
                <option value="主卧">主卧</option>
                <option value="主卧">次卧</option>
                <option value="书房">书房</option>
                <option value="卫生间">卫生间</option>
                <option value="洗手间">洗手间</option>
              </select>
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
	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
			<input type="hidden" id="house_id" name="house_id" value="{{ $house->id }}">
		<form class="layui-form">
            <div class="layui-input-inline">
              <select name="schedule_id" id="schedule_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($schedule as $c)
                <option value="{{ $c->id }}">{{ $c->stage.' '.$c->matter.' '.$c->details }}</option>
                @endforeach
              </select>
            </div>
          </form>
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增图片','.add',0.5,0.7)">新增图片</button>
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
  }).use(['index', 'table','layedit','laydate','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,upload = layui.upload
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/engineering/house/album'
      ,where:{_token:token,house_id:$('#house_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '相册'
      ,cols: [[
         {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'schedule_name', title:'进度',unresize:true}
        ,{field:'class', title:'类别',unresize:true}
        ,{field:'time', title:'拍摄时间',unresize:true}
        ,{title:'图片',unresize:true,templet:function(d){
        	return " <a lay-event='check'><img src ='"+d.re_image+"'/></a>";
        }}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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
      elem: '#start2' //指定元素
    });

    $('.demoTable .layui-btn').on('click',function(){
    	schedule_id = $('#schedule_id').val();
    	tab.reload({where:{schedule_id:schedule_id,_token:token,house_id:$('#house_id').val()},page:{curr:1}});
    });

    //选完文件后不自动上传
    upload.render({
      elem: '#test-upload-change'
      ,url: '/upload/'
      ,auto: false
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          if(data.length <= 0) return false;
          var id = new Array();
          $.each(data,function(i,n){
          	id.push(n.id);
          });
        layer.confirm('确定删除: '+data.length+' 张图片吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/house/album-del") }}',
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
        layer.confirm('确定删除当前图片吗', function(index){
        	$.ajax({
          	url:'{{ url("/engineering/house/album-del") }}',
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
      		document.getElementById("edit").reset();
    			$('.edit').find("input[name='id']").val(data.id);
          form.val("edit", {
            "id" : data.id,
            'time' : data.time,
            'class' : data.class,
            'schedule_id' :data.schedule_id
          }); 
    			var width = ($(window).width() * 0.5)+'px';
    			var height = ($(window).height() * 0.6)+'px';
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
      } else if(obj.event === 'check')
      {	          
      		var schedule_id = $('#schedule_id').val();
      		var house_id = $('#house_id').val();
        	var page = tab.config.page.curr;
        	var limit = tab.config.page.limit;	
      	  $.getJSON('/engineering/house/album-check?limit='+limit+'&page='+page+'&schedule_id='+schedule_id+'&house_id='+house_id+'&album_id='+data.id, function(json){
          layer.photos({
            photos: json //格式见API文档手册页
          });
        });
      }
    });
    form.on('submit(add)',function(data){
      	data = data.field;

      if(data.file == "")
      {
      	layMsgError('请上传图片');
      	return false;
      }
      	datas = new FormData();
        datas.append('image',$('input[type="file"]').get(0).files[0]);
        datas.append('time',data.time);
        datas.append('class',data.class);
        datas.append('house_id',$('#house_id').val());
        datas.append('schedule_id',data.schedule_id);
        datas.append('_token',token);
      $.ajax({
        url : '{{ url("/engineering/house/album-add") }}',
        type : 'post',
        contentType : false,
        processData : false,
        data : datas,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
            $('#name').val('');
            tab.reload({
              where : {_token:token,house_id:$('#house_id').val()},
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
      data._token = token;
      $.ajax({
        url : '{{ url("/engineering/house/album-edit") }}',
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
  });
  </script>
@endsection

