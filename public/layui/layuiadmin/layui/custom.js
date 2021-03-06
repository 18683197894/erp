function layMsgOk(message,fun=null) {
  layer.msg(message, {icon:1},fun);
}
function layMsgError(message,fun=null) {
  layer.msg(message, {icon:2, anim:6,time:1500},fun);
}
function open_show(title,url,w,h,pid,ptitle)
{   
    var layer = layui.layer;
    var admin = layui.admin
    var $ = layui.jquery;
    var width = $(window).width(); 
    var height = $(window).height();
    document.getElementById("myform").reset();
    $('.reset').click();
    $('.add').find('input[type="file"]').val('');
    $('.add').find('.layui-upload-choose').html('');
    if(w)
    {
      area = [(width * w)+'px',(height * h)+'px']
    }else
    {
        area = admin.screen() < 2 ? ['80%', '300px'] : ['700px', '500px']
    }
    if(pid)
    {
      $(url).find('input[index="pid"]').val(pid);
    }
    if(ptitle)
    {
      $(url).find('input[index="ptitle"]').val(ptitle);
    }
    opens = layer.open({
    title:title
    ,type: 1
    // ,skin: 'layui-layer-rim'
    ,maxmin: true
    ,shadeClose: true
    ,area: area
    ,content: $(url)
  });
}
openMax = function(title,url,fun=null){
  layer.open({
    type : 2,
    title : title,
    fix: false, //不固定
    maxmin: true,
    shadeClose: true,
    area : [$(window).width() * 0.95+'px',$(window).height() * 0.9+'px'],
    shade: 0.4,
    content : url,
    end : fun
  })
}
// 搜索重置刷新
reset = function(data=null)
{ 
  document.getElementById("query").reset();
  if(data)
  { 
    data._token = token;
    tab.reload({where:data});
  }else
  {
    tab.reload({where:{_token:token}});
  }
}
tableCheck = {
    init:function()
    {
        $(".layui-form-checkbox").click(function(event) {
          if($(this).hasClass('layui-form-checked')){
              $(this).removeClass('layui-form-checked');
              if($(this).hasClass('cate')){
                  $(this).parents('tr').find('td').eq(1).find('.layui-form-checkbox').removeClass('layui-form-checked');
              }
          }else{
              $(this).addClass('layui-form-checked');
              if($(this).hasClass('cate')){
                  $(this).parents('tr').find('td').eq(1).find('.layui-form-checkbox').addClass('layui-form-checked');
              }
          }
          
        });
    },
    getDate:function(obj)
    {

          var obj = $(obj).find(".layui-form-checked").not('.header');
          var arr=[];
          obj.each(function(index, el) {
              if(obj.eq(index).attr('data-id'))
              {
                  arr.push(obj.eq(index).attr('data-id'));
              }
          });
          return arr;

    },
    tableCheckClose : function(obj)
    {
        $(obj).find('.layui-form-checkbox').removeClass('layui-form-checked');
    }
}