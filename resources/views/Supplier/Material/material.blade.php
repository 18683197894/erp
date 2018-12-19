@extends('public')

@section('css')
<style type="text/css">
  .promotion .layui-form-pane .layui-form-label{
  width:160px;
}
</style>

@endsection

@section('open')
<div class="layui-card add" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane"  id="myform"lay-filter="component-form-group">
        <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">材料编码</label>
              <div class="layui-input-inline">
                <input name="code" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商</label>
              <div class="layui-input-inline">
                 <select name="supply_id" lay-verify="required" lay-search>
                    <option value="">直接搜索或选择</option>
                    @foreach($supply as $v)
                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                 </select>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">品牌</label>
              <div class="layui-input-inline">
                <input name="brand" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">型号</label>
              <div class="layui-input-inline">
                <input name="spec" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">规格</label>
              <div class="layui-input-inline">
                <input name="model" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>

            <div class="layui-col-lg4">
              <label class="layui-form-label">颜色</label>
              <div class="layui-input-inline">
                <input name="color" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">计量单位</label>
              <div class="layui-input-inline">
                <input name="metering" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">成本价</label>
              <div class="layui-input-inline">
                <input type="cost_price" name="cost_price" lay-verify="required|cost_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">市场标价</label>
              <div class="layui-input-inline">
                <input type="text" name="market_price" lay-verify="required|market_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">销售价</label>
              <div class="layui-input-inline">
                <input name="sale_price" value="" lay-verify="required|sale_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算价</label>
              <div class="layui-input-inline">
                <input type="text" name="settlement_price" lay-verify="required|settlement_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">采购价</label>
              <div class="layui-input-inline">
                <input type="text" name="purchase_price" lay-verify="required|purchase_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">毛利率</label>
              <div class="layui-input-inline">
                <input name="gross_profit" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算周期</label>
              <div class="layui-input-inline">
                <input type="text" name="settlement_cycle" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">账单时间</label>
              <div class="layui-input-inline">
                <input type="text" name="billing_time" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算比例</label>
              <div class="layui-input-inline">
                <input name="settlement_ratio" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">配件套数</label>
              <div class="layui-input-inline">
                <input type="parts_num" name="parts_num" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产品级别</label>
              <div class="layui-input-inline">
                <input type="text" name="level" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">风格属性</label>
              <div class="layui-input-inline">
                <input name="style" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产品说明</label>
              <div class="layui-input-inline">
                <input type="text" name="explain" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产地</label>
              <div class="layui-input-inline">
                <input type="text" name="place" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否推荐</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="recommend" checked lay-skin="switch" lay-text="推荐|不推荐">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否有货</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="available" checked lay-skin="switch" lay-text="有货|无货">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">效果图</label>
                <div class="layui-upload">
                  <button type="button" class="layui-btn layui-btn-normal" id="test-upload-change">选择文件</button>
                </div>
            </div>
          </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
            </div>
          </div>
         <div class="layui-form-item">
            <label class="layui-form-label">促销</label>
            <div class="layui-input-inline">
            <input type="checkbox" name="promotion" checked lay-skin="switch" lay-text="有|无">
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销开始时间</label>
              <div class="layui-input-inline">
                <input name="start" value="" lay-verify="start" id="start" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结束时间</label>
              <div class="layui-input-inline">
                <input type="text" name="end" lay-verify="end" id="end" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销价</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_price" lay-verify="promotion_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结算价</label>
              <div class="layui-input-inline">
                <input name="promotion_settlement_price" value="" lay-verify="promotion_settlement_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结算比例</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_settlement_proportion" lay-verify="promotion_settlement_proportion" placeholder="请输入促销结算比例" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">计入活动比例</label>
              <div class="layui-input-inline">
                <input type="text" name="activity_proportion" lay-verify="activity_proportion" placeholder="请输入计入活动比例" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销期计入活动比例</label>
              <div class="layui-input-inline">
                <input name="promotion_activity_proportion" value="" lay-verify="promotion_activity_proportion" placeholder="请输入促销期计入活动比例" autocomplete="off" class="layui-input" type="text">
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
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane" id="edit"lay-filter="edit">
        <input type="hidden" name="id" value="">
        <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">材料编码</label>
              <div class="layui-input-inline">
                <input name="code" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">供应商名称</label>
              <div class="layui-input-inline">
                 <select name="supply_id" lay-verify="required" lay-search>
                    <option value="">直接搜索或选择</option>
                    @foreach($supply as $v)
                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                 </select>
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">品牌</label>
              <div class="layui-input-inline">
                <input name="brand" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">型号</label>
              <div class="layui-input-inline">
                <input name="spec" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">规格</label>
              <div class="layui-input-inline">
                <input name="model" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>

            <div class="layui-col-lg4">
              <label class="layui-form-label">颜色</label>
              <div class="layui-input-inline">
                <input name="color" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">计量单位</label>
              <div class="layui-input-inline">
                <input name="metering" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">成本价</label>
              <div class="layui-input-inline">
                <input type="cost_price" name="cost_price" lay-verify="required|cost_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">市场标价</label>
              <div class="layui-input-inline">
                <input type="text" name="market_price" lay-verify="required|market_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">销售价</label>
              <div class="layui-input-inline">
                <input name="sale_price" value="" lay-verify="required|sale_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算价</label>
              <div class="layui-input-inline">
                <input type="text" name="settlement_price" lay-verify="required|settlement_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">采购价</label>
              <div class="layui-input-inline">
                <input type="text" name="purchase_price" lay-verify="required|purchase_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">毛利率</label>
              <div class="layui-input-inline">
                <input name="gross_profit" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算周期</label>
              <div class="layui-input-inline">
                <input type="text" name="settlement_cycle" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">账单时间</label>
              <div class="layui-input-inline">
                <input type="text" name="billing_time" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">结算比例</label>
              <div class="layui-input-inline">
                <input name="settlement_ratio" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">配件套数</label>
              <div class="layui-input-inline">
                <input type="parts_num" name="parts_num" lay-verify="" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产品级别</label>
              <div class="layui-input-inline">
                <input type="text" name="level" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">风格属性</label>
              <div class="layui-input-inline">
                <input name="style" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产品说明</label>
              <div class="layui-input-inline">
                <input type="text" name="explain" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">产地</label>
              <div class="layui-input-inline">
                <input type="text" name="place" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>

          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否推荐</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="recommend" checked lay-skin="switch" lay-text="推荐|不推荐">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">是否有货</label>
              <div class="layui-input-inline">
              <input type="checkbox" name="available" checked lay-skin="switch" lay-text="有货|无货">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">效果图</label>
                <div class="layui-upload">
                  <button type="button" class="layui-btn layui-btn-normal" id="test-upload-change2">选择文件</button>
                </div>
            </div>
          </div>

          <div class="layui-form-item layui-form-text" >
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
              <textarea name="remarks" lay-verify="" placeholder="请输入" class="layui-textarea"></textarea>
            </div>
          </div>
         <div class="layui-form-item">
            <label class="layui-form-label">促销</label>
            <div class="layui-input-inline">
            <input type="checkbox" name="promotion" checked lay-skin="switch" lay-text="有|无">
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销开始时间</label>
              <div class="layui-input-inline">
                <input name="start" value="" lay-verify="start" id="start2" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结束时间</label>
              <div class="layui-input-inline">
                <input type="text" name="end" lay-verify="end" id="end2" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销价</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_price" lay-verify="promotion_price" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结算价</label>
              <div class="layui-input-inline">
                <input name="promotion_settlement_price" value="" lay-verify="promotion_settlement_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销结算比例</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_settlement_proportion" lay-verify="promotion_settlement_proportion" placeholder="请输入促销结算比例" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg4">
              <label class="layui-form-label">计入活动比例</label>
              <div class="layui-input-inline">
                <input type="text" name="activity_proportion" lay-verify="activity_proportion" placeholder="请输入计入活动比例" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg4">
              <label class="layui-form-label">促销期计入活动比例</label>
              <div class="layui-input-inline">
                <input name="promotion_activity_proportion" value="" lay-verify="promotion_activity_proportion" placeholder="请输入促销期计入活动比例" autocomplete="off" class="layui-input" type="text">
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
<div class="layui-card promotion" style="display:none">
    <div class="layui-card-body" style="margin: 15px 15px 15px 0px">
      <form class="layui-form layui-form-pane" id="promotion"lay-filter="promotion">
        <div class="layui-form-item" >
          <div class="layui-col-lg12">
            <label class="layui-form-label">材料编码</label>
            <div class="layui-input-inline">
              <input name="code" value="" readonly="readonly" lay-verify="promotion_activity_proportion" placeholder="" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
        </div>
        <div class="layui-form-item" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">促销开始时间</label>
              <div class="layui-input-inline">
                <input name="start" value="" lay-verify="start"  readonly="readonly" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">促销结束时间</label>
              <div class="layui-input-inline">
                <input type="text" name="end" lay-verify="end" readonly="readonly"  class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-col-lg6">
              <label class="layui-form-label">促销价</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_price" readonly="readonly" lay-verify="promotion_price" placeholder="" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">促销结算价</label>
              <div class="layui-input-inline">
                <input name="promotion_settlement_price" value="" readonly="readonly" lay-verify="promotion_settlement_price" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg6">
              <label class="layui-form-label">促销结算比例</label>
              <div class="layui-input-inline">
                <input type="text" name="promotion_settlement_proportion" lay-verify="promotion_settlement_proportion" placeholder="" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-col-lg6">
              <label class="layui-form-label">计入活动比例</label>
              <div class="layui-input-inline">
                <input type="text" name="activity_proportion" readonly="readonly" lay-verify="activity_proportion" placeholder="" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
          <div class="layui-form-item" >
            <div class="layui-col-lg12">
              <label class="layui-form-label">促销期计入活动比例</label>
              <div class="layui-input-inline">
                <input name="promotion_activity_proportion" readonly="readonly" value="" lay-verify="promotion_activity_proportion" placeholder="" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
          </div>
      </form>
    </div>
