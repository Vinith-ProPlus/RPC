<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstmTOB">Type of Bank <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} select2" id="lstmTOB">
                <option value="">-- Select a Type of Bank --</option>
                @for($i=0;$i<count($TypeOfBank);$i++)
                    <option  value="{{$TypeOfBank[$i]->SLNO}}">{{$TypeOfBank[$i]->TypeOfBank}}</option>
                @endfor
            </select>
            <span class="errors New-Bank-err" id="lstmTOB-err"></span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmBankName">Bank Name <span class="required">*</span></label>
            <input type="text" id="txtmBankName"  class="form-control  {{$Theme['input-size']}}" placeholder="Bank Name"  value="" autofocus>
            <span class="errors New-Bank-err" id="txtmBankName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateBank" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#lstmTOB').select2({
            dropdownParent: $('.modal-dialog .modal-content')
        });
    })
</script>