<!-- 引入导航栏目 -->
@include('admin.public.bar')
<h3 align="center">货品添加</h3>
<form action="{{url('Sku/add')}}" method="post">
@csrf
<!-- 隐藏于 -->
<input type="hidden" name="goods_id" value="{{$goodsdata['goods_id']}}">

    <table width="100%" id="table_list" class='table '>
        <tbody >
            <tr>
                <th colspan="20" scope="col">商品名称：{{$goodsdata['goods_name']}}&nbsp;&nbsp;&nbsp;&nbsp;货号：{{$goodsdata['goods_ltem']}}</th>
            </tr>
            <tr>
                <!-- start for specifications -->
                @foreach($arr as $k=>$v)
                    <td scope="col"><div align="center"><strong>{{$k}}</strong></div></td>
                @endforeach
                <td class="label_2">&nbsp;</td>
            </tr>
            <tr>
                <!-- start for specifications_value -->
                @foreach ($arr as $k=>$v)
                    <td align="center" >
                        <select name="goods_attr_id[]">
                            <option value="0" selected="">请选择...</option>
                                @foreach ($v as $vv)
                                    <option value="{{$vv['goods_attr_id']}}">{{$vv['attr_value']}}</option>
                                @endforeach
                        </select>
                    </td>
                @endforeach
                <!-- end for specifications_value -->
                <td class="label_2" >
                     <input type="text" name="goods_num[]" size="10" placeholder="请输入库存" >
                </td>
                <td >
                    <input type="button" class="button addRow" value=" + " >
                </td>
            </tr>

            <tr>
                <td align="center" colspan="6" >
                    <input type="submit" class="button" value=" 保存 ">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script>
      // 加减号
    $(document).on('click','.addRow',function(){
        var _this=$(this);
        var value=_this.val();
        if(value==' + '){
          $(this).val(' - ');
           var tr=_this.parents('tr');
           var tr_clone=tr.clone();
           $(this).val(' + ');
           tr.after(tr_clone);
        }else{
            _this.parents('tr').remove();
        }
    })
</script>
