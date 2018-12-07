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
            <th>阶段</th>
            <th>事项</th>
            <th>施工细节</th>
            <th>开工时间</th>
            <th>结束时间</th>
            <th>状态</th>
            <th>责任人</th>
            <th>验收人</th>
        </thead>

        <tbody>
          
          <tr findex="1">
            <td name="serial_number">1</td>
            <td rowspan='22' name="stage">基础阶段</td>
            <td name="matter">开工交底</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly"  class="layui-input" placeholder="开始日" value="{{ isset($schedule[0]->start)?$schedule[0]->start:'' }}" name="start" id="start1">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" placeholder="截止日" value="{{ isset($schedule[0]->end)? $schedule[0]->end :'' }}" name="end" id="end1">
            </td>
            <td>
              @if(isset($schedule[0])  && $schedule[0]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[0]->liable)?$schedule[0]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[0]->check)?$schedule[0]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr fid="1">
            <td name="serial_number">2</td>
            <td name="matter">正式施工</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[1]->start)?$schedule[1]->start:'' }}" placeholder="开始日" name="start" id="start2">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[1]->end)? $schedule[1]->end :'' }}" placeholder="截止日" name="end" id="end2">
            </td>
            <td>
              @if(isset($schedule[1]) && $schedule[1]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[1]->liable)?$schedule[1]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[1]->check)?$schedule[1]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr index="3" fid="1">
            <td name="serial_number">3</td>
            <td rowspan="3" name="matter">拆除开挖</td>
            <td name="details">拆墙</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[2]->start)?$schedule[2]->start:'' }}" placeholder="开始日" name="start" id="start3">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[2]->end)? $schedule[2]->end :'' }}" placeholder="截止日" name="end" id="end3">
            </td>
            <td>
              @if(isset($schedule[2]) && $schedule[2]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[2]->liable)?$schedule[2]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[2]->check)?$schedule[2]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>
          <tr pid="3" fid="1">
            <td name="serial_number">4</td>
            <td name="details">铲铁皮</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[3]->start)?$schedule[3]->start:'' }}" placeholder="开始日" name="start" id="start4">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[3]->end)? $schedule[3]->end :'' }}" placeholder="截止日" name="end" id="end4">
            </td>
            <td>
              @if(isset($schedule[3]) && $schedule[3]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[3]->liable)?$schedule[3]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[3]->check)?$schedule[3]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>
          <tr pid="3" fid="1">
            <td name="serial_number">5</td>
            <td name="details">水电开槽</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[4]->start)?$schedule[4]->start:'' }}" placeholder="开始日" name="start" id="start5">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[4]->end)? $schedule[4]->end :'' }}" placeholder="截止日" name="end" id="end5">
            </td>
            <td>
              @if(isset($schedule[4]) && $schedule[4]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[4]->liable)?$schedule[4]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[4]->check)?$schedule[4]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>


          <tr index="6" fid="1">
            <td name="serial_number">6</td>
            <td rowspan="3" name="matter">水电改造</td>
            <td name="details">厨房改造</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[5]->start)?$schedule[5]->start:'' }}" placeholder="开始日" name="start" id="start6">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[5]->end)? $schedule[5]->end :'' }}" placeholder="截止日" name="end" id="end6">
            </td>
            <td>
              @if(isset($schedule[5]) && $schedule[5]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[5]->liable)?$schedule[5]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[5]->check)?$schedule[5]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="6" fid="1">
            <td name="serial_number">7</td>
            <td name="details">卫生间水路改造</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[6]->start)?$schedule[6]->start:'' }}" placeholder="开始日" name="start" id="start7">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[6]->end)? $schedule[6]->end :'' }}" placeholder="截止日" name="end" id="end7">
            </td>
            <td>
              @if(isset($schedule[6]) && $schedule[6]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[6]->liable)?$schedule[6]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[6]->check)?$schedule[6]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="6" fid="1">
            <td name="serial_number">8</td>
            <td name="details">生活阳台/分区水路改造</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[7]->start)?$schedule[7]->start:'' }}" placeholder="开始日" name="start" id="start8">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[7]->end)? $schedule[7]->end :'' }}" placeholder="截止日" name="end" id="end8">
            </td>
            <td>
              @if(isset($schedule[7]) && $schedule[7]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[7]->liable)?$schedule[7]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[7]->check)?$schedule[7]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr index="9" fid="1">
            <td name="serial_number">9</td>
            <td rowspan="3" name="matter">电路改造</td>
            <td name="details">线路改造</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[8]->start)?$schedule[8]->start:'' }}" placeholder="开始日" name="start" id="start9">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[8]->end)? $schedule[8]->end :'' }}" placeholder="截止日" name="end" id="end9">
            </td>
            <td>
              @if(isset($schedule[8]) && $schedule[8]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[8]->liable)?$schedule[8]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[8]->check)?$schedule[8]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="9" fid="1">
            <td name="serial_number">10</td>
            <td name="details">开关调整</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[9]->start)?$schedule[9]->start:'' }}" placeholder="开始日" name="start" id="start10">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[9]->end)? $schedule[9]->end :'' }}" placeholder="截止日" name="end" id="end10">
            </td>
            <td>
              @if(isset($schedule[9]) && $schedule[9]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[9]->liable)?$schedule[9]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[9]->check)?$schedule[9]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="9" fid="1">
            <td name="serial_number">11</td>
            <td name="details">插座调整</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[10]->start)?$schedule[10]->start:'' }}" placeholder="开始日" name="start" id="start11">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[10]->end)? $schedule[10]->end :'' }}" placeholder="截止日" name="end" id="end11">
            </td>
            <td>
              @if(isset($schedule[10]) && $schedule[10]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[10]->liable)?$schedule[10]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[10]->check)?$schedule[10]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="12" fid="1">
            <td name="serial_number">12</td>
            <td rowspan="3" name="matter">造型施工</td>
            <td name="details">吊顶</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[11]->start)?$schedule[11]->start:'' }}" placeholder="开始日" name="start" id="start12">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[11]->end)? $schedule[11]->end :'' }}" placeholder="截止日" name="end" id="end12">
            </td>
            <td>
              @if(isset($schedule[11]) && $schedule[11]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[11]->liable)?$schedule[11]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[11]->check)?$schedule[11]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="12" fid="1">
            <td name="serial_number">13</td>
            <td name="details">墙面/电视墙</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[12]->start)?$schedule[12]->start:'' }}" placeholder="开始日" name="start" id="start13">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[12]->end)? $schedule[12]->end :'' }}" placeholder="截止日" name="end" id="end13">
            </td>
            <td>
              @if(isset($schedule[12]) && $schedule[12]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[12]->liable)?$schedule[12]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[12]->check)?$schedule[12]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="12" fid="1">
            <td name="serial_number">14</td>
            <td name="details">其他部分</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[13]->start)?$schedule[13]->start:'' }}" placeholder="开始日" name="start" id="start14">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[13]->end)? $schedule[13]->end :'' }}" placeholder="截止日" name="end" id="end14">
            </td>
            <td>
              @if(isset($schedule[13]) && $schedule[13]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[13]->liable)?$schedule[13]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[13]->check)?$schedule[13]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>



          <tr index="15" fid="1">
            <td name="serial_number">15</td>
            <td rowspan="3" name="matter">场面施工</td>
            <td name="details">回填</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[14]->start)?$schedule[14]->start:'' }}" placeholder="开始日" name="start" id="start15">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[14]->end)? $schedule[14]->end :'' }}" placeholder="截止日" name="end" id="end15">
            </td>
            <td>
              @if(isset($schedule[14]) && $schedule[14]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[14]->liable)?$schedule[14]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[14]->check)?$schedule[14]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="15" fid="1">
            <td name="serial_number">16</td>
            <td name="details">防水</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[15]->start)?$schedule[15]->start:'' }}" placeholder="开始日" name="start" id="start16">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[15]->end)? $schedule[15]->end :'' }}" placeholder="截止日" name="end" id="end16">
            </td>
            <td>
              @if(isset($schedule[15]) && $schedule[15]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[15]->liable)?$schedule[15]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[15]->check)?$schedule[15]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>
          <tr pid="15" fid="1">
            <td name="serial_number">17</td>
            <td name="details">贴砖</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[16]->start)?$schedule[16]->start:'' }}" placeholder="开始日" name="start" id="start17">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[16]->end)? $schedule[16]->end :'' }}" placeholder="截止日" name="end" id="end17">
            </td>
            <td>
              @if(isset($schedule[16]) && $schedule[16]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[16]->liable)?$schedule[16]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[16]->check)?$schedule[16]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>


          <tr index="18" fid="1">
            <td name="serial_number">18</td>
            <td rowspan="2" name="matter">墙面施工</td>
            <td name="details">墙面处理</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[17]->start)?$schedule[17]->start:'' }}" placeholder="开始日" name="start" id="start18">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[17]->end)? $schedule[17]->end :'' }}" placeholder="截止日" name="end" id="end18">
            </td>
            <td>
              @if(isset($schedule[17]) && $schedule[17]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[17]->liable)?$schedule[17]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[17]->check)?$schedule[17]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
 
          </tr>
          <tr pid="18" fid="1">
            <td name="serial_number">19</td>
            <td name="details">墙面刷漆/壁纸</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[18]->start)?$schedule[18]->start:'' }}" placeholder="开始日" name="start" id="start19">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[18]->end)? $schedule[18]->end :'' }}" placeholder="截止日" name="end" id="end19">
            </td>
            <td>
              @if(isset($schedule[18]) && $schedule[18]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[18]->liable)?$schedule[18]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[18]->check)?$schedule[18]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
  
          </tr>


          <tr index="20" fid="1">
            <td name="serial_number">20</td>
            <td rowspan="3" name="matter">初步检查</td>
            <td name="details">检查水电</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[19]->start)?$schedule[19]->start:'' }}" placeholder="开始日" name="start" id="start20">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[19]->end)? $schedule[19]->end :'' }}" placeholder="截止日" name="end" id="end20">
            </td>
            <td>
              @if(isset($schedule[19]) && $schedule[19]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[19]->liable)?$schedule[19]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[19]->check)?$schedule[19]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
  
          </tr>
          <tr pid="20" fid="1">
            <td name="serial_number">21</td>
            <td name="details">检查墙面/砖/防水</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[20]->start)?$schedule[20]->start:'' }}" placeholder="开始日" name="start" id="start21">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[20]->end)? $schedule[20]->end :'' }}" placeholder="截止日" name="end" id="end21">
            </td>
            <td>
              @if(isset($schedule[20]) && $schedule[20]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[20]->liable)?$schedule[20]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[20]->check)?$schedule[20]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>
          <tr pid="20" fid="1">
            <td name="serial_number">22</td>
            <td name="details">初步卫生打理</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[21]->start)?$schedule[21]->start:'' }}" placeholder="开始日" name="start" id="start22">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[21]->end)? $schedule[21]->end :'' }}" placeholder="截止日" name="end" id="end22">
            </td>
            <td>
              @if(isset($schedule[21]) && $schedule[21]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[21]->liable)?$schedule[21]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[21]->check)?$schedule[21]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
