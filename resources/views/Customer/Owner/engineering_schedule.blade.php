@extends('public')

@section('css')
    <script type="text/javascript" charset="utf-8" src="{{ asset('/UEditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('/UEditor/ueditor.all.js') }}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{ asset('/UEditor/lang/zh-cn/zh-cn.js') }}"></script>
<style type="text/css">
#file_name{
background-color: rgb(255, 255, 255);
border-bottom-color: rgb(210, 210, 210);
border-bottom-left-radius: 2px;
border-bottom-right-radius: 2px;
border-bottom-style: solid;
border-bottom-width: 0.883333px;
border-left-color: rgb(210, 210, 210);
border-left-style: solid;
border-left-width: 0.883333px;
border-right-color: rgb(210, 210, 210);
border-right-style: solid;
border-right-width: 0.883333px;
border-top-color: rgb(210, 210, 210);
border-top-left-radius: 2px;
border-top-right-radius: 2px;
border-top-style: solid;
border-top-width: 0.883333px;
box-sizing: border-box;
display: block;
font-family: "Microsoft Yahei", Arial, Helvetica, sans-serif, "宋体";
font-feature-settings: normal;
font-kerning: auto;
font-language-override: normal;
font-optical-sizing: auto;
font-size: 14px;
font-size-adjust: none;
font-stretch: 100%;
font-style: normal;
font-variant: normal;
font-variant-alternates: normal;
font-variant-caps: normal;
font-variant-east-asian: normal;
font-variant-ligatures: normal;
font-variant-numeric: normal;
font-variant-position: normal;
font-variation-settings: normal;
font-weight: 400;
height: 38px;
line-height: 18.2px;
margin-bottom: 0px;
margin-left: 0px;
margin-right: 0px;
margin-top: 0px;
outline-color: rgb(0, 0, 0);
outline-style: none;
outline-width: 0px;
padding-bottom: 0px;
padding-left: 10px;
padding-right: 0px;
padding-top: 0px;
transition-delay: 0s;
transition-duration: 0.3s;
transition-property: all;
transition-timing-function: ease;
width:30%;
min-width: 115.683px;
}
a.input {
	width:70px;
	height:30px;
	line-height:30px;
	background:#3091d1;
	text-align:center;
	display:inline-block;/*具有行内元素的视觉，块级元素的属性 宽高*/
	overflow:hidden;/*去掉的话，输入框也可以点击*/
	position:relative;/*相对定位，为 #file 的绝对定位准备*/
	top:10px;
}
a.input:hover {
	background:#31b0d5;
	color: #ffffff;
}
a{
	text-decoration:none;
	color:#FFF;

}
#file {
	opacity:0;/*设置此控件透明度为零，即完全透明*/
	filter:alpha(opacity=0);/*设置此控件透明度为零，即完全透明针对IE*/
	font-size:100px;
	position:absolute;/*绝对定位，相对于 .input */
	top:0;
	right:0;

	}
</style>
@endsection

@section('content')
<div class="x-body">
	<blockquote class="layui-elem-quote">装修进度查看</blockquote>

