<!-- @extends('public')

@section('css')
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/template.css') }}" media="all">
@endsection

@section('content')
<div class="layui-fluid layadmin-message-fluid">
  <div class="layui-row">
    <div class="layui-col-md12">
      <form class="layui-form">
        <div class="layui-form-item layui-form-text">
          <div class="layui-input-block">
            <textarea id="demo" class="layui-textarea" style="display: none;"></textarea>
          </div>
        </div>

        <div class="layui-form-item" style="overflow: hidden;">
          <div class="layui-input-block layui-input-right">
            <button class="layui-btn" lay-submit lay-filter="formDemo">发表</button>
          </div>
        </div>
      </form>
    </div>
    <div class="layui-col-md12 layadmin-homepage-list-imgtxt message-content">
       <div class="flow-default" id="test-flow-auto" style="margin-bottom: 0px;"></div>

     </div>

    </div>
  </div>
@endsection

@section('js')
<script type="text/javascript">
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form','layedit','flow'], function(){
      form = layui.form;
      layedit = layui.layedit;
      $ = layui.jquery;
      flow = layui.flow;
      token = $("meta[name='csrf-token']").attr('content');


      flow.load({
        elem: '#test-flow-auto' //指定列表容器
        ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
          var lis = [];
          //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
          $.post('/message/liuyan?page='+page+'&_token='+token, function(res){
            //假设你的列表返回在data集合中
            res = $.parseJSON(res);
            layui.each(res.data, function(index, item){
              lis.push(
                "<div class='media-body'><a href='javascript:;' class='media-left' style='float: left;'><img src='"+item.user.head_portrait+"' height='46px' width='46px'></a><div class='pad-btm'><p class='fontColor'><a href='javascript:;'>"+item.user.username+"</a></p><p class='min-font'><span class='layui-breadcrumb' lay-separator='-' style='visibility: visible'><a href='javascript:;'>"+item.time+"</a></span></p></div><p class='message-text'>"+item.content+"</p></div>"
                );
            }); 
            
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(lis.join(''), page < res.pages);    
          });
        }
      });

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
      if(!layedit.getText(message)) return false;
      $.ajax({
        'url' : '{{url("/message/liuyan-add")}}',
        'type' : 'post',
        'data' : {content:content,_token:token},
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layedit.setContent(message,'');
            $('#test-flow-auto').prepend("<div class='media-body'><a href='javascript:;' class='media-left' style='float: left;'><img src='"+res.data.user.head_portrait+"' height='46px' width='46px'></a><div class='pad-btm'><p class='fontColor'><a href='javascript:;'>"+res.data.user.username+"</a></p><p class='min-font'><span class='layui-breadcrumb' lay-separator='-' style='visibility: visible'><a href='javascript:;'>刚刚</a></span></p></div><p class='message-text'>"+res.data.content+"</p></div>");
            layMsgOk(res.msg);
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('留言失败');
        }
      })


      return false;
    });
  })
</script>
@endsection -->