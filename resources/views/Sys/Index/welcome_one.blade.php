@extends('public')

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
<!--        <div class="media-body">
          <a href="javascript:;" class="media-left" style="float: left;">
             <img src="../../layuiadmin/style/res/template/portrait.png" height="46px" width="46px">
          </a>
          <div class="pad-btm">
            <p class="fontColor"><a href="javascript:;">胡歌</a></p>
            <p class="min-font">
              <span class="layui-breadcrumb" lay-separator="-">
                <a href="javascript:;" class="layui-icon layui-icon-cellphone"></a>
                <a href="javascript:;">从移动</a>
                <a href="javascript:;">11分钟前</a>
              </span>
            </p>         
         </div>
          <p class="message-text">历经打磨，@索尼中国 再献新作品—OLED电视A8F完美诞生。很开心一起参加了A8F的“首映礼”！[鼓掌]正如我们演员对舞台的热爱，索尼对科技与艺术的追求才创造出了让人惊喜的作品。作为A1兄弟款，A8F沿袭了黑科技“屏幕发声技术”和高清画质，色彩的出众表现和高端音质，让人在体验的时候如同身临其境。A8F，这次的“视帝”要颁发给你！  索尼官网预售： O网页链接 索尼旗舰店预售：</p>
       </div> -->
    <!--    <div class="layui-row message-content-btn">
          <a href="javascript:;" class="layui-btn">更多</a>
       </div> -->
     </div>

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

      // flow.load({
      //   elem: '#test-flow-auto' //流加载容器
      //   ,done: function(page, next){ //执行下一页的回调
          
      //     //模拟数据插入
      //     setTimeout(function(){
      //       var lis = [];
      //       for(var i = 0; i < 8; i++){
      //         lis.push('<div style="width:100px;height:100px">'+ ( (page-1)*8 + i + 1 ) +'</div>')
      //       }
            
      //       //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
      //       //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
      //       next(lis.join(''), page < 10); //假设总页数为 10
      //     }, 500);
      //   }
      // });
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
@endsection