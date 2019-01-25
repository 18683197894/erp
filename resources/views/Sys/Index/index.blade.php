

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ env('APP_NAME') }}</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/layui/css/layui.css') }}" media="all">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/admin.css') }}" media="all">
</head>
<style>
.ibox-content {
    clear: both;
}
.ibox-content {
    background-color: #ffffff;
    border-color: #e7eaec;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 0;
    color: inherit;
    padding: 15px 20px 20px;
    overflow: auto;
}
.text-center {
    text-align: center;
}
img.circle-border {
    border: 6px solid #FFF;
    border-radius: 50%;
}
#info p{
  line-height: 22px;
}
</style>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="http://www.jsjju.cn" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords="> 
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          
          <li class="layui-nav-item" lay-unselect>
            <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
              <i class="layui-icon layui-icon-notice"></i>  
              
              <!-- 如果有新消息，则显示小圆点 -->
              <span class="layui-badge-dot"></span>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite>{{ $user->username }}</cite>
            </a>
            <dl class="layui-nav-child">
              <dd><a lay-href="/user/personal">基本资料</a></dd>
              <dd><a lay-href="/user/personal-password">修改密码</a></dd>
              <hr>
              <dd style="text-align: center;"><a href="/login">退出</a></dd>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="/index/welcome-one">

            <span>
              <img class="layui-nav-img" style="float: left; width:35px;height:35px;margin:7px 0px 0px 22px " src="{{ asset('/uploads/default/images/logo.png') }}">
              <h3 style="padding-right: 18px;">{{ env('APP_NAME') }}</h3></span>
          </div>

          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            @foreach($menu as $v)
            <li class="layui-nav-item @if($v['title'] == '主页') layui-nav-itemed @endif">
              <a href="javascript:;" lay-tips="{{ $v['title'] }}" lay-direction="2">
                <i class="layui-icon {{ $v['lcon'] }}"></i>
                <cite>{{ $v['title'] }}</cite>
              </a>
              <dl class="layui-nav-child">
              @foreach($v['menus'] as $val)
                
                  @if($val['url'] == '#')
                  <dd>
                    <a href="javascript:;">{{ $val['title'] }}</a>
                    <dl class="layui-nav-child">
                      @foreach($val['menus'] as $value)
                      <dd><a lay-href="{{ $value['url'] }}">{{ $value['title'] }}</a></dd>
                      @endforeach
                    </dl>
                  </dd>
                  @else
                  <dd>
                    <a lay-href="{{ $val['url'] }}" @if($val['url'] == '/index/welcome-one') class="layui-this" @endif>{{ $val['title'] }}</a>
                  </dd>
                  @endif
                
              @endforeach
              </dl>
              
            </li>
            @endforeach

          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="/index/welcome-one" lay-attr="/index/welcome-one" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="/index/welcome-one" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

  <script src="{{ asset('/layui/layuiadmin/layui/layui.js') }}"></script>  
  <script src="{{ asset('/layui/layuiadmin/layui/custom.js') }}"></script>  
  <script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
  </script>
  <script type="text/javascript">
    function indexHerf(url)
    {
      window.location.href = url;
    }
  </script>
</body>
</html>


