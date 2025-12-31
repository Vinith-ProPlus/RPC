@extends('layouts.pdf')
@section('content')
    <div id="ct-main-container">
        <div class="actual-quotaion ct-page-layout " data-page=1>
            <div class="ct-header">
                <div class="ct-logo-wrapper">
                    <img src="{{url('/')}}/{{$Company['Logo']}}" alt="">
                    <span class="ct-name">RPC <span>Builders Supply</span>
                    </span>
                </div>
            </div>
            <div class="ct-body">
                <div class="ct-body-content">
                    <div class="ct-quote-title">
                        <div class="ct-title">Quotaion </div>
                        <div>Quotaion No : {{$QID}}</div>
                    </div>
                    <div class="row mt-10 fs-12 invoice-details">
                        <div class="col-sm-6 pr-20">
                            <div class="lh-24 fw-700 fs-15 pb-5">Contact Info :</div>
                            <div class="row p-0">
                                <div class="col-12">
                                    <table class="table table-sm header-table  fs-11">
                                        <tr>
                                            <td>Name </td>
                                            <td>: {{$QData->CustomerName}} </td>
                                        </tr>
                                        <tr>
                                            <td>Email </td>
                                            <td class="break-word">: {{$QData->Email}} </td>
                                        </tr>
                                        <tr>
                                            <td>Contact No </td>
                                            <td>: {{$QData->MobileNo1}} </td>
                                        </tr>
                                        <tr>
                                            <td>Expiry Date </td>
                                            <td>: {{date($Settings['date-format'], strtotime($QData->QExpiryDate))}} </td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person </td>
                                            <td>: {{$QData->ReceiverName}}<br> ({{$QData->ReceiverMobNo}})</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 fs-11">
                            <div class="lh-24 fw-700 fs-14 pb-5">Billing Address :</div>
                            <div class="lh-24">
                                <?php
                                    $Address="";
                                    if($QData->BAddress!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BAddress;}
                                    if($QData->BCityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BCityName;}
                                    if($QData->BTalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BTalukName;}
                                    if($QData->BDistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BDistrictName;}
                                    if($QData->BStateName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BStateName;}
                                    if($QData->BCountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$QData->BCountryName;}
                                    if($QData->BPostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$QData->BPostalCode;}
                                    if($Address!=""){$Address.=".";}
                                    echo  $Address;
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3 fs-11">
                            <div class="lh-24 fw-700 fs-14 pb-5">Shipping Address :</div>
                            <div class="lh-24">
                                <?php
                                    $DAddress="";
                                    if($QData->DAddress!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DAddress;}
                                    if($QData->DCityName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DCityName;}
                                    if($QData->DTalukName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DTalukName;}
                                    if($QData->DDistrictName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DDistrictName;}
                                    if($QData->DStateName!=""){if($DAddress!=""){$DAddress.=",<br>";}$DAddress.=$QData->DStateName;}
                                    if($QData->DCountryName!=""){if($DAddress!=""){$DAddress.=", ";}$DAddress.=$QData->DCountryName;}
                                    if($QData->DPostalCode!=""){if($DAddress!=""){$DAddress.=" - ";}$DAddress.=$QData->DPostalCode;}
                                    if($DAddress!=""){$DAddress.=".";}
                                    echo  $DAddress;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="width-per-100 mt-10 quote-table">
                        <table class="ct-table fs-11 fw-400">
                            <thead>
                                <tr>
                                    <th class="text-center">SNo. <div>&nbsp;</div></th>
                                    <th class="text-center">Description <div>&nbsp;</div></th>
                                    <th class="text-center">Qty <div>&nbsp;</div></th>
                                    <th class="text-center">Price <div>&nbsp;</div></th>
                                    @if(count($QData->Details)>0)
                                        <th class="text-center">Taxable <div>( <i class="fa fa-inr"></i>) </div></th>
                                        @if(floatval($QData->Details[0]->IGSTAmt)<=0)
                                            <th class="text-center">CGST <div>( <i class="fa fa-inr"></i>) </div></th>
                                            <th class="text-center">SGST <div>( <i class="fa fa-inr"></i>) </div></th>
                                        @else
                                            <th class="text-center">IGST <div>( <i class="fa fa-inr"></i>) </div></th>
                                        @endif
                                    @endif
                                    <th class="text-center">Sub Total <div>( <i class="fa fa-inr"></i>) </div></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="ct-table-footer fs-12">
                            <div class="ct-totals">
                                <div class="ct-sub-total fs-12">
                                    <div>Sub Total ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                    <div class="text-right">{{NumberFormat($QData->SubTotal,$Settings['price-decimals'])}}</div>
                                </div>
                                @if(count($QData->Details)>0)
                                    @if(floatval($QData->Details[0]->IGSTAmt)<=0)
                                        <div class="ct-cgst fs-12">
                                            <div>CGST ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                            <div class="text-right">{{NumberFormat($QData->CGSTAmount,$Settings['price-decimals'])}}</div>
                                        </div>
                                        <div class="ct-sgst fs-12">
                                            <div>SGST ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                            <div class="text-right">{{NumberFormat($QData->SGSTAmount,$Settings['price-decimals'])}}</div>
                                        </div>
                                    @else
                                        <div class="ct-sgst fs-12">
                                            <div>IGST ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                            <div class="text-right">{{NumberFormat($QData->IGSTAmount,$Settings['price-decimals'])}}</div>
                                        </div>
                                    @endif
                                @endif
                                @if(floatval($QData->AdditionalCost)>0)
                                    <div class="ct-sgst fs-13 fw-700">
                                        <div>Total Amount ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                        <div class="text-right">{{NumberFormat($QData->TotalAmount,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="ct-sgst fs-12">
                                        <div>Additional Amount ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                        <div class="text-right">{{NumberFormat($QData->AdditionalCost,$Settings['price-decimals'])}}</div>
                                    </div>
                                @endif
                                <div class="ct-total-amount fs-14 fw-700">
                                    <div>Net Amount ( <i class="fa fa-inr"></i>) <span> :</span></div>
                                    <div class="text-right">{{NumberFormat($QData->NetAmount,$Settings['price-decimals'])}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ct-footer">
                <div class="primary-bar width-per-100  mt-30 "></div>
                <div class="ct-footer-content">
                    <span>RPC Builders Supply</span>
                    <span>{{date("M-Y",strtotime($QData->QDate))}}</span>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none" id="divInvDetails"><?php echo json_encode($QData->Details); ?></div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
		let pageNo = 1;
		let pageMaxHeight, tableFooterHeight;
        let imageLoadPromises = []; // Array to hold all image load promises
        const init=async()=>{
			pageMaxHeight = $('.actual-quotaion.ct-page-layout[data-page="1"] .ct-body').height();
			tableFooterHeight = $('.ct-table-footer').outerHeight();
		    await loadTable();
        }
        const getOrderData=async()=>{
            return await new Promise(async(resolve,reject)=>{
                let data=[];
                try {
                    data=$('#divInvDetails').html();
                    data=JSON.parse(data);
                } catch (error) {
                    
                }
                resolve(data);
            });
        }
        const clonePage = () => {
			let $currentPage = $('.actual-quotaion.ct-page-layout[data-page="' + pageNo + '"]');
			let $newPage = $currentPage.clone().attr('data-page', ++pageNo).addClass('no-header');
			$newPage.find('.ct-header, .ct-quote-title, .invoice-details').remove();
			$newPage.find('.quote-table table tbody').empty();
			$('#ct-main-container').append($newPage);
		};
	    const getRowHeight =async (item,index) => {
            let html=await getHTML(item,index);

			let tempRow = $('<tr>').html(html).appendTo($('.quote-table table tbody'));
			let rowHeight = tempRow.height();
			tempRow.remove();
			return rowHeight;
		};
		const generatePDF = async () => {
            const pdfBlob = await new Promise((resolve, reject) => {
                let element = document.querySelector('#ct-main-container');
                let opt = {
                    margin: 0,
                    filename: '{{$QData->QNo}}.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { scale: 5, useCORS: true },
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                };

                window.html2pdf()
                    .set(opt)
                    .from(element)
                    .toPdf()
                    .get('pdf') // Get the PDF instance
                    .output('blob') // Directly call output to get a blob
                    .then(blob => {
                        resolve(blob); // Resolve the blob
                    })
                    .catch(reject); // Handle any errors in PDF generation
            });

            const formData = new FormData();
            formData.append('QID', '{{$QData->QID}}');
            formData.append('ChatID', '{{$ChatID}}');
            formData.append('isPDF', '1');
            formData.append('pdf', pdfBlob, '{{$QData->QNo}}.pdf');

            $.ajax({
                type: "post",
                url: "{{route('admin.chat.save.quote.pdf')}}",
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                dataType: "json",
                data: formData,
                async:true,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(response) {
                    if (response.status) {
                        window.close();
                    } else {
                        alert("Failed to save the PDF. Please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    
                }
            });
		}
        const QtyFormat=(value,Decimal)=>{
            try {
                if((value=="")||(value==undefined)||(isNaN(parseFloat(value)))){
                    value=0;
                }
                if(Decimal!="auto"){
                    return parseFloat(value).toFixed(Decimal);
                }else{
                    return value;
                }
            } catch (error) {
                return value;
            }
        }
        const NumberFormat=(value,type)=>{
            try {
                if((value=="")||(value==undefined)||(isNaN(parseFloat(value)))){
                    value=0;
                }
                let Decimal="auto";
                let settings=$('#divsettings').html();
                if(settings!=""){
                    settings=JSON.parse(settings);
                }
                type=type.toString().toLowerCase();
                if(type=="weight"){
                    if(settings['weight-decimals']!=undefined){
                        Decimal=settings['weight-decimals'];
                    }
                }else if(type=="price"){
                    if(settings['price-decimals']!=undefined){
                        Decimal=settings['price-decimals'];
                    }
                }else if(type=="qty"){
                    if(settings['qty-decimals']!=undefined){
                        Decimal=settings['QTY-decimals'];
                    }
                }else if(type=="percentage"){
                    if(settings['percentage-decimals']!=undefined){
                        Decimal=settings['percentage-decimals'];
                    }
                }else{
                    Decimal=0;
                }
                if(Decimal!="auto"){
                    return parseFloat(value).toFixed(Decimal);
                }else{
                    return value;
                }
            } catch (error) {
                return value;
            }

        }
        const getHTML=async(item,index)=>{
            //item.ProductImage=(item.ProductImage!=null&&item.ProductImage!="")?"{{url('/')}}"+item.ProductImage:"{{url('/assets/images/no-image-b.png')}}";
            
			// Create a new image element
            const imgElement = $('<img>').attr('src', item.ProductImage).css('border-radius', '2px');
            
		    // Create a promise that resolves when the image loads
			const imgLoadPromise = new Promise((resolve, reject) => {imgElement.on('load', resolve);imgElement.on('error', reject);});

            // Push the promise to the array
            imageLoadPromises.push(imgLoadPromise);

            let html ='';
                html+='<tr>';
                    html+=`<td>${index + 1}</td>`;
                    html+=`<td>${imgElement.prop('outerHTML')} ${item.ProductName}</td>`;
                    html+=`<td class="text-right">${QtyFormat(item.Qty,item.Decimals)} ${item.UCode}</td>`;
                    html+=`<td class="text-right">${NumberFormat(item.Price,'price')}</td>`;
                    html+=`<td class="text-right">${NumberFormat(item.Taxable,'price')}</td>`;
                    if(parseFloat(item.IGSTAmt)<=0){
                        html+=`<td class="text-right">${NumberFormat(item.CGSTAmt,'price')}</td>`;
                        html+=`<td class="text-right">${NumberFormat(item.SGSTAmt,'price')}</td>`;
                    }else{
                        html+=`<td class="text-right">${NumberFormat(item.IGSTAmt,'price')}</td>`;
                    }
                    html+=`<td class="text-right">${NumberFormat(item.TotalAmt,'price')}</td>`;
                html+='</tr>';
            return html;
        }
		const loadTable = async () => {
			let tableFooterContent = $('.ct-table-footer').html();
			$('.ct-table-footer').remove();
            imageLoadPromises = []; // Array to hold all image load promises
            const data=await getOrderData();
            for (let i = 0; i < data.length; i++) {
				let item = data[i];
				let rowHeight =0;// await getRowHeight(item,i);
				let currentBodyHeight = $('.actual-quotaion.ct-page-layout[data-page="' + pageNo + '"] .ct-body .ct-body-content').outerHeight();


                // Check if the row should be added to a new page
				if (((currentBodyHeight + rowHeight + tableFooterHeight) > pageMaxHeight) && i === data.length - 1) {
					clonePage();
				} else if (((currentBodyHeight + rowHeight) > pageMaxHeight) && i < data.length - 1) {
					clonePage();
				}

				// Append the row with the image
                let html=await getHTML(item,i);
			    $('.actual-quotaion.ct-page-layout[data-page="' + pageNo + '"] .quote-table table tbody').append(html);
			}

			// Add the footer after all images are loaded
			$('.actual-quotaion.ct-page-layout[data-page="' + pageNo + '"] .quote-table').append('<div class="ct-table-footer fs-12">' + tableFooterContent + '</div>');
			
            // Wait for all images to load
			try {
				await Promise.all(imageLoadPromises);
			} catch (error) {
				console.error("One or more images failed to load.", error);
			}

			// Generate the PDF after ensuring all images are loaded
			//setTimeout(async () => {await generatePDF();}, 100);
            setTimeout(async() => {
                generatePDF();
            }, 100);
		};
        init();
    });
</script>
<script>
/*
   $(document).ready(async function() {
        const pdfBlob = await new Promise((resolve, reject) => {
            let element = document.querySelector('#pdf');
            let opt = {
                margin: 0,
                filename: '{{$QData->QNo}}.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 5, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
            };

            window.html2pdf()
                .set(opt)
                .from(element)
                .toPdf()
                .get('pdf') // Get the PDF instance
                .output('blob') // Directly call output to get a blob
                .then(blob => {
                    resolve(blob); // Resolve the blob
                })
                .catch(reject); // Handle any errors in PDF generation
        });

        const formData = new FormData();
        formData.append('QID', '{{$QData->QID}}');
        formData.append('pdf', pdfBlob, '{{$QData->QNo}}.pdf');

        $.ajax({
            type: "post",
            url: "{{route('admin.chat.save.quote.pdf')}}",
            headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    // window.opener.postMessage(response, window.location.origin);
                    window.close();
                } else {
                    alert("Failed to save the PDF. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred. Please try again.");
            }
        });
    });

*/
</script>
@endsection