<!-- **************************************************************** -->
<!-- **************************************************************** -->
<!-- **************************************************************** -->
          <tr index="23" findex="23">
            <td name="serial_number">23</td>
            <td rowspan='14' name="stage">精细阶段</td>
            <td rowspan="3" name="matter">门窗安装</td>
            <td name="details">窗户安装</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[22]->start)?$schedule[22]->start:'' }}" placeholder="开始日" name="start" id="start23">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[22]->end)? $schedule[22]->end :'' }}" placeholder="截止日" name="end" id="end23">
            </td>
            <td>
              @if(isset($schedule[22]) && $schedule[22]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[22]->liable)?$schedule[22]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[22]->check)?$schedule[22]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="23" fid="23">
            <td name="serial_number">24</td>
            <td name="details">门安装</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[23]->start)?$schedule[23]->start:'' }}" placeholder="开始日" name="start" id="start24">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[23]->end)? $schedule[23]->end :'' }}" placeholder="截止日" name="end" id="end24">
            </td>
            <td>
              @if(isset($schedule[23]) && $schedule[23]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[23]->liable)?$schedule[23]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[23]->check)?$schedule[23]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="23" fid="23">
            <td name="serial_number">25</td>
            <td name="details">缝隙处理</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[24]->start)?$schedule[24]->start:'' }}" placeholder="开始日" name="start" id="start25">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[24]->end)? $schedule[24]->end :'' }}" placeholder="截止日" name="end" id="end25">
            </td>
            <td>
              @if(isset($schedule[24]) && $schedule[24]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[24]->liable)?$schedule[24]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[24]->check)?$schedule[24]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="26" fid="23">
            <td name="serial_number">26</td>
            <td rowspan="2" name="matter">厨卫安装</td>
            <td name="details">厨房橱柜等</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[25]->start)?$schedule[25]->start:'' }}" placeholder="开始日" name="start" id="start26">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[25]->end)? $schedule[25]->end :'' }}" placeholder="截止日" name="end" id="end26">
            </td>
            <td>
              @if(isset($schedule[25]) && $schedule[25]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[25]->liable)?$schedule[25]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[25]->check)?$schedule[25]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="26" fid="23">
            <td name="serial_number">27</td>
            <td name="details">卫生间安装</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[26]->start)?$schedule[26]->start:'' }}" placeholder="开始日" name="start" id="start27">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[26]->end)? $schedule[26]->end :'' }}" placeholder="截止日" name="end" id="end27">
            </td>
            <td>
              @if(isset($schedule[26]) && $schedule[26]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[26]->liable)?$schedule[26]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[26]->check)?$schedule[26]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>


          <tr index="28" fid="23">
            <td name="serial_number">28</td>
            <td rowspan="3" name="matter">灯具安装</td>
            <td name="details">灯具进场</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[27]->start)?$schedule[27]->start:'' }}" placeholder="开始日" name="start" id="start28">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[27]->end)? $schedule[27]->end :'' }}" placeholder="截止日" name="end" id="end28">
            </td>
            <td>
              @if(isset($schedule[27]) && $schedule[27]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[27]->liable)?$schedule[27]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[27]->check)?$schedule[27]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="28" fid="23">
            <td name="serial_number">29</td>
            <td name="details">灯具安装</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[28]->start)?$schedule[28]->start:'' }}" placeholder="开始日" name="start" id="start29">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[28]->end)? $schedule[28]->end :'' }}" placeholder="截止日" name="end" id="end29">
            </td>
            <td>
              @if(isset($schedule[28]) && $schedule[28]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[28]->liable)?$schedule[28]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[28]->check)?$schedule[28]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="28" fid="23">
            <td name="serial_number">30</td>
            <td name="details">灯具调试</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[29]->start)?$schedule[29]->start:'' }}" placeholder="开始日" name="start" id="start30">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[29]->end)? $schedule[29]->end :'' }}" placeholder="截止日" name="end" id="end30">
            </td>
            <td>
              @if(isset($schedule[29]) && $schedule[29]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[29]->liable)?$schedule[29]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[29]->check)?$schedule[29]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr index="31" fid="23">
            <td name="serial_number">31</td>
            <td rowspan="3" name="matter">电器安装</td>
            <td name="details">电器进场</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[30]->start)?$schedule[30]->start:'' }}" placeholder="开始日" name="start" id="start31">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[30]->end)? $schedule[30]->end :'' }}" placeholder="截止日" name="end" id="end31">
            </td>
            <td>
              @if(isset($schedule[30]) && $schedule[30]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[30]->liable)?$schedule[30]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[30]->check)?$schedule[30]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="31" fid="23">
            <td name="serial_number">32</td>
            <td name="details">电气安装</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[31]->start)?$schedule[31]->start:'' }}" placeholder="开始日" name="start" id="start32">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[31]->end)? $schedule[31]->end :'' }}" placeholder="截止日" name="end" id="end32">
            </td>
            <td>
              @if(isset($schedule[31]) && $schedule[31]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[31]->liable)?$schedule[31]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[31]->check)?$schedule[31]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="31" fid="23">
            <td name="serial_number">33</td>
            <td name="details">电气调试</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[32]->start)?$schedule[32]->start:'' }}" placeholder="开始日" name="start" id="start33">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[32]->end)? $schedule[32]->end :'' }}" placeholder="截止日" name="end" id="end33">
            </td>
            <td>
              @if(isset($schedule[32]) && $schedule[32]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[32]->liable)?$schedule[32]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[32]->check)?$schedule[32]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

          <tr index="34" fid="23">
            <td name="serial_number">34</td>
            <td rowspan="3" name="matter">家居安装</td>
            <td name="details">家居进场</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[33]->start)?$schedule[33]->start:'' }}" placeholder="开始日" name="start" id="start34">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[33]->end)? $schedule[33]->end :'' }}" placeholder="截止日" name="end" id="end34">
            </td>
            <td>
              @if(isset($schedule[33]) && $schedule[33]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[33]->liable)?$schedule[33]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[33]->check)?$schedule[33]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="35" fid="23">
            <td name="serial_number">35</td>
            <td name="details">家具安装与摆放</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[34]->start)?$schedule[34]->start:'' }}" placeholder="开始日" name="start" id="start35">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[34]->end)? $schedule[34]->end :'' }}" placeholder="截止日" name="end" id="end35">
            </td>
            <td>
              @if(isset($schedule[34]) && $schedule[34]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[34]->liable)?$schedule[34]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[34]->check)?$schedule[34]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>
          <tr pid="35" fid="23">
            <td name="serial_number">36</td>
            <td name="details">家居检查</td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[35]->start)?$schedule[35]->start:'' }}" placeholder="开始日" name="start" id="start36">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[35]->end)? $schedule[35]->end :'' }}" placeholder="截止日" name="end" id="end36">
            </td>
            <td>
              @if(isset($schedule[35]) && $schedule[35]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[35]->liable)?$schedule[35]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[35]->check)?$schedule[35]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

