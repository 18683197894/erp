@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item" >
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
              <input name="username" value="" lay-verify="required|username" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
              <input type="radio" name="sex" value="1" title="男">
              <input type="radio" name="sex" value="2" title="女">
            </div>
          </div>
          
          <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">手机</label>
              <div class="layui-input-block">
                <input name="phone" value="" lay-verify="phone" autocomplete="off" class="layui-input" type="tel">
              </div>
            </div>
            <div class="layui-inline">
              <label class="layui-form-label">邮箱</label>
              <div class="layui-input-block">
                <input name="email" value="" lay-verify="emails" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">微信账号</label>
            <div class="layui-input-block">
              <input name="wechat_name" value="" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">客户备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">绑定房屋</label>
              <div class="layui-input-block">
                <select name="house_id" lay-search="">
                  <option value="">直接选择或搜索选择</option>
                  @foreach($house as $p)
                  <option value="{{ $p->id }}">{{ $p->Project->name.$p->unit.'单元'.$p->building.'栋'.$p->floor.'层'.$p->room_number.'号' }}</option>
                  @endforeach
                </select>
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
          <div class="layui-form-item" >
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
              <input name="username" value="" lay-verify="required|username" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                  <input type="radio" name="sex" value="1" title="男">
                  <input type="radio" name="sex" value="2" title="女">
            </div>
          </div>
          
          <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">手机</label>
              <div class="layui-input-block">
                <input name="phone" value="" lay-verify="phone" autocomplete="off" class="layui-input" type="tel">
              </div>
            </div>
            <div class="layui-inline">
              <label class="layui-form-label">邮箱</label>
              <div class="layui-input-block">
                <input name="email" value="" lay-verify="emails" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">微信账号</label>
            <div class="layui-input-block">
              <input name="wechat_name" value="" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">客户备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
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
		  <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="姓名搜索" autocomplete="off">
      <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
      <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增业主','.add',0.6,0.85)">新增业主</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="house">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="house">进入</a>
  </script>
  </script>
</div>
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','code','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/customer/owner'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '业主'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'id', title:'客户编号',fixed: 'left',unresize:true}
        ,{field:'username', title:'姓名',unresize:true}
        ,{title:'性别',unresize:true,templet:function(d){
          if(d.sex == 1)
          {
            return '男';
          }else if(d.sex == 2)
          {
            return '女';
          }else
          {
            return '';
          }
        }}
        ,{field:'phone', title:'手机',unresize:true}
        ,{field:'wechat_name', title:'微信号',unresize:true}
        ,{field:'remarks', title:'客户备注',unresize:true}
        ,{title:'房屋信息',unresize:true,toolbar:'#house',width:100}
        ,{fixed: 'right', title:'操作',fixed: 'right', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
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


    $('.demoTable .layui-btn').on('click',function(){
    	name = $('#name').val();
      $('#name').attr('val',name);
    	tab.reload({where:{name:name,_token:token},page:{curr:1}});
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
        layer.confirm('确定删除权限ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/rule-del") }}',
          	type : 'post',
          	data : {id,_token:token},
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
    laydate.render({
      elem: '#disc_time' //指定元素
    });
    laydate.render({
      elem: '#disc_time_re' //指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除业主: '+data.username+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/customer/owner-del") }}',
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
          form.val("edit", {
            "username": data.username 
            ,"phone": data.phone
            ,"email" : data.email
            ,"wechat_name" : data.wechat_name
            ,"id" : data.id
            ,"remarks" : data.remarks
          });
          if(data.sex == 1)
          {
            $('.edit').find("input[name=sex][value=1]").next('.layui-form-radio').click();
          }else if(data.sex == 2)
          {
            $('.edit').find("input[name=sex][value=2]").next('.layui-form-radio').click();
          }
          var width = ($(window).width() * 0.7)+'px';
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
      }else if(obj.event === 'house')
      {   
        var name = $('#name').attr('val');
        var page = tab.config.page.curr;
        var limit = tab.config.page.limit;
        window.location.href="/customer/owner/house?user_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/customer/owner-add") }}',
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
              where : {_token:token},
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
        url : '{{ url("/customer/owner-edit") }}',
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
      username : function(value){
        if(value.length < 2 || value.length >16)
        {
          return '姓名格式错误';
        }
      },
      emails : function(value)
      {
        if(value)
        {
          var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;                

          if (!myreg.test(value))
          {               
            return '邮箱格式错误';
          }
        }
      }
      
    });
  });
  </script>
@endsection