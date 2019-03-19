@extends('public')

@section('css')
<style type="text/css">
.nones{
  display:none;
}
.level_one,.level_one:hover{
  border:2px solid #ff0000;
}
.level_two{
  border:2px solid #9933ff;
}
.level_three{
  border:2px solid #3c3;
}
</style>
@endsection

@section('open')
<div class="layui-card level1" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form id="myform" class="layui-form layui-form-pane">
                @csrf
                <input type="hidden" name="level" value="1">
                <input type="hidden" name="pid" value="0">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        标题
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="title" name="title" required="" lay-verify="title"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        图标样式
                    </label>
                    <div class="layui-input-block">
                        <input type="lcon" id="title" name="lcon" required="" lay-verify="required|lcon"
                        autocomplete="off"  class="layui-input">
                    </div>
                    <div class="hint-block">详情请参考：<a class="aurl" href="https://www.layui.com/doc/element/icon.html#table" target="_blank">layui-icon</a></div>
                </div>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        排序
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="sort" name="sort" required="" lay-verify="sort"
                        autocomplete="off"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">状态</label>
                  <div class="layui-input-block" style="border:1px solid rgb(230, 230, 230);">
                    <input type="radio" name="status" value="1" title="启用" checked="">
                    <input type="radio" name="status" value="0" title="禁用">
                  </div>
                </div>

                <div class="layui-form-item">
                  <label class="layui-form-label">路由地址</label>
                  <div class="layui-input-block">
                    <select disabled="disabled" name="url" lay-verify="required">
                      <option value="#">#</option>
                    </select>
                  </div>
                 </div>
                 <br>
                 <br>
                <div class="layui-form-item">

                <button class="layui-btn" lay-submit="" lay-filter="menu_add" >增加</button>
              </div>
        </form>
      </div>
</div>
<div class="layui-card level2" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form id="myform" class="layui-form layui-form-pane">
                <input type="hidden" name="pid" index="pid" value="">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        标题
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="title" name="title" required="" lay-verify="title"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        图标样式
                    </label>
                    <div class="layui-input-block">
                        <input type="lcon" id="title" name="lcon" required="" lay-verify="lcon"
                        autocomplete="off"  class="layui-input">
                    </div>
                    <div class="hint-block">详情请参考：<a class="aurl" href="https://www.layui.com/doc/element/icon.html#table" target="_blank">layui-icon</a></div>
                </div>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        排序
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="sort" name="sort" required="" lay-verify="sort"
                        autocomplete="off"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">状态</label>
                  <div class="layui-input-block" style="border:1px solid rgb(230, 230, 230);">
                    <input type="radio" name="status" value="1" title="启用" checked="">
                    <input type="radio" name="status" value="0" title="禁用">
                  </div>
                </div>

                <div class="layui-form-item">
                  <label class="layui-form-label">路由地址</label>
                  <div class="layui-input-block">
                    <select name="url" lay-search="" lay-verify="required">
                      <option value="">直接选择或搜索选择</option>
                      @foreach($path as $val)
                      <option value="{{ $val }}">{{ $val }}</option>
                      @endforeach
                    </select>
                  </div>
                 </div>
                 <br>
                 <br>
                <div class="layui-form-item">

                <button class="layui-btn" lay-submit="" lay-filter="menu_add" >增加</button>
              </div>
        </form>
      </div>
</div>
<div class="layui-card edit" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form id="myform" class="layui-form layui-form-pane" lay-filter="edit">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        标题
                    </label>
                    <div class="layui-input-block">
                        <input type="text" name="title" required="" lay-verify="title"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        图标样式
                    </label>
                    <div class="layui-input-block">
                        <input type="lcon" name="lcon"  lay-verify="lcon"
                        autocomplete="off"  class="layui-input">
                    </div>
                    <div class="hint-block">详情请参考：<a class="aurl" href="https://www.layui.com/doc/element/icon.html#table" target="_blank">layui-icon</a></div>
                </div>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        排序
                    </label>
                    <div class="layui-input-block">
                        <input type="text" name="sort" required="" lay-verify="required|sort"
                        autocomplete="off"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">状态</label>
                  <div class="layui-input-block" style="border:1px solid rgb(230, 230, 230);">
                    <input type="radio" name="status" value="1" title="启用">
                    <input type="radio" name="status" value="0" title="禁用">
                  </div>
                </div>

                <div class="layui-form-item">
                  <label class="layui-form-label">路由地址</label>
                  <div class="layui-input-block">
                    <input type="text" disabled="disabled" name="url"
                        autocomplete="off"  class="layui-input">
                  </div>
                 </div>
                 <br>
                 <br>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="edit" >编辑</button>
              </div>
        </form>
      </div>
