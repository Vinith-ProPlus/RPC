@php use Illuminate\Support\Facades\DB; @endphp
@php use App\helper\helper; @endphp

<style>
    .notification-item.read {
        background: #cccccc30;
    }
</style>
<div class="notification-heading">
    <h4 class="menu-title">Notifications</h4>
</div>
<li class="divider"></li>
<div class="notifications-wrapper" id="customerNotification" style="top: 160px !important;">
    @forelse($Notifications as $notification)
        @php
            $notification_url = '#';
            switch ($notification->Route) {
                case 'Enquiry':
                case 'Quotation':
                    $notification_url = route('customer.quotations.QuoteView', $notification->RouteID);
                    break;
                case 'Order':
                    $notification_url = route('CustomerOrderView', $notification->RouteID);
                    break;
                case 'Ratings':
                    $customer_order_id = DB::table(helper::getcurrFyDB().'tbl_vendor_orders')->where('VOrderID', $notification->RouteID)->value('OrderID');
                    if($customer_order_id){
                        $notification_url = route('CustomerOrderView', $customer_order_id);
                    }
                    break;
                case 'Support':
                    $notification_url = route('customer.support.SupportDetailsView', $notification->RouteID);
                    break;
            }
        @endphp

        <a class="content" href="{{ $notification_url }}">
            <div class="notification-item {{ $notification->ReadStatus ? 'read' : 'notificationMarkRead' }}" data-nid="{{ $notification->NID }}">
                <h4 class="item-title">{{ $notification->Title }}</h4>
                <p class="item-info">{{ $notification->Message }}</p>
            </div>
        </a>
    @empty
        <a class="content" href="#">
            <div class="notification-item">
                <p class="item-info">No notifications available</p>
            </div>
        </a>
    @endforelse
</div>
<div class="pagination">
    <ul class="pagination toolbox-item mb-0">
        @if ($Notifications->currentPage() > 1)
            <li class="page-item">
                <a class="page-link page-link-btn notificationPrev" href="#"><i class="icon-angle-left"></i></a>
            </li>
        @endif
        @if ($Notifications->lastPage() != $pageNo)
            <li class="page-item">
                <a class="page-link page-link-btn notificationNext" href="#"><i class="icon-angle-right"></i></a>
            </li>
        @endif
    </ul>
</div>

<script>
    $(document).ready(function () {
        var NotificationPageNo = {{ $pageNo }};
        $('.notificationNext').on('click', function (e) {
            e.preventDefault();
            NotificationPageNo++;
            $('#notificationPageNo').val(NotificationPageNo).trigger('change');
        });

        $('.notificationPrev').on('click', function (e) {
            e.preventDefault();
            if (NotificationPageNo > 1) {
                NotificationPageNo--;
                $('#notificationPageNo').val(NotificationPageNo).trigger('change');
            }
        });
        $('.notificationMarkRead').on('click', function () {
            var notificationThis = $(this);
            var notificationID = notificationThis.data('nid');
            let formData=new FormData();
            formData.append('NID',notificationID);
            $.ajax({
                type: "POST",
                url: "{{ route('notificationsRead') }}",
                dataType: "json",
                headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status){
                        notificationThis.removeClass('notificationMarkRead').addClass('read');
                        if(response.UnReadCount === 0){
                            if($('.unread-badge').is(':visible')){
                                $('.unread-badge').hide();
                            }
                        } else {
                            $('.unread-badge').show();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    });
</script>