<!--       <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input readonly="readonly" class="layui-input" placeholder="开始日" name="start" id="start">
          <input readonly="readonly" class="layui-input" placeholder="截止日" name="end" id="end">
          <input readonly="readonly" type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach" style="margin-bottom:4px"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div> -->

      <table class="layui-table">
        <thead>
          <tr>
            <th>序号</th>
            <th>施工进度</th>
            <th>开工时间</th>
            <th>结束时间</th>
            <th>状态</th>
            <th>责任人</th>
            <th>验收人</th>
        </thead>

        <tbody>
          

          <tr fid="1">
            <td name="serial_number">1</td>
            <td name="details">开工仪式</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[0]->start)?$schedule[0]->start:'' }}" placeholder="开始日" name="start" id="start2">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[0]->end)? $schedule[0]->end :'' }}" placeholder="截止日" name="end" id="end2">
            </td>
            <td>
              @if(isset($schedule[0]) && $schedule[0]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[0]->liable)?$schedule[0]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[0]->check)?$schedule[0]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
  
          </tr>

          <tr index="3" fid="1">
            <td name="serial_number">2</td>
            <td name="details">拆除补烂</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[1]->start)?$schedule[1]->start:'' }}" placeholder="开始日" name="start" id="start3">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[1]->end)? $schedule[1]->end :'' }}" placeholder="截止日" name="end" id="end3">
            </td>
            <td>
              @if(isset($schedule[1]) && $schedule[1]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[1]->liable)?$schedule[1]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[1]->check)?$schedule[1]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="3" fid="1">
            <td name="serial_number">3</td>
            <td name="details">砌砖墙</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[2]->start)?$schedule[2]->start:'' }}" placeholder="开始日" name="start" id="start4">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[2]->end)? $schedule[2]->end :'' }}" placeholder="截止日" name="end" id="end4">
            </td>
            <td>
              @if(isset($schedule[2]) && $schedule[2]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[2]->liable)?$schedule[2]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[2]->check)?$schedule[2]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="3" fid="1">
            <td name="serial_number">4</td>
            <td name="details">中央空调</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[3]->start)?$schedule[3]->start:'' }}" placeholder="开始日" name="start" id="start4">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[3]->end)? $schedule[3]->end :'' }}" placeholder="截止日" name="end" id="end4">
            </td>
            <td>
              @if(isset($schedule[3]) && $schedule[3]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[3]->liable)?$schedule[3]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[3]->check)?$schedule[3]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
  
          </tr>
          <tr pid="3" fid="1">
            <td name="serial_number">5</td>
            <td name="details">地暖施工</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[4]->start)?$schedule[4]->start:'' }}" placeholder="开始日" name="start" id="start5">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[4]->end)? $schedule[4]->end :'' }}" placeholder="截止日" name="end" id="end5">
            </td>
            <td>
              @if(isset($schedule[4]) && $schedule[4]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[4]->liable)?$schedule[4]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[4]->check)?$schedule[4]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="6" fid="1">
            <td name="serial_number">6</td>
            <td name="details">放线管理验收</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[5]->start)?$schedule[5]->start:'' }}" placeholder="开始日" name="start" id="start6">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[5]->end)? $schedule[5]->end :'' }}" placeholder="截止日" name="end" id="end6">
            </td>
            <td>
              @if(isset($schedule[5]) && $schedule[5]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[5]->liable)?$schedule[5]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[5]->check)?$schedule[5]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="6" fid="1">
            <td name="serial_number">7</td>
            <td name="details">水电部分</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[6]->start)?$schedule[6]->start:'' }}" placeholder="开始日" name="start" id="start7">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[6]->end)? $schedule[6]->end :'' }}" placeholder="截止日" name="end" id="end7">
            </td>
            <td>
              @if(isset($schedule[6]) && $schedule[6]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[6]->liable)?$schedule[6]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[6]->check)?$schedule[6]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="6" fid="1">
            <td name="serial_number">8</td>
            <td name="details">防水施工</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[7]->start)?$schedule[7]->start:'' }}" placeholder="开始日" name="start" id="start8">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[7]->end)? $schedule[7]->end :'' }}" placeholder="截止日" name="end" id="end8">
            </td>
            <td>
              @if(isset($schedule[7]) && $schedule[7]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[7]->liable)?$schedule[7]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[7]->check)?$schedule[7]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr index="9" fid="1">
            <td name="serial_number">9</td>
            <td name="details">木作部分</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[8]->start)?$schedule[8]->start:'' }}" placeholder="开始日" name="start" id="start9">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[8]->end)? $schedule[8]->end :'' }}" placeholder="截止日" name="end" id="end9">
            </td>
            <td>
              @if(isset($schedule[8]) && $schedule[8]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[8]->liable)?$schedule[8]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[8]->check)?$schedule[8]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="9" fid="1">
            <td name="serial_number">10</td>
            <td name="details">隐蔽工程验收</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[9]->start)?$schedule[9]->start:'' }}" placeholder="开始日" name="start" id="start10">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[9]->end)? $schedule[9]->end :'' }}" placeholder="截止日" name="end" id="end10">
            </td>
            <td>
              @if(isset($schedule[9]) && $schedule[9]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[9]->liable)?$schedule[9]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[9]->check)?$schedule[9]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="9" fid="1">
            <td name="serial_number">11</td>
            <td name="details">厨卫墙地砖</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[10]->start)?$schedule[10]->start:'' }}" placeholder="开始日" name="start" id="start11">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[10]->end)? $schedule[10]->end :'' }}" placeholder="截止日" name="end" id="end11">
            </td>
            <td>
              @if(isset($schedule[10]) && $schedule[10]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[10]->liable)?$schedule[10]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[10]->check)?$schedule[10]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="12" fid="1">
            <td name="serial_number">12</td>
            <td name="details">墙顶面基础施工</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[11]->start)?$schedule[11]->start:'' }}" placeholder="开始日" name="start" id="start12">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[11]->end)? $schedule[11]->end :'' }}" placeholder="截止日" name="end" id="end12">
            </td>
            <td>
              @if(isset($schedule[11]) && $schedule[11]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[11]->liable)?$schedule[11]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[11]->check)?$schedule[11]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="12" fid="1">
            <td name="serial_number">13</td>
            <td name="details">油漆</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[12]->start)?$schedule[12]->start:'' }}" placeholder="开始日" name="start" id="start13">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[12]->end)? $schedule[12]->end :'' }}" placeholder="截止日" name="end" id="end13">
            </td>
            <td>
              @if(isset($schedule[12]) && $schedule[12]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[12]->liable)?$schedule[12]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[12]->check)?$schedule[12]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="12" fid="1">
            <td name="serial_number">14</td>
            <td name="details">乳胶漆</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[13]->start)?$schedule[13]->start:'' }}" placeholder="开始日" name="start" id="start14">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[13]->end)? $schedule[13]->end :'' }}" placeholder="截止日" name="end" id="end14">
            </td>
            <td>
              @if(isset($schedule[13]) && $schedule[13]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[13]->liable)?$schedule[13]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[13]->check)?$schedule[13]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>



          <tr index="15" fid="1">
            <td name="serial_number">15</td>
            <td name="details">客厅地砖</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[14]->start)?$schedule[14]->start:'' }}" placeholder="开始日" name="start" id="start15">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[14]->end)? $schedule[14]->end :'' }}" placeholder="截止日" name="end" id="end15">
            </td>
            <td>
              @if(isset($schedule[14]) && $schedule[14]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[14]->liable)?$schedule[14]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[14]->check)?$schedule[14]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="15" fid="1">
            <td name="serial_number">16</td>
            <td name="details">面饰验收</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[15]->start)?$schedule[15]->start:'' }}" placeholder="开始日" name="start" id="start16">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[15]->end)? $schedule[15]->end :'' }}" placeholder="截止日" name="end" id="end16">
            </td>
            <td>
              @if(isset($schedule[15]) && $schedule[15]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[15]->liable)?$schedule[15]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[15]->check)?$schedule[15]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="15" fid="1">
            <td name="serial_number">17</td>
            <td name="details">成品门安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[16]->start)?$schedule[16]->start:'' }}" placeholder="开始日" name="start" id="start17">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[16]->end)? $schedule[16]->end :'' }}" placeholder="截止日" name="end" id="end17">
            </td>
            <td>
              @if(isset($schedule[16]) && $schedule[16]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[16]->liable)?$schedule[16]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[16]->check)?$schedule[16]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="18" fid="1">
            <td name="serial_number">18</td>
            <td name="details">橱柜安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[17]->start)?$schedule[17]->start:'' }}" placeholder="开始日" name="start" id="start18">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[17]->end)? $schedule[17]->end :'' }}" placeholder="截止日" name="end" id="end18">
            </td>
            <td>
              @if(isset($schedule[17]) && $schedule[17]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[17]->liable)?$schedule[17]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[17]->check)?$schedule[17]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="18" fid="1">
            <td name="serial_number">19</td>
            <td name="details">地板安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[18]->start)?$schedule[18]->start:'' }}" placeholder="开始日" name="start" id="start19">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[18]->end)? $schedule[18]->end :'' }}" placeholder="截止日" name="end" id="end19">
            </td>
            <td>
              @if(isset($schedule[18]) && $schedule[18]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[18]->liable)?$schedule[18]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[18]->check)?$schedule[18]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="20" fid="1">
            <td name="serial_number">20</td>
            <td name="details">洁具安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[19]->start)?$schedule[19]->start:'' }}" placeholder="开始日" name="start" id="start20">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[19]->end)? $schedule[19]->end :'' }}" placeholder="截止日" name="end" id="end20">
            </td>
            <td>
              @if(isset($schedule[19]) && $schedule[19]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[19]->liable)?$schedule[19]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[19]->check)?$schedule[19]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="20" fid="1">
            <td name="serial_number">21</td>
            <td name="details">定制家具安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[20]->start)?$schedule[20]->start:'' }}" placeholder="开始日" name="start" id="start21">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[20]->end)? $schedule[20]->end :'' }}" placeholder="截止日" name="end" id="end21">
            </td>
            <td>
              @if(isset($schedule[20]) && $schedule[20]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[20]->liable)?$schedule[20]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[20]->check)?$schedule[20]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="20" fid="1">
            <td name="serial_number">22</td>
            <td name="details">灯具、魔镜安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[21]->start)?$schedule[21]->start:'' }}" placeholder="开始日" name="start" id="start22">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[21]->end)? $schedule[21]->end :'' }}" placeholder="截止日" name="end" id="end22">
            </td>
            <td>
              @if(isset($schedule[21]) && $schedule[21]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[21]->liable)?$schedule[21]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[21]->check)?$schedule[21]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