</div>
@endsection

@section('content')
          <div class="layui-card-body" >
              <button class="layui-btn layui-btn-normal" onClick="open_show('创建菜单','.level1',0.5,0.75)" style="">创建菜单</button>
            
          <table class="layui-table" style="border-left: 0;border-right:0" lay-size="lg" lay-even="" lay-skin="line">
            <colgroup>
              <col width="60">
              <col width="180">
              <col width="120">
              <col width="200">
              <col width="120">
              <col width="150">
              <col width="210">
              <col>
            </colgroup>
            <thead>
              <tr>
                <th>折叠</th>
                <th>标题</th>
                <th>类别</th>
                <th>路由</th>
                <th>图标</th>
                <th>排序</th>
                <th>操作</th>
              </tr> 
            </thead>
            <tbody>

            @foreach($menu as $k => $v)
              <tr id="{{ $v->id }}" class="0" style="background-color: #fff;">
                <td><i class="layui-icon cick ok">&#xe61a;</i></td>
                <td>{{ $v->title }}</td>
                <td>一级菜单</td>
                <td>{{ $v->url }}</td>
                <td><i class="layui-icon {{ $v->lcon }}"></i></td>
                <td><input type="text" id="{{ $v->id }}" val="{{ $v->sort }}"  class="layui-input level_one sorts" name="sort" value="{{ $v->sort }}"></td>
                <td>
                  <button class="layui-btn  layui-btn-sm layui-btn-normal" onClick="open_show('上级目录: {{ $v->title }}','.level2',0.5,0.8,'{{ $v->id }}')">创建菜单</button>
                  <button class="layui-btn  layui-btn-sm" onClick="menuEdit('{{json_encode($v)}}')">编辑</button>
                  <button class="layui-btn layui-btn-danger  layui-btn-sm" onClick="menu_del(this,'{{ $v->id }}','{{ $v->title }}',1)">删除</button>
                  
                </td>
              </tr>
            @foreach($v->Menus as $val)
              <tr class="{{ $v->id }}" style="background-color: #fff;">
                <td></td>
                <td>@if($loop->last) └── {{ $val->title }} @else ├── {{ $val->title }}  @endif</td>
                <td>二级菜单</td>
                <td>{{ $val->url }}</td>
                <td><i class="layui-icon {{ $val->lcon }}"></i></td>
                <td><input type="text" id="{{ $val->id }}" val="{{ $val->sort }}"  class="layui-input level_two sorts" name="sort" value="{{ $val->sort }}"></td>
                <td>
                  @if($val->url == '#')
                  <button class="layui-btn  layui-btn-sm layui-btn-normal" onClick="open_show('上级目录: {{ $val->title }}','.level2',0.5,0.8,'{{ $val->id }}')">创建菜单</button>
                  @else
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  @endif
                  <button class="layui-btn  layui-btn-sm" onClick="menuEdit('{{json_encode($val)}}')">编辑</button>
                  <button class="layui-btn layui-btn-danger  layui-btn-sm" onClick="menu_del(this,'{{ $val->id }}','{{ $val->title }}',2)">删除</button>

                </td>
              </tr>
            @foreach($val->Menus as $value)
              <tr class="{{ $v->id }}" pid="{{ $val->id }}" style="background-color: #fff;">
                <td></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@if($loop->last) └── {{ $value->title }} @else ├── {{ $value->title }}  @endif</td>
                <td>三级菜单</td>
                <td>{{ $value->url }}</td>
                <td><i class="layui-icon {{ $value->lcon }}"></i></td>
                <td><input type="text" id="{{ $value->id }}" val="{{ $value->sort }}" class="layui-input level_three sorts" name="sort" value="{{ $value->sort }}"></td>
                <td>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <button class="layui-btn  layui-btn-sm" onClick="menuEdit('{{json_encode($value)}}')">编辑</button>
                  <button class="layui-btn layui-btn-danger  layui-btn-sm" onClick="menu_del(this,'{{ $value->id }}','{{ $value->title }}',3)">删除</button>
                </td>
              </tr>
            @endforeach
            @endforeach
            @endforeach

            </tbody>
          </table> 
          </div>

@endsection

