<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="lstMBank">Bank Name <span class="required">*</span></label>
            <select class="form-control  {{$Theme['input-size']}} select2" id="lstMBank">
                <option value="">--Select a Bank--</option>
                @foreach($Bank as $TOB=>$banks)
                    @if(count($Bank)>0)
                        <optgroup label="{{$TOB}}">
                            @foreach($banks as $item)
                                <option @if($BankID==$item->BankID) selected @endif value="{{$item->BankID}}">{{$item->NameOfBanks}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
            <span class="errors New-BankBranch-err" id="lstMBank-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMBranchName">Branch Name <span class="required">*</span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMBranchName" placeholder="Branch Name">
            <span class="errors New-BankBranch-err" id="txtMBranchName-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMIFSCCode">IFSC Code <span class="required">*</span></label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMIFSCCode" placeholder="IFSC Code">
            <span class="errors New-BankBranch-err" id="txtMIFSCCode-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMMICR">Magnetic Ink Character Recognition (MICR) Code </label>
            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtMMICR" placeholder="MICR Code (optional)">
            <span class="errors New-BankBranch-err" id="txtMMICR-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label for="txtMBranchEmail">Branch E-Mail </label>
            <input type="email" class="form-control  {{$Theme['input-size']}}" id="txtMBranchEmail" placeholder="Branch E-Mail (optional)">
            <span class="errors New-BankBranch-err" id="txtMBranchEmail-err"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-30 text-right">
        <button id="btnCloseModal" class="btn btn-outline-dark {{$Theme['button-size']}} mr-10">Close</a>
        <button id="btnCreateBankBranch" type="button" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} ">Create</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#lstMBank').select2({
            dropdownParent: $('.dynamicValueModal'),
        });
    });
</script>