</div>
@endsection

@section('content')
<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<form class="layui-form">
		<div class="layui-input-inline">
		    <input class="layui-input" name="code" value="{{ isset($request['code'])?$request['code']:'' }}" val="{{ isset($request['code'])?$request['code']:'' }}" id="code" placeholder="编码搜索" autocomplete="off">
        <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">
        <input type="hidden" id="page" name="page" value="{{ isset($request['page'])?$request['page']:1 }}">
        <input type="hidden" id="limit" name="limit" value="{{ isset($request['limit'])?$request['limit']:10 }}">
		</div>
		<a class="layui-btn">搜索</a>
	</form>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增材料','.add',0.9,0.9)">新增材料</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
	<script type="text/html" id="material">
	  <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="material">进入</a>
	</script>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('layui/city/JAreaData.js') }}"></script>
<script type="text/javascript" src="{{ asset('layui/city/JAreaSelect.js') }}"></script>
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','form','code','laydate','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,laydate = layui.laydate
    ,upload = layui.upload
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/supplier/material'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '材料'
      ,where:{name:$('#name').val(),_token:token,category_id:$('#category_id').val()}
      ,cols: [[
         {field:'code', title:'材料编码',fixed: 'left',unresize:true,width:120}
        ,{title:'供应商',unresize:true,width:120,templet:function(d){
          return d.supply.name;
        }}
        ,{field:'brand', title:'品牌',unresize:true,width:120}
        ,{field:'model', title:'型号',unresize:true,width:120}
        ,{field:'spec', title:'规格',unresize:true,width:120}
        ,{field:'color', title:'颜色',unresize:true,width:120}
        ,{field:'metering', title:'计量单位',unresize:true,width:120}
        ,{field:'cost_price', title:'成本价',unresize:true,width:120}
        ,{field:'market_price', title:'市场标价',unresize:true,width:120}
        ,{field:'sale_price', title:'销售价',unresize:true,width:120}
        ,{field:'settlement_price', title:'结算价',unresize:true,width:120}
        ,{field:'purchase_price', title:'采购价',unresize:true,width:120}
        ,{field:'gross_profit', title:'毛利率',unresize:true,width:120}
        ,{field:'settlement_cycle', title:'结算周期',unresize:true,width:120}
        ,{field:'billing_time', title:'账单时间',unresize:true,width:120}
        ,{field:'settlement_ratio', title:'结算比例',unresize:true,width:120}
        ,{field:'parts_num', title:'配件套数',unresize:true,width:120}
        ,{field:'level', title:'产品级别',unresize:true,width:120}
        ,{field:'style', title:'风格属性',unresize:true,width:120}
        ,{field:'explain', title:'产品说明',unresize:true,width:120}
        ,{field:'place', title:'产地',unresize:true,width:120}
        ,{title:'是否推荐',unresize:true,width:120,templet:function(d){
            if(d.recommend == 1)
            {
              return '推荐';
            }else
            {
              return '不推荐';
            }
        }}
        ,{title:'是否有货',unresize:true,width:120,templet:function(d){
            if(d.available == 1)
            {
              return '有货';
            }else
            {
              return '无货';
            }
        }},
        {title:'促销信息',unresize:true,width:120,templet:function(d){
            if(d.promotion == 1)
            {
              return "<button class='layui-btn layui-btn-xs layui-btn-normal' lay-event='promotion'>查看促销</button>";
            }else
            {
              return '无促销';
            }
        }}
        ,{title:'图片',unresize:true,width:120,templet:function(d){
          if(d.image)
          {       
            return "<a href='"+d.image+"' target='_blank' class='layui-btn layui-btn-xs layui-btn-normal'>查看</a>"      
          }else
          {
            return "无"      
          }
        }}
        ,{field:'remarks', title:'备注',unresize:true,width:120}
        ,{fixed: 'right', title:'操作',fixed: 'right', toolbar: '#test-table-toolbar-barDemo',unresize:true,width:120}
      ]]
      ,page: {curr:$('#page').val(),limit:$('#limit').val()}
    ,parseData: function(res){ //res 即为原始返回的数据
	    return {
	      "code": res.code, //解析接口状态
	      "msg": res.msg, //解析提示文本
	      "count": res.total, //解析数据长度
	      "data": res.data //解析数据列表
	    };
	  }
    });
    //选完文件后不自动上传
    upload.render({
      elem: '#test-upload-change'
      ,url: '/upload/'
      ,auto: false
    });
    upload.render({
      elem: '#test-upload-change2'
      ,url: '/upload/'
      ,auto: false
    });
    laydate.render({
      elem: '#start' //指定元素
    });
    laydate.render({
      elem: '#end' //指定元素
    });
    laydate.render({
      elem: '#start2' //指定元素
    });
    laydate.render({
      elem: '#end2' //指定元素
    });
    $('.demoTable .layui-btn').on('click',function(){
      var code = $('#code').val();
      var category_id = $('#category_id').val();
      $('#code').attr('val',code);
      $('#category_id').attr('val',category_id);
    	tab.reload({where:{code:code,_token:token,category_id:category_id},page:{curr:1}});
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          if(data.length <= 0) return false;
          var id = new Array();
          $.each(data,function(i,n){
          	id.push(n.id);
          });
        layer.confirm('确定删除权限ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/rule-del") }}',
          	type : 'post',
          	data : {id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{
      					layer.close(index);
      					layMsgOk(res.msg);
      					// location.reload(true);
      					tab.reload();
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
          // layer.alert(JSON.stringify(data));
        break;
        case 'getCheckLength':
          // var data = checkStatus.data;
          // layer.msg('选中了：'+ data.length + ' 个');
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });

    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除材料 编码: '+data.code+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/supplier/material-del") }}',
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
          document.getElementById("edit").reset();
          $('.edit').find('input[type="file"]').val('');
          $('.edit').find('.layui-upload-choose').html('');
          form.val("edit", {
            "id" : data.id,
            'supply_id' : data.supply_id,
            'code' : data.code,
            'brand' : data.brand,
            'model' : data.model,
            'spec' : data.spec,
            'color' : data.color,
            'metering' : data.metering,
            'cost_price' : data.cost_price,
            'market_price' : data.market_price,
            'sale_price' : data.sale_price,
            'settlement_price' : data.settlement_price,
            'purchase_price' : data.purchase_price,
            'gross_profit' : data.gross_profit,
            'settlement_cycle' : data.settlement_cycle,
            'billing_time' : data.billing_time,
            'settlement_ratio' : data.settlement_ratio,
            'parts_num' : data.parts_num,
            'available' : data.available,
            'level' : data.level,
            'style' : data.style,
            'place' : data.place,
            'recommend' : data.recommend,
            'remarks' : data.remarks,
            'explain' : data.explain,
            'promotion' : data.promotion,
            'start' : data.start,
            'end' : data.end,
            'promotion_price' : data.promotion_price,
            'promotion_settlement_price' : data.promotion_settlement_price,
            'promotion_settlement_proportion' : data.promotion_settlement_proportion,
            'activity_proportion' : data.activity_proportion,
            'promotion_activity_proportion' : data.promotion_activity_proportion,
          });
          var width = ($(window).width() * 0.9)+'px';
          var height = ($(window).height() * 0.9)+'px';
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
      }else if(obj.event === 'promotion')
      {   
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.6)+'px';
          form.val("promotion", {
            "code" : data.code,
            'start' : data.start,
            'end' : data.end,
            'promotion_price' : data.promotion_price,
            'promotion_settlement_price' : data.promotion_settlement_price,
            'promotion_settlement_proportion' : data.promotion_settlement_proportion,
            'activity_proportion' : data.activity_proportion,
            'promotion_activity_proportion' : data.promotion_activity_proportion,
          });
            promotion = layer.open({
            type : 1,
            title : '促销信息',
            fix: false, //不固定
            maxmin: true,
            shadeClose: true,
            shade: 0.4,
            area : [width,height],
            content : $('.promotion')
          })
      }
    });
    form.on('submit(add)',function(data){
      data = data.field;
      data.category_id = $('#category_id').val();
      datas = new FormData();
      datas.append('image',$('.add').find('input[type="file"]').get(0).files[0]);
      datas.append('_token',token);
      datas.append('data',JSON.stringify(data));

      $.ajax({
        url : '{{ url("/supplier/material-add") }}',
        type : 'post',
        data : datas,        
        contentType : false,
        processData : false,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
            $('#name').val('');
            $('#page').val(1);
            tab.config.page.curr = 1;
            tab.reload({
              where : {_token:token,category_id:$('#category_id').val()},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('新增失败');
        }
      })
      return false;
    })
    form.on('submit(edit)',function(data){
      data = data.field;
      datas = new FormData();
      datas.append('image',$('.edit').find('input[type="file"]').get(0).files[0]);
      datas.append('_token',token);
      datas.append('data',JSON.stringify(data));
      $.ajax({
        url : '{{ url("/supplier/material-edit") }}',
        type : 'post',
        data : datas,        
        contentType : false,
        processData : false,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk(res.msg);
            tab.reload();
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
      'cost_price' : function(value)
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
      'market_price' : function(value)
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
      'sale_price' : function(value)
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
      'settlement_price' : function(value)
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
      'purchase_price' : function(value)
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
      'promotion_price' : function(value)
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
      'promotion_settlement_price' : function(value)
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