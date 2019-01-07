@extends('public')

@section('css')

@endsection
@section('open')
<div class="layui-card dwg_upload" style="display:none">
      <div class="layui-card-body">
        <div class="layui-upload-drag" id="dwg_upload" lay-data="">
          <i class="layui-icon"></i>
          <p>点击上传，或将文件拖拽到此处</p>
        </div>
      </div>
</div>
<div class="layui-card effect_image" style="display:none">
      <div class="layui-card-body">
        <div class="layui-upload-drag" id="effect_image" lay-data="">
          <i class="layui-icon"></i>
          <p>点击上传，或将图片拖拽到此处</p>
        </div>
      </div>
</div>
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;padding-left: 0px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item" >
            <label class="layui-form-label">图纸名称</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
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
      <div class="layui-card-body" style="padding: 15px;padding-left: 0px;">
        <form class="layui-form" id="edit"lay-filter="edit">
          <input type="hidden" name="id" value="">
          <div class="layui-form-item" >
            <label class="layui-form-label">图纸名称</label>
            <div class="layui-input-block">
              <input name="name" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
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
    <form class="layui-form">
      <input type="hidden" name="house_id" id="house_id" value="{{ $house->id }}">
    </form>

	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增图纸','.add',0.3,0.4)">新增图纸</button>
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
  }).use(['index', 'table','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/house/drawing'
      ,where:{_token:token,house_id:$('#house_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '设计图纸'
      ,cols: [[
         {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'name', title:'图纸名称',unresize:true}
        ,{ title:'图纸CAD图',unresize:true,templet:function(d){
          if(d.dwg_image !== '')
          {       
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='dwg_upload'><i class='layui-icon'></i>上传文件</a><a href='/design/house/drawing-download?a="+d.id+"&c=dwg_image' target='_blank' class='layui-btn layui-btn-xs layui-btn-normal'>下载</a>"      
          }else
          {
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='dwg_upload'><i class='layui-icon'></i>上传文件</a>"      

          }
        }}
        ,{ title:'图纸IMG图',unresize:true,templet:function(d){
          if(d.effect_image !== '')
          {       
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='effect_image'><i class='layui-icon'></i>上传图片</a><a href='"+d.effect_image+"' target='_blank' class='layui-btn layui-btn-xs layui-btn-normal'>查看</a>"      
          }else
          {
            return "<a class='layui-btn layui-btn-xs layui-btn-normal' lay-event='effect_image'><i class='layui-icon'></i>上传图片</a>"      

          }
        }}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:110}
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
    $('.demoTable .layui-btn').on('click',function(){
    	var project_id = $('#project_id').val();
    	tab.reload({where:{project_id:project_id,_token:token},page:{curr:1}});
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data.house_id = $('#house_id').val();
      data._token = token;
      $.ajax({
        url : '{{ url("/design/house/drawing-add") }}',
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
            $('#page').val(1);
            tab.config.page.curr = 1;
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
        url : '{{ url("/design/house/drawing-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk('编辑成功');
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
        layer.confirm('确定删除图纸: '+name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/house/drawing-del") }}',
          	type : 'post',
          	data : {id:id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{

    					layer.close(index);
    					layMsgOk(res.msg);
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
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除图纸: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/house/drawing-del") }}',
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
      }else if(obj.event === 'dwg_upload')
      { 
          var re_data = "{data:{id:"+data.id+",_token:'"+token+"'}}";
          $('.dwg_upload').find("#dwg_upload").attr('lay-data',re_data);
          var width = ($(window).width() * 0.3)+'px';
          var height = ($(window).height() * 0.5)+'px';
            dwg_upload = layer.open({
            type : 1,
            title : '上传DWG平面图',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : ['288px','210px'],
            content : $('.dwg_upload')
          })
      }else if(obj.event === 'effect_image')
      { 
          var re_data = "{data:{id:"+data.id+",_token:'"+token+"'}}";
          $('.effect_image').find("#effect_image").attr('lay-data',re_data);
          var width = ($(window).width() * 0.3)+'px';
          var height = ($(window).height() * 0.5)+'px';
            effect_image = layer.open({
            type : 1,
            title : '上传平面效果图',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : ['288px','210px'],
            content : $('.effect_image')
          })
      }else if(obj.event == 'edit')
      {     
            form.val('edit',{
              'id':data.id,
              'name':data.name
            });
            var width = ($(window).width() * 0.3)+'px';
            var height = ($(window).height() * 0.4)+'px';
            edit = layer.open({
            type : 1,
            title : '图纸编辑',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.edit')
          })
      }
    });

    upload.render({
      elem: '#dwg_upload'
      ,url: '{{ url("/design/house/drawing-upload") }}'
      ,method : 'post'
      ,field:'dwg_upload'
      ,accept: 'file' //普通文件
      ,exts :'dwg'
      ,done: function(res){
        layer.close(dwg_upload);
        if(res.code == 200)
        {
          layMsgOk(res.msg);
          tab.reload();
        }else
        {
          layMsgError(res.msg);
        }
      }
    });
    upload.render({
      elem: '#effect_image'
      ,url: '{{ url("/design/house/drawing-upload") }}'
      ,method : 'post'
      ,field:'effect_image'
      ,accept: 'image' //普通文件
      ,exts :'jpg|png|jpeg'
      ,done: function(res){
        layer.close(effect_image);
        if(res.code == 200)
        {
          layMsgOk(res.msg);
          tab.reload();
        }else
        {
          layMsgError(res.msg);
        }
      }
    });
  });

  </script>
@endsection

