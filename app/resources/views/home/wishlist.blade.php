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
                <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="wishlist-title">
            <h2 class="p-2">My wishlist</h2>
        </div>
        <div class="wishlist-table-container">
            <table class="table table-wishlist mb-0">
                <thead>
                <tr>
                    <th class="thumbnail-col"></th>
                    <th class="product-col">Product</th>
                    <th class="status-col">Stock Status</th>
                    <th class="action-col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="product-row">
                    <td>
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-4.jpg" alt="product">
                            </a>

                            <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                        </figure>
                    </td>
                    <td>
                        <h5 class="product-title">
                            <a href="product.html">Men Watch</a>
                        </h5>
                    </td>
                    <td>
                        <span class="stock-status">In stock</span>
                    </td>
                    <td class="action">
                        <a href="ajax/product-quick-view.html" class="btn btn-quickview mt-1 mt-md-0" title="Quick View">Quick
                            View</a>
                        <button class="btn btn-dark btn-add-cart product-type-simple btn-shop">
                            ADD TO CART
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div><!-- End .cart-table-container -->
    </div>
@endsection
@section('scripts')
{{--    <script>--}}
{{--        $(document).ready(function(){--}}
{{--            let RootUrl=$('#txtRootUrl').val();--}}
{{--            const LoadTable=async()=>{--}}
{{--                $('#tblQuotations').dataTable({--}}
{{--                    "bProcessing": true,--}}
{{--                    "bServerSide": true,--}}
{{--                    "ajax": {"url": "{{url('/')}}/requested-quotations/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},--}}
{{--                    deferRender: true,--}}
{{--                    responsive: true,--}}
{{--                    dom: 'Bfrtip',--}}
{{--                    "iDisplayLength": 10,--}}
{{--                    "lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],--}}
{{--                    buttons: ['pageLength'],--}}
{{--                    columnDefs: [--}}
{{--                        {"className": "dt-center", "targets": [0, 1, 2, 3, 4]},--}}
{{--                    ]--}}
{{--                });--}}
{{--            }--}}
{{--            $(document).on('click','.btnView',function(){--}}
{{--                window.location.replace("{{url('/')}}/quotations/view/"+ $(this).attr('data-id'));--}}
{{--            });--}}
{{--            --}}{{--$(document).on('click','.btnVendorQuoteView',function(){--}}
{{--            --}}{{--    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/vendor-quote/"+ $(this).attr('data-id'));--}}
{{--            --}}{{--});--}}

{{--            --}}{{--$(document).on('click','.btnDelete',function(){--}}
{{--            --}}{{--    let ID=$(this).attr('data-id');--}}
{{--            --}}{{--    swal({--}}
{{--            --}}{{--            title: "Are you sure?",--}}
{{--            --}}{{--            text: "You want to Cancel this Quotation!",--}}
{{--            --}}{{--            type: "warning",--}}
{{--            --}}{{--            showCancelButton: true,--}}
{{--            --}}{{--            confirmButtonClass: "btn-outline-danger",--}}
{{--            --}}{{--            confirmButtonText: "Yes, Cancel it!",--}}
{{--            --}}{{--            closeOnConfirm: false--}}
{{--            --}}{{--        },--}}
{{--            --}}{{--        function(){swal.close();--}}
{{--            --}}{{--            $.ajax({--}}
{{--            --}}{{--                type:"post",--}}
{{--            --}}{{--                url:"{{url('/')}}/admin/transaction/quote-enquiry/delete/"+ID,--}}
{{--            --}}{{--                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
{{--            --}}{{--                dataType:"json",--}}
{{--            --}}{{--                success:function(response){--}}
{{--            --}}{{--                    swal.close();--}}
{{--            --}}{{--                    if(response.status==true){--}}
{{--            --}}{{--                        $('#tblQuoteEnquiry').DataTable().ajax.reload();--}}
{{--            --}}{{--                        toastr.success(response.message, "Success", {--}}
{{--            --}}{{--                            positionClass: "toast-top-right",--}}
{{--            --}}{{--                            containerId: "toast-top-right",--}}
{{--            --}}{{--                            showMethod: "slideDown",--}}
{{--            --}}{{--                            hideMethod: "slideUp",--}}
{{--            --}}{{--                            progressBar: !0--}}
{{--            --}}{{--                        })--}}
{{--            --}}{{--                    }else{--}}
{{--            --}}{{--                        toastr.error(response.message, "Failed", {--}}
{{--            --}}{{--                            positionClass: "toast-top-right",--}}
{{--            --}}{{--                            containerId: "toast-top-right",--}}
{{--            --}}{{--                            showMethod: "slideDown",--}}
{{--            --}}{{--                            hideMethod: "slideUp",--}}
{{--            --}}{{--                            progressBar: !0--}}
{{--            --}}{{--                        })--}}
{{--            --}}{{--                    }--}}
{{--            --}}{{--                }--}}
{{--            --}}{{--            });--}}
{{--            --}}{{--        });--}}
{{--            // });--}}
{{--            LoadTable();--}}
{{--        });--}}
{{--    </script>--}}
@endsection
