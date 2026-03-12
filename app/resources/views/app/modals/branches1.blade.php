<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstmBankName">Bank Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}}" id="lstmBankName">
                <option value="">--Select a Bank--</option>
                @foreach($Banks as $TOP=>$Bank)
                    @if(count($Bank)>0)
                        <optgroup label="{{$TOP}}">
                            @for($i=0;$i<count($Bank);$i++)
                                <option @if($BankID==$Bank[$i]->BankID) selected @endif value="{{$Bank[$i]->BankID}}">{{$Bank[$i]->BankName}}</option>
                            @endfor
                        </optgroup>
                    @endif
                @endforeach
            </select>
            <span class="errors New-Branch-err" id="lstmBankName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmBranchName">Branch Name <span class="required">*</span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtmBranchName" placeholder="Branch Name">
            <span class="errors New-Branch-err" id="txtmBranchName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmIFSCCode">IFSC Code <span class="required">*</span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtmIFSCCode" placeholder="IFSC Code">
            <span class="errors New-Branch-err" id="txtmIFSCCode-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmMICR">Magnetic Ink Character Recognition (MICR) Code </label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtmMICR" placeholder="MICR Code (optional)">
            <span class="errors New-Branch-err" id="txtmMICR-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="txtmBranchEmail">Branch E-Mail </label>
            <input type="email" class="form-control  {{$Theme['input-size']}}" id="txtmBranchEmail" placeholder="Branch E-Mail (optional)">
            <span class="errors New-Branch-err" id="txtmBranchEmail-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateBranch" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#lstmBankName').select2({
            dropdownParent: $('.modal-dialog .modal-content')
        });
    });
</script>