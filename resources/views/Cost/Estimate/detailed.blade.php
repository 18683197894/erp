@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card add" style="display:none">
  <div class="layui-card-body" style="padding: 15px">
    <form class="layui-form layui-form-pane" id="myform"lay-filter="component-form-group">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block">
              <input name="classify" value="" lay-verify="required" placeholder="请输入分类" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">项目名称</label>
            <div class="layui-input-block">
              <input name="project_name" value="" lay-verify="required" placeholder="请输入项目名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">子项目</label>
            <div class="layui-input-block">
              <input name="son_project" value="" lay-verify="required" placeholder="请输入子项目" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">区域</label>
            <div class="layui-input-block">
              <input name="region" value="" lay-verify="required" placeholder="请输入区域" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">单位</label>
            <div class="layui-input-block">
              <input name="unit" value="" lay-verify="required" placeholder="请输入单位"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">总工程量</label>
            <div class="layui-input-block">
              <input name="amount_total" value="" lay-verify="required" placeholder="请输入总工程量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">区域数</label>
            <div class="layui-input-block">
              <input name="region_num" value="" lay-verify="required" placeholder="请输入区域数" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">工程量</label>
            <div class="layui-input-block">
              <input name="amount_num" value="" lay-verify="required" placeholder="请输入工程量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">计算式</label>
            <div class="layui-input-block">
              <input name="formula" value="" lay-verify="required" placeholder="请输入计算式"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">预算描述</label>
            <div class="layui-input-block">
              <input name="describe" value="" lay-verify="required" placeholder="请输入预算描述" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">工种</label>
            <div class="layui-input-block">
              <input name="profession" value="" lay-verify="required" placeholder="请输入工种" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div>
          <label class="layui-form-label" style="width: 100%;">成本单价组成</label>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">承包价(元)</label>
            <div class="layui-input-block">
              <input name="a_contract_price" value="" lay-verify="required|price" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">辅材及机械(元)</label>
            <div class="layui-input-block">
              <input name="a_mechanics_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">龙骨(元)</label>
            <div class="layui-input-block">
              <input name="a_keel_price" value="" lay-verify="required|price" placeholder="请输入龙骨(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材/板材(元)</label>
            <div class="layui-input-block">
              <input name="a_main_price" value="" lay-verify="required|price" placeholder="请输入主材/板材(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材损耗(%)</label>
            <div class="layui-input-block">
              <input name="a_main_loss" value="" lay-verify="required" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">单价(元)</label>
            <div class="layui-input-block">
              <input name="a_unit_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">合价</label>
            <div class="layui-input-block">
              <input name="total" value="" lay-verify="required|price" placeholder="请输入合价" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">(预)项目特征</label>
            <div class="layui-input-block">
              <input name="project_characteristics_a" value="" lay-verify="required" placeholder="请输入(预)项目特征" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">(劳)项目特征</label>
            <div class="layui-input-block">
              <input name="project_characteristics_b" value="" lay-verify="required" placeholder="请输入(劳)项目特征" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">计算规则</label>
            <div class="layui-input-block">
              <input name="calculation_rule" value="" lay-verify="required" placeholder="请输入计算规则" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">综合单价(包含内容)</label>
            <div class="layui-input-block">
              <input name="comprehensive_unit_price" value="" lay-verify="required|price" placeholder="综合单价(包含内容)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div>
          <label class="layui-form-label" style="width: 100%;">成本统计</label>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">承包价(元)</label>
            <div class="layui-input-block">
              <input name="b_contract_price" value="" lay-verify="required|price" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">辅材及机械(元)</label>
            <div class="layui-input-block">
              <input name="b_mechanics_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">龙骨(元)</label>
            <div class="layui-input-block">
              <input name="b_keel_price" value="" lay-verify="required|price" placeholder="请输入龙骨(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材/板材(元)</label>
            <div class="layui-input-block">
              <input name="b_main_price" value="" lay-verify="required|price" placeholder="请输入主材/板材(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材损耗(%)</label>
            <div class="layui-input-block">
              <input name="b_main_loss" value="" lay-verify="required" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">单价(元)</label>
            <div class="layui-input-block">
              <input name="b_unit_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div class="layui-row layui-form-text">
          <div class="layui-col-lg12">
            <label class="layui-form-label">备注(内部调整记录)</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入备注(内部调整记录)" class="layui-textarea"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item ">
        <div class="layui-input-block">
        <br>
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
          </div>
        </div>
      </div> 
    </form>
  </div>
