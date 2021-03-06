@extends("admin.ylxcx.common.base")
@section("index")
    {{--<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>--}}
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','./member-add.html',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{ $count }} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <th>性别</th>
            <th>手机</th>
            <th>邮箱</th>
            <th>地址</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
          @foreach($usersList as $v)
            <tr>
              <td>
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
              </td>
              <td>{{$v->id}}</td>
              <td>{{$v->nickname}}</td>
              <td>
                  @if($v->sex == 1)
                      男
                  @else
                      女
                  @endif
              </td>
              <td>{{$v->user_mobile}}</td>
              <td>{{$v->user_mobile}}</td>
              <td>{{$v->country}} {{$v->province}} {{$v->city}}</td>
              <td>{{ date('Y-m-d H:i:s', $v->created_time)}}</td>
              <td class="td-status">
                @if($v->user_state == 1)
                    <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                @else
                    <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
                @endif
              </td>
              <td class="td-manage">
                  @if($v->user_state == 1)
                      <a onclick="member_stop(this,'{{$v->id}}')" href="javascript:;"  title="停用">
                          <i class="layui-icon">&#xe601;</i>
                      </a>
                  @else
                      <a onclick="member_stop(this,'{{$v->id}}')" href="javascript:;"  title="启用">
                          <i class="layui-icon">&#xe62f;</i>
                      </a>
                  @endif
                <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/user_edit')}}',600,400)" href="javascript:;">
                  <i class="layui-icon">&#xe642;</i>
                </a>
                <a onclick="x_admin_show('修改密码','{{url('admin/editPassword')}}',600,400)" title="修改密码" href="javascript:;">
                  <i class="layui-icon">&#xe631;</i>
                </a>
                <a title="删除" onclick="member_del(this,'{{$v->id}}')" href="javascript:;">
                  <i class="layui-icon">&#xe640;</i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="page">
        <div>
          <a class="prev" href="">&lt;&lt;</a>
          <a class="num" href="">1</a>
          <span class="current">2</span>
          <a class="num" href="">3</a>
          <a class="num" href="">489</a>
          <a class="next" href="">&gt;&gt;</a>
        </div>
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){

              if($(obj).attr('title')=='停用'){
                  layer.confirm('确认要停用吗？',function(index) {
                      //发异步把用户状态进行更改
                      $(obj).attr('title', '启用');
                      $(obj).find('i').html('&#xe62f;');

                      $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                      layer.msg('已停用!', {icon: 5, time: 1000});
                  });

              }else{
                  layer.confirm('确认要启用吗？',function(index){
                    $(obj).attr('title','停用');
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!',{icon: 5,time:1000});
                  });
              }
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
@endsection