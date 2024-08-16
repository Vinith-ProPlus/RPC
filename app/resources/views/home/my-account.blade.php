@extends('home.home-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .sidebar {
            position:relative;
            height:100%;
            font-size:1.3rem
        }
        .sidebar .widget {
            margin-bottom:3.1rem
        }
        .sidebar .sidebar-wrapper {
            padding-bottom:4.2rem
        }
        .sidebar .sidebar-wrapper .widget:last-child {
            margin-bottom:0;
            padding-bottom:3rem
        }
        .widget-post .widget-title {
            margin-bottom:1.7rem
        }
        .widget-title {
            margin:0.5rem 0 1.3rem;
            color:#313131;
            font-size:1.6rem;
            font-weight:700;
            line-height:1.2;
            text-transform:uppercase
        }
        .widget form {
            margin-bottom:0
        }

        .widget-dashboard h2 {
            margin-top:-1px;
            margin-bottom:1.5rem;
            font-size:1.6rem
        }
        .widget-dashboard .nav-item:last-child {
            margin-right:3.5rem
        }
        .widget-dashboard .list {
            border-bottom:none
        }
        .widget-dashboard .list a {
            padding:1rem 0 1.1rem;
            color:#777;
            letter-spacing:-0.025em;
            font-size:1.4rem
        }
        .widget-dashboard .list a:focus,
        .widget-dashboard .list a:hover {
            background:transparent
        }
        .widget-dashboard .list a.active {
            color:#222524;
            font-weight:700
        }
        .widget-dashboard li:last-child a {
            border-bottom:0
        }
        .widget-dashboard li {
            padding:8px 0 8px 0
        }
        .widget-dashboard li:before {
            display:none
        }

        .container :not(.sticky-header)>.container,
        .container :not(.sticky-header)>.container-fluid {
            padding-left:0;
            padding-right:0
        }
        @media (max-width:1280px) {
            .container-fluid {
                padding-left:20px;
                padding-right:20px
            }
        }
        @media (min-width:1220px) {
            .container {
                max-width:1200px
            }
        }

        @media (min-width:992px) {
            .container {
                padding-left:10px;
                padding-right:10px
            }
            .row-lg {
                margin-left:-15px;
                margin-right:-15px
            }
            .row-lg [class*=col-] {
                padding-left:15px;
                padding-right:15px
            }
        }
        @media (max-width:991px) {
            .container {
                max-width:none
            }
            .mmenu-active .page-wrapper,
            .sidebar-opened .page-wrapper {
                left:260px
            }
        }
        .custom-account-container {
            margin-bottom:5.6rem
        }

        .nav-tabs {
            margin:0;
            border:0;
            border-bottom:1px solid #e7e7e7;
            padding-bottom:2px
        }
        .nav-tabs .nav-item {
            margin-bottom:-3px
        }
        .nav-tabs .nav-item:not(:last-child) {
            margin-right:3.5rem
        }
        .nav-tabs .nav-item .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            border-bottom-color:#fff;
            color:#0f43b0;
            border-bottom: none !important;
        }
        .nav-tabs .nav-link {
            padding:1.2rem 0;
            border:0;
            border-bottom:2px solid transparent;
            color:#282d3b;
            font-weight:700;
            font-size:1.4rem;
            line-height:1;
            font-family:Poppins,sans-serif;
            text-transform:uppercase
        }
        .nav-tabs .nav-link:hover {
            color:#0f43b0
        }
        .tabs .tab-content {
            border:1px solid #eee;
            box-shadow:0 1px 5px 0 rgba(0,0,0,0.04);
            padding:1.5rem
        }
        .tabs .nav-tabs {
            border-bottom:0
        }
        .tabs .nav-tabs .nav-item .nav-link.active,
        .tabs .nav-tabs .nav-item.show .nav-link {
            border-top-color:#0f43b0;
            color:#0f43b0;
            background:#fff
        }
        .tabs .nav-tabs .nav-item:not(:last-child) {
            margin-right:0.1rem
        }
        .tabs .nav-tabs .nav-link {
            border-top-left-radius:0;
            border-top-right-radius:0;
            border-top:3px solid #eee;
            border-left:1px solid #eee;
            border-right:1px solid #eee;
            border-bottom:none;
            background:#f4f4f4;
            text-transform:none;
            font-weight:400;
            line-height:2.4rem;
            margin-bottom:-1px;
            padding:0.8rem 1.6rem
        }
        .tabs .nav-tabs .nav-link:focus,
        .tabs .nav-tabs .nav-link:hover {
            border-top-color:#0f43b0
        }
        .tabs .tab-pane p:last-child {
            line-height:2.4rem
        }
        .tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-top:none;
            border-bottom-color:#0f43b0
        }
        .tabs-bottom .nav-tabs .nav-item:not(:last-child) {
            margin-right:0.1rem
        }
        .tabs-bottom .nav-tabs .nav-link {
            border-bottom-left-radius:0;
            border-bottom-right-radius:0;
            border-bottom:3px solid #eee;
            border-left:1px solid #eee;
            border-right:1px solid #eee;
            border-top:none;
            margin-top:-1px
        }
        .tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color:#0f43b0
        }
        .tabs-left {
            border-top:1px solid #eee
        }
        .tabs-left .tab-content {
            border-top:0
        }
        .tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left:3px solid #0f43b0
        }
        .tabs-left .nav-tabs .nav-item:not(:last-child) {
            margin-right:0.1rem
        }
        .tabs-left .nav-tabs .nav-link {
            border:0;
            border-left:3px solid #eee;
            margin-right:-1px
        }
        .tabs-left .nav-tabs .nav-link:focus,
        .tabs-left .nav-tabs .nav-link:hover {
            border-left-color:#0f43b0
        }
        .tabs-right {
            border-top:1px solid #eee
        }
        .tabs-right .tab-content {
            border-top:0
        }
        .tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right:3px solid #0f43b0
        }
        .tabs-right .nav-tabs .nav-item:not(:last-child) {
            margin-right:0
        }
        .tabs-right .nav-tabs .nav-link {
            border:0;
            border-right:3px solid #eee
        }
        .tabs-right .nav-tabs .nav-link:focus,
        .tabs-right .nav-tabs .nav-link:hover {
            border-right-color:#0f43b0
        }
        .nav-justified .nav-link {
            flex-basis:0;
            flex-grow:1;
            text-align:center
        }
        .tabs-vertical {
            display:flex
        }
        .tabs-vertical .nav-tabs {
            flex-flow:column nowrap;
            width:27.8%;
            border:0
        }
        .tabs-vertical .tab-content {
            flex:1
        }
        .tabs-vertical .nav-link:last-child {
            border-bottom:1px solid #eee!important
        }
        .tabs-secondary .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary .nav-tabs .nav-item.show .nav-link {
            border-top-color:#ff7272;
            color:#ff7272
        }
        .tabs-secondary .nav-tabs .nav-link:focus,
        .tabs-secondary .nav-tabs .nav-link:hover {
            border-top-color:#ff7272;
            color:#ff7272
        }
        .tabs-secondary.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color:#ff7272
        }
        .tabs-secondary.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color:#ff7272
        }
        .tabs-secondary.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color:#ff7272
        }
        .tabs-secondary.tabs-left .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-left .nav-tabs .nav-link:hover {
            border-left-color:#ff7272
        }
        .tabs-secondary.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color:#ff7272
        }
        .tabs-secondary.tabs-right .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-right .nav-tabs .nav-link:hover {
            border-right-color:#ff7272
        }
        .tabs-tertiary .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary .nav-tabs .nav-item.show .nav-link {
            border-top-color:#2baab1;
            color:#2baab1
        }
        .tabs-tertiary .nav-tabs .nav-link:focus,
        .tabs-tertiary .nav-tabs .nav-link:hover {
            border-top-color:#2baab1;
            color:#2baab1
        }
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color:#2baab1
        }
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color:#2baab1
        }
        .tabs-tertiary.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color:#2baab1
        }
        .tabs-tertiary.tabs-left .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-left .nav-tabs .nav-link:hover {
            border-left-color:#2baab1
        }
        .tabs-tertiary.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color:#2baab1
        }
        .tabs-tertiary.tabs-right .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-right .nav-tabs .nav-link:hover {
            border-right-color:#2baab1
        }
        .tabs-dark .nav-tabs .nav-item .nav-link.active,
        .tabs-dark .nav-tabs .nav-item.show .nav-link {
            border-top-color:#222529;
            color:#222529
        }
        .tabs-dark .nav-tabs .nav-link:focus,
        .tabs-dark .nav-tabs .nav-link:hover {
            border-top-color:#222529;
            color:#222529
        }
        .tabs-dark.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color:#222529
        }
        .tabs-dark.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color:#222529
        }
        .tabs-dark.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color:#222529
        }
        .tabs-dark.tabs-left .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-left .nav-tabs .nav-link:hover {
            border-left-color:#222529
        }
        .tabs-dark.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color:#222529
        }
        .tabs-dark.tabs-right .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-right .nav-tabs .nav-link:hover {
            border-right-color:#222529
        }
        .tabs-simple .tab-content {
            border:0;
            box-shadow:none;
            padding:3rem 0
        }
        .tabs-simple .nav-tabs .nav-item .nav-link.active,
        .tabs-simple .nav-tabs .nav-item.show .nav-link {
            border-bottom-color:#555;
            color:#777
        }
        .tabs-simple .nav-tabs .nav-item:not(:last-child) {
            margin-right:0.1rem
        }
        .tabs-simple .nav-tabs .nav-link {
            border:0;
            border-bottom:3px solid #eee;
            text-transform:none;
            font-weight:400;
            font-size:16px;
            line-height:2.4rem;
            margin-bottom:-1px;
            color:#777;
            background:none;
            padding:15px 30px;
            margin-bottom:1.5rem
        }
        .tabs-simple .nav-tabs .nav-link:focus,
        .tabs-simple .nav-tabs .nav-link:hover {
            border-bottom-color:#555
        }
        .tabs-with-icon .nav-tabs .nav-link {
            display:flex;
            flex-direction:column;
            align-items:center;
            background:none;
            margin-bottom:1rem
        }

        .nav-tabs.list .nav-item {
            padding:0
        }
        .nav-tabs.list .nav-item .nav-link {
            padding:1.3rem 0 1.5rem;
            font-family:"Open Sans",sans-serif;
            text-transform:capitalize;
            font-size:1.4rem;
            border:none
        }
        .nav-tabs.list .nav-item .nav-link:not(.active) {
            font-weight:400;
            color:#777
        }
        .nav-tabs.list .nav-item .nav-link.active,
        .nav-tabs.list .nav-item .nav-link.address {
            font-weight:700;
            color:#222529
        }
        .download-table-container .btn,
        .order-detail-container .btn,
        .order-table-container .btn {
            padding:8px 12px;
            font-size:14px;
            font-weight:400
        }
        .order-table-container .btn-dark {
            min-width:200px;
            padding:16px 0 15px;
            font-size:15px;
            letter-spacing:-0.015em;
            text-align:center;
            font-family:"Open Sans",sans-serif;
            font-weight:700
        }
        .table.table-striped {
            margin-top:2rem;
            margin-bottom:5.9rem
        }
        .table.table-striped td,
        .table.table-striped th {
            padding:1.1rem 1.2rem
        }
        .table.table-striped tr:nth-child(odd) {
            background-color:#f9f9f9
        }

        .table.table-size tbody tr td,
        .table.table-size thead tr th {
            border:0;
            color:#21293c;
            font-size:1.4rem;
            letter-spacing:0.005em;
            text-transform:uppercase
        }
        .table.table-size thead tr th {
            padding:2.8rem 1.5rem 1.7rem;
            background-color:#f4f4f2;
            font-weight:600
        }
        .table.table-size tbody tr td {
            padding:1.1rem 1.5rem;
            background-color:#fff;
            font-weight:700
        }
        .table.table-size tbody tr:nth-child(2n) td {
            background-color:#ebebeb
        }
        @media (min-width:992px) {
            .product-both-info .row .col-lg-12 {
                margin-bottom:4px
            }
            .main-content .col-lg-7 {
                -ms-flex:0 0 54%;
                flex:0 0 54%;
                max-width:54%
            }
            .main-content .col-lg-5 {
                -ms-flex:0 0 46%;
                flex:0 0 46%;
                max-width:46%
            }
            .product-full-width {
                padding-right:3.5rem
            }
            .product-full-width .product-single-details .product-title {
                font-size:4rem
            }
            .table.table-size thead tr th {
                padding-top:2.9rem;
                padding-bottom:2.9rem
            }
            .table.table-size tbody tr td,
            .table.table-size thead tr th {
                padding-right:4.2rem;
                padding-left:3rem
            }
        }
        @media (max-width:767px) {
            .product-size-content .table.table-size {
                margin-top:3rem
            }
        }

        .table.table-downloads,
        .table.table-order {
            margin-bottom:1px;
            font-size:14px
        }
        .table.table-downloads thead th,
        .table.table-order thead th {
            border-top:none;
            border-bottom-width:1px;
            padding:1.3rem 1rem;
            font-weight:700;
            color:#222524
        }
        .table.table-downloads tbody td,
        .table.table-order tbody td {
            vertical-align:middle
        }

        .table.table-order-detail th {
            font-weight:600
        }
        .table.table-order-detail td,
        .table.table-order-detail th {
            padding:1rem;
            font-size:1.4rem;
            line-height:24px
        }
        .table.table-order-detail thead th {
            border:none
        }
        .table.table-order-detail .product-title {
            display:inline;
            color:#08C;
            font-size:1.4rem;
            font-weight:400
        }
        .table.table-order-detail .product-count {
            color:#08C
        }
        @media (max-width:767px) {
            .table.table-order thead {
                display:none
            }
            .table.table-order td {
                display:block;
                border-top:none;
                text-align:center
            }
            .table.table-order .product-thumbnail img {
                display:inline
            }
            .table.table-order tbody tr {
                position:relative;
                display:block;
                padding:10px 0
            }
            .table.table-order tbody tr:not(:first-child) {
                border-top:1px solid #ddd
            }
            .table.table-order .product-remove {
                position:absolute;
                top:12px;
                right:0
            }
        }

        .feature-box {
            color:#7b858a;
            font-size:1.5rem;
            line-height:2;
            margin-bottom:4rem
        }
        .feature-box i {
            display:inline-block;
            margin-bottom:2.2rem;
            color:#08C;
            font-size:5rem;
            line-height:1
        }
        .feature-box i:before {
            margin:0
        }
        .feature-box h3 {
            margin-bottom:2rem;
            font-size:1.6rem;
            font-weight:700;
            text-transform:uppercase;
            line-height:1.1;
            letter-spacing:0
        }
        .feature-box p {
            margin-bottom:0
        }
        .feature-box.border-top-primary {
            border-bottom:1px solid #dfdfdf;
            border-left:1px solid #ececec;
            border-right:1px solid #ececec;
            box-shadow:0 2px 4px 0px rgba(0,0,0,0.05)
        }
        .feature-box.border-top-primary .feature-box-content {
            border-top:4px solid #08C;
            padding:30px 20px 10px 20px
        }
        .feature-box-content {
            color:#7b858a;
            font-size:1.5rem;
            line-height:1.9;
            padding-left:10px;
            padding-right:10px
        }
        .features-section .feature-box {
            padding:3rem 4rem
        }
        .checkout-discount .feature-box,
        .login-form-container .feature-box {
            box-shadow:0 2px 4px 0px rgba(0,0,0,0.05);
            margin-bottom:2.9rem
        }
        .checkout-discount .feature-box .feature-box-content,
        .login-form-container .feature-box .feature-box-content {
            border-top:4px solid #e7e7e7;
            border-bottom:1px solid #e7e7e7;
            border-left:1px solid #ececec;
            border-right:1px solid #ececec;
            padding:1rem 2rem
        }
        .contact-info .feature-box .sicon-location-pin {
            margin-top:-2px
        }
        .contact-info .feature-box i {
            margin-bottom:1.8rem;
            font-size:4.5rem
        }
        .contact-info .feature-box h3 {
            margin-bottom:0.4rem;
            font-size:2rem;
            letter-spacing:-0.025em;
            text-transform:none;
            font-weight:700
        }
        .contact-info .feature-box h5 {
            color:#777;
            font-weight:400;
            letter-spacing:-0.025em
        }
        .dashboard-content .feature-box {
            padding-top:3.5rem;
            margin-bottom:2rem;
            border:2px solid #e7e7e7
        }
        .dashboard-content .feature-box i {
            margin-bottom:2.5rem;
            color:#d3d3d4;
            font-size:6rem;
            transition:transform 0.35s
        }
        .dashboard-content .feature-box:hover i {
            transform:scale(1.15);
            transition:transform 0.35s
        }
        @media (max-width:575px) {
            .dashboard-content .feature-box h3 {
                font-size:1.3rem
            }
        }
        wishlist-table-container .btn-shop {
            font-weight:600;
            text-transform:uppercase;
            min-width:160px
        }
        .wishlist-title {
            margin-top:5.3rem;
            margin-bottom:2.8rem
        }
        .wishlist-table-container {
            margin-bottom:5.5rem
        }
        .wishlist-table-container .table-title {
            padding-top:1rem;
            padding-bottom:1rem;
            font-size:1.3em;
            font-weight:400;
            letter-spacing:-0.7px;
            line-height:1.42857;
            text-transform:uppercase
        }
        .wishlist-table-container .btn {
            height:42px;
            width:auto;
            padding:0 25px!important;
            font-size:13px;
            line-height:42px;
            text-indent:0
        }
        .wishlist-table-container .btn-quickview {
            margin-right:6px;
            background:#f4f4f4;
            color:#222529;
            font-family:"Open Sans",sans-serif
        }
        .wishlist-table-container .btn-quickview:hover {
            background-color:#08C;
            color:#fff
        }
        .wishlist-table-container .btn-shop {
            font-weight:600;
            text-transform:uppercase;
            min-width:160px
        }
        @media (max-width:1199px) {
            .wishlist-table-container .btn {
                width:100%
            }
            .wishlist-table-container .btn:first-child {
                margin-bottom:1rem
            }
        }
        .table.table-cart tr td,
        .table.table-cart tr th,
        .table.table-wishlist tr td,
        .table.table-wishlist tr th {
            vertical-align:middle
        }
        .table.table-cart tr th,
        .table.table-wishlist tr th {
            border:0;
            color:#222529;
            font-weight:700;
            line-height:2.4rem;
            text-transform:uppercase
        }
        .table.table-cart tr td,
        .table.table-wishlist tr td {
            border-top:1px solid #e7e7e7
        }
        .table.table-cart tr td.product-col,
        .table.table-wishlist tr td.product-col {
            padding:2rem 0.8rem 1.8rem 0
        }
        .table.table-cart tr.product-action-row td,
        .table.table-wishlist tr.product-action-row td {
            padding:0 0 2.2rem;
            border:0
        }
        .table.table-cart .product-image-container,
        .table.table-wishlist .product-image-container {
            position:relative;
            width:8rem;
            margin:0
        }
        .table.table-cart .product-title,
        .table.table-wishlist .product-title {
            margin-bottom:0;
            padding:0;
            font-family:"Open Sans",sans-serif;
            font-weight:400;
            line-height:1.75
        }
        .table.table-cart .product-title a,
        .table.table-wishlist .product-title a {
            color:inherit
        }
        .table.table-cart .product-single-qty,
        .table.table-wishlist .product-single-qty {
            margin:0.5rem 4px 0.5rem 1px
        }
        .table.table-cart .product-single-qty .form-control,
        .table.table-wishlist .product-single-qty .form-control {
            height:48px;
            width:44px;
            font-size:1.6rem;
            font-weight:700
        }
        .table.table-cart .subtotal-price,
        .table.table-wishlist .subtotal-price {
            color:#222529;
            font-size:1.6rem;
            font-weight:600
        }
        .table.table-cart .btn-remove,
        .table.table-wishlist .btn-remove {
            right:-10px;
            font-size:1.1rem
        }
        .table.table-cart tfoot td,
        .table.table-wishlist tfoot td {
            padding:2rem 0.8rem 1rem
        }
        .table.table-cart tfoot .btn,
        .table.table-wishlist tfoot .btn {
            padding:1.2rem 2.4rem 1.3rem 2.5rem;
            font-family:"Open Sans",sans-serif;
            font-size:1.3rem;
            font-weight:700;
            height:43px;
            letter-spacing:-0.018em
        }
        .table.table-cart tfoot .btn+.btn,
        .table.table-wishlist tfoot .btn+.btn {
            margin-left:1rem
        }
        .table.table-cart .bootstrap-touchspin.input-group,
        .table.table-wishlist .bootstrap-touchspin.input-group {
            margin-right:auto;
            margin-left:auto
        }
        .table.table-wishlist tr th {
            padding:10px 5px 10px 16px
        }
        .table.table-wishlist tr th.thumbnail-col {
            width:10%
        }
        .table.table-wishlist tr th.product-col {
            width:29%
        }
        .table.table-wishlist tr th.price-col {
            width:13%
        }
        .table.table-wishlist tr th.status-col {
            width:19%
        }
        .table.table-wishlist tr td {
            padding:20px 5px 23px 16px
        }
        .table.table-wishlist .product-price {
            color:inherit;
            font-size:1.4rem;
            font-weight:400
        }
        .table.table-wishlist .price-box {
            margin-bottom:0
        }
        .table.table-wishlist .stock-status {
            color:#222529;
            font-weight:600
        }
        .box-content .table-cart,
        .box-content .table-wishlist {
            margin-bottom:15px;
            font-size:100%;
            border-collapse:collapse;
            border-spacing:0;
            width:100%;
            margin-bottom:1em
        }
        .box-content .table-cart .wishlist-empty,
        .box-content .table-wishlist .wishlist-empty {
            margin-bottom:1rem;
            text-align:center
        }
        @media (max-width:767px) {
            .wishlist-table-container {
                border-top:4px solid #08C
            }
            .table.table-wishlist {
                border:1px solid #e7e7e7;
                border-top:0;
                box-shadow:0 2px 4px 0 rgba(0,0,0,0.05)
            }
            .table.table-wishlist,
            .table.table-wishlist tbody {
                display:block
            }
            .table.table-wishlist thead {
                display:none
            }
            .table.table-wishlist tr td {
                padding:0.5rem 1rem;
                border-top:0
            }
            .table.table-wishlist tr td.product-col {
                padding-bottom:0.5rem
            }
            .table.table-wishlist .product-row {
                display:-ms-flexbox;
                display:flex;
                -ms-flex-direction:column;
                flex-direction:column;
                justify-content:center;
                align-items:center;
                padding:3rem 0;
                border-top:2px solid #ddd
            }
            .table.table-wishlist .product-row:first-child {
                border-top:0
            }
            .table.table-wishlist .product-col {
                -ms-flex-direction:column;
                flex-direction:column;
                -ms-flex-pack:center;
                justify-content:center;
                text-align:center
            }
            .table.table-wishlist .product-col .product-image-container {
                -ms-flex:0 0 auto;
                flex:0 0 auto;
                margin-right:0;
                margin-bottom:1rem
            }
            .table.table-wishlist .btn-shop {
                width:100%
            }
        }

        #ordersTable th{
            text-align: center !important;
        }
        #ordersTable td{
            text-align: center !important;
        }

        .wishlist-table-container .btn {
            font-size: 11px;
            line-height: 42px;
            text-indent: -2px;
        }
    </style>
    <form id="logout-form" action="{{ url('/') }}/logout" method="POST" style="display: none;">
        @csrf
    </form>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </div>
    </nav>
        <div class="container account-container custom-account-container">
            <div class="row">
                <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                    <h2 class="text-uppercase">My Account</h2>
                    <ul class="nav nav-tabs list flex-column mb-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Account
                                details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="quotations-tab" data-toggle="tab" href="#quotations" role="tab" aria-controls="quotations" aria-selected="false">Quotations</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="orders-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false">Orders</a>
                        </li>

