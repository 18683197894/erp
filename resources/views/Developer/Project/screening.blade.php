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
<div class="layui-card edit" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="edit"lay-filter="edit">
          <input type="hidden" name="id" value="">

          <div class="layui-form-item">
            <label class="layui-form-label">来源</label>
              <div class="layui-input-inline">
                <select name="source" lay-verify="required" lay-search="">
                  <option value=""></option>
                  <option value="内部推荐">内部推荐</option>
                  <option value="百度推广">百度推广</option>
                  <option value="新媒体">新媒体</option>
                  <option value="合作推广">合作推广</option>
                  <option value="商务关系">商务关系</option>
                  <option value="商务关系">商务关系</option>
                  <option value="商务关系">商务关系</option>
                </select>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">是否有效</label>
              <div class="layui-input-inline">
                    <input type="checkbox" name="status" lay-skin="switch" lay-text="是|否" checked>
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
<!-- 	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
			<input class="layui-input" name="name" id="name" placeholder="姓名搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div> -->
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
    <a class='layui-btn layui-btn-xs' lay-event='edit'>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
<!--       <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
     -->
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
      ,url: '/developer/project/screening'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预约拜访'
      ,cols: [[
         // {type: 'checkbox', fixed: 'left'}
        {field:'company_name', title:'开发商',fixed: 'left',unresize:true}
        ,{field:'name', title:'项目名称',unresize:true}
        ,{title:'联系人',unresize:true,templet:function(d){
          return "<a class='layui-btn layui-btn-xs  layui-btn-normal' lay-event='check'>进入</a>";
        }}
        ,{title:'信息',unresize:true,templet:function(d){
          return "<a class='layui-btn layui-btn-xs  layui-btn-normal' lay-event='information'>进入</a>";
        }}
        ,{field:'source', title:'来源',unresize:true,sort:true}
        ,{field:'status', title:'是否有效',unresize:true,sort:true}
        ,{field:'screening_time', title:'处理时间',unresize:true}
        ,{fixed: 'right', title:'操作',toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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
        layer.confirm('确定删除项目: '+data.name+' 吗', function(index){
          $.ajax({
            url:'{{ url("/developer/project-del") }}',
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
      } else if(obj.event === 'check'){
        openMax('项目联系人',"/developer/project/contacts?project_id="+data.id);
      }else if(obj.event === 'information'){
        openMax('项目信息',"/developer/project/information?project_id="+data.id);
      }else if(obj.event === 'edit')
      { 

        form.val('edit',{
          'id':data.id,
          'source':data.source,
          'status':data.status === '有效'?1:0
        });
        var width = ($(window).width() * 0.4)+'px';
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
        });
      }
    });
    openMax = function(title,url){
      layer.open({
        type : 2,
        title : title,
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        area : [$(window).width() * 0.95+'px',$(window).height() * 0.9+'px'],
        shade: 0.4,
        content : url
      })
    }
    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/developer/project/screening-edit") }}',
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

