@extends('public')

@section('content')
<div class="layui-card edit">
  <div class="layui-card-body layui-container">
    <form class="layui-form layui-form-pane " id="edit" lay-filter="edit">
      <input type="hidden" name="id" value="{{ $model->id }}">
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">房号</label>
            <div class="layui-input-block">
              <input name="room_number" value="{{ $model->room_number }}" lay-verify="required" placeholder="请输入房号" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">楼层</label>
            <div class="layui-input-block">
              <select name="floor" lay-verify="required">
                <option value="">请选择</option>
                <option value="1" @if($model->floor == '1') selected @endif>1</option>
                <option value="2" @if($model->floor == '2') selected @endif>2</option>
                <option value="3" @if($model->floor == '3') selected @endif>4</option>
                <option value="4" @if($model->floor == '4') selected @endif>4</option>
                <option value="5" @if($model->floor == '5') selected @endif>5</option>
                <option value="6" @if($model->floor == '6') selected @endif>6</option>
                <option value="7" @if($model->floor == '7') selected @endif>7</option>
                <option value="8" @if($model->floor == '8') selected @endif>8</option>
                <option value="9" @if($model->floor == '9') selected @endif>9</option>
                <option value="10" @if($model->floor == '10') selected @endif>10</option>
                <option value="11" @if($model->floor == '11') selected @endif>11</option>
                <option value="12" @if($model->floor == '12') selected @endif>12</option>
                <option value="13" @if($model->floor == '13') selected @endif>13</option>
                <option value="14" @if($model->floor == '14') selected @endif>14</option>
                <option value="15" @if($model->floor == '15') selected @endif>15</option>
                <option value="16" @if($model->floor == '16') selected @endif>16</option>
                <option value="17" @if($model->floor == '17') selected @endif>17</option>
                <option value="18" @if($model->floor == '18') selected @endif>18</option>
                <option value="19" @if($model->floor == '19') selected @endif>19</option>
                <option value="20" @if($model->floor == '20') selected @endif>20</option>
                <option value="21" @if($model->floor == '21') selected @endif>21</option>
                <option value="22" @if($model->floor == '22') selected @endif>22</option>
                <option value="23" @if($model->floor == '23') selected @endif>23</option>
                <option value="24" @if($model->floor == '24') selected @endif>24</option>
                <option value="25" @if($model->floor == '25') selected @endif>25</option>
                <option value="26" @if($model->floor == '26') selected @endif>26</option>
                <option value="27" @if($model->floor == '27') selected @endif>27</option>
                <option value="28" @if($model->floor == '28') selected @endif>28</option>
                <option value="29" @if($model->floor == '29') selected @endif>29</option>
                <option value="30" @if($model->floor == '30') selected @endif>30</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">楼栋</label>
            <div class="layui-input-block">
              <select name="building" lay-verify="required">
                <option value="">请选择</option>
                <option value="1" @if($model->building == '1') selected @endif>1</option>
                <option value="2" @if($model->building == '2') selected @endif>2</option>
                <option value="3" @if($model->building == '3') selected @endif>2</option>
                <option value="4" @if($model->building == '4') selected @endif>4</option>
                <option value="5" @if($model->building == '5') selected @endif>5</option>
                <option value="6" @if($model->building == '6') selected @endif>6</option>
                <option value="7" @if($model->building == '7') selected @endif>7</option>
                <option value="8" @if($model->building == '8') selected @endif>8</option>
                <option value="9" @if($model->building == '9') selected @endif>9</option>
                <option value="10" @if($model->building == '10') selected @endif>10</option>
                <option value="11" @if($model->building == '11') selected @endif>11</option>
                <option value="12" @if($model->building == '12') selected @endif>12</option>
                <option value="13" @if($model->building == '13') selected @endif>13</option>
                <option value="14" @if($model->building == '14') selected @endif>14</option>
                <option value="15" @if($model->building == '15') selected @endif>15</option>
              </select>
            </div>
          </div>
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">单元</label>
            <div class="layui-input-block">
              <select name="unit" lay-verify="required">
                <option value="">请选择</option>
                <option value="1" @if($model->building == '1') selected @endif>1</option>
                <option value="2" @if($model->building == '2') selected @endif>2</option>
                <option value="3" @if($model->building == '3') selected @endif>3</option>
                <option value="4" @if($model->building == '4') selected @endif>4</option>
                <option value="5" @if($model->building == '5') selected @endif>5</option>
                <option value="6" @if($model->building == '6') selected @endif>6</option>
                <option value="7" @if($model->building == '7') selected @endif>7</option>
                <option value="8" @if($model->building == '8') selected @endif>8</option>
                <option value="9" @if($model->building == '9') selected @endif>9</option>
                <option value="10" @if($model->building == '10') selected @endif>10</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item" >
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">面积</label>
            <div class="layui-input-block">
              <input name="acreage" value="{{ $model->acreage }}" lay-verify="acreage" placeholder="请输入面积" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">户型</label>
            <div class="layui-input-block">
              <select name="huxing_id">
                <option value=""></option>
                @foreach($model->project->huxings as $v)
                <option value="{{ $v->id }}" @if($v->id == $model->huxing_id) selected @endif>{{ $v->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">人工成本</label>
            <div class="layui-input-block">
              <input name="manual_cost" value="{{ $model->manual_cost }}" lay-verify="manual_cost" placeholder="请输入人工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">人工销售成本</label>
            <div class="layui-input-block">
              <input name="manual_sale_cost" value="{{ $model->manual_sale_cost }}" lay-verify="manual_sale_cost" placeholder="请输入人工销售成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">材料成本</label>
            <div class="layui-input-block">
              <input name="material_cost" value="{{ $model->material_cost }}" lay-verify="material_cost" placeholder="请输入材料成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg6 layui-col-xs6 layui-col-sm6 layui-col-md6">
            <label class="layui-form-label">施工成本</label>
            <div class="layui-input-block">
              <input name="construction_cost" value="{{ $model->construction_cost }}" lay-verify="construction_cost" placeholder="请输入施工成本" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
          <label class="layui-form-label">套装选用</label>
          <div class="layui-input-block">
            <select name="template_id" lay-search="" lay-verify="">
              <option value="">直接选择或搜索选择</option>
              @foreach($houses as $p)
              <option value="{{ $p->id }}" @if($model->template_id == $p->id)  selected="selected" @endif>{{ $p->project->name.$p->building.'栋'.$p->unit.'单元'.$p->floor.'层'.$p->room_number.'号' }}</option>
              @endforeach
            </select>
          </div>
      </div>
      <div class="layui-form-item ">
        <div class="layui-input-block">
        <br>
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
          </div>
        </div>
      </div> 
    </form>
  </div> 
</div>
@endsection

@section('js')
<script type="text/javascript">
 layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    token = $("meta[name='csrf-token']").attr('content');

    form.on('submit(edit)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/design/manage-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            parent.editClose(res.msg);
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('编辑失败');
        }
      })
      return false;
    })
    form.verify({
      'room_number' : function(value)
      {
        if(value.length >= 10)
        {
          return '字数超出限制 (MAX:10)';
        }
      },
      
      'acreage' : function(value)
      {
        if(value)
        {
          s = /^\d{1,3}\.\d{1,2}$/;
          sS = /^\d{1,3}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MAX:3 保留小数点2位)';
          }
        }
      },
      manual_cost : function(value)
      {
        if(value)
        {
          s = /^\d{1,8}\.\d{1,2}$/;
          sS = /^\d{1,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:1 MAX:8 保留小数点2位)';
          }
        }
      },
      manual_sale_cost : function(value)
      {
        if(value)
        {
          s = /^\d{1,8}\.\d{1,2}$/;
          sS = /^\d{1,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:1 MAX:8 保留小数点2位)';
          }
        }
      },
      material_cost : function(value)
      {
        if(value)
        {
          s = /^\d{1,8}\.\d{1,2}$/;
          sS = /^\d{1,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:1 MAX:8 保留小数点2位)';
          }
        }
      },
      construction_cost : function(value)
      {
        if(value)
        {
          s = /^\d{1,8}\.\d{1,2}$/;
          sS = /^\d{1,8}$/;
          if(!s.test(value) && !sS.test(value))
          {
            return '请输入整数 (MIN:1 MAX:8 保留小数点2位)';
          }
        }
      }
    })
 });
</script>
@endsection