{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab" aria-controls="download" aria-selected="false">Downloads</a>--}}
{{--                        </li>--}}

{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Addresses</a>--}}
{{--                        </li>--}}

{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="edit" aria-selected="false">Shopping Address</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" id="wishlist-tab" data-toggle="tab" href="#wishlist" role="tab" aria-controls="wishlist" aria-selected="false">Wishlist</a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" id="support-tab" data-toggle="tab" href="#support" role="tab" aria-controls="support" aria-selected="false">Support</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="$('#logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 order-lg-last order-1 tab-content">
                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel">
                        <div class="dashboard-content">
                            <div class="mb-4"></div>

                            <div class="row row-lg">
                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#order" onclick="$('#orders-tab').click();" class="link-to-tab"><i class="sicon-social-dropbox"></i></a>
                                        <div class="feature-box-content">
                                            <h3>ORDERS</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="{{ route('products') }}"><i class="sicon-present"></i></a>
                                        <div class="feature-box-content">
                                            <h3>Products</h3>
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="col-6 col-md-4">--}}
{{--                                    <div class="feature-box text-center pb-4">--}}
{{--                                        <a href="#wishlist" onclick="$('#wishlist-tab').click();"><i class="sicon-heart"></i></a>--}}
{{--                                        <div class="feature-box-content">--}}
{{--                                            <h3>WISHLIST</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#support" onclick="$('#support-tab').click();" class="link-to-tab"><i class="sicon-support"></i></a>
                                        <div class="feature-box-content">
                                            <h3>SUPPORT</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#quotations" onclick="$('#quotations-tab').click();" class="link-to-tab"><i class="sicon-notebook"></i></a>
                                        <div class=" feature-box-content">
                                            <h3>QUOTATIONS</h3>
                                        </div>
                                    </div>
                                </div>

{{--                                --}}
{{--                                <div class="col-6 col-md-4">--}}
{{--                                    <div class="feature-box text-center pb-4">--}}
{{--                                        <a href="#address" class="link-to-tab"><i class="sicon-location-pin"></i></a>--}}
{{--                                        <div class="feature-box-content">--}}
{{--                                            <h3>ADDRESSES</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#profile" onclick="$('#profile-tab').click();" class="link-to-tab"><i class="icon-user-2"></i></a>
                                        <div class="feature-box-content p-0">
                                            <h3>ACCOUNT DETAILS</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a onclick="$('#logout-form').submit();"><i class="sicon-logout"></i></a>
                                        <div class="feature-box-content">
                                            <h3>LOGOUT</h3>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .row -->
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="quotations" role="tabpanel">
                        <div class="download-content">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="account-sub-title d-none d-md-block"><i class="sicon-notebook align-middle mr-3"></i>Quotations</h3>
                                </div>
                            </div>
                            <div class="download-table-container" style="margin-top: 20px !important;">
                                <div class="wishlist-table-container" id="quotationTableHtml">
                                </div>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="order" role="tabpanel">
                        <div class="download-content">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="account-sub-title d-none d-md-block"><i class="sicon-social-dropbox align-middle mr-3"></i>Orders</h3>
                                </div>
                            </div>
                            <div class="download-table-container" style="margin-top: 20px !important;">
                                <div class="wishlist-table-container" id="orderTableHtml">
                                </div>
                            </div>
                        </div>
{{--                        <div class="order-content">--}}
{{--                            <h3 class="account-sub-title d-none d-md-block"><i class="sicon-social-dropbox align-middle mr-3"></i>Orders</h3>--}}
{{--                            <div class="order-table-container text-center">--}}
{{--                                <table class="table table-order text-left">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th class="order-id">ORDER</th>--}}
{{--                                        <th class="order-date">DATE</th>--}}
{{--                                        <th class="order-status">STATUS</th>--}}
{{--                                        <th class="order-price">TOTAL</th>--}}
{{--                                        <th class="order-action">ACTIONS</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-center p-0" colspan="5">--}}
{{--                                            <p class="mb-5 mt-5">--}}
{{--                                                No Order has been made yet.--}}
{{--                                            </p>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                                <hr class="mt-0 mb-3 pb-2">--}}

{{--                                <a href="category.html" class="btn btn-dark">Go Shop</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div><!-- End .tab-pane -->

{{--                    <div class="tab-pane fade" id="wishlist" role="tabpanel">--}}
{{--                        <div class="download-content">--}}
{{--                            <h3 class="account-sub-title d-none d-md-block"><i class="sicon-heart align-middle mr-3"></i>Wishlist</h3>--}}
{{--                            <div class="download-table-container" style="margin-top: 20px !important;">--}}
{{--                                <div class="wishlist-table-container" id="wishlistTableHtml">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End .tab-pane -->--}}
                    <div class="tab-pane fade" id="support" role="tabpanel">
                        <div class="download-content">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="account-sub-title d-none d-md-block"><i class="sicon-support align-middle mr-3"></i>Support</h3>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <button type="button" id="btnNewTicket" class="btn btn-dark btn-min-width box-shadow-2 round">New Ticket</button>
                                </div>
                            </div>
                            <div class="download-table-container" style="margin-top: 20px !important;">
                                <div class="wishlist-table-container" id="supportTableHtml">
                                </div>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="address" role="tabpanel">
                        <h3 class="account-sub-title d-none d-md-block mb-1"><i class="sicon-location-pin align-middle mr-3"></i>Addresses</h3>
                        <div class="addresses-content">
                            <p class="mb-4">
                                The following addresses will be used on the checkout page by
                                default.
                            </p>

                            <div class="row">
                                <div class="address col-md-6">
                                    <div class="heading d-flex">
                                        <h4 class="text-dark mb-0">Billing address</h4>
                                    </div>

                                    <div class="address-box">
                                        You have not set up this type of address yet.
                                    </div>

                                    <a href="#billing" class="btn btn-default address-action link-to-tab">Add
                                        Address</a>
                                </div>

                                <div class="address col-md-6 mt-5 mt-md-0">
                                    <div class="heading d-flex">
                                        <h4 class="text-dark mb-0">
                                            Shipping address
                                        </h4>
                                    </div>

                                    <div class="address-box">
                                        You have not set up this type of address yet.
                                    </div>

                                    <a href="#shipping" class="btn btn-default address-action link-to-tab">Add
                                        Address</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i class="icon-user-2 align-middle mr-3 pr-1"></i>Account Details</h3>
{{--                        <div class="account-content">--}}
{{--                            <form action="#">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="acc-name">First name <span class="required">*</span></label>--}}
{{--                                            <input type="text" class="form-control" placeholder="Editor" id="acc-name" name="acc-name" required="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="acc-lastname">Last name <span class="required">*</span></label>--}}
{{--                                            <input type="text" class="form-control" id="acc-lastname" name="acc-lastname" required="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group mb-2">--}}
{{--                                    <label for="acc-text">Display name <span class="required">*</span></label>--}}
{{--                                    <input type="text" class="form-control" id="acc-text" name="acc-text" placeholder="Editor" required="">--}}
{{--                                    <p>This will be how your name will be displayed in the account section and--}}
{{--                                        in--}}
{{--                                        reviews</p>--}}
{{--                                </div>--}}


{{--                                <div class="form-group mb-4">--}}
{{--                                    <label for="acc-email">Email address <span class="required">*</span></label>--}}
{{--                                    <input type="email" class="form-control" id="acc-email" name="acc-email" placeholder="editor@gmail.com" required="">--}}
{{--                                </div>--}}

{{--                                <div class="change-password">--}}
{{--                                    <h3 class="text-uppercase mb-2">Password Change</h3>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="acc-password">Current Password (leave blank to leave--}}
{{--                                            unchanged)</label>--}}
{{--                                        <input type="password" class="form-control" id="acc-password" name="acc-password">--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="acc-password">New Password (leave blank to leave--}}
{{--                                            unchanged)</label>--}}
{{--                                        <input type="password" class="form-control" id="acc-new-password" name="acc-new-password">--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="acc-password">Confirm New Password</label>--}}
{{--                                        <input type="password" class="form-control" id="acc-confirm-password" name="acc-confirm-password">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-footer mt-3 mb-0">--}}
{{--                                    <button type="submit" class="btn btn-dark mr-0">--}}
{{--                                        Save changes--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}


                        <div class="download-table-container" style="margin-top: 20px !important;">
                            <div class="wishlist-table-container" id="profileHtml">
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="billing" role="tabpanel">
                        <div class="address account-content mt-0 pt-2">
                            <h4 class="title">Billing address</h4>

                            <form class="mb-2" action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name <span class="required">*</span></label>
                                            <input type="text" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last name <span class="required">*</span></label>
                                            <input type="text" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Company </label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="select-custom">
                                    <label>Country / Region <span class="required">*</span></label>
                                    <select name="orderby" class="form-control">
                                        <option value="" selected="selected">British Indian Ocean Territory
                                        </option>
                                        <option value="1">Brunei</option>
                                        <option value="2">Bulgaria</option>
                                        <option value="3">Burkina Faso</option>
                                        <option value="4">Burundi</option>
                                        <option value="5">Cameroon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Street address <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="House number and street name" required="">
                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" required="">
                                </div>

                                <div class="form-group">
                                    <label>Town / City <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>State / Country <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>Postcode / ZIP <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Phone <span class="required">*</span></label>
                                    <input type="number" class="form-control" required="">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email address <span class="required">*</span></label>
                                    <input type="email" class="form-control" placeholder="editor@gmail.com" required="">
                                </div>

                                <div class="form-footer mb-0">
                                    <div class="form-footer-right">
                                        <button type="submit" class="btn btn-dark py-4">
                                            Save Address
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                        <div class="address account-content mt-0 pt-2">
                            <h4 class="title mb-3">Shipping Address</h4>

                            <form class="mb-2" action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name <span class="required">*</span></label>
                                            <input type="text" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last name <span class="required">*</span></label>
                                            <input type="text" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Company </label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="select-custom">
                                    <label>Country / Region <span class="required">*</span></label>
                                    <select name="orderby" class="form-control">
                                        <option value="" selected="selected">British Indian Ocean Territory
                                        </option>
                                        <option value="1">Brunei</option>
                                        <option value="2">Bulgaria</option>
                                        <option value="3">Burkina Faso</option>
                                        <option value="4">Burundi</option>
                                        <option value="5">Cameroon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Street address <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="House number and street name" required="">
                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" required="">
                                </div>

                                <div class="form-group">
                                    <label>Town / City <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>State / Country <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>Postcode / ZIP <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="">
                                </div>

                                <div class="form-footer mb-0">
                                    <div class="form-footer-right">
                                        <button type="submit" class="btn btn-dark py-4">
                                            Save Address
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var wish_current_page_no = 1;
            var viewType = 'List';
            const LoadWishlists = async () => {
                var formData = new FormData();

                formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
                formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
                formData.append('productCount', parseInt($('#productCountSelect').val()));
                formData.append('orderBy', $('#orderBySelect').val());
                formData.append('viewType', viewType);
                formData.append('pageNo', wish_current_page_no);

                $.ajax({
                    url: '{{ route('wishlistTableHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#wishlistTableHtml').html(response);
                        $('#productCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect2').val(selectedValue);
                        });
                        $('#productCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect').val(selectedValue);
                        });
                        $('#productCountSelect').change(function () {
                            LoadWishlists();
                        });
                        $('#productCountSelect2').change(function () {
                            LoadWishlists();
                        });
                        $('#orderBySelect').change(function () {
                            LoadWishlists();
                        });
                        $('.changePage').click(function () {
                            wish_current_page_no = $(this).attr('data-page-no');
                            LoadWishlists();
                        });
                        $('.changeView').click(function () {
                            viewType = $(this).attr('title');
                            LoadWishlists();
                        });
                        $('.prevPage').click(function () {
                            wish_current_page_no = parseInt(wish_current_page_no) - 1;
                            LoadWishlists();
                        });
                        $('.nextPage').click(function () {
                            wish_current_page_no = parseInt(wish_current_page_no) + 1;
                            LoadWishlists();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            $('#wishlist-tab').click(function (){
                LoadWishlists();
            });

            var support_current_page_no = 1;
            const LoadSupports = async () => {
                var formData = new FormData();

                formData.append('productCount', parseInt($('#supportProductCountSelect').val()));
                formData.append('orderBy', $('#supportOrderBySelect').val());
                formData.append('pageNo', support_current_page_no);

                $.ajax({
                    url: '{{ route('supportTableHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#supportTableHtml').html(response);
                        $('#supportProductCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#supportProductCountSelect2').val(selectedValue);
                        });
                        $('#supportProductCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#supportProductCountSelect').val(selectedValue);
                        });
                        $('#supportProductCountSelect').change(function () {
                            LoadSupports();
                        });
                        $('#supportProductCountSelect2').change(function () {
                            LoadSupports();
                        });
                        $('#supportOrderBySelect').change(function () {
                            LoadSupports();
                        });
                        $('.supportChangePage').click(function () {
                            support_current_page_no = $(this).attr('data-page-no');
                            LoadSupports();
                        });
                        $('.supportPrevPage').click(function () {
                            support_current_page_no = parseInt(support_current_page_no) - 1;
                            LoadSupports();
                        });
                        $('.supportNextPage').click(function () {
                            support_current_page_no = parseInt(support_current_page_no) + 1;
                            LoadSupports();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            $('#support-tab').click(function (){
                LoadSupports();
            });

            $(document).on('click','.btnDetails',function(e){
                var CID=$(this).attr('id');
                let t=$(e.target);
                if((t.hasClass('SupportTicketReopen')==false)&&(t.hasClass('SupportTicketDelete')==false)&&(t.hasClass('SupportTicketClose')==false)){
                    window.location.replace("{{url('/')}}/customer/support/details/"+CID);
                }
            });

            $(document).on('click','.btnOrderView',function(){
                window.location.replace("{{url('/')}}/order/view/"+ $(this).attr('data-id'));
            });

            $(document).on('click','.btnQuoteView',function(){
                window.location.replace("{{url('/')}}/quotations/view/"+ $(this).attr('data-id'));
            });

            $('#btnNewTicket').click(function(e){
                e.preventDefault();
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/customer/support/new-ticket",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        if(response!=""){
                            bootbox.dialog({
                                title: 'Support',
                                size:'large',
                                closeButton: true,
                                message: response,
                                buttons: {
                                }
                            });
                        }
                    }
                })
            });

            var quotation_current_page_no = 1;
            const LoadQuotations = async () => {
                var formData = new FormData();

                formData.append('productCount', parseInt($('#quotationProductCountSelect').val()));
                formData.append('orderBy', $('#quotationOrderBySelect').val());
                formData.append('pageNo', quotation_current_page_no);

                $.ajax({
                    url: '{{ route('quotationTableHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#quotationTableHtml').html(response);
                        $('#quotationProductCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#quotationProductCountSelect2').val(selectedValue);
                        });
                        $('#quotationProductCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#quotationProductCountSelect').val(selectedValue);
                        });
                        $('#quotationProductCountSelect').change(function () {
                            LoadQuotations();
                        });
                        $('#quotationProductCountSelect2').change(function () {
                            LoadQuotations();
                        });
                        $('#quotationOrderBySelect').change(function () {
                            LoadQuotations();
                        });
                        $('.quotationChangePage').click(function () {
                            quotation_current_page_no = $(this).attr('data-page-no');
                            LoadQuotations();
                        });
                        $('.quotationPrevPage').click(function () {
                            quotation_current_page_no = parseInt(quotation_current_page_no) - 1;
                            LoadQuotations();
                        });
                        $('.quotationNextPage').click(function () {
                            quotation_current_page_no = parseInt(quotation_current_page_no) + 1;
                            LoadQuotations();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            $('#quotations-tab').click(function (){
                LoadQuotations();
            });

            var order_current_page_no = 1;
            const LoadOrders = async () => {
                var formData = new FormData();

                formData.append('productCount', parseInt($('#orderProductCountSelect').val()));
                formData.append('orderBy', $('#orderOrderBySelect').val());
                formData.append('pageNo', order_current_page_no);

                $.ajax({
                    url: '{{ route('orderTableHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#orderTableHtml').html(response);
                        $('#orderProductCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#orderProductCountSelect2').val(selectedValue);
                        });
                        $('#orderProductCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#orderProductCountSelect').val(selectedValue);
                        });
                        $('#orderProductCountSelect').change(function () {
                            LoadOrders();
                        });
                        $('#orderProductCountSelect2').change(function () {
                            LoadOrders();
                        });
                        $('#orderOrderBySelect').change(function () {
                            LoadOrders();
                        });
                        $('.orderChangePage').click(function () {
                            order_current_page_no = $(this).attr('data-page-no');
                            LoadOrders();
                        });
                        $('.orderPrevPage').click(function () {
                            order_current_page_no = parseInt(order_current_page_no) - 1;
                            LoadOrders();
                        });
                        $('.orderNextPage').click(function () {
                            order_current_page_no = parseInt(order_current_page_no) + 1;
                            LoadOrders();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            $('#orders-tab').click(function (){
                LoadOrders();
            });

            const LoadProfile = async () => {
                $.ajax({
                    url: '{{ route('profileHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: {},
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#profileHtml').html(response);
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            $('#profile-tab').click(function (){
                LoadProfile();
            });

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadWishlists();
                        LoadSupports();
                        LoadQuotations();
                        LoadOrders();
                    }
                });
            });
            var config = { attributes: true };
            observer.observe(document.getElementById('customerSelectedAddress'), config);

            if (window.location.search) {
                const param = new URLSearchParams(window.location.search);
                param.forEach(function(value, key) {
                    $('#' + value +'-tab').click();
                });
            }
        });
    </script>




    <!-- Image Crop Script Start -->
    <script>
        $(document).ready(function() {
            var uploadedImageURL;
            var URL = window.URL || window.webkitURL;
            var $dataRotate = $('#dataRotate');
            var $dataScaleX = $('#dataScaleX');
            var $dataScaleY = $('#dataScaleY');
            var options = {
                aspectRatio: 16/9,
                preview: '.img-preview'
            };
            const btnReset=async($this)=> {
                $('.waves-ripple').remove();
                $this.html($this.data('original-text'));
                $this.removeAttr('disabled');
            }
            var $image = $('#ImageCrop').cropper(options);
            $('#ImgCrop').modal({backdrop: 'static',keyboard: false});
            $('#ImgCrop').modal('hide');
            $(document).on('change', '.imageScrop', function() {
                let id = $(this).attr('id');
                $('#'+id).attr('data-remove',0);
                if($('#'+id).attr('data-aspect-ratio')!=undefined){
                    options.aspectRatio=$('#'+id).attr('data-aspect-ratio')
                }
                $image.attr('data-id', id);
                $('#ImgCrop').modal('show');
                var files = this.files;
                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        uploadedImageName = file.name;
                        uploadedImageType = file.type;
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }
                        uploadedImageURL = URL.createObjectURL(file); console.log(options)
                        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
            $('.docs-buttons').on('click', '[data-method]', function() {
                var $this = $(this);
                var data = $this.data();
                var cropper = $image.data('cropper');
                var cropped;
                var $target;
                var result;
                if (cropper && data.method) {
                    data = $.extend({}, data);
                    if (typeof data.target !== 'undefined') {
                        $target = $(data.target);
                        if (typeof data.option === 'undefined') {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }
                    cropped = cropper.cropped;
                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                $image.cropper('clear');
                            }
                            break;
                        case 'getCroppedCanvas':
                            if (uploadedImageType === 'image/jpeg') {
                                if (!data.option) {
                                    data.option = {};
                                }
                                data.option.fillColor = '#fff';
                            }
                            break;
                    }
                    result = $image.cropper(data.method, data.option, data.secondOption);
                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                $image.cropper('crop');
                            }
                            break;
                        case 'scaleX':
                        case 'scaleY':
                            $(this).data('option', -data.option);
                            break;
                        case 'getCroppedCanvas':
                            if (result) {
                                $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                                if (!$download.hasClass('disabled')) {
                                    download.download = uploadedImageName;
                                    $download.attr('href', result.toDataURL(uploadedImageType));
                                }
                            }
                            break;
                    }
                }
            });
            $('#inputImage').change(function() {
                var files = this.files;
                var file;
                if (!$image.data('cropper')) {
                    return;
                }
                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        uploadedImageName = file.name;
                        uploadedImageType = file.type;
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }
                        uploadedImageURL = URL.createObjectURL(file);
                        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                        $('#inputImage').val('');
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
            $(document).on('click', '#btnUploadImage', function() {
                $('#inputImage').trigger('click')
            });
            $("#btnCropApply").on('click', function() {
                setTimeout(() => {
                    var base64 = $image.cropper('getCroppedCanvas').toDataURL();
                    var id = $image.attr('data-id');
                    $('#' + id).attr('src', base64);
                    $('#' + id).parent().find('img').attr('src', base64)
                    $('#ImgCrop').modal('hide');
                    setTimeout(() => {
                        btnReset($('#btnCropApply'));
                    }, 100);
                }, 100);
            });
            $(document).on('click','#btnCropModelClose',function(){
                var id = $image.attr('data-id');
                $('#' + id).val("");
                $('#' + id).attr('src', "");
                $('#' + id).parent().find('img').attr('src', "");
                $('#' + id).parent().find('.dropify-clear').trigger('click');
                $('#ImgCrop').modal('hide');
            });
            $(document).on('click','.dropify-clear',function(){
                $(this).parent().find('input[type="file"]').attr('data-remove',1);
            });
            $('.dropify').dropify();
        });
    </script>
    <!-- Image Crop Script End -->
    <script>
        $(document).ready(function(){
            const ajaxErrors=async(e, x, settings, exception)=> {
                let isSwal=false;let isToastr=false;
                try {
                    if(window.swal != undefined) {isSwal=true;}
                }
                catch(err) {
                    console.log("toastr is missing");
                }
                try {
                    if(window.toastr != undefined) {isToastr=true;}
                }
                catch(err) {
                    console.log("toastr is missing");
                }
                if ((e.status != 200) && (e.status != undefined)) {
                    var message="";
                    var statusErrorMap = {
                        '400': "Server understood the request, but request content was invalid.",
                        '401': "Unauthorized access.",
                        '403': "Forbidden resource can't be accessed.",
                        '404': "Sorry! Page Not Found",
                        '405': "Sorry! Method not Allowed",
                        '419': "Sorry! Page session has been expired",
                        '500': "Internal server error.",
                        '503': "Service unavailable."
                    };
                    if (e.status) {
                        message = statusErrorMap[e.status];
                    } else if (x == 'timeout') {
                        message = "Request Time out.";
                    } else if (x == 'abort') {
                        //message = "Request was aborted by the server";
                    }
                    console.log(isToastr)
                    if ((message != "")&&(message!=undefined)) {
                        if(isToastr==true){
                            toastr.error(message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                        }else if(isSwal==true){
                            swal("Error", message, "error");
                        }
                        if(e.status==419){
                            setTimeout(async()=>{
                                window.location.reload();
                            },100)
                        }
                    }
                } else if (x == 'parsererror') {
                    if(isToastr==true){
                        toastr.error("Parsing JSON Request failed.", "Failed", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                    }else if(isSwal==true){
                        swal("Error", "Parsing JSON Request failed.", "error");
                    }
                } else if (x == 'timeout') {
                    if(isToastr==true){
                        toastr.error("Request Time out.", "Failed", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                    }else if(isSwal==true){
                        swal("Error", "Request Time out.", "error");
                    }
                } else if (x == 'abort') {
                    if(isToastr==true){
                        toastr.error("Request was aborted by the server", "Failed", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                    }else if(isSwal==true){
                        swal("Error", "Request was aborted by the server", "error");
                    }
                }
            }
            const ajaxIndicatorStart =async(text="") =>{
                var basepath=$('#txtRootUrl').val();
                if ($('body').find('#resultLoading').attr('id') != 'resultLoading') {
                    if(text==""){text="Processing";}
                    $('body').append('<div id="resultLoading" style="display:none"><div style="font-weight: 700;"><img loading="lazy" src="' + basepath + '/assets/images/ajax-loader.gif"><div id="divProcessText">'+text+'</div></div><div class="bg"></div></div>');
                }
                $('#resultLoading').css({
                    'width': '100%',
                    'height': '100%',
                    'position': 'fixed',
                    'z-index': '10000000',
                    'top': '0',
                    'left': '0',
                    'right': '0',
                    'bottom': '0',
                    'margin': 'auto'
                });
                $('#resultLoading .bg').css({
                    'background': '#000000',
                    'opacity': '0.7',
                    'width': '100%',
                    'height': '100%',
                    'position': 'absolute',
                    'top': '0'
                });
                $('#resultLoading>div:first').css({
                    'width': '50%',
                    'height': '75px',
                    'text-align': 'center',
                    'position': 'fixed',
                    'top': '0',
                    'left': '0',
                    'right': '0',
                    'bottom': '0',
                    'margin': 'auto',
                    'font-size': '16px',
                    'z-index': '10',
                    'color': '#ffffff'
                });
                $('#resultLoading .bg').height('100%');
                $('#resultLoading').fadeIn(300);
                $('body').css('cursor', 'wait');
            }
            const ajaxIndicatorStop=async()=> {
                $('#resultLoading .bg').height('100%');
                $('#resultLoading').fadeOut(300);
                $('body').css('cursor', 'default');
            }
            const UploadImages = async () => {
                let RootUrl=$('#txtRootUrl').val();
                let uploadImages=await new Promise((resolve,reject)=>{
                    ajaxIndicatorStart("% Completed. Please wait for until upload process complete.");
                    setTimeout(() => {
                        let count = $("input.imageScrop").length;
                        let completed = 0;
                        let rowIndex=0;
                        let images={profileImage:{uploadPath:"",fileName:""},coverImage:{uploadPath:"",fileName:""},gallery:[]};
                        const uploadComplete=async(e, x, settings, exception)=>{
                            completed++;
                            let percentage=(100*completed)/count;
                            $('#divProcessText').html(percentage + '% Completed. Please wait for until upload process complete.');
                            checkUploadCompleted();
                        }
                        const checkUploadCompleted=async()=>{
                            if(count<=completed){
                                ajaxIndicatorStop();
                                resolve(images);
                            }
                        }
                        const upload=async(formData)=>{
                            console.log(formData);
                            $.ajax({
                                type: "post",
                                url: RootUrl+"tmp/upload-image",
                                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                                data: formData,
                                dataType:"json",
                                error: function(e, x, settings, exception) {ajaxErrors(e, x, settings, exception);},
                                complete: uploadComplete,
                                success:function(response){
                                    if(response.referData.isProfileImage==1){
                                        images.profileImage={uploadPath:response.uploadPath,fileName:response.fileName};
                                    }else if(response.referData.isCoverImage==1){
                                        images.coverImage={uploadPath:response.uploadPath,fileName:response.fileName};
                                    }else{
                                        images.gallery.push({uploadPath:response.uploadPath,fileName:response.fileName,slno:response.referData.slno});
                                    }
                                }
                            });
                        }
                        $("input.imageScrop").each(function (index){
                            let id = $(this).attr('id');
                            if ($('#' + id).val() != "" ) {
                                let isProfileImage=$('#'+id).attr('data-is-profile-image');
                                let isCoverImage=$('#'+id).attr('data-is-cover-image');
                                isProfileImage=isNaN(parseInt(isProfileImage))==false?isProfileImage:0;
                                isCoverImage=isNaN(parseInt(isCoverImage))==false?isCoverImage:0;
                                rowIndex++;
                                let formData = {};
                                formData.image = $('#'+id).attr('src');
                                formData.referData = {index:rowIndex,id:id,slno:$('#'+id).attr('data-slno'),isProfileImage:isProfileImage,isCoverImage:isCoverImage};
                                upload(formData);
                            }else{
                                completed++;
                                let percentage=(100*completed)/count;
                                $('#divProcessText').html(percentage + '% Completed. Please wait for until upload process complete.');
                                checkUploadCompleted();
                            }
                        });
                    }, 200);


                });
                return uploadImages;
            }

            $(document).on('click','#btnGSearchPostalCode',async function(){
                $('#txtPostalCode-err').html('')
                let PostalCode=$('#txtPostalCode').val();
                if(PostalCode!=""){
                    $('#btnGSearchPostalCode').attr('disabled','disabled');
                    $('#btnGSearchPostalCode').html('<i class="fa fa-spinner fa-pulse"></i>');
                    let response=await getCity({PostalCode});
                    if(response.length>0){
                        $('#lstCity option').remove();
                        $('#lstCity').append('<option value="">Select a City</option>');
                        for(let Item of response){
                            let selected="";
                            if(Item.CityID==$('#lstCity').attr('data-selected')){selected="selected";}
                            $('#lstCity').append('<option '+selected+' data-postal="'+Item.PostalID+'" data-taluk="'+Item.TalukID+'" data-district="'+Item.DistrictID+'" data-state="'+Item.StateID+'" data-country="'+Item.CountryID+'" data-city-name="'+Item.CityName+'" value="'+Item.CityID+'">'+Item.CityName+' </option>');
                        }
                        if($('#lstCity').val()!=""){
                            $('#lstCity').trigger('change');
                        }
                    }else{
                        $('#txtPostalCode-err').html('Postal Code does not exists.')
                    }
                    setTimeout(() => {
                        $('#btnGSearchPostalCode').html('Search <i class="fa fa-search"></i>');
                        $('#btnGSearchPostalCode').removeAttr('disabled');
                    }, 100);
                }else{
                    $('#txtPostalCode-err').html('Postal Code is required.')
                }
            });
            $(document).on("change",'#lstCity',function(){
                let CountryID=$('#lstCity option:selected').attr('data-country');
                let StateID=$('#lstCity option:selected').attr('data-state');
                let DistrictID=$('#lstCity option:selected').attr('data-district');
                let TalukID=$('#lstCity option:selected').attr('data-taluk');
                $('#lstTaluk').attr('data-selected',TalukID);
                $('#lstDistricts').attr('data-selected',DistrictID);
                $('#lstState').attr('data-selected',StateID);
                $('#lstCountry').attr('data-selected',CountryID);
                $('#lstCountry').val(CountryID).trigger('change');

                if (!$('.chkServiceBy:checked').length) {
                    $('.chkServiceBy[data-value="PostalCode"]').prop('checked', true).trigger('change');
                    setTimeout(function() {
                    },2000)
                }
            });
            $(document).on("change",'#lstDistricts',function(){
                getTaluks({CountryID:$('#lstCountry').val(),StateID:$('#lstState').val(),DistrictID:$('#lstDistricts').val()},'lstTaluk');
            });
            $(document).on("change",'#lstState',function(){
                getDistricts({CountryID:$('#lstCountry').val(),StateID:$('#lstState').val()},'lstDistricts');
            });
            $(document).on("change",'#lstCountry',function(){
                getStates({CountryID:$('#lstCountry').val()},'lstState');
            });

            $(document).on('click', '.btnEditSAddress', function () {
                let Row=$(this).closest('tr');
                let EditData=JSON.parse($(this).closest('tr').find("td:eq(3)").html());
                EditData.EditID=Row.attr('id');
                EditData.AID=Row.attr('data-aid');
                getAddressModal(EditData);
            });

            $(document).on('click', '.btnOrderReview', function () {
                let Btn = $(this);
                let EditData = {
                    ID: Btn.data('id')
                };
                getReviewModal(EditData);
            });


            $(document).on('click', '#btnSaveReview', function () {
                SaveReview();
            });
            $(document).on('click', '#btnEditImage', function () {
                $('#txtCustomerImage').trigger('click');
            });

            const SaveReview = async () => {
                $('#txtRdescription-err').html('');
                let data = {};

                let OrderID = $("#btnSaveReview").attr('data-order-id');
                let Review = $("#txtRdescription").val();
                let Ratings = 0;
                $('.fa-star.sactive').each(function () {
                    Ratings = $(this).data('value');
                });

                if (Review === "") {
                    $('#txtRdescription-err').html('Review is required');
                } else if (Review.length < 5) {
                    $('#txtRdescription-err').html('The Review must be greater than 5 characters.');
                } else {
                    data.OrderID = OrderID;
                    data.Review = Review;
                    data.Ratings = Ratings;
                    $.ajax({
                        type: "post",
                        url: "{{ route('customer.order.review.save') }}",
                        data: data,
                        headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                        async: true,
                        error: function (e, x, settings, exception) {
                        },
                        success: async (response) => {
                            if(response.status){
                                toastr.success(response.message);
                                $('#orderProductCountSelect').change();
                            } else {
                                toastr.warning(response.message);
                            }
                            console.log(response)
                            bootbox.hideAll();
                        }
                    });

                }
            };


            $(document).on('keyup change', 'input, select', function () {
                $('.errors').html('');
            });

            const getAddressModal = (data = {}) => {
                $.ajax({
                    type: "post",
                    url: "{{url('/')}}/shipping-address-form",
                    data: {"data": JSON.stringify(data)},
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    dataType: "html",
                    async: true,
                    error: function (e, x, settings, exception) {
                    },
                    success: async (response) => {
                        if (response != "") {
                            bootbox.dialog({
                                title: "Shipping Address",
                                closeButton: true,
                                message: response,
                                className: "AddressModal",
                                buttons: {}
                            }).on('shown.bs.modal', function() {
                                $(this).scrollTop(0);
                            })
                        }
                    }
                });
            }

            const getReviewModal = (data = {}) => {
                $.ajax({
                    type: "post",
                    url: "{{url('/')}}/review-form",
                    data: {"data": JSON.stringify(data)},
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    dataType: "html",
                    async: true,
                    error: function (e, x, settings, exception) {
                    },
                    success: async (response) => {
                        if (response != "") {
                            bootbox.dialog({
                                title: "Review",
                                closeButton: true,
                                message: response,
                                className: "ReviewModal",
                                buttons: {}
                            });
                        }
                    }
                });
            }

            const getCity=async(data)=>{
                return await new Promise((resolve,reject)=>{
                    $.ajax({
                        type:"post",
                        url:"{{url('/')}}/get/city",
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:data,
                        dataType:"json",
                        async:true,
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                        complete: function(e, x, settings, exception){},
                        success:function(response){
                            resolve(response)
                        }
                    });
                });
            }
            const getTaluks=async(data,id)=>{
                $('#'+id+' option').remove();
                $('#'+id).append('<option value="">Select a Taluk</option>');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/taluks",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:data,
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        for(let Item of response){
                            let selected="";
                            if(Item.TalukID==$('#'+id).attr('data-selected')){selected="selected";}
                            $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.TalukID+'">'+Item.TalukName+' </option>');
                        }
                        if($('#'+id).val()!=""){
                            $('#'+id).trigger('change');
                        }
                    }
                });
            }
            const getDistricts=async(data,id)=>{
                let Data = [];
                $('#'+id+' option').remove();
                $('#'+id).append('<option value="">Select a District</option>');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/districts",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:data,
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        for(let Item of response){
                            let selected="";
                            if(Item.DistrictID==$('#'+id).attr('data-selected')){selected="selected";}
                            $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                        }
                        if($('#'+id).val()!=""){
                            $('#'+id).trigger('change');
                        }
                        Data = response;
                    }
                });
                return Data;
            }
            const getStates=async(data,id)=>{
                $('#'+id+' option').remove();
                $('#'+id).append('<option value="">Select a State</option>');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/states",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:data,
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        for(let Item of response){
                            let selected="";
                            if(Item.StateID==$('#'+id).attr('data-selected')){selected="selected";}
                            $('#'+id).append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                        }
                        if($('#'+id).val()!=""){
                            $('#'+id).trigger('change');
                        }
                    }
                });
            }
            const SaveAddress = async () => {
                let { status, formData, Address } = await ValidateGetAddress();
                console.log(formData);

                if (status) {

                    $.ajax({
                        type:"post",
                        url:"{{ route('UpdateShippingAddress') }}",
                        data: formData,
                        headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                        // dataType:"html",
                        async:true,
                        error:function(e, x, settings, exception){},
                        success:async(response)=>{
                            if(response.status === true){
                                let index = formData.EditID ? formData.EditID : $('#tblShippingAddress tbody tr').length + 1;

                                // ${formData.TalukName},<br>
                                //     ${formData.DistrictName}, ${formData.StateName},<br>
                                //     ${formData.CountryName} -
                                // <button type="button" class="btn btn-sm btn-outline-success m-2 btnEditSAddress"><i class="fas fa-pencil-alt"></i></button>

                                let html = `<tr id="${index}" data-aid="${response.AID}">
                                <td class="text-right checkbox1 align-middle">
                                    <div class="radio radio-primary">
                                        <input id="chkSA${index}" data-aid="${response.AID}" class="defaultAddress" type="radio" name="SAddress" value="${index}">
                                        <label for="chkSA${index}"></label>
                                    </div>
                                </td>
                                <td class="pointer align-middle">
                                    <b>${response.data.AddressType}</b><br>
                                    <b>${response.data.Address}</b>,<br>
                                    ${formData.CityName},${formData.PostalCode}.
                                </td>
                                <td class="align-middle">
                                        <div class="row justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-danger m-2 btnDeleteSAddress" data-aid="${response.AID}"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                <td class="d-none">${JSON.stringify(formData)}</td>
                            </tr>`;

                                if (formData.EditID) {
                                    $("#tblShippingAddress tbody tr").each(function () {
                                        let SNo = $(this).attr('id');
                                        if (SNo == formData.EditID) {
                                            $(this).replaceWith(html);
                                            return false;
                                        }
                                    });
                                } else {
                                    $('#tblShippingAddress tbody').append(html);
                                }
                                toastr.success("Address added successfully!.");
                            } else {
                                toastr.warning("Error!.");
                            }
                        }
                    });
                    bootbox.hideAll();
                }
            };
            const DeleteAddress = async (thiss) => {
                let { status, formData, Address } = await ValidateDeleteAddress(thiss.attr('data-aid'));
                $.ajax({
                    type:"post",
                    url:"{{ route('DeleteShippingAddress') }}",
                    data: formData,
                    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                    async:true,
                    error:function(e, x, settings, exception){},
                    success:async(response)=>{
                        if(response.status === true){
                            toastr.success('Shipping address deleted');
                            $('tr[data-aid="' + thiss.attr('data-aid') + '"]').remove();
                        } else {
                            toastr.warning(response.message);
                        }
                    }
                });
            };
            const SetDefaultAddress = async (thiss) => {
                let { status, formData, Address } = await ValidateDefaultAddress(thiss.attr('data-aid'));
                $.ajax({
                    type:"post",
                    url:"{{ route('SetAddressDefault') }}",
                    data: formData,
                    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                    async:true,
                    error:function(e, x, settings, exception){},
                    success:async(response)=>{
                        if(response.status === true){
                            toastr.success('Default address changed!.');
                            // $('tr[data-aid="' + thiss.attr('data-aid') + '"]').remove();
                        } else {
                            toastr.warning(response.message);
                        }
                    }
                });
            };
            const ValidateDeleteAddress = async (AID) => {
                let status = true;
                let Address = "";
                var formData={};
                formData.AID=AID;
                return { status, formData, Address };
            };
            const ValidateDefaultAddress = async (AID) => {
                let status = true;
                let Address = "";
                var formData={};
                formData.AID=AID;
                return { status, formData, Address };
            };
            const ValidateGetAddress = async () => {
                $(".errors.Address").html("");
                let status = true;
                var formData={};
                formData.EditID=$("#btnSaveAddress").attr('data-edit-id');
                formData.AID = $("#btnSaveAddress").attr('data-aid');
                formData.AddressType = $('#txtADAddressType').val();
                formData.OtherAddressType = $('#txtOtherADAddressType').val();
                formData.Address = $('#txtADAddress').val();
                formData.CompleteAddress = $('#txtADAddress').val();
                formData.Latitude = $('#txtADLatitude').val();
                formData.Longitude=$('#txtADLongitude').val();
                formData.mapData=$('#mapData').val();
                // formData.CountryID=$('#lstADCountry').val();
                // formData.CountryName=$('#lstADCountry option:selected').attr('data-country-name');
                // formData.StateID=$('#lstADState').val();
                // formData.StateName=$('#lstADState option:selected').text();
                // formData.DistrictID=$('#lstADDistrict').val();
                // formData.DistrictName=$('#lstADDistrict option:selected').text();
                // formData.TalukID=$('#lstADTaluk').val();
                // formData.TalukName=$('#lstADTaluk option:selected').text();
                formData.CityID=$('#lstADCity').val();
                formData.CityName=$('#lstADCity option:selected').text();
                formData.PostalCode=$('#txtADPostalCode').val();
                formData.PostalCodeID=$('#lstADCity option:selected').attr('data-postal-id');
                // console.log(formData);
                let Address ="";
                if(formData.Address==""){
                    $('#txtADAddress-err').html('Address is required');status=false;
                }else if(formData.Address.length<5){
                    $('#txtADAddress-err').html('The Address must be greater than 5 characters.');status=false;
                }else{
                    Address+=",<br>"+formData.Address;
                }
                if(formData.CityID==""){
                    $('#lstADCity-err').html('City is required');status=false;
                }else{
                    Address+=",<br>"+formData.CityName;
                }
                if(formData.AddressType==""){
                    $('#txtADAddressType-err').html('Address Type is required');status=false;
                }
                // if(formData.TalukID==""){
                //     $('#lstADTaluk-err').html('Taluk is required');status=false;
                // }else{
                //     Address+=",<br>"+formData.TalukName;
                // }
                // if(formData.DistrictID==""){
                //     $('#lstADDistrict-err').html('District is required');status=false;
                // }else{
                //     Address+=",<br>"+formData.DistrictName;
                // }
                // if(formData.StateID==""){
                //     $('#lstADState-err').html('State is required');status=false;
                // }else{
                //     Address+=",<br>"+formData.StateName;
                // }
                // if(formData.CountryID==""){
                //     $('#lstADCountry-err').html('Country is required');status=false;
                // }else{
                //     Address+=","+formData.CountryName;
                // }
                if(formData.PostalCode==""){
                    $('#txtADPostalCode-err').html('Postal Code is required');status=false;
                }else{
                    Address+=" - "+formData.PostalCode;
                }
                // status = true;
                return { status, formData, Address };
            };
            const getData=async ()=>{
                let status = await validateForm();
                if(status){
                    let tmp=await UploadImages();
                    let formData=new FormData();
                    formData.append('CustomerName',$('#txtCustomerName').val());
                    formData.append('MobileNo1',$('#txtMobileNo1').val());
                    formData.append('MobileNo2',$('#txtMobileNo2').val());
                    formData.append('Email',$('#txtEmail').val());
                    formData.append('GenderID', $('#lstGender').val());
                    formData.append('DOB', $('#txtDOB').val());
                    formData.append('CusTypeID', $('#lstCusType').val());
                    formData.append('ConTypeIDs', $('#lstConTypeIDs').val());
                    formData.append('Address',$('#txtAddress').val());
                    formData.append('PostalCodeID',$('#lstCity option:selected').attr('data-postal'));
                    formData.append('CityID',$('#lstCity').val());
                    formData.append('TalukID',$('#lstTaluk').val());
                    formData.append('DistrictID',$('#lstDistricts').val());
                    formData.append('StateID',$('#lstState').val());
                    formData.append('CountryID',$('#lstCountry').val());
                    if(tmp.coverImage.uploadPath!=""){
                        formData.append('CustomerImage', JSON.stringify(tmp.coverImage));
                    }
                    let SAddress = [];
                    $("#tblShippingAddress tbody tr").each(function() {
                        let Address = JSON.parse($(this).find("td:eq(3)").html());
                        let isSelectedDefaultShipping = $(this).find('input[type="radio"][name="SAddress"]:checked').length;
                        Address.isDefault = isSelectedDefaultShipping ? 1 : 0;
                        SAddress.push(Address);
                    });
                    formData.append('SAddress',JSON.stringify(SAddress));
                    return formData;
                }
            }
            function validateForm() {
                $('.errors').html('');
                let status=true;
                let CustomerName=$('#txtCustomerName').val();
                let MobileNo1=$('#txtMobileNo1').val();
                let MobileNo2=$('#txtMobileNo2').val();
                let Email=$('#txtEmail').val();
                let Gender=$('#lstGender').val();
                let DOB=$('#txtDOB').val();
                let CusType=$('#lstCusType').val();
                let ConType=$('#lstConTypeIDs').val();
                let AddressType=$('#txtADAddressType').val();
                let Address=$('#txtAddress').val();
                let PostalCode=$('#lstCity option:selected').attr('data-postal');
                let CityID=$('#lstCity').val();
                let TalukID=$('#lstTaluk').val();
                let DistrictID=$('#lstDistricts').val();
                let StateID=$('#lstState').val();
                let CountryID=$('#lstCountry').val();
                if(!CustomerName){
                    $('#txtCustomerName-err').html('Customer Name is required');status=false;
                }else if(CustomerName.length<2){
                    $('#txtCustomerName-err').html('The Customer Name is must be greater than 2 characters.');status=false;
                }else if(CustomerName.length>100){
                    $('#txtCustomerName-err').html('The Customer Name is not greater than 100 characters.');status=false;
                }
                let mobilePattern = /^\d{10}$/;
                if(!MobileNo1){
                    $('#txtMobileNo1-err').html('Mobile Number is required.');status=false;
                }else if (!mobilePattern.test(MobileNo1)){
                    $("#txtMobileNo1-err").html("Mobile Number must be 10 digit");
                }
                if (MobileNo2.length > 0 && !mobilePattern.test(MobileNo2)){
                    $("#txtMobileNo2-err").html("Alternate Mobile Number must be 10 digit");status=false;
                }
                if(Gender === ""){
                    $('#lstGender-err').html('Gender is required.');status=false;
                }
                if(DOB === ""){
                    $('#txtDOB-err').html('DOB is required.');status=false;
                }
                if(AddressType === ""){
                    $('#txtADAddressType-err').html('Address Type is required.');status=false;
                }
                if(CusType === ""){
                    $('#lstCusType-err').html('Customer type is required.');status=false;
                }
                if(ConType.length === 0){
                    $('#lstConTypeIDs-err').html('Construction type is required.');status=false;
                }
                if(!PostalCode){
                    $('#txtPostalCode-err').html('Postal Code is required.');status=false;isAddress=true;
                }
                if(CityID==""){
                    $('#lstCity-err').html('City is required.');status=false;isAddress=true;
                }
                if(TalukID==""){
                    $('#lstTaluk-err').html('Taluk is required.');status=false;isAddress=true;
                }
                if(DistrictID==""){
                    $('#lstDistricts-err').html('District is required.');status=false;isAddress=true;
                }
                if(StateID==""){
                    $('#lstState-err').html('State is required.');status=false;isAddress=true;
                }
                if(CountryID==""){
                    $('#lstCountry-err').html('Country is required.');status=false;isAddress=true;
                }
                if(Address==""){
                    $('#txtAddress-err').html('Address is required.');status=false;
                }else if(Address.length<10){
                    $('#txtAddress-err').html('Address must be greater than 10 characters');status=false;isAddress=true;
                }
                let TotRows=$('#tblShippingAddress tbody tr').length;
                let isSelectedDefaultShipping=$('input[type="radio"][name="SAddress"]:checked').length
                if(TotRows<=0){
                    $('#btnAddAddress-err').html('Shipping address is required');status=false;
                }else if(isSelectedDefaultShipping<=0){
                    $('#tblShippingAddress-err').html('Select a default shipping address');status=false;
                }
                if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}

                // return true;
                return status;
            }
            $(document).on('click', '#btnSaveAddress', function () {
                SaveAddress();
            });
            $(document).on('click', '.defaultAddress', function () {
                SetDefaultAddress($(this));
            });
            $(document).on('click', '.btnDeleteSAddress', function () {
                var thiss = $(this);
                DeleteAddress(thiss);
            });
            $(document).on('click', '#btnSave', function () {
                let status = validateForm();
                if (status) {
                    $.magnificPopup.open({
                        items: {
                            src: '#confirm-modal'
                        },
                        type: 'inline',
                        mainClass: 'mfp mfp-custom-width',
                        removalDelay: 350
                    });
                }
            });

            $(document).on('click', '#btnReviewMClose', function () {
                bootbox.hideAll();
            });
            $(document).on('click', '#btnMConfirm', async function () {
                let formData = await getData();
                let postUrl = "{{url('/')}}/update";
                $.ajax({
                    type: "post",
                    url: postUrl,
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: function (e, x, settings, exception) {
                        // ajax_errors(e, x, settings, exception);
                        toastr.failure("Error!.");
                    },
                    complete: function (e, x, settings, exception) {
                        btnReset($('#btSave'));
                        ajaxIndicatorStop();
                        $("html, body").animate({scrollTop: 0}, "slow");
                    },
                    success: function (response) {
                        if (response.status == true) {
                            toastr.success("Profile saved");
                            $('#confirm-modal .mfp-close').click();
                            $('html, body').animate({
                                scrollTop: $('.profilePageTitle').offset().top
                            }, 1000);
                        } else {
                            $("html, body").animate({scrollTop: 0}, "slow");
                            if (response['errors'] != undefined) {
                                $('.errors').html('');
                                $.each(response['errors'], function (KeyName, KeyValue) {
                                    var key = KeyName;
                                    if (key == "Email") {
                                        $('#txtEmail-err').html(KeyValue);
                                    }
                                    if (key == "MobileNo1") {
                                        $('#txtMobileNo1-err').html(KeyValue);
                                    }
                                    if (key == "CustomerImage") {
                                        $('#txtCustomerImage-err').html(KeyValue);
                                    }
                                });
                            }
                        }
                    }
                });
            });
            $(document).on('click', '#btnMCancel', function () {
                $.magnificPopup.close();
            });
        });
    </script>
@endsection
