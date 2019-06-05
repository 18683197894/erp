@extends('public')

@section('css')

@endsection

@section('content')


  <div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
          <li class="layui-this">全部消息</li>
          <li><span class="letter">站内私信</span></li>
          <li><span class="notice">公司公告</span></li>
          <li><span class="sys">系统消息</span></li>
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
      Unread = function()
      { 
        // <span class="layui-badge">1</span>
        $.ajax('/app/message-unread',{
        type : 'post',
        data : {_token:token},
        success : function(res)
        { 
          var res = $.parseJSON(res);

            if(res.data.letter > 0)
            { 
              $('.letter_re').remove();
              $('.letter').after('<span class="layui-badge letter_re">'+res.data.letter+'</span>');
            }else
            {
              $('.letter_re').remove();
            }
            if(res.data.notice > 0)
            { 
              $('.notice_re').remove();
              $('.notice').after('<span class="layui-badge notice_re">'+res.data.notice+'</span>');
            }else
            {
              $('.notice_re').remove();
            }
            if(res.data.sys > 0)
            { 
              $('.sys_re').remove();
              $('.sys').after('<span class="layui-badge sys_re">'+res.data.sys+'</span>');
            }else
            {
              $('.sys_re').remove();
            }

        },
        error:function(error)
        {
          $('.letter_re').remove();
          $('.notice_re').remove();
          $('.sys').remove();
        }
      }) 
      }
      Unread();
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
          ,{field: 'username', title: '发件人', width: 90}
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
        ,where:{_token:$("meta[name='csrf-token']").attr('content'),type:1}
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
        ,where:{_token:$("meta[name='csrf-token']").attr('content'),type:2}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'title', title: '主题', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(parseInt(d.msg_created_at+'000'),'30');
          }}
        ]]
        ,skin: 'line'
      });

      //系统
     table.render({
        elem: '#LAY-app-message-sys'
        ,url: '{{ url("/app/message") }}' //模拟接口
        ,method : 'post'
        ,where:{_token:$("meta[name='csrf-token']").attr('content'),type:3}
        ,page: true
        ,cols: [[
          {type: 'checkbox', fixed: 'left'}
          ,{field: 'title', title: '主题', minWidth: 300, templet: tplTitle}
          ,{field: 'time', title: '时间', width: 170, templet: function(d){
            return layui.util.timeAgo(parseInt(d.msg_created_at+'000'),'30');
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
      var arr=[];
      layer.confirm('确定删除选中的数据吗？', function(){
      $.each(data,function(index, el) {
          arr.push(el.id);
      });
      $.ajax('/app/message-edit',{
        type : 'post',
        data : {_token:token,type:'public',class:'Del',data:arr},
        success : function(res)
        {
          var res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.msg('操作成功', {
              icon: 1
              ,time:1500
            },function(){
              table.reload('LAY-app-message-all');
              table.reload('LAY-app-message-letter');
              table.reload('LAY-app-message-notice');
              table.reload('LAY-app-message-sys');
              Unread();
            });
          }else
          {
            layMsgError('操作失败');
          }

        },
        error:function(error)
        {

        }
      })  
      });
    }
    ,ready: function(othis, type){
      var thisTabs = tabs[type]
      ,checkStatus = table.checkStatus(thisTabs.id)
      ,data = checkStatus.data; //获得选中的数据
      if(data.length === 0) return layer.msg('未选中行');
      var arr=[];
      $.each(data,function(index, el) {
          arr.push(el.id);
      });
      $.ajax('/app/message-edit',{
        type : 'post',
        data : {_token:token,type:'public',class:'Read',data:arr},
        success : function(res)
        {
          var res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.msg('操作成功', {
              icon: 1
              ,time:1500
            },function(){
              table.reload('LAY-app-message-all');
              table.reload('LAY-app-message-letter');
              table.reload('LAY-app-message-notice');
              table.reload('LAY-app-message-sys');
              Unread();
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
            layer.msg('操作成功', {
              icon: 1
              ,time:1500
            },function(){
              table.reload('LAY-app-message-all');
              table.reload('LAY-app-message-letter');
              table.reload('LAY-app-message-notice');
              table.reload('LAY-app-message-sys');
              Unread();
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
