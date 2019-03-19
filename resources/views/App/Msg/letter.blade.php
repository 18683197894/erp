@extends('public')

@section('css')
 <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/template.css') }}" media="all">
@endsection

@section('content')
<div class="layui-fluid layadmin-message-fluid">
  <div class="layui-row">
      <form class="layui-form" lay-filter="formDemo" style="padding:0px">
        
        <div class="layui-form-item">
	        <label class="layui-form-label">主题</label>
	        <div class="layui-input-block">
	            <input type="text" id="title" name="title"  lay-verify="required"
	            autocomplete="off" class="layui-input">
	        </div>
    	</div>
		
		<div class="layui-form-item layui-form-text">
		  <div class="layui-input-block">
		    <textarea id="demo" class="layui-textarea"  style="display: none;"></textarea>
		  </div>
		</div>
		<!-- <div class="layui-form-item" style="overflow: hidden;"> -->
		<div class="layui-form-item">
			<label class="layui-form-label">收件人</label>
			<div class="layui-input-block layui-col-md12">
				<select name="user_id" lay-search="" lay-verify="required">
					<option value="">直接选择或搜索选择</option>
					@foreach($users as $val)
					@if(\session('user')['id'] !== $val->id)
					<option value="{{ $val->id }}">{{ $val->username }}</option>
					@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="layui-input-block layui-input-right">
		<button class="layui-btn" lay-submit lay-filter="formDemo">发表</button>
		</div>
    </form>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form','layedit','flow','layer'], function(){
      form = layui.form;
      layedit = layui.layedit;
      $ = layui.jquery;
      layer = layui.layer;
      flow = layui.flow;
      token = $("meta[name='csrf-token']").attr('content');
      message = layedit.build('demo',{
      height: 200,
      tool: [
        'strong' //加粗
        ,'italic' //斜体
        ,'underline' //下划线
        ,'del' //删除线
        
        ,'|' //分割线
        
        ,'left' //左对齐
        ,'center' //居中对齐
        ,'right' //右对齐
        ,'link' //超链接
        ,'unlink' //清除链接
        ,'face' //表情
        // ,'image' //插入图片
        // ,'help' //帮助
      ]
    }); //建立编辑器

    form.on('submit(formDemo)', function(data){
      var content = layedit.getContent(message);
      var user_id = data.field.user_id;
      var title = data.field.title;
      if(isnull(content)){
      	layMsgError('请输入信件内容');
      	return false;
      } 
      layer.msg('正在发送',{icon:16,time:1000,shade:0.2},function(){
		$.ajax({
			'url' : '{{url("/app/msg_letter")}}',
			'type' : 'post',
			'data' : {content:content,_token:token,user_id:user_id,title:title},
			success : function(res)
			{
				res = $.parseJSON(res);
				if(res.code == 200)
				{	
					form.val('formDemo',{
						'title':'',
						'user_id':''
					});
					layedit.setContent(message,'');
					layMsgOk(res.msg);
				}else
				{
					layMsgError(res.msg);
				}
			},
			error : function(error)
			{
				layMsgError('发送失败');
			}
		});
      });

	  return false;
    });

	isnull = function (val) {
    	var str = val.replace(/(^\s*)|(\s*$)/g, '');//去除空格;
	    if (str == '' || str == undefined || str == null) {
	        return true;
	    } else {
	        return false;
	    }
   	}
})
</script>
@endsection
