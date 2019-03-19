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
          <div class="layui-col-md6">
            <div class="layui-form-item">
              <label class="layui-form-label">时间</label>
              <div class="layui-input-block">
                <input type="text" name="time" lay-verify="required" class="layui-input" id="start">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">地点</label>
              <div class="layui-input-block">
                <input name="address" value="" lay-verify="required" placeholder="请输入地点" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">参与人员</label>
              <div class="layui-input-block">
                <input name="participant" value="" lay-verify="required" placeholder="请输入参与人员" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">洽谈对象</label>
              <div class="layui-input-block">
                <input name="visitingobj" value="" lay-verify="required" placeholder="请输入洽谈对象" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">当前进度</label>
              <div class="layui-input-block">
                <input name="schedule" value="" lay-verify="required" placeholder="请输入当前进度" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item">
            <label class="layui-form-label">负责人</label>
            <div class="layui-input-block">
              <select name="user_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($user as $c)
                <option value="{{ $c->id }}">{{ $c->username }}</option>
                @endforeach
              </select>
            </div>
            </div>
            <div class="layui-col-md6">
              <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
                <div class="layui-card-header">是否接触高层</div>
                <div class="layui-card-body layui-row layui-col-space10">
                  <div class="layui-col-md12">
                    <input type="checkbox" name="contact_senior" lay-skin="switch" lay-text="是|否" checked>
                  </div>
                </div>
              </div>
            </div>
            <div class="layui-col-md6">
              <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
                <div class="layui-card-header">是否提前预约</div>
                <div class="layui-card-body layui-row layui-col-space10">
                  <div class="layui-col-md12">
                    <input type="checkbox" name="advance" lay-skin="switch" lay-text="是|否" checked>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="layui-col-md6" style="padding-left:15px;">
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">准备情况</label>
              <div class="layui-input-block">
                <textarea name="preparation" placeholder="请输入准备情况" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">预计效果</label>
              <div class="layui-input-block">
                <textarea name="expected" placeholder="请输入预计效果" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">备注</label>
              <div class="layui-input-block">
                <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
              <div class="layui-form-item ">
                <div class="layui-input-block">
                  <div class="layui-footer">
                    <button class="layui-btn" style="margin-top: 10px;" lay-submit="" lay-filter="add">立即提交</button>
                  </div>
                </div>
              </div> 
          </div>
  </form>
</div>

<div class="layui-card edit" style="display:none">
        <form class="layui-form layui-form-pane" id="edit"  style="margin: 15px;" lay-filter="component-form-group">
          <div class="layui-col-md6">
            <div class="layui-form-item">
              <input type="hidden" name="id" value="">
              <label class="layui-form-label">时间</label>
              <div class="layui-input-block">
                <input type="text" name="time" lay-verify="required" class="layui-input" id="re_start">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">地点</label>
              <div class="layui-input-block">
                <input name="address" value="" lay-verify="required" placeholder="请输入地点" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">参与人员</label>
              <div class="layui-input-block">
                <input name="participant" value="" lay-verify="required" placeholder="请输入参与人员" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">洽谈对象</label>
              <div class="layui-input-block">
                <input name="visitingobj" value="" lay-verify="required" placeholder="请输入洽谈对象" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">当前进度</label>
              <div class="layui-input-block">
                <input name="schedule" value="" lay-verify="required" placeholder="请输入当前进度" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item">
            <label class="layui-form-label">负责人</label>
            <div class="layui-input-block">
              <select name="user_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($user as $c)
                <option value="{{ $c->id }}">{{ $c->username }}</option>
                @endforeach
              </select>
            </div>
            </div>
            <div class="layui-col-md6">
            <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
              <div class="layui-card-header">是否接触高层</div>
              <div class="layui-card-body layui-row layui-col-space10">
                <div class="layui-col-md12">
                  <input type="checkbox" name="contact_senior" lay-skin="switch" lay-text="是|否" checked>
                </div>
              </div>
            </div>
            </div>
            <div class="layui-col-md6">
            <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
              <div class="layui-card-header">是否提前预约</div>
              <div class="layui-card-body layui-row layui-col-space10">
                <div class="layui-col-md12">
                  <input type="checkbox" name="advance" lay-skin="switch" lay-text="是|否" checked>
                </div>
              </div>
            </div>
            </div>

          </div>

          <div class="layui-col-md6" style="padding-left:15px;">
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">准备情况</label>
              <div class="layui-input-block">
                <textarea name="preparation" placeholder="请输入准备情况" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">预计效果</label>
              <div class="layui-input-block">
                <textarea name="expected" placeholder="请输入预计效果" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">备注</label>
              <div class="layui-input-block">
                <textarea name="remarks" placeholder="请输入备注" class="layui-textarea"></textarea>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
              <div class="layui-form-item ">
                  <div class="layui-footer">
                    <button class="layui-btn" style="margin-top: 10px;" lay-submit="" lay-filter="edit">立即提交</button>
                  </div>
              </div> 
          </div>
      </form>