<!-- *************************************************************************************
************************************************************************************* -->

          <tr findex="37">
            <td name="serial_number">37</td>
            <td rowspan='4' name="stage">竣工阶段</td>
            <td name="matter">保洁</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[36]->start)?$schedule[36]->start:'' }}" placeholder="开始日" name="start" id="start37">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[36]->end)? $schedule[36]->end :'' }}" placeholder="截止日" name="end" id="end37">
            </td>
            <td>
              @if(isset($schedule[36]) && $schedule[36]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[36]->liable)?$schedule[36]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[36]->check)?$schedule[36]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>

          <tr fid="37">
            <td name="serial_number">38</td>
            <td name="matter">质量检查</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[37]->start)?$schedule[37]->start:'' }}" placeholder="开始日" name="start" id="start38">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[37]->end)? $schedule[37]->end :'' }}" placeholder="截止日" name="end" id="end38">
            </td>
            <td>
              @if(isset($schedule[37]) && $schedule[37]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[37]->liable)?$schedule[37]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[37]->check)?$schedule[37]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
 
          </tr>
          <tr fid="37">
            <td name="serial_number">39</td>
            <td name="matter">参套检查</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[38]->start)?$schedule[38]->start:'' }}" placeholder="开始日" name="start" id="start39">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[38]->end)? $schedule[38]->end :'' }}" placeholder="截止日" name="end" id="end39">
            </td>
            <td>
              @if(isset($schedule[38]) && $schedule[38]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[38]->liable)?$schedule[38]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[38]->check)?$schedule[38]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>

          </tr>
          <tr fid="37">
            <td name="serial_number">40</td>
            <td name="matter">确认验收</td>
            <td name="details"></td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[39]->start)?$schedule[39]->start:'' }}" placeholder="开始日" name="start" id="start40">
            </td>
            <td>
              <input readonly="readonly" class="layui-input" value="{{ isset($schedule[39]->end)? $schedule[39]->end :'' }}" placeholder="截止日" name="end" id="end40">
            </td>
            <td>
              @if(isset($schedule[39]) && $schedule[39]['status'] == 2)
              <button class="layui-btn layui-btn-sm layui-btn-normal">已完成</button>
              @else
              <button class="layui-btn layui-btn-sm layui-btn-danger">未完成</button>
              @endif
            </td>
            <td>
              <input readonly="readonly" name="liable" value="{{ isset($schedule[39]->liable)?$schedule[39]->liable :'' }}" lay-verify="required" placeholder="责任人" autocomplete="off" class="layui-input" type="text">
            </td>
            <td>
              <input readonly="readonly" name="check" value="{{ isset($schedule[39]->check)?$schedule[39]->check :'' }}"  lay-verify="required" placeholder="验收人" autocomplete="off" class="layui-input" type="text">
            </td>
          </tr>

        </tbody>


      </table>

 

</div>
@endsection

@section('js')

@endsection