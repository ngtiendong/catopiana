<div class="box-body">
    <form method="POST" id="frmMoveCustomer" action="/admin/user/move">
        <input type="hidden" name="old_user_id" value="{{$user_id}}">
        <div class="col-md-12">
            <label>Chọn người thay thế</label>
            <select name="new_user_id" class="row-fluid user_move" style="width: 100%">
                <option value="0">---Chọn người thay thế---</option>
                @foreach($users  as $item)
                    <option value="{{$item->id}}">{{$item->username}}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
<div class="box-footer text-center">
    <button class="btn btn-success" id="btnSubmitMove" type="button" onclick="return onSubmitMove();">Cập nhật</button>
</div>
<script type="text/javascript">

    $(document).ready(function () {
       $('.user_move').select2();
    });

    function onSubmitMove(){
        btn_loading.loading('btnSubmitMove');

        formHelper.postFormJson('frmMoveCustomer', function (result) {
            btn_loading.hide('btnSubmitMove');
            if(result.err == 1){
                alert(result.msg);
            }else{
                alert(result.msg);
                window.location.reload();
            }
        });
    }

</script>