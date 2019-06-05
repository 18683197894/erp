

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<body layadmin-themealias="default" id="test">
<div class="layui-fluid  Juzhong">
    <img src="{{ asset('/logo.png') }}" alt="" class="logo"/>
</div>


<style>
    body{
        background-color: #ffffff;
        height:calc(100vh  - 90px); ;
    }
    .Juzhong{
        position: relative;
        height: 100%;
    }
    .logo{
        display: block;
        position: absolute;
        top:calc(50% - 130px);
        left:calc(50% - 140px);
    }
</style>
<script>
    autoDivSize();
    function autoDivSize(){
        if (window.innerWidth){
            winWidth = window.innerWidth;
            console.log(winWidth+','+"oneW");
        }
        else if ((document.body) && (document.body.clientWidth)){
            winWidth = document.body.clientWidth;
            console.log(winWidth+','+"twoW");
        }
        // 获取窗口高度
        if (window.innerHeight){
            winHeight = window.innerHeight;
            console.log(winHeight+','+"oneH");
        }
        else if ((document.body) && (document.body.clientHeight)){
            winHeight = document.body.clientHeight;
            console.log(winHeight+','+"oneH");
        }
        // 通过深入 Document 内部对 body 进行检测，获取窗口大小
        if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth)
        {
            winHeight = document.documentElement.clientHeight;
            winWidth = document.documentElement.clientWidth;
            console.log(winHeight+','+winWidth);
        }
        //DIV高度为浏览器窗口高度 的60%
        document.getElementById("test").style.height= winHeight-90+"px";
    }
    window.onresize=autoDivSize; //浏览器窗口发生变化时同时变化DIV高度
</script>
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
  <script type="text/javascript">
      $.ajax('/app/message-unread',{
        type : 'post',
        data : {_token:'{{ csrf_token() }}'},
        success : function(res)
        { 
            var res = $.parseJSON(res);

            if(res.data.letter > 0 || res.data.notice > 0 || res.data.sys > 0)
            { 
              $("#Uiunread",window.parent.document).remove();
              $("#Fuunread",window.parent.document).append('<span id="Uiunread" class="layui-badge-dot"></span>');
            }else
            {
              $("#Uiunread",window.parent.document).remove();
            }

        },
        error:function(error)
        {
          $("#Uiunread",window.parent.document).remove();
        }
      }) 
  </script>
</body>
</html>