</div>
<div class="layui-card feedback_add" style="display:none">
        <form class="layui-form layui-form-pane" id="feedback_add"  style="margin: 15px;" lay-filter="feedback_add">
          <input type="hidden" name="appointment_id" value="">
          <input type="hidden" name="id" value="">
          <div class="layui-col-md6">
            <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
              <div class="layui-card-header">是否需要更高岗位介入</div>
              <div class="layui-card-body layui-row layui-col-space10">
                <div class="layui-col-md12">
                  <input type="checkbox" name="higher_post" lay-skin="switch" lay-text="是|否" checked>
                </div>
              </div>
            </div>
            <div class="layui-card layui-form layui-form-text" lay-filter="component-form-element">
              <div class="layui-card-header">是否需要团队介入</div>
              <div class="layui-card-body layui-row layui-col-space10">
                <div class="layui-col-md12">
                  <input type="checkbox" name="higher_team" lay-skin="switch" lay-text="是|否" checked>
                </div>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">洽谈结果</label>
              <div class="layui-input-block">
                <textarea name="now_result"  placeholder="请输入洽谈结果" lay-verify="required" class="layui-textarea"></textarea>
              </div>
            </div>
          </div>

          <div class="layui-col-md6" style="padding-left:15px;">
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">其他帮助支持</label>
              <div class="layui-input-block">
                <textarea name="other_support" placeholder="请输入其他帮助支持" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">下阶段攻坚重点</label>
              <div class="layui-input-block">
                <textarea name="next_stage" placeholder="请输入下阶段攻坚重点" class="layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text" >
              <label class="layui-form-label">此项目建议</label>
              <div class="layui-input-block">
                <textarea name="project_proposal" placeholder="请输入此项目建议" class="layui-textarea"></textarea>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
              <div class="layui-form-item ">
                <div class="layui-input-block">
                  <div class="layui-footer">
                    <button class="layui-btn" lay-submit="" lay-filter="feedback_add">立即提交</button>
                  </div>
                </div>
              </div> 
          </div>
      </form>
    
</div>
<div class="layui-card feedback_check" style="display:none">
      <div class="layui-row">
        <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-body">
            <div class="layui-form-pane" lay-filter="component-panel">
              <div class="layui-form-item layui-form-text" >
                <label class="layui-form-label">是否需要更高岗位介入</label>
                <div class="layui-input-block">
                  <input name="higher_post" value="" disabled lay-verify="required" autocomplete="off" class="layui-input" type="text">
                </div>
              </div>
              <div class="layui-form-item layui-form-text" >
                <label class="layui-form-label">是否需要团队介入</label>
                <div class="layui-input-block">
                  <input name="higher_team" value="" disabled lay-verify="required" autocomplete="off" class="layui-input" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="layui-card-body" style="padding-bottom: 30px;">
            <div class="layui-collapse" lay-filter="component-panel">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">洽谈结果</h2>
                <div class="layui-colla-content layui-show now_result">
                  <p></p>
                </div>
              </div>
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">其他帮助支持</h2>
                <div class="layui-colla-content layui-show other_support">
                  <p></p>
                </div>
              </div>
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">下阶段攻坚重点</h2>
                <div class="layui-colla-content layui-show next_stage">
                  <p></p>
                </div>
              </div>
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">此项目建议</h2>
                <div class="layui-colla-content layui-show project_proposal">
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
      <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">

	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增进度','.add',0.8,0.9)">新增进度</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
    <a class='layui-btn layui-btn-xs  layui-btn-normal' lay-event='feedback'>反馈</a>
	</script>