<!-- **************************************************************** -->
<!-- **************************************************************** -->
<!-- **************************************************************** -->
          <tr index="23" findex="23">
            <td name="serial_number">23</td>
            <td name="details">成品家具安装</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[22]->start)?$schedule[22]->start:'' }}" placeholder="开始日" name="start" id="start23">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[22]->end)? $schedule[22]->end :'' }}" placeholder="截止日" name="end" id="end23">
            </td>
            <td>
              @if(isset($schedule[22]) && $schedule[22]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[22]->liable)?$schedule[22]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[22]->check)?$schedule[22]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="23" fid="23">
            <td name="serial_number">24</td>
            <td name="details">定制成品安装验收</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[23]->start)?$schedule[23]->start:'' }}" placeholder="开始日" name="start" id="start24">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[23]->end)? $schedule[23]->end :'' }}" placeholder="截止日" name="end" id="end24">
            </td>
            <td>
              @if(isset($schedule[23]) && $schedule[23]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[23]->liable)?$schedule[23]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[23]->check)?$schedule[23]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="23" fid="23">
            <td name="serial_number">25</td>
            <td name="details">软装搭配</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[24]->start)?$schedule[24]->start:'' }}" placeholder="开始日" name="start" id="start25">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[24]->end)? $schedule[24]->end :'' }}" placeholder="截止日" name="end" id="end25">
            </td>
            <td>
              @if(isset($schedule[24]) && $schedule[24]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[24]->liable)?$schedule[24]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[24]->check)?$schedule[24]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="26" fid="23">
            <td name="serial_number">26</td>
            <td name="details">竣工联合验收单</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[25]->start)?$schedule[25]->start:'' }}" placeholder="开始日" name="start" id="start26">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[25]->end)? $schedule[25]->end :'' }}" placeholder="截止日" name="end" id="end26">
            </td>
            <td>
              @if(isset($schedule[25]) && $schedule[25]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[25]->liable)?$schedule[25]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[25]->check)?$schedule[25]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="26" fid="23">
            <td name="serial_number">27</td>
            <td name="details">竣工验收</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[26]->start)?$schedule[26]->start:'' }}" placeholder="开始日" name="start" id="start27">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[26]->end)? $schedule[26]->end :'' }}" placeholder="截止日" name="end" id="end27">
            </td>
            <td>
              @if(isset($schedule[26]) && $schedule[26]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[26]->liable)?$schedule[26]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[26]->check)?$schedule[26]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="28" fid="23">
            <td name="serial_number">28</td>
            <td name="details">竣工仪式</td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[27]->start)?$schedule[27]->start:'' }}" placeholder="开始日" name="start" id="start28">
            </td>
            <td>
              <input class="layui-input" readonly="readonly" value="{{ isset($schedule[27]->end)? $schedule[27]->end :'' }}" placeholder="截止日" name="end" id="end28">
            </td>
            <td>
              @if(isset($schedule[27]) && $schedule[27]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input name="liable" readonly="readonly" value="{{ isset($schedule[27]->liable)?$schedule[27]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input name="check" readonly="readonly" value="{{ isset($schedule[27]->check)?$schedule[27]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


        </tbody>

      </table>

 

</div>
@endsection

@section('js')

@endsection