</div>
<div class="layui-card edit" style="display:none">
  <div class="layui-card-body" style="padding: 15px">
    <form class="layui-form layui-form-pane" id="myform" lay-filter="edit">
      <input type="hidden" name="id" value="">
      <div class="layui-form-item">
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block">
              <input name="classify" value="" lay-verify="required" placeholder="请输入分类" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">项目名称</label>
            <div class="layui-input-block">
              <input name="project_name" value="" lay-verify="required" placeholder="请输入项目名称" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">子项目</label>
            <div class="layui-input-block">
              <input name="son_project" value="" lay-verify="required" placeholder="请输入子项目" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">区域</label>
            <div class="layui-input-block">
              <input name="region" value="" lay-verify="required" placeholder="请输入区域" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">单位</label>
            <div class="layui-input-block">
              <input name="unit" value="" lay-verify="required" placeholder="请输入单位"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">总工程量</label>
            <div class="layui-input-block">
              <input name="amount_total" value="" lay-verify="required" placeholder="请输入总工程量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">区域数</label>
            <div class="layui-input-block">
              <input name="region_num" value="" lay-verify="required" placeholder="请输入区域数" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">工程量</label>
            <div class="layui-input-block">
              <input name="amount_num" value="" lay-verify="required" placeholder="请输入工程量" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">计算式</label>
            <div class="layui-input-block">
              <input name="formula" value="" lay-verify="required" placeholder="请输入计算式"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">预算描述</label>
            <div class="layui-input-block">
              <input name="describe" value="" lay-verify="required" placeholder="请输入预算描述" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">工种</label>
            <div class="layui-input-block">
              <input name="profession" value="" lay-verify="required" placeholder="请输入工种" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div>
          <label class="layui-form-label" style="width: 100%;">成本单价组成</label>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">承包价(元)</label>
            <div class="layui-input-block">
              <input name="a_contract_price" value="" lay-verify="required|price" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">辅材及机械(元)</label>
            <div class="layui-input-block">
              <input name="a_mechanics_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">龙骨(元)</label>
            <div class="layui-input-block">
              <input name="a_keel_price" value="" lay-verify="required|price" placeholder="请输入龙骨(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材/板材(元)</label>
            <div class="layui-input-block">
              <input name="a_main_price" value="" lay-verify="required|price" placeholder="请输入主材/板材(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材损耗(%)</label>
            <div class="layui-input-block">
              <input name="a_main_loss" value="" lay-verify="required" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">单价(元)</label>
            <div class="layui-input-block">
              <input name="a_unit_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">合价</label>
            <div class="layui-input-block">
              <input name="total" value="" lay-verify="required|price" placeholder="请输入合价" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">(预)项目特征</label>
            <div class="layui-input-block">
              <input name="project_characteristics_a" value="" lay-verify="required" placeholder="请输入(预)项目特征" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">(劳)项目特征</label>
            <div class="layui-input-block">
              <input name="project_characteristics_b" value="" lay-verify="required" placeholder="请输入(劳)项目特征" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">计算规则</label>
            <div class="layui-input-block">
              <input name="calculation_rule" value="" lay-verify="required" placeholder="请输入计算规则" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">综合单价(包含内容)</label>
            <div class="layui-input-block">
              <input name="comprehensive_unit_price" value="" lay-verify="required|price" placeholder="综合单价(包含内容)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div>
          <label class="layui-form-label" style="width: 100%;">成本统计</label>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">承包价(元)</label>
            <div class="layui-input-block">
              <input name="b_contract_price" value="" lay-verify="required|price" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">辅材及机械(元)</label>
            <div class="layui-input-block">
              <input name="b_mechanics_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">龙骨(元)</label>
            <div class="layui-input-block">
              <input name="b_keel_price" value="" lay-verify="required|price" placeholder="请输入龙骨(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材/板材(元)</label>
            <div class="layui-input-block">
              <input name="b_main_price" value="" lay-verify="required|price" placeholder="请输入主材/板材(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-row layui-col-space10">
          <div class="layui-col-lg3">
            <label class="layui-form-label">主材损耗(%)</label>
            <div class="layui-input-block">
              <input name="b_main_loss" value="" lay-verify="required" placeholder="请输入承包价(元)"分 autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-col-lg3">
            <label class="layui-form-label">单价(元)</label>
            <div class="layui-input-block">
              <input name="b_unit_price" value="" lay-verify="required|price" placeholder="请输入辅材及机械(元)" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <br>
        <div class="layui-row layui-form-text">
          <div class="layui-col-lg12">
            <label class="layui-form-label">备注(内部调整记录)</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入备注(内部调整记录)" class="layui-textarea"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item ">
        <div class="layui-input-block">
        <br>
          <div class="layui-footer">
            <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
          </div>
        </div>
      </div> 
    </form>
  </div>