<!--       <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
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
      ,url: '/developer/project/appointment'
      ,where:{_token:token,project_id:$('#project_id').val()}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预约拜访'
      ,cols: [[
         // {type: 'checkbox', fixed: 'left'}
        {field:'schedule', title:'当前阶段',fixed: 'left',unresize:true,width:110}
        ,{field:'time', title:'拜访时间',unresize:true,width:110}
        ,{field:'address', title:'拜访地点',unresize:true}
        ,{field:'participant', title:'参与人员',unresize:true}
        // ,{field:'visitingobj', title:'拜访对象',unresize:true}
        ,{field:'contact_seniors', title:'接触高层',unresize:true,width:100}
        ,{field:'advances', title:'提前预约',unresize:true,width:90}
        ,{field:'expected', title:'预计效果',unresize:true}
        ,{field:'username', title:'项目负责人',unresize:true}
        ,{field:'remarks', title:'备注',unresize:true}
        // ,{field:'remarks', title:'更高职位介入',unresize:true}
        // ,{field:'remarks', title:'团队介入',unresize:true}
        // ,{field:'remarks', title:'其他帮助支持',unresize:true}
        ,{field:'remarks', title:'项目建议',unresize:true}
        // ,{field:'preparation', title:'准备情况',unresize:true}
        // ,{title:'反馈',unresize:true,templet:function(d){
        //   if(d.feedback !== null)
        //   {
        //     return "<a class='layui-btn layui-btn-xs  layui-btn-normal' lay-event='check'>查看</a>";

        //   }else
        //   {
        //     return "<a class='layui-btn layui-btn-xs  layui-btn-normal' lay-event='feedback'>反馈</a>";
        //   }
        // }}
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
    laydate.render({
      elem: '#start' //指定元素
    });
    laydate.render({
      elem: '#re_start' //指定元素
    });
    // $('.demoTable .layui-btn').on('click',function(){
    // 	name = $('#name').val();
    // 	tab.reload({where:{name:name,_token:token,project_id:$('#project_id').val()},page:{curr:1}});
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
        layer.confirm('确定删除: '+data.schedule+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/developer/project/appointment-del") }}',
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
          if(data.contact_senior == 1)
          {
            $('.edit').find("input[name='contact_senior']").attr('checked','');

          }else
          {
            $('.edit').find("input[name='contact_senior']").removeAttr('checked');
          }
          if(data.advance == 1)
          {
            $('.edit').find("input[name='advance']").attr('checked','');

          }else
          {
            $('.edit').find("input[name='advance']").removeAttr('checked');
          }
    			$('.edit').find("input[name='time']").val(data.time);
    			$('.edit').find("input[name='address']").val(data.address);
          $('.edit').find("input[name='participant']").val(data.participant);
          $('.edit').find("input[name='visitingobj']").val(data.visitingobj);
    			$('.edit').find("input[name='schedule']").val(data.schedule);
    			$('.edit').find("textarea[name='preparation']").val(data.preparation);
    			$('.edit').find("textarea[name='expected']").val(data.expected);
    			$('.edit').find("textarea[name='remarks']").val(data.remarks);
    			$('.edit').find("input[name='id']").val(data.id);
          $('.edit').find('dd[lay-value="'+data.user.id+'"]').click();
    			var width = ($(window).width() * 0.8)+'px';
    			var height = ($(window).height() * 0.9)+'px';
    			edit = layer.open({
      			type : 1,
      			title : '编辑进度',
      			fix: false, //不固定
      			maxmin: true,
      			shadeClose: true,
      			shade: 0.4,
      			area : [width,height],
      			content : $('.edit')
    			})
      }else if(obj.event === 'feedback')
      {
          document.getElementById("feedback_add").reset();
          $('.feedback_add').find("input[name='appointment_id']").val(data.id);
          if(data.feedback)
          { 
            console.log(data.feedback);
            form.val('feedback_add',{
              'id' : data.feedback.id,
              'higher_post':data.feedback.higher_post,
              'higher_team':data.feedback.higher_team,
              'now_result':data.feedback.now_result,
              'other_support':data.feedback.other_support,
              'next_stage':data.feedback.next_stage,
              'project_proposal':data.feedback.project_proposal
            });
          }else
          {
            form.val('feedback_add',{
              'id':'',
              'higher_post':0,
              'higher_team':0,
              'now_result':'',
              'other_support':'',
              'next_stage':'',
              'project_proposal':''
            });
          }

          var width = ($(window).width() * 0.8)+'px';
          var height = ($(window).height() * 0.9)+'px';
          feedback_edit = layer.open({
            type : 1,
            title : '反馈结果',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.feedback_add')
          })
      }else if(obj.event === 'check')
      {
          var width = ($(window).width() * 0.7)+'px';
          var height = ($(window).height() * 0.9)+'px';
          if(data.feedback.higher_post == 1)
          {
            $('.feedback_check').find('input[name="higher_post"]').val('是');
          }else
          {
            $('.feedback_check').find('input[name="higher_post"]').val('否');
          }
          if(data.feedback.higher_team == 1)
          {
            $('.feedback_check').find('input[name="higher_team"]').val('是');
          }else
          {
            $('.feedback_check').find('input[name="higher_team"]').val('否');
          }
          $('.feedback_check').find('.now_result').find('p').html('');
          $('.feedback_check').find('.now_result').find('p').html(data.feedback.now_result);
          $('.feedback_check').find('.other_support').find('p').html('');
          $('.feedback_check').find('.other_support').find('p').html(data.feedback.now_result);
          $('.feedback_check').find('.next_stage').find('p').html('');
          $('.feedback_check').find('.next_stage').find('p').html(data.feedback.next_stage);
          $('.feedback_check').find('.project_proposal').find('p').html('');
          $('.feedback_check').find('.project_proposal').find('p').html(data.feedback.project_proposal);
          feedback_check = layer.open({
            type : 1,
            title : '查看反馈结果',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.feedback_check')
          })
      }
    });
    form.on('submit(feedback_add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/developer/project/feedback-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(feedback_edit);
            layMsgOk(res.msg);
            $('#name').val('');
            tab.reload({
              where : {_token:token,project_id:$('#project_id').val()},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('反馈失败');
        }
      })
      return false;
    })
    form.on('submit(add)',function(data){
      data = data.field;
      data._token = token;
      data.project_id = $('#project_id').val();
      $.ajax({
        url : '{{ url("/developer/project/appointment-add") }}',
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
              where : {_token:token,project_id:$('#project_id').val()},
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
        url : '{{ url("/developer/project/appointment-edit") }}',
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

