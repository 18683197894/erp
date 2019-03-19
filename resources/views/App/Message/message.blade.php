@extends('public')

@section('css')

@endsection

@section('content')


  <div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
          <li class="layui-this">全部消息</li>
          <li>站内私信<span class="layui-badge">6</span></li>
          <li>公司公告</li>
          <li>系统消息</li>
        </ul>
        <div class="layui-tab-content">
        
          <div class="layui-tab-item layui-show">
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-all" lay-filter="LAY-app-message-all"></table>
          </div>
          <div class="layui-tab-item">
          
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="letter" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="letter" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="letter" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-letter" lay-filter="LAY-app-message-letter"></table>
          </div>
          <div class="layui-tab-item">
          
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-notice" lay-filter="LAY-app-message-notice"></table>
          </div>
          <div class="layui-tab-item">
          
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="sys" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="sys" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="sys" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-sys" lay-filter="LAY-app-message-sys"></table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
 <script src="{{ asset('/layui/layuiadmin/layui/layui.js') }}"></script>   
  <script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table', 'util'],function(){
      var $ = layui.$
      ,admin = layui.admin
      ,table = layui.table
      ,element = layui.element;
      token = $("meta[name='csrf-token']").attr('content');
      var DISABLED = 'layui-btn-disabled'

      //区分各选项卡中的表格
      ,tabs = {
        all: {
          text: '全部消息'
          ,id: 'LAY-app-message-all'
        }
        ,letter: {
          text: '站内私信'
          ,id: 'LAY-app-message-letter'
        }
        ,notice: {
          text: '公司公告'
          ,id: 'LAY-app-message-notice'
        }
        ,sys: {
          text: '系统消息'
          ,id: 'LAY-app-message-sys'
        }
      };

      //标题内容模板
      var tplTitle = function(d){
        if(d.is_read == 0)
        {
          return '<a href="/app/message-detail?id='+ d.id +'" style="color:#000;font-weight:800">'+ d.title;
        }else
        {
          return '<a href="/app/message-detail?id='+ d.id +'">'+ d.title;
        }
      };

      //全部消息
      table.render({
        elem: '#LAY-app-message-all'
        ,url: '{{ url("/app/message") }}' //模拟接口
        ,method : 'post'
        ,where:{_token:token,type:0}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'username', title: '发件人', width: 80}
          ,{field: 'title', title: '主题', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(parseInt(d.msg_created_at+'000'),'30');
          }}
        ]]
        ,skin: 'line'
      });

      //私信
      table.render({
        elem: '#LAY-app-message-letter'
        ,url: '{{ url("/app/message") }}' //模拟接口
        ,method : 'post'
        ,where:{_token:token,type:1}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'username', title: '发件人', width: 80}
          ,{field: 'title', title: '主题', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(parseInt(d.msg_created_at+'000'),'30');
          }}
        ]]
        ,skin: 'line'
      });

      //通知
      table.render({
        elem: '#LAY-app-message-notice'
        ,url: '{{ url("/app/message") }}' //模拟接口
        ,method : 'post'
        ,where:{_token:token,type:2}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'title', title: '主题', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(1562025210);
          }}
        ]]
        ,skin: 'line'
      });

      //系统
      table.render({
        elem: '#LAY-app-message-sys'
        ,url: '{{ url("/app/message") }}' //模拟接口
        ,method : 'post'
        ,where:{_token:token,type:3}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'title', title: '标题内容', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(d.msg_created_at);
          }}
        ]]
        ,skin: 'line'
      });
  //事件处理
  var events = {
    del: function(othis, type){
      var thisTabs = tabs[type]
      ,checkStatus = table.checkStatus(thisTabs.id)
      ,data = checkStatus.data; //获得选中的数据
      if(data.length === 0) return layer.msg('未选中行');

      layer.confirm('确定删除选中的数据吗？', function(){
        /*
        admin.req('url', {}, function(){ //请求接口
          //do somethin
        });
        */
        //此处只是演示，实际应用需把下述代码放入上述Ajax回调中
        layer.msg('删除成功', {
          icon: 1
        });
        table.reload(thisTabs.id); //刷新表格
      });
    }
    ,ready: function(othis, type){
      var thisTabs = tabs[type]
      ,checkStatus = table.checkStatus(thisTabs.id)
      ,data = checkStatus.data; //获得选中的数据
      if(data.length === 0) return layer.msg('未选中行');
      
      //此处只是演示
      layer.msg('标记已读成功', {
        icon: 1
      });
      table.reload(thisTabs.id); //刷新表格
    }
    ,readyAll: function(othis, type){
      var thisTabs = tabs[type];
      
      $.ajax('/app/message-edit',{
        type : 'post',
        data : {_token:token,type:type,class:'allRead'},
        success : function(res)
        {
          var res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.msg(thisTabs.text + '：全部已读', {
              icon: 1
              ,time:1500
            },function(){
              table.reload(thisTabs.id);
            });
          }else
          {
            layMsgError('操作失败');
          }

        },
        error:function(error)
        {
          layMsgError('操作失败');
        }
      })  

    }
  };
  
  $('.LAY-app-message-btns .layui-btn').on('click', function(){
    var othis = $(this)
    ,thisEvent = othis.data('events')
    ,type = othis.data('type');
    events[thisEvent] && events[thisEvent].call(this, othis, type);
  });
  });
  </script>
@endsection