@section('js')
<script>

  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form'], function(){
    $ = layui.jquery
    ,admin = layui.admin
    ,element = layui.element
    ,router = layui.router()
    ,form = layui.form
    ,layer = layui.layer;

    element.render('collapse');
    token = $("meta[name='csrf-token']").attr('content');

    $(".cick").on('click',function(){
      var tr = $(this).parents('tr');
      index = tr.attr('id');

      if($(this).hasClass('no'))
      {
        $(this).removeClass('no');
        $(this).addClass('ok');
        $(this).html('&#xe61a;');
        tr.nextAll('.'+index).addClass('table-row');
        tr.nextAll('.'+index).removeClass('nones');
      }else
      {
        $(this).removeClass('ok');
        $(this).addClass('no');
        $(this).html('&#xe602;');
        tr.nextAll('.'+index).removeClass('table-row');
        tr.nextAll('.'+index).addClass('nones');

      }
    });
    form.verify({
      title:function(value)
      {
        if(value.length > 20 || value.length <= 0 )
        {
          return '格式错误';
        }
      },
      sort:function(value)
      {
        if(value.length <= 0 || !value.match(/^[0-9]*$/))
        {
          return '请输入数字排序';
        }
      }
    });
    form.on('submit(menu_add)',function(data){
      data = data.field;
      data._token = token;
      console.log(data);
      $.ajax({
        url : '{{url("/nav/menu-add")}}',
        type : 'post',
        data : data,
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          { 
            layer.close(opens);
            layer.msg(res.msg, {icon: 1,time: 1000}, function(){
              window.location.reload();
            });
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('操作失败 请联系管理员');
        }
      })
      return false;
    });
    $('.sorts').on('blur',function(){
      var inp = $(this);
      var sort = $(this).val();
      var id = $(this).attr('id');
      var usedSort = $(this).attr('val');
      if(sort.length <= 0 || !sort.match(/^[0-9]*$/))
      {
          $(this).val(usedSort);
          layer.alert('请输入数字排序',{title:'错误',icon:5,btn:['确认']});
          return false;
      }
      if(sort == usedSort)
      { 
        return false;
      }

      $.ajax({
        url : "{{ url('/nav/menu-sort') }}",
        type : 'post',
        data : {id:id,sort:sort,_token:token},
        success : function(res)
        {
          var res = $.parseJSON(res);
          if(res.code == 200)
          {
            inp.attr('val',sort);
            // layMsgOk(res.info);
          }else if(res.code == 501)
          {
            inp.val(usedSort);
            layMsgError(res.msg);
          }
          else
          {
            inp.val(usedSort);
            layMsgError('操作失败');
          }
        },
        error : function(error)
        {
          inp.val(usedSort);
          layMsgError('操作失败');
        }
      })
    })
    form.on('submit(edit)',function(data){
      // console.log(data);
      data = data.field;
      data._token = token;
      $.ajax("{{ url('/nav/menu-edit/') }}",{
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(edit);
            layMsgOk(res.msg,function(){
              window.location.reload();
            });
          }else if(res.code == 501)
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('操作失败');
        }
      });
      return false;
    });
  });
      function menuEdit(data)
      {
        data = $.parseJSON(data);
        // console.log(data.status);return false;
        var width = ($(window).width() * 0.5)+'px';
        var height = ($(window).height() * 0.8)+'px';
        form.val('edit',{
          'title' : data.title,
          'lcon' : data.lcon,
          'sort' : data.sort,
          'status' : data.status+'',
          'url' : data.url,
          'id'  : data.id,


        });
          edit = layer.open({
          type : 1,
          title : '编辑菜单',
          fix: false, //不固定
          maxmin: true,
          shadeClose: true,
          shade: 0.4,
          area : [width,height],
          content : $('.edit')          
        });
      }

      function menu_del(obj,id,name,itps)
      {
        layer.confirm('确定删除菜单: '+name+' 吗? 如有子菜单将一并清空',function(index){
          $.ajax({
            url : '{{ url("/nav/menu-del") }}',
            type : 'post',
            data : {id:id,_token:$("meta[name='csrf-token']").attr('content')},
            success : function(res)
            {
              var res = $.parseJSON(res);
              if(res.code == 200)
              {
                if(itps == 1)
                {
                  $(obj).parents('tr').css('display','none');
                  $(obj).parents('tr').nextAll('.'+id).css('display','none');
                }else if(itps == 2)
                {
                  $(obj).parents('tr').css('display','none');
                  $(obj).parents('tr').nextAll("tr[pid='"+id+"']").css('display','none');

                }else if(itps == 3)
                {
                  $(obj).parents('tr').css('display','none');
                }
                layMsgOk(res.msg);

              }else if(res.code == 501)
              {
                layMsgError(res.msg);
              }else
              {
                layMsgError('删除失败');
              }
            },
            error : function(error)
            {
              layMsgError('删除失败');
            }
          })
        })
      } 


  </script>
@endsection