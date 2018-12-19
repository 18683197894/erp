<script type="text/javascript">
    @if(!empty(session('error')) && session('error') == '此账号已在别处登录' || session('error') == '此账号已被禁用')
    alert("{{ session('error') }}");
    parent.indexHerf('/login');
    @else
      parent.indexHerf('/login');
    @endif

</script>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>登入</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/layui/css/layui.css') }}" media="all">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/admin.css') }}" media="all">
  <link rel="stylesheet" href="{{ asset('/layui/layuiadmin/style/login.css') }}" media="all">
</head>
<body>

  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h1>建商集团</h1>
        <!-- <p>建商网络</p> --><br>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          @csrf
          <input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
              <input type="text" name="captcha" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
            </div>
            <div class="layui-col-xs5">
              <div style="margin-left: 10px;">
                <img class="captcha" src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()">
                <!-- <img src="https://www.oschina.net/action/user/captcha" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode"> -->
              </div>
            </div>
          </div>
        </div>
<!--         <div class="layui-form-item" style="margin-bottom: 20px;">
          <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
          <a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
        </div> -->
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">登 入</button>
        </div>
<!--         <div class="layui-trans layui-form-item layadmin-user-login-other">
          <label>社交账号登入</label>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>
          
          <a href="reg.html" class="layadmin-user-jump-change layadmin-link">注册帐号</a>
        </div> -->
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      
      <p>© 2018 <a href="javascript:;">建商网络科技</a></p>
      <p>
        <!-- <span><a href="http://www.layui.com/admin/#get" target="_blank">获取授权</a></span> -->
        <!-- <span><a href="http://www.layui.com/admin/pro/" target="_blank">在线演示</a></span> -->
        <span><a href="http://www.jianshanglianmeng.com" target="_blank">前往官网</a></span>
      </p>
    </div>
    

    
  </div>

  <script src="{{ asset('/layui/layuiadmin/layui/layui.js') }}"></script>  
  <script src="{{ asset('/layui/layuiadmin/layui/custom.js') }}"></script>  
  <script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'user'], function(){
    var $ = layui.$
    ,setter = layui.setter
    ,admin = layui.admin
    ,form = layui.form
    ,router = layui.router()
    ,search = router.search;

    form.render();

    //提交
    form.on('submit(LAY-user-login-submit)', function(data){

    // console.log(data);
    // return false;
      //请求登入接口
      $.ajax({
        url: "{{ url('/dologin') }}",
        type : 'post',
        data: data.field,
        success: function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          {
              layer.msg(res.msg, {offset: '15px',icon: 1,time: 1000}, function(){
                location.href = '{{ url("/") }}';
              });
          }else
          { 
            $('.captcha').click();
            layMsgError(res.msg);
          }
          // //请求成功后，写入 access_token
          // layui.data(setter.tableName, {
          //   key: setter.request.tokenName
          //   ,value: res.data.access_token
          // });
          
          //登入成功的提示与跳转
          // layer.msg('登入成功', {
          //   offset: '15px'
          //   ,icon: 1
          //   ,time: 1000
          // }, function(){
          //   location.href = '../'; //后台主页
          // });
        },
        error : function(error)
        { 
          $('.captcha').click();
          if(error.status == 422)
          {
            layMsgError(error.responseJSON.errors.captcha[0]);
          }else
          {
            layMsgError('登陆失败 请联系管理员');
          }
        }

      });
      
    });
    
  });
  </script>
</body>
</html>