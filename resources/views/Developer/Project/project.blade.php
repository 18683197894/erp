@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-row layui-col-space10">
            <div class="layui-col-lg6">
              <label class="layui-form-label">项目名称</label>
              <div class="layui-input-block">
                <input name="name" value="" lay-verify="required" placeholder="请输入项目名称" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">开盘时间</label>
              <div class="layui-input-block">
                <input type="text" name="disc_time" lay-verify="required" class="layui-input" id="disc_time">
              </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10">
            <div class="layui-col-lg6">
              <label class="layui-form-label">开发商</label>
                <div class="layui-input-block">
                  <select name="company_id" lay-verify="required" lay-search="">
                    <option value="">直接选择或搜索选择</option>
                    @foreach($company as $p)
                    <option value="{{ $p->id }}">{{ $p->company_name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">状态标记</label>
                <div class="layui-input-block">
                  <select name="label" lay-verify="required" lay-search="">
                    <option value=""></option>
                    <option value="暂定">暂定</option>
                    <option value="放弃">放弃</option>
                    <option value="暂停">暂停</option>
                    <option value="重要">重要</option>
                    <option value="已完成">已完成</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否为房销业务</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="is_sales" checked lay-skin="switch" lay-text="是|否">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否为精装业务</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="is_hardcover" checked lay-skin="switch" lay-text="是|否">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">房屋总套数</label>
              <div class="layui-input-block">
                <input name="house_num" value="" lay-verify="required|int" placeholder="请输入房屋总套数" autocomplete="off" class="layui-input" type="text">
              </div>  
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">项目地址</label>
            <div class="layui-input-block" id="area-select-box-1"></div>
            </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">详细地址</label>
            <div class="layui-input-block">
              <textarea name="address" lay-verify="required" placeholder="请输入项目地址" class="layui-textarea"></textarea>
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
          <div class="layui-row layui-col-space10">
            <div class="layui-col-lg4">
              <label class="layui-form-label">项目名称</label>
              <div class="layui-input-block">
                <input name="name" value="" lay-verify="required" placeholder="请输入项目名称" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">开盘时间</label>
              <div class="layui-input-block">
                <input type="text" name="disc_time" lay-verify="required" class="layui-input" id="disc_time_re">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">状态标记</label>
                <div class="layui-input-block">
                  <select name="label" lay-verify="required" lay-search="">
                    <option value=""></option>
                    <option value="暂定">暂定</option>
                    <option value="放弃">放弃</option>
                    <option value="暂停">暂停</option>
                    <option value="重要">重要</option>
                    <option value="已完成">已完成</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="layui-row layui-col-space10">
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否为房销业务</label>
              <div class="layui-input-block">
              <input type="checkbox" name="is_sales" checked lay-skin="switch" lay-text="是|否">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否为精装业务</label>
              <div class="layui-input-block">
              <input type="checkbox" name="is_hardcover" checked lay-skin="switch" lay-text="是|否">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">房屋总套数</label>
              <div class="layui-input-block">
                <input name="house_num" value="" lay-verify="required|int" placeholder="请输入房屋总套数" autocomplete="off" class="layui-input" type="text">
              </div>  
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">项目地址</label>
            <div class="layui-input-block" id="area-select-box-2"></div>
          </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">详细地址</label>
            <div class="layui-input-block">
              <textarea name="address" lay-verify="required" placeholder="请输入项目地址" class="layui-textarea"></textarea>
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
		  <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="项目名搜索" autocomplete="off">
      <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
      <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<button class="layui-btn" style="margin-left: 5px;">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增项目','.add',0.7,0.8)">新增项目</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="appointment">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="appointment">进入</a>
  </script>
  <script type="text/html" id="check">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="check">进入</a>
  </script>
  <script type="text/html" id="information">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="information">进入</a>
  </script>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('layui/city/JAreaData.js') }}"></script>
<script type="text/javascript" src="{{ asset('layui/city/JAreaSelect.js') }}"></script>
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
      ,url: '/developer/project'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '项目'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'name', title:'项目名称',fixed: 'left',unresize:true,width:130}
        ,{field:'re_address', title:'项目地址',unresize:true}
        ,{field:'is_sales_re', title:'是否为房销业务',unresize:true,width:130}
        ,{field:'is_hardcover_re', title:'是否为精装业务',unresize:true,width:130}
        ,{field:'house_num', title:'房屋总套数',unresize:true,width:110}
        ,{field:'created_at', title:'项目信息录入时间',unresize:true}
        ,{field:'label', title:'状态',unresize:true,width:110}
        ,{title:'项目联系人',unresize:true,toolbar:'#check',width:120}
        ,{title:'项目信息',unresize:true,toolbar:'#information',width:120}
        ,{title:'项目进度',unresize:true,toolbar:'#appointment',width:120}
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

    layui.code();
    var area1 = $("#area-select-box-1").JAreaSelect();
    var area2 = $("#area-select-box-2").JAreaSelect({prov: 0, city: 0, dist: 0});

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
      } else if(obj.event === 'edit'){
          $('.edit').find("input[name='name']").val(data.name);
		      $('.edit').find("input[name='disc_time']").val(data.disc_time);
          $('.edit').find("textarea[name='address']").val(data.address);
          $('.edit').find("input[name='id']").val(data.id);
          $('.edit').find("dd[lay-value='"+data.prov+"']").click();
          $('.edit').find("dd[lay-value='"+data.city+"']").click();
          $('.edit').find("dd[lay-value='"+data.dist+"']").click();
          $('.edit').find("dd[lay-value='"+data.label+"']").click();
          form.val('edit',{
            'house_num' :data.house_num,
            'is_sales' : data.is_sales,
            'is_hardcover' : data.is_hardcover
          });
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
      }else if(obj.event === 'check')
      {   
        openMax('项目联系人',"/developer/project/contacts?project_id="+data.id);
        // var name = $('#name').attr('val');
        // var page = tab.config.page.curr;
        // var limit = tab.config.page.limit;
        // window.location.href="/developer/project/contacts?project_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }else if(obj.event === 'information')
      {
        openMax('项目信息',"/developer/project/information?project_id="+data.id);
        // var name = $('#name').attr('val');
        // var page = tab.config.page.curr;
        // var limit = tab.config.page.limit;
        // window.location.href="/developer/project/information?project_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }else if(obj.event === 'appointment')
      {
        openMax('项目进度',"/developer/project/appointment?project_id="+data.id);
        // var name = $('#name').attr('val');
        // var page = tab.config.page.curr;
        // var limit = tab.config.page.limit;
        // window.location.href="/developer/project/appointment?project_id="+data.id+"&name="+name+"&page="+page+"&limit="+limit;
      }
    });

    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      if(data.province == '0' || data.city == '0' || data.dist == '0')
      {
        layMsgError('请选择地址');
        return false;
      }
      data.re_address = area1.getAreaString()+data.address;

      $.ajax({
        url : '{{ url("/developer/project-add") }}',
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
      console.log(data);
      if(data.province == '0' || data.city == '0' || data.dist == '0')
      {
        layMsgError('请选择地址');
        return false
      }
      console.log(data);
      data.re_address = area2.getAreaString()+data.address;
      $.ajax({
        url : '{{ url("/developer/project-edit") }}',
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