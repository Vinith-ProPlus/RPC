<div class="notification-heading">
    <h4 class="menu-title">Notifications</h4>
</div>
<li class="divider"></li>
<div class="notifications-wrapper" id="customerNotification" style="top: 160px !important;">
    @forelse($Notifications as $notification)
        <a class="content" href="#">
            <div class="notification-item">
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
            $('#notificationPageNo').attr('data-value', NotificationPageNo).trigger('change');
        });

        $('.notificationPrev').on('click', function (e) {
            e.preventDefault();
            if (NotificationPageNo > 1) {
                NotificationPageNo--;
                $('#notificationPageNo').attr('data-value', NotificationPageNo).trigger('change');
            }
        });
    });
</script>
