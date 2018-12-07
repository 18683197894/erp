@extends('public')

@section('css')

@endsection

@section('content')
<div class="layui-fluid" id="LAY-component-grid-list">
    <div class="layui-row layui-col-space10 demo-list">
    	<div id="layer-photos-demo" class="layer-photos-demo">
		    @foreach($album as $v)
		      <div class="layui-col-sm4 layui-col-md3 layui-col-lg3">
		        <!-- 填充内容 -->
		        <div class="layui-card" style="margin:5px;">
  					<img width="100%" height="100%" layer-pid="{{ $v->id }}" layer-src="{{ $v->image }}" src="{{ $v->re_image }}" alt="{{ $v->Schedule->stage.' '.$v->Schedule->matter.' '.$v->Schedule->details.'/'.$v->class }}">
		        </div>
		      </div>
		    @endforeach
    	</div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	layui.use('layer',function(){
		layer = layui.layer;
		layer.photos({
		  photos: '#layer-photos-demo'
		  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
		}); 
	})
</script>
@endsection