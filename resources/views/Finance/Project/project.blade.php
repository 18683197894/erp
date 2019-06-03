@extends('public')

@section('css')

@endsection
@section('open')

@endsection

@section('content')

<div class="layui-card-body">
  <div class="demoTable" style="padding-bottom: 10px">
  
  </div>
  <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
  <script type="text/html" id="test-table-toolbar-barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  </script>
  <script type="text/html" id="price">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="price">进入</a>
  </script>
  <script type="text/html" id="income">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="income">进入</a>
  </script>
</div>

@endsection

@section('js')
<script>

  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table','upload'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table
    ,upload = layui.upload
    token = $("meta[name='csrf-token']").attr('content');
    department_id = {{ $department->id }};
  $(function () {
        $("td").on("mouseenter",function() {
            if (this.offsetWidth < this.scrollWidth) {
                var that = this;
                var text = $(this).text();
                layer.tips(text, that,{
                    tips: 1,
                    time: 2000
                });
            }
        });
    })
      tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/finance/project/department/'+department_id
      ,where:{_token:token,department_id:department_id}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '预估测算'
      ,cols: [[
         {field:'id',title:'序号',fixed: 'left',unresize:true,width:'4%',rowspan:2}
        ,{field:'department_name',title:'部门',unresize:true,width:'5%',rowspan:2}
        ,{field:'name',title:'项目名称',unresize:true,width:120,width:'7%',rowspan:2}
        ,{title:'最近费用',unresize:true,align:'center',colspan:7}
        ,{field:'total_should', title:'房间总应收',unresize:true,width:'7%',rowspan:2}
        ,{field:'total_money', title:'房间总实收',unresize:true,width:'7%',rowspan:2}
        ,{field:'total_zhichu', title:'房间总支出',unresize:true,width:'7%',rowspan:2}
        ,{title:'房间明细',unresize:true, toolbar:'#price',width:'6%',rowspan:2}
        ,{title:'收入明细',unresize:true, toolbar:'#income',width:'6%',rowspan:2}
        ,{fixed: 'right',field:'price_surplus',title:'项目剩余费用',unresize:true,width:'8%',rowspan:2}
      ],[
         {field:'house', title:'房间',unresize:true,width:'7%'}
        ,{field:'price_cost_name', title:'费用属性',unresize:true,width:'5%'}
        ,{field:'price_purpose', title:'用途',unresize:true,width:'5%'}
        ,{field:'price_money', title:'费用金额',unresize:true,width:'5%'}
        ,{field:'price_name', title:'费用名称',unresize:true,width:'6%'}
        ,{field:'payment_time', title:'收款/付款时间',unresize:true,width:'6%'}
        ,{field:'remarks', title:'备注',unresize:true}
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
    form.on('submit(query)',function(data){
      data = data.field;
      data._token = token;
      tab.reload({where:data});
      return false;
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          // layer.alert(JSON.stringify(data));
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'edit')
      {
        layer.prompt({
          title : '项目剩余费用'
          ,formType: 0
          ,value: data.price_surplus
        }, function(value, index){
          if(value)
          {
            s = /^\d{1,8}\.\d{1,2}$/;
            sS = /^\d{1,8}$/;
            if(!s.test(value) && !sS.test(value))
            {
              layMsgError('请输入整数 (MIN:1 MAX:8 保留小数点2位)');
              return false;
            }
          }
          $.ajax({
            url:'{{ url("/finance/project/department-edit") }}',
            type : 'post',
            data : {id:data.id,price_surplus:value,_token:token},
            success : function(res)
            { 
              res = $.parseJSON(res);
              if(res.code == 200)
              {
                obj.update({
                  price_surplus: value
                });
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
      }else if(obj.event === 'price')
      {
        openMax('房间明细','/finance/project/price?department_id='+department_id+'&project_id='+data.id,function(){
          tab.reload();
        });
      }else if(obj.event === 'income')
      {
        openMax('详细','/finance/project/income?department_id='+department_id+'&project_id='+data.id);
      }
    });
  });

  </script>
@endsection

