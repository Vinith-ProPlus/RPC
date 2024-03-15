<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstmTOB">Bank Type <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} mselect2" id="lstMBankType" data-parent=1 >
                <option value="">-- Select a Bank Type --</option>
                @for($i=0;$i<count($BankType);$i++)
                    <option @if($BankType[$i]->SLNO==$BankTypeID) selected @endif value="{{$BankType[$i]->SLNO}}">{{$BankType[$i]->TypeOfBank}}</option>
                @endfor
            </select>
            <span class="errors New-Bank-err" id="lstMBankType-err"></span>
        </div>
    </div>
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMBankName">Bank Name <span class="required">*</span></label>
            <input type="text" id="txtMBankName"  class="form-control  {{$Theme['input-size']}}" placeholder="Bank Name"  value="" autofocus>
            <span class="errors New-Bank-err" id="txtMBankName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-30 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateBank" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.mselect2').select2({
            dropdownParent: $('.dynamicValueModal')
        });
    })
</script>