</div>
@endsection

@section('content')
<div class="layui-card-body">
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-toolbarDemo">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" onclick="open_show('新增预算','.add',0.8,0.9
      )">新增预算</button>
    </div>
  </script>
  <script type="text/html" id="operation">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  </script>
</div>
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','laydate'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
    house_id = {{ $house->id }};
    tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/cost/estimate/detailed'
      ,where:{_token:token,house_id:house_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预估测算清单'
      ,cols: [[
         {field:'classify', title:'分类',fixed: 'left',unresize:true,width:100,rowspan:2}
        ,{field:'id', title:'序号',unresize:true,width:70,rowspan:2}
        ,{field:'project_name', title:'项目名称',unresize:true,width:120,rowspan:2}
        ,{field:'son_project', title:'子项目',unresize:true,width:120,rowspan:2}
        ,{field:'region', title:'区域',unresize:true,width:120,rowspan:2}
        ,{field:'unit', title:'单位',unresize:true,width:120,rowspan:2}
        ,{field:'amount_total', title:'总工程量',unresize:true,width:120,rowspan:2}
        ,{field:'region_num', title:'区域数',unresize:true,width:120,rowspan:2}
        ,{field:'amount_num', title:'工程量',unresize:true,width:120,rowspan:2}
        ,{field:'formula', title:'计算式',unresize:true,width:120,rowspan:2}
        ,{field:'describe', title:'预算描述',unresize:true,width:120,rowspan:2}
        ,{field:'profession', title:'工种',unresize:true,width:120,rowspan:2}
        ,{title:'成本单价组成',unresize:true,align:'center',colspan: 6}
        ,{field:'total', title:'合计',unresize:true,width:120,rowspan:2}
        ,{field:'project_characteristics_a', title:'(预)项目特征',unresize:true,width:120,rowspan:2}
        ,{field:'project_characteristics_b', title:'(劳)项目特征',unresize:true,width:120,rowspan:2}
        ,{field:'calculation_rule', title:'计算规则',unresize:true,width:120,rowspan:2}
        ,{field:'comprehensive_unit_price', title:'综合单价(包含内容)',unresize:true,width:120,rowspan:2}
        ,{title:'成本统计',unresize:true,align:'center',colspan: 6}
        ,{field:'remarks', title:'备注(内部调整记录)',unresize:true,width:120,rowspan:2}
        ,{fixed: 'right',title:'操作',width:120,toolbar:'#operation',unresize:true,rowspan:2}
      ],[
         {field:'a_contract_price', title:'承包价(元)',unresize:true,width:120}
        ,{field:'a_mechanics_price', title:'辅材及机械(元)',unresize:true,width:120}
        ,{field:'a_keel_price', title:'龙骨(元)',unresize:true,width:120}
        ,{field:'a_main_price', title:'主材/板材(元)',unresize:true,width:120}
        ,{field:'a_main_loss', title:'主材损耗(%)',unresize:true,width:120}
        ,{field:'a_unit_price', title:'单价(元)',unresize:true,width:120}
        ,{field:'b_contract_price', title:'承包价(元)',unresize:true,width:120}
        ,{field:'b_mechanics_price', title:'辅材及机械(元)',unresize:true,width:120}
        ,{field:'b_keel_price', title:'龙骨(元)',unresize:true,width:120}
        ,{field:'b_main_price', title:'主材/板材(元)',unresize:true,width:120}
        ,{field:'b_main_loss', title:'主材损耗(%)',unresize:true,width:120}
        ,{field:'b_unit_price', title:'单价(元)',unresize:true,width:120}
      ]]
      ,page: true
    ,parseData: function(res){ //res 即为原始返回的数据
      return {
        "code": res.code, //解析接口状态
        "msg": res.msg, //解析提示文本
        "count": res.total, //解析数据长度
        "data": res.data //解析数据列表
      };
    }
    });

    laydate.render({
      elem: '#time_1'//指定元素
    });
    laydate.render({
      elem: '#time_2'//指定元素
    });
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除当前预算吗', function(index){
          $.ajax({
            url:'{{ url("/cost/estimate/detailed-del") }}',
            type : 'post',
            data : {id:data.id,_token:token},
            success : function(res)
            { 
              res = $.parseJSON(res);
              if(res.code == 200)
              {
                obj.del();
                layer.close(index);
                layMsgOk(res.msg);
              }else
              {
                layMsgError(res.msg);
              }
            },
            error : function(error)
            {
              layMsgError('操作失败');
            }
          })
        });
      } else if(obj.event === 'edit'){
          var width = ($(window).width() * 0.8)+'px';
          var height = ($(window).height() * 0.9)+'px';
          form.val('edit',{
            'id':data.id,
            'classify':data.classify,
            'project_name':data.project_name,
            'son_project':data.son_project,
            'region':data.region,
            'unit':data.unit,
            'amount_total':data.amount_total,
            'region_num':data.region_num,
            'amount_num':data.amount_num,
            'formula':data.formula,
            'describe':data.describe,
            'profession':data.profession,
            'total':data.total,
            'project_characteristics_a':data.project_characteristics_a,
            'project_characteristics_b':data.project_characteristics_b,
            'calculation_rule':data.calculation_rule,
            'comprehensive_unit_price':data.comprehensive_unit_price,
            'remarks':data.remarks,
            'a_contract_price':data.a_contract_price,
            'a_mechanics_price':data.a_mechanics_price,
            'a_keel_price':data.a_keel_price,
            'a_main_price':data.a_main_price,
            'a_main_loss':data.a_main_loss,
            'a_unit_price':data.a_unit_price,
            'b_contract_price':data.b_contract_price,
            'b_mechanics_price':data.b_mechanics_price,
            'b_keel_price':data.b_keel_price,
            'b_main_price':data.b_main_price,
            'b_main_loss':data.b_main_loss,
            'b_unit_price':data.b_unit_price
          })
            edit = layer.open({
            type : 1,
            title : '编辑',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.edit')
          })
      }else if(obj.event === 'plan')
      {   
        openMax('施工计划','/engineering/construction/plan?house_id='+data.id,function(){
          tab.reload();
        });
      }

    });

    form.on('submit(add)',function(data)
    {
      data = data.field;
      data._token = token;
      data.house_id = house_id;
      $.ajax('/cost/estimate/detailed-add',{
        data : data,
        type : 'post',
        success : function(res)
        {
          layer.close(opens);
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layMsgOk(res.msg);
            tab.reload({
              where : {_token:token,house_id:house_id},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(data)
        {
          layMsgError('新增失败');
        }
      });
      return false;
    });
    form.on('submit(edit)',function(data)
    {
      data = data.field;
      data._token = token;
      $.ajax('/cost/estimate/detailed-edit',{
        data : data,
        type : 'post',
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk(res.msg);
            tab.reload()
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(data)
        {
          layMsgError('编辑失败');
        }
      });
      return false;
    });
    form.verify({
      'price' : function(value)
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
      'num':function(value)
      { 
        if(value)
        {
          s = /^[1-9]\d{0,4}$/;
          if(!s.test(value))
          {
            return '请输入整数 (MIN:1 MAX:5)';
          }
        }
      }
    })
  });
  </script>
@endsection