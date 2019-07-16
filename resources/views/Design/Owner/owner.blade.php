@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item">
            <label class="layui-form-label">选择业主</label>
              <div class="layui-input-block">
                <select name="user_id"  lay-verify="required" lay-search="">
                  <option value="">直接选择或搜索选择</option>
                  @foreach($user as $p)
                  <option value="{{ $p->id }}">{{ $p->username.' '.$p->phone }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">绑定房屋</label>
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
            <label class="layui-form-label">客户备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" placeholder="请输入精装修客户备注" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">合同金额</label>
            <div class="layui-input-block">
              <input name="total" value="" lay-verify="required|total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
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
          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">客户备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" placeholder="请输入精装修客户备注" class="layui-textarea"></textarea>
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">合同金额</label>
            <div class="layui-input-block">
              <input name="total" value="" lay-verify="required|total" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
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
		<div class="layui-input-inline">
		  <input class="layui-input" name="name" value="{{ isset($request['name'])?$request['name']:'' }}" val="{{ isset($request['name'])?$request['name']:'' }}" id="name" placeholder="姓名搜索" autocomplete="off">
		</div>
		<button class="layui-btn" style="margin-left: 5px;">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增业主','.add',0.5,0.6)">新增业主</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
  <script type="text/html" id="schedule">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="schedule">进入</a>
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
  }).use(['index', 'table','form','code','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/design/owner'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '业主'
      ,where:{name:$('#name').val(),_token:token}
      ,cols: [[
         {field:'user_id', title:'客户编号',fixed: 'left',unresize:true}
        ,{field:'username', title:'姓名',unresize:true}
        ,{field:'sex_name',title:'性别',unresize:true,unresize:true}
        ,{field:'phone', title:'手机',unresize:true}
        ,{field:'wechat_name', title:'微信号',unresize:true}
        ,{field:'remarks', title:'客户备注',unresize:true}
        ,{field:'total', title:'精装合同金额',unresize:true}
        ,{field:'money', title:'精装实付金额',unresize:true}
        ,{title:'精装跟进进度',unresize:true,toolbar: '#schedule'}
        ,{title:'装修需求',unresize:true,toolbar: '#demand'}
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
        layer.confirm('确定删除业主: '+data.username+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/design/owner-del") }}',
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
            "id" : data.id
            ,"remarks" : data.remarks
            ,'total':data.total
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
          })
      }else if(obj.event === 'schedule')
      {
        openMax(data.username+' - 跟进进度','/design/owner/schedule?user_id='+data.user_id,function(){
          tab.reload();
        });
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
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/design/owner-add") }}',
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
        url : '{{ url("/design/owner-edit") }}',
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
      },
      total : function(value)
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
      
    });
  });
  </script>
@endsection