
function layMsgOk(message) {
  layer.msg(message, {icon:1});
}
function layMsgError(message) {
  layer.msg(message, {icon:2, anim:6,time:1500});
}
function open_show(title,url,w,h,pid,ptitle)
{   
    var layer = layui.layer;
    var admin = layui.admin
    var $ = layui.jquery;
    var width = $(window).width(); 
    var height = $(window).height();
    document.getElementById("myform").reset();
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