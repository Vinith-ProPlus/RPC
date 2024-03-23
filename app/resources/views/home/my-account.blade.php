@extends('home.home-layout')
@section('content')
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
    </style>
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
                            <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="false">Account
                                details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="quotations-tab" data-toggle="tab" href="#quotations" role="tab" aria-controls="quotations" aria-selected="false">Quotations</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false">Orders</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab" aria-controls="download" aria-selected="false">Downloads</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Addresses</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="edit" aria-selected="false">Shopping Address</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="wishlist-tab" data-toggle="tab" href="#wishlist" role="tab" aria-controls="wishlist" aria-selected="false">Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="support-tab" data-toggle="tab" href="#support" role="tab" aria-controls="support" aria-selected="false">Support</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Logout</a>
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
                                        <a href="#order" class="link-to-tab"><i class="sicon-social-dropbox"></i></a>
                                        <div class="feature-box-content">
                                            <h3>ORDERS</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#download" class="link-to-tab"><i class="sicon-cloud-download"></i></a>
                                        <div class=" feature-box-content">
                                            <h3>DOWNLOADS</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#address" class="link-to-tab"><i class="sicon-location-pin"></i></a>
                                        <div class="feature-box-content">
                                            <h3>ADDRESSES</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#edit" class="link-to-tab"><i class="icon-user-2"></i></a>
                                        <div class="feature-box-content p-0">
                                            <h3>ACCOUNT DETAILS</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="#wishlist-tab"><i class="sicon-heart"></i></a>
                                        <div class="feature-box-content">
                                            <h3>WISHLIST</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="feature-box text-center pb-4">
                                        <a href="login.html"><i class="sicon-logout"></i></a>
                                        <div class="feature-box-content">
                                            <h3>LOGOUT</h3>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .row -->
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="quotations" role="tabpanel">
                        <div class="order-content">
                            <h3 class="account-sub-title d-none d-md-block"><i class="sicon-social-dropbox align-middle mr-3"></i>Quotations</h3>
                            <div class="order-table-container text-center">
                                <table class="table table-order text-left">
                                    <thead>
                                    <tr>
                                        <th class="order-id">ORDER</th>
                                        <th class="order-date">DATE</th>
                                        <th class="order-status">STATUS</th>
                                        <th class="order-price">TOTAL</th>
                                        <th class="order-action">ACTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center p-0" colspan="5">
                                            <p class="mb-5 mt-5">
                                                No Order has been made yet.
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr class="mt-0 mb-3 pb-2">

                                <a href="category.html" class="btn btn-dark">Go Shop</a>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="order" role="tabpanel">
                        <div class="order-content">
                            <h3 class="account-sub-title d-none d-md-block"><i class="sicon-social-dropbox align-middle mr-3"></i>Orders</h3>
                            <div class="order-table-container text-center">
                                <table class="table table-order text-left">
                                    <thead>
                                    <tr>
                                        <th class="order-id">ORDER</th>
                                        <th class="order-date">DATE</th>
                                        <th class="order-status">STATUS</th>
                                        <th class="order-price">TOTAL</th>
                                        <th class="order-action">ACTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center p-0" colspan="5">
                                            <p class="mb-5 mt-5">
                                                No Order has been made yet.
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr class="mt-0 mb-3 pb-2">

                                <a href="category.html" class="btn btn-dark">Go Shop</a>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

                    <div class="tab-pane fade" id="wishlist" role="tabpanel">
                        <div class="download-content">
                            <h3 class="account-sub-title d-none d-md-block"><i class="sicon-cloud-download align-middle mr-3"></i>Wishlist</h3>
                            <div class="download-table-container" style="margin-top: 20px !important;">
                                <div class="wishlist-table-container" id="wishlistTableHtml">
                                </div>
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->
                    <div class="tab-pane fade" id="support" role="tabpanel">
                        <div class="download-content">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="account-sub-title d-none d-md-block"><i class="sicon-cloud-download align-middle mr-3"></i>Support</h3>
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

                    <div class="tab-pane fade" id="edit" role="tabpanel">
                        <h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i class="icon-user-2 align-middle mr-3 pr-1"></i>Account Details</h3>
                        <div class="account-content">
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="acc-name">First name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Editor" id="acc-name" name="acc-name" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="acc-lastname">Last name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="acc-lastname" name="acc-lastname" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="acc-text">Display name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="acc-text" name="acc-text" placeholder="Editor" required="">
                                    <p>This will be how your name will be displayed in the account section and
                                        in
                                        reviews</p>
                                </div>


                                <div class="form-group mb-4">
                                    <label for="acc-email">Email address <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="acc-email" name="acc-email" placeholder="editor@gmail.com" required="">
                                </div>

                                <div class="change-password">
                                    <h3 class="text-uppercase mb-2">Password Change</h3>

                                    <div class="form-group">
                                        <label for="acc-password">Current Password (leave blank to leave
                                            unchanged)</label>
                                        <input type="password" class="form-control" id="acc-password" name="acc-password">
                                    </div>

                                    <div class="form-group">
                                        <label for="acc-password">New Password (leave blank to leave
                                            unchanged)</label>
                                        <input type="password" class="form-control" id="acc-new-password" name="acc-new-password">
                                    </div>

                                    <div class="form-group">
                                        <label for="acc-password">Confirm New Password</label>
                                        <input type="password" class="form-control" id="acc-confirm-password" name="acc-confirm-password">
                                    </div>
                                </div>

                                <div class="form-footer mt-3 mb-0">
                                    <button type="submit" class="btn btn-dark mr-0">
                                        Save changes
                                    </button>
                                </div>
                            </form>
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
                console.log('skqjbxs');
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

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadWishlists();
                        LoadSupports();
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
@endsection
