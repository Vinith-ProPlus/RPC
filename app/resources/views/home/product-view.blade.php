@extends('home.home-layout')
@section('content')
    <style>
        @charset "UTF-8";

        button.mfp-arrow,
        button.mfp-close {
            overflow:visible;
            cursor:pointer;
            background:transparent;
            border:0;
            -webkit-appearance:none;
            display:block;
            outline:none;
            padding:0;
            z-index:1046;
            box-shadow:none;
            touch-action:manipulation
        }
        button::-moz-focus-inner {
            padding:0;
            border:0
        }
        .mfp-fade.mfp-wrap .mfp-content {
            opacity:0;
            -webkit-transition:all 0.15s ease-out;
            -moz-transition:all 0.15s ease-out;
            transition:all 0.15s ease-out
        }
        .mfp-fade.mfp-wrap.mfp-ready .mfp-content {
            opacity:1
        }
        .mfp-fade.mfp-wrap.mfp-removing .mfp-content {
            opacity:0
        }
        .bootstrap-touchspin .input-group-btn-vertical {
            position:absolute;
            right:0;
            height:100%;
            z-index:11
        }
        .bootstrap-touchspin .form-control {
            text-align:center;
            margin-bottom:0;
            height:4.2rem;
            max-width:46px;
            padding:1.1rem 1rem
        }
        .bootstrap-touchspin .form-control:not(:focus) {
            border-color:#ccc
        }
        .bootstrap-touchspin .input-group-btn-vertical>.btn {
            position:absolute;
            right:0;
            height:2rem;
            padding:0;
            width:2rem;
            text-align:center;
            font-size:1.2rem
        }
        .bootstrap-touchspin .input-group-btn-vertical>.btn:before {
            position:relative;
            margin:0;
            width:auto;
            line-height:1;
            width:auto;
            top:-0.1rem;
            margin-right:-0.2rem
        }
        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-up {
            border-radius:0;
            top:0
        }
        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-down {
            border-radius:0;
            bottom:0
        }

        html:not([dir=rtl]) .noUi-horizontal .noUi-origin {
            left:auto;
            right:0
        }
        .noUi-vertical .noUi-origin {
            width:0
        }
        .noUi-horizontal .noUi-origin {
            height:0
        }
        .noUi-handle {
            position:absolute
        }
        .noUi-state-tap .noUi-connect,
        .noUi-state-tap .noUi-origin {
            -webkit-transition:transform 0.3s;
            transition:transform 0.3s
        }
        .noUi-state-drag * {
            cursor:inherit!important
        }
        .noUi-horizontal {
            height:0.3rem
        }
        .noUi-horizontal .noUi-handle {
            width:1.1rem;
            height:1.1rem;
            left:-0.55rem;
            top:-0.3em
        }
        .noUi-vertical {
            width:0.3rem;
            height:150px
        }
        .noUi-vertical .noUi-handle {
            width:1.1rem;
            height:1.1rem;
            left:-0.4rem;
            top:-0.5rem
        }
        html:not([dir=rtl]) .noUi-horizontal .noUi-handle {
            right:-0.55rem;
            left:auto
        }
        .alert {
            display:flex;
            align-items:center;
            font-family:Poppins,sans-serif;
            margin-bottom:2rem;
            padding:1.6rem 1.5rem;
            border-radius:0
        }
        .alert i {
            font-size:1.7em;
            width:3.9rem
        }
        .alert.icon-sm i {
            font-size:1.1em;
            width:2.9rem
        }
        .alert .pixel-icon {
            height:16px;
            background-repeat:no-repeat;
            background-position:0 0;
            margin-bottom:1px
        }
        .alert .alert-wrapper h4 {
            letter-spacing:-0.05em;
            margin-bottom:1.4rem
        }
        .alert .alert-wrapper p {
            line-height:2.4rem;
            margin-bottom:2rem
        }
        .alert .alert-wrapper ul {
            margin:2rem 0 0 2.5rem;
            list-style:disc
        }
        .alert .alert-wrapper li {
            line-height:2.5rem
        }
        .alert .alert-wrapper .btn {
            text-transform:none;
            font-weight:400;
            font-size:1.3rem;
            padding:0.533rem 0.933rem
        }
        .alert .alert-close {
            z-index:2;
            padding:0.95rem 0 0.95rem 2.5rem;
            cursor:pointer;
            width:1em;
            height:1em;
            color:#000;
            background:transparent url(../images/elements/alert/close.svg) center/1em auto no-repeat;
            border:0;
            border-radius:0;
            opacity:0.5;
            transition:opacity 0.2s;
            margin-left:auto
        }
        .alert .alert-close:hover {
            opacity:1
        }
        .alert.alert-intro {
            font-size:1.5rem
        }
        .alert-rounded {
            border-radius:5px
        }
        .alert.alert-default {
            background-color:#f2f2f2;
            border-color:#eaeaea;
            color:#737373
        }
        .alert.alert-default .alert-link {
            color:#4c4c4c
        }
        .alert.alert-dark {
            background-color:#3a3f45;
            border-color:#0b0c0e;
            color:#d5d8dc
        }
        .alert.alert-dark .alert-link {
            color:#fff
        }
        .alert.alert-primary {
            background-color:#0088cc;
            border-color:#007ebd;
            color:#fff
        }
        .alert.alert-secondary {
            background-color:#e36159;
            border-color:#e1554c;
            color:#fff
        }
        .alert.alert-tertiary {
            background-color:#2baab1;
            border-color:#299fa5;
            color:#fff
        }
        .alert.alert-quaternary {
            background-color:#383f48;
            border-color:#323840;
            color:#fff
        }
        .alert.alert-sm {
            padding:0.5rem 1rem
        }
        .alert.alert-lg {
            padding:2rem
        }
        @keyframes maskUp {
            0% {
                transform:translate(0,100%)
            }
            to {
                transform:translate(0,0)
            }
        }
        @keyframes maskRight {
            0% {
                transform:translate(-100%,0)
            }
            to {
                transform:translate(0,0)
            }
        }
        @keyframes maskDown {
            0% {
                transform:translate(0,-100%)
            }
            to {
                transform:translate(0,0)
            }
        }
        @keyframes maskLeft {
            0% {
                transform:translate(100%,0)
            }
            to {
                transform:translate(0,0)
            }
        }
        .maskUp {
            animation-name:maskUp
        }
        .maskRight {
            animation-name:maskRight
        }
        .maskDown {
            animation-name:maskDown
        }
        .maskLeft {
            animation-name:maskLeft
        }
        @keyframes fadeInUpShorter {
            0% {
                opacity:0;
                transform:translate(0,50px)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInUpShorter {
            animation-timing-function:ease-out;
            animation-name:fadeInUpShorter
        }
        @keyframes fadeInUpBig {
            0% {
                opacity:0;
                transform:translate(0,2000px)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInUpBig {
            animation-timing-function:ease-out;
            animation-name:fadeInUpBig
        }
        @keyframes fadeInLeftShorter {
            0% {
                opacity:0;
                transform:translate(50px,0)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInLeftShorter {
            animation-timing-function:ease-out;
            animation-name:fadeInLeftShorter
        }
        @keyframes fadeInLeftBig {
            0% {
                opacity:0;
                transform:translate(2000px,0)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInLeftBig {
            animation-timing-function:ease-out;
            animation-name:fadeInLeftBig
        }
        @keyframes fadeInRightShorter {
            0% {
                opacity:0;
                transform:translate(-50px,0)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInRightShorter {
            animation-timing-function:ease-out;
            animation-name:fadeInRightShorter
        }
        @keyframes fadeInRightBig {
            0% {
                opacity:0;
                transform:translate(-2000px,0)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInRightBig {
            animation-timing-function:ease-out;
            animation-name:fadeInRightBig
        }
        .fadeIn {
            animation-name:fadeIn
        }
        @keyframes fadeIn {
            0% {
                opacity:0
            }
            to {
                opacity:1
            }
        }
        @keyframes fadeInDownShorter {
            0% {
                opacity:0;
                transform:translate(0,-50px)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInDownShorter {
            animation-name:fadeInDownShorter;
            animation-timing-function:ease-out
        }
        @keyframes fadeInDownBig {
            0% {
                opacity:0;
                transform:translate(0,-2000px)
            }
            to {
                opacity:1;
                transform:none
            }
        }
        .fadeInDownBig {
            animation-name:fadeInDownBig;
            animation-timing-function:ease-out
        }
        @keyframes flash {
            0%,
            50%,
            to {
                opacity:1
            }
            25%,
            75% {
                opacity:0
            }
        }
        .flash {
            animation-name:flash
        }
        @keyframes shake {
            0%,
            to {
                transform:translateX(0);
                opacity:1
            }
            10%,
            30%,
            50%,
            70%,
            90% {
                transform:translateX(-10px)
            }
            20%,
            40%,
            60%,
            80% {
                transform:translateX(10px)
            }
        }
        .shake {
            animation-name:shake
        }
        @keyframes tada {
            0% {
                transform:scale(1)
            }
            10%,
            20% {
                transform:scale(0.9) rotate(-3deg)
            }
            30%,
            50%,
            70%,
            90% {
                transform:scale(1.1) rotate(3deg)
            }
            40%,
            60%,
            80% {
                transform:scale(1.1) rotate(-3deg)
            }
            to {
                transform:scale(1) rotate(0);
                opacity:1
            }
        }
        .tada {
            animation-name:tada
        }
        @keyframes pulse {
            0% {
                transform:scale(1)
            }
            50% {
                transform:scale(1.1)
            }
            to {
                transform:scale(1);
                opacity:1
            }
        }
        .pulse {
            animation-name:pulse
        }
        @keyframes swing {
            0% {
                transform:rotate(0)
            }
            20% {
                transform:rotate(15deg)
            }
            40% {
                transform:rotate(-10deg)
            }
            60% {
                transform:rotate(5deg)
            }
            80% {
                transform:rotate(-5deg)
            }
            to {
                transform:rotate(0);
                opacity:1
            }
        }
        .swing {
            animation-name:swing
        }
        @keyframes wobble {
            0% {
                transform:translateX(0%)
            }
            15% {
                transform:translateX(-25%) rotate(-5deg)
            }
            30% {
                transform:translateX(20%) rotate(3deg)
            }
            45% {
                transform:translateX(-15%) rotate(-3deg)
            }
            60% {
                transform:translateX(10%) rotate(2deg)
            }
            75% {
                transform:translateX(-5%) rotate(-1deg)
            }
            to {
                transform:translateX(0%);
                opacity:1
            }
        }
        .wobble {
            animation-name:wobble
        }
        @keyframes blurIn {
            0% {
                opacity:0;
                filter:blur(20px);
                transform:scale(1.3)
            }
            to {
                opacity:1;
                filter:blur(0);
                transform:none
            }
        }
        .blurIn {
            animation-name:blurIn
        }
        @keyframes dotPulse {
            0% {
                opacity:1;
                transform:scale(0.2)
            }
            to {
                opacity:0;
                transform:scale(1)
            }
        }
        .dotPulse {
            animation-name:dotPulse;
            animation-iteration-count:infinite;
            animation-duration:4s
        }
        @keyframes slideInUp {
            0% {
                transform:translate3d(0,100%,0);
                visibility:visible
            }
            to {
                transform:translateZ(0)
            }
        }
        @keyframes slideInDown {
            0% {
                transform:translate3d(0,-100%,0);
                visibility:visible
            }
            to {
                transform:translateZ(0)
            }
        }
        @keyframes slideInLeft {
            0% {
                transform:translate3d(-100%,0,0);
                visibility:visible
            }
            to {
                transform:translateZ(0)
            }
        }
        @keyframes slideInRight {
            0% {
                transform:translate3d(100%,0,0);
                visibility:visible
            }
            to {
                transform:translateZ(0)
            }
        }
        @keyframes flipInX {
            0% {
                animation-timing-function:ease-in;
                opacity:0;
                transform:perspective(400px) rotateX(90deg)
            }
            to {
                transform:perspective(400px)
            }
        }
        @keyframes flipInY {
            0% {
                animation-timing-function:ease-in;
                opacity:0;
                transform:perspective(400px) rotateY(-90deg)
            }
            to {
                transform:perspective(400px)
            }
        }
        @keyframes brightIn {
            0% {
                animation-timing-function:ease-in;
                filter:brightness(0%)
            }
            to {
                filter:brightness(100%)
            }
        }
        @keyframes bounce {
            0%,
            20%,
            50%,
            80%,
            to {
                transform:translateY(0);
                opacity:1
            }
            40% {
                transform:translateY(-30px)
            }
            60% {
                transform:translateY(-15px)
            }
        }
        .bounce {
            animation-name:bounce
        }
        @keyframes bounceIn {
            0% {
                opacity:0;
                transform:scale(0.3)
            }
            50% {
                opacity:1;
                transform:scale(1.05)
            }
            70% {
                transform:scale(0.9)
            }
            to {
                transform:scale(1)
            }
        }
        .bounceIn {
            animation-name:bounceIn
        }
        @keyframes bounceInUp {
            0% {
                opacity:0;
                transform:translateY(2000px)
            }
            60% {
                transform:translateY(-30px)
            }
            80% {
                transform:translateY(10px)
            }
            to {
                transform:translateY(0);
                opacity:1
            }
        }
        .bounceInUp {
            animation-name:bounceInUp
        }
        @keyframes bounceInDown {
            0% {
                opacity:0;
                transform:translateY(-2000px)
            }
            60% {
                transform:translateY(30px)
            }
            80% {
                transform:translateY(-10px)
            }
            to {
                transform:translateY(0);
                opacity:1
            }
        }
        .bounceInDown {
            animation-name:bounceInDown
        }
        @keyframes bounceInLeft {
            0% {
                opacity:0;
                transform:translateX(-2000px)
            }
            60% {
                transform:translateX(30px)
            }
            80% {
                transform:translateX(-10px)
            }
            to {
                transform:translateX(0);
                opacity:1
            }
        }
        .bounceInLeft {
            animation-name:bounceInLeft
        }
        @keyframes bounceInRight {
            0% {
                opacity:0;
                transform:translateX(2000px)
            }
            60% {
                transform:translateX(-30px)
            }
            80% {
                transform:translateX(10px)
            }
            to {
                transform:translateX(0);
                opacity:1
            }
        }
        .bounceInRight {
            animation-name:bounceInRight
        }
        @keyframes rotateIn {
            0% {
                transform-origin:center center;
                transform:rotate(-200deg);
                opacity:0
            }
            to {
                transform:rotate(0);
                opacity:1
            }
        }
        .rotateIn {
            animation-name:rotateIn
        }
        @keyframes rotateInUpLeft {
            0% {
                opacity:0;
                transform:rotate(90deg);
                transform-origin:left bottom
            }
            to {
                opacity:1;
                transform:rotate(0)
            }
        }
        .rotateInUpLeft {
            animation-name:rotateInUpLeft
        }
        @keyframes rotateInDownLeft {
            0% {
                opacity:0;
                transform:rotate(-90deg);
                transform-origin:left bottom
            }
            to {
                opacity:1;
                transform:rotate(0)
            }
        }
        .rotateInDownLeft {
            animation-name:rotateInDownLeft
        }
        @keyframes rotateInUpRight {
            0% {
                opacity:0;
                transform:rotate(-90deg);
                transform-origin:right bottom
            }
            to {
                opacity:1;
                transform:rotate(0)
            }
        }
        .rotateInUpRight {
            animation-name:rotateInUpRight
        }
        @keyframes rotateInDownRight {
            0% {
                opacity:0;
                transform:rotate(90deg);
                transform-origin:right bottom
            }
            to {
                opacity:1;
                transform:rotate(0)
            }
        }
        .rotateInDownRight {
            animation-name:rotateInDownRight
        }
        .brightIn {
            animation-name:brightIn
        }
        @keyframes customSVGLineAnimTwo {
            0% {
                stroke-dasharray:820;
                stroke-dashoffset:500
            }
            to {
                stroke-dasharray:1120;
                stroke-dashoffset:500
            }
        }
        .customSVGLineAnimTwo {
            animation-name:customSVGLineAnimTwo
        }
        .appear-animate {
            opacity:0
        }
        .appear-animation-visible {
            opacity:1
        }
        .banner {
            position:relative;
            font-size:1.6rem
        }
        .banner figure {
            margin:0
        }
        .banner img {
            width:100%;
            object-fit:cover
        }
        .banner h1,
        .banner h2,
        .banner h3,
        .banner h4,
        .banner h5,
        .banner h6 {
            line-height:1
        }
        .owl-dots .owl-dot,
        .owl-nav .owl-next,
        .owl-nav .owl-prev {
            outline:none
        }
        a:focus {
            outline:none
        }
        @keyframes spin {
            0% {
                transform:rotate(0deg)
            }
            to {
                transform:rotate(359deg)
            }
        }
        .card-body a {
            text-decoration:underline
        }
        .card-body h4 {
            margin-bottom:0.7rem;
            color:#666
        }
        .card-accordion.accordion-boxed p {
            padding:1.5rem
        }
        .card-accordion.accordion-boxed i {
            margin-right:1rem
        }
        .product-countdown-container {
            display:flex;
            position:absolute;
            padding:1rem 0.7rem 0.9rem;
            justify-content:center;
            flex-wrap:wrap;
            left:1rem;
            right:1rem;
            bottom:1rem;
            opacity:0.7;
            letter-spacing:-0.01em;
            visibility:visible;
            text-transform:uppercase;
            font-family:Oswald,sans-serif;
            transition:opacity 0.3s ease;
            background:#0f43b0;
            z-index:6
        }
        .product-countdown-container .product-countdown-title {
            display:inline-block;
            color:#fff;
            font-size:11px;
            font-weight:400;
            margin-bottom:0;
            margin-right:3px
        }
        .product-countdown-container .product-countdown {
            position:relative;
            left:auto;
            right:auto;
            bottom:auto;
            z-index:6;
            line-height:1;
            opacity:1;
            color:#fff
        }
        .product-countdown-container .product-countdown .countdown-amount {
            display:block;
            padding-bottom:2px;
            font-weight:400;
            font-size:1.3rem;
            line-height:1;
            margin-bottom:0;
            text-transform:uppercase
        }
        .product-default:not(.count-down):hover .product-countdown,
        .product-default:not(.count-down):hover .product-countdown-container {
            opacity:0;
            visibility:hidden
        }
        .toolbox {
            flex-wrap:wrap;
            -ms-flex-wrap:wrap;
            justify-content:space-between;
            -ms-flex-pack:justify;
            margin-bottom:1rem;
            font-size:1.2rem;
            line-height:1.5
        }
        .toolbox .select-custom:after {
            right:1.5rem;
            font-size:1.6rem;
            color:#222529
        }
        .toolbox .select-custom .form-control {
            max-width:160px;
            padding-right:2.5rem;
            padding-left:0.8rem;
            font-size:1.3rem;
            padding-top:1px
        }
        .toolbox label {
            margin:1px 1.1rem 0 0;
            color:#777;
            font-size:1.3rem;
            font-weight:400;
            font-family:"Open Sans",sans-serif
        }
        .toolbox .form-control {
            display:inline-block;
            margin-bottom:0;
            padding:0 0.8rem;
            color:#777
        }
        .toolbox .form-control:focus {
            color:#777
        }
        .toolbox select.form-control:not([size]):not([multiple]) {
            height:34px
        }
        .toolbox .toolbox-show .select-custom:after {
            right:1rem
        }
        .toolbox,
        .toolbox-item,
        .toolbox-left,
        .toolbox-right {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-items:center
        }
        .toolbox-item {
            margin-bottom:10px
        }
        .toolbox-item:not(:last-child) {
            margin-right:10px
        }
        .toolbox-item.layout-modes {
            margin-top:-1px
        }
        .toolbox-item.toolbox-sort {
            margin-right:1.5rem
        }
        .toolbox-item .select-custom {
            margin-bottom:0
        }
        .toolbox-pagination {
            border-top:1px solid #efefef;
            padding-top:2.5rem;
            margin-bottom:3.5rem
        }
        .pagination {
            flex-wrap:wrap;
            -ms-flex-wrap:wrap;
            color:#706f6c;
            font-size:1.4rem;
            font-weight:600;
            font-family:Poppins,sans-serif
        }
        .page-item:not(:first-child) {
            margin-left:0.5rem
        }
        .page-item.active .page-link {
            color:#706f6c;
            background-color:transparent;
            border-color:#0f43b0
        }
        .page-item.disabled {
            display:none
        }
        .page-link {
            border:1px solid #ccc;
            padding:0 0.5em;
            min-width:2.2em;
            color:inherit;
            line-height:2.1em;
            text-align:center
        }
        .page-link:focus,
        .page-link:hover {
            color:#706f6c;
            background-color:transparent;
            border-color:#0f43b0;
            box-shadow:none
        }
        .page-link i {
            font-size:2rem
        }
        .page-link-btn,
        span.page-link {
            border:0
        }
        .layout-btn {
            display:inline-block;
            width:1.2em;
            color:#000;
            font-size:16px;
            line-height:34px;
            text-align:center
        }
        .layout-btn:not(:last-child) {
            margin-right:4px
        }
        .layout-btn.active {
            color:#0f43b0
        }
        @media (min-width:992px) {
            .toolbox-pagination {
                margin-bottom:0
            }
        }
        @media (max-width:991px) {
            aside .toolbox-item {
                display:block
            }
            aside .toolbox-item:after {
                content:normal
            }
            .toolbox:not(.toolbox-pagination) {
                padding:10px;
                background-color:#f4f4f4;
                margin-bottom:2rem
            }
            .toolbox:not(.toolbox-pagination) .toolbox-item {
                margin-bottom:0
            }
            .toolbox label {
                font-size:11px;
                font-weight:600;
                color:#222529
            }
            .toolbox .select-custom .form-control {
                font-size:11px;
                font-weight:600;
                max-width:140px;
                text-transform:uppercase;
                color:#222529
            }
        }
        @media (max-width:767px) {
            .toolbox label {
                display:none
            }
            .toolbox .select-custom:after {
                padding:0
            }
        }
        @media (max-width:575px) {
            .toolbox .layout-modes {
                display:none
            }
            .toolbox .toolbox-show,
            .toolbox .toolbox-sort {
                margin-right:0
            }
            .toolbox .select-custom .form-control {
                max-width:132px
            }
        }
        .minipopup-area {
            position:fixed;
            right:20px;
            bottom:20px;
            font-size:1.1em;
            text-align:center;
            z-index:20002
        }
        .wishlist-popup {
            position:fixed;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            border-width:4px 0 0;
            font-weight:600;
            line-height:1.5;
            padding:15px 20px;
            width:250px;
            border-radius:0;
            background-color:#fff;
            box-shadow:0 0 5px rgba(0,0,0,0.5);
            opacity:0;
            visibility:hidden;
            transition:opacity 0.35s,visibility 0.35s;
            z-index:100
        }
        .wishlist-popup .wishlist-popup-msg {
            font-weight:600;
            line-height:1.6;
            text-align:center
        }
        .wishlist-popup.active {
            opacity:1;
            visibility:visible;
            z-index:1071
        }
        .login-popup .mfp-content {
            margin-top:2.1rem;
            max-width:872px;
            background-color:#fff
        }
        .login-popup .btn-regist {
            margin-top:3.6rem;
            font-size:1.6rem;
            letter-spacing:-0.025em
        }
        .login-popup .form-footer-right {
            margin-bottom:0.6rem
        }
        .login-popup .form-input {
            height:42px
        }
        .login-popup .title {
            font-size:2.2rem;
            font-weight:700;
            letter-spacing:-0.01em;
            line-height:1.45;
            margin-bottom:0.9rem
        }
        .login-popup form {
            display:block
        }
        .login-popup label {
            color:#777;
            font-family:"Open Sans",sans-serif;
            font-size:1.4rem;
            font-weight:500;
            line-height:1.57;
            margin-bottom:0.6rem
        }
        .login-popup .form-footer {
            margin:1rem 0 2.1rem
        }
        .login-popup .form-footer .custom-control {
            margin:0 0 0 auto;
            font-size:1.3rem;
            padding-left:2.5rem
        }
        .login-popup .forget-password {
            color:#222529;
            font-size:1.4rem;
            font-family:"Open Sans",sans-serif;
            font-weight:600
        }
        .login-popup .btn-block {
            font-size:1.6rem;
            font-weight:700;
            line-height:1.5;
            padding:1.5rem 2.4rem;
            letter-spacing:-0.02em
        }
        .login-popup .form-control {
            padding-left:2.5rem
        }
        .login-popup .form-control:hover {
            outline:none
        }
        .login-popup .custom-control-label {
            margin-top:2px;
            font-size:1.2rem
        }
        .newsletter-popup {
            position:relative;
            max-width:740px;
            margin-right:auto;
            margin-left:auto;
            padding:64px 40px;
            border-radius:0;
            box-shadow:0 0 50px rgba(0,0,0,0.12)
        }
        .mfp-bg {
            background-color:#777777
        }
        button.mfp-close {
            position:absolute;
            top:0;
            right:0;
            overflow:visible;
            opacity:0.65;
            cursor:pointer;
            background:transparent;
            border:0;
            text-indent:-9999px;
            transform:rotateZ(45deg);
            color:#838383
        }
        button.mfp-close:hover {
            opacity:1
        }
        .mfp-image-holder button.mfp-close {
            width:41px;
            color:#fff;
            text-align:left
        }
        button.mfp-close:after {
            content:"";
            position:absolute;
            height:17px;
            top:12px;
            left:20px;
            border-left:1px solid
        }
        button.mfp-close:before {
            content:"";
            position:absolute;
            width:17px;
            top:20px;
            left:12px;
            border-top:1px solid
        }
        .newsletter-popup-content {
            max-width:357px
        }
        .newsletter-popup-content .form-control {
            height:auto;
            padding:7px 12px 9px 22px;
            border-radius:3rem 0 0 3rem;
            font-size:1.36rem;
            line-height:2.4;
            border:none;
            background-color:#f4f4f4
        }
        .newsletter-popup-content .form-control::placeholder {
            position:relative;
            top:2px;
            color:#999
        }
        .newsletter-popup-content .btn {
            margin-left:-1px;
            padding:0 32px 0 25px;
            border-radius:0 3rem 3rem 0;
            font-size:1.28rem;
            font-family:"Open Sans",sans-serif;
            letter-spacing:0;
            text-align:center;
            text-transform:uppercase
        }
        .logo-newsletter {
            display:inline-block;
            max-width:111px;
            height:auto
        }
        .newsletter-popup h2 {
            margin:24px 0 5px;
            color:#313131;
            font-size:1.8rem;
            font-weight:700;
            text-transform:uppercase
        }
        .newsletter-popup p {
            font-size:1.4rem;
            line-height:1.85;
            letter-spacing:-0.02em;
            margin-bottom:2.4rem
        }
        .newsletter-popup form {
            margin:0 0 2.7rem
        }
        .newsletter-popup .custom-control {
            margin:0 0 4px 1px;
            padding-left:2.5rem
        }
        .newsletter-subscribe {
            font-size:1.1rem;
            text-align:left
        }
        .newsletter-subscribe .checkbox {
            margin:1.5rem 0
        }
        .newsletter-subscribe input {
            margin-right:0.5rem;
            vertical-align:middle
        }
        .newsletter-subscribe label {
            margin-top:0.2rem;
            color:inherit;
            font-size:1.2rem;
            font-weight:400;
            font-family:"Open Sans",sans-serif;
            text-transform:none
        }
        .mfp-newsletter.mfp-removing {
            transition:opacity 0.35s ease-out;
            opacity:0
        }
        .mfp-ready .mfp-preloader {
            display:none
        }
        .mfp-zoom-out-cur .mfp-bg {
            opacity:0.8;
            background-color:#0b0b0b
        }
        .mfp-zoom-out-cur .mfp-counter {
            color:#fff
        }
        .mfp-zoom-out-cur .mfp-arrow-right:before {
            border-left:0
        }
        .mfp-zoom-out-cur .mfp-arrow-left:before {
            border-right:0
        }
        .login-popup.mfp-bg,
        .mfp-ajax-product.mfp-bg {
            opacity:0.6;
            background-color:transparent
        }
        .mfp-ajax-product .product-single-container {
            box-shadow:0 10px 25px rgba(0,0,0,0.5)
        }
        .mfp-wrap .mfp-content {
            transition:all 0.35s ease-out;
            opacity:0
        }
        .login-popup.mfp-wrap .mfp-content {
            max-width:525px
        }
        .mfp-ajax-product.mfp-wrap .mfp-content {
            max-width:931px
        }
        .mfp-wrap.mfp-ready .mfp-content {
            opacity:1
        }
        .mfp-wrap.mfp-removing .mfp-content {
            opacity:0
        }
        .mfp-ajax-product {
            z-index:1058
        }
        .mfp-bg.login-popup,
        .mfp-bg.mfp-newsletter,
        .mfp-wrap.login-popup,
        .mfp-wrap.mfp-newsletter {
            z-index:1058
        }

        @media (min-width:768px) {
            .login-popup .col-md-6 {
                padding:0 2rem
            }
            .login-popup .col-md-6:first-child {
                border-right:1px solid #f5f6f6
            }
        }
        .product-intro.owl-carousel.owl-theme .owl-nav.disabled+.owl-dots {
            margin:0
        }
        .product-intro.owl-carousel.owl-theme .owl-dots {
            top:-58px;
            position:absolute;
            right:0
        }
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot span {
            position:relative;
            display:block;
            width:14px;
            height:14px;
            border:2px solid;
            background:none;
            margin:5px 2px;
            border-radius:7px;
            border-color:rgba(0,68,102,0.4);
            transition:opacity 0.2s
        }
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span {
            background:none;
            border-color:#0f43b0
        }
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span:before,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span:before {
            display:none
        }
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span:after,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span:after {
            content:"";
            position:absolute;
            left:3px;
            bottom:3px;
            right:3px;
            top:3px;
            border-radius:10px;
            background-color:#0f43b0
        }
        .product-intro.owl-carousel.owl-theme .owl-nav {
            color:#333;
            font-size:2.4rem
        }
        .product-intro.owl-carousel.owl-theme .owl-nav .owl-next,
        .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
            opacity:0;
            transition:opacity 0.2s,transform 0.4s;
            top:30%;
            width:30px
        }
        .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
            text-align:left;
            left:-30px;
            padding-right:30px;
            transform:translateX(-10px)
        }
        .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
            text-align:right;
            right:-30px;
            padding-left:30px;
            transform:translateX(10px)
        }
        .product-intro.owl-carousel.owl-theme:hover .owl-next,
        .product-intro.owl-carousel.owl-theme:hover .owl-prev {
            transform:translateX(0);
            opacity:1
        }
        .product-panel {
            margin-bottom:3.5rem
        }
        .product-panel .section-title {
            color:#313131;
            padding-bottom:1rem;
            border-bottom:1px solid rgba(0,0,0,0.08);
            margin-bottom:2.4rem
        }
        .product-panel .section-title h2 {
            font-weight:700;
            font-size:1.6rem;
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.01em;
            line-height:22px;
            text-transform:uppercase
        }
        .tooltiptext {
            visibility:hidden;
            position:absolute;
            background-color:#333;
            color:#fff;
            font-family:"Open Sans",sans-serif;
            font-weight:400;
            letter-spacing:0.01em;
            text-align:center;
            padding:1rem 0.7rem;
            z-index:1;
            opacity:0;
            transition:opacity 0.3s;
            bottom:125%;
            left:50%;
            transform:translateX(-50%)
        }
        figure .porto-loading-icon {
            position:absolute
        }
        .product-default {
            color:#777;
            margin-bottom:2rem;
            transition:box-shadow 0.3s ease-in-out
        }
        .product-default a {
            color:inherit;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis
        }
        .product-default a:hover {
            color:#0f43b0;
            text-decoration:none
        }
        .product-default figure {
            display:flex;
            justify-content:center;
            align-items:center;
            position:relative;
            margin-bottom:1.6rem
        }
        .product-default figure>a:first-child {
            width:100%;
            height:100%
        }
        .product-default figure img {
            transition:opacity 0.3s ease-in-out;
            height:auto;
            width:100%
        }
        .product-default figure img:last-child {
            opacity:0;
            position:absolute;
            left:0;
            right:0;
            top:0;
            left:0
        }
        .product-default figure img:first-child {
            opacity:1;
            position:relative
        }
        .product-default .label-group {
            position:absolute;
            top:0.8rem;
            left:0.8rem
        }
        .product-default .product-label {
            display:block;
            text-align:center;
            margin-bottom:5px;
            text-transform:uppercase;
            padding:5px 11px;
            color:#fff;
            font-weight:600;
            font-size:10px;
            line-height:1;
            border-radius:12px
        }
        .product-default .product-label.label-hot {
            background-color:#2ba968
        }
        .product-default .product-label.label-sale {
            background-color:#da5555
        }
        .product-default .product-label.label-number {
            display:flex;
            position:relative;
            padding:0;
            margin-left:auto;
            margin-right:auto;
            align-items:center;
            justify-content:center;
            width:32px;
            height:32px;
            border-radius:50%;
            font-size:1.6rem;
            background-color:#0f43b0;
            color:#fff
        }
        .product-default .product-label.label-number span {
            margin-left:1px
        }
        .product-default .product-details {
            display:flex;
            display:-ms-flexbox;
            padding:0 0.8rem;
            flex-direction:column;
            -ms-flex-direction:column;
            align-items:center;
            -ms-flex-align:center;
            justify-content:center;
            -ms-flex-pack:center
        }
        .product-default .category-wrap {
            width:100%;
            white-space:nowrap
        }
        .product-default .category-list {
            text-align:center;
            font-weight:400;
            font-size:1rem;
            font-family:"Open Sans",sans-serif;
            line-height:1.7;
            opacity:0.8;
            text-transform:uppercase;
            text-overflow:ellipsis;
            overflow:hidden
        }
        .product-default .product-title {
            max-width:100%;
            font-weight:400;
            font-size:1.5rem;
            font-family:Poppins,sans-serif;
            line-height:1.35;
            letter-spacing:0.005em;
            margin-bottom:0.4rem
        }
        .product-default .product-title a {
            display:block
        }
        .product-default .title-wrap .product-title {
            text-overflow:ellipsis;
            overflow:hidden;
            width:calc(100% - 20px);
            margin-bottom:0.5rem
        }
        .product-default .title-wrap .btn-icon-wish {
            margin-top:-2px
        }
        .product-default .product-action {
            position:relative;
            margin-bottom:1.5rem;
            color:#333;
            text-align:center
        }
        .product-default .btn-add-cart,
        .product-default .btn-icon-wish,
        .product-default .btn-quickview {
            border:1px solid #f4f4f4;
            background:#f4f4f4;
            color:#6f6e6b;
            line-height:34px
        }
        .product-default .btn-icon-wish,
        .product-default .btn-quickview {
            display:inline-block;
            position:absolute;
            top:0;
            margin:0 2px;
            width:36px;
            height:36px;
            font-size:1.6rem;
            text-align:center;
            opacity:0;
            transition:all 0.25s ease
        }
        .product-default .btn-icon-wish.checked,
        .product-default .btn-quickview.checked {
            color:#e27c7c
        }
        .product-default .btn-icon-wish.checked i:before,
        .product-default .btn-quickview.checked i:before {
            content:""
        }
        .product-default .btn-icon-wish:hover,
        .product-default .btn-quickview:hover {
            color:#333
        }
        .product-default .btn-icon-wish {
            left:0
        }
        .product-default .btn-icon-wish.added-wishlist i:before {
            content:"";
            color:#da5555
        }
        .product-default .btn-quickview {
            font-size:1.4rem;
            right:0
        }
        .product-default:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
            display:none
        }
        .product-default .btn-add-cart {
            display:inline-block;
            padding:0 1.4rem;
            font-size:1.2rem;
            font-weight:600;
            font-family:Poppins,sans-serif;
            text-align:center;
            vertical-align:top;
            cursor:pointer;
            transition:all 0.25s ease
        }
        .product-default .btn-add-cart i {
            font-size:1.5rem;
            line-height:32px
        }
        .product-default .btn-add-cart i:before {
            margin:0 4px 0 0;
            font-weight:800
        }

        .product-default .addToCartBtn {
            display:inline-block;
            padding:0 1.4rem;
            font-size:1.2rem;
            font-weight:600;
            font-family:Poppins,sans-serif;
            text-align:center;
            vertical-align:top;
            cursor:pointer;
            transition:all 0.25s ease
        }
        .product-default .addToCartBtn i {
            font-size:1.5rem;
            line-height:32px
        }
        .product-default .addToCartBtn i:before {
            margin:0 4px 0 0;
            font-weight:800
        }
        .product-default.product-unfold .btn-add-cart i {
            display:inline-block
        }
        .product-default.product-unfold .btn-icon-wish,
        .product-default.product-unfold .btn-quickview {
            position:relative
        }
        .product-default.product-unfold:hover .product-action a.btn-quickview {
            right:0
        }
        .product-default.product-unfold:hover .product-action a.btn-icon-wish {
            left:0
        }
        .product-default:hover {
            z-index:1;
            box-shadow:0 12px 20px 0 rgba(0,0,0,0.08);
            transition:box-shadow 0.3s ease-in-out;
        }
        .product-default:hover figure img:first-child {
            opacity:0;
            transition:opacity 0.3s ease-in-out
        }
        .product-default:hover figure img:last-child {
            opacity:1;
            transition:opacity 0.3s ease-in-out
        }
        .product-default:hover .btn-add-cart {
            background:#2b2b2d;
            border-color:#2b2b2d;
            color:#fff
        }
        .product-default:hover .btn-add-cart.product-type-simple i {
            display:inline-block
        }
        .product-default:hover .product-action a {
            opacity:1
        }
        .product-default:hover .product-action a.btn-icon-wish {
            left:-40px
        }
        .product-default:hover .product-action a.btn-quickview {
            right:-40px
        }
        .tooltip-top:after {
            content:"";
            position:absolute;
            top:96%;
            left:50%;
            margin-left:-6px;
            border-width:6px;
            border-style:solid;
            border-color:#333 transparent transparent transparent
        }
        .old-price {
            text-decoration:line-through;
            font-size:1.4rem;
            letter-spacing:0.005em;
            color:#999;
            margin-right:3px
        }
        .product-price {
            color:#222529;
            font-size:1.8rem;
            line-height:1
        }
        .price-box {
            margin-bottom:1.4rem;
            font-weight:600;
            font-family:"Open Sans",sans-serif;
            line-height:1
        }
        .ratings-container {
            line-height:1;
            margin:0 0 12px 1px;
            cursor:pointer;
            position:relative;
            display:inline-block
        }
        .ratings-container .product-ratings,
        .ratings-container .ratings {
            position:relative;
            display:inline-block;
            font-size:11px;
            letter-spacing:0.1em;
            font-family:"Font Awesome 5 Free";
            font-weight:900
        }
        .ratings-container .product-ratings {
            height:11px
        }
        .ratings-container .product-ratings:before {
            content:"";
            color:rgba(0,0,0,0.16)
        }
        .ratings-container .product-ratings:hover .tooltiptext {
            visibility:visible;
            opacity:1
        }
        .ratings-container .ratings {
            position:absolute;
            top:0;
            left:0;
            white-space:nowrap;
            overflow:hidden
        }
        .ratings-container .ratings:before {
            content:"";
            color:#6a6a6d
        }
        .product-select-group {
            display:flex;
            display:-ms-flexbox
        }
        .product-select {
            margin:0 4px 0 0;
            cursor:pointer
        }
        .product-select.type-image {
            width:32px;
            height:32px;
            background-size:contain;
            border:1px solid rgba(0,0,0,0.09)
        }
        .product-select.type-image.checked,
        .product-select.type-image.hover {
            border:1px solid #0f43b0
        }
        .product-select.type-check {
            margin:5px;
            overflow:visible;
            display:block;
            position:relative;
            width:12px;
            height:12px;
            border-radius:50%
        }
        .product-select.type-check:after {
            content:"";
            background-color:transparent;
            border:1px solid black;
            position:absolute;
            left:-3px;
            top:-3px;
            border-radius:50%;
            width:18px;
            display:block;
            height:18px
        }
        .product-select.type-check.checked:before {
            font-size:8px;
            content:"";
            font-family:"Font Awesome 5 Free";
            font-weight:900;
            -webkit-font-smoothing:antialiased;
            text-indent:0;
            position:absolute;
            left:0;
            top:50%;
            width:100%;
            color:#fff;
            height:12px;
            line-height:12px;
            margin-top:-6px;
            text-align:center
        }
        .product-nav-filter {
            display:flex;
            align-items:center
        }
        .product-nav-thumbs a,
        .product-nav-thumbs span {
            margin-right:0.6rem;
            width:32px;
            height:32px;
            text-indent:-9999px;
            background-repeat:no-repeat;
            background-size:cover;
            background-color:transparent!important;
            border:1px solid #e9e9e9;
            transition:border-color 0.35s
        }
        .product-nav-thumbs a:hover,
        .product-nav-thumbs span:hover {
            border-color:#1d70ba
        }
        .product-nav-dots {
            padding-top:2px
        }
        .product-nav-dots a,
        .product-nav-dots span {
            display:block;
            width:1.6rem;
            height:1.6rem;
            border-radius:50%;
            border:0.2rem solid #fff;
            margin-right:0.6rem;
            transition:box-shadow 0.35s ease;
            box-shadow:0 0 0 0.1rem #999
        }
        .product-nav-dots a.active,
        .product-nav-dots a:hover,
        .product-nav-dots span.active,
        .product-nav-dots span:hover {
            box-shadow:0 0 0 0.1rem #222529
        }
        .product-single-qty {
            display:inline-block;
            max-width:104px;
            vertical-align:middle
        }
        .product-single-qty .bootstrap-touchspin.input-group {
            -ms-flex-wrap:nowrap;
            flex-wrap:nowrap;
            max-width:none;
            padding-right:0
        }
        .product-single-qty .bootstrap-touchspin .form-control {
            width:2.7em;
            height:36px;
            padding:10px 2px;
            color:#222529;
            font-size:1.4rem;
            font-family:Poppins,sans-serif;
            text-align:center
        }
        .product-single-qty .bootstrap-touchspin .form-control,
        .product-single-qty .bootstrap-touchspin .form-control:not(:focus),
        .product-single-qty .btn-outline:not(:disabled):not(.disabled):active {
            border-color:#dae2e6
        }
        .product-single-qty .btn {
            width:2.2em;
            padding:0
        }
        .product-single-qty .btn.btn-down-icon:hover:after,
        .product-single-qty .btn.btn-down-icon:hover:before,
        .product-single-qty .btn.btn-up-icon:hover:after,
        .product-single-qty .btn.btn-up-icon:hover:before {
            background-color:#0f43b0
        }
        .product-single-qty .btn.btn-outline {
            border-color:#e7e7e7
        }
        .product-single-qty .btn.btn-down-icon:after,
        .product-single-qty .btn.btn-up-icon:after,
        .product-single-qty .btn.btn-up-icon:before {
            display:block;
            position:absolute;
            top:50%;
            left:50%;
            width:9px;
            height:1px;
            margin-left:-0.55rem;
            background:#222529;
            content:""
        }
        .product-single-qty .btn.btn-up-icon:before {
            transform:rotate(90deg)
        }
        .product-single-qty .horizontal-quantity::-webkit-inner-spin-button,
        .product-single-qty .horizontal-quantity::-webkit-outer-spin-button {
            -webkit-appearance:none
        }
        .config-swatch-list {
            margin:1.5rem 0 0;
            padding:0;
            font-size:0;
            list-style:none
        }
        .config-swatch-list li a {
            position:relative;
            display:block;
            width:2.8rem;
            height:2.8rem;
            margin:3px 6px 3px 0;
            box-shadow:0 0 3px 0 rgba(0,0,0,0.2)
        }
        .config-swatch-list li .color-panel {
            display:inline-block;
            width:1.7rem;
            height:1.7rem;
            border:1px solid #fff;
            transition:all 0.3s;
            margin-right:1.5rem
        }
        .config-swatch-list li span:last-child {
            cursor:pointer
        }
        .config-swatch-list li:hover span:last-child {
            color:#0f43b0
        }
        .config-swatch-list li.active a:before {
            display:inline-block;
            position:absolute;
            top:50%;
            left:50%;
            transform:translateX(-50%) translateY(-50%);
            color:#fff;
            font-family:"porto";
            font-size:1.1rem;
            line-height:1;
            content:""
        }
        .config-swatch-list a:focus .color-panel,
        .config-swatch-list a:hover .color-panel,
        .config-swatch-list li.active .color-panel {
            box-shadow:0 0 0 0.1rem #dfdfdf
        }
        .modal#addCartModal {
            width:340px;
            top:calc((100% - 320px) / 2);
            left:calc((100% - 320px) / 2);
            padding:10px!important;
            overflow:hidden
        }
        .modal#addCartModal .modal-dialog {
            margin:0
        }
        .modal#addCartModal .modal-content {
            margin:0;
            border:none;
            box-shadow:none
        }
        .add-cart-box {
            padding:19px 10px 20px!important;
            border-top:4px solid #0f43b0;
            background-color:#fff;
            box-shadow:0 0 10px rgba(0,0,0,0.6)
        }
        .add-cart-box h4 {
            font-weight:500;
            color:#0f43b0;
            margin-bottom:1.8rem
        }
        .add-cart-box img {
            margin:0 auto 10px;
            width:120px
        }
        .add-cart-box .btn-actions {
            display:flex;
            display:-ms-flexbox;
            justify-content:space-around;
            -ms-flex-pack:distribute
        }
        .add-cart-box .btn-actions .btn-primary {
            width:140px;
            padding:8px 0;
            font:500 16px "Open Sans",sans-serif;
            border:none;
            cursor:pointer
        }
        .add-cart-box .btn-actions .btn-primary:active,
        .add-cart-box .btn-actions .btn-primary:active:focus,
        .add-cart-box .btn-actions .btn-primary:focus {
            outline:none;
            border:none;
            box-shadow:none
        }
        .divide-line>.col-1:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-1:nth-child(12n) {
            border-right:none
        }
        .divide-line>.col-2:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-2:nth-child(6n) {
            border-right:none
        }
        .divide-line>.col-3:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-3:nth-child(4n) {
            border-right:none
        }
        .divide-line>.col-4:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-4:nth-child(3n) {
            border-right:none
        }
        .divide-line>.col-5:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-5:nth-child(2n) {
            border-right:none
        }
        .divide-line>.col-6:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-6:nth-child(2n) {
            border-right:none
        }
        .divide-line>.col-7:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-7:nth-child(1n) {
            border-right:none
        }
        .divide-line>.col-8:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-8:nth-child(1n) {
            border-right:none
        }
        .divide-line>.col-9:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-9:nth-child(1n) {
            border-right:none
        }
        .divide-line>.col-10:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-10:nth-child(1n) {
            border-right:none
        }
        .divide-line>.col-11:nth-child(n) {
            border-right:1px solid rgba(0,0,0,0.09);
            border-bottom:1px solid rgba(0,0,0,0.09)
        }
        .divide-line>.col-11:nth-child(1n) {
            border-right:none
        }
        .divide-line:not(.up-effect) .product-default .btn-quickview {
            width:calc(100% - 30px);
            margin:0 15px
        }
        .divide-line:not(.up-effect) .product-default .product-details {
            padding:0 1.5rem
        }
        .divide-line.up-effect {
            margin-top:-2rem
        }
        .divide-line.up-effect .product-default {
            padding-top:5rem;
            margin:0;
            transition:0.3s
        }
        .divide-line.up-effect .product-default .product-action {
            transition:0.3s;
            opacity:0
        }
        .divide-line.up-effect .product-default:hover {
            padding-top:1rem;
            padding-bottom:4rem
        }
        .divide-line.up-effect .product-default:hover .product-action {
            opacity:1
        }
        .divide-line .product-default {
            margin-bottom:0
        }
        .divide-line .product-default:hover {
            box-shadow:0 25px 35px -5px rgba(0,0,0,0.1)
        }
        .divide-line .product-default:hover figure {
            box-shadow:none
        }
        .inner-quickview figure {
            position:relative
        }
        .inner-quickview figure .btn-quickview {
            position:absolute;
            padding:0.8rem 1.4rem;
            bottom:0;
            left:0;
            width:100%;
            height:auto;
            color:#fff;
            background-color:#0f43b0;
            font-size:1.3rem;
            font-weight:400;
            letter-spacing:0.025em;
            font-family:Poppins,sans-serif;
            text-transform:uppercase;
            visibility:hidden;
            opacity:0;
            transform:none;
            margin:0;
            border:none;
            line-height:1.82;
            transition:padding-top 0.2s,padding-bottom 0.2s;
            z-index:2
        }
        .inner-quickview figure .btn-quickview:hover {
            color:#fff;
            opacity:1
        }
        .inner-quickview .product-details {
            align-items:flex-start;
            -ms-flex-align:start
        }
        .inner-quickview .category-wrap,
        .inner-quickview .title-wrap {
            display:flex;
            display:-ms-flexbox;
            justify-content:space-between;
            -ms-flex-pack:justify;
            align-items:center;
            -ms-flex-align:center;
            width:100%
        }
        .inner-quickview .category-wrap .btn-icon-wish,
        .inner-quickview .title-wrap .btn-icon-wish {
            transform:none;
            opacity:1;
            width:auto;
            height:auto;
            border:none;
            overflow:visible;
            font-size:1.5rem;
            line-height:0
        }
        .inner-quickview .category-list {
            text-align:left
        }
        .inner-quickview .category-wrap .btn-icon-wish {
            font-size:1.6rem;
            padding-top:1px
        }
        .inner-quickview:hover .btn-quickview {
            visibility:visible;
            opacity:0.85
        }
        .inner-icon {
            position:relative;
            margin-bottom:1.9rem
        }
        .inner-icon:not(.product-widget) .product-details {
            padding:0
        }
        .inner-icon .category-list {
            text-align:left;
            text-overflow:ellipsis;
            overflow:hidden;
            width:calc(100% - 20px)
        }
        .inner-icon .product-title {
            font-family:Poppins,sans-serif;
            letter-spacing:-0.01em
        }
        .inner-icon .ratings-container {
            margin-left:0
        }
        .inner-icon .price-box {
            margin-bottom:1.5rem;
            font-family:"Open Sans",sans-serif
        }
        .inner-icon .btn-icon-group {
            z-index:2
        }
        .inner-icon .btn-icon-wish,
        .inner-icon .btn-quickview {
            top:auto
        }
        .inner-icon .btn-icon-wish {
            left:auto;
            right:0
        }
        .inner-icon:not(.product-widget):hover {
            box-shadow:none
        }
        .inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top:1.2rem;
            padding-bottom:1.3rem;
            transition:padding-top 0.2s,padding-bottom 0.2s,opacity 0.2s
        }
        .inner-icon .btn-add-cart,
        .inner-icon .btn-icon-wish,
        .inner-icon .btn-quickview {
            background-color:transparent
        }
        .inner-icon figure {
            position:relative
        }
        .inner-icon figure .btn-icon-group {
            position:absolute;
            top:1.5rem;
            right:1.5rem
        }
        .inner-icon figure .btn-icon {
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid #ddd;
            border-radius:50%;
            margin:0 0 5px;
            width:36px;
            height:36px;
            padding:0;
            opacity:0;
            visibility:hidden;
            transition:opacity 0.3s,background-color 0.3s,color 0.3s,border-color 0.3s;
            transform:none
        }
        .inner-icon figure .btn-icon i:not(.fa):before {
            font-weight:400
        }
        .inner-icon figure .btn-icon .fa {
            font-size:12px;
            font-weight:600
        }
        .inner-icon figure .btn-icon i {
            font-size:1.6rem;
            margin-bottom:0
        }
        .inner-icon figure .btn-icon i:before {
            margin:0
        }
        .inner-icon figure .btn-icon i.icon-bag {
            font-size:1.8rem
        }
        .inner-icon figure .btn-icon:hover {
            background-color:#0f43b0;
            border-color:#0f43b0;
            color:#fff
        }
        .inner-icon:hover .btn-icon {
            background-color:#fff;
            border-color:#ddd;
            color:black;
            visibility:visible;
            opacity:1;
            overflow:hidden
        }
        .left-details .product-details {
            -ms-flex-align:start;
            align-items:flex-start
        }
        .left-details .btn-add-cart,
        .left-details .btn-icon-wish,
        .left-details .btn-quickview {
            background-color:#f4f4f4;
            border-color:#f4f4f4;
            color:black
        }
        .left-details .btn-icon-wish,
        .left-details .btn-quickview {
            transform:none
        }
        .left-details .btn-add-cart {
            margin-left:0;
            padding:0 1.5rem
        }
        .hidden-description {
            position:relative
        }
        .hidden-description:hover figure {
            box-shadow:none
        }
        .hidden-description:hover .btn-add-cart {
            background-color:#f4f4f4;
            position:absolute
        }
        .hidden-description:hover .product-details {
            opacity:1;
            transform:translateY(0)
        }
        .hidden-description:hover .product-action a.btn-quickview {
            left:0
        }
        .hidden-description figure {
            margin-bottom:0
        }
        .hidden-description figure .btn-icon-group {
            top:1rem;
            right:1rem
        }
        .hidden-description .product-details {
            position:absolute;
            width:100%;
            bottom:46px;
            background-color:#fff;
            border-top:1px solid rgba(0,0,0,0.09);
            opacity:0;
            transform:translateY(5px);
            transition:all 0.3s ease
        }
        .hidden-description.product-default .product-details {
            padding:1rem
        }
        .hidden-description .product-action {
            position:absolute;
            left:0;
            bottom:0;
            width:100%;
            margin-bottom:0
        }
        .hidden-description .btn-quickview {
            transform:none;
            background-color:#0f43b0;
            color:#fff;
            width:50%;
            margin:0;
            border:none;
            height:45px;
            left:0;
            font-size:1.3rem;
            font-weight:400;
            letter-spacing:0.025em;
            font-family:Poppins,sans-serif;
            text-transform:uppercase;
            line-height:45px
        }
        .hidden-description:hover .product-action .btn-quickview {
            opacity:0.85
        }
        .hidden-description:hover .product-action .btn-quickview:hover {
            opacity:1;
            color:#fff
        }
        .hidden-description .btn-add-cart {
            position:absolute;
            z-index:3;
            justify-content:center;
            margin:0;
            width:50%;
            height:45px;
            border:none;
            background:#f4f4f4;
            font-size:1.3rem;
            font-weight:400;
            letter-spacing:0.025em;
            font-family:Poppins,sans-serif;
            text-transform:uppercase;
            line-height:45px
        }
        .hidden-description .btn-add-cart:hover {
            background-color:#f46017;
            color:#fff
        }
        .full-width {
            padding-left:10px;
            padding-right:10px;
            margin:0;
            display:flex;
            flex-wrap:wrap
        }
        .full-width [class*=col-] {
            padding-right:10px;
            padding-left:10px
        }
        .no-gaps {
            display:flex;
            flex-wrap:wrap;
            padding-left:0;
            padding-right:0
        }
        .no-gaps [class*=col-] {
            padding-right:0;
            padding-left:0
        }
        .no-gaps .product-details {
            padding:0 1rem
        }
        .no-gaps .product-default {
            margin-bottom:0
        }
        .no-gaps .product-default:nth-child(2n) figure>a:first-child:after {
            content:"";
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            background:rgba(33,37,41,0.01)
        }
        .inner-icon-inline figure .btn-icon-group {
            display:flex;
            flex-direction:row
        }
        .inner-icon-inline figure .btn-icon {
            margin-left:5px
        }
        .product-overlay figure {
            margin:0
        }
        .product-overlay figure>a:first-child:after {
            content:"";
            position:absolute;
            width:100%;
            height:100%;
            left:0;
            top:0;
            background-color:rgba(27,27,23,0);
            transition:all 0.25s
        }
        .product-overlay figure .btn-icon-group,
        .product-overlay figure .btn-quickview {
            z-index:1
        }
        .product-overlay figure .btn-icon {
            border-color:#fff;
            border-width:2px;
            color:#fff;
            background-color:#4d4d4a;
            opacity:0
        }
        .product-overlay figure .btn-icon-wish {
            position:relative
        }
        .product-overlay figure .btn-add-cart i {
            display:inline-block
        }
        .product-overlay .product-details {
            align-items:center;
            position:absolute;
            width:100%;
            left:0;
            top:0;
            bottom:0;
            opacity:0;
            transform:scale(0.8);
            transition:all 0.4s
        }
        .product-overlay .product-details .product-category,
        .product-overlay .product-details .product-price,
        .product-overlay .product-details .product-title a {
            color:#fff
        }
        .product-overlay .product-details a:hover {
            color:#0f43b0
        }
        .product-overlay .product-details .ratings-container .product-ratings:before {
            color:rgba(255,255,255,0.6)
        }
        .product-overlay .product-details .ratings-container .ratings:before {
            color:#fff
        }
        .product-overlay .product-details .price-box {
            margin-bottom:0
        }
        .product-overlay .product-details .category-list {
            text-align:center;
            width:100%
        }
        .product-overlay:hover figure,
        .product-overlay:nth-child(2n):hover figure {
            box-shadow:none
        }
        .product-overlay:hover figure>a:first-child:after,
        .product-overlay:nth-child(2n):hover figure>a:first-child:after {
            background-color:rgba(27,27,23,0.6)
        }
        .product-overlay:hover figure .btn-icon,
        .product-overlay:hover figure .btn-quickview,
        .product-overlay:nth-child(2n):hover figure .btn-icon,
        .product-overlay:nth-child(2n):hover figure .btn-quickview {
            opacity:0.85;
            visibility:visible
        }
        .product-overlay:hover figure .btn-icon:hover,
        .product-overlay:hover figure .btn-quickview:hover,
        .product-overlay:nth-child(2n):hover figure .btn-icon:hover,
        .product-overlay:nth-child(2n):hover figure .btn-quickview:hover {
            opacity:1
        }
        .product-overlay:hover figure .btn-icon,
        .product-overlay:nth-child(2n):hover figure .btn-icon {
            border-color:#fff;
            border-width:2px;
            color:#fff;
            background-color:#4d4d4a;
            opacity:0.85
        }
        .product-overlay:hover .product-details,
        .product-overlay:nth-child(2n):hover .product-details {
            opacity:1;
            transform:scale(1)
        }
        .overlay-dark figure {
            margin:0
        }
        .overlay-dark figure>a:first-child:after {
            content:"";
            position:absolute;
            width:100%;
            height:100%;
            left:0;
            top:0;
            background-color:rgba(27,27,23,0.3);
            transition:all 0.25s
        }
        .overlay-dark figure .btn-icon-group,
        .overlay-dark figure .btn-quickview {
            z-index:1
        }
        .overlay-dark figure .btn-icon {
            border-color:#fff;
            border-width:2px;
            color:#fff;
            background-color:#4d4d4a;
            opacity:0;
            margin-left:8px
        }
        .overlay-dark figure .btn-quickview {
            border:2px solid #fff;
            background-color:#4d4d4a;
            border-radius:2rem;
            padding:1rem 2.3rem;
            width:auto;
            height:auto;
            left:50%;
            bottom:50%;
            transform:translate(-50%,50%);
            opacity:0;
            transition:all 0.1s
        }
        .overlay-dark .product-details {
            position:absolute;
            width:100%;
            left:2rem;
            bottom:4rem;
            opacity:0;
            transform:translateY(10px);
            transition:all 0.4s
        }
        .overlay-dark .product-details .product-category,
        .overlay-dark .product-details .product-price,
        .overlay-dark .product-details .product-title a {
            color:#fff
        }
        .overlay-dark .product-details a:hover {
            color:#0f43b0
        }
        .overlay-dark .product-details .ratings-container .product-ratings:before {
            color:rgba(255,255,255,0.6)
        }
        .overlay-dark .product-details .price-box {
            margin-bottom:0
        }
        .overlay-dark:hover figure,
        .overlay-dark:nth-child(2n):hover figure {
            box-shadow:none
        }
        .overlay-dark:hover figure>a:first-child:after,
        .overlay-dark:nth-child(2n):hover figure>a:first-child:after {
            background-color:rgba(27,27,23,0.7)
        }
        .overlay-dark:hover figure .btn-icon,
        .overlay-dark:hover figure .btn-quickview,
        .overlay-dark:nth-child(2n):hover figure .btn-icon,
        .overlay-dark:nth-child(2n):hover figure .btn-quickview {
            opacity:0.85
        }
        .overlay-dark:hover figure .btn-icon:hover,
        .overlay-dark:hover figure .btn-quickview:hover,
        .overlay-dark:nth-child(2n):hover figure .btn-icon:hover,
        .overlay-dark:nth-child(2n):hover figure .btn-quickview:hover {
            background-color:#4d4d4a;
            opacity:1
        }
        .overlay-dark:hover figure .btn-icon,
        .overlay-dark:nth-child(2n):hover figure .btn-icon {
            border-color:#fff;
            border-width:2px;
            color:#fff;
            background-color:#4d4d4a;
            opacity:0.85
        }
        .overlay-dark:hover .product-details,
        .overlay-dark:nth-child(2n):hover .product-details {
            opacity:1;
            transform:translateY(0)
        }
        .creative-grid {
            margin-left:-10px;
            margin-right:-10px
        }
        .creative-grid .product-default {
            padding:0 10px 20px;
            margin-bottom:0
        }
        .creative-grid .product-default .btn-add-cart i {
            display:inline-block
        }
        .creative-grid figure {
            height:100%
        }
        .creative-grid figure img {
            height:100%;
            object-fit:cover
        }
        .creative-grid .overlay-dark figure .btn-quickview {
            padding:8px 15px;
            max-width:128px;
            max-height:41px;
            border-radius:5rem
        }
        .creative-grid .inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top:7px
        }
        .creative-grid .grid-height-1-2 {
            height:300px
        }
        .creative-grid .grid-height-1 {
            height:600px
        }
        .creative-grid .grid-col-sizer {
            width:25%
        }
        .creative-grid .btn-icon-wish {
            position:relative
        }
        .inner-btn figure .btn-icon-group {
            top:auto;
            left:auto;
            right:1.5rem;
            bottom:1.5rem
        }
        .inner-btn figure .btn-icon {
            position:relative;
            margin-bottom:0
        }
        .inner-btn figure .btn-quickview {
            background-color:#fff
        }
        .inner-btn figure .btn-quickview i {
            font-size:1.4rem
        }
        .inner-btn figure .btn-add-cart i {
            display:inline-block
        }
        .quantity-input .product-details {
            align-items:center
        }
        .quantity-input .product-single-qty {
            margin:0 0 1rem
        }
        .quantity-input .btn-add-cart {
            margin:0 0 1rem 2px
        }
        .quantity-input .btn-add-cart:hover {
            background-color:#0f43b0;
            border-color:#0f43b0;
            color:#fff
        }
        .quantity-input .category-list {
            text-align:center
        }
        .product-list {
            display:flex;
            display:-ms-flexbox;
            align-items:center
        }
        .product-list:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
            display:block
        }
        .product-list .product-action {
            margin-bottom:0
        }
        .product-list:hover .btn-icon {
            padding-right:0.8rem;
            transition:0.35s
        }
        .product-list:hover .btn-icon i {
            opacity:1;
            transition:0.35s
        }
        .product-list:hover .btn-icon span {
            padding-left:1.3rem;
            transition:0.35s
        }
        .product-list figure {
            max-width:250px;
            margin-right:1.2rem;
            margin-bottom:0
        }
        .product-list figure img {
            object-fit:cover;
            height:100%
        }
        .product-list .product-details {
            padding-top:3px;
            max-width:calc(100% - 270px)
        }
        .product-list .product-title {
            margin-bottom:0.6rem;
            font-weight:600;
            font-size:1.8rem;
            font-family:"Open Sans",sans-serif
        }
        .product-list .ratings-container {
            margin:0 0 10px 0px
        }
        .product-list .product-description {
            display:-webkit-box;
            margin-bottom:1.6rem;
            max-width:100%;
            font-weight:400;
            font-size:1.4rem;
            font-family:"Open Sans",sans-serif;
            line-height:24px;
            overflow:hidden;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical
        }
        .product-list .price-box {
            margin-bottom:1.6rem
        }
        .product-list .category-list {
            margin-bottom:-1px
        }
        .product-list .btn-add-cart {
            margin:0 3px 5px 0;
            padding:0 1.4rem;
            background-color:#0f43b0;
            border-color:#0f43b0;
            color:#fff
        }
        .product-list .btn-icon {
            position:relative;
            transition:0.35s
        }
        .product-list .btn-icon i {
            position:absolute;
            display:inline-block;
            opacity:0;
            left:8px;
            transition:0.35s
        }
        .product-list .btn-icon i:before {
            margin:0;
            line-height:1;
            font-weight:800
        }
        .product-list .btn-icon i.fa {
            top:26%
        }
        .product-list .btn-icon span {
            display:inline-block;
            transition:0.35s
        }
        .product-list .btn-icon-wish,
        .product-list .btn-quickview {
            position:static;
            opacity:1;
            background-color:#f4f4f4;
            border:1px solid #f4f4f4;
            color:#333333;
            margin:0 0 5px;
            line-height:32px
        }
        .product-list .btn-icon-wish {
            position:relative
        }
        .product-list:hover {
            box-shadow:none
        }
        .product-list:hover figure {
            box-shadow:none
        }
        .product-list:hover .product-action a.btn-icon-wish {
            left:0
        }
        .product-widget {
            display:flex;
            display:-ms-flexbox;
            margin-bottom:1.6rem
        }
        .product-widget figure {
            max-width:84px;
            margin-right:1rem;
            margin-bottom:0
        }
        .product-widget figure img {
            object-fit:cover;
            height:100%
        }
        .product-widget .ratings-container {
            margin-bottom:1rem
        }
        .product-widget .product-details {
            margin-bottom:2px;
            max-width:calc(100% - 104px)
        }
        .product-widget .product-title {
            margin-bottom:0.5rem;
            font-size:1.4rem
        }
        .product-widget .price-box {
            margin-bottom:0
        }
        .product-widget .product-price {
            font-size:1.5rem
        }
        .product-widget .old-price {
            font-size:1.2rem
        }
        .product-widget:hover,
        .product-widget:hover figure {
            box-shadow:none
        }
        .row-joined.product-nogap .product-details {
            padding:0 1rem
        }
        .row-joined.product-nogap .product-details .category-wrap {
            position:relative
        }
        .product-quick-view {
            padding:3rem;
            background-color:#fff
        }
        .product-quick-view .product-single-filter label {
            margin-right:0
        }
        .product-quick-view .product-single-details .product-title {
            width:100%
        }
        .product-quick-view .view-cart {
            padding:13px 10px;
            font-size:0.8em;
            font-weight:700;
            text-transform:uppercase;
            text-decoration:underline
        }
        .product-quick-view .product-single-details .product-single-filter:last-child {
            margin-left:-1px
        }
        .image-bg-white {
            filter:brightness(1.08)
        }
        .post-slider>.owl-stage-outer,
        .products-slider>.owl-stage-outer {
            margin:-10px -20px;
            padding:10px 20px
        }
        @media (max-width:1280px) {
            .post-slider>.owl-stage-outer,
            .products-slider>.owl-stage-outer {
                margin:-10px -15px;
                padding:10px 15px
            }
        }
        .modal-backdrop.show {
            opacity:0
        }
        @media (max-width:1200px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left:10px
            }
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right:10px
            }
        }
        @media (max-width:1159px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left:-30px
            }
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right:-30px
            }
        }
        @media (max-width:1000px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left:10px
            }
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right:10px
            }
        }
        @media (min-width:576px) {
            .divide-line>.col-sm-1:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-1:nth-child(12n) {
                border-right:none
            }
            .divide-line>.col-sm-2:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-2:nth-child(6n) {
                border-right:none
            }
            .divide-line>.col-sm-3:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-3:nth-child(4n) {
                border-right:none
            }
            .divide-line>.col-sm-4:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-4:nth-child(3n) {
                border-right:none
            }
            .divide-line>.col-sm-5:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-5:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-sm-6:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-6:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-sm-7:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-7:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-sm-8:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-8:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-sm-9:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-9:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-sm-10:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-10:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-sm-11:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-sm-11:nth-child(1n) {
                border-right:none
            }
        }
        @media (min-width:768px) {
            .divide-line>.col-md-1:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-1:nth-child(12n) {
                border-right:none
            }
            .divide-line>.col-md-2:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-2:nth-child(6n) {
                border-right:none
            }
            .divide-line>.col-md-3:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-3:nth-child(4n) {
                border-right:none
            }
            .divide-line>.col-md-4:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-4:nth-child(3n) {
                border-right:none
            }
            .divide-line>.col-md-5:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-5:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-md-6:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-6:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-md-7:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-7:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-md-8:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-8:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-md-9:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-9:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-md-10:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-10:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-md-11:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-md-11:nth-child(1n) {
                border-right:none
            }
            .product-quick-view .product-single-details {
                position:absolute;
                right:0;
                height:100%!important;
                overflow-y:auto
            }
            .product-quick-view .product-single-details::-webkit-scrollbar {
                height:10px;
                width:3px
            }
            .product-quick-view .product-single-details::-webkit-scrollbar-thumb {
                background:#ebebeb;
                border-radius:10px;
                position:absolute
            }
            .product-quick-view .product-single-details::-webkit-scrollbar-track {
                background:#fff;
                border-radius:10px;
                margin:8px;
                width:100%
            }
        }
        @media (min-width:992px) {
            .divide-line>.col-lg-1:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-1:nth-child(12n) {
                border-right:none
            }
            .divide-line>.col-lg-2:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-2:nth-child(6n) {
                border-right:none
            }
            .divide-line>.col-lg-3:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-3:nth-child(4n) {
                border-right:none
            }
            .divide-line>.col-lg-4:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-4:nth-child(3n) {
                border-right:none
            }
            .divide-line>.col-lg-5:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-5:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-lg-6:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-6:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-lg-7:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-7:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-lg-8:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-8:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-lg-9:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-9:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-lg-10:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-10:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-lg-11:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-lg-11:nth-child(1n) {
                border-right:none
            }
        }
        @media (min-width:1200px) {
            .divide-line>.col-xl-1:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-1:nth-child(12n) {
                border-right:none
            }
            .divide-line>.col-xl-2:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-2:nth-child(6n) {
                border-right:none
            }
            .divide-line>.col-xl-3:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-3:nth-child(4n) {
                border-right:none
            }
            .divide-line>.col-xl-4:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-4:nth-child(3n) {
                border-right:none
            }
            .divide-line>.col-xl-5:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-5:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-xl-6:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-6:nth-child(2n) {
                border-right:none
            }
            .divide-line>.col-xl-7:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-7:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-xl-8:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-8:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-xl-9:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-9:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-xl-10:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-10:nth-child(1n) {
                border-right:none
            }
            .divide-line>.col-xl-11:nth-child(n) {
                border-right:1px solid rgba(0,0,0,0.09);
                border-bottom:1px solid rgba(0,0,0,0.09)
            }
            .divide-line>.col-xl-11:nth-child(1n) {
                border-right:none
            }
            .col-xl-7col .product-default .product-title,
            .col-xl-8col .product-default .product-title {
                font-size:1.3rem
            }
            .col-xl-7col .old-price,
            .col-xl-8col .old-price {
                font-size:1.2rem
            }
            .col-xl-7col .product-price,
            .col-xl-8col .product-price {
                font-size:1.5rem
            }
        }
        @media (max-width:575px) {
            .product-list {
                flex-direction:column;
                -ms-flex-direction:column
            }
            .product-list figure {
                max-width:none;
                margin-right:0;
                margin-bottom:2rem
            }
            .product-list .product-details {
                max-width:none;
                width:100%
            }
            .product-list:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
                display:block
            }
            .product-list .product-action>a {
                padding:0;
                width:34px;
                height:34px
            }
            .product-list .product-action>a i {
                display:inline-block
            }
            .product-list .btn-icon {
                margin-right:1px
            }
            .product-list .btn-icon i {
                position:static;
                opacity:1
            }
            .product-list .btn-icon:hover {
                padding:0
            }
            .product-list .btn-icon span {
                display:none
            }
            .product-list .btn-icon:not(.product-type-simple) i {
                margin-top:1.1rem
            }
            .product-quick-view {
                padding:2rem
            }
            .product-quick-view .product-single-details .product-title {
                font-size:2.6rem
            }
        }
        @media (max-width:479px) {
            .product-price {
                font-size:1.3rem
            }
            .product-quick-view {
                padding:2rem
            }
        }
        .product-category-panel {
            margin-bottom:35px
        }
        .product-category-panel .owl-carousel {
            margin-top:-10px;
            padding-top:10px
        }
        .product-category-panel .owl-carousel .owl-nav button.owl-next,
        .product-category-panel .owl-carousel .owl-nav button.owl-prev {
            width:30px;
            font-size:24px;
            color:#333;
            line-height:22px
        }
        .product-category-panel .owl-carousel .owl-nav button.owl-prev {
            left:-41px
        }
        .product-category-panel .owl-carousel .owl-nav button.owl-next {
            right:-41px
        }
        .product-category-panel .section-title {
            padding-bottom:1rem;
            border-bottom:1px solid #dbdbdb;
            margin-bottom:2.5rem
        }
        .product-category-panel .section-title h2 {
            font-weight:700;
            font-size:1.6rem;
            line-height:1.2;
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.05em;
            color:#282d3b;
            text-transform:uppercase
        }
        .product-category {
            color:#1d2127;
            margin-bottom:2rem;
            position:relative
        }
        .product-category a:hover {
            color:inherit
        }
        .product-category img {
            width:100%
        }
        .product-category figure {
            margin-bottom:0;
            position:relative
        }
        .product-category figure:after {
            position:absolute;
            width:100%;
            height:100%;
            left:0;
            top:0;
            background:transparent;
            transition:all 0.3s;
            z-index:1;
            content:""
        }
        .product-category:hover figure:after {
            background-color:rgba(27,27,23,0.15)
        }
        .owl-item>.product-category {
            margin-bottom:0
        }
        .category-content {
            padding:2rem;
            display:flex;
            display:-ms-flex-box;
            flex-direction:column;
            -ms-flex-direction:column;
            align-items:center;
            -ms-flex-align:center
        }
        .category-content h3 {
            font-weight:700;
            font-size:1.5rem;
            line-height:1.35;
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.005em;
            margin-bottom:1rem;
            text-transform:uppercase
        }
        .category-content span {
            font-weight:400;
            font-size:10.2px;
            line-height:1.8;
            font-family:"Open Sans",sans-serif;
            letter-spacing:normal;
            margin-top:-10px;
            text-transform:uppercase;
            opacity:0.7;
            color:#1d2127
        }
        .category-content span mark {
            padding:0;
            background-color:transparent;
            color:inherit
        }
        .content-center-bottom .category-content,
        .content-center .category-content,
        .content-left-bottom .category-content,
        .content-left-center .category-content {
            padding:20.4px 25.5px;
            position:absolute;
            width:100%;
            transform:translateY(-50%);
            z-index:2
        }
        .content-center-bottom .category-content h3,
        .content-center-bottom .category-content span,
        .content-center .category-content h3,
        .content-center .category-content span,
        .content-left-bottom .category-content h3,
        .content-left-bottom .category-content span,
        .content-left-center .category-content h3,
        .content-left-center .category-content span {
            color:#fff
        }
        .content-center .category-content,
        .content-left-center .category-content {
            left:0;
            top:50%
        }
        .content-left-center .category-content {
            align-items:flex-start
        }
        .content-left-bottom .category-content {
            align-items:flex-start;
            left:0;
            bottom:0;
            transform:none
        }
        .content-center-bottom figure {
            min-height:90px
        }
        .content-center-bottom .category-content {
            bottom:0;
            transform:none;
            padding:20.4px 0
        }
        .content-center-bottom .category-content h3,
        .content-center-bottom .category-content span {
            margin-bottom:0;
            color:#1d2127
        }
        .overlay-lighter figure:after {
            background-color:rgba(27,27,23,0)
        }
        .overlay-lighter:hover figure:after {
            background-color:rgba(27,27,23,0.15)
        }
        .overlay-darker figure:after {
            background-color:rgba(27,27,23,0.25)
        }
        .overlay-darker:hover figure:after {
            background-color:rgba(27,27,23,0.4)
        }
        .overlay-light figure:after {
            background-color:rgba(27,27,23,0.75)
        }
        .overlay-light:hover figure:after {
            background-color:rgba(27,27,23,0.6)
        }
        .hidden-count .category-content span {
            max-height:10px;
            transition:all 0.5s;
            transform:translateY(20%);
            opacity:0
        }
        .hidden-count:hover .category-content span {
            max-height:30px;
            transform:none;
            opacity:0.7
        }
        .creative-grid .product-category {
            margin-bottom:0;
            padding-bottom:2rem
        }
        .creative-grid .product-category.content-left-bottom .category-content {
            margin-bottom:20px
        }
        .creative-grid .product-category figure {
            height:100%
        }
        .creative-grid .product-category figure img {
            width:100%;
            height:100%;
            object-fit:cover;
            padding:0
        }
        .height-600 {
            height:600px
        }
        .height-400 {
            height:400px
        }
        .height-300 {
            height:300px
        }
        .height-200 {
            height:200px
        }
        @media (min-width:1199px) {
            .col-5col-1 {
                flex:0 0 20%;
                max-width:20%
            }
        }
        @media (max-width:767px) {
            .height-600 {
                height:400px
            }
            .height-300 {
                height:200px
            }
        }
        @media (max-width:450px) {
            .content-center-bottom .category-content {
                padding:16.8px 21px;
                text-align:center;
                flex-wrap:wrap
            }
        }
        @media (max-width:400px) {
            .content-center-bottom .category-content {
                padding-bottom:1rem
            }
        }
        @media (max-width:1200px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width:15px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right:-18px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left:-18px
            }
        }
        @media (max-width:1159px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width:30px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right:-41px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left:-41px
            }
        }
        @media (max-width:1024px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width:15px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right:-18px
            }
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left:-18px
            }
        }
        .testimonial-owner {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-content:center
        }
        .testimonial-owner figure {
            max-width:40px;
            margin-right:25px;
            margin-bottom:2rem
        }
        .testimonial-owner figure.max-width-none {
            max-width:none;
            margin:0
        }
        .testimonial-owner h4 {
            display:block;
            margin-bottom:0.5rem;
            padding-top:0.7rem;
            color:#111;
            font-size:1.4rem;
            text-transform:uppercase
        }
        .testimonial-owner span {
            display:block;
            color:#666;
            font-size:1.2rem;
            text-transform:uppercase;
            letter-spacing:0.045em;
            line-height:1.2;
            font-weight:600
        }
        .testimonial blockquote {
            position:relative;
            margin:0 0 0 15px;
            padding:1rem 2rem;
            color:#0f43b0
        }
        .testimonial blockquote:after,
        .testimonial blockquote:before {
            position:absolute;
            font-family:"Playfair Display";
            font-size:5rem;
            font-weight:900;
            line-height:1
        }
        .testimonial blockquote:before {
            top:0;
            left:-0.4em;
            content:"“"
        }
        .testimonial blockquote p {
            margin-bottom:0;
            font-family:inherit;
            font-style:normal;
            font-size:14px;
            line-height:24px;
            color:#62615e
        }
        .testimonial.blockquote-both blockquote:after {
            display:block;
            content:"”";
            right:0;
            bottom:-5px;
            line-height:24px
        }
        .testimonial.owner-center>p,
        .testimonial.owner-center blockquote {
            text-align:center
        }
        .testimonial.owner-center .testimonial-title {
            text-align:center
        }
        .testimonial.owner-center .testimonial-owner {
            justify-content:center
        }
        .testimonial.owner-center .testimonial-owner span {
            text-align:center
        }
        .testimonial.owner-center .testimonial-owner figure,
        .testimonial.owner-center .testimonial-owner img {
            margin-left:auto;
            margin-right:auto
        }
        .testimonial.testimonial-border {
            border:1px solid;
            border-top-color:#dfdfdf;
            border-bottom-color:#dfdfdf;
            border-left-color:#ececec;
            border-right-color:#ececec;
            box-shadow:0 1px 1px 0 rgba(0,0,0,0.04)
        }
        .testimonial.testimonial-border-bottom .testimonial-owner {
            border-top:1px solid #f2f2f2
        }
        .testimonial.inner-blockquote figure {
            margin-top:15px;
            margin-bottom:10px
        }
        .testimonial.inner-blockquote blockquote {
            padding:6px 20px
        }
        .testimonial.inner-blockquote .testimonial-title {
            margin-top:28px
        }
        .testimonial .testimonial-arrow-down {
            border-left:11px solid transparent;
            border-right:11px solid transparent;
            border-top:8px solid #CCC;
            height:0;
            margin:0 0 0 40px;
            width:0
        }
        @media (max-width:480px) {
            .testimonial blockquote:before {
                left:-15px
            }
        }
        .social-icon {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:32px;
            height:32px;
            color:#fff;
            background-color:#0f43b0;
            font-size:14px;
            line-height:3.2rem;
            text-align:center;
            text-decoration:none;
            opacity:1
        }
        .social-icon+.social-icon {
            margin-left:0.6rem
        }
        .social-icons .social-icon:focus,
        .social-icons .social-icon:hover {
            color:#fff;
            text-decoration:none;
            opacity:0.85
        }
        .social-icon.social-facebook {
            background-color:#3b5a9a
        }
        .social-icon.social-twitter {
            background-color:#1aa9e1
        }
        .social-icon.social-instagram {
            background-color:#7c4a3a
        }
        .social-icon.social-linkedin {
            background-color:#0073b2
        }
        .social-icon.social-gplus {
            background-color:#dd4b39
        }
        .social-icon.social-mail {
            background-color:#dd4b39
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
            border-bottom-color:#0f43b0;
            color:#0f43b0
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
        .tabs-with-icon .icon-content {
            position:relative;
            height:75px;
            width:75px;
            line-height:75px;
            text-align:center;
            font-size:3rem;
            border:1px solid #dfdfdf;
            border-radius:50%;
            margin-bottom:1.5rem
        }
        .tabs-with-icon .icon-content:after {
            content:"";
            border:5px solid #f4f4f4;
            border-radius:50%;
            display:block;
            height:100%;
            padding:1px;
            position:absolute;
            top:0;
            width:100%;
            transform:scale(1.2);
            transition:transform 0.3s
        }
        .tabs-with-icon .icon-content:hover:after {
            transform:scale(1.3)
        }
        .product-single-tabs.product-tabs-list .product-desc-content p {
            margin-bottom:1.3rem
        }
        .product-single-tabs.product-tabs-list .product-desc-content ol,
        .product-single-tabs.product-tabs-list .product-desc-content ul {
            padding-left:5.8rem;
            margin-bottom:2rem
        }
        .product-single-tabs.product-tabs-list .product-desc-content li:before {
            left:2.4rem
        }
        .product-slider-tab .tab-content {
            position:relative
        }
        .product-slider-tab .tab-content>.tab-pane {
            display:block!important;
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            height:0!important;
            opacity:0;
            z-index:-1;
            transition:visibility 0.3s,opacity 0.3s
        }
        .product-slider-tab .tab-content>.tab-pane:not(.active) {
            overflow:hidden;
            visibility:hidden
        }
        .product-slider-tab .tab-content>.active {
            position:relative;
            height:auto!important;
            opacity:1;
            z-index:auto
        }
        @media (min-width:992px) {
            .product-single-tabs.product-tabs-list {
                padding-bottom:2px
            }
            .product-single-tabs.product-tabs-list .col-lg-2 {
                -ms-flex:0 0 21.4%;
                flex:0 0 21.4%;
                max-width:21.4%
            }
            .product-single-tabs.product-tabs-list .col-lg-10 {
                -ms-flex:0 0 78.6%;
                flex:0 0 78.6%;
                max-width:78.6%
            }
            .product-single-tabs.product-tabs-list .nav.nav-tabs {
                flex-direction:column;
                border:none
            }
            .product-single-tabs.product-tabs-list .nav.nav-tabs .nav-item {
                margin-right:0;
                margin-bottom:0.8rem;
                border-bottom:1px solid #e7e7e7
            }
            .product-single-tabs.product-tabs-list .nav.nav-tabs .nav-link {
                display:inline-block;
                padding:1.4rem 0 1.5rem;
                margin-bottom:-1px
            }
            .product-single-tabs.product-tabs-list .tab-pane {
                padding-top:0.5rem
            }
            .product-single-tabs.product-tabs-list .tab-content {
                padding-left:0.9rem
            }
        }
        @media (max-width:479px) {
            .nav-tabs .nav-item:not(:last-child) {
                margin-right:2.5rem
            }
        }
        .tooltip {
            font-family:"Open Sans",sans-serif;
            font-size:1.3rem
        }
        .tooltip.show {
            opacity:1
        }
        .tooltip .arrow {
            width:1rem;
            height:1rem
        }
        .bs-tooltip-auto[x-placement^=top],
        .bs-tooltip-top {
            padding:1rem 0
        }
        .bs-tooltip-auto[x-placement^=top] .arrow:before,
        .bs-tooltip-top .arrow:before {
            margin-left:-0.5rem;
            border-width:1rem 1rem 0;
            border-top-color:#ddd
        }
        .bs-tooltip-auto[x-placement^=right],
        .bs-tooltip-right {
            padding:0 1rem
        }
        .bs-tooltip-auto[x-placement^=right] .arrow,
        .bs-tooltip-right .arrow {
            width:1rem;
            height:2rem
        }
        .bs-tooltip-auto[x-placement^=right] .arrow:before,
        .bs-tooltip-right .arrow:before {
            border-width:1rem 1rem 1rem 0;
            border-right-color:#ddd
        }
        .bs-tooltip-auto[x-placement^=bottom],
        .bs-tooltip-bottom {
            padding:1rem 0
        }
        .bs-tooltip-auto[x-placement^=bottom] .arrow:before,
        .bs-tooltip-bottom .arrow:before {
            margin-left:-0.5rem;
            border-width:0 1rem 1em;
            border-bottom-color:#ddd
        }
        .bs-tooltip-auto[x-placement^=left],
        .bs-tooltip-left {
            padding:0 1rem
        }
        .bs-tooltip-auto[x-placement^=left] .arrow,
        .bs-tooltip-left .arrow {
            width:1rem;
            height:1rem
        }
        .bs-tooltip-auto[x-placement^=left] .arrow:before,
        .bs-tooltip-left .arrow:before {
            border-width:1rem 0 1rem 1rem;
            border-left-color:#ddd
        }
        .tooltip-inner {
            max-width:270px;
            padding:1.2rem 1.5rem;
            border:1px solid #ddd;
            border-radius:0.1rem;
            background-color:#f4f4f4;
            color:#777;
            text-align:left
        }
        html {
            overflow-x:hidden;
            font-size:62.5%;
            font-size-adjust:100%;
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:100%
        }
        body {
            color:#777;
            background:#fff;
            font-size:1.4rem;
            font-weight:400;
            line-height:1.4;
            letter-spacing:0.2px;
            font-family:"Open Sans",sans-serif;
            -moz-osx-font-smoothing:grayscale;
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden
        }
        body:not(.loaded)>:not(.loading-overlay) {
            visibility:hidden!important;
            transition:none!important
        }
        body:not(.loaded)>:not(.loading-overlay) * {
            visibility:hidden!important;
            transition:none!important
        }
        ::-moz-selection {
            background-color:#0f43b0;
            color:#fff
        }
        ::selection {
            background-color:#0f43b0;
            color:#fff
        }
        p {
            margin-bottom:1.5rem
        }
        ol,
        ul {
            margin:0 0 2.25rem;
            padding:0;
            list-style:none
        }
        b,
        strong {
            font-weight:700
        }
        em,
        i {
            font-style:italic
        }
        hr {
            max-width:1730px;
            margin:5.5rem auto 5.2rem;
            border:0;
            border-top:1px solid #e7e7e7
        }
        sub,
        sup {
            font-size:70%
        }
        sup {
            font-size:50%
        }
        sub {
            bottom:-0.25em
        }
        img {
            display:block;
            max-width:100%;
            height:auto
        }
        button:focus {
            outline:none
        }
        body.modal-open {
            padding-right:0!important
        }
        @keyframes rotating {
            0% {
                transform:rotate(0deg)
            }
            to {
                transform:rotate(360deg)
            }
        }
        @keyframes spin {
            0% {
                transform:rotate(0deg)
            }
            to {
                transform:rotate(359deg)
            }
        }
        @keyframes bouncedelay {
            0%,
            80%,
            to {
                -webkit-transform:scale(0);
                transform:scale(0)
            }
            40% {
                -webkit-transform:scale(1);
                transform:scale(1)
            }
        }
        @-webkit-keyframes bouncedelay {
            0%,
            80%,
            to {
                -webkit-transform:scale(0);
                transform:scale(0)
            }
            40% {
                transform:scale(1)
            }
        }
        .loading-overlay {
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            transition:all 0.5s ease-in-out;
            background:#fff;
            opacity:1;
            visibility:visible;
            z-index:999999
        }
        .loaded>.loading-overlay {
            opacity:0;
            visibility:hidden
        }
        .bounce-loader {
            position:absolute;
            top:50%;
            left:50%;
            width:70px;
            margin:-9px 0 0 -35px;
            transition:all 0.2s;
            text-align:center;
            z-index:10000
        }
        .bounce-loader .bounce1,
        .bounce-loader .bounce2,
        .bounce-loader .bounce3 {
            display:inline-block;
            width:18px;
            height:18px;
            border-radius:100%;
            background-color:#CCC;
            box-shadow:0 0 20px 0 rgba(0,0,0,0.15);
            -webkit-animation:1.4s ease-in-out 0s normal both infinite bouncedelay;
            animation:1.4s ease-in-out 0s normal both infinite bouncedelay
        }
        .bounce-loader .bounce1 {
            -webkit-animation-delay:-0.32s;
            animation-delay:-0.32s
        }
        .bounce-loader .bounce2 {
            -webkit-animation-delay:-0.16s;
            animation-delay:-0.16s
        }
        .custom-scrollbar,
        .mobile-cart>div,
        .mobile-sidebar {
            -webkit-overflow-scrolling:touch
        }
        .custom-scrollbar::-webkit-scrollbar,
        .mobile-cart>div::-webkit-scrollbar,
        .mobile-sidebar::-webkit-scrollbar {
            height:10px;
            width:6px
        }
        .custom-scrollbar::-webkit-scrollbar-thumb,
        .mobile-cart>div::-webkit-scrollbar-thumb,
        .mobile-sidebar::-webkit-scrollbar-thumb {
            background:#e5e5e5;
            border-radius:10px;
            position:absolute
        }
        .custom-scrollbar::-webkit-scrollbar-track,
        .mobile-cart>div::-webkit-scrollbar-track,
        .mobile-sidebar::-webkit-scrollbar-track {
            background:#fff;
            border-radius:10px;
            margin:8px;
            width:100%
        }
        .load-more-overlay.loading:after,
        .loading:not(.load-more-overlay) {
            animation:spin 650ms infinite linear;
            border:2px solid #fff;
            border-radius:32px;
            border-top:2px solid rgba(0,0,0,0.4)!important;
            border-right:2px solid rgba(0,0,0,0.4)!important;
            border-bottom:2px solid rgba(0,0,0,0.4)!important;
            content:"";
            display:block;
            height:20px;
            top:50%;
            margin-top:-10px;
            left:50%;
            margin-left:-10px;
            right:auto;
            position:absolute;
            width:20px;
            z-index:3
        }
        .load-more-overlay {
            position:relative
        }
        .load-more-overlay.loading:after {
            content:""
        }
        .load-more-overlay:before {
            content:"";
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            background:#fff;
            opacity:0.8;
            z-index:3
        }
        .popup-loading-overlay {
            position:relative
        }
        .popup-loading-overlay.porto-loading-icon:before {
            content:""
        }
        .popup-loading-overlay:after {
            content:"";
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            background:#fff;
            opacity:0.8
        }
        .col-6.fade.in {
            opacity:1;
            transition:opacity 0.5s
        }
        .col-6.fade {
            opacity:0;
            transition:opacity 0.5s
        }
        @keyframes spin {
            0% {
                transform:rotate(0deg)
            }
            to {
                transform:rotate(359deg)
            }
        }
        @media (max-width:767px) {
            html {
                font-size:9px
            }
        }
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-bottom:1.8rem;
            color:#222529;
            font-weight:700;
            line-height:1.1;
            font-family:Poppins,sans-serif
        }
        .h1,
        h1 {
            font-size:3.6rem;
            font-weight:400;
            line-height:1.223
        }
        .h2,
        h2 {
            font-size:3rem;
            line-height:1.5
        }
        .h3,
        h3 {
            font-size:2.5rem;
            line-height:1.28
        }
        .h4,
        h4 {
            font-size:2rem;
            line-height:1.35
        }
        .h5,
        h5 {
            font-size:1.4rem;
            line-height:1.429
        }
        .h6,
        h6 {
            font-size:1.3rem;
            line-height:1.385;
            font-weight:600
        }
        a {
            transition:all 0.3s;
            color:#0f43b0;
            text-decoration:none
        }
        a:focus,
        a:hover {
            color:#0f43b0;
            text-decoration:none
        }
        .heading {
            margin-bottom:3rem;
            color:#222529
        }
        .heading .title {
            margin-bottom:1.6rem
        }
        .heading p {
            letter-spacing:-0.015em
        }
        .heading p:last-child {
            margin-bottom:0
        }
        .light-title {
            margin-bottom:2rem;
            font-weight:300
        }
        .section-title {
            text-transform:uppercase;
            font-size:1.8rem
        }
        .section-sub-title {
            font-size:1.6rem;
            text-transform:uppercase
        }
        @media (min-width:768px) {
            .h1,
            h1 {
                font-size:4.5rem
            }
            .h2,
            h2 {
                font-size:2.5rem
            }
            .heading {
                margin-bottom:4rem
            }
        }
        @media (min-width:992px) {
            .h1,
            h1 {
                font-size:5rem
            }
            .h2,
            h2 {
                font-size:3rem
            }
            .heading {
                margin-bottom:5rem
            }
        }
        .page-wrapper {
            position:relative;
            left:0;
            transition:all 0.25s
        }
        .main {
            flex:1 1 auto
        }
        .row {
            margin-left:-10px;
            margin-right:-10px
        }
        [class*=col-] {
            padding-left:10px;
            padding-right:10px
        }
        .row-sparse {
            margin-left:-15px;
            margin-right:-15px
        }
        .row-sparse>[class*=col-] {
            padding-left:15px;
            padding-right:15px
        }
        .row-sm {
            margin-left:-6px;
            margin-right:-6px
        }
        .row-sm>[class*=col-] {
            padding-left:6px;
            padding-right:6px
        }
        .row-joined {
            margin-left:0;
            margin-right:0
        }
        .row-joined>[class*=col-] {
            padding-left:0;
            padding-right:0
        }
        .gutter-sm {
            margin-left:-10px;
            margin-right:-10px
        }
        .gutter-sm>* {
            padding-left:10px;
            padding-right:10px
        }
        .ajax-overlay {
            display:flex;
            display:-ms-flexbox;
            align-items:center;
            -ms-flex-align:center;
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            opacity:0.8;
            background-color:#0b0b0b;
            z-index:1055
        }
        @media (min-width:1200px) {
            .col-xl-5col {
                -ms-flex:0 0 20%;
                flex:0 0 20%;
                max-width:20%
            }
            .col-xl-5col-2 {
                -ms-flex:0 0 40%;
                flex:0 0 40%;
                max-width:40%
            }
            .col-xl-7col {
                -ms-flex:0 0 14.2857%;
                flex:0 0 14.2857%;
                max-width:14.2857%
            }
            .col-xl-8col {
                -ms-flex:0 0 12.5%;
                flex:0 0 12.5%;
                max-width:12.5%
            }
            .row-xl-tight {
                margin-left:-5px;
                margin-right:-5px
            }
            .row-xl-tight>[class*=col-] {
                padding-left:5px;
                padding-right:5px
            }
        }
        @media (min-width:768px) {
            .row-md-tight {
                margin-left:-5px;
                margin-right:-5px
            }
            .row-md-tight>[class*=col-] {
                padding-left:5px;
                padding-right:5px
            }
        }
        .cols-1>* {
            max-width:100%;
            flex:0 0 100%
        }
        .cols-2>* {
            max-width:50%;
            flex:0 0 50%
        }
        .cols-3>* {
            max-width:33.3333%;
            flex:0 0 33.3333%
        }
        .cols-4>* {
            max-width:25%;
            flex:0 0 25%
        }
        .cols-5>* {
            max-width:20%;
            flex:0 0 20%
        }
        .cols-6>* {
            max-width:16.6667%;
            flex:0 0 16.6667%
        }
        .cols-7>* {
            max-width:14.2857%;
            flex:0 0 14.2857%
        }
        .cols-8>* {
            max-width:12.5%;
            flex:0 0 12.5%
        }
        @media (min-width:480px) {
            .cols-xs-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-xs-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-xs-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-xs-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-xs-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-xs-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-xs-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-xs-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        @media (min-width:576px) {
            .cols-sm-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-sm-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-sm-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-sm-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-sm-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-sm-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-sm-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-sm-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        @media (min-width:768px) {
            .cols-md-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-md-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-md-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-md-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-md-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-md-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-md-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-md-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        @media (min-width:992px) {
            .cols-lg-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-lg-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-lg-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-lg-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-lg-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-lg-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-lg-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-lg-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        @media (min-width:1200px) {
            .cols-xl-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-xl-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-xl-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-xl-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-xl-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-xl-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-xl-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-xl-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        @media (min-width:1600px) {
            .cols-xxl-1>* {
                max-width:100%;
                flex:0 0 100%
            }
            .cols-xxl-2>* {
                max-width:50%;
                flex:0 0 50%
            }
            .cols-xxl-3>* {
                max-width:33.3333%;
                flex:0 0 33.3333%
            }
            .cols-xxl-4>* {
                max-width:25%;
                flex:0 0 25%
            }
            .cols-xxl-5>* {
                max-width:20%;
                flex:0 0 20%
            }
            .cols-xxl-6>* {
                max-width:16.6667%;
                flex:0 0 16.6667%
            }
            .cols-xxl-7>* {
                max-width:14.2857%;
                flex:0 0 14.2857%
            }
            .cols-xxl-8>* {
                max-width:12.5%;
                flex:0 0 12.5%
            }
        }
        .owl-carousel .owl-nav .disabled {
            opacity:0.5;
            cursor:default
        }
        .owl-carousel .owl-dots .owl-dot span {
            width:16px;
            height:16px;
            border-width:2px
        }
        .owl-carousel .owl-dots .owl-dot span:before {
            margin:0;
            width:8px;
            height:8px;
            transform:translate(-50%,-50%)
        }
        .owl-carousel .owl-dots .owl-dot.active span:before,
        .owl-carousel .owl-dots .owl-dot:hover span:before {
            transform:translate(-50%,-50%)
        }
        .owl-carousel.dots-m-0 .disabled+.owl-dots {
            margin:0
        }
        .owl-carousel.dots-mt-1 .disabled+.owl-dots {
            margin-top:1rem
        }
        .owl-carousel.nav-big .owl-nav {
            font-size:3.7rem
        }
        .owl-carousel.nav-big .owl-nav i {
            padding:4px 7px
        }
        .owl-carousel.nav-large .owl-nav {
            font-size:4.5rem
        }
        .owl-carousel.nav-large .owl-nav i {
            padding:4px 2px
        }
        .owl-carousel.nav-image-center .owl-nav button {
            top:35%
        }
        .owl-carousel.show-nav-hover .owl-nav {
            opacity:0;
            transition:opacity 0.2s,color 0.2s
        }
        .owl-carousel.show-nav-hover:hover .owl-nav {
            opacity:1
        }
        .owl-carousel .owl-nav .owl-prev {
            left:1vw
        }
        .owl-carousel .owl-nav .owl-next {
            right:1vw
        }
        @media (min-width:992px) {
            .owl-carousel.nav-outer .owl-prev {
                left:-1.7vw
            }
            .owl-carousel.nav-outer .owl-next {
                right:-1.7vw
            }
            .owl-carousel.nav-outer.nav-large .owl-prev {
                left:-2.3vw
            }
            .owl-carousel.nav-outer.nav-large .owl-next {
                right:-2.3vw
            }
        }
        .owl-carousel.nav-top .owl-nav .owl-next,
        .owl-carousel.nav-top .owl-nav .owl-prev {
            top:-4px
        }
        .owl-carousel.nav-top .owl-nav .owl-prev {
            left:unset;
            right:3rem
        }
        .owl-carousel.nav-top .owl-nav .owl-next {
            right:0
        }
        .owl-carousel.dots-top .owl-dots {
            position:absolute;
            right:0;
            bottom:100%;
            margin:0 0 3.4rem
        }
        .owl-carousel.dots-small .owl-dots span {
            width:14px;
            height:14px
        }
        .owl-carousel.dots-small .owl-dots span:before {
            width:4px;
            height:4px
        }
        .owl-carousel.dots-simple .owl-dots .owl-dot.active span:before {
            background-color:#222529
        }
        .owl-carousel.dots-simple .owl-dots .owl-dot span {
            margin:1px 1px 2px 0px;
            border:none
        }
        .owl-carousel.dots-simple .owl-dots .owl-dot span:before {
            opacity:1;
            visibility:visible;
            background-color:#D6D6D6
        }
        .owl-carousel.images-center img {
            width:auto;
            margin:auto
        }
        .dots-left .owl-dots {
            text-align:left
        }
        .owl-carousel-lazy {
            display:block
        }
        .owl-carousel-lazy .category-slide:first-child,
        .owl-carousel-lazy .home-slide:first-child,
        .owl-carousel-lazy .owl-item:first-child .category-slide,
        .owl-carousel-lazy .owl-item:first-child .home-slide {
            display:block
        }
        .owl-carousel-lazy:not(.owl-loaded)>:not(:first-child) {
            display:none
        }
        .category-slide,
        .home-slide {
            width:100%
        }
        div.slide-bg {
            background-repeat:no-repeat;
            background-position:center center;
            background-size:cover
        }
        img.slide-bg {
            object-fit:cover;
            object-position:center top
        }
        .owl-carousel.dot-inside .owl-dots {
            position:absolute;
            right:3.6rem;
            left:3.6rem;
            bottom:4.1rem;
            text-align:center
        }
        .owl-carousel:not(.owl-loaded) {
            flex-wrap:nowrap;
            overflow:hidden
        }
        .owl-carousel:not(.owl-loaded)[class*=cols-]:not(.gutter-no) {
            margin-left:-10px!important;
            margin-right:-10px!important;
            width:auto
        }
        .owl-carousel:not(.owl-loaded).row {
            display:flex
        }
        .noUi-target {
            background:#eee
        }
        .noUi-handle {
            background:#0f43b0
        }
        .noUi-connect {
            background:none;
            box-shadow:0 1px 2px 0 rgba(0,0,0,0.38) inset
        }
        .sticky-navbar {
            display:flex;
            position:fixed;
            left:0;
            right:0;
            top:100%;
            width:100%;
            background-color:#fff;
            border-top:1px solid #e7e7e7;
            opacity:0;
            visibility:hidden;
            transition:all 0.25s;
            z-index:997
        }
        .sticky-navbar.fixed {
            opacity:1;
            visibility:visible;
            transform:translateY(-100%)
        }
        .mmenu-active .sticky-navbar.fixed,
        .sidebar-opened .sticky-navbar.fixed {
            left:260px;
            transition:all 0.25s
        }
        .sticky-navbar .sticky-info {
            flex:0 0 20%;
            max-width:20%;
            padding:1rem 0
        }
        .sticky-navbar .sticky-info:not(:last-child) {
            border-right:1px solid #e7e7e7
        }
        .sticky-navbar .sticky-info a {
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            color:#222529;
            font-family:Poppins,sans-serif;
            font-size:9px;
            font-weight:600;
            text-transform:uppercase
        }
        .sticky-navbar .sticky-info i {
            font-size:27px;
            font-weight:400
        }
        .sticky-navbar .sticky-info i span {
            font-style:normal;
            right:-4px;
            top:3px
        }
        @media (min-width:576px) {
            .sticky-navbar {
                display:none
            }
        }


        .top-notice h5 {
            color:inherit;
            font-size:inherit;
            font-weight:500
        }
        .top-notice small {
            font-size:0.8461em;
            letter-spacing:0.025em;
            opacity:0.5
        }
        .top-notice a {
            color:inherit;
            font-weight:700
        }
        .top-notice .category {
            display:inline-block;
            padding:0.3em 0.8em;
            background:#151719;
            font-size:1rem
        }
        .top-notice .mfp-close {
            top:50%;
            transform:translateY(-50%) rotateZ(45deg) translateZ(0);
            color:inherit;
            opacity:0.7;
            z-index:10
        }
        .top-notice .mfp-close:hover {
            opacity:1
        }
        .dropdown-arrow .badge-circle {
            top:3px;
            left:19px;
            z-index:2
        }
        .cart-dropdown a:focus,
        .cart-dropdown a:hover {
            color:inherit
        }
        .cart-dropdown .mobile-cart {
            display:block;
            position:fixed;
            top:0;
            bottom:0;
            right:0;
            left:auto;
            width:300px;
            margin:0;
            transform:translate(340px);
            transition:transform 0.2s ease-in-out 0s;
            background-color:#fff;
            z-index:1050;
            border:none;
            border-radius:0;
            box-shadow:0 5px 8px rgba(0,0,0,0.15)
        }
        .cart-opened .cart-dropdown .mobile-cart {
            transform:none
        }
        .cart-dropdown .mobile-cart .btn-close {
            position:absolute;
            left:-4.2rem;
            top:0.7rem;
            font-size:3.3rem;
            color:#fff;
            font-weight:300
        }
        .cart-product-info {
            color:#696969
        }
        .cart-opened .cart-overlay {
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            background:rgba(0,0,0,0.4);
            z-index:1050
        }
        .cart-dropdown .dropdownmenu-wrapper {
            padding:2rem;
            overflow-y:auto;
            height:100%
        }
        .cart-dropdown .dropdownmenu-wrapper:before {
            right:28px;
            left:auto
        }
        .cart-dropdown .dropdownmenu-wrapper:after {
            right:29px;
            left:auto
        }
        .cart-dropdown .product {
            display:-ms-flexbox;
            display:flex;
            margin:0!important;
            padding:2rem 0;
            -ms-flex-align:center;
            align-items:center;
            border-bottom:1px solid #e6ebee;
            box-shadow:none!important;
            font-family:Poppins,sans-serif
        }
        .cart-dropdown .product-image-container {
            position:relative;
            max-width:80px;
            width:100%;
            margin:0;
            margin-left:auto;
            border:1px solid #f4f4f4
        }
        .cart-dropdown .product-image-container a:after {
            display:none
        }
        .cart-dropdown .product-title {
            padding-right:1.5rem;
            margin-bottom:1.1rem;
            font-size:1.4rem;
            line-height:19px;
            color:#222529;
            font-weight:500
        }
        .cart-dropdown .product-title a {
            color:#222529
        }
        .cart-dropdown .product-details {
            margin-bottom:3px;
            font-size:1.3rem
        }
        .cart-dropdown .btn-remove {
            position:absolute;
            top:-11px;
            right:-9px;
            width:2rem;
            height:2rem;
            border-radius:50%;
            color:inherit;
            background-color:#fff;
            box-shadow:0 2px 6px rgba(0,0,0,0.5);
            text-align:center;
            line-height:2rem;
            font-size:1.8rem;
            font-weight:500
        }
        .cart-dropdown .btn-remove span {
            display:block;
            margin-top:1px
        }
        .cart-dropdown .btn-remove:focus,
        .cart-dropdown .btn-remove:hover {
            color:#0f43b0
        }
        .dropdown-cart-action .btn {
            padding:1.3rem 2.5rem 1.4rem;
            border-radius:0.2rem;
            color:#fff;
            height:auto;
            font-size:1.2rem;
            font-weight:600;
            font-family:Poppins,sans-serif;
            letter-spacing:0.025em;
            border-color:transparent
        }
        .dropdown-cart-action .btn:last-child:hover {
            color:#fff
        }
        .dropdown-cart-action .view-cart {
            margin:1rem 0;
            background:#e7e7e7;
            color:#222529
        }
        .dropdown-cart-action .view-cart:focus,
        .dropdown-cart-action .view-cart:hover {
            background:#f1f1f1;
            color:#222529
        }
        .compare-dropdown .dropdown-toggle {
            text-transform:uppercase
        }
        .compare-dropdown .dropdown-toggle i {
            margin-top:-0.2rem;
            margin-right:0.2rem
        }
        .compare-dropdown .dropdown-toggle i:before {
            margin:0
        }
        .compare-dropdown .dropdown-toggle:after {
            display:none
        }
        .compare-products {
            margin:0;
            padding:0;
            list-style:none
        }
        .compare-products .product {
            position:relative;
            margin:0;
            padding:0.5rem 0;
            box-shadow:none!important
        }
        .compare-products .product:hover {
            box-shadow:none
        }
        .compare-products .product-title {
            margin:0;
            color:#696969;
            font-size:1.1rem;
            font-weight:400;
            line-height:1.35;
            text-transform:uppercase
        }
        .compare-products .btn-remove {
            display:-ms-flexbox;
            display:flex;
            position:absolute;
            top:50%;
            right:0;
            -ms-flex-align:center;
            align-items:center;
            -ms-flex-pack:center;
            justify-content:center;
            width:2.3rem;
            height:2.3rem;
            margin-top:-1.2rem;
            padding:0.5rem 0;
            color:#777;
            font-size:1.3rem;
            line-height:1;
            text-align:center;
            overflow:hidden
        }
        .compare-actions {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-items:center;
            margin-top:2rem
        }
        .compare-actions .action-link {
            display:inline-block;
            color:#777;
            font-size:1.1rem;
            text-transform:uppercase
        }
        .compare-actions .btn {
            min-width:110px;
            margin-left:auto;
            padding:0.9rem 1rem;
            border:0;
            border-radius:0.2rem;
            color:#fff;
            font-size:1.2rem;
            font-weight:400;
            letter-spacing:0.025rem;
            text-align:center;
            text-transform:uppercase
        }
        .btn-remove {
            position:absolute;
            top:-10px;
            right:-8px;
            width:2rem;
            height:2rem;
            border-radius:50%;
            color:#474747;
            background-color:#fff;
            box-shadow:0 2px 6px 0 rgba(0,0,0,0.4);
            text-align:center;
            line-height:2rem
        }
        .btn-remove:focus,
        .btn-remove:hover {
            color:#0f43b0
        }
        .icon-cancel:before {
            content:"";
            font-family:"Font Awesome 5 Free";
            font-weight:900
        }
        @media (min-width:992px) {

            .dropdown-expanded li+li {
                margin-left:0
            }
            .dropdown-expanded ul {
                position:static;
                display:flex;
                display:-ms-flexbox;
                padding:0;
                border:0;
                background-color:transparent;
                box-shadow:none;
                opacity:1;
                visibility:visible
            }
            .dropdown-expanded ul a {
                padding:0;
                color:inherit
            }
            .dropdown-expanded ul a:hover {
                background-color:transparent
            }
        }
        @media (max-width:575px) {
            .compare-dropdown {
                display:none
            }
        }
        @media (max-width:480px) {
            .cart-dropdown .dropdown-menu,
            .compare-dropdown .dropdown-menu {
                width:262px
            }
        }
        .menu,
        .menu li,
        .menu ol,
        .menu ul {
            margin:0;
            padding:0;
            list-style:none
        }
        .menu {
            font-size:12px;
            font-weight:600;
            line-height:1.5
        }
        .menu:after {
            display:block;
            clear:both;
            content:""
        }
        .menu .show>.megamenu,
        .menu .show>ul {
            opacity:1
        }
        .menu li>a {
            display:block;
            padding:0.8rem 1.8rem;
            transition:0.2s ease-out;
            color:#777
        }
        .menu li.active>a,
        .menu li.show>a,
        .menu li:hover>a {
            background:#f4f4f4
        }
        .menu>li {
            float:left;
            position:relative;
            margin-right:2.8rem
        }
        .menu>li>a {
            padding:1rem 0;
            font-size:13px;
            font-weight:400;
            color:#555
        }
        .menu>li.active>a,
        .menu>li.show>a,
        .menu>li:hover>a {
            color:#0f43b0;
            background:transparent
        }
        .menu>li>.sf-with-ul:before {
            content:"";
            position:absolute;
            z-index:1000;
            left:50%;
            bottom:0;
            margin-left:-14px;
            border:10px solid;
            border-color:transparent transparent #fff;
            opacity:0
        }
        .menu>li.show>.sf-with-ul:before {
            opacity:1;
            visibility:visible
        }
        .menu .megamenu {
            display:none;
            position:absolute;
            z-index:999;
            background-color:#fff;
            box-shadow:0 1rem 2.5rem rgba(0,0,0,0.15);
            border:1px solid #eee;
            border-top:3px solid #0f43b0;
            left:15px;
            padding:10px 20px;
            width:580px
        }
        .menu .megamenu.megamenu-3cols {
            width:600px
        }
        .menu .megamenu .row>div {
            padding-top:1.5rem
        }
        .menu .megamenu img {
            width:300px;
            height:100%;
            object-fit:cover
        }
        .menu .megamenu .submenu {
            margin:0;
            padding-top:0;
            border-top:none;
            display:block;
            position:static;
            box-shadow:none;
            min-width:0
        }
        .menu .megamenu .submenu a {
            padding:7px 8px 8px 0;
            font-family:"Open Sans",sans-serif;
            font-size:12px
        }
        .menu .megamenu .submenu li:hover a {
            text-decoration:underline;
            background:transparent
        }
        .menu .nolink {
            cursor:default;
            display:inline-block;
            padding-bottom:11px;
            font-weight:700;
            font-family:"Open Sans",sans-serif;
            font-size:12px;
            color:#333
        }
        .menu ul {
            display:none;
            position:absolute;
            min-width:200px;
            padding:5px 0;
            border-top:3px solid #0f43b0;
            top:100%;
            left:0;
            z-index:101;
            background-color:#fff;
            box-shadow:0 29px 29px rgba(0,0,0,0.1)
        }
        .menu ul.custom-scrollbar {
            max-height:80vh;
            overflow-y:auto
        }
        .menu ul a {
            font-family:"Open Sans",sans-serif;
            font-size:12px
        }
        .menu ul ul {
            top:-5px;
            left:100%
        }
        .menu ul li {
            position:relative
        }
        .menu ul li:hover ul {
            display:block
        }
        .menu.sf-arrows .sf-with-ul+ul>li {
            position:relative
        }
        .menu.sf-arrows .sf-with-ul:after {
            position:absolute;
            right:1rem;
            content:"";
            font-family:"porto"
        }
        .menu.sf-arrows>li>.sf-with-ul:after {
            content:"";
            position:static;
            margin-left:5px;
            font-weight:400
        }
        .main-nav .menu {
            text-transform:uppercase;
            font-size:1.4rem;
            font-family:"Open Sans",sans-serif
        }
        .main-nav .menu>li {
            margin-right:3rem
        }
        .main-nav .menu > li > a {
            font-size: 1.3rem;
            font-weight: 700;
            padding: 20px 0 21px;
            letter-spacing: 0;
            color: #222529;
            letter-spacing: 0
        }
        .main-nav .menu > li:first-child > a {
            padding-left: 0
        }
        .main-nav .menu > li:not(.float-right) + li.float-right,
        .main-nav .menu > li:not(.float-right):last-child {
            margin-right: 0
        }
        .main-nav .menu.sf-arrows ul {
            border-top:none
        }
        .main-nav .menu>li>ul {
            left:-15px
        }
        .main-nav .menu .megamenu {
            top:100%;
            left:-15px;
            border-top:none
        }
        .main-nav .menu .megamenu img {
            height:100%;
            object-fit:cover
        }
        .tip {
            display:inline-block;
            position:relative;
            margin:-2px 0 0 1rem;
            padding:3px 4px;
            border-radius:2px;
            color:#fff;
            font-family:"Open Sans",sans-serif;
            font-size:1rem;
            line-height:1;
            text-transform:uppercase;
            vertical-align:middle;
            z-index:1
        }
        .tip:before {
            position:absolute;
            top:50%;
            right:100%;
            left:auto;
            margin-top:-3px;
            border:3px solid transparent;
            border-width:3px 2px 0 2px;
            content:""
        }
        .tip-new {
            background-color:#0fc567
        }
        .tip-new:not(.tip-top):before {
            border-right-color:#0fc567
        }
        .tip-new.tip-top:before {
            border-top-color:#0fc567
        }
        .tip-hot {
            background-color:#eb2771
        }
        .tip-hot:not(.tip-top):before {
            border-right-color:#eb2771
        }
        .tip-hot.tip-top:before {
            border-right-color:#eb2771
        }
        .tip-top {
            position:absolute;
            top:0;
            left:50%;
            margin-top:6px;
            margin-left:-2px;
            transform:translate(-50%)
        }
        .tip-top:before {
            top:100%;
            right:70%;
            margin:0
        }
        .menu-banner {
            height:100%
        }
        .menu-banner figure {
            margin-bottom:0;
            height:100%
        }
        .menu-banner .banner-content {
            position:absolute;
            top:50%;
            left:2rem;
            transform:translateY(-50%)
        }
        .menu-banner h4 {
            font-size:2.7rem;
            font-weight:600;
            line-height:1;
            color:#485156;
            margin-bottom:3.5rem
        }
        .menu-banner h4 span {
            font-size:3.1rem;
            font-weight:700
        }
        .menu-banner h4 b {
            font-size:3.2rem;
            color:#f4762a;
            font-family:Oswald,sans-serif
        }
        .menu-banner h4 i {
            position:absolute;
            top:33.5%;
            font-family:Oswald,sans-serif;
            font-size:1.8rem;
            font-style:normal;
            transform:translateY(-50%) rotate(-90deg)
        }
        .menu-banner .btn {
            font-family:Oswald,sans-serif;
            border-radius:1px;
            font-weight:300;
            color:#fff
        }
        .menu-banner.menu-banner-2 {
            max-height:317px
        }
        .menu-banner.menu-banner-2 figure img {
            object-position:center 80%
        }
        .menu-banner.menu-banner-2 .banner-content {
            top:10px;
            left:auto;
            right:10px;
            transform:none
        }
        .menu-banner.menu-banner-2 .banner-content b {
            color:#0f43b0
        }
        .menu-banner.menu-banner-2 i {
            position:absolute;
            font-style:normal;
            font-size:108px;
            font-weight:800;
            line-height:1;
            letter-spacing:0.02em;
            color:#fff;
            top:58px;
            left:-58px;
            transform:rotate(-90deg)
        }
        .menu-banner.menu-banner-2 .btn {
            position:absolute;
            bottom:10px;
            padding:8px 32px;
            left:50%;
            transform:translateX(-50%);
            border-radius:2px;
            font-weight:300
        }
        .mobile-menu-container {
            position:fixed;
            top:0;
            bottom:0;
            left:0;
            width:100%;
            max-width:260px;
            background-color:#1d1e20;
            font-size:1.2rem;
            line-height:1.5;
            z-index:1051;
            transform:translateX(-100%);
            transition:transform 0.25s;
            overflow-y:auto
        }
        .mmenu-active .mobile-menu-container {
            transform:translateX(0)
        }
        .mobile-menu-container .social-icons {
            display:flex;
            -ms-flex-pack:center;
            justify-content:center;
            margin-bottom:0
        }
        .mobile-menu-container .social-icon+.social-icon {
            margin-left:1.2rem
        }
        .mobile-menu-container .search-wrapper {
            display:flex;
            position:relative;
            align-items:center;
            padding-left:1.5rem;
            padding-right:1.5rem
        }
        .mobile-menu-container .search-wrapper .form-control {
            background:#282e36;
            border:0;
            line-height:22px;
            padding:8px 12px;
            height:38px
        }
        .mobile-menu-container .search-wrapper .btn {
            position:absolute;
            right:28px
        }
        .mobile-menu-wrapper {
            position:relative;
            padding:4.7rem 0 3rem
        }
        .mobile-menu-close {
            position:absolute;
            top:1.2rem;
            right:2.1rem;
            padding:0.4rem;
            color:#fff;
            line-height:1;
            cursor:pointer;
            z-index:9;
            font-size:1.3rem
        }
        .mobile-menu-overlay {
            display:block;
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            transition:all 0.25s;
            background:#000;
            opacity:0;
            visibility:hidden;
            z-index:1050
        }
        .mmenu-active .mobile-menu-overlay {
            opacity:0.35;
            visibility:visible
        }
        .mmenu-active .sidebar-product {
            display:none
        }
        .mmenu-active .mobile-sidebar {
            display:none
        }
        .mobile-nav {
            margin:0 0 2rem;
            padding:0
        }
        .mobile-menu {
            margin:0;
            padding:0;
            list-style:none
        }
        .mobile-menu li ul {
            display:none
        }
        .mobile-menu>li>a {
            text-transform:uppercase
        }
        .mobile-menu li {
            display:block;
            position:relative
        }
        .mobile-menu li:not(:last-child) {
            border-bottom:1px solid #242527
        }
        .mobile-menu li a {
            display:block;
            position:relative;
            margin-left:1.1rem;
            margin-right:1.1rem;
            padding:1rem 0 1.1rem 0.7rem;
            color:#fff;
            font-size:1.3rem
        }
        .mobile-menu li a:focus,
        .mobile-menu li a:hover {
            color:#fff;
            text-decoration:none
        }
        .mobile-menu li.active>a,
        .mobile-menu li.open>a {
            color:#fff;
            background-color:#282e36
        }
        .mobile-menu li>div {
            padding-left:1rem
        }
        .mobile-menu li ul {
            margin:0;
            padding:0
        }
        .mobile-menu li ul li a {
            padding-left:2.5rem
        }
        .mobile-menu li ul ul li a {
            padding-left:3.5rem
        }
        .mmenu-btn {
            display:block;
            position:absolute;
            top:46%;
            right:0.5rem;
            width:3rem;
            height:3rem;
            margin-top:-1.5rem;
            text-align:center;
            border-radius:0;
            outline:none;
            font-weight:bold;
            background-color:transparent;
            color:#fff;
            font-size:1.7rem;
            line-height:3rem;
            cursor:pointer
        }
        .open>.mmenu-btn:after {
            content:""
        }
        .mmenu-btn:after {
            display:inline-block;
            margin-top:-2px;
            font-family:"porto";
            content:""
        }
        .open>a>.mmenu-btn:after {
            content:""
        }
        .side-menu-wrapper {
            border:1px solid #e7e7e7
        }
        .side-menu-title {
            padding:1.5rem 2rem;
            margin-bottom:0;
            background:#f6f7f9;
            font-size:1.4rem;
            text-transform:uppercase
        }
        .side-menu li {
            position:relative
        }
        .side-menu li>a {
            display:block;
            border-bottom:1px solid #e7e7e7;
            padding:1.2rem 0;
            color:#555;
            font-weight:600
        }
        .side-menu li i {
            margin-right:1.2rem;
            font-size:20px;
            line-height:1;
            vertical-align:middle
        }
        .side-menu ul {
            display:none;
            padding-left:1.0714em
        }
        .side-menu:after {
            content:"";
            position:absolute;
            width:100%;
            height:1px;
            margin-top:-1px;
            background:#fff
        }
        .side-menu-toggle {
            position:absolute;
            top:1rem;
            right:0;
            width:24px;
            color:#222529;
            text-align:center;
            line-height:24px;
            cursor:pointer
        }
        .side-menu-toggle:before {
            content:"";
            font-family:"porto";
            font-weight:600
        }
        .show>.side-menu-toggle:before {
            content:""
        }
        .menu-vertical .megamenu,
        .menu-vertical ul {
            top:0;
            left:100%;
            margin-left:-1px;
            border-top:0
        }
        .menu-vertical.sf-arrows>li>.sf-with-ul:before {
            top:50%;
            bottom:auto;
            left:calc(95% - 12px);
            margin:-10px 0 0;
            border-width:10px 12px 10px 0;
            border-color:transparent;
            border-right-color:#fff;
            transition:0.2s
        }
        .menu-vertical.sf-arrows>li>.sf-with-ul:after {
            content:"";
            position:absolute;
            right:2.8rem;
            color:#838b90;
            font-size:1.5rem
        }
        .menu-vertical.sf-arrows>li.show>.sf-with-ul:before {
            left:calc(100% - 12px)
        }
        .menu-vertical.sf-arrows>li.show>.sf-with-ul:after {
            color:inherit
        }
        .menu-vertical.sf-arrows>li:hover>.sf-with-ul:after {
            color:inherit
        }
        .menu-vertical .nolink {
            font-size:1.3rem;
            font-weight:700
        }
        .menu-vertical>li {
            float:none;
            margin:0;
            padding:0 1.8rem 0 1.6rem
        }
        .menu-vertical>li:not(:first-child) {
            border-top:1px solid #fff
        }
        .menu-vertical>li:not(:first-child)>a {
            margin-top:-1px;
            border-top:1px solid #e7e7e7
        }
        .menu-vertical>li>a {
            display:block;
            padding:1.2rem 1rem 1.4rem 0.5rem;
            font-size:1.4rem;
            font-weight:600;
            text-transform:capitalize;
            transition:none
        }
        .menu-vertical>li i {
            position:relative;
            margin-right:8px;
            top:1px
        }
        .menu-vertical>li.active,
        .menu-vertical>li.show,
        .menu-vertical>li:hover {
            background:#0f43b0
        }
        .menu-vertical>li.active>a,
        .menu-vertical>li.show>a,
        .menu-vertical>li:hover>a {
            border-bottom-color:transparent;
            color:#fff
        }
        .menu-vertical>li.active+li>a,
        .menu-vertical>li.show+li>a,
        .menu-vertical>li:hover+li>a {
            border-top-color:transparent
        }
        .menu-custom-block {
            display:flex;
            justify-content:flex-end;
            padding-top:1rem;
            padding-bottom:0.9rem
        }
        .menu-custom-block a {
            display:block;
            position:relative;
            padding:0 15px;
            text-transform:uppercase;
            font-family:Poppins,sans-serif;
            font-size:12px;
            font-weight:700;
            line-height:32px
        }
        .menu-custom-block a:not(:hover) {
            color:#465157
        }
        .menu-custom-block a:last-child {
            padding-right:0
        }
        .menu-item-sale {
            text-align:center
        }
        .menu-item-sale a {
            display:inline-block;
            margin:7px 0px 20px;
            padding:1.6rem 4rem;
            background-color:#f4f4f4;
            color:#ff7272;
            font-size:1.4rem;
            font-weight:700
        }
        .toggle-menu-wrap .side-nav {
            position:absolute;
            top:100%;
            left:0;
            right:0
        }
        .side-menu-wrapper {
            position:relative
        }
        .side-menu-title.cursor-pointer {
            cursor:pointer
        }
        .side-menu-title.cursor-pointer+.side-nav {
            display:none;
            box-shadow:rgba(0,0,0,0.1) 0px 5px 4px 4px
        }
        @media (max-width:1199px) {
            .menu-item-sale a {
                padding-left:1.2rem;
                padding-right:1.2rem
            }
        }
        @media (max-width:575px) {
            .menu-custom-block {
                display:none
            }
        }
        footer {
            font-size:1.3rem;
            line-height:23px
        }
        footer p {
            color:inherit
        }
        .footer a {
            color:#777
        }
        footer a:focus,
        footer a:hover {
            color:#222529
        }
        .footer-top {
            background:#0f43b0;
            padding-top:2rem;
            padding-bottom:2rem
        }
        .footer-middle {
            padding-top:4.8rem;
            padding-bottom:1.4rem
        }
        .footer-bottom {
            border-top:1px solid #e1e1e1;
            padding-bottom:2.4rem;
            padding-top:2.6rem
        }
        footer .social-icon {
            border-radius:50%;
            width:3rem;
            height:3rem;
            color:#222529;
            font-size:1.4rem;
            line-height:3rem
        }
        footer .social-icon:not(:hover):not(:active):not(:focus) {
            background:transparent
        }
        footer .social-icon+.social-icon {
            margin-left:0
        }
        footer .payment-icons {
            margin-right:2px
        }
        footer .payment-icons .payment-icon {
            display:inline-block;
            vertical-align:middle;
            margin:1px;
            width:56px;
            height:32px;
            background-color:#d6d3cc;
            background-size:80% auto;
            background-repeat:no-repeat;
            background-position:center;
            transition:opacity 0.25s;
            filter:invert(1);
            border-radius:4px
        }
        footer .payment-icons .payment-icon:hover {
            opacity:0.7
        }
        footer .payment-icons .payment-icon.paypal {
            background-size:85% auto;
            background-position:50% 48%
        }
        footer .payment-icons .payment-icon.stripe {
            background-size:60% auto
        }
        footer .widget {
            margin-bottom:3rem
        }
        footer .widget-title {
            color:#2b2b2d;
            font-size:1.6rem;
            font-family:"Open Sans",sans-serif;
            text-transform:none;
            margin:0 0 1.5rem
        }
        footer .tagcloud a {
            padding:0.6em;
            margin:0 0.8rem 0.8rem 0;
            border:1px solid #313438;
            color:inherit;
            font-size:11px;
            background:transparent
        }
        footer .tagcloud a:hover {
            border-color:#fff;
            background:transparent
        }
        footer .contact-info {
            margin:0;
            padding:0
        }
        footer .contact-info li {
            position:relative;
            margin-bottom:1rem;
            line-height:1.4
        }
        footer .contact-info-label {
            display:block;
            color:#2b2b2d;
            font-weight:400;
            text-transform:uppercase;
            margin-bottom:1px
        }
        .footer-ribbon {
            position:absolute;
            top:0;
            margin:-16px 0 0;
            padding:10px 20px 6px;
            color:#fff;
            font-size:1.6em;
            z-index:101;
            background-color:#0088cc;
            font-family:"Shadows Into Light",sans-serif;
            font-weight:400
        }
        .footer-ribbon:before {
            content:"";
            display:block;
            height:0;
            position:absolute;
            top:0;
            width:7px;
            right:100%;
            border-right:10px solid #005580;
            border-top:16px solid transparent
        }
        #scroll-top {
            height:40px;
            position:fixed;
            right:15px;
            width:40px;
            z-index:9999;
            bottom:0;
            color:#fff;
            background-color:#43494e;
            font-size:16px;
            text-align:center;
            line-height:1;
            padding:11px 0;
            visibility:hidden;
            opacity:0;
            border-radius:0 0 0 0;
            transition:all 0.3s,margin-right 0s;
            transform:translateY(40px)
        }
        #scroll-top>i {
            position:absolute;
            height:24px;
            line-height:24px;
            top:0;
            bottom:0;
            left:0;
            right:0;
            margin:auto
        }
        #scroll-top>i:before {
            font-weight:700;
            font-size:2rem
        }
        #scroll-top:focus,
        #scroll-top:hover {
            background-color:#3a4045
        }
        #scroll-top.fixed {
            transform:translateY(0);
            opacity:1;
            visibility:visible;
            color:#FFF;
            width:49px;
            height:48px;
            right:10px;
            text-align:center;
            text-decoration:none;
            z-index:996;
            transition:background 0.3s ease-out;
            background:rgba(64,64,64,0.75)
        }
        #scroll-top.fixed:hover {
            color:#0f43b0
        }
        @media (max-width:575px) {
            footer {
                margin-bottom:68px
            }
            #scroll-top {
                display:none
            }
        }
        .top-message+.gap {
            position:relative;
            top:-2px
        }
        .mobile-menu-toggler {
            margin:0.8rem;
            margin-left:0;
            padding:0.7rem 1.1rem;
            color:#fff;
            font-size:1.4rem
        }
        .product-default.inner-icon {
            position:relative;
            padding:1rem 1rem 0
        }
        .product-default.inner-icon .product-title {
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.01em
        }
        .product-default.inner-icon .product-details {
            padding:0
        }
        .product-default.inner-icon .category-list {
            text-overflow:ellipsis;
            overflow:hidden;
            width:calc(100% - 20px)
        }
        .product-default.inner-icon .btn-icon-wish,
        .product-default.inner-icon .btn-quickview {
            top:auto
        }
        .product-default.inner-icon .btn-icon-wish {
            left:auto;
            right:1rem
        }
        .product-default.inner-icon .ratings-container {
            margin-left:0
        }
        .product-default.inner-icon .price-box {
            margin-bottom:1.7rem
        }
        .product-default.inner-icon .old-price {
            color:#a7a7a7;
            letter-spacing:inherit
        }
        .product-default.inner-icon:not(.product-widget):hover {
            box-shadow:0 5px 25px 0 rgba(0,0,0,0.1)
        }
        .product-default.inner-icon:not(.product-widget):hover .img-effect a:first-child:after {
            opacity:1
        }
        .product-default.inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top:1.2rem;
            padding-bottom:1.3rem
        }
        .product-default.inner-icon .btn-icon-wish {
            background-color:transparent
        }
        .product-default.inner-icon .btn-quickview {
            background-color: #0f43b0;
        }
        .inner-quickview figure .btn-quickview {
            padding:0.8rem 1.4rem;
            transition-property:padding-top,padding-bottom,opacity;
            transition-duration:0.25s;
            line-height:1.82;
            z-index:2
        }
        .inner-quickview figure .btn-quickview:hover {
            color:#fff
        }
        .inner-quickview .category-wrap .btn-icon-wish {
            font-size:1.6rem;
            padding-top:1px
        }
        .breadcrumb-item {
            line-height:27px
        }
        footer .widget-title {
            letter-spacing:-0.01em;
            line-height:1.4
        }
        footer .social-icons {
            margin-top:4px
        }
        .contact-widget .widget-title {
            font-weight:600;
            font-size:11px;
            letter-spacing:0.2px;
            line-height:1;
            text-transform:uppercase;
            color:#777;
            margin-bottom:0
        }
        .contact-widget>a {
            color:#222529;
            font-size:1.6rem;
            font-weight:700;
            line-height:1.8
        }
        .widget-newsletter-title {
            font-size:1.8rem;
            line-height:19px;
            margin-bottom:0
        }
        p.widget-newsletter-content {
            font-size:1.3rem;
            letter-spacing:0.005em;
            line-height:20px
        }
        span.widget-newsletter-content {
            font-size:1.6rem;
            letter-spacing:0.005em;
            line-height:20px
        }
        .footer-submit-wrapper .form-control {
            width:419px;
            min-width:1px;
            border-radius:24px 0 0 24px;
            padding-left:25px;
            border:none;
            height:48px;
            font-size:1.4rem
        }
        .footer-submit-wrapper .form-control::placeholder {
            color:#999
        }
        .footer-submit-wrapper .btn {
            padding-left:25px;
            padding-right:30px;
            border-radius:0 24px 24px 0;
            height:48px;
            font-family:"Open Sans",sans-serif;
            font-size:1.2rem;
            font-weight:600;
            background:#333
        }
        @media (min-width:768px) {
            .footer-middle .col-md-4 {
                flex-basis:30%;
                max-width:30%
            }
        }
        @media (min-width:992px) and (max-width:1440px) {
            .contact-widget.follow {
                margin-left:4rem
            }
        }
        @media (max-width:991px) {
            .widget-newsletter-title {
                margin-bottom:2.4rem
            }
            .widget-newsletter-content {
                margin-bottom:2.4rem
            }
            .footer-submit-wrapper .form-control {
                flex:1
            }
        }
        .about .feature-box h3 {
            margin-bottom:1.2rem;
            text-transform:none;
            font-weight:600;
            font-size:18px;
            line-height:20px;
            color:#21293c
        }
        .about .feature-box i {
            margin-bottom:1.3rem;
            font-size:5.5rem
        }
        .about .feature-box p {
            line-height:27px
        }
        .about-section .subtitle {
            margin-bottom:1.7rem
        }
        .about-section p {
            margin-bottom:2rem;
            font-weight:400;
            font-size:14px;
            line-height:24px
        }
        .about-section .lead {
            font-family:Poppins,sans-serif;
            color:#21293c;
            font-size:1.8rem;
            line-height:1.5;
            font-weight:400
        }
        .features-section {
            padding:5.1rem 0 2rem
        }
        .features-section .subtitle {
            margin-bottom:1.7rem
        }
        .features-section h3 {
            font-family:Poppins,sans-serif
        }
        .features-section .feature-box {
            padding:3rem 4rem
        }
        .testimonials-section {
            padding:5.1rem 0 7rem
        }
        .testimonials-section .subtitle {
            margin-bottom:5.2rem
        }
        .testimonials-carousel blockquote {
            margin-bottom:0
        }
        .testimonials-carousel.owl-theme .owl-nav.disabled+.owl-dots {
            margin-top:0.5rem
        }
        .testimonial-title {
            display:block;
            margin-bottom:2px;
            font-size:1.6rem;
            text-transform:uppercase;
            color:#2b2b2d
        }
        .counters-section {
            padding:5rem 0 2.4rem
        }
        .count-container .count-wrapper {
            color:#0087cb;
            font-size:3.2rem;
            font-weight:800;
            line-height:3.2rem;
            font-family:"Open Sans",sans-serif
        }
        .count-container span:not(.count-to) {
            font-size:1.9rem
        }
        .count-container .count-title {
            color:#7b858a;
            font-size:1.4rem;
            font-weight:600
        }
        .team-info figure {
            position:relative
        }
        .team-info:hover .prod-full-screen {
            opacity:1
        }
        .team-info .prod-full-screen {
            display:flex;
            width:30px;
            height:30px;
            align-items:center;
            justify-content:center;
            background-color:#222529;
            border-radius:50%;
            bottom:5px;
            right:5px
        }
        .team-info .prod-full-screen i {
            color:#fff
        }
        .owl-carousel.images-left img {
            width:auto
        }
        @media (min-width:992px) {
            .counters-section .col-md-4 {
                -ms-flex:0 0 20%;
                flex:0 0 20%;
                max-width:20%
            }
        }
        @media (min-width:768px) {
            .about-section {
                padding-top:3.1rem;
                padding-bottom:4.5rem
            }
        }
        @media (min-width:576px) {
            .testimonial blockquote {
                margin-left:85px;
                padding:2rem 3rem 1.5rem 2rem
            }
        }
        @keyframes navItemArrow {
            0% {
                position:relative;
                right:-1px
            }
            50% {
                position:relative;
                right:3px
            }
            to {
                position:relative;
                right:-1px
            }
        }
        .blog-section {
            padding-bottom:1.6rem
        }
        .post {
            margin-bottom:4.1rem
        }
        .post a {
            color:inherit
        }
        .post a:focus,
        .post a:hover {
            text-decoration:underline
        }
        .post .read-more {
            float:right
        }
        .post .read-more i:before {
            margin:0
        }
        .post-media {
            position:relative;
            margin-bottom:1.7rem;
            border-radius:0;
            background-color:#ccc
        }
        .post-media .prod-full-screen {
            display:flex;
            width:30px;
            height:30px;
            align-items:center;
            justify-content:center;
            background-color:#0f43b0;
            border-radius:50%
        }
        .post-media .prod-full-screen i {
            color:#fff
        }
        .post-media:hover .prod-full-screen {
            opacity:1
        }
        .post-media .post-date {
            position:absolute;
            top:1rem;
            left:1rem;
            width:4.5rem;
            padding:1rem 0.8rem 0.8rem;
            color:#fff;
            background:#222529;
            font-family:Poppins,sans-serif;
            text-align:center;
            text-transform:uppercase;
            letter-spacing:0.05em
        }
        .post-media .day {
            display:block;
            font-size:1.8rem;
            font-weight:700;
            line-height:1
        }
        .post-media .month {
            display:block;
            font-size:1.12rem;
            line-height:1;
            opacity:0.6
        }
        .post-media img {
            width:100%
        }
        .post-slider {
            margin-bottom:3rem
        }
        .post-slider .owl-dots {
            position:absolute;
            right:0;
            bottom:0.25rem;
            left:0;
            margin:0!important
        }
        .post-body {
            margin-left:0;
            padding-bottom:2.1rem;
            border:0;
            line-height:24px
        }
        .post-body .post-date {
            width:40px;
            margin-right:10px;
            float:left;
            text-align:center;
            box-shadow:0 1px 2px 0 rgba(0,0,0,0.1)
        }
        .post-body .post-date .day {
            display:block;
            padding:1.1rem 0.2rem;
            background-color:#f4f4f4;
            color:#08c;
            font-size:1.6rem;
            font-weight:700;
            line-height:1.375
        }
        .post-body .post-date .month {
            display:block;
            padding:0.4rem 0.2rem 0.7rem;
            border-radius:0 0 0.2rem 0.2rem;
            background-color:#08c;
            color:#fff;
            font-size:1.2rem;
            line-height:1.33;
            box-shadow:0 -1px 0 0 rgba(0,0,0,0.07) inset
        }
        .post-title {
            margin-bottom:1.3rem;
            color:#222529;
            font-family:"Open Sans",sans-serif;
            font-size:1.8rem;
            font-weight:700;
            line-height:1.35
        }
        .post-content {
            font-size:1.3rem
        }
        .post-content:after {
            display:block;
            clear:both;
            content:""
        }
        .post-content p {
            margin-bottom:7px
        }
        .post-comment {
            color:#999;
            font-size:1rem;
            text-transform:uppercase
        }
        .post-meta>span {
            display:inline-block;
            margin-right:1.5rem
        }
        .post-meta i {
            margin-right:0.5rem
        }
        .post-meta i:before {
            margin:0
        }
        .single {
            margin-bottom:2.3rem
        }
        .single .post-media {
            margin-bottom:3rem
        }
        .single .post-meta {
            margin-bottom:2rem;
            margin-left:49px
        }
        .single .post-meta a {
            color:#999;
            font-size:1rem;
            text-transform:uppercase
        }
        .single .post-title {
            margin-bottom:-8px;
            font-size:3rem;
            color:#0f43b0;
            font-weight:700;
            font-family:Poppins,sans-serif;
            line-height:40px
        }
        .single h3 {
            font-size:2rem;
            font-weight:600
        }
        .single h3 i {
            margin-right:7px;
            font-size:2rem
        }
        .single .post-share {
            margin-bottom:2.4rem
        }
        .single .post-share h3 {
            margin-bottom:2.2rem;
            letter-spacing:-0.01em
        }
        .single .post-content {
            margin-bottom:5.7rem
        }
        .single .post-content p {
            margin-bottom:2rem;
            font-family:"Open Sans",sans-serif;
            font-weight:400;
            font-size:14px;
            line-height:24px
        }
        .single .post-content h3 {
            margin-bottom:2rem;
            color:#21293c;
            font-size:18px;
            font-weight:400;
            line-height:27px
        }
        .single .social-icon {
            width:29px;
            height:29px
        }
        .single .social-icon+.social-icon {
            margin-left:0.8rem
        }
        .post-share {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-direction:column;
            flex-direction:column;
            margin-bottom:2.6rem;
            padding:2.8rem 0
        }
        .post-share h3 {
            margin-right:2rem
        }
        .post-share .social-icons {
            color:#fff
        }
        .post-author {
            margin-bottom:2.2rem;
            padding-bottom:2.7rem
        }
        .post-author:after {
            display:block;
            clear:both;
            content:""
        }
        .post-author h3 {
            margin-bottom:2rem;
            letter-spacing:-0.01em
        }
        .post-author figure {
            max-width:80px;
            margin-right:2rem;
            margin-bottom:0;
            float:left
        }
        .post-author h4 {
            margin:1rem;
            font-weight:600;
            font-size:1.6rem;
            letter-spacing:0.03em;
            color:#0f43b0;
            font-family:"Open Sans",sans-serif
        }
        .post-author .author-content {
            font-size:1.3rem;
            line-height:1.8
        }
        .post-author .author-content p:last-child {
            margin-bottom:0;
            line-height:1.7
        }
        .zoom-effect {
            position:relative;
            overflow:hidden
        }
        .zoom-effect img {
            transition:transform 0.2s
        }
        .zoom-effect:hover img {
            transform:scale(1.1,1.1)
        }
        .post-date-in-media .post-media {
            margin-bottom:1.9rem;
            overflow:hidden
        }
        .post-date-in-media .post-media img {
            transition:transform 0.2s
        }
        .post-date-in-media .post-media:hover img {
            transform:scale(1.1,1.1)
        }
        .post-date-in-media .post-body {
            margin-left:0;
            padding-bottom:2rem;
            border:0
        }
        .post-date-in-media .post-title {
            margin-bottom:0.7rem;
            font-size:1.7rem;
            font-family:Poppins,sans-serif;
            font-weight:700
        }
        .post-date-in-media p {
            font-size:1.3rem;
            line-height:1.846
        }
        .post-date-in-media .post-comment {
            color:#999;
            font-size:1rem;
            text-transform:uppercase
        }
        .comment-respond h3 {
            margin-bottom:2.9rem;
            letter-spacing:-0.01em
        }
        .comment-respond h3+p {
            margin-bottom:2.6rem
        }
        .comment-respond label {
            margin-bottom:0.7rem;
            font-size:1.4rem;
            font-family:"Open Sans",sans-serif
        }
        .comment-respond .form-control {
            height:37px
        }
        .comment-respond .form-group {
            margin-bottom:2rem
        }
        .comment-respond form {
            margin-bottom:0;
            padding:3rem;
            background-color:#f5f5f5
        }
        .comment-respond form p {
            margin-bottom:2rem;
            line-height:1.75
        }
        .comment-respond form textarea {
            margin-top:1px;
            min-height:170px
        }
        .comment-respond form .form-group-custom-control .custom-control-label {
            font-family:"Open Sans",sans-serif;
            font-size:1.4rem;
            line-height:1.75;
            font-weight:700;
            color:#222529
        }
        .comment-respond .form-group-custom-control {
            padding-top:1px
        }
        .comment-respond .custom-control-label:after,
        .comment-respond .custom-control-label:before {
            width:13px;
            height:13px
        }
        .comment-respond .custom-checkbox .custom-control-label:after {
            top:2px;
            left:1px;
            font-weight:300;
            font-size:1.2rem
        }
        .comment-respond .custom-control-label:after,
        .comment-respond .custom-control-label:before {
            top:5px;
            left:0;
            width:13px;
            height:13px;
            line-height:2rem
        }
        .comment-respond .custom-control {
            padding-left:2.2rem
        }
        .comment-respond .btn-sm {
            letter-spacing:0.01em
        }
        .related-posts {
            padding-top:3.2rem;
            margin-bottom:5rem
        }
        .related-posts h4 {
            margin-bottom:1.4rem;
            font-size:2rem;
            text-transform:uppercase;
            letter-spacing:-0.01em
        }
        .related-posts .post {
            margin-bottom:0;
            padding-bottom:0;
            border-bottom:0
        }
        .related-posts .post p {
            margin-bottom:1rem
        }
        .related-posts .post-body {
            padding-bottom:0;
            border-bottom:0
        }
        .related-posts .post-media {
            margin-bottom:2rem
        }
        .related-posts .post-title {
            color:#0077b3;
            margin-bottom:1rem;
            font-size:16.8px
        }
        .related-posts .post-content {
            margin-left:55px
        }
        .related-posts .read-more {
            float:left;
            color:#222529;
            font-size:12.6px;
            font-weight:600
        }
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
        .list {
            padding:0;
            list-style:none;
            font-size:1.3rem;
            border-bottom:1px solid rgba(0,0,0,0.08);
            margin-top:-8px;
            margin-bottom:0
        }
        .list li {
            display:block;
            position:relative;
            margin:0;
            padding:6px 0 6px 15px;
            border-top:1px solid rgba(0,0,0,0.08);
            line-height:24px
        }
        .list li:before {
            content:"";
            position:relative;
            font-family:"Font Awesome 5 Free";
            font-weight:900;
            margin-left:-11px;
            margin-right:6px;
            font-size:7.2px;
            opacity:0.7;
            vertical-align:middle
        }
        .list li:hover:before {
            animation:navItemArrow 0.6s linear infinite
        }
        .list li a {
            color:inherit
        }
        .list li:first-child {
            border-top-width:0
        }
        .list .list {
            margin-top:5px;
            margin-bottom:-6px;
            border-bottom:none
        }
        .list .list li:first-child {
            border-top-width:1px
        }
        .widget.widget-categories .widget-title {
            margin-top:1px;
            margin-bottom:1.8rem
        }
        .tagcloud:after {
            display:block;
            clear:both;
            content:""
        }
        .tagcloud a {
            margin:0.4rem 0.4rem 0.4rem 0;
            padding:0.4rem 0.8rem;
            line-height:1;
            display:inline-block;
            text-decoration:none;
            font-size:10.5px;
            text-transform:uppercase;
            font-weight:700;
            border-radius:10px;
            background-color:#222529;
            color:#fff
        }
        .simple-post-list {
            margin:0;
            padding:0;
            list-style:none
        }
        .simple-post-list li {
            padding-bottom:15px
        }
        .simple-post-list li:after {
            display:block;
            clear:both;
            content:""
        }
        .simple-post-list li:last-child {
            padding-top:15px;
            border-top:1px dotted #ececec
        }
        .simple-post-list .post-media {
            width:5rem;
            margin:0 1rem 0 0;
            float:left;
            border-radius:0;
            line-height:0
        }
        .simple-post-list .post-media img {
            display:block;
            width:100%;
            max-width:none;
            height:auto
        }
        .simple-post-list .post-info a {
            display:inline-block;
            margin-bottom:2px;
            font-weight:600;
            font-size:14px;
            line-height:18px;
            color:#0f43b0
        }
        .simple-post-list .post-info a:hover {
            text-decoration-line:underline
        }
        .simple-post-list .post-info .post-meta {
            letter-spacing:0.01em;
            font-size:1.1rem
        }
        .comment-list {
            padding-bottom:4px
        }
        .comments {
            position:relative
        }
        .comments .img-thumbnail {
            position:absolute;
            top:0;
            padding:0;
            border:0
        }
        .comments .comment-block {
            padding:2rem 2rem 3.5rem;
            margin-left:11.5rem;
            position:relative
        }
        .comments .comment-block p {
            font-size:0.9em;
            line-height:21px;
            margin:0;
            padding:0
        }
        .comments .comment-block .date {
            color:#999;
            font-size:0.9em
        }
        .comments .comment-by {
            display:block;
            padding:0 0 4px 0;
            margin:0;
            font-size:1.3rem;
            line-height:21px;
            letter-spacing:-0.005em;
            color:#999
        }
        .comments .comment-by strong {
            font-size:1.4rem;
            letter-spacing:0.005em;
            color:#7b858a
        }
        .comments .comment-footer {
            margin-top:5px
        }
        .comments .comment-arrow {
            position:absolute;
            left:-15px;
            height:0;
            top:28px;
            width:0;
            border-bottom:15px solid transparent;
            border-top:15px solid transparent;
            border-right:15px solid #f4f4f4
        }
        .comments .comment-action {
            color:var(--primary-color)
        }
        @media (max-width:991px) {
            .sidebar.mobile-sidebar {
                position:fixed
            }
        }
        @media (max-width:767px) {
            .comment-respond .form-footer {
                margin-bottom:3rem
            }
        }
        @media (max-width:767px) {
            .comment-respond .form-footer {
                margin-bottom:2rem
            }
        }
        @media (max-width:575px) {
            .comment-respond form {
                padding:1.5rem
            }
        }
        .sidebar-shop {
            font-size:1.3rem
        }
        .sidebar-shop .product-widget .product-title {
            margin-bottom:0.4rem;
            font-family:"Open Sans",sans-serif
        }
        .sidebar-shop .product-widget .product-details {
            margin-bottom:1px
        }
        .sidebar-shop .widget:after {
            display:block;
            clear:both;
            content:""
        }
        .sidebar-shop .widget:not(:last-child) {
            margin-bottom:3rem;
            border-bottom:0
        }
        .sidebar-shop .widget-title {
            margin:0;
            color:#000;
            font-family:"Open Sans",sans-serif;
            font-size:1.2rem;
            font-weight:700;
            padding-bottom:1rem;
            border-bottom:1px solid #dfdfdf;
            line-height:1.4;
            text-transform:uppercase
        }
        .sidebar-shop .widget-title a {
            display:block;
            position:relative;
            color:inherit
        }
        .sidebar-shop .widget-title a:focus,
        .sidebar-shop .widget-title a:hover {
            text-decoration:none
        }
        .sidebar-shop .widget-title a:after,
        .sidebar-shop .widget-title a:before {
            display:inline-block;
            position:absolute;
            top:50.4%;
            right:2px;
            width:10px;
            height:2px;
            margin-top:-1px;
            transition:all 0.35s;
            background:#222529;
            content:""
        }
        .sidebar-shop .widget-title a.collapsed:after {
            transform:rotate(-90deg)
        }
        .sidebar-shop .widget-body {
            padding:1.5rem 0 0.7rem
        }
        .sidebar-shop .widget-featured {
            position:relative;
            padding-bottom:0.5rem
        }
        .sidebar-shop .widget-featured .widget-body {
            padding-top:1.5rem
        }
        .sidebar-shop .widget-featured .product-sm:last-child {
            margin-bottom:0
        }
        .sidebar-shop .widget-featured .ratings-container {
            margin-left:0
        }
        .widget-featured-products .product-widget {
            margin-bottom:1.6rem
        }
        .widget-featured-products .product-widget figure {
            margin-right:1.2rem;
            max-width:84px;
            flex-shrink:0
        }
        .widget-featured-products .product-widget .ratings-container {
            margin-bottom:1.2rem;
            margin-top:2px
        }
        .widget .owl-carousel .owl-nav {
            position:absolute;
            top:-3.5rem;
            right:1px;
            line-height:0
        }
        .widget .owl-carousel .owl-nav button.owl-next,
        .widget .owl-carousel .owl-nav button.owl-prev {
            padding:0 0.4rem!important;
            border-radius:0;
            color:#222529;
            font-size:1.8rem;
            line-height:1;
            background-color:transparent
        }
        .widget .owl-carousel .owl-nav i:before {
            width:auto;
            margin:0
        }
        .cat-list {
            margin:0;
            padding:0;
            list-style:none
        }
        .cat-list li {
            position:relative;
            margin-bottom:1.3rem;
            font-size:14px;
            font-weight:500
        }
        .cat-list li:last-child {
            margin-bottom:0
        }
        .cat-list li a {
            color:#777;
            font-weight:500
        }
        .cat-list li a:focus,
        .cat-list li a:hover {
            color:#0f43b0
        }
        .cat-list .products-count {
            margin-left:3px;
            font-size:13px;
            font-weight:500
        }
        .cat-sublist {
            margin-top:1.3rem;
            margin-left:1.4rem
        }
        span.toggle {
            cursor:pointer;
            display:inline-block;
            text-align:center;
            position:absolute;
            right:-5px;
            top:-3px;
            margin:0;
            padding:0;
            width:24px;
            height:24px;
            line-height:23px;
            font-family:"Porto";
            font-weight:900;
            color:#222529
        }
        span.toggle:before {
            content:""
        }
        .collapsed span.toggle:before {
            content:""
        }
        .config-size-list {
            margin:0;
            padding:0;
            font-size:0;
            list-style:none
        }
        .config-size-list li {
            display:-ms-inline-flexbox;
            display:inline-flex
        }
        .config-size-list a {
            display:block;
            position:relative;
            min-width:32px;
            text-align:center;
            margin:3px 6px 3px 0;
            padding:4px 8px;
            transition:all 0.3s;
            border:1px solid #e9e9e9;
            color:#777;
            font-size:1.1rem;
            font-weight:400;
            line-height:1.6rem;
            text-decoration:none
        }
        .config-size-list a.active,
        .config-size-list a:focus,
        .config-size-list a:hover {
            border-color:#0f43b0;
            background-color:#0f43b0;
            color:#fff;
            text-decoration:none
        }
        .price-slider-wrapper {
            padding:1.5rem 0.4rem 0.5rem 0.6rem
        }
        .filter-price-action {
            margin-top:2.5rem;
            padding-bottom:0.5rem
        }
        .filter-price-action .btn {
            padding:5px 1.5rem 6px 1.5rem;
            font-size:1.2rem;
            font-weight:600;
            font-family:"Open Sans",sans-serif
        }
        .filter-price-action .filter-price-text {
            font-size:1.2rem;
            line-height:2
        }
        .widget-block {
            font-size:1.5rem;
            line-height:1.42
        }
        .widget-block h5 {
            margin-bottom:1.5rem;
            color:#313131;
            font-size:1.4rem;
            font-weight:600;
            font-family:"Open Sans",sans-serif
        }
        .widget-block p {
            font-size:1.4rem;
            line-height:1.75;
            margin-bottom:0
        }
        .widget-block .widget-title {
            padding-bottom:3px
        }
        .widget .config-swatch-list {
            display:flex;
            flex-wrap:wrap;
            margin-top:0.3rem
        }
        .widget .config-swatch-list li {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-items:center;
            margin:0;
            font-size:1.3rem
        }
        .widget .config-swatch-list li a {
            margin:3px 6px 3px 0;
            box-shadow:none
        }
        .widget.widget-color .widget-body {
            padding-top:0.6rem
        }
        .widget.widget-size .widget-body {
            padding-top:1.1rem
        }
        .shop-toggle.sidebar-toggle {
            display:inline-flex;
            position:static;
            align-items:center;
            width:auto;
            height:34px;
            background:#fff;
            padding:0 8px;
            text-transform:uppercase;
            color:inherit;
            border:1px solid #e7e7e7;
            cursor:pointer;
            margin-right:1rem;
            margin-top:0;
            z-index:1
        }
        .shop-toggle.sidebar-toggle span {
            font-size:11px;
            font-weight:700;
            letter-spacing:-0.05em;
            margin-left:0.6rem;
            color:#222528
        }
        .sidebar-opened .shop-toggle.sidebar-toggle {
            z-index:1
        }
        .sidebar-opened .shop-toggle.sidebar-toggle i:before {
            content:""
        }
        .horizontal-filter {
            margin-bottom:2rem;
            padding:6px 0 0px;
            background-color:#f4f4f4
        }
        .horizontal-filter.filter-sorts {
            padding:12px 12px 2px
        }
        .horizontal-filter.filter-sorts .select-custom select {
            border:none
        }
        .horizontal-filter:not(.filter-sorts) .toolbox-item:not(:last-child) {
            margin-right:1.6rem
        }
        .horizontal-filter:not(.filter-sorts).toolbox label {
            margin:0px 1rem 1px 0px;
            font-family:Poppins,sans-serif;
            letter-spacing:-0.025em
        }
        .horizontal-filter:not(.filter-sorts).toolbox .form-control {
            padding:0 0.8rem 2px;
            color:#222529;
            font-family:"poppins"
        }
        .horizontal-filter:not(.filter-sorts).toolbox .select-custom .form-control {
            padding-right:2.4rem
        }
        .horizontal-filter:not(.filter-sorts) .toolbox-item.toolbox-sort {
            margin-right:3.2rem
        }
        .horizontal-filter .filter-price-form {
            font-family:"Open Sans",sans-serif;
            font-size:1.36rem
        }
        .horizontal-filter .filter-price-form .btn {
            font-family:inherit;
            padding:0.7rem 1.2rem;
            font-size:1.2rem;
            font-weight:400
        }
        .horizontal-filter .input-price {
            display:block;
            width:50px;
            padding:6px;
            line-height:1.45;
            outline:none;
            border:1px solid rgba(0,0,0,0.09)
        }
        .horizontal-filter select {
            border:0
        }
        .horizontal-filter:not(.filter-sorts) {
            background-color:#fff
        }
        .horizontal-filter:not(.filter-sorts) .layout-btn {
            width:36px;
            border:1px solid #dfdfdf;
            line-height:34px
        }
        .horizontal-filter:not(.filter-sorts) .layout-btn.active {
            color:#222529;
            border-color:#222529
        }
        .horizontal-filter:not(.filter-sorts) .layout-btn:not(:last-child) {
            margin-right:8px
        }
        .horizontal-filter .select-custom select {
            border:1px solid #dfdfdf
        }
        .sort-menu-trigger {
            display:block;
            color:#313131;
            font-size:12px;
            line-height:1.4;
            text-transform:uppercase
        }
        .sort-list li {
            padding:1rem 0;
            font-size:12px;
            text-transform:uppercase
        }
        .sort-list li a {
            color:inherit;
            font-weight:600
        }
        .sort-list li.active,
        .sort-list li:focus,
        .sort-list li:hover {
            color:#0f43b0
        }
        .sort-list.cat-list li {
            margin-bottom:0
        }
        .sort-list.cat-list li span.toggle {
            top:5px
        }
        .filter-toggle span {
            margin-bottom:2px;
            color:#777;
            font-size:1.3rem;
            letter-spacing:-0.02em
        }
        .filter-toggle a {
            display:inline-block;
            position:relative;
            width:46px;
            height:26px;
            margin-left:7px;
            border-radius:13px;
            background:#e6e6e6;
            text-decoration:none
        }
        .filter-toggle a:before {
            position:absolute;
            left:0;
            width:42px;
            height:22px;
            -webkit-transform:translate3d(2px,2px,0) scale3d(1,1,1);
            transform:translate3d(2px,2px,0) scale3d(1,1,1);
            transition:all 0.3s linear;
            border-radius:11px;
            background-color:#fff;
            content:""
        }
        .filter-toggle a:after {
            position:absolute;
            left:0;
            width:22px;
            height:22px;
            -webkit-transform:translate3d(2px,2px,0);
            transform:translate3d(2px,2px,0);
            transition:all 0.2s ease-in-out;
            border-radius:11px;
            background-color:#fff;
            box-shadow:0 2px 2px rgba(0,0,0,0.24);
            content:""
        }
        .filter-toggle.opened a {
            background-color:#0f43b0
        }
        .filter-toggle.opened a:before {
            -webkit-transform:translate3d(18px,2px,0) scale3d(0,0,0);
            transform:translate3d(18px,2px,0) scale3d(0,0,0)
        }
        .filter-toggle.opened a:after {
            -webkit-transform:translate3d(22px,2px,0);
            transform:translate3d(22px,2px,0)
        }
        .shop-off-canvas .mobile-sidebar {
            display:block;
            position:fixed;
            padding:1.3rem 0.8rem 1.3rem 0.9rem;
            top:0;
            bottom:0;
            left:0;
            width:300px;
            margin:0;
            transform:translate(-300px);
            transition:transform 0.2s ease-in-out 0s;
            background-color:#fff;
            z-index:9999;
            overflow-y:auto
        }
        .shop-off-canvas .widget {
            border:none
        }
        .shop-off-canvas .widget:not(:last-child) {
            border-bottom:1px solid #e7e7e7
        }
        .shop-off-canvas .sidebar-wrapper {
            width:100%!important
        }
        .sidebar-opened .shop-off-canvas .mobile-sidebar {
            transform:none
        }
        .sidebar-opened .shop-off-canvas .sidebar-overlay {
            position:fixed;
            top:0;
            right:0;
            bottom:0;
            left:0;
            background:#000;
            opacity:0.35;
            z-index:9999
        }
        .sidebar-toggle {
            display:flex;
            position:static;
            margin-right:0.8rem;
            margin-top:0;
            padding:0 1.1rem 0 3px;
            align-items:center;
            width:auto;
            height:34px;
            text-transform:uppercase;
            line-height:36px;
            color:inherit;
            border:1px solid #dfdfdf;
            background:#fff;
            cursor:pointer
        }
        .sidebar-toggle span {
            margin-left:0rem;
            font-size:1.3rem;
            letter-spacing:-0.05em
        }
        .sidebar-toggle:hover span {
            color:#0f43b0
        }
        .sidebar-opened .sidebar-toggle i:before {
            content:""
        }
        .slide-content {
            position:absolute;
            top:50%;
            transform:translateY(-50%);
            left:11.4%;
            text-transform:uppercase
        }
        .boxed-slide-1 .slide-content {
            text-align:center
        }
        .boxed-slide-2 .slide-content {
            left:6.8%;
            color:#222529
        }
        .boxed-slide-1 h4 {
            font-family:Oswald,sans-serif;
            font-size:2.7rem;
            font-weight:500;
            letter-spacing:-0.08em;
            margin-bottom:0
        }
        .boxed-slide-1 h5 {
            font-family:"Open Sans",sans-serif;
            font-size:3rem;
            font-weight:800;
            letter-spacing:-0.025em;
            margin-top:-5px;
            margin-bottom:0
        }
        .boxed-slide-1 span {
            display:block;
            position:relative;
            width:100%;
            color:#222529;
            letter-spacing:0.05em;
            font-weight:700;
            margin-bottom:-6px;
            margin-top:3px
        }
        .boxed-slide-1 span:before {
            content:"";
            display:block;
            position:absolute;
            left:0;
            top:50%;
            transform:translateY(-50%);
            width:50px;
            height:1px;
            background-color:#74b0bb
        }
        .boxed-slide-1 span:after {
            content:"";
            display:block;
            position:absolute;
            right:0;
            top:50%;
            transform:translateY(-50%);
            width:50px;
            height:1px;
            background-color:#74b0bb
        }
        .boxed-slide-1 b {
            font-size:3.6rem;
            font-weight:800;
            color:#222529;
            letter-spacing:0.025em
        }
        .boxed-slide-1 b i {
            font-weight:500
        }
        .boxed-slide-1 p {
            font-size:13px;
            font-weight:700;
            color:#222529;
            letter-spacing:0.03em;
            margin-top:-5px;
            margin-bottom:2.2rem
        }
        .boxed-slide-2 h5 {
            font-family:"Open Sans",sans-serif;
            font-size:1.8rem;
            font-weight:800;
            margin-bottom:0
        }
        .boxed-slide-2 h5 span {
            font-family:Oswald,sans-serif;
            font-size:2.9rem
        }
        .boxed-slide-2 h5 i {
            font-family:Poppins,sans-serif;
            font-style:normal;
            font-size:1.6rem;
            margin-left:-2px;
            margin-bottom:5px
        }
        .boxed-slide-2 h4 {
            font-size:3.2rem;
            font-weight:800;
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.02em;
            margin-bottom:3rem;
            margin-top:-3px
        }
        .boxed-slide-2 .btn {
            font-family:Oswald,sans-serif;
            font-size:1.5rem;
            font-weight:300;
            letter-spacing:0.04em;
            padding:9px 17.5px 13px;
            margin-bottom:1.3rem
        }
        .btn-loadmore {
            box-shadow:none;
            padding:1.3rem 3rem;
            border:1px solid #e7e7e7;
            font-size:1.2rem;
            font-family:"Open Sans",sans-serif;
            color:#555
        }
        .btn-loadmore:hover {
            border-color:#ccc
        }
        .category-banner {
            padding:6.8rem 0
        }
        .category-banner .coupon-sale-text {
            font-family:"Open Sans",sans-serif
        }
        .category-banner h3 {
            font-size:3em;
            margin-left:1.8rem;
            margin-bottom:1.6rem
        }
        .category-banner h4 {
            font-size:1.125em;
            line-height:1.7
        }
        .category-banner h5 {
            font-size:1em
        }
        .category-banner .btn {
            font-size:0.75em;
            letter-spacing:0.01em;
            padding:1em 1.6em;
            margin-left:1.8rem
        }
        @media (min-width:992px) {
            .filter-sorts .toolbox-left {
                position:relative
            }
            .filter-sorts .toolbox-item.toolbox-sort {
                margin-left:0;
                margin-right:1rem;
                background-color:#fff
            }
            .filter-sorts select {
                border:0;
                text-transform:uppercase
            }
            .filter-sorts .mobile-sidebar.sidebar-shop {
                left:0;
                padding:0;
                visibility:visible;
                z-index:2
            }
            .sort-list {
                display:none;
                position:absolute;
                top:100%;
                left:0;
                min-width:220px;
                margin-top:10px;
                padding:10px 15px;
                background:#fff;
                box-shadow:0 1px 3px rgba(0,0,0,0.15);
                z-index:99
            }
            .sort-list:after,
            .sort-list:before {
                content:"";
                position:absolute;
                bottom:100%;
                border-right:10px solid transparent;
                border-bottom:10px solid #fff;
                border-left:10px solid transparent
            }
            .sort-list:before {
                left:21px;
                z-index:999
            }
            .sort-list:after {
                left:20px;
                border-right-width:11px;
                border-bottom:11px solid #e8e8e8;
                border-left-width:11px
            }
            .sort-menu-trigger {
                min-width:140px;
                height:34px;
                padding-left:0.8rem;
                color:#777;
                line-height:34px;
                z-index:9
            }
            .sort-menu-trigger:focus,
            .sort-menu-trigger:hover {
                text-decoration:none
            }
            .toolbox-item.opened .sort-list {
                display:block
            }
        }
        .sidebar-toggle svg {
            stroke:#222529;
            fill:#fff;
            width:28px
        }
        .product-ajax-grid+.bounce-loader {
            bottom:-1rem;
            top:auto
        }
        @media (min-width:992px) {
            .sidebar-toggle {
                display:none
            }
        }
        @media (max-width:991px) {
            .sort-menu-trigger {
                margin-bottom:1.5rem;
                font-weight:700
            }
            .shop-off-canvas .sidebar-wrapper {
                padding:2rem
            }
            .shop-off-canvas .sidebar-toggle {
                margin-right:0
            }
            .shop-off-canvas .toolbox {
                justify-content:flex-start
            }
            .shop-off-canvas .toolbox-right {
                margin-left:auto
            }
            .shop-off-canvas .toolbox .toolbox-item:not(:last-child) {
                margin-left:0.7rem
            }
            .sidebar-toggle span {
                font-size:11px;
                font-weight:600;
                color:#222529
            }
            .sidebar-shop .widget {
                padding:2rem 0;
                border:0
            }
            .sidebar-shop .widget:first-child {
                padding-top:0
            }
            .sidebar-shop .widget:not(:last-child) {
                border-bottom:1px solid #e7e7e7
            }
            .horizontal-filter,
            .horizontal-filter.filter-sorts,
            .horizontal-filter:not(.filter-sorts) {
                padding:10px;
                background-color:#f4f4f4
            }
        }
        @media (max-width:767px) {
            .category-content {
                padding:1rem
            }
            .category-banner h3 {
                margin-left:-2px
            }
            .category-banner .btn {
                margin-left:0
            }
            .horizontal-filter:not(.filter-sorts).toolbox .select-custom .form-control {
                padding-top:3px
            }
        }
        @media (max-width:575px) {
            .home-slide1 {
                font-size:2.5vw
            }
            .horizontal-filter.filter-sorts {
                justify-content:unset
            }
            .horizontal-filter .toolbox-item.toolbox-sort {
                margin-right:0
            }
            .boxed-slide img {
                min-height:250px
            }
            .horizontal-filter:not(.filter-sorts) .toolbox-item:not(:last-child) {
                margin-right:0
            }
        }
        @media (max-width:479px) {
            .horizontal-filter {
                justify-content:stretch
            }
            .horizontal-filter:not(.filter-sorts) .toolbox-item.toolbox-sort {
                margin-right:0;
                margin-left:0
            }
            .sidebar-toggle {
                margin-right:2px
            }
        }
        @media (min-width:992px) and (max-width:1420px) {
            .sidebar-shop .product-widget figure {
                max-width:70px;
                margin-right:1.5rem
            }
        }
        .contact-two>.container {
            margin-bottom:0.6rem
        }
        .contact-two #map {
            margin-bottom:3.2rem;
            height:400px;
            background-color:#e5e3df
        }
        .contact-two #map address {
            margin:0;
            padding:0.625rem 0.875rem;
            font-size:1.3rem;
            font-style:normal;
            font-weight:400;
            line-height:1.5
        }
        .contact-two #map a {
            display:inline-block;
            margin-top:0.8rem;
            font-size:1.2rem;
            text-transform:uppercase
        }
        .contact-two .required-field>label:after {
            margin-bottom:0.4rem;
            color:#777;
            font-size:1.3rem
        }
        .contact-two .contact-info {
            margin-bottom:3rem;
            padding-top:0.4rem
        }
        .contact-two .contact-info>div {
            margin-bottom:2rem
        }
        .contact-two .contact-info>div:after {
            display:block;
            clear:both;
            content:""
        }
        .contact-two .contact-info i {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-items:center;
            -ms-flex-pack:center;
            justify-content:center;
            width:28px;
            height:28px;
            float:left;
            border-radius:50%;
            background-color:#3b3b3b;
            color:#fff;
            font-size:1.4rem;
            text-align:center
        }
        .contact-two .contact-info p {
            margin-bottom:0;
            margin-left:5.5rem
        }
        .contact-two .contact-info p:first-of-type {
            padding-top:0.1rem
        }
        .contact-two label {
            margin-bottom:1.1rem;
            color:#777;
            font-family:"Open Sans",sans-serif;
            font-size:1.4rem;
            font-weight:400
        }
        .contact-two .form-control {
            border-color:rgba(0,0,0,0.09);
            height:37px
        }
        .contact-two .form-group {
            margin-bottom:1.8rem
        }
        .contact-two textarea.form-control {
            min-height:208px
        }
        .contact-two .form-footer {
            margin-top:1.6rem
        }
        .contact-two .btn {
            padding:0.7rem 1.3rem 0.7rem 1.4rem;
            font-size:1.4rem;
            font-weight:400;
            text-transform:none
        }
        .contact-two .contact-title {
            margin-top:1.6rem;
            margin-bottom:1.3rem;
            font-size:2rem
        }
        .contact-two p {
            padding-bottom:5px;
            font-size:14px;
            line-height:22px
        }
        .contact-two .porto-sicon-title {
            margin:0;
            margin-left:1.5rem;
            color:#777;
            font-weight:400;
            font-size:1.4rem
        }
        .contact-two .contact-time {
            padding-top:4px
        }
        .contact-two .contact-time .contact-title {
            margin-bottom:1.4rem
        }
        .contact-two .contact-time .porto-sicon-title {
            margin-top:1px
        }
        .contact-two .contact-time .porto-sicon-box {
            margin-bottom:2.3rem
        }
        @media (min-width:768px) {
            #map {
                height:380px;
                margin-bottom:5rem
            }
        }
        @media (min-width:992px) {
            #map {
                height:460px;
                margin-bottom:6rem
            }
        }
        .cart-message {
            padding:0.8rem 0 1.9rem 3px
        }
        .cart-message:before {
            content:"";
            position:relative;
            margin-right:0.6rem;
            top:2px;
            font-size:20px;
            font-weight:900;
            font-family:"Font Awesome 5 Free";
            color:#0cc485
        }
        .cart-message span {
            color:#222529;
            font-size:1.6rem
        }
        .single-cart-notice {
            line-height:24px;
            font-size:1.6rem;
            color:#222529
        }
        .view-cart {
            padding:14px 27px 13px;
            margin:3px 0;
            height:48px;
            font-family:"Open Sans",sans-serif
        }
        .add-cart {
            padding:12px 27px 10px 26px;
            font-size:1.4rem;
            font-weight:700;
            letter-spacing:-0.015em;
            line-height:24px
        }
        .add-cart:before {
            font-size:1.8rem;
            line-height:0;
            vertical-align:middle;
            margin-right:8px;
            font-weight:900
        }
        .add-wishlist {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:17px 8px;
            color:#222529;
            font-size:1.2rem;
            font-weight:700;
            font-family:Poppins,sans-serif;
            letter-spacing:-0.015em;
            text-transform:uppercase;
            white-space:nowrap
        }
        .add-wishlist i {
            margin-right:4px;
            font-size:1.6rem
        }
        .add-wishlist i:before {
            font-weight:700
        }
        .added-wishlist i:before {
            content:"";
            color:#da5555
        }
        .add-compare:before {
            content:"";
            font-size:1.8rem;
            font-family:"porto";
            margin-right:6px
        }
        .product-widgets-container {
            margin-bottom:3.8rem
        }
        .product-widgets-container .product-single-details {
            margin-bottom:3px
        }
        .product-widgets-container .section-sub-title {
            margin-bottom:1.6rem
        }
        .product-widgets-container figure {
            max-width:75px;
            margin-right:0.7rem
        }
        .product-widgets-container .product-details {
            margin-bottom:2px
        }
        .product-widgets-container .ratings-container {
            margin-bottom:1.2rem;
            margin-left:0
        }
        .product-widgets-container .product-title {
            font-size:1.4rem;
            font-family:"Open Sans",sans-serif
        }
        .product-widgets-container .product-price {
            font-size:1.5rem
        }
        .product-single-container:not(.product-quick-view) .product-action .add-cart.added-to-cart:before {
            display:none
        }
        .product-single-container:not(.product-quick-view) .product-action .add-cart.added-to-cart:after {
            margin-left:8px;
            font-family:"Font Awesome 5 Free";
            content:"";
            font-weight:600;
            font-size:1.6rem
        }
        .product-single-details {
            margin-bottom:1.1rem
        }
        .product-single-details .product-action .add-cart {
            display:inline-flex;
            align-items:center
        }
        .product-single-details .product-action .add-cart:before {
            content:"";
            margin-top:-2px;
            font-family:"Porto";
            font-weight:600;
            font-size:1.8rem;
            margin-right:7px
        }
        .sticky-sidebar .product-single-details {
            margin-bottom:2.7rem
        }
        .product-single-details .product-title {
            margin-bottom:1.1rem;
            color:#222529;
            font-size:3rem;
            font-weight:700;
            letter-spacing:-0.01em;
            width:calc(100% - 70px)
        }
        .product-single-details .product-nav {
            position:absolute;
            display:flex;
            top:4px;
            right:10px
        }
        .product-single-details .product-nav.top-0 {
            top:0
        }
        .product-single-details .product-nav a {
            color:#222529
        }
        .product-single-details .product-nav .product-next,
        .product-single-details .product-nav .product-prev {
            float:left;
            margin-left:2px
        }
        .product-single-details .product-nav .product-next.disabled>a,
        .product-single-details .product-nav .product-prev.disabled>a {
            color:#999;
            cursor:no-drop
        }
        .product-single-details .product-nav .product-next:hover .product-popup,
        .product-single-details .product-nav .product-prev:hover .product-popup {
            display:block
        }
        .product-single-details .product-nav a:hover {
            color:#333
        }
        .product-single-details .product-nav .product-link {
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:16px;
            width:28px;
            height:28px;
            line-height:23px;
            border:2px solid #e7e7e7;
            border-radius:14px;
            text-align:center;
            text-decoration:none;
            font-family:"porto"
        }
        .product-single-details .product-nav .product-prev .product-link:before {
            content:"";
            display:block
        }
        .product-single-details .product-nav .product-next .product-link:before {
            content:"";
            display:block
        }
        .product-single-details .product-nav .product-popup {
            position:absolute;
            top:31px;
            display:none;
            right:0;
            font-size:13px;
            z-index:999;
            width:110px;
            box-shadow:0 5px 8px rgba(0,0,0,0.15);
            text-align:center;
            background-color:#fff
        }
        .product-single-details .product-nav .product-popup:before {
            right:36px;
            border-bottom:7px solid #333;
            border-left:7px solid transparent!important;
            border-right:7px solid transparent!important;
            content:"";
            position:absolute;
            top:-5px
        }
        .product-single-details .product-nav .box-content {
            border-top:3px solid #222529;
            display:block;
            padding:10px 10px 11px
        }
        .product-single-details .product-nav .box-content>span {
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
            display:block;
            padding-top:5px;
            line-height:1.4em;
            font-size:12px;
            font-weight:600;
            text-align:center;
            color:#797876
        }
        .product-single-details .product-nav .product-next .product-popup:before {
            right:7px
        }
        .product-single-details .product-filters-container {
            padding-top:2px;
            padding-bottom:1.4rem
        }
        .product-single-details .product-filters-container+.price-box {
            margin-top:2.2rem;
            margin-bottom:0.8rem
        }
        .product-single-details .price-box {
            margin-bottom:2.3rem;
            color:#222529;
            font-weight:600;
            font-family:Poppins,sans-serif
        }
        .product-single-details .product-filtered-price {
            display:none;
            margin-bottom:1.3rem;
            margin-top:0.7rem
        }
        .product-single-details .new-price {
            color:#222529;
            font-size:2.4rem;
            letter-spacing:-0.02em;
            vertical-align:middle;
            line-height:0.8;
            margin-left:3px
        }
        .product-single-details .product-price {
            color:#222529;
            font-size:2.4rem;
            letter-spacing:-0.02em;
            vertical-align:middle;
            line-height:0.8
        }
        .product-single-details .old-price {
            position:relative;
            top:2px;
            color:#a7a7a7;
            font-size:1.9rem;
            font-weight:600;
            vertical-align:middle
        }
        .product-single-details .old-price+.product-price {
            margin-left:0.4rem
        }
        .product-single-details .add-wishlist:before {
            margin-right:0.3rem
        }
        .product-single-details .short-divider {
            width:40px;
            height:0;
            border-top:2px solid #e7e7e7;
            margin:0 0 2.2rem;
            text-align:left
        }
        .product-single-details .product-single-filter:last-child {
            display:none;
            margin-bottom:1rem;
            margin-top:-2px
        }
        .product-single-details .divider+.product-action {
            margin-top:-0.5rem
        }
        .product-single-details .product-action+.divider {
            margin-top:1.6rem
        }
        .product-single-details .ratings-container {
            margin-bottom:2.1rem;
            display:flex;
            align-items:center
        }
        .product-single-details .ratings-container .product-ratings,
        .product-single-details .ratings-container .ratings {
            font-size:1.3rem
        }
        .product-single-details .ratings-container .product-ratings {
            height:14px;
            margin-left:-1px;
            margin-right:1px
        }
        .product-single-details .ratings-container .product-ratings:before {
            color:#999
        }
        .product-single-details .ratings-container .ratings:before {
            color:#FD5B5A
        }
        .product-single-details .rating-link {
            color:#999;
            font-size:1.3rem;
            font-weight:400;
            padding-left:1rem
        }
        .product-single-details .rating-link:hover {
            text-decoration:underline
        }
        .product-single-details .rating-link-separator {
            padding-left:0.9rem;
            font-size:1.3rem
        }
        .product-single-details .product-desc {
            margin-bottom:1.8rem;
            font-size:1.6rem;
            letter-spacing:-0.015em;
            line-height:1.6875
        }
        .product-single-details .product-desc a {
            color:#222529
        }
        .product-single-details .product-action {
            padding:1.5rem 0 1.6rem;
            border-top:1px solid #e7e7e7
        }
        .product-single-details .container {
            align-items:center;
            -ms-flex-align:center
        }
        .product-single-details .container img {
            max-width:5rem;
            max-height:5rem;
            margin-right:2rem
        }
        .product-single-details .product-single-qty {
            margin:0.5rem 0.5rem 0.5rem 1px
        }
        .product-single-details .product-single-qty .form-control {
            height:48px;
            font-size:1.6rem;
            font-weight:700
        }
        .product-single-details .clear-btn {
            display:inline-block;
            background-color:#f4f4f4;
            margin-top:-3px;
            margin-left:-3px;
            padding:5px 8px;
            font-size:1rem;
            color:#777
        }
        .product-single-details .clear-btn:hover {
            background-color:#0f43b0;
            color:#fff
        }
        .product-filters-container select.form-control:not([size]):not([multiple]) {
            margin-bottom:0;
            height:42px;
            font-weight:600
        }
        .product-filters-container .select-custom {
            max-width:282px;
            width:100%
        }
        .product-filters-container .select-custom:after {
            right:1.5rem;
            color:#222529
        }
        .product-both-info .row .col-lg-12 {
            margin-bottom:12px
        }
        .product-both-info .product-single-details {
            margin-top:0
        }
        .product-both-info .product-single-details .product-desc {
            border-bottom:0
        }
        .product-both-info .product-single-gallery .label-group {
            left:1.8rem
        }
        .single-info-list {
            margin-bottom:1.7rem;
            padding:0;
            font-size:1.2rem;
            line-height:1.5;
            letter-spacing:0.005em;
            text-transform:uppercase
        }
        .single-info-list li {
            margin-bottom:1rem;
            letter-spacing:0.001em
        }
        .single-info-list li strong {
            color:#222529;
            letter-spacing:0
        }
        .product-single-filter {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:center;
            align-items:center;
            margin-bottom:1rem
        }
        .product-single-filter label {
            margin-right:4.2rem;
            min-width:5rem;
            margin-bottom:0;
            color:#777;
            font-weight:400;
            font-family:"Open Sans",sans-serif;
            letter-spacing:0.005em;
            text-transform:uppercase
        }
        .product-single-filter .config-swatch-list {
            display:inline-flex;
            margin:0
        }
        .product-single-filter .config-size-list li {
            margin-bottom:0;
            margin-right:0;
            color:#777
        }
        .product-single-filter .config-size-list li a {
            margin:3px 6px 3px 0;
            min-width:3.2rem;
            height:2.6rem;
            border:1px solid #eee;
            color:inherit;
            font-size:1.1rem;
            font-weight:500;
            line-height:2.6rem;
            background-color:#fff
        }
        .product-single-filter .config-size-list li a:not(.disabled):hover {
            border-color:#0f43b0;
            background-color:#0f43b0;
            color:#fff
        }
        .product-single-filter .config-size-list li a.disabled {
            cursor:not-allowed;
            text-decoration:none;
            background-color:transparent;
            opacity:0.5
        }
        .product-single-filter .config-size-list li a.filter-color {
            height:2.8rem;
            min-width:2.8rem
        }
        .product-single-filter .config-size-list li.active a {
            border-color:#0f43b0;
            outline:none;
            color:#fff;
            background-color:#0f43b0
        }
        .product-single-filter .config-size-list li.active a.filter-color:before {
            display:inline-block;
            position:absolute;
            top:50%;
            left:50%;
            transform:translateX(-50%) translateY(-50%);
            font-family:"porto";
            font-size:1.1rem;
            line-height:1;
            content:""
        }
        .product-single-filter .config-img-list li a {
            height:100%
        }
        .product-single-filter .config-img-list li img {
            width:30px;
            height:30px
        }
        .product-single-filter.product-single-qty {
            max-width:148px;
            max-height:7.5rem;
            border-bottom:0
        }
        .product-single-qty label {
            color:#222529;
            font-weight:600;
            font-size:1.5rem
        }
        .product-single-share {
            display:-ms-flexbox;
            display:flex;
            margin-top:0.7rem;
            -ms-flex-align:center;
            align-items:center;
            flex-wrap:wrap;
            -ms-flex-wrap:wrap
        }
        .product-single-share label {
            margin-right:1.2rem;
            margin-bottom:0.5rem;
            color:#222529;
            font-weight:600;
            font-size:1.4rem;
            line-height:1.1;
            font-family:"Open Sans",sans-serif;
            letter-spacing:0.005em;
            text-transform:uppercase
        }
        .product-single-share .social-icons {
            margin-top:2px
        }
        .product-single-share .social-icons.vertical {
            display:flex;
            flex-direction:column
        }
        .product-single-share .social-icons.vertical .social-icon {
            border-radius:0
        }
        .product-single-share .social-icon {
            line-height:2em;
            border:2px solid transparent;
            margin:0.2857em 1px 0.2857em 0
        }
        .product-single-share:not(.icon-with-color) .social-icon {
            border-radius:50%
        }
        .product-single-share:not(.icon-with-color) .social-icon:not(:hover):not(:active):not(:focus) {
            color:#222529;
            background-color:transparent;
            border-color:#e7e7e7
        }
        .product-single-gallery {
            margin-bottom:3.3rem
        }
        .product-single-gallery .sticky-slider:not(.sticked) {
            position:relative!important
        }
        .product-single-gallery a {
            display:block
        }
        .product-single-gallery img {
            display:block;
            width:100%;
            max-width:none
        }
        .product-single-gallery .prod-thumbnail .owl-nav {
            font-size:1.6rem;
            color:#0f43b0
        }
        .product-single-gallery .prod-thumbnail .owl-nav .owl-prev {
            left:1.5rem
        }
        .product-single-gallery .prod-thumbnail .owl-nav .owl-next {
            right:1.5rem
        }
        .product-single-gallery .owl-nav {
            font-size:2.8rem
        }
        .product-single-gallery .owl-nav .owl-prev {
            left:2.5rem
        }
        .product-single-gallery .owl-nav .owl-next {
            right:2.5rem
        }
        .product-single-gallery .owl-nav button {
            transition:opacity 0.5s
        }
        .product-single-gallery .product-item {
            position:relative;
            z-index:2
        }
        .product-single-gallery .product-item:not(:last-child) {
            margin-bottom:4px
        }
        .product-single-gallery .product-item:hover .prod-full-screen {
            opacity:1
        }
        .product-single-gallery .product-single-grid {
            margin-bottom:3.6rem
        }
        .product-single-gallery .label-group {
            position:absolute;
            z-index:100;
            top:1.1rem;
            left:1.1rem
        }
        .product-single-gallery .product-label {
            display:block;
            text-align:center;
            margin-bottom:5px;
            text-transform:uppercase;
            padding:7px;
            color:#fff;
            font-weight:600;
            font-size:12px;
            font-weight:700;
            line-height:1;
            border-radius:12px
        }
        .product-single-gallery .product-label.label-hot {
            background-color:#2ba968
        }
        .product-single-gallery .product-label.label-sale {
            background-color:#da5555
        }
        .product-single-gallery .product-label.label-new {
            background-color:#08c
        }
        .prod-thumbnail {
            display:flex;
            display:-ms-flexbox;
            margin:8px 0 0;
            padding:0 1px
        }
        .prod-thumbnail>.owl-dot {
            flex:0 0 25%;
            max-width:25%;
            padding:4px
        }
        .prod-thumbnail.owl-theme .owl-nav [class*=owl-]:hover {
            color:#0f43b0
        }
        .prod-thumbnail img {
            width:100%;
            cursor:pointer
        }
        .prod-thumbnail .owl-dot.active img,
        .prod-thumbnail img:hover {
            border:2px solid #21293c
        }
        .transparent-dots {
            position:absolute;
            top:1.6rem;
            left:2.6rem;
            width:110px;
            margin:0;
            padding:0;
            z-index:99
        }
        .transparent-dots .owl-dot {
            flex:1;
            max-width:108px;
            margin-bottom:2px
        }
        .transparent-dots .owl-dot img {
            border:0;
            border:1px solid rgba(0,0,0,0.1);
            transition:border-color 0.2s
        }
        .transparent-dots .owl-dot.active img,
        .transparent-dots .owl-dot:hover img {
            border:1px solid #0f43b0;
            transition:border-color 0.2s
        }
        .product-slider-container:not(.container) {
            position:relative;
            padding-left:1px;
            padding-right:1px
        }
        .product-slider-container:not(.container):hover .prod-full-screen {
            opacity:1
        }
        .product-slider-container:not(.container) button.owl-next:not(.disabled),
        .product-slider-container:not(.container) button.owl-prev:not(.disabled) {
            opacity:1
        }
        .prod-full-screen {
            position:absolute;
            right:2rem;
            bottom:1.7rem;
            transition:all 0.5s;
            outline:none;
            opacity:0;
            z-index:1
        }
        .prod-full-screen i {
            color:#000;
            font-size:1.4rem;
            cursor:pointer
        }
        .product-single-tabs .tab-pane {
            padding-top:3rem;
            padding-bottom:3rem;
            color:#7b858a;
            line-height:1.92
        }
        .product-single-tabs .nav.nav-tabs .nav-link {
            color:#818692
        }
        .product-single-tabs .nav.nav-tabs .nav-link.active {
            color:#222529
        }
        .product-single-tabs .nav.nav-tabs .nav-link {
            font-family:"Open Sans",sans-serif;
            font-size:1.3rem
        }
        .product-single-tabs .nav.nav-tabs .nav-link.active,
        .product-single-tabs .nav.nav-tabs .nav-link:hover {
            border-bottom-color:#222529
        }
        .product-single-tabs .nav-item {
            font-size:1.3rem
        }
        .scrolling-box .tab-pane+.tab-pane {
            margin-top:3.5rem;
            border-top:2px solid #dae2e6
        }
        .product-size-content {
            padding-top:2rem;
            padding-bottom:0.5rem
        }
        .product-size-content img {
            margin:0 auto 2rem
        }
        .product-desc-content {
            margin-bottom:2.5rem
        }
        .product-desc-content .feature-icon {
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 1.9rem;
            border-style:solid;
            border-width:2px;
            width:64px;
            height:64px;
            line-height:60px;
            border-radius:60px;
            font-size:28px;
            color:#0f43b0;
            background:transparent;
            border-color:#0f43b0
        }
        .product-desc-content .feature-box p {
            font-size:14px;
            line-height:27px;
            color:#4a505e;
            letter-spacing:0
        }
        .product-desc-content .feature-box h3 {
            margin-bottom:0.8rem;
            font-size:1.4rem
        }
        .product-desc-content p {
            margin-bottom:2.3rem;
            letter-spacing:0.005em
        }
        .product-desc-content ol,
        .product-desc-content ul {
            margin-bottom:2.4rem;
            padding-left:7.4rem;
            letter-spacing:0.005em;
            position:relative;
            padding-top:2px
        }
        .product-desc-content li {
            margin-bottom:9px;
            letter-spacing:0
        }
        .product-desc-content li:before {
            content:"";
            position:absolute;
            left:4rem;
            display:inline-block;
            margin-top:-2px;
            vertical-align:middle;
            font-family:"Font Awesome 5 Free";
            font-weight:900;
            margin-right:1.8rem;
            color:#21293c;
            font-size:1.6rem
        }
        .product-desc-content img.float-left,
        .product-desc-content img.float-right {
            max-width:50%
        }
        .product-desc-content img {
            padding-top:4px
        }
        .product-desc-content .feature-box i {
            display:inline-block;
            font-size:2.8rem;
            float:none;
            margin-bottom:0;
            margin-top:3px
        }
        .product-desc-content .feature-box-content {
            margin-left:0
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
        .product-tags-content h4 {
            margin:0 0 2rem;
            font-size:1.8rem;
            font-weight:700;
            text-transform:uppercase
        }
        .product-tags-content form {
            margin-bottom:2rem
        }
        .product-tags-content .form-group {
            display:-ms-flexbox;
            display:flex;
            -ms-flex-align:stretch;
            align-items:stretch
        }
        .product-tags-content .form-control {
            margin-right:10px
        }
        .product-tags-content .btn {
            padding-top:0.5rem;
            padding-bottom:0.5rem
        }
        .product-reviews-content {
            padding-top:2px;
            padding-bottom:2.5rem;
            line-height:1.92
        }
        .product-reviews-content .required {
            color:#222529
        }
        .product-reviews-content .reviews-title {
            margin-bottom:1.6rem;
            font-size:2rem;
            font-weight:400
        }
        .product-reviews-content .reviews-title+p {
            padding-bottom:0.4rem;
            letter-spacing:0.005em
        }
        .product-reviews-content .ratings-container {
            margin:-3px -2px 0.5rem 0
        }
        .product-reviews-content .divider {
            border-top:1px solid #e7e7e7;
            margin:4rem 0
        }
        .product-reviews-content .comments .comment-block {
            padding-bottom:2.3rem;
            background-color:#f5f7f7
        }
        .comment-container {
            display:flex;
            display:-ms-flexbox;
            padding:29px 0 8px
        }
        .comment-container:not(:first-child) {
            border-top:1px solid #e7e7e7
        }
        .comment-container .comment-avatar {
            flex:1 0 auto;
            padding:0 22px 5px 8px
        }
        .comment-container img {
            border-radius:10rem
        }
        .comment-container .ratings-container {
            margin-bottom:6px
        }
        .comment-container .product-ratings,
        .comment-container .ratings {
            font-size:14px
        }
        .comment-container .product-ratings:before {
            color:#999
        }
        .comment-container .ratings:before {
            color:#FD5B5A
        }
        .comment-container .comment-info {
            font-family:"Open Sans",sans-serif;
            font-size:1.4rem;
            line-height:1;
            letter-spacing:-0.02em
        }
        .comment-container .avatar-name {
            display:inline;
            font-family:inherit;
            font-size:inherit
        }
        .comment-container .comment-text {
            letter-spacing:-0.015em
        }
        .add-product-review {
            padding-top:5px
        }
        .add-product-review .custom-checkbox .custom-control-input:checked~.custom-control-label:after {
            top:4px;
            left:2px
        }
        .add-product-review form {
            padding:3.5rem 2rem 3.3rem;
            border-radius:3px;
            background-color:#f4f4f4
        }
        .add-product-review h3 {
            margin-bottom:1.6rem;
            font-size:2rem;
            font-weight:400;
            letter-spacing:-0.01em
        }
        .add-product-review label {
            display:block;
            font-family:"Open Sans",sans-serif;
            font-size:1.4rem;
            line-height:1;
            margin-bottom:1.1rem
        }
        .add-product-review .rating-stars {
            margin-bottom:1rem
        }
        .add-product-review .form-control {
            margin-top:1.4rem;
            margin-bottom:1.6rem;
            font-size:1.4rem;
            max-width:100%;
            height:37px
        }
        .add-product-review textarea.form-control {
            min-height:170px
        }
        .add-product-review .btn {
            padding:0.55em 1rem 0.5em;
            font-weight:400;
            text-transform:none;
            font-family:"Open Sans",sans-serif
        }
        .add-product-review .custom-control-label {
            letter-spacing:0.005em;
            line-height:1.9
        }
        .add-product-review .custom-control-label:after,
        .add-product-review .custom-control-label:before {
            top:6px;
            left:0;
            width:15px;
            height:15px;
            font-size:1.2rem;
            font-weight:300
        }
        .add-product-review .custom-checkbox .custom-control-input:checked~.custom-control-label:before {
            background-color:#0075ff;
            border-color:#0075ff
        }
        .add-product-review .custom-checkbox .custom-control-input:checked~.custom-control-label:after {
            color:#fff
        }
        .add-product-review .custom-control {
            padding-left:2.2rem;
            margin-bottom:1rem;
            margin-top:-6px
        }
        .rating-stars {
            display:flex;
            display:-ms-flexbox;
            position:relative;
            height:14px;
            font-size:1.4rem;
            margin-bottom:2.8rem
        }
        .rating-stars a {
            color:#706f6c;
            text-indent:-9999px;
            letter-spacing:1px;
            width:16px
        }
        .rating-stars a:before {
            content:"";
            position:absolute;
            left:0;
            height:14px;
            line-height:1;
            font-family:"Font Awesome 5 Free";
            text-indent:0;
            overflow:hidden;
            white-space:nowrap
        }
        .rating-stars a.active:before,
        .rating-stars a:hover:before {
            content:"";
            font-weight:900
        }
        .rating-stars .star-1 {
            z-index:10
        }
        .rating-stars .star-2 {
            z-index:9
        }
        .rating-stars .star-3 {
            z-index:8
        }
        .rating-stars .star-4 {
            z-index:7
        }
        .rating-stars .start-5 {
            z-index:6
        }
        .rating-stars .star-1:before {
            width:16px
        }
        .rating-stars .star-2:before {
            width:32px
        }
        .rating-stars .star-3:before {
            width:48px
        }
        .rating-stars .star-4:before {
            width:64px
        }
        .rating-stars .star-5:before {
            content:""
        }
        .products-section {
            padding-top:3.8rem;
            padding-bottom:3rem
        }
        .products-section .owl-carousel.dots-top .owl-dots {
            margin:0px -2px 3.5rem
        }
        .products-section .owl-carousel.dots-top .owl-dots span {
            border-color:rgba(0,68,102,0.4)
        }
        .products-section .owl-carousel.dots-top .owl-dot.active span {
            border-color:#0f43b0
        }
        .products-section .product-title {
            margin-bottom:4px
        }
        .products-section .price-box {
            margin-bottom:1.4rem
        }
        .products-section h2 {
            font-family:"Poppins";
            padding-bottom:1rem;
            border-bottom:1px solid #e7e7e7;
            margin-bottom:3.4rem;
            font-size:1.8rem;
            line-height:22px;
            letter-spacing:-0.01em;
            text-transform:uppercase
        }
        .products-section.pt-sm {
            padding-top:2.5rem
        }
        .product-sidebar-right {
            margin-bottom:1.7rem
        }
        .product-sidebar-right .product-single-gallery {
            margin-bottom:2.7rem
        }
        .product-sidebar-right .product-single-details {
            margin-bottom:0.6rem
        }
        .product-sidebar-right .product-desc-content p {
            margin-bottom:1.3rem;
            letter-spacing:0.005em
        }
        .product-sidebar-right .product-desc-content ul {
            margin-bottom:2rem;
            padding-left:5.8rem
        }
        .product-sidebar-right .product-desc-content li:before {
            left:2.4rem
        }
        .products-section .container-fluid {
            padding-right:20px;
            padding-left:20px
        }
        .custom-product-filters .config-size-list li a {
            height:28px;
            font-size:13px;
            border:1px solid #e9e9e9;
            color:#222529;
            background-color:#f4f4f4
        }
        .custom-product-filters .config-color-list img {
            width:30px;
            height:30px
        }
        .custom-product-filters .config-color-list li a {
            height:100%
        }
        .single-product-custom-block .porto-heading {
            padding:0.85em 2em;
            margin-bottom:1.7rem;
            box-shadow:0 3px 10px 0 rgba(0,0,0,0.1);
            margin-right:20px;
            font-family:"Open Sans",sans-serif;
            font-weight:600;
            font-size:1.2rem
        }
        .custom-product-single-share {
            position:absolute;
            top:0;
            right:0rem
        }
        .custom-product-single-share .social-icon {
            display:block;
            margin:0;
            margin-bottom:2px;
            border-radius:0
        }
        .custom-product-single-tabs {
            padding:7rem 0 3rem
        }
        .custom-product-single-tabs .add-product-review form {
            background-color:#f7f7f7
        }
        .custom-product-single-tabs .product-desc-content ol,
        .custom-product-single-tabs .product-desc-content ul {
            margin-bottom:2rem;
            padding-left:5.8rem
        }
        .custom-product-single-tabs .product-desc-content li:before {
            left:2.4rem
        }
        .custom-product-single-tabs .product-desc-content p {
            margin-bottom:1.3rem
        }
        .custom-product-single-tabs .nav.nav-tabs .nav-link {
            font-size:1.5rem;
            padding:1.1rem 0 1rem;
            margin-right:1.5rem;
            background-color:transparent
        }
        .product-single-tab-two .product-desc-content p {
            margin-bottom:1.3rem
        }
        .product-single-tab-two .product-desc-content ul {
            margin-bottom:2rem;
            padding-left:5.8rem
        }
        .product-single-tab-two .product-desc-content li:before {
            left:2.4rem
        }
        .product-left-sidebar .product-single-details {
            margin-bottom:0.8rem
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
        @media (max-width:1199px) {
            .transparent-dots {
                width:90px
            }
        }
        @media (min-width:768px) {
            .custom-product-single-tabs .nav.nav-tabs .nav-item {
                margin-bottom:-3px
            }
            .custom-product-single-tabs .nav.nav-tabs .nav-link {
                padding:1.1rem 0 1rem;
                font-size:1.8rem;
                margin-right:1.5rem
            }
            .products-section {
                padding-top:4.8rem;
                padding-bottom:3.6rem
            }
            .product-both-info .product-single-share {
                -ms-flex-pack:end;
                justify-content:flex-end
            }
            .add-product-review form {
                padding-left:3rem;
                padding-right:3rem
            }
            .product-both-info-bottom .col-md-4:last-child strong {
                order:2;
                margin-left:20px;
                margin-right:0
            }
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
        @media (min-width:1200px) {
            .product-both-info .product-single-share {
                margin-top:-13px
            }
        }
        @media (max-width:991px) {
            .single-product-custom-block {
                margin-right:4rem
            }
            .single-product-custom-block .porto-heading {
                padding:0.85em 1em;
                margin-bottom:0.7rem;
                margin-right:1rem
            }
        }
        @media (min-width:992px) and (max-width:1199px) {
            .product-all-icons.product-action .product-single-qty {
                margin-right:50%;
                margin-bottom:1.2rem
            }
        }
        @media (min-width:576px) {
            .product-tags-content .form-control {
                width:250px
            }
        }
        @media (max-width:767px) {
            .product-size-content .table.table-size {
                margin-top:3rem
            }
        }
        @media (max-width:575px) {
            .transparent-dots {
                width:70px
            }
            .rating-stars a:before {
                line-height:1.2
            }
            .ratings-container .product-ratings,
            .ratings-container .ratings {
                line-height:1.2
            }
        }
        @media (max-width:480px) {
            .pg-vertical .product-thumbs-wrap {
                height:165px
            }
            .pg-vertical .vertical-thumbs {
                max-width:48px
            }
            .pg-vertical .product-slider-container {
                max-width:calc(100% - 53px)
            }
            .product-size-content .table.table-size td,
            .product-size-content .table.table-size th {
                padding-left:1rem;
                padding-right:0.5rem;
                font-size:1.2rem
            }
            .product-reviews-content .reviews-title {
                font-size:1.7rem
            }
            .custom-product-single-tabs .nav.nav-tabs .nav-item:not(:last-child) {
                margin-right:0
            }
            .custom-product-single-tabs .nav.nav-tabs .nav-link {
                font-size:1.4rem
            }
        }
        .sidebar-product .widget.widget-product-categories {
            margin-bottom:3rem;
            padding:1.8rem 1.5rem 1.3rem;
            border:1px solid #e7e7e7
        }
        .sidebar-product .widget.widget-product-categories .widget-body {
            padding:2px 0 0.5rem 1.4rem
        }
        .sidebar-product .widget.widget-product-categories .widget-body:after {
            display:block;
            clear:both;
            content:""
        }
        .sidebar-product .widget.widget-product-categories .cat-list li {
            margin-bottom:0.5rem
        }
        .sidebar-product .widget.widget-product-categories .cat-list li:last-child {
            margin-bottom:-2px
        }
        .sidebar-product .widget.widget-product-categories a {
            display:block;
            position:relative;
            padding:4px 0;
            color:#7a7d82;
            font-weight:600
        }
        .sidebar-product .widget.widget-product-categories .widget-title {
            color:#7a7d82;
            font-weight:600;
            font-size:14px;
            font-family:"Open Sans",sans-serif;
            line-height:24px
        }
        .sidebar-product .widget-title a:after {
            content:"";
            display:inline-block;
            position:absolute;
            top:46%;
            right:2px;
            transform:translateY(-50%);
            transition:all 0.35s;
            font-family:"porto";
            font-size:1.7rem;
            font-weight:600;
            color:#222529
        }
        .sidebar-product .widget-title a.collapsed:after {
            content:""
        }
        .sidebar-product .sidebar-toggle {
            position:fixed;
            padding-left:10px;
            top:50%;
            z-index:9999;
            left:0
        }
        .custom-sidebar-toggle {
            display:flex;
            position:fixed;
            padding:0;
            align-items:center;
            justify-content:center;
            top:20%;
            left:0;
            width:40px;
            height:40px;
            transition:left 0.2s ease-in-out 0s;
            border:#dcdcda solid 1px;
            border-left-width:0;
            background:#fff;
            font-size:17px;
            line-height:38px;
            text-align:center;
            cursor:pointer;
            z-index:999;
            margin-top:50px
        }
        .sidebar-opened .custom-sidebar-toggle {
            left:260px;
            z-index:9000
        }
        .sidebar-opened .custom-sidebar-toggle i:before {
            content:""
        }
        .sidebar-product {
            margin-bottom:2.8rem
        }
        .sidebar-product .widget:not(:last-child):not(.widget-info) {
            margin-bottom:2.9rem
        }
        .sidebar-product .widget-info {
            margin:0px 0 4.8rem
        }
        .sidebar-product .widget-info li {
            display:flex;
            align-items:center;
            margin-bottom:2.2rem
        }
        .sidebar-product .widget-info i {
            margin:1px 1.9rem 0 4px
        }
        .sidebar-product .widget-featured {
            padding-bottom:3rem
        }
        .sidebar-product .widget-featured .widget-body {
            padding-top:1.9rem
        }
        .sidebar-product .widget-featured .owl-carousel .owl-nav {
            top:-4.1rem
        }
        .sidebar-product .widget-title {
            margin:0;
            text-transform:none;
            border-bottom-width:1px;
            font-weight:600;
            font-size:1.5rem;
            line-height:24px
        }
        .sidebar-product .widget-subtitle {
            color:#7a7d82;
            margin-bottom:3rem;
            font-size:1.3rem;
            font-weight:400
        }
        .sidebar-product .widget-body {
            padding-left:0;
            padding-top:2.3rem
        }
        .sidebar-product .widget-body p {
            line-height:27px;
            font-size:1.3rem;
            color:#222529;
            letter-spacing:0.01em;
            font-weight:500;
            margin-bottom:3rem
        }
        .sidebar-product .product-widget {
            margin-bottom:1.3rem
        }
        .sidebar-product .product-widget figure {
            margin-right:0.8rem;
            max-width:75px
        }
        .sidebar-product .product-widget .widget-body {
            padding-top:1.9rem
        }
        .sidebar-product .ratings-container {
            margin-left:0;
            margin-bottom:1.2rem
        }
        .sidebar-product .owl-carousel .owl-nav {
            top:-4.1rem;
            right:1px
        }
        .sidebar-product .owl-carousel .owl-nav button.owl-next,
        .sidebar-product .owl-carousel .owl-nav button.owl-prev {
            font-size:1.8rem
        }
        .widget-info ul {
            display:-ms-flexbox;
            display:flex;
            align-items:center;
            -ms-flex-align:center;
            justify-content:space-between;
            -ms-flex-pack:justify;
            flex-wrap:wrap;
            -ms-flex-wrap:wrap;
            margin:0
        }
        aside .widget-info ul {
            display:block
        }
        .widget-info li {
            margin-bottom:2rem
        }
        .widget-info li:not(:last-child) {
            margin-right:2.5rem
        }
        aside .widget-info li:not(:last-child) {
            border-bottom:1px solid rgba(231,231,231,0.8);
            padding-bottom:2.2rem;
            margin-right:0
        }
        .widget-info i {
            min-width:40px;
            margin-right:15px;
            color:#0f43b0;
            font-size:4rem;
            line-height:1
        }
        .widget-info i:before {
            margin:0
        }
        aside .widget-info i {
            margin-left:7px
        }
        .widget-info h4 {
            display:inline-block;
            margin-bottom:0;
            color:#6b7a83;
            font-weight:600;
            font-size:1.4rem;
            line-height:1.286;
            font-family:"Open Sans",sans-serif;
            text-transform:uppercase
        }
        .product-single-collapse {
            line-height:1.9;
            margin-bottom:3.2rem;
            margin-top:-3px
        }
        .product-single-collapse p {
            margin-bottom:1.3rem
        }
        .product-single-collapse .collapse-body-wrapper {
            padding-top:3.1rem;
            padding-bottom:2px
        }
        .product-single-collapse .product-desc-content {
            margin-bottom:1.3rem
        }
        .product-single-collapse .product-desc-content ol,
        .product-single-collapse .product-desc-content ul {
            padding-left:5.8rem;
            margin-bottom:2rem
        }
        .product-single-collapse .product-desc-content li:before {
            left:2.4rem
        }
        .product-collapse-title {
            margin:0;
            font-size:1.4rem;
            line-height:1;
            text-transform:uppercase
        }
        .product-collapse-title a {
            display:flex;
            align-items:center;
            position:relative;
            padding:1.4rem 1.5rem 1.5rem;
            border-bottom:1px solid #ddd;
            color:inherit
        }
        .product-collapse-title a:focus,
        .product-collapse-title a:hover {
            color:inherit;
            text-decoration:none
        }
        .product-collapse-title a:before {
            content:"";
            margin-right:1rem;
            font-family:"porto";
            font-size:2rem;
            font-weight:400
        }
        .product-collapse-title a:after {
            display:block;
            position:absolute;
            bottom:-0.2rem;
            left:0;
            width:100%;
            height:0.2rem;
            transform-origin:left center;
            transform:scale(1,1);
            transition:transform 0.4s;
            background-color:#0f43b0;
            content:""
        }
        .product-collapse-title a.collapsed:before {
            content:""
        }
        .product-collapse-title a.collapsed:after {
            transform-origin:right center;
            transform:scale(0,1)
        }
        .collapse-body-wrapper {
            padding:3rem 0 1.5rem 2rem
        }
        .maga-sale-container {
            font-family:"Oswald";
            position:relative
        }
        .maga-sale-container .mega-content {
            margin:1.1rem;
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            text-align:center;
            border:1px solid #f6f5f0
        }
        .maga-sale-container .mega-price-box {
            position:relative;
            display:flex;
            margin:4.4rem 0.5rem 2.4rem 0;
            align-items:center;
            justify-content:center;
            color:#fff
        }
        .maga-sale-container .mega-price-box .price-big {
            font-size:4rem;
            margin-right:5px;
            z-index:1
        }
        .maga-sale-container .mega-price-box .price-desc {
            display:flex;
            flex-direction:column;
            font-size:1.4rem;
            line-height:1.1;
            z-index:1
        }
        .maga-sale-container .mega-price-box em {
            font-size:1.8rem;
            font-style:unset
        }
        .maga-sale-container .mega-price-box:after,
        .maga-sale-container .mega-price-box:before {
            position:absolute;
            content:"";
            display:block;
            width:94px;
            border:0 solid #0f43b0;
            border-width:50px 0;
            border-bottom-color:transparent;
            border-radius:50%
        }
        .maga-sale-container .mega-price-box:before {
            transform:rotate(-60deg);
            top:-34%
        }
        .maga-sale-container .mega-price-box:after {
            transform:rotate(120deg);
            margin-left:8px;
            top:-41%
        }
        .maga-sale-container .mega-title {
            margin-left:0.8rem;
            transform:scaleX(0.6);
            font-size:3.8rem;
            letter-spacing:0.07em;
            line-height:1.1;
            color:#113952
        }
        .maga-sale-container .mega-subtitle {
            margin-left:0.8rem;
            font-size:1.6rem;
            letter-spacing:0.17em;
            color:#113952
        }
        .custom-maga-sale-container {
            margin-bottom:3.4rem
        }
        .custom-maga-sale-container .mega-price-box {
            margin:4.2rem 0.8rem 3rem 0
        }
        .custom-maga-sale-container .mega-price-box .price-big {
            font-size:4.7rem;
            margin-right:5px;
            margin-top:2px
        }
        .custom-maga-sale-container .mega-price-box .price-desc {
            font-size:1.6rem
        }
        .custom-maga-sale-container .mega-price-box em {
            font-size:2.2rem;
            margin-bottom:1px;
            margin-top:3px
        }
        .custom-maga-sale-container .mega-price-box:after,
        .custom-maga-sale-container .mega-price-box:before {
            width:120px;
            border-width:60px 0
        }
        .custom-maga-sale-container .mega-price-box:after {
            margin-left:9px
        }
        .custom-maga-sale-container .mega-title {
            margin-left:0;
            font-size:4.4rem;
            white-space:nowrap;
            padding-top:4px;
            margin-right:1.5rem
        }
        .custom-maga-sale-container .mega-subtitle {
            font-size:1.9rem;
            margin-left:0;
            letter-spacing:0.1em
        }
        @media (min-width:992px) {
            .main-content-wrap {
                overflow:hidden
            }
            .main-content-wrap .main-content {
                margin-left:-25%;
                transition:0.15s linear
            }
            .main-content-wrap .sidebar-shop {
                left:-25%;
                transition:0.15s linear;
                visibility:hidden;
                z-index:-1
            }
            .sidebar-opened .main-content-wrap>.sidebar-shop {
                left:0;
                visibility:visible;
                z-index:0
            }
            .sidebar-opened .main-content-wrap>.main-content {
                margin-left:0
            }
            body:not(.sidebar-opened) .main-content-wrap>.main-content {
                max-width:100%;
                -ms-flex:0 0 100%;
                flex:0 0 100%
            }
            .sidebar-toggle {
                display:none
            }
        }
        @media (min-width:576px) {
            .sidebar-product .widget.widget-product-categories {
                padding:2.4rem 3rem 2.5rem
            }
        }
        @media (max-width:1199px) {
            .maga-sale-container .mega-title {
                font-size:3rem
            }
            .custom-maga-sale-container .mega-price-box:after,
            .custom-maga-sale-container .mega-price-box:before {
                width:100px;
                border-width:52px 0
            }
            .custom-maga-sale-container .mega-price-box .price-big {
                margin-top:-3px
            }
            .maga-sale-container .mega-title {
                margin-right:0
            }
        }
        @media (max-width:991px) {
            .mobile-sidebar {
                display:block;
                position:fixed;
                top:0;
                bottom:0;
                left:0;
                width:260px;
                padding:2rem;
                margin:0;
                transform:translate(-260px);
                transition:transform 0.2s ease-in-out 0s;
                background-color:#fff;
                z-index:9999;
                overflow-y:auto
            }
            .sidebar-opened .mobile-sidebar {
                transform:none
            }
            .sidebar-opened .sidebar-overlay {
                position:fixed;
                top:0;
                right:0;
                bottom:0;
                left:0;
                background:#000;
                opacity:0.35;
                z-index:8999
            }
        }
        @media (max-width:575px) {
            .widget-info ul {
                display:block
            }
        }
        .section-sub-title,
        .section-title {
            border-bottom:1px solid rgba(0,0,0,0.08);
            color:#313131;
            font-family:"Open Sans",sans-serif;
            font-weight:600;
            font-size:1.6rem;
            line-height:23px;
            text-transform:none
        }
        .banner img {
            object-fit:cover
        }
        .intro-section {
            position:relative
        }
        .home-slide {
            height:532px;
            padding:1.5rem;
            background-position:center;
            background-repeat:no-repeat;
            background-size:cover
        }
        .home-slide h2 {
            color:#444;
            font-family:"Open Sans",sans-serif;
            font-size:1.6875em;
            line-height:1.2;
            letter-spacing:-0.01em
        }
        .home-slide h1 {
            font-size:3.75em;
            line-height:1.2;
            letter-spacing:-0.05em;
            margin-left:-3px;
            margin-bottom:7px
        }
        .home-slide .btn {
            padding:1.25em 3.125em;
            font-family:"Open Sans",sans-serif;
            font-size:1.6rem;
            font-weight:600;
            line-height:1.42857
        }
        .home-slide .banner-layer {
            left:0;
            right:0
        }
        .home-slider-sidebar {
            position:absolute;
            top:50%;
            left:0;
            width:100%;
            transform:translateY(-50%);
            z-index:1
        }
        .home-slider-sidebar ul {
            font-size:1.7rem;
            white-space:nowrap;
            font-weight:600;
            padding:0;
            position:absolute;
            right:20px;
            top:50%;
            margin-top:-63px;
            color:#171f2f
        }
        .home-slider-sidebar li {
            position:relative;
            padding-right:35px;
            margin-bottom:15px;
            text-align:right;
            cursor:pointer;
            line-height:27px
        }
        .home-slider-sidebar li.active {
            color:#ff6840
        }
        .home-slider-sidebar li:after {
            content:"";
            position:absolute;
            right:0;
            top:50%;
            transform:translateY(-50%);
            border-top:2px solid;
            width:16px
        }
        .featured-products-section {
            padding:7rem 0 3.4rem
        }
        .cat-section {
            padding:7rem 0 5rem
        }
        .cat-section .product-category {
            padding:3.9rem 0 3.5rem;
            background:#fff;
            transition:box-shadow 0.2s
        }
        .cat-section .product-category:hover {
            box-shadow:0 5px 25px 0 rgba(0,0,0,0.1)
        }
        .cat-section .product-category:hover i {
            color:#f67434
        }
        .cat-section .product-category:hover h3 {
            color:#ff6840
        }
        .category-content {
            padding:0
        }
        .category-content i {
            margin-bottom:1.5rem;
            color:#222529;
            font-size:4.2rem;
            line-height:1
        }
        .category-content h3 {
            margin-bottom:0;
            font-size:1.5rem;
            font-weight:600;
            text-transform:none
        }
        .categories-slider .owl-stage-outer {
            margin:-1rem;
            padding:1rem
        }
        .new-products-section {
            padding:7rem 0 2.1rem
        }
        .new-products-section .banner,
        .new-products-section .container>.row:last-child {
            margin-bottom:3.5rem
        }
        .banner1 img,
        .banner2 img {
            min-height:190px
        }
        .banner1 h3,
        .banner2 h3 {
            font-size:2.1875em;
            line-height:1.2
        }
        .banner1 h4,
        .banner2 h4 {
            margin-bottom:1.4rem;
            color:#444444;
            font-size:1em;
            line-height:19px
        }
        .banner1 h4 b,
        .banner2 h4 b {
            display:block;
            font-size:1.425em;
            line-height:1.5
        }
        .banner1 .btn,
        .banner2 .btn {
            padding:0.8rem 2rem;
            font-family:"Open Sans",sans-serif;
            font-size:1.2rem
        }
        .banner1 .banner-layer,
        .banner2 .banner-layer {
            left:15px;
            right:15px;
            margin:0
        }
        .special-offer-section {
            padding:7rem 0 2.5rem
        }
        .special-offer-section .subtitle {
            padding:1.6rem 0 1.9rem;
            border-bottom:1px solid #eaeaea;
            font-weight:600;
            font-size:1.8rem;
            line-height:24px
        }
        .special-offer-section .nav-tabs .nav-item .nav-link {
            padding:1.5rem 1.8rem;
            background:transparent;
            border-bottom-width:3px;
            font-family:"Open Sans",sans-serif;
            font-size:1.6rem;
            font-weight:600;
            letter-spacing:-0.01em;
            line-height:1.6875;
            text-transform:none
        }
        .special-offer-section .nav-tabs .nav-item:not(:last-child) {
            margin-right:1px
        }
        .banner3 {
            max-width:450px
        }
        .banner3 img {
            min-height:220px
        }
        .banner3 h3 {
            font-size:1.5em;
            text-indent:-2px
        }
        .banner3 h4 {
            font-size:1.375em;
            font-weight:600
        }
        .banner3 del {
            font-size:80%;
            color:#aeaeae;
            margin-right:7px
        }
        .banner3 .btn {
            padding:1em 2.5em;
            font-family:"Open Sans",sans-serif;
            font-size:1.2rem;
            font-weight:600;
            letter-spacing:-0.01em
        }
        .banner3 .banner-layer-left {
            left:12%;
            margin-top:5px
        }
        .cat-banners-section {
            padding:4.8rem 0 2.8rem
        }
        .cat-banner {
            display:flex;
            align-items:center;
            position:relative;
            margin-bottom:2rem;
            padding:3.2rem;
            border:1px solid #e7e7e7;
            font-size:1.6rem
        }
        .cat-banner figure {
            flex:1;
            margin-bottom:0
        }
        .cat-banner img {
            display:inline-block
        }
        .cat-banner h3 {
            font-family:"Open Sans",sans-serif;
            font-size:1.0625em;
            line-height:20px;
            white-space:nowrap
        }
        .cat-banner .btn {
            font-family:"Open Sans",sans-serif;
            font-size:0.75em;
            letter-spacing:-0.025em;
            padding:0.8rem 2rem
        }
        .cat-banner .cat-content {
            flex:1
        }
        .feature-boxes-container {
            padding:8rem 0 6rem
        }
        .feature-box i {
            margin-bottom:2.7rem;
            font-size:5rem
        }
        .feature-box h3 {
            margin-bottom:3px;
            font-size:1.8rem;
            line-height:1.5
        }
        .feature-box h5 {
            color:#21293c;
            font-weight:600;
            font-size:1.7rem;
            line-height:1.6875
        }
        .feature-box p {
            font-size:1.6rem;
            line-height:1.625
        }
        .product-widgets-container {
            padding:7rem 0 5.5rem
        }
        .product-widgets-container .section-sub-title {
            padding-top:1.6rem
        }
        .product-widgets-container .product-widget figure {
            margin-right:0.7rem
        }
        .product-widgets-container .product-widget .product-title {
            font-family:"Open Sans",sans-serif;
            font-size:0.9em
        }
        .product-widgets-container .product-widget .product-price {
            font-size:1.3rem
        }
        .product-widgets-container .product-widget .old-price {
            color:#444;
            font-size:1.1rem
        }
        .product-widgets-container .product-widget .ratings-container {
            margin-bottom:1rem
        }
        .product-widgets-container.lg-images .product-widget figure {
            max-width:84px;
            margin-right:1.2rem
        }
        .count-down {
            border:3px solid #0f43b0;
            text-align:center;
            position:relative;
            display:flex;
            flex-direction:column;
            width:100%;
            height:100%;
            margin-bottom:2.8rem
        }
        .count-down figure {
            max-width:100%;
            margin-bottom:0;
            margin-right:0
        }
        .count-down .product-name {
            position:absolute;
            left:0;
            right:0;
            top:1.6rem;
            z-index:1;
            margin-bottom:0;
            font-family:"Open Sans",sans-serif;
            font-size:1.6rem;
            line-height:27px
        }
        .count-down .product-details {
            padding:0.4rem 1.6rem 4.8rem
        }
        .count-down .product-title {
            margin-bottom:0.5rem;
            font-family:"Open Sans",sans-serif;
            font-size:1.6rem;
            letter-spacing:-0.01em
        }
        .count-down .ratings-container {
            margin-bottom:1.3rem
        }
        .count-down .old-price {
            letter-spacing:inherit
        }
        .count-down .product-price {
            font-size:1.8rem
        }
        .count-down .label-group {
            left:auto;
            top:-2px;
            right:-2px
        }
        .count-down .product-label {
            border-radius:0
        }
        .count-down .label-primary {
            background-color:#0f43b0;
            font-size:1.6rem;
            font-weight:700;
            letter-spacing:-0.1px;
            line-height:1;
            padding:5px 11px;
            margin-bottom:0
        }
        .count-down .label-dark {
            background-color:#222529;
            font-size:1.4rem;
            font-weight:700;
            letter-spacing:-0.1px;
            line-height:16px
        }
        .count-down:hover {
            box-shadow:none
        }
        .count-down:hover img {
            transform:none
        }
        .count-down .product-countdown-container {
            align-items:center;
            position:absolute;
            bottom:-13rem;
            left:15%;
            right:15%;
            padding:5px;
            color:#444;
            background:#f4f4f4;
            border-radius:3.2rem;
            line-height:27px;
            opacity:1
        }
        .count-down .product-countdown-title {
            color:#444;
            font-family:Oswald,sans-serif;
            font-size:1.1rem;
            letter-spacing:-0.01em;
            text-transform:uppercase
        }
        .count-down .product-countdown {
            color:#444;
            font-size:1.3rem;
            font-family:Oswald,sans-serif;
            letter-spacing:-0.01em
        }
        .brands-slider {
            margin-bottom:4.8rem
        }
        @media (min-width:992px) {
            .banner1 .col-lg-4:first-child,
            .banner2 .col-lg-4:last-child {
                padding-left:3rem
            }
            .banner1 .col-lg-4:last-child {
                padding-left:4rem
            }
            .banner2 .col-lg-4:first-child {
                padding-right:4rem
            }
        }
        @media (min-width:1200px) {
            .cat-banner {
                font-size:0.83333vw
            }
        }
        @media (min-width:1440px) {
            .special-offer-section .nav-tabs .nav-item .nav-link {
                padding-left:2.2rem;
                padding-right:2.2rem
            }
            .cat-banner figure {
                min-width:139px
            }
        }
        .category-banner {
            padding:7rem 0;
            background-position:center;
            background-size:cover;
            font-size:1.6rem
        }
        .category-banner h2 {
            margin-left:-3px;
            margin-bottom:1.7rem;
            font-size:3.25em;
            letter-spacing:-0.05em;
            line-height:48px
        }
        .category-banner h3 {
            font-size:1.5em;
            color:#444444
        }
        .category-banner h4 {
            color:#444;
            font-size:1.25em;
            line-height:normal
        }
        .sidebar-shop .widget-title {
            padding:8px 0;
            letter-spacing:0.05em
        }
        .sidebar-shop .widget-title a:after,
        .sidebar-shop .widget-title a:before {
            right:3px
        }
        .sidebar-shop .widget-body {
            padding-top:2.4rem
        }
        .sidebar-shop .config-swatch-list {
            display:block;
            margin-left:1.5rem;
            margin-top:1.3rem
        }
        .sidebar-shop .config-swatch-list li a {
            margin-bottom:7px;
            width:28px;
            height:28px;
            color:#000;
            font-size:1.2rem;
            line-height:26px;
            text-indent:37px
        }
        .sidebar-shop .config-swatch-list li a:before {
            text-indent:0
        }
        .sidebar-shop .config-swatch-list li a.active,
        .sidebar-shop .config-swatch-list li a:hover {
            color:#0f43b0
        }
        .cat-list {
            padding-left:1.5rem
        }
        .cat-list li {
            color:#000;
            font-size:1.2rem;
            font-weight:400;
            margin-bottom:1.1rem
        }
        .cat-list li a {
            color:inherit;
            font-weight:inherit
        }
        .cat-list .products-count {
            color:#899296
        }
        .cat-sublist {
            margin-left:1.3rem;
            margin-top:1.1rem
        }
        .main-content>.row {
            margin-bottom:1.5rem
        }
        .toolbox label {
            margin-top:-2px
        }
        @media (min-width:992px) {
            .toolbox-pagination {
                margin-bottom:0.7rem
            }
        }
        @media (max-width:991px) {
            .sidebar-shop .widget {
                padding:1.5rem 0
            }
            .sidebar-shop .widget:not(:last-child) {
                border-bottom:0;
                margin-bottom:0
            }
        }
        .product-single-details .product-title {
            margin-bottom:1.2rem
        }
        .product-single-details .ratings-container {
            margin-bottom:2.3rem
        }
        .product-single-details .product-desc {
            line-height:1.6872
        }
        .product-single-details .single-info-list {
            margin-bottom:1.8rem
        }
        .product-single-gallery {
            margin-bottom:3.1rem
        }
        .product-single-tabs .nav.nav-tabs .nav-item .nav-link {
            line-height:1.4
        }
        .product-desc-content li,
        .product-desc-content ul {
            letter-spacing:inherit
        }
        .products-section h2 {
            font-size:1.6rem
        }
        .products-section .product-default.inner-quickview {
            padding:1.4rem 0 0
        }
        .products-section .product-default.inner-quickview:hover {
            box-shadow:none
        }
        .products-section .owl-carousel.dots-top .owl-dots span {
            border-color:rgba(162,59,8,0.4)
        }
        .product-single-container~.product-widgets-container .section-sub-title {
            padding-top:0;
            border-bottom:0;
            color:#222529;
            font-size:1.4rem;
            font-weight:700;
            text-transform:uppercase
        }
        .about .subtitle {
            font-family:"Open Sans",sans-serif;
            letter-spacing:-0.01em;
            line-height:normal
        }
        .about .feature-box i {
            margin-bottom:0.8rem;
            font-size:5.6rem;
            margin-top:4px
        }
        .about .feature-box p {
            font-size:1.5rem;
            line-height:27px
        }
        .about-section p {
            line-height:27px
        }
        .features-section {
            padding-top:5rem
        }
        .testimonials-section {
            padding-top:5rem
        }
        .testimonials-section .subtitle {
            margin-bottom:4.8rem
        }
        .testimonial-owner {
            align-items:center
        }
        .testimonial-owner figure {
            max-width:25px;
            margin-bottom:5px;
            margin-right:27px
        }
        .testimonial-owner span {
            font-size:1.28rem;
            letter-spacing:inherit;
            line-height:16px
        }
        .testimonial blockquote:before {
            font-size:4.8rem
        }
        .count-container .count-wrapper,
        .testimonial blockquote:before {
            color:#ff6840
        }
        .count-container .count-wrapper {
            margin-bottom:1rem
        }
        @media (min-width:768px) {
            .about-section {
                padding-top:3rem
            }
        }
        .contact-two h2 {
            margin-bottom:1.7rem
        }
        .contact-two .contact-title {
            margin-top:1.5rem;
            margin-bottom:1.2rem;
            font-size:1.6rem
        }
        .contact-two p {
            line-height:27px
        }
        .contact-two label {
            margin-bottom:1.2rem
        }
        .contact-two .contact-info i {
            background:#08c
        }
        .contact-two .porto-sicon-title {
            margin-bottom:2px
        }
        .contact-two .contact-time .contact-title {
            margin-bottom:1.3rem
        }
        .contact-two .contact-time .porto-sicon-title {
            margin-top:0;
            margin-bottom:1px
        }
    </style>
    <style>
        ul.resp-tabs-list {
            margin:0;
            padding:0
        }
        .resp-tabs-list li {
            font-weight:600;
            font-size:13px;
            display:inline-block;
            padding:13px 15px;
            margin:0;
            list-style:none;
            cursor:pointer;
            float:left
        }
        .resp-tabs-container {
            padding:0;
            clear:left
        }
        h2.resp-accordion {
            cursor:pointer;
            padding:5px;
            display:none;
            margin:0
        }
        .resp-tab-content {
            display:none;
            padding:15px
        }
        .resp-tab-active {
            border:1px solid #e7e7e7;
            border-bottom:none;
            margin-bottom:-1px!important;
            padding:12px 14px 14px 14px!important
        }
        .resp-tab-active {
            border-bottom:none;
            background-color:#fff
        }
        .resp-accordion-active,
        .resp-content-active {
            display:block
        }
        .resp-tab-content {
            border:1px solid var(--porto-gray-2)
        }
        h2.resp-accordion {
            font-size:13px;
            border:1px solid #e7e7e7;
            border-top:0 solid #e7e7e7;
            margin:0;
            padding:10px 15px
        }
        h2.resp-tab-active {
            border-bottom:0 solid #e7e7e7!important;
            margin-bottom:0!important;
            padding:10px 15px!important
        }
        h2.resp-tab-title:last-child {
            border-bottom:12px solid #e7e7e7!important;
            background:blue
        }
        .resp-vtabs ul.resp-tabs-list {
            float:left;
            width:30%
        }
        .resp-vtabs .resp-tabs-list li {
            display:block;
            padding:15px 15px!important;
            margin:0;
            cursor:pointer;
            float:none
        }
        .resp-vtabs .resp-tabs-container {
            padding:0;
            background-color:#fff;
            border:1px solid #e7e7e7;
            float:left;
            width:68%;
            min-height:250px;
            clear:none
        }
        .resp-vtabs .resp-tab-content {
            border:none
        }
        .resp-vtabs li.resp-tab-active {
            border:1px solid #e7e7e7;
            border-right:none;
            background-color:#fff;
            position:relative;
            z-index:1;
            margin-right:-1px!important;
            padding:14px 15px 15px 14px!important
        }
        .resp-arrow {
            width:0;
            height:0;
            float:right;
            margin-top:3px;
            border-left:6px solid transparent;
            border-right:6px solid transparent;
            border-top:12px solid #e7e7e7
        }
        h2.resp-tab-active span.resp-arrow {
            border:none;
            border-left:6px solid transparent;
            border-right:6px solid transparent;
            border-bottom:12px solid #9B9797
        }
        h2.resp-tab-active {
            background:#DBDBDB!important
        }
        .resp-easy-accordion h2.resp-accordion {
            display:block
        }
        .resp-easy-accordion .resp-tab-content {
            border:1px solid #e7e7e7
        }
        .resp-easy-accordion .resp-tab-content:last-child {
            border-bottom:1px solid #e7e7e7!important
        }
        .resp-jfit {
            width:100%;
            margin:0
        }
        .resp-tab-content-active {
            display:block
        }
        h2.resp-accordion:first-child {
            border-top:1px solid #e7e7e7!important
        }
        @media only screen and (max-width:767px) {
            ul.resp-tabs-list {
                display:none
            }
            h2.resp-accordion {
                display:block
            }
            .resp-vtabs .resp-tab-content {
                border:1px solid #e7e7e7
            }
            .resp-vtabs .resp-tabs-container {
                border:none;
                float:none;
                width:100%;
                min-height:initial;
                clear:none
            }
            .resp-accordion-closed {
                display:none!important
            }
            .resp-vtabs .resp-tab-content:last-child {
                border-bottom:1px solid #e7e7e7!important
            }
        }
        .dokan-error,
        .dokan-info,
        .dokan-message {
            border:none;
            background:none;
            border-radius:0
        }
        .dokan-error:before,
        .dokan-info:before,
        .dokan-message:before {
            left:0;
            background:none;
            font-style:normal;
            padding:0;
            width:auto;
            border-radius:0
        }
        .cart-popup .total,
        .woocommerce-message {
            color:var(--porto-heading-color)
        }
        .dokan-error,
        .dokan-info,
        .dokan-message,
        .woocommerce-error,
        .woocommerce-info,
        .woocommerce-message {
            padding:10px 3px;
            list-style-position:inside;
            text-align:left;
            margin-bottom:10px;
            font-size:16px;
            font-weight:500
        }
        #main>.container>.dokan-error,
        #main>.container>.dokan-info,
        #main>.container>.dokan-message,
        #main>.container>.woocommerce-error,
        #main>.container>.woocommerce-info,
        #main>.container>.woocommerce-message {
            margin-top:10px
        }
        #main>.container-fluid>.dokan-error,
        #main>.container-fluid>.dokan-info,
        #main>.container-fluid>.dokan-message,
        #main>.container-fluid>.woocommerce-error,
        #main>.container-fluid>.woocommerce-info,
        #main>.container-fluid>.woocommerce-message {
            margin-top:20px
        }
        .dokan-error:before,
        .dokan-info:before,
        .dokan-message:before,
        .woocommerce-error:before,
        .woocommerce-info:before,
        .woocommerce-message:before {
            position:relative;
            top:2px;
            margin-right:5px;
            font-size:20px;
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900
        }
        .woocommerce-error {
            color:#6d1a17;
            list-style:none
        }
        .woocommerce-error li {
            padding:5px 0
        }
        .woocommerce-error li:before {
            content:"\f071";
            margin-right:0.5rem;
            color:var(--bs-danger);
            font-size:23px;
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            vertical-align:middle
        }
        .dokan-error {
            color:#6d1a17
        }
        .dokan-error:before {
            content:"\f071";
            color:var(--bs-danger)
        }
        .dokan-message .wc-forward,
        .woocommerce-message .wc-forward {
            margin-right:10px
        }
        .dokan-message:before,
        .woocommerce-message:before {
            content:"\f00c";
            color:#0cc485
        }
        .dokan-info,
        .woocommerce-info {
            color:#2f6473
        }
        .dokan-info:before,
        .woocommerce-info:before {
            content:"\f05a";
            color:var(--info)
        }
        dl.variation {
            margin-bottom:0;
            font-size:0.625rem;
            text-transform:uppercase
        }
        dl.variation p {
            font-size:inherit
        }
        .shop_table dl.variation {
            color:var(--porto-body-color)
        }
        .shop_table {
            border-collapse:collapse;
            border-spacing:0;
            width:100%;
            margin-bottom:1em
        }
        .shop_table a {
            color:inherit
        }
        .shop_table a:not(.button):hover {
            color:var(--porto-primary-color)
        }
        .shop_table dd,
        .shop_table dt {
            display:inline-block;
            margin:0 5px 0 0;
            font-weight:400
        }
        .shop_table dd p {
            font-size:inherit
        }
        .shop_table th {
            text-align:left;
            padding:10px
        }
        .shop_table td {
            text-align:left;
            padding:20px 10px
        }
        .shop_table thead th {
            color:var(--porto-heading-color);
            text-transform:uppercase
        }
        .shop_table thead tr,
        .shop_table tr:not(:last-child) {
            border-bottom:1px solid var(--porto-gray-5)
        }
        .shop_table td.product-name {
            font-weight:500;
            word-break:break-word;
            color:var(--porto-heading-color)
        }
        .shop_table tfoot tr:first-child td,
        .shop_table tfoot tr:first-child th {
            padding:28px 10px 10px
        }
        .shop_table tbody th:first-child,
        .shop_table tfoot th:first-child {
            border-left:none
        }
        .shop_table td.actions {
            padding:20px 0
        }
        @media (max-width:575px) {
            .shop_table td.actions .coupon>* {
                margin-bottom:1rem
            }
        }
        @media (max-width:767px) {
            .shop_table.responsive,
            .shop_table.shop_table_responsive {
                border:1px solid var(--porto-gray-5);
                border-top:4px solid var(--porto-primary-color);
                box-shadow:0 2px 4px 0px rgba(0,0,0,0.05)
            }
            .shop_table.responsive thead,
            .shop_table.shop_table_responsive thead {
                display:none
            }
            .shop_table.responsive tr,
            .shop_table.shop_table_responsive tr {
                display:block;
                padding:20px 0;
                position:relative;
                border-top:1px solid var(--porto-gray-5)
            }
            .shop_table.responsive tr:first-child,
            .shop_table.shop_table_responsive tr:first-child {
                border-top:none
            }
            .shop_table.responsive tfoot th,
            .shop_table.shop_table_responsive tfoot th {
                border:none
            }
            .shop_table.responsive tfoot tr:first-child,
            .shop_table.shop_table_responsive tfoot tr:first-child {
                border-top:1px solid var(--porto-gray-5)
            }
            .shop_table.responsive td,
            .shop_table.responsive th,
            .shop_table.shop_table_responsive td,
            .shop_table.shop_table_responsive th {
                background:transparent;
                text-align:center;
                display:block;
                padding:5px 10px;
                border:none
            }
            .shop_table.responsive td.product-remove,
            .shop_table.responsive th.product-remove,
            .shop_table.shop_table_responsive td.product-remove,
            .shop_table.shop_table_responsive th.product-remove {
                position:absolute;
                right:0;
                top:12px
            }
            .shop_table.responsive td.product-thumbnail,
            .shop_table.responsive th.product-thumbnail,
            .shop_table.shop_table_responsive td.product-thumbnail,
            .shop_table.shop_table_responsive th.product-thumbnail {
                padding-top:10px
            }
        }
        .featured-box .shop_table {
            box-shadow:none;
            border:none
        }
        .featured-box .shop_table th {
            background:transparent;
            border-bottom:none;
            font-weight:600
        }
        .featured-box .shop_table th:first-child,
        .featured-box .shop_table th:last-child,
        .featured-box .shop_table th:only-child {
            border-radius:0
        }
        .featured-box .shop_table td {
            border-left:none
        }
        .featured-box .shop_table tr:last-child td:first-child,
        .featured-box .shop_table tr:last-child td:last-child,
        .featured-box .shop_table tr:last-child td:only-child {
            border-radius:0
        }
        .featured-box .shop_table .product-remove .remove {
            font-size:30px
        }
        .featured-box .shop_table .quantity {
            margin:0;
            width:auto
        }
        .featured-box .shop_table .quantity input.qty {
            border-color:var(--porto-gray-2);
            border-radius:0;
            width:38px;
            height:3rem;
            padding:0 4px
        }
        .featured-box .shop_table .quantity .minus,
        .featured-box .shop_table .quantity .plus {
            width:30px;
            height:3rem;
            border-color:var(--porto-gray-2)
        }
        .featured-box .shop_table .coupon {
            margin-top:16px;
            width:50%
        }
        .featured-box .shop_table .coupon label {
            display:none
        }
        .featured-box .shop_table .coupon #coupon_code {
            max-width:280px
        }
        .featured-box .shop_table .actions,
        .featured-box .shop_table .cart-actions {
            margin-top:8px;
            padding-bottom:10px
        }
        .featured-box .shop_table .actions button,
        .featured-box .shop_table .actions input,
        .featured-box .shop_table .cart-actions button,
        .featured-box .shop_table .cart-actions input {
            margin-bottom:15px
        }
        @media (max-width:991px) {
            .featured-box .shop_table .coupon {
                width:100%
            }
            .featured-box .shop_table .pt-left,
            .featured-box .shop_table .pt-right {
                float:none!important;
                text-align:center
            }
        }
        .order-again .button {
            padding:0 1.5rem
        }
        .btn-go-shop {
            min-width:200px;
            padding:16px 0;
            font-size:15px;
            letter-spacing:-0.015em;
            text-align:center
        }
        .wc-action-btn.wc-action-sm {
            font-size:13px;
            letter-spacing:-0.015em
        }
        .btn-v-dark,
        .order-again .button,
        .wc-action-btn.button {
            font-weight:700;
            text-transform:uppercase
        }
        .order-again .button,
        .wc-action-btn.button,
        .wc-action-btn.button:disabled,
        .wishlist_table .add-links .quickview,
        .wishlist_table .add-links .yith-compare {
            background:var(--porto-gray-3);
            color:var(--porto-heading-color);
            border:none
        }
        .order-again .button:hover,
        .wc-action-btn.button:hover {
            background:var(--porto-gray-8)
        }
        .wc-action-btn.button:disabled {
            opacity:0.8
        }
        .text-v-dark {
            color:var(--porto-heading-color)!important
        }
        .cart-popup .button.checkout,
        .wishlist_table .add_to_cart.button,
        html .btn-v-dark {
            background:var(--porto-heading-color);
            color:var(--porto-body-bg);
            border:none
        }
        .cart-popup .button.checkout:focus,
        .wishlist_table .add_to_cart.button:focus,
        html .btn-v-dark:focus {
            outline:none;
            box-shadow:none;
            color:var(--porto-body-bg)
        }
        .cart-popup .button.checkout:hover,
        .wishlist_table .add_to_cart.button:hover,
        html .btn-v-dark:hover {
            background:var(--porto-heading-light-8);
            color:var(--porto-body-bg)
        }
        @media (min-width:992px) {
            .order-info,
            .woocommerce-order-details {
                width:90%
            }
        }
        .order-info .order-item {
            width:20%;
            font-size:13px;
            line-height:24px;
            text-align:center
        }
        @media (max-width:767px) {
            .order-info .order-item {
                width:33.3333%;
                margin-bottom:2rem
            }
        }
        @media (max-width:575px) {
            .order-info .order-item {
                width:50%
            }
        }
        .checkout-order-review .cart-subtotal,
        .checkout-order-review tbody .amount,
        .order_details tbody .amount {
            color:#777;
            font-weight:500
        }
        .checkout-order-review tr td:last-child,
        .order_details tr td:last-child {
            text-align:right
        }
        .order_details tbody tr.order_item {
            line-height:20px;
            border-bottom-width:0
        }
        .order_details tbody tr.order_item td {
            padding-top:9px;
            padding-bottom:0
        }
        .order_details tbody td.product-name {
            padding-top:9px
        }
        .order_details tfoot tr {
            padding:5px 0
        }
        .order_details tfoot tr td {
            color:#777;
            font-weight:500
        }
        .order_details tfoot tr:last-child h4 {
            font-size:16px
        }
        .order_details tfoot tr:last-child .amount {
            font-size:22px;
            font-weight:700;
            color:var(--porto-heading-color)
        }
        .order_details .product-name a {
            color:var(--porto-heading-color)
        }
        .order_details .wc-item-meta {
            padding-left:5px;
            margin-bottom:0
        }
        .order_details .wc-item-meta li {
            display:flex;
            font-size:12px;
            color:#999
        }
        .order_details .wc-item-meta strong {
            margin-right:10px
        }
        .order_details .wc-item-meta p,
        .order_details .wc-item-meta strong {
            font-weight:500
        }
        .featured-box .cart-actions {
            margin-top:8px;
            margin-bottom:20px
        }
        .woocommerce-thankyou-order-received {
            padding:36px 0;
            font-size:18px;
            font-weight:700;
            letter-spacing:-0.025em;
            border:2px solid #0cc485;
            text-align:center;
            color:var(--porto-heading-color)
        }
        .success-message i,
        .woocommerce-thankyou-order-received i {
            color:#0cc485
        }
        .woocommerce-thankyou .woocommerce-order-details {
            width:100%
        }
        #login-form-popup .account-sub-title,
        .woocommerce-account .account-sub-title,
        .woocommerce-checkout .account-sub-title,
        .woocommerce-thankyou .account-sub-title {
            font-size:22px;
            font-weight:700;
            letter-spacing:-0.01em
        }
        #login-form-popup .account-sub-title i,
        .woocommerce-account .account-sub-title i,
        .woocommerce-checkout .account-sub-title i,
        .woocommerce-thankyou .account-sub-title i {
            font-size:35px
        }
        #login-form-popup .featured-boxes,
        .woocommerce-account .featured-boxes,
        .woocommerce-checkout .featured-boxes,
        .woocommerce-thankyou .featured-boxes {
            border:2px solid var(--porto-gray-5)
        }
        .woocommerce-cart h4,
        .woocommerce-checkout h4,
        .woocommerce-order-details h4 {
            letter-spacing:-0.01em;
            font-size:14px;
            font-weight:600
        }
        .woocommerce-cart .card-sub-title,
        .woocommerce-checkout .card-sub-title,
        .woocommerce-order-details .card-sub-title {
            font-weight:700
        }
        .u-column1.col-1 {
            max-width:none;
            flex:none;
            padding-left:0;
            padding-right:0
        }
        .col2-set {
            margin:0 calc(var(--porto-column-spacing) * -1)
        }
        .col2-set:after {
            content:" ";
            display:table;
            clear:both
        }
        .col2-set .col-1,
        .col2-set .col-2 {
            width:50%;
            max-width:none;
            flex:none
        }
        .col2-set .col-1,
        .col2-set .col-12,
        .col2-set .col-2 {
            padding:0 var(--porto-column-spacing)
        }
        .col2-set .col-1 {
            float:left
        }
        .col2-set .col-2 {
            float:right
        }
        @media (max-width:991px) {
            .col2-set .col-1,
            .col2-set .col-2 {
                float:none;
                width:100%
            }
        }
        .chosen-container-single .chosen-single,
        .select2-container .select2-choice,
        .woocommerce-checkout .form-row .chosen-container-single .chosen-single {
            background:var(--porto-normal-bg);
            border-color:var(--porto-gray-5);
            height:34px;
            line-height:28px;
            padding:3px 8px
        }
        .chosen-container-active.chosen-with-drop .chosen-single,
        .chosen-container-single .chosen-single {
            box-shadow:0 1px 1px rgba(0,0,0,0.075) inset
        }
        .chosen-container-single .chosen-single div b,
        .woocommerce-checkout .form-row .chosen-container-single .chosen-single div b {
            background-position:0 7px!important
        }
        .chosen-container-active.chosen-with-drop .chosen-single div b,
        .woocommerce-checkout .form-row .chosen-container-active.chosen-with-drop .chosen-single div b {
            background-position:-18px 7px!important
        }
        .select2-container .select2-choice {
            box-shadow:0 1px 1px rgba(0,0,0,0.075) inset;
            color:var(--porto-body-color)
        }
        .chosen-container-active.chosen-with-drop .chosen-single,
        .select2-container-active .select2-choice {
            border-color:var(--porto-gray-5);
            box-shadow:0 1px 1px rgba(0,0,0,0.075) inset
        }
        .select2-drop,
        .select2-drop-active {
            margin-top:-2px;
            border-color:var(--porto-gray-5);
            color:var(--porto-body-color)
        }
        .select2-drop .select2-search,
        .select2-drop-active .select2-search {
            padding-top:4px
        }
        .select2-drop .select2-results,
        .select2-drop-active .select2-results {
            font-size:0.9em;
            background-color:var(--porto-normal-bg)
        }
        .select2-drop .select2-results li,
        .select2-drop-active .select2-results li {
            line-height:20px
        }
        .form-row {
            margin-bottom:15px;
            vertical-align:top
        }
        .form-row:not(.row) {
            display:block;
            margin-left:0;
            margin-right:0
        }
        .form-row label {
            display:block
        }
        .form-row label.checkbox {
            display:inline-block
        }
        .form-row label.inline {
            display:inline
        }
        .form-row .required {
            border:none;
            cursor:default;
            color:#c10000
        }
        .form-row input[type=color],
        .form-row input[type=date],
        .form-row input[type=datetime-local],
        .form-row input[type=datetime],
        .form-row input[type=email],
        .form-row input[type=month],
        .form-row input[type=number],
        .form-row input[type=password],
        .form-row input[type=search],
        .form-row input[type=tel],
        .form-row input[type=text],
        .form-row input[type=time],
        .form-row input[type=url],
        .form-row input[type=week],
        .form-row select,
        .form-row textarea {
            width:100%;
            background-color:var(--porto-normal-bg);
            color:var(--porto-body-color)
        }
        .form-row-wide {
            width:100%
        }
        .form-row-first {
            float:left;
            width:50%;
            padding-right:10px
        }
        @media (max-width:767px) {
            .form-row-first {
                float:none;
                width:100%;
                padding-right:0
            }
        }
        .form-row-last {
            float:right;
            width:50%;
            padding-left:10px
        }
        @media (max-width:767px) {
            .form-row-last {
                float:none;
                width:100%;
                padding-left:0
            }
        }
        header.title {
            position:relative
        }
        header.title:after {
            content:" ";
            display:table;
            clear:both
        }
        header.title h3 {
            float:left;
            margin-bottom:15px
        }
        header.title .edit {
            float:right;
            margin-bottom:15px
        }
        form.global-login label.inline {
            display:inline-block;
            margin:0;
            vertical-align:middle
        }
        form.global-login #rememberme {
            margin-left:10px
        }
        .wcml-switcher {
            position:relative
        }
        .wcml-switcher h5 {
            cursor:pointer!important
        }
        .wcml-switcher li.loading {
            display:inline-block!important;
            position:absolute!important;
            z-index:1;
            top:0;
            bottom:0;
            left:0;
            right:0;
            opacity:0.3;
            cursor:wait;
            background-color:var(--porto-normal-bg)
        }
        p.demo_store {
            position:fixed;
            bottom:0;
            left:0;
            right:0;
            margin:0;
            width:100%;
            font-size:1em;
            padding:1em 0;
            text-align:center;
            background-color:#000;
            color:#fff;
            z-index:99998;
            box-shadow:0 1px 1em rgba(0,0,0,0.2)
        }
        body.woocommerce-page .main-content .featured-box {
            margin-top:0;
            margin-bottom:30px
        }
        body.woocommerce-page .card-body .featured-box {
            margin-bottom:0
        }
        .account-text-user {
            color:var(--porto-heading-color)
        }
        .overlay-vendor-effect {
            background:rgba(0,0,0,0.4);
            padding-bottom:1px
        }
        .vendor-profile-bg {
            background:#d41b1b;
            color:#fff;
            text-align:center;
            margin-bottom:20px
        }
        .vendor-profile-bg h1 a {
            text-align:center;
            color:#fff;
            font-size:26px;
            font-weight:bold;
            text-transform:capitalize
        }
        .vendor-profile-bg p {
            font-weight:700;
            text-align:center;
            font-size:14px;
            margin:10px
        }
        .vendor_userimg img {
            border-radius:100px;
            margin:20px 0px
        }
        .footer form {
            opacity:1
        }
        #header .header-top,
        .welcome-msg {
            font-weight:600
        }
        #header .header-top .top-links:last-child>li.menu-item:last-child>a {
            padding-right:0
        }
        #header .header-top .top-links:last-child>li.menu-item:last-child:after {
            display:none
        }
        .porto-wide-sub-menu li.menu-item li.menu-item>a:hover {
            background:none;
            color:var(--porto-mainmenu-popup-text-color-hover,var(--porto-mainmenu-popup-text-color-regular,var(--porto-body-color)))
        }
        #header .porto-wide-sub-menu .menu-item>a:hover {
            text-decoration:underline
        }
        .porto-wide-sub-menu>li.sub {
            --porto-wide-subitem-pd:15px 10px 0
        }
        #header .main-menu .popup {
            left:-15px
        }
        #header .main-menu .narrow.pos-right .popup {
            right:-15px;
            left:auto
        }
        .sidebar-menu .wide .popup {
            border-left:none
        }
        .sidebar-menu .wide .popup>.inner {
            margin-left:0
        }
        .sidebar-menu .popup:before {
            content:"";
            position:absolute;
            border-right:12px solid var(--porto-body-bg);
            border-top:10px solid transparent;
            border-bottom:10px solid transparent;
            left:-12px;
            top:calc(13px + -1 * var(--porto-sd-menu-popup-top, 0px));
            z-index:112
        }
        .price {
            line-height:1;
            font-weight:600;
            font-size:2.5714em
        }
        .price,
        td.order-total,
        td.product-subtotal,
        td.product-total,
        tr.cart-subtotal,
        tr.order-total {
            color:var(--porto-color-price)
        }
        .price .price,
        td.order-total .price,
        td.product-price .price,
        td.product-subtotal .price,
        td.product-total .price,
        tr.cart-subtotal .price {
            font-size:1em
        }
        .price .currency,
        .price .decimal,
        td.order-total .currency,
        td.order-total .decimal,
        td.product-price .currency,
        td.product-price .decimal,
        td.product-subtotal .currency,
        td.product-subtotal .decimal,
        td.product-total .currency,
        td.product-total .decimal,
        tr.cart-subtotal .currency,
        tr.cart-subtotal .decimal {
            font-size:0.75em;
            font-weight:400
        }
        .price .currency .decimal,
        td.order-total .currency .decimal,
        td.product-price .currency .decimal,
        td.product-subtotal .currency .decimal,
        td.product-total .currency .decimal,
        tr.cart-subtotal .currency .decimal {
            font-size:1em
        }
        .price ins,
        td.order-total ins,
        td.product-price ins,
        td.product-subtotal ins,
        td.product-total ins,
        tr.cart-subtotal ins {
            display:inline-block;
            text-decoration:none;
            vertical-align:baseline
        }
        .price .from,
        .price del,
        td.order-total .from,
        td.order-total del,
        td.product-price .from,
        td.product-price del,
        td.product-subtotal .from,
        td.product-subtotal del,
        td.product-total .from,
        td.product-total del,
        tr.cart-subtotal .from,
        tr.cart-subtotal del {
            display:inline-block;
            color:#a7a7a7;
            font-size:0.8em;
            margin-right:0.2143em;
            vertical-align:baseline
        }
        div.quantity {
            display:inline-flex;
            position:relative;
            text-align:left;
            vertical-align:middle
        }
        div.quantity.hidden {
            display:none!important
        }
        div.quantity .qty {
            -moz-appearance:textfield;
            text-align:center;
            width:2.5em;
            height:36px;
            padding-left:0;
            padding-right:0;
            background:none;
            border-color:var(--porto-gray-2);
            font-weight:700
        }
        div.quantity .minus,
        div.quantity .plus {
            position:relative;
            width:2em;
            height:36px;
            line-height:1;
            border:1px solid var(--porto-gray-2);
            padding:0;
            outline:none;
            text-indent:-9999px;
            background:none;
            color:var(--porto-heading-color)
        }
        div.quantity .minus:hover,
        div.quantity .plus:hover {
            color:var(--porto-primary-color)
        }
        div.quantity .minus:before,
        div.quantity .plus:before {
            content:"";
            position:absolute;
            left:50%;
            top:50%;
            width:9px;
            border-top:1px solid;
            margin-top:-0.5px;
            margin-left:-4.5px
        }
        div.quantity .plus {
            left:-1px
        }
        div.quantity .plus:after {
            content:"";
            position:absolute;
            left:50%;
            top:50%;
            height:9px;
            border-left:1px solid;
            margin-top:-4.5px;
            margin-left:-0.5px
        }
        div.quantity .minus {
            left:1px
        }
        .quantity .qty {
            font-family:var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif;
            color:var(--porto-heading-color)
        }
        .product-image {
            display:block;
            position:relative;
            border:none;
            width:100%;
            padding:0
        }
        .product-image:hover {
            z-index:1
        }
        .product-image .inner {
            display:block;
            overflow:hidden;
            position:relative
        }
        .product-image img {
            display:inline-block;
            width:100%;
            height:auto;
            transition:opacity 0.3s,transform 2s cubic-bezier(0,0,0.44,1.18);
            transform:translateZ(0)
        }
        .product-image .viewcart {
            font-size:1.25rem;
            color:var(--porto-primary-color);
            border-radius:50%;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            right:0;
            margin:auto;
            z-index:3;
            text-align:center;
            width:2.2em;
            height:2.2em;
            line-height:2.1em;
            display:none;
            opacity:0;
            transition:0.25s
        }
        .product-image .viewcart:before {
            font-family:"Simple-Line-Icons";
            content:"\e04e"
        }
        .product-image .viewcart:hover {
            background-color:var(--porto-primary-color);
            color:#fff
        }
        .product-image .labels {
            line-height:1;
            color:#fff;
            font-weight:600;
            text-transform:uppercase;
            position:absolute;
            z-index:2;
            top:0.8em;
            font-size:10px;
            left:0.8em;
            text-align:center
        }
        .product-image .labels .onhot,
        .product-image .labels .onnew,
        .product-image .labels .onsale {
            padding:5px 11px;
            margin-bottom:5px
        }
        .product-image .labels .onnew {
            background:-webkit-linear-gradient(-405deg,var(--porto-new-bgc,#08c) 0,var(--porto-new-bgc,#0169fe) 80%);
            background:linear-gradient(135deg,var(--porto-new-bgc,#08c) 0,var(--porto-new-bgc,#0169fe) 80%)
        }
        .product-image .labels .tooltip {
            font-weight:normal;
            text-transform:none;
            white-space:nowrap;
            z-index:100
        }
        .product-image .stock {
            position:absolute;
            z-index:1;
            background:var(--porto-label-bg1);
            color:var(--porto-heading-color);
            top:0;
            bottom:0;
            left:0;
            right:0;
            width:10em;
            height:3em;
            line-height:3em;
            margin:auto;
            font-weight:600;
            text-transform:uppercase;
            text-align:center;
            transition:0.25s
        }
        .product-image,
        .product-image .stock,
        .product-image .viewcart {
            background:var(--porto-normal-bg)
        }
        .yith-wcbm-badge {
            margin:0
        }
        .yith-wcbm-badge img {
            margin:0!important;
            border-radius:0;
            opacity:1!important
        }
        .products .yith-wcbm-badge {
            margin:0
        }
        .products .yith-wcbm-badge img {
            margin:0!important
        }
        .product-image .labels .onhot,
        .summary-before .labels .onhot {
            background:var(--porto-hot-color,#62b959);
            color:var(--porto-hot-color-inverse,#fff)
        }
        .product-image .labels .onsale,
        .summary-before .labels .onsale {
            background:var(--porto-sale-color,#e27c7c);
            color:var(--porto-sale-color-inverse,#fff)
        }
        .add-links .add_to_cart_button,
        .add-links .add_to_cart_read_more,
        .add-links-wrap .quickview,
        .product-image .yith-compare,
        .yith-wcwl-add-to-wishlist a,
        .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            position:relative;
            display:inline-block;
            cursor:pointer;
            font-size:inherit;
            text-align:center;
            vertical-align:top;
            transition:opacity 0.25s,background-color 0.25s,color 0.25s,border-color 0.25s,left 0.25s,right 0.25s;
            background-color:var(--porto-shop-add-links-bg-color);
            border:1px solid var(--porto-shop-add-links-border-color,transparent);
            color:var(--porto-shop-add-links-color,#212529)
        }
        .add-links-wrap .quickview:before,
        .yith-wcwl-add-to-wishlist a:before,
        .yith-wcwl-add-to-wishlist span:before {
            display:inline-block
        }
        .add-links .button:focus,
        .add-links .button:hover,
        .add-links .quickview:hover,
        .product-image .yith-compare:hover,
        .yith-wcwl-add-to-wishlist a:hover,
        li.product-default:hover .add-links .add_to_cart_button,
        li.product-default:hover .add-links .add_to_cart_read_more {
            background-color:var(--porto-primary-color);
            border-color:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse,#fff)
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist a,
        .product-summary-wrap .yith-wcwl-add-to-wishlist a:hover,
        .product-summary-wrap .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            background:none;
            border:none
        }
        .add-links .add_to_cart_button,
        .add-links .add_to_cart_read_more,
        .add-links .yith-compare {
            padding:0 0.625rem;
            font-size:0.75rem;
            font-weight:600;
            text-transform:uppercase;
            z-index:1;
            white-space:nowrap
        }
        .add-links .add_to_cart_button:before,
        .add-links .add_to_cart_read_more:before,
        .add-links .yith-compare:before {
            content:"\f061";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            margin-right:5px;
            position:relative;
            float:left
        }
        .add-links .yith-compare:before {
            content:"\e810";
            font-family:"porto"
        }
        .add-links .yith-compare.added:before {
            content:"\f00c";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            line-height:36px
        }
        .product-type-simple .add-links .add_to_cart_button:before {
            font-family:"Porto";
            content:"\e8ba";
            font-size:1rem;
            font-weight:600;
            font-size:0.9375rem
        }
        .add-links .add_to_cart_button.loading.viewcart-style-1:after {
            content:"";
            opacity:0.5;
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            background:var(--porto-normal-bg)
        }
        .add-links .add_to_cart_button,
        .add-links .add_to_cart_read_more,
        .add-links .quickview,
        .add-links .yith-compare {
            height:36px;
            line-height:34px;
            min-width:36px
        }
        .yith-wcwl-add-to-wishlist {
            margin-top:0;
            line-height:1;
            vertical-align:top
        }
        .yith-wcwl-add-to-wishlist a,
        .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            width:36px;
            height:36px;
            line-height:34px;
            padding:0;
            text-indent:-9999em
        }
        .yith-wcwl-add-to-wishlist a:before,
        .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip):before {
            position:absolute;
            left:0;
            right:0;
            top:0;
            text-indent:0;
            font-size:1rem;
            font-family:"Porto"
        }
        .yith-wcwl-add-to-wishlist a:before,
        .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            vertical-align:middle
        }
        .yith-wcwl-add-to-wishlist .add_to_wishlist:before {
            content:"\e889"
        }
        .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a.view-wishlist:before,
        .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,
        .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before {
            content:"\e88a";
            color:var(--porto-sale-color,#e27c7c)
        }
        .yith-wcwl-add-to-wishlist .delete_item:before {
            content:"\e88a"
        }
        .yith-wcwl-add-to-wishlist a i,
        .yith-wcwl-add-to-wishlist+.clear {
            display:none
        }
        .yith-wcwl-add-to-wishlist .feedback,
        .yith-wcwl-add-to-wishlist img.ajax-loading {
            display:none!important
        }
        .product-layout-image .yith-wcwl-add-to-wishlist .yith-wcwl-add-button>a:first-child,
        .product-layout-image .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse>a,
        .summary-before .yith-wcwl-add-to-wishlist .yith-wcwl-add-button>a:first-child,
        .summary-before .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse>a {
            padding-left:20px
        }
        .product-layout-image .yith-wcwl-add-to-wishlist .yith-wcwl-add-button>a:first-child:before,
        .product-layout-image .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse>a:before,
        .summary-before .yith-wcwl-add-to-wishlist .yith-wcwl-add-button>a:first-child:before,
        .summary-before .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse>a:before {
            right:unset
        }
        .product-layout-image .yith-wcwl-add-to-wishlist a,
        .product-layout-image .yith-wcwl-add-to-wishlist span,
        .summary-before .yith-wcwl-add-to-wishlist a,
        .summary-before .yith-wcwl-add-to-wishlist span {
            width:unset;
            text-indent:unset
        }
        .product-layout-image .yith-wcwl-add-to-wishlist a:hover,
        .summary-before .yith-wcwl-add-to-wishlist a:hover {
            color:var(--porto-primary-color);
            background-color:var(--porto-primary-color-inverse,#fff);
            border-color:var(--porto-primary-color-inverse,#fff)
        }
        li.product-outimage_aq_onimage .add-links .quickview {
            background-color:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse,#fff)
        }
        .add-links .quickview {
            width:36px;
            text-indent:-9999px;
            text-transform:uppercase;
            font-size:13px
        }
        .add-links .quickview:before {
            content:"\f35d";
            position:absolute;
            left:0;
            right:0;
            top:0;
            text-indent:0;
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-size:1.1em;
            font-weight:900
        }
        .add-links .quickview.loading:after {
            content:"";
            opacity:0.5;
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            background-color:var(--porto-normal-bg)
        }
        .single-add-to-cart .type-product .single_add_to_cart_button:before {
            content:none
        }
        .single-add-to-cart .type-product .single_add_to_cart_button:after {
            content:"\f00c";
            margin-left:10px;
            font-size:16px;
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900
        }
        #comments h2 {
            margin-top:0
        }
        .commentlist {
            list-style:none;
            margin:15px 0;
            padding:0
        }
        .commentlist:after {
            content:" ";
            display:table;
            clear:both
        }
        .commentlist li {
            clear:both;
            margin-bottom:20px
        }
        .commentlist li:last-child {
            margin-bottom:0
        }
        @media (max-width:575px) {
            .commentlist li .comment_container {
                background:var(--porto-title-bgc);
                padding:10px 10px 15px
            }
        }
        .commentlist li .comment-text {
            padding:20px;
            position:relative;
            background:var(--porto-title-bgc)
        }
        @media (max-width:575px) {
            .commentlist li .comment-text {
                padding:0;
                background:transparent
            }
        }
        .commentlist li .comment-text p {
            font-size:0.9em;
            line-height:21px;
            margin:0;
            padding:0
        }
        .commentlist li .comment-text .meta {
            font-size:1em;
            margin:0
        }
        .commentlist li .comment-text .meta strong {
            display:inline-block;
            line-height:21px;
            margin:0;
            padding:0 0 5px 0
        }
        @media (max-width:575px) {
            .commentlist li .comment-text .meta strong {
                display:block;
                padding-bottom:0
            }
        }
        .commentlist li .comment-text .meta time {
            color:#999;
            font-size:0.9em
        }
        .comment-reply-title {
            font-size:1.4em;
            font-weight:400;
            line-height:27px;
            margin:0 0 14px 0
        }
        .comment-form-rating label {
            display:inline-block;
            margin-right:10px;
            margin-bottom:0
        }
        .comment-form-rating .stars {
            display:inline-block;
            position:relative;
            top:-0.5em;
            white-space:nowrap
        }
        .comment-form-rating .stars span a {
            position:absolute;
            top:0;
            left:0;
            font-size:14px;
            text-indent:-9999em;
            transition:0.2s
        }
        .comment-form-rating .stars span a:before {
            color:#706f6c;
            content:"";
            position:absolute;
            left:0;
            height:24px;
            text-indent:0;
            letter-spacing:1px
        }
        .comment-form-rating .stars span a:hover:before {
            color:#706f6c
        }
        .comment-form-rating .stars .star-1 {
            z-index:10
        }
        .comment-form-rating .stars .star-1:before {
            width:17px
        }
        .comment-form-rating .stars .star-1.active:before,
        .comment-form-rating .stars .star-1:hover:before {
            content:"\f005"
        }
        .comment-form-rating .stars .star-2 {
            z-index:9
        }
        .comment-form-rating .stars .star-2:before {
            width:34px
        }
        .comment-form-rating .stars .star-2.active:before,
        .comment-form-rating .stars .star-2:hover:before {
            content:"\f005" "\f005"
        }
        .comment-form-rating .stars .star-3 {
            z-index:8
        }
        .comment-form-rating .stars .star-3:before {
            width:51px
        }
        .comment-form-rating .stars .star-3.active:before,
        .comment-form-rating .stars .star-3:hover:before {
            content:"\f005" "\f005" "\f005"
        }
        .comment-form-rating .stars .star-4 {
            z-index:7
        }
        .comment-form-rating .stars .star-4:before {
            width:68px
        }
        .comment-form-rating .stars .star-4.active:before,
        .comment-form-rating .stars .star-4:hover:before {
            content:"\f005" "\f005" "\f005" "\f005"
        }
        .comment-form-rating .stars .star-5 {
            z-index:6
        }
        .comment-form-rating .stars .star-5:before {
            content:"\f005" "\f005" "\f005" "\f005" "\f005";
            font-weight:400
        }
        .comment-form-rating .stars .star-5.active:before,
        .comment-form-rating .stars .star-5:hover:before {
            font-weight:900
        }
        #yith-wcwl-popup-message {
            border-width:4px 0 0;
            border-color:var(--porto-primary-color);
            font-weight:600;
            line-height:1.5;
            color:var(--porto-body-color);
            padding:15px 20px;
            width:250px;
            margin-left:-125px!important;
            background:var(--porto-body-bg);
            border-radius:0;
            box-shadow:0 0 5px rgba(0,0,0,0.5)
        }
        .yith-wcan-sort-by ul.orderby li.orderby-wrapper a.active,
        a.yith-wcan-instock-button.active,
        a.yith-wcan-onsale-button.active,
        a.yith-wcan-price-link.active,
        ul.yith-wcan-list li.chosen a {
            position:relative;
            padding-left:16px!important
        }
        .yith-wcan-sort-by ul.orderby li.orderby-wrapper a.active:after,
        .yith-wcan-sort-by ul.orderby li.orderby-wrapper a.active:before,
        a.yith-wcan-instock-button.active:after,
        a.yith-wcan-instock-button.active:before,
        a.yith-wcan-onsale-button.active:after,
        a.yith-wcan-onsale-button.active:before,
        a.yith-wcan-price-link.active:after,
        a.yith-wcan-price-link.active:before,
        ul.yith-wcan-list li.chosen a:after,
        ul.yith-wcan-list li.chosen a:before {
            content:"";
            position:absolute;
            color:#777;
            top:50%
        }
        .yith-wcan-sort-by ul.orderby li.orderby-wrapper a.active:before,
        a.yith-wcan-instock-button.active:before,
        a.yith-wcan-onsale-button.active:before,
        a.yith-wcan-price-link.active:before,
        ul.yith-wcan-list li.chosen a:before {
            width:11px;
            left:0;
            margin-top:-1px;
            border-top:1px solid;
            -webkit-transform:rotateZ(45deg);
            transform:rotateZ(45deg)
        }
        .yith-wcan-sort-by ul.orderby li.orderby-wrapper a.active:after,
        a.yith-wcan-instock-button.active:after,
        a.yith-wcan-onsale-button.active:after,
        a.yith-wcan-price-link.active:after,
        ul.yith-wcan-list li.chosen a:after {
            height:11px;
            left:5px;
            -webkit-transform:translateY(-50%) rotateZ(45deg);
            transform:translateY(-50%) rotateZ(45deg);
            border-left:1px solid
        }
        .single_variation_wrap .variations_button>.warranty_info {
            margin:0 0.5rem 5px 0
        }
        .single_variation_wrap .variations_button #wc-stripe-payment-request-button-separator,
        .single_variation_wrap .variations_button #wc-stripe-payment-request-wrapper {
            width:100%
        }
        .filter-item-list,
        .single-product form.cart:not(.variations_form),
        .single_variation_wrap .variations_button {
            display:flex;
            flex-wrap:wrap;
            align-items:center
        }
        .product_title {
            font-size:2em;
            font-weight:600;
            margin-bottom:0.5em;
            color:var(--porto-color-price)
        }
        .product_title a {
            color:inherit
        }
        .product_title a:focus,
        .product_title a:hover {
            color:var(--porto-primary-color)
        }
        .product_title.show-product-nav {
            width:calc(100% - 52px)
        }
        .product-nav {
            position:absolute;
            top:0;
            margin-top:calc(1.125rem - 14px);
            right:10px;
            z-index:1
        }
        .product-nav:after {
            content:" ";
            display:table;
            clear:both
        }
        .product-nav .product-next,
        .product-nav .product-prev {
            float:left;
            margin-left:0.125rem
        }
        .product-nav .product-next:hover .product-popup,
        .product-nav .product-prev:hover .product-popup {
            display:block
        }
        .product-nav a {
            display:block;
            color:var(--porto-heading-color)
        }
        .product-nav a:focus,
        .product-nav a:hover {
            color:var(--porto-heading-color)
        }
        .product-nav .product-link {
            font-size:16px;
            width:28px;
            height:28px;
            line-height:23px;
            border:2px solid var(--porto-gray-2);
            border-radius:14px;
            display:inline-block;
            text-align:center;
            font-family:"porto"
        }
        .product-nav .product-link.disabled {
            cursor:default;
            opacity:0.5
        }
        .product-nav .product-prev .product-link:before {
            content:"\e819"
        }
        .product-nav .product-prev .product-popup:before {
            right:36px
        }
        .product-nav .product-next .product-link:before {
            content:"\e81a"
        }
        .product-nav .product-next .product-popup:before {
            right:7px
        }
        .product-nav .featured-box {
            display:block;
            margin:0;
            text-align:left;
            border-width:0;
            box-shadow:0 5px 8px rgba(0,0,0,0.15)
        }
        .product-nav .featured-box .box-content {
            display:block;
            padding:10px
        }
        .product-nav .featured-box .box-content:after {
            content:" ";
            display:table;
            clear:both
        }
        .product-nav .product-popup {
            display:none;
            position:absolute;
            top:32px;
            right:0;
            font-size:0.9286em;
            z-index:999
        }
        .product-nav .product-popup:before {
            border-bottom:7px solid var(--porto-heading-color);
            border-left:7px solid transparent!important;
            border-right:7px solid transparent!important;
            content:"";
            position:absolute;
            top:-5px
        }
        .page-top .product-nav .product-popup {
            color:var(--porto-body-color)
        }
        .page-top .product-nav .product-popup:before {
            border-bottom-color:var(--porto-primary-color)
        }
        .product-nav .product-popup .box-content {
            border-top:3px solid var(--porto-heading-color)
        }
        .product-nav .product-popup .product-image {
            padding:0;
            width:90px
        }
        .product-nav .product-popup .product-image img {
            width:100%;
            height:auto
        }
        .product-nav .product-popup .product-details .product-title {
            display:block;
            padding-top:5px;
            line-height:1.4em;
            font-size:12px;
            font-weight:600;
            text-align:center;
            color:var(--porto-color-price)
        }
        .product-nav .product-popup .product-details .amount {
            font-size:1.0714em;
            font-weight:600;
            line-height:1;
            vertical-align:middle;
            color:var(--porto-color-price)
        }
        .product-nav .product-popup .product-details .amount .currency,
        .product-nav .product-popup .product-details .amount .decimal {
            font-size:0.75em;
            font-weight:400
        }
        .product-nav .product-popup .product-details .amount .currency .decimal {
            font-size:1em
        }
        .product-nav .product-popup .product-details ins {
            text-decoration:none;
            vertical-align:baseline
        }
        .product-nav .product-popup .product-details .from,
        .product-nav .product-popup .product-details del {
            color:#a7a7a7;
            font-size:0.8em;
            margin-right:3px;
            vertical-align:baseline
        }
        .product-nav .product-popup .product-details .from .amount,
        .product-nav .product-popup .product-details del .amount {
            color:#a7a7a7
        }
        .woocommerce-product-rating {
            color:#999;
            margin-bottom:1.4286em;
            margin-top:0;
            font-size:0.9286em
        }
        .woocommerce-product-rating .star-rating {
            font-size:1.2857em;
            display:inline-block;
            margin-right:0.7143em;
            position:relative
        }
        .woocommerce-product-rating .review-link {
            display:inline-block
        }
        .woocommerce-product-rating .review-link a:first-child {
            padding-left:0
        }
        .woocommerce-product-rating a {
            color:inherit;
            display:inline-block;
            vertical-align:bottom;
            padding:0 0.7143em
        }
        .woocommerce-product-rating a:active,
        .woocommerce-product-rating a:hover {
            color:#888
        }
        .woocommerce-product-rating.noreview a {
            padding:0
        }
        .product-summary-wrap {
        }
        .product-summary-wrap .summary,
        .product-summary-wrap .summary-before {
            margin-bottom:2rem
        }
        .product-summary-wrap .description {
            margin-bottom:1em
        }
        .product-summary-wrap .description p:last-child {
            margin-bottom:0
        }
        @media (max-width:767px) {
            .product-summary-wrap .summary {
                margin-right:0
            }
        }
        .product-summary-wrap .cart {
            margin-bottom:1.7857em
        }
        .product-summary-wrap .quantity {
            vertical-align:top;
            margin-bottom:5px
        }
        .product-summary-wrap .single_add_to_cart_button {
            margin:0 0.625rem 0.3125rem 0
        }
        .product-summary-wrap .single_add_to_cart_button:before {
            display:inline-block;
            content:"\e8ba";
            font-family:"Porto";
            margin-right:0.5rem;
            font-size:1.2857em;
            line-height:1
        }
        @media (max-width:991px) {
            .product-summary-wrap .single_add_to_cart_button {
                padding:0 1.4286em
            }
        }
        @media (max-width:575px) {
            .product-summary-wrap .single_add_to_cart_button {
                padding:0 0.7143em
            }
        }
        .product-summary-wrap .stock {
            font-weight:600;
            color:#4c4c4c;
            margin-bottom:0
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist {
            position:relative;
            text-align:left
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist a,
        .product-summary-wrap .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            color:var(--porto-wishlist-color,#302e2a);
            width:auto;
            text-indent:0;
            overflow:visible;
            border:none;
            background:none;
            border-radius:0
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist a:focus,
        .product-summary-wrap .yith-wcwl-add-to-wishlist a:hover,
        .product-summary-wrap .yith-wcwl-add-to-wishlist span:focus,
        .product-summary-wrap .yith-wcwl-add-to-wishlist span:hover {
            color:var(--porto-wishlist-color-inverse,var(--porto-primary-color))
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist a span:not(.yith-wcwl-tooltip) {
            transition:none
        }
        .product-summary-wrap .yith-wcwl-add-to-wishlist a span:not(.yith-wcwl-tooltip),
        .product-summary-wrap .yith-wcwl-add-to-wishlist a span:not(.yith-wcwl-tooltip):hover {
            color:inherit
        }
        .product-summary-wrap .product_meta {
            margin:1.2143em 0
        }
        .product-summary-wrap .product_meta span a,
        .product-summary-wrap .product_meta span span {
            display:inline-block;
            font-weight:400;
            color:#777
        }
        .product-summary-wrap .share-links {
            margin:2.2143em 0 0
        }
        .product-summary-wrap .share-links {
            margin-bottom:1.0714em
        }
        .product-summary-wrap #product-tab .description {
            margin-bottom:0
        }
        .product-summary-wrap #product-tab hr {
            display:none
        }
        .product-summary-wrap .price {
            color:var(--porto-heading-color)
        }
        .elementor-widget-porto_cp_wishlist .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip),
        .wpb-sp-wishlist .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            width:auto;
            text-indent:0
        }
        .product_meta .posted_in,
        .product_meta .product-stock,
        .product_meta .sku_wrapper,
        .product_meta .tags {
            display:block;
            margin-bottom:0.25rem
        }
        #product-tab:not(:last-child) {
            margin-bottom:1.5rem
        }
        #product-tab .tab-content h2 {
            margin-bottom:0.7em
        }
        #product-tab .tab-content>h2:first-child {
            display:none
        }
        #reviews .commentlist li {
            position:relative;
            padding-left:115px
        }
        @media (max-width:575px) {
            #reviews .commentlist li {
                padding-left:0
            }
        }
        #reviews .commentlist .img-thumbnail {
            position:absolute;
            left:0;
            top:0
        }
        #reviews .commentlist .img-thumbnail img {
            max-width:80px;
            height:auto
        }
        @media (max-width:575px) {
            #reviews .commentlist .img-thumbnail {
                position:static;
                margin:0 12px 10px 0;
                float:left
            }
            #reviews .commentlist .img-thumbnail img {
                max-width:60px
            }
        }
        #reviews .commentlist .comment-text {
            min-height:90px
        }
        #reviews .commentlist .comment-text:before {
            content:"";
            border-bottom:15px solid transparent;
            left:-15px;
            border-top:15px solid transparent;
            border-right:15px solid var(--porto-gray-1);
            height:0;
            position:absolute;
            top:28px;
            width:0
        }
        @media (max-width:575px) {
            #reviews .commentlist .comment-text:before {
                display:none
            }
        }
        #reviews .commentlist .star-rating {
            float:right
        }
        @media (max-width:575px) {
            #reviews .commentlist .star-rating {
                float:none
            }
        }
        div.products {
            margin-bottom:1.875rem
        }
        .products-container {
            list-style:none
        }
        .products.related {
            padding-bottom:1.875rem;
            margin-bottom:0
        }
        .main-content .products.related {
            padding-bottom:0.5rem
        }
        #content-bottom+.products.related {
            margin-top:2.5rem
        }
        .summary-before {
            position:relative
        }
        @media (max-width:991px) {
            .summary-before {
                margin-left:auto;
                margin-right:auto
            }
        }
        .summary-before .labels {
            position:absolute;
            line-height:1;
            color:#fff;
            font-weight:700;
            text-transform:uppercase;
            margin:0;
            z-index:7;
            top:0.8em;
            left:0.8em;
            margin-left:var(--porto-column-spacing)
        }
        .summary-before .labels .onhot,
        .summary-before .labels .onnew,
        .summary-before .labels .onsale {
            font-size:0.8571em;
            padding:0.5833em 0.6333em;
            margin-bottom:5px;
            display:block
        }
        .summary-before .labels .onnew {
            background:-webkit-linear-gradient(-405deg,var(--porto-new-bgc,#08c) 0,var(--porto-new-bgc,#0169fe) 80%);
            background:linear-gradient(135deg,var(--porto-new-bgc,#08c) 0,var(--porto-new-bgc,#0169fe) 80%)
        }
        .summary-before .ms-lightbox-btn {
            background-color:var(--porto-primary-color)
        }
        .summary-before .ms-lightbox-btn:hover {
            background-color:var(--porto-primary-light-5)
        }
        .summary-before .ms-nav-next:before,
        .summary-before .ms-nav-prev:before,
        .summary-before .ms-thumblist-bwd:before,
        .summary-before .ms-thumblist-fwd:before {
            color:var(--porto-primary-color)
        }
        .product-images {
            position:relative;
            margin-bottom:8px
        }
        .product-images .image-galley-viewer,
        .product-images .zoom {
            border-radius:100%;
            bottom:4px;
            cursor:pointer;
            background-color:var(--porto-primary-color);
            color:#FFF;
            display:block;
            height:30px;
            padding:0;
            position:absolute;
            right:4px;
            text-align:center;
            width:30px;
            opacity:0;
            transition:all 0.1s;
            z-index:1000
        }
        .product-images .image-galley-viewer i,
        .product-images .zoom i {
            font-size:14px;
            line-height:28px
        }
        .product-images .image-galley-viewer {
            display:flex;
            justify-content:center;
            bottom:calc(8px + var(--porto-product-action-margin, 0px) + 2 * var(--porto-product-action-border, 0px) + var(--porto-product-action-width, 30px))
        }
        .product-images .image-galley-viewer i {
            font-size:16px
        }
        .product-images .image-galley-viewer i:before {
            font-size:1.25em;
            line-height:inherit
        }
        .product-images .image-galley-viewer.without-zoom {
            bottom:4px
        }
        .product-images:hover .image-galley-viewer,
        .product-images:hover .zoom {
            opacity:1
        }
        .product-images .product-image-slider.owl-carousel {
            margin-bottom:0
        }
        .product-images .product-image-slider.owl-carousel .img-thumbnail {
            display:block
        }
        .product-image-slider.owl-carousel {
            margin-bottom:10px
        }
        .product-image-slider.owl-carousel .img-thumbnail {
            padding:0
        }
        .product-image-slider.owl-carousel .owl-nav [class*=owl-],
        .product-image-slider.owl-carousel .owl-nav [class*=owl-]:active,
        .product-image-slider.owl-carousel .owl-nav [class*=owl-]:hover {
            background:none!important;
            font-size:22px;
            color:#222529
        }
        .product-image-slider.owl-carousel .owl-nav .owl-prev {
            left:0
        }
        .product-image-slider.owl-carousel .owl-nav .owl-next {
            right:0
        }
        .product-image-slider .owl-item {
            cursor:grab;
            line-height:1
        }
        .product-image-slider .owl-item .img-thumbnail {
            width:100%
        }
        .product-thumbs-slider.owl-carousel {
            margin-bottom:0
        }
        .product-thumbs-slider.owl-carousel .thumb-nav {
            opacity:0;
            transition:opacity 0.3s;
            top:50%;
            position:absolute;
            margin-top:-20px;
            width:100%!important
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-next,
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-prev {
            cursor:pointer;
            display:inline-block;
            position:absolute;
            font-size:15px;
            color:var(--porto-primary-color);
            width:30px;
            height:30px;
            text-align:center;
            text-shadow:0 -1px 0 rgba(0,0,0,0.25);
            margin:5px;
            padding:4px 7px;
            -webkit-user-select:none;
            -ms-user-select:none;
            user-select:none
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-next:before,
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-prev:before {
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            position:relative;
            top:0
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-prev {
            left:-5px
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-prev:before {
            content:"\f053";
            left:-1px
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-next {
            right:-5px
        }
        .product-thumbs-slider.owl-carousel .thumb-nav .thumb-next:before {
            content:"\f054";
            left:1px
        }
        .product-thumbs-slider.owl-carousel:hover .thumb-nav {
            opacity:1
        }
        .product-thumbs-slider.owl-carousel .owl-item {
            cursor:pointer
        }
        .product-thumbs-slider.owl-carousel .owl-item img {
            transition:opacity 0.3s
        }
        .product-thumbs-slider.owl-carousel .img-thumbnail {
            border:1px solid var(--porto-gray-1);
            transition:border-color 0.2s
        }
        .product-thumbs-slider.owl-carousel .owl-item.selected .img-thumbnail,
        html:not(.touch) .product-thumbs-slider .owl-item:hover .img-thumbnail {
            border:2px solid var(--porto-heading-color)
        }
        .variations td>br {
            display:none
        }
        .variations .label {
            font-size:1em;
            color:inherit;
            text-align:left;
            padding-left:0
        }
        .variations .reset_variations {
            display:inline-block;
            line-height:1;
            padding:0.4375rem 0.5rem;
            margin-top:0.7em;
            background:var(--porto-gray-1);
            color:inherit;
            font-size:0.6875rem;
            text-transform:uppercase
        }
        .variations .reset_variations:hover {
            background:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse)
        }
        .variations tr td {
            padding-top:2px
        }
        .variations tr td label {
            padding-top:10px
        }
        .variations tr:last-child select {
            margin-bottom:0
        }
        .variations select {
            display:block;
            height:2.625rem;
            font-size:0.8571em;
            font-weight:600;
            text-transform:uppercase;
            box-shadow:none;
            width:100%
        }
        .single-product .cart:not(.variations_form),
        .single_variation_wrap {
            padding:1.25rem 0 1rem;
            border-top:1px solid var(--porto-gray-2);
            border-bottom:1px solid var(--porto-gray-2);
            margin-top:1rem
        }
        .wcml_currency_switcher {
            margin-bottom:15px
        }
        .group_table td,
        .group_table th {
            vertical-align:middle;
            display:table-cell
        }
        .group_table .label,
        .group_table .price {
            font-size:1.2em
        }
        h2.resp-accordion {
            padding:15px!important;
            line-height:1.4;
            font-size:1em
        }
        .resp-arrow {
            display:none
        }
        .tab-content h2 {
            font-size:1.4286em;
            line-height:1.4;
            font-weight:400;
            margin-bottom:1.0714em
        }
        .tab-content p {
            margin-bottom:10px
        }
        .tab-content table {
            margin-top:20px
        }
        .tab-content table p {
            margin:0
        }
        .tab-content :last-child {
            margin-bottom:0
        }
        .woocommerce-tabs .tab-content {
            border:none;
            border-top:solid 1px var(--porto-gray-2);
            box-shadow:none;
            padding:30px 0 15px
        }
        @media (max-width:767px) {
            .woocommerce-tabs .tab-content {
                border-top:none
            }
        }
        .woocommerce-tabs .tab-content p {
            font-size:14px;
            font-weight:400;
            letter-spacing:0.005em;
            line-height:1.9
        }
        .woocommerce-tabs .resp-tabs-list {
            padding-bottom:1px;
            border-bottom:none
        }
        .woocommerce-tabs .resp-tabs-list li {
            font-weight:700;
            color:#818692!important;
            text-transform:uppercase;
            background:transparent!important;
            border:none!important;
            border-bottom:2px solid transparent!important;
            padding:7px 0!important;
            border-radius:0!important;
            margin-right:35px
        }
        .woocommerce-tabs .resp-tabs-list li.resp-tab-active,
        .woocommerce-tabs .resp-tabs-list li:hover {
            border-color:var(--porto-heading-color)!important
        }
        .woocommerce-tabs .resp-tabs-list li.resp-tab-active {
            color:var(--porto-heading-color)!important
        }
        .woocommerce-tabs h2.resp-accordion {
            border-top:none!important;
            border-left:none;
            border-right:none;
            background:none!important;
            text-transform:uppercase;
            font-weight:bold;
            color:var(--porto-heading-color)
        }
        .woocommerce-tabs h2.resp-accordion:before {
            content:"\e81c";
            font-family:"porto";
            float:left;
            margin-right:10px
        }
        .woocommerce-tabs h2.resp-tab-active {
            border-bottom:2px solid var(--porto-primary-color)!important
        }
        .woocommerce-tabs h2.resp-tab-active:before {
            content:"\e81b"
        }
        .single-product .cart {
            margin-bottom:0px
        }
        .single-product .cart:not(.variations_form) {
            margin-top:10px
        }
        .single-product .product-summary-wrap .yith-wcwl-add-to-wishlist {
            padding:0;
            display:inline-block;
            vertical-align:middle;
            margin:15px 0.5rem 0 0;
            font:700 0.75rem/1 var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif;
            text-transform:uppercase;
            letter-spacing:-0.015em
        }
        .single-product .product-summary-wrap .yith-wcwl-add-to-wishlist+.clear {
            display:block
        }
        .single-product .product-summary-wrap .description p {
            font-size:1.1428em;
            line-height:1.6875;
            letter-spacing:-0.015em
        }
        .single-product .product-summary-wrap .price {
            font:600 1.5rem/1 var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif;
            letter-spacing:-0.02em
        }
        .single-product .product-summary-wrap .price .price {
            margin-top:0;
            margin-bottom:0
        }
        .single-product .product-summary-wrap .price del {
            letter-spacing:0
        }
        .single-product .product-summary-wrap .yith-compare {
            display:inline-flex;
            height:34px;
            margin-top:15px;
            padding:0;
            color:var(--porto-wishlist-color,#302e2a);
            font:700 12px/34px var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif;
            background:none;
            text-transform:uppercase
        }
        .single-product .product-summary-wrap .yith-compare:before {
            content:"\e810";
            margin-right:0.25rem;
            font-family:"porto";
            font-size:1.125rem
        }
        .single-product .product-summary-wrap .yith-compare.added:before {
            content:"\f00c";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900
        }
        .single-product .product-summary-wrap .yith-compare:active,
        .single-product .product-summary-wrap .yith-compare:active:before,
        .single-product .product-summary-wrap .yith-compare:focus,
        .single-product .product-summary-wrap .yith-compare:focus:before,
        .single-product .product-summary-wrap .yith-compare:hover,
        .single-product .product-summary-wrap .yith-compare:hover:before {
            color:var(--porto-wishlist-color-inverse,var(--porto-primary-color));
            background:none
        }
        .single-product .product-summary-wrap .share-links {
            margin:0
        }
        .single-product .product-summary-wrap .share-links a {
            font-size:13px;
            width:32px;
            height:32px;
            border-radius:16px;
            margin:0.2857em 0.1em 0.2857em 0
        }
        .single-product .product-summary-wrap .share-links a:not(:hover) {
            background:none;
            color:var(--porto-heading-color);
            border:2px solid #e7e7e7
        }
        .single-product .product-summary-wrap .product-share {
            display:inline-block;
            margin:15px 0.5rem 0 0;
            vertical-align:middle
        }
        .single-product .product_meta {
            clear:both;
            font-size:0.8571em;
            font-weight:600;
            color:var(--porto-heading-color)
        }
        .single-product .product_meta a,
        .single-product .product_meta span span {
            font-weight:400;
            color:#777
        }
        .single-product .product_meta a:hover {
            color:#222529
        }
        .single-product .entry-summary {
            position:relative
        }
        .single-product .entry-summary .add_to_wishlist:before {
            position:relative;
            content:"\e91b";
            font-size:1.125rem;
            bottom:auto;
            right:auto
        }
        .single-product .entry-summary .yith-wcwl-add-button a.view-wishlist:before,
        .single-product .entry-summary .yith-wcwl-add-to-wishlist .delete_item:before,
        .single-product .entry-summary .yith-wcwl-wishlistaddedbrowse a:before,
        .single-product .entry-summary .yith-wcwl-wishlistexistsbrowse a:before {
            position:static;
            margin-right:0.125rem;
            line-height:1
        }
        .single-product .product_title {
            font-size:1.875rem;
            line-height:1.2;
            color:var(--porto-heading-color);
            letter-spacing:-0.01em;
            font-weight:700;
            margin-bottom:2px
        }
        .single-product .product-images .image-galley-viewer,
        .single-product .product-images .zoom {
            background:none;
            color:#212529
        }
        .single-product .woocommerce-product-rating .star-rating {
            font-size:1em;
            top:1px
        }
        .single-product .woocommerce-product-rating .star-rating:before {
            color:#999
        }
        .single-product .woocommerce-product-rating .star-rating span:before {
            color:#ff5b5b
        }
        .single-product .woocommerce-product-rating:after {
            content:"";
            display:block;
            width:40px;
            border-top:2px solid #e7e7e7;
            margin:0.875rem 0 1rem
        }
        .single-product .variations {
            width:auto;
            min-width:45%
        }
        .single-product .variations .label {
            display:table-cell;
            padding-right:1em
        }
        .single-product .variations .label label {
            font-size:1em;
            text-transform:uppercase;
            line-height:42px;
            white-space:nowrap;
            padding:0;
            margin:0;
            color:var(--porto-heading-color)
        }
        .single-product .variations .label label:after {
            content:":"
        }
        .single-product ul.product_list_widget li .product-image {
            width:75px;
            flex:0 0 75px;
            margin-right:15px
        }
        .single-product ul.product_list_widget li .product-details {
            max-width:calc(100% - 90px)
        }
        .single-product .product-summary-wrap .wishlist-nolabel:not(.entry-summary) .yith-wcwl-add-to-wishlist a,
        .single-product .product-summary-wrap .wishlist-nolabel:not(.entry-summary) .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip):not(.separator) {
            width:36px;
            text-indent:-9999em;
            border:1px solid var(--porto-shop-add-links-border-color,transparent)
        }
        .single-product .product-summary-wrap .wishlist-nolabel:not(.entry-summary) .yith-wcwl-add-to-wishlist a:before {
            position:absolute;
            line-height:inherit
        }
        .single-product .woocommerce-variation-availability .stock {
            display:inline-block;
            position:relative;
            font-size:0.6875rem;
            color:#777;
            line-height:1.6875rem;
            text-transform:uppercase;
            background-color:#f3f3f3;
            border-radius:0.8125rem;
            z-index:2;
            overflow:hidden;
            padding:0 3rem;
            margin-bottom:0
        }
        .single-product .woocommerce-variation-availability .stock:before {
            display:block;
            content:"";
            position:absolute;
            background-color:#2fc589;
            width:15%;
            height:100%;
            left:0;
            z-index:-1
        }
        .single-product .woocommerce-variation-availability .stock.out-of-stock:before {
            background-color:#e12d2d
        }
        .single-product .cwginstock-subscribe-form {
            margin-top:0.625rem
        }
        .single-product .cwginstock-panel-heading h4 {
            margin-bottom:0
        }
        .single-product .fpf-fields,
        .single-product .fpf-totals {
            width:100%
        }
        .single-product .fpf-field h2 {
            margin-bottom:1rem
        }
        .single-product .fpf-field label {
            margin-bottom:0.5rem
        }
        .single-product .wcpa_form_outer {
            margin:0
        }
        .shop_table.cart-table .quantity,
        .single-product .product-summary-wrap .quantity {
            margin-right:0.5rem
        }
        .shop_table.cart-table .quantity .minus,
        .shop_table.cart-table .quantity .plus,
        .single-product .product-summary-wrap .quantity .minus,
        .single-product .product-summary-wrap .quantity .plus {
            width:30px;
            height:3rem;
            border-radius:0
        }
        .shop_table.cart-table .quantity .qty,
        .single-product .product-summary-wrap .quantity .qty {
            width:44px;
            height:3rem;
            font-size:1rem;
            line-height:14px;
            border-radius:0;
            border-width:1px 0 1px 0
        }
        .single_add_to_cart_button,
        .view-cart-btn {
            height:3rem!important;
            padding:0 2em;
            margin-bottom:5px;
            overflow:hidden;
            text-transform:uppercase;
            font-size:1em;
            letter-spacing:-0.015em;
            font-weight:700;
            line-height:3rem;
            border:none
        }
        .single_add_to_cart_button {
            font-family:var(--porto-add-to-cart-ff,var(--porto-body-ff)),sans-serif;
            background:var(--porto-heading-color);
            color:var(--porto-body-bg)
        }
        .view-cart-btn {
            display:none
        }
        .single-add-to-cart .type-product .view-cart-btn {
            display:inline-block
        }
        .filter-item-list {
            padding:0;
            list-style:none;
            margin-bottom:0
        }
        .filter-item-list .filter-color {
            display:block;
            position:relative;
            margin:5px 10px 5px 0;
            padding-right:0!important;
            --porto-sw-size:25px;
            width:var(--porto-sw-size);
            height:var(--porto-sw-size);
            text-indent:-9999px;
            white-space:nowrap;
            border:1px solid #e7e7e7;
            border-radius:50%
        }
        .filter-item-list .active .filter-color:before,
        .filter-item-list .chosen .filter-color:before {
            content:"";
            position:absolute;
            --porto-sw-offset:-4px;
            left:var(--porto-sw-offset);
            top:var(--porto-sw-offset);
            right:var(--porto-sw-offset);
            bottom:var(--porto-sw-offset);
            border:1px solid #222529;
            border-radius:50%
        }
        .filter-item-list+select {
            visibility:hidden;
            width:0;
            height:0;
            overflow:hidden;
            margin:0;
            padding:0;
            float:right;
            border:none;
            -webkit-appearance:none;
            -moz-appearance:none;
            -ms-appearance:none
        }
        .filter-item-list a.disabled {
            cursor:not-allowed;
            opacity:0.5
        }
        .filter-item-list .filter-item,
        .woocommerce-widget-layered-nav-list a:not(.filter-color) {
            display:block;
            padding:0 15px;
            margin:3px 6px 3px 0;
            min-width:32px;
            border:1px solid var(--porto-gray-5);
            text-align:center;
            font-size:12px;
            line-height:24px;
            font-weight:500;
            color:inherit
        }
        .filter-item-list .active .filter-item,
        .filter-item-list .filter-item:not(.disabled):hover,
        .woocommerce-widget-layered-nav-list .chosen a:not(.filter-color) {
            background-color:var(--porto-primary-color);
            border-color:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse)
        }
        .filter-item-list .filter-image {
            width:32px;
            height:32px;
            text-indent:-9999px;
            background-repeat:no-repeat;
            background-size:cover;
            background-color:transparent!important
        }
        .single-product .single_variation>div:not(:empty) {
            margin-bottom:0.75rem
        }
        .single-product .porto-pre-order-date {
            flex:0 0 100%;
            max-width:100%
        }
        .label-pre-order {
            font-size:0.9em;
            color:var(--porto-primary-color)
        }
        .porto-video-thumbnail-viewer:before {
            content:"";
            position:absolute;
            left:0;
            top:0;
            right:0;
            bottom:0;
            background:rgba(0,0,0,0.1);
            transition:background 0.3s
        }
        .porto-video-thumbnail-viewer:after {
            content:"\f04b";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-size:16px;
            font-weight:800;
            color:#fff;
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            border:2px solid #fff;
            border-radius:50%;
            width:40px;
            height:40px;
            line-height:36px;
            text-align:center;
            transition:box-shadow 0.3s
        }
        .porto-video-popup-wrapper video {
            width:100%;
            object-fit:cover;
            outline:none
        }
        .sale-product-daily-deal .daily-deal-title,
        .sale-product-daily-deal .porto_countdown {
            font-family:"Oswald",var(--porto-h3-ff),var(--porto-body-ff),sans-serif;
            text-transform:uppercase
        }
        .entry-summary .sale-product-daily-deal {
            margin-top:10px
        }
        .entry-summary .sale-product-daily-deal .porto_countdown {
            margin-bottom:5px
        }
        .entry-summary .sale-product-daily-deal .porto_countdown-section {
            background-color:var(--porto-primary-color);
            color:#fff;
            margin-left:1px;
            margin-right:1px;
            display:block;
            float:left;
            max-width:calc(25% - 2px);
            min-width:64px;
            padding:12px 10px
        }
        .entry-summary .sale-product-daily-deal .porto_countdown .porto_countdown-amount {
            display:block;
            font-size:18px;
            font-weight:700
        }
        .entry-summary .sale-product-daily-deal .porto_countdown-period {
            font-size:10px
        }
        .entry-summary .sale-product-daily-deal:after {
            content:"";
            display:table;
            clear:both
        }
        .products .sale-product-daily-deal {
            position:absolute;
            left:10px;
            right:10px;
            bottom:10px;
            color:#fff;
            padding:5px 0;
            text-align:center
        }
        .products .sale-product-daily-deal:before {
            content:"";
            position:absolute;
            left:0;
            width:100%;
            top:0;
            height:100%;
            background:var(--porto-primary-color);
            opacity:0.7
        }
        .products .sale-product-daily-deal>div,
        .products .sale-product-daily-deal>h5 {
            position:relative;
            z-index:1
        }
        .products .sale-product-daily-deal .daily-deal-title {
            display:inline-block;
            color:#fff;
            font-size:11px;
            font-weight:400;
            margin-bottom:0;
            margin-right:1px
        }
        .products .sale-product-daily-deal .porto_countdown {
            float:none;
            display:inline-block;
            margin-bottom:0;
            width:auto
        }
        .products .sale-product-daily-deal .porto_countdown-section {
            padding:0;
            margin-bottom:0
        }
        .products .sale-product-daily-deal .porto_countdown-section:first-child:after {
            content:",";
            margin-right:2px
        }
        .products .sale-product-daily-deal .porto_countdown-amount,
        .products .sale-product-daily-deal .porto_countdown-period {
            font-size:13px;
            font-weight:500;
            padding:0 1px
        }
        .products .sale-product-daily-deal .porto_countdown-section:last-child .porto_countdown-period {
            padding:0
        }
        .products .sale-product-daily-deal:after {
            content:"";
            display:table;
            clear:both
        }
        .porto-products.default .products.list li .add-links .yith-compare,
        .porto-products.onhover .products.list li .add-links .yith-compare,
        .porto-products.onimage .products.list li .add-links .yith-compare,
        .porto-products.outimage .products.list li .add-links .yith-compare,
        .porto-products.theme_option .products.list li .add-links .yith-compare {
            display:none
        }
        .sp-linked-heading {
            font-size:1rem;
            text-transform:uppercase;
            margin-bottom:1.5rem;
            border-bottom:1px solid rgba(0,0,0,0.0784313725)
        }
        .slider-wrapper>.sp-linked-heading {
            margin-left:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / 2);
            margin-right:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / 2)
        }
        @media (max-width:575px) {
            li.product-col:not(.product-onimage2) .links-on-image .add-links-wrap {
                display:block!important
            }
            li.product-col .links-on-image .button {
                opacity:1!important
            }
            li.product-col .product-image {
                box-shadow:none!important
            }
            li.product-col .product-image .img-effect img {
                opacity:1!important
            }
            li.product-col .product-image .img-effect .hover-image,
            li.product-col .product-image .quickview {
                display:none!important
            }
            li.product-col .product-image .yith-wcwl-add-to-wishlist>div {
                opacity:1!important;
                visibility:visible!important
            }
            li.product-default .add-links .quickview,
            li.product-default .add-links .yith-wcwl-add-to-wishlist>div,
            li.product-outimage .add-links .quickview {
                display:none
            }
            li.product-outimage .add-links .yith-wcwl-add-to-wishlist>div {
                opacity:1!important;
                visibility:visible!important
            }
        }
        .gridlist-toggle {
            display:flex
        }
        @media (max-width:575px) {
            .gridlist-toggle {
                display:none
            }
        }
        .gridlist-toggle>a {
            font-size:1rem;
            width:34px;
            height:34px;
            display:flex;
            align-items:center;
            justify-content:center;
            transition:0.25s;
            color:var(--porto-heading-color);
            border:1px solid var(--porto-heading-color)
        }
        .gridlist-toggle>a:not(.active) {
            border:1px solid var(--porto-gray-5)
        }
        .gridlist-toggle #grid {
            margin-right:0.25rem
        }
        .woocommerce-result-count {
            margin-bottom:0
        }
        .woocommerce-ordering select,
        .woocommerce-viewing select {
            font-size:1em;
            padding:0 25px 0 8px;
            box-shadow:none;
            border:1px solid var(--porto-gray-5);
            height:34px;
            border-radius:0
        }
        .woocommerce-ordering select {
            width:160px
        }
        .woocommerce-viewing {
            display:inline-block;
            vertical-align:top
        }
        .woocommerce-pagination {
            position:relative;
            text-align:right
        }
        .woocommerce-pagination ul {
            display:inline-block;
            white-space:nowrap;
            padding:0;
            margin:0 0 0 10px;
            clear:both
        }
        .woocommerce-pagination ul li {
            float:left;
            margin-left:5px;
            display:inline;
            padding:0;
            text-align:center
        }
        .woocommerce-pagination li a,
        .woocommerce-pagination li span {
            border:1px solid var(--porto-gray-5);
            color:var(--porto-body-color);
            display:block;
            font-size:15px;
            font-weight:700;
            margin:0 0 5px;
            padding:0 0.5em;
            line-height:2.1em;
            min-width:2.2em;
            height:2.2em
        }
        .woocommerce-pagination span.dots {
            border-width:0;
            min-width:0;
            padding:0
        }
        .woocommerce-pagination li a:focus,
        .woocommerce-pagination li a:hover,
        .woocommerce-pagination li span.current {
            color:var(--porto-body-color);
            border-color:var(--porto-primary-color)
        }
        .woocommerce-pagination .next,
        .woocommerce-pagination .prev {
            text-indent:-9999px;
            position:relative;
            padding:0
        }
        .woocommerce-pagination .next:before,
        .woocommerce-pagination .prev:before {
            font-family:"porto";
            font-size:20px;
            font-weight:normal;
            line-height:30px;
            position:absolute;
            top:0;
            left:0;
            right:0;
            text-indent:0
        }
        .woocommerce-pagination .prev:before {
            content:"\e819"
        }
        .woocommerce-pagination .next:before {
            content:"\e81a"
        }
        .woocommerce-pagination.load-more {
            float:none
        }
        .woocommerce-pagination.load-more:not(.d-none) {
            display:block!important
        }
        .woocommerce-pagination.load-more .woocommerce-viewing {
            display:none
        }
        .woocommerce-pagination.load-more>.page-numbers {
            float:none;
            display:block;
            width:100%;
            margin:0 0 11px
        }
        .woocommerce-pagination.load-more ul li {
            float:none;
            display:block;
            margin-left:0
        }
        .shop-loop-after,
        .shop-loop-before {
            font-size:0.9286em
        }
        .shop-loop-after label,
        .shop-loop-before label {
            margin:0 7px 0 0;
            vertical-align:middle
        }
        @media (max-width:575px) {
            .shop-loop-after label,
            .shop-loop-before label {
                display:none
            }
        }
        .shop-loop-before {
            display:flex;
            align-items:center;
            flex-wrap:wrap;
            margin-bottom:10px;
            margin-right:-10px
        }
        .shop-loop-before>* {
            margin:0 10px 10px 0
        }
        .shop-loop-before p {
            font-size:inherit
        }
        .shop-loop-before.sticky {
            position:fixed!important;
            z-index:999;
            left:0;
            width:100%;
            padding:11.5px calc(var(--porto-fluid-spacing) - 10px) 1.5px var(--porto-fluid-spacing);
            border-bottom:1px solid var(--porto-gray-5);
            transition:left 0.3s
        }
        .shop-loop-before .page-numbers,
        .shop-loop-before .woocommerce-pagination .page-numbers {
            display:none
        }
        .shop-loop-before .woocommerce-ordering {
            margin-right:auto
        }
        .shop-loop-before .woocommerce-pagination {
            margin-top:0
        }
        .shop-loop-before .woocommerce-pagination:empty {
            display:none
        }
        .shop-loop-before .woocommerce-pagination .woocommerce-viewing {
            display:inline-block
        }
        @media (max-width:991px) {
            .shop-loop-before .woocommerce-pagination ul {
                margin-left:-5px
            }
        }
        .page-wrapper.sticky-scroll-up .shop-loop-before.sticky {
            top:0;
            opacity:1;
            visibility:visible;
            transform:translate3d(0,0,0)
        }
        .page-wrapper.sticky-scroll-up .shop-loop-before.sticky.scroll-down {
            opacity:0!important;
            visibility:hidden;
            transform:translate3d(0,-100%,0)
        }
        .page-wrapper.sticky-scroll-up .shop-loop-before.sticky-ready {
            transition:left 0.3s,visibility 0.3s,opacity 0.3s,transform 0.3s,top 0.3s ease
        }
        .page-wrapper.sticky-scroll-up .filter-placeholder {
            width:100%
        }
        .filter-sidebar-opened .shop-loop-before.sticky {
            position:static!important;
            z-index:auto
        }
        .panel-opened .shop-loop-before.sticky,
        .sidebar-opened .shop-loop-before.sticky {
            left:260px
        }
        @media (max-width:991px) {
            .sidebar-right-opened.sidebar-opened #header.sticky-header .header-main.sticky,
            .sidebar-right-opened.sidebar-opened .shop-loop-before.sticky,
            html.sidebar-opened.sidebar-right-opened .page-wrapper {
                left:-260px
            }
        }
        .shop-loop-after {
            text-align:center;
            border-top:1px solid var(--porto-gray-5);
            padding-top:25px
        }
        .shop-loop-after .woocommerce-pagination {
            text-align:center
        }
        .shop-loop-after .woocommerce-pagination>* {
            margin-bottom:15px
        }
        .shop-loop-after .page-numbers {
            display:block
        }
        .shop-loop-after .woocommerce-viewing {
            float:left
        }
        .shop-loop-after .page-numbers {
            clear:none;
            float:right
        }
        .shop-loop-after.load-more-wrap {
            padding-top:0;
            border-top:none
        }
        .shop-loop-before .shop-loop-after {
            padding-top:0;
            border-top:none
        }
        .shop-loop-before .shop-loop-after .woocommerce-pagination>* {
            margin-bottom:0
        }
        .porto-products-widget-pagination .woocommerce-viewing {
            display:none
        }
        a.porto-product-filters-toggle {
            align-items:center;
            height:36px;
            background:var(--porto-normal-bg);
            padding:0 10px 0 3px;
            text-transform:uppercase;
            color:inherit;
            border:1px solid var(--porto-gray-5)
        }
        a.porto-product-filters-toggle svg {
            fill:#fff;
            width:28px
        }
        @media (max-width:991px) {
            .shop-loop-before {
                font-size:11px;
                letter-spacing:-0.025em;
                font-weight:600;
                background:var(--porto-gray-7);
                padding:10px 0 0 10px;
                margin-right:0;
                margin-bottom:var(--porto-grid-gutter-width);
                color:var(--porto-heading-color)
            }
            .shop-loop-before select {
                text-transform:uppercase;
                height:36px;
                max-width:140px;
                letter-spacing:inherit;
                font-weight:inherit;
                color:inherit
            }
            .shop-loop-before label {
                font-weight:inherit
            }
            .shop-loop-before .woocommerce-ordering,
            .shop-loop-before .woocommerce-pagination {
                font-size:1em
            }
            .shop-loop-before .woocommerce-result-count {
                display:none
            }
            a.porto-product-filters-toggle svg {
                stroke:var(--porto-heading-color)
            }
        }
        .shop-wrap .elementor-container,
        .shop-wrap .elementor-row {
            flex-wrap:wrap
        }
        .category-image {
            width:100%;
            margin-bottom:20px
        }
        .entry-description .category-image {
            width:auto
        }
        .products ul,
        ul.products {
            margin:0 0 1em;
            padding:0;
            list-style:none outside
        }
        .products ul li,
        ul.products li {
            list-style:none outside
        }
        .cross-sells .slider-wrapper .products .product {
            padding-left:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / 2);
            padding-right:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / 2)
        }
        ul.products {
            margin-left:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / -2);
            margin-right:calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / -2)
        }
        ul.products:not(.owl-carousel) {
            display:flex;
            flex-wrap:wrap
        }
        ul.products li.product-col {
            padding:0 calc(var(--porto-el-spacing, var(--porto-grid-gutter-width)) / 2);
            margin-bottom:var(--porto-el-spacing,var(--porto-grid-gutter-width));
            position:relative;
            flex:0 0 auto;
            width:100%;
            max-width:100%
        }
        ul.products .product-content {
            padding-bottom:1px
        }
        ul.products .product-image {
            margin-bottom:1rem;
            min-height:90px
        }
        ul.products .product-image .img-effect img {
            position:relative;
            opacity:1
        }
        ul.products .product-image .img-effect .hover-image {
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            margin:auto;
            opacity:0
        }
        ul.products .product-image:hover .img-effect img {
            opacity:0
        }
        ul.products .product-image:hover .img-effect .hover-image {
            opacity:1;
            transform:scale(1.1,1.1) translateZ(0)
        }
        ul.products h3 {
            font-size:0.92rem;
            font-weight:500;
            line-height:1.35;
            margin-bottom:0.45rem
        }
        ul.products .product-loop-title:hover h3 {
            color:inherit
        }
        ul.products .rating-wrap {
            margin:0 0 0.625rem;
            position:relative;
            display:table
        }
        ul.products .rating-wrap .rating-content {
            display:table-cell
        }
        ul.products .description {
            margin-top:1.5em
        }
        ul.products .price {
            display:block;
            font-size:1.125rem;
            margin-bottom:1rem
        }
        ul.products .add-links {
            display:inline-block;
            position:relative;
            margin-bottom:1.0714em
        }
        ul.products .add-links .tooltip-inner {
            white-space:nowrap
        }
        ul.products .add-links .added_to_cart {
            display:none
        }
        ul.products .add-links .yith-wcwl-add-to-wishlist a.button:before {
            display:block!important
        }
        ul.products .add-links .yith-wcwl-add-to-wishlist>div {
            left:0;
            transition:0.25s
        }
        ul.products .add-links .quickview {
            right:0
        }
        ul.products .add-links .quickview,
        ul.products .add-links .yith-wcwl-add-to-wishlist>div {
            position:absolute;
            top:0;
            opacity:0;
            visibility:hidden;
            z-index:3
        }
        ul.products .add-links div.quantity {
            margin-bottom:5px
        }
        ul.products .links-on-image {
            height:0
        }
        ul.products .links-on-image .add-links-wrap {
            display:none;
            height:0
        }
        ul.products .links-on-image .add-links {
            position:static
        }
        ul.products .variations .label,
        ul.products .variations .reset_variations {
            display:none!important
        }
        ul.products .variations td {
            padding:0 0 5px
        }
        ul.products .variations tr {
            border-bottom:none
        }
        ul.products .variations .filter-item-list {
            display:flex;
            margin-top:-4px;
            margin-bottom:5px
        }
        ul.products .variations {
            width:100%
        }
        .products.gap-narrow li.product-col h3 {
            font-size:0.8125rem
        }
        .products.gap-narrow li.product-col .price {
            font-size:0.9375rem
        }
        @media (min-width:767px) {
            .products.gap-narrow {
                margin-left:calc(var(--porto-column-spacing) * -0.5);
                margin-right:calc(var(--porto-column-spacing) * -0.5)
            }
            .products.gap-narrow li.product-col {
                padding:0 calc(var(--porto-column-spacing) / 2)
            }
            .products.gap-narrow li.product-col h3 {
                font-size:0.8125rem
            }
            .products.gap-narrow li.product-col .price {
                font-size:0.9375rem
            }
        }
        li.product:hover .add-links .quickview,
        li.product:hover .add-links .yith-compare,
        li.product:hover .add-links .yith-wcwl-add-to-wishlist>div {
            opacity:1;
            visibility:visible
        }
        li.product:hover .add-links .quickview {
            opacity:0.85
        }
        li.product:hover .links-on-image .add-links-wrap {
            display:block
        }
        li.product:hover .product-image {
            box-shadow:0 25px 35px -5px rgba(0,0,0,0.1)
        }
        li.product:hover .product-image .viewcart.added {
            display:block;
            opacity:1
        }
        li.product .add-links .quickview:hover {
            opacity:1
        }
        li.product-default:hover .add-links .yith-wcwl-add-to-wishlist>div {
            left:-40px
        }
        li.product-default:hover .add-links .quickview {
            right:-40px
        }
        li.product-default:hover .add-links.no-effect .add_to_cart_button,
        li.product-default:hover .add-links.no-effect .add_to_cart_read_more {
            text-indent:0;
            width:auto;
            padding:0 0.7143em
        }
        li.product-default:hover .add-links.no-effect .add_to_cart_button:before,
        li.product-default:hover .add-links.no-effect .add_to_cart_read_more:before {
            position:static;
            font-size:1em;
            margin-right:0.5714em
        }
        ul.pcols-lg-9 li.product-col {
            width:11.1111%
        }
        ul.pcols-lg-9 li.product-col .add-links {
            display:none
        }
        ul.pcols-lg-8 li.product-col {
            width:12.5%
        }
        ul.pcols-lg-8 li.product-col .add-links {
            display:none
        }
        ul.pwidth-lg-8 .product-image {
            font-size:0.8em
        }
        ul.pwidth-lg-8 .add-links {
            font-size:0.85em
        }
        ul.pcols-lg-7 li.product-col {
            width:14.2857%
        }
        ul.pcols-lg-7 li.product-col .add-links {
            display:none
        }
        ul.pwidth-lg-7 .product-image {
            font-size:0.8em
        }
        ul.pwidth-lg-7 .add-links {
            font-size:0.9em
        }
        ul.pcols-lg-6 li.product-col {
            width:16.6666%
        }
        ul.pwidth-lg-6 .product-image {
            font-size:0.9em
        }
        ul.pwidth-lg-6 .add-links {
            font-size:1em
        }
        ul.pcols-lg-5 li.product-col {
            width:20%
        }
        ul.pwidth-lg-5 .product-image {
            font-size:1em
        }
        ul.pwidth-lg-5 .add-links {
            font-size:1em
        }
        ul.pcols-lg-4 li.product-col {
            width:25%
        }
        ul.pwidth-lg-4 .product-image {
            font-size:1em
        }
        ul.pwidth-lg-4 .add-links {
            font-size:1em
        }
        ul.pcols-lg-3 li.product-col {
            width:33.3333%
        }
        ul.pwidth-lg-3 .product-image {
            font-size:1.2em
        }
        ul.pwidth-lg-3 .add-links {
            font-size:1em
        }
        ul.pcols-lg-2 li.product-col {
            width:50%
        }
        ul.pwidth-lg-2 .product-image {
            font-size:1.5em
        }
        ul.pwidth-lg-2 .add-links {
            font-size:1em
        }
        ul.pcols-lg-1 li.product-col {
            width:100%
        }
        @media (min-width:992px) {
            .column2 ul.pwidth-lg-6 .product-image {
                font-size:0.75em
            }
            .column2 ul.pwidth-lg-6 .add-links {
                font-size:0.8em
            }
            .column2 ul.pwidth-lg-5 .product-image {
                font-size:0.8em
            }
            .column2 ul.pwidth-lg-5 .add-links {
                font-size:0.9em
            }
            .column2 ul.pwidth-lg-4 .product-image {
                font-size:0.9em
            }
            .column2 ul.pwidth-lg-4 .add-links {
                font-size:0.95em
            }
            .column2 ul.pwidth-lg-3 .product-image {
                font-size:1em
            }
            .column2 ul.pwidth-lg-3 .add-links {
                font-size:1em
            }
            .column2 ul.pwidth-lg-2 .product-image {
                font-size:1.2em
            }
        }
        @media (min-width:1400px) {
            ul.pcols-xl-8 li.product-col {
                width:12.5%
            }
            ul.pcols-xl-8 li.product-col .add-links {
                display:none
            }
            ul.pcols-xl-7 li.product-col {
                width:14.2857%
            }
            ul.pcols-xl-7 li.product-col .add-links {
                display:none
            }
            ul.pcols-xl-6 li.product-col {
                width:16.6666%
            }
            ul.pcols-xl-6 li.product-col .add-links {
                display:none
            }
        }
        .products .product-category {
            text-align:center
        }
        .products .product-category .thumb-info {
            min-height:90px;
            margin-bottom:0;
            text-align:left;
            transition:background-color 0.2s
        }
        .products .product-category .thumb-info h3 {
            font-weight:700;
            color:inherit
        }
        .products .product-category .thumb-info-title {
            background:none;
            max-width:none;
            width:100%;
            bottom:0;
            padding:1.2em 1.5em;
            margin:0
        }
        .products .product-category .thumb-info-type {
            display:block;
            margin:0;
            padding:0;
            font-weight:400;
            background:none;
            float:none;
            opacity:0.7;
            line-height:1.8
        }
        .products .product-category mark {
            padding:0;
            background:none;
            color:inherit
        }
        .products .product-category .thumb-info-wrapper:after {
            background:rgba(27,27,23,0.15);
            z-index:1;
            opacity:1
        }
        .products .product-category:hover .thumb-info-wrapper:after {
            background:rgba(27,27,23,0.3)
        }
        ul.category-color-dark li.product-category .thumb-info-title {
            color:var(--porto-dark-color)
        }
        ul.category-color-primary li.product-category .thumb-info-title {
            color:var(--porto-primary-color)
        }
        ul.category-color-secondary li.product-category .thumb-info-title {
            color:var(--porto-secondary-color)
        }
        ul.products li.cat-has-icon .thumb-info {
            padding:40px 0 25px;
            transition:box-shadow 0.2s,background-color 0.2s;
            text-align:center
        }
        ul.products li.cat-has-icon .thumb-info i {
            display:inline-block
        }
        ul.products li.cat-has-icon .thumb-info>i {
            font-size:3em;
            display:inline-block;
            margin-bottom:15px;
            color:var(--porto-dark-color)
        }
        ul.products li.cat-has-icon:hover .thumb-info>i {
            color:var(--porto-primary-color)
        }
        ul.products li.cat-has-icon .thumb-info-wrap {
            display:block
        }
        ul.products li.cat-has-icon .thumb-info-title {
            display:block;
            position:static;
            padding:0 0 10px
        }
        ul.products.category-pos-middle li.product-category .thumb-info-title {
            position:absolute;
            bottom:auto;
            top:50%;
            transform:translateY(-50%)
        }
        ul.products.category-pos-outside li.product-category .thumb-info-title {
            position:static;
            transform:none;
            display:block;
            padding-left:0;
            padding-right:0
        }
        .category-text-center .thumb-info-title {
            text-align:center
        }
        .category-text-right .thumb-info-title {
            text-align:right
        }
        .category-text-left .thumb-info-title {
            text-align:left
        }
        li.product-category .thumb-info-title a {
            color:inherit
        }
        li.product-category .thumb-info-title a:hover {
            color:inherit
        }
        li.product-category .sub-categories {
            font-size:0.875rem;
            font-weight:400;
            opacity:0.7
        }
        .grid-creative.category-pos-outside li.product-category .thumb-info {
            height:calc(100% - 60px)
        }
        .porto-products.show-count-on-hover li.product-category .thumb-info-type {
            max-height:10px;
            transition:0.5s;
            transform:translateY(20%);
            opacity:0
        }
        .porto-products.show-count-on-hover li.product-category:hover .thumb-info-type {
            max-height:30px;
            transform:translateY(0);
            opacity:0.7
        }
        .porto-products.hide-count li.product-category .thumb-info-type {
            display:none
        }
        .porto-products.hide-count li.product-category .thumb-info h3 {
            margin-bottom:0
        }
        ul.products .woocommerce-loop-product__title {
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis
        }
        ul.products .add-links .button {
            overflow:hidden
        }
        ul.products .category-list {
            display:block;
            font-size:0.625rem;
            opacity:0.8;
            text-transform:uppercase;
            line-height:1.7;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis
        }
        ul.products .category-list a:not(:hover) {
            color:inherit
        }
        li.product-default .price {
            margin-bottom:0.875rem
        }
        li.product-default:not(.product-type-simple) .add-links .button:before {
            display:none
        }
        li.product-default.show-links-hover {
            padding-top:50px;
            padding-bottom:0;
            transition:0.3s
        }
        li.product-default.show-links-hover .add-links-wrap {
            visibility:hidden;
            opacity:0;
            transition:0.3s;
            margin:0 -50px -10px
        }
        li.product-default.show-links-hover .add-links {
            margin-bottom:0
        }
        li.product-default.show-links-hover .product-image {
            box-shadow:none
        }
        li.product-default.show-links-hover:hover {
            padding-top:10px;
            padding-bottom:40px
        }
        li.product-default.show-links-hover:hover .add-links-wrap {
            visibility:visible;
            opacity:1
        }
        li.product-default,
        li.product-wq_onimage {
            text-align:center
        }
        li.product-default .rating-wrap,
        li.product-wq_onimage .rating-wrap {
            margin-left:auto;
            margin-right:auto
        }
        li.product-default .filter-item-list,
        li.product-wq_onimage .filter-item-list {
            justify-content:center
        }
        li.product-onimage2 .product-image .inner:after,
        li.product-onimage3 .product-image .inner:after,
        li.product-outimage_aq_onimage .product-image .inner:after {
            content:"";
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            background-color:rgba(27,27,23,0.3);
            transition:0.25s
        }
        li.product-outimage_aq_onimage {
            text-align:left
        }
        li.product-outimage_aq_onimage .add-links .button {
            position:absolute;
            z-index:3;
            right:15px;
            top:15px;
            width:36px;
            padding:0;
            border-radius:18px;
            opacity:0;
            text-indent:-9999px
        }
        li.product-outimage_aq_onimage .add-links .button:before {
            text-indent:0;
            width:100%
        }
        li.product-outimage_aq_onimage .add-links .yith-compare {
            top:60px
        }
        li.product-outimage_aq_onimage .add-links .quickview {
            bottom:0;
            top:auto;
            left:0;
            width:100%;
            text-indent:0;
            padding:0.1rem 0;
            height:auto;
            border:none
        }
        li.product-outimage_aq_onimage .add-links .quickview:before {
            content:none
        }
        li.product-outimage_aq_onimage .add-links .yith-wcwl-add-to-wishlist {
            display:none
        }
        li.product-outimage_aq_onimage .links-on-image .add-links-wrap {
            display:block
        }
        li.product-outimage_aq_onimage .product-image .inner:after {
            background:rgba(0,0,0,0.1);
            opacity:0;
            transition:opacity 0.2s
        }
        li.product-outimage_aq_onimage:hover .button {
            opacity:1
        }
        li.product-outimage_aq_onimage:hover .add-links .quickview {
            padding:0.45rem 0
        }
        li.product-outimage_aq_onimage:hover .sale-product-daily-deal {
            display:none
        }
        li.product-outimage_aq_onimage:hover .product-image .inner:after {
            opacity:1
        }
        li.product-outimage_aq_onimage.with-padding,
        li.product-outimage_aq_onimage.with-padding .product-image {
            margin-bottom:0
        }
        li.product-outimage_aq_onimage.with-padding .product-content {
            padding:15px 15px 1px
        }
        .porto-type-builder-product-type .yith-wcwl-add-to-wishlist,
        li.product-outimage_aq_onimage .yith-wcwl-add-to-wishlist {
            float:right;
            position:relative;
            z-index:2;
            margin-left:10px
        }
        .porto-type-builder-product-type .yith-wcwl-add-to-wishlist a,
        .porto-type-builder-product-type .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip),
        li.product-outimage_aq_onimage .yith-wcwl-add-to-wishlist a,
        li.product-outimage_aq_onimage .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            opacity:0.7;
            border:none;
            background:none;
            color:var(--porto-shop-add-links-color,#333);
            height:auto;
            width:1.4em;
            line-height:1.2
        }
        .porto-type-builder-product-type .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
        li.product-outimage_aq_onimage .yith-wcwl-add-to-wishlist .add_to_wishlist:hover {
            opacity:1
        }
        .porto-type-builder-product-type .yith-wcwl-add-to-wishlist span.separator,
        li.product-outimage_aq_onimage .yith-wcwl-add-to-wishlist span.separator {
            text-indent:0
        }
        ul.grid.divider-line li.product-outimage_aq_onimage.with-padding .quickview {
            left:15px;
            right:15px;
            width:auto
        }
        ul.grid.divider-line .product-image {
            border:none
        }
        li.product-awq_onimage .links-on-image .add-links {
            position:absolute;
            z-index:2
        }
        li.product-awq_onimage .add-links {
            display:flex;
            right:15px;
            bottom:0
        }
        li.product-awq_onimage .add-links>:not(:last-child) {
            margin-right:3px
        }
        li.product-awq_onimage .add-links .button {
            text-indent:-9999px;
            padding:0 8px
        }
        li.product-awq_onimage .add-links .button:before {
            text-indent:0;
            margin:0;
            width:18px
        }
        li.product-awq_onimage .add-links .yith-wcwl-add-button .button:before {
            width:100%
        }
        li.product-awq_onimage .add-links .quickview,
        li.product-awq_onimage .add-links .yith-compare,
        li.product-awq_onimage .add-links .yith-wcwl-add-to-wishlist>div {
            position:relative;
            opacity:1!important
        }
        li.product-awq_onimage .add-links .button,
        li.product-awq_onimage .add-links .quickview,
        li.product-awq_onimage .add-links .yith-wcwl-add-to-wishlist a,
        li.product-awq_onimage .add-links .yith-wcwl-add-to-wishlist span {
            border-radius:18px;
            overflow:hidden
        }
        li.product-awq_onimage .add-links .yith-compare {
            top:auto;
            right:auto
        }
        li.product-outimage .add-links {
            display:flex
        }
        li.product-outimage .add-links>:not(:last-child) {
            margin-right:6px
        }
        li.product-outimage .add-links .quickview,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist>div {
            position:relative
        }
        li.product-outimage .add-links .button,
        li.product-outimage .add-links .quickview,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist a,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            border:none;
            line-height:36px
        }
        li.product-outimage .add-links .button {
            padding-left:1rem;
            padding-right:1rem
        }
        @media (max-width:767px) {
            li.product-outimage .add-links .button {
                padding-left:0.6rem;
                padding-right:0.6rem
            }
            li.product-outimage .add-links .button:before {
                display:none
            }
        }
        li.product-outimage .add-links .button,
        li.product-outimage .add-links .quickview,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist a,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            background:#f4f4f4
        }
        li.product-outimage .add-links .button:focus,
        li.product-outimage .add-links .button:hover,
        li.product-outimage .add-links .quickview:hover,
        li.product-outimage .add-links .yith-wcwl-add-to-wishlist a:hover {
            background:var(--porto-primary-color)
        }
        li.product-outimage:hover .add-links .quickview,
        li.product-outimage:hover .add-links .yith-wcwl-add-to-wishlist>div {
            opacity:1
        }
        @media (max-width:575px) {
            .pcols-ls-2 li.product-outimage .add-links .button {
                padding:0 0.4rem;
                width:36px;
                text-indent:-9999px
            }
            .pcols-ls-2 li.product-outimage .add-links .button:before {
                display:block;
                text-indent:0;
                width:100%
            }
        }
        @media (min-width:576px) {
            li.product-outimage:not(.product-type-simple) .add-links .button:before {
                display:none
            }
        }
        li.product-onimage {
            overflow:hidden
        }
        li.product-onimage .product-inner {
            position:relative
        }
        li.product-onimage .product-image {
            margin-bottom:0
        }
        li.product-onimage .links-on-image .button,
        li.product-onimage .links-on-image .quickview {
            display:none!important
        }
        li.product-onimage .links-on-image .yith-wcwl-add-to-wishlist>div {
            position:absolute;
            top:10px;
            right:10px;
            left:auto
        }
        li.product-onimage .links-on-image .yith-wcwl-add-to-wishlist .blockUI,
        li.product-onimage .links-on-image .yith-wcwl-add-to-wishlist a,
        li.product-onimage .links-on-image .yith-wcwl-add-to-wishlist span {
            border-radius:20px
        }
        li.product-onimage .product-content {
            position:absolute;
            bottom:0;
            left:0;
            width:100%;
            z-index:2;
            padding:15px 20px 0;
            opacity:0;
            transition:transform 0.4s,opacity 0.2s;
            transform:translateZ(0) translateY(5px);
            background:var(--porto-normal-bg);
            border-top:1px solid var(--porto-input-bc)
        }
        li.product-onimage .product-content .yith-wcwl-add-to-wishlist {
            display:none
        }
        li.product-onimage .product-content .add-links {
            border-top:1px solid var(--porto-input-bc)
        }
        li.product-onimage .add-links {
            position:static;
            display:flex;
            flex-direction:row-reverse;
            margin:0 -20px
        }
        li.product-onimage .add-links>* {
            flex:1;
            min-width:50%
        }
        li.product-onimage .add-links .button:not(:hover):not(:focus) {
            background:#f4f4f4
        }
        li.product-onimage .add-links .button,
        li.product-onimage .add-links .quickview {
            height:45px;
            line-height:44px;
            border:none
        }
        li.product-onimage .add-links .button:before {
            display:none
        }
        li.product-onimage .add-links .yith-wcwl-add-button .button {
            display:block!important;
            height:36px;
            line-height:34px;
            border:1px solid var(--porto-shop-add-links-border-color,transparent)
        }
        li.product-onimage .add-links .yith-wcwl-add-button .button:before {
            display:block
        }
        li.product-onimage .add-links .quickview {
            position:static;
            background:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse,#fff);
            text-indent:0;
            opacity:0.85;
            visibility:visible
        }
        li.product-onimage .add-links .quickview:before {
            display:none
        }
        li.product-onimage:hover .product-content {
            opacity:1;
            transform:translateZ(0) translateY(0)
        }
        li.product-onimage:not(.product-type-simple) .add-links .button:before {
            display:none
        }
        li.product-onimage .description,
        li.product-onimage2 .description,
        li.product-onimage3 .description {
            display:none
        }
        li.product-onimage2 .product-inner,
        li.product-onimage3 .product-inner {
            position:relative;
            overflow:hidden
        }
        li.product-onimage2 .price,
        li.product-onimage2 h3,
        li.product-onimage2 span,
        li.product-onimage3 .price,
        li.product-onimage3 h3,
        li.product-onimage3 span {
            color:#fff
        }
        li.product-onimage2 .star-rating:before,
        li.product-onimage3 .star-rating:before {
            color:rgba(255,255,255,0.6)
        }
        li.product-onimage2 .star-rating span:before,
        li.product-onimage3 .star-rating span:before {
            color:inherit
        }
        li.product-onimage2 .price,
        li.product-onimage3 .price {
            margin-bottom:0
        }
        li.product-onimage2 .add-links .button,
        li.product-onimage2 .add-links .yith-wcwl-add-to-wishlist a,
        li.product-onimage2 .add-links .yith-wcwl-add-to-wishlist span,
        li.product-onimage3 .add-links .button,
        li.product-onimage3 .add-links .quickview,
        li.product-onimage3 .add-links .yith-wcwl-add-to-wishlist a,
        li.product-onimage3 .add-links .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            border-color:#fff;
            border-width:2px;
            color:#fff;
            background-color:#4d4d4a;
            border-radius:2rem;
            overflow:hidden
        }
        li.product-onimage2 .product-image {
            margin-bottom:0;
            position:static
        }
        li.product-onimage2 .product-image .inner:after {
            opacity:0
        }
        li.product-onimage2 .links-on-image .add-links {
            position:absolute
        }
        li.product-onimage2 .add-links {
            top:15px;
            right:12px;
            display:flex;
            justify-content:center;
            z-index:3
        }
        li.product-onimage2 .add-links>* {
            margin:0 3px;
            opacity:0.85!important
        }
        li.product-onimage2 .add-links>:hover {
            opacity:1!important
        }
        li.product-onimage2 .add-links .button {
            line-height:32px;
            text-indent:-9999px;
            padding:0 7px
        }
        li.product-onimage2 .add-links .button:before {
            text-indent:0;
            margin:0;
            width:18px;
            line-height:inherit
        }
        li.product-onimage2 .add-links .yith-wcwl-add-button .button:before {
            width:100%
        }
        li.product-onimage2 .add-links .yith-wcwl-add-to-wishlist>div {
            position:relative
        }
        li.product-onimage2 .add-links .yith-wcwl-add-to-wishlist a,
        li.product-onimage2 .add-links .yith-wcwl-add-to-wishlist span {
            line-height:32px
        }
        li.product-onimage2 .quickview {
            position:absolute;
            top:auto;
            bottom:0;
            left:0;
            right:0;
            border:none;
            color:var(--porto-primary-color-inverse,#fff);
            background:var(--porto-primary-color);
            padding:0.45rem 0;
            text-transform:uppercase;
            line-height:32px;
            opacity:0.85
        }
        li.product-onimage2 .quickview:hover {
            opacity:1
        }
        li.product-onimage2 .yith-compare {
            position:static
        }
        li.product-onimage2 .product-content {
            position:absolute;
            left:0;
            right:0;
            top:50%;
            transform:scale(0.9) translateZ(0) translateY(-50%);
            text-align:center;
            z-index:2;
            opacity:0;
            transition:opacity 0.5s,transform 0.3s
        }
        li.product-onimage2 .rating-wrap {
            margin-left:auto;
            margin-right:auto
        }
        li.product-onimage2:hover .product-content {
            transform:scale(1) translateZ(0) translateY(-50%);
            opacity:1
        }
        li.product-onimage2:hover .product-image .inner:after {
            opacity:1
        }
        li.product-onimage3 .product-image {
            margin-bottom:0
        }
        li.product-onimage3 .product-content {
            position:absolute;
            bottom:-5px;
            left:0;
            right:0;
            padding:0 20px 20px;
            z-index:2;
            opacity:0;
            transition:0.3s
        }
        li.product-onimage3 .add-links .button,
        li.product-onimage3 .add-links .yith-wcwl-add-to-wishlist a,
        li.product-onimage3 .add-links .yith-wcwl-add-to-wishlist span:not(.yith-wcwl-tooltip) {
            line-height:32px
        }
        li.product-onimage3 .add-links>* {
            opacity:0.85!important;
            transition:opacity 0.2s
        }
        li.product-onimage3 .add-links>:hover {
            opacity:1!important
        }
        li.product-onimage3 .add-links .button {
            text-indent:-9999px;
            position:absolute;
            right:15px;
            top:15px;
            padding:0 7px
        }
        li.product-onimage3 .add-links .button:before {
            text-indent:0;
            margin:0;
            width:18px;
            line-height:inherit
        }
        li.product-onimage3 .add-links .yith-wcwl-add-button .button {
            position:relative;
            top:0;
            right:0
        }
        li.product-onimage3 .add-links .yith-wcwl-add-button .button:before {
            width:100%
        }
        li.product-onimage3 .add-links .yith-compare {
            right:105px
        }
        li.product-onimage3 .add-links .yith-wcwl-add-to-wishlist>div {
            top:15px;
            right:60px;
            left:auto
        }
        li.product-onimage3 .add-links .quickview {
            text-indent:0;
            padding:0.1rem 1.5rem;
            width:auto;
            height:auto;
            top:50%;
            right:50%;
            transform:translateZ(0) translateX(50%);
            margin-top:-20px;
            white-space:nowrap
        }
        li.product-onimage3 .add-links .quickview:before {
            display:none
        }
        li.product-onimage3 .product-loop-title:hover {
            color:#fff
        }
        li.product-onimage3:hover .product-image .inner:after {
            background-color:rgba(27,27,23,0.7)
        }
        li.product-onimage3:hover .product-content {
            opacity:1;
            bottom:0
        }
        li.product-wq_onimage .add-links .quickview,
        li.product-wq_onimage .add-links .yith-compare,
        li.product-wq_onimage .add-links .yith-wcwl-add-to-wishlist {
            display:none
        }
        li.product-wq_onimage .links-on-image .button,
        li.product-wq_onimage .links-on-image .quantity {
            display:none
        }
        li.product-wq_onimage .links-on-image .quickview {
            display:block;
            bottom:0;
            top:auto;
            left:0;
            width:100%;
            text-indent:0;
            padding:0.4rem 0;
            height:auto;
            border:none;
            background:var(--porto-primary-color);
            color:var(--porto-primary-color-inverse,#fff);
            z-index:1
        }
        li.product-wq_onimage .links-on-image .quickview:before {
            content:none
        }
        li.product-wq_onimage .links-on-image .yith-wcwl-add-to-wishlist {
            display:block
        }
        li.product-wq_onimage .links-on-image .yith-wcwl-add-to-wishlist>div {
            top:15px;
            left:auto;
            right:15px
        }
        li.product-wq_onimage .links-on-image .yith-wcwl-add-to-wishlist .blockUI,
        li.product-wq_onimage .links-on-image .yith-wcwl-add-to-wishlist a {
            border-radius:18px
        }
        li.product-wq_onimage .links-on-image .yith-compare {
            display:block
        }
        li.product-wq_onimage:hover .sale-product-daily-deal {
            display:none
        }
        ul.products.grid-creative .product-image,
        ul.products.grid-creative .product-image .inner,
        ul.products.grid-creative .product-inner {
            height:100%
        }
        ul.products.grid-creative li.product-col {
            padding-bottom:var(--porto-el-spacing,var(--porto-grid-gutter-width))
        }
        ul.products.grid-creative li.product-col,
        ul.products.grid-creative li.product-col .product-image {
            margin-bottom:0
        }
        ul.products .filter-item-list .active .filter-color:before,
        ul.products .filter-item-list .chosen .filter-color:before {
            --porto-sw-offset:-3px
        }
        ul.products .filter-item-list .filter-color {
            --porto-sw-size:17px;
            margin:3px 6px 3px 0
        }
        ul.grid.divider-line {
            margin-left:0;
            margin-right:0
        }
        ul.grid.divider-line>.product-col {
            border-right:1px solid var(--porto-input-bc);
            border-bottom:1px solid var(--porto-input-bc)
        }
        ul.grid.divider-line .product-col {
            padding-left:0;
            padding-right:0;
            margin-bottom:0
        }
        ul.grid.divider-line .product-col:hover {
            z-index:2;
            box-shadow:0 25px 35px -5px rgba(0,0,0,0.1)
        }
        ul.grid.divider-line .product-col:hover .product-image {
            box-shadow:none
        }
        @media (min-width:576px) and (max-width:767px) {
            .divider-line.pcols-xs-2>.product-col:nth-child(2n),
            .divider-line.pcols-xs-3>.product-col:nth-child(3n) {
                border-right-width:0
            }
        }
        @media (max-width:575px) {
            .divider-line.pcols-ls-2>.product-col:nth-child(2n) {
                border-right-width:0
            }
        }
        @media (min-width:576px) {
            ul.list li.product .product-inner {
                display:flex;
                align-items:center
            }
            ul.list li.product .product-image {
                flex:0 0 250px;
                margin:0 20px 0 0
            }
            ul.list li.product .product-content {
                flex:1 1 auto;
                max-width:calc(100% - 250px)
            }
        }
        ul.list li.product {
            text-align:left;
            margin-bottom:var(--porto-grid-gutter-width)
        }
        ul.list li.product .description {
            margin-top:0;
            margin-bottom:1em;
            overflow:hidden;
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical
        }
        ul.list li.product .description p:last-child {
            margin-bottom:0
        }
        ul.list li.product h3 {
            font-size:1.2857em;
            font-weight:600
        }
        ul.list li.product .add-links {
            display:flex;
            flex-wrap:wrap;
            margin-bottom:0
        }
        ul.list li.product .add-links .quickview,
        ul.list li.product .add-links .yith-wcwl-add-to-wishlist>div {
            position:relative;
            left:0!important;
            opacity:1;
            visibility:visible
        }
        ul.list li.product .add-links>* {
            margin:0 0.25rem 0.375rem 0
        }
        ul.list li.product .add-links-wrap:not(:last-child) {
            margin-bottom:0.8em
        }
        ul.list li.product .product-inner>script,
        ul.list li.product .product-inner>style {
            display:none
        }
        ul.list li.product .variations .filter-item-list {
            margin-bottom:0
        }
        ul.list li.product .variations td {
            padding-bottom:0
        }
        ul.list li.product .filter-item-list li {
            margin-bottom:0
        }
        ul.list li.product .rating-wrap {
            margin-left:0;
            margin-right:0
        }
        ul.list li.product:hover .product-image {
            box-shadow:none
        }
        ul.list .add-links {
            font-size:1em
        }
        ul.products.list li.product-category img {
            width:100%;
            font-size:1em
        }
        .related.products .slider-title,
        .title-border-bottom>.section-title {
            letter-spacing:-0.01em;
            line-height:22px;
            padding-bottom:10px;
            margin-bottom:24px;
            border-bottom:1px solid var(--porto-input-bc)
        }
        .porto-products.title-border-bottom .products-slider.show-dots-title-right .owl-dots,
        .related.products .products-slider.show-dots-title-right .owl-dots {
            top:-52px;
            height:32px
        }
        .porto-products.title-border-bottom .products-slider.show-nav-title .owl-nav,
        .related.products .products-slider.show-nav-title .owl-nav {
            margin-top:-36px
        }
        .title-border-middle>.section-title {
            display:flex;
            align-items:center;
            margin-bottom:20px
        }
        .title-border-middle>.section-title:after,
        .title-border-middle>.section-title:before {
            border-bottom:1px solid var(--porto-input-bc);
            flex:1
        }
        .title-border-middle>.section-title:before {
            margin-right:1em
        }
        .title-border-middle>.section-title:after {
            content:"";
            margin-left:1em
        }
        .title-border-middle>.text-right {
            padding-right:75px
        }
        .title-border-middle>.text-right:before {
            content:""
        }
        .title-border-middle>.text-right:after {
            content:none
        }
        .title-border-middle>.text-center:before {
            content:""
        }
        .title-border-middle>.border-right-spacing:after {
            margin-right:75px
        }
        .products-slider.show-dots-title-right .owl-dots {
            top:-40px;
            height:32px
        }
        .products-slider.owl-carousel .owl-dots.disabled {
            display:none
        }
        .products-slider.owl-carousel.dots-style-1 .owl-dot {
            vertical-align:middle
        }
        .products-slider.owl-carousel.dots-style-1 .owl-dot span {
            position:relative;
            width:14px;
            height:14px;
            border:2px solid;
            background:none;
            margin:5px 2px;
            border-radius:7px;
            opacity:0.4;
            color:var(--porto-primary-dark-20)
        }
        .products-slider.owl-carousel.dots-style-1 .owl-dot.active span,
        .products-slider.owl-carousel.dots-style-1 .owl-dot:hover span {
            background:none;
            color:var(--porto-primary-color);
            opacity:1
        }
        .products-slider.owl-carousel.dots-style-1 .owl-dot.active span:after,
        .products-slider.owl-carousel.dots-style-1 .owl-dot:hover span:after {
            content:"";
            position:absolute;
            left:3px;
            bottom:3px;
            right:3px;
            top:3px;
            border-radius:10px;
            border:2px solid
        }
        .porto-products .product-categories {
            list-style:none;
            padding-left:0
        }
        .porto-products.filter-vertical {
            display:flex;
            flex-wrap:wrap
        }
        .porto-products.filter-vertical .section-title {
            width:100%
        }
        .porto-products.filter-vertical .shop-loop-before {
            display:none!important
        }
        .porto-products.filter-vertical .products-filter,
        .porto-products.filter-vertical .products-filter+div {
            width:100%
        }
        @media (min-width:768px) {
            .porto-products.filter-vertical .products-filter {
                flex:0 0 auto;
                width:16.6666%;
                border-right:1px solid #dcdcdc;
                padding-left:15px;
                padding-right:15px
            }
            .porto-products.filter-vertical .products-filter+div {
                flex:0 0 auto;
                width:83.3333%;
                padding-left:15px;
                padding-right:15px
            }
        }
        @media (max-width:767px) {
            .porto-products.filter-vertical .product-categories li {
                display:inline-block;
                margin-right:20px
            }
        }
        .porto-products.filter-vertical .product-categories a {
            display:block;
            position:relative;
            padding:12px 0 12px 20px
        }
        .porto-products.filter-vertical .product-categories a:before {
            content:"\f87a";
            font-family:"porto";
            margin-right:10px;
            width:11px;
            position:absolute;
            left:0
        }
        .porto-products.filter-vertical .product-categories .current a:before {
            content:"\f87b"
        }
        .porto-products.filter-horizontal .product-categories li {
            display:inline-block;
            margin-right:2rem
        }
        .column2 ul.products.owl-loaded li.product-col,
        .column2 ul.products.owl-loading li.product-col,
        ul.products.owl-loaded li.product-col,
        ul.products.owl-loading li.product-col {
            width:auto
        }
        ul.products.product_list_widget .product {
            text-align:left
        }
        ul.products.product_list_widget .product .product-image {
            margin-right:15px;
            min-height:0
        }
        ul.products.product_list_widget .product .rating-wrap {
            display:block;
            margin:-5px 0 6px;
            height:auto
        }
        ul.products.product_list_widget .add-links {
            font-size:0.8571em
        }
        ul.products.product_list_widget .add-links .add_to_cart_button,
        ul.products.product_list_widget .add-links .add_to_cart_read_more {
            text-indent:0!important
        }
        ul.products.product_list_widget .add-links .add_to_cart_button:before,
        ul.products.product_list_widget .add-links .add_to_cart_read_more:before {
            display:none
        }
        ul.products.product_list_widget .add-links .tooltip {
            display:none!important
        }
        ul.products.product_list_widget .add-links .quickview,
        ul.products.product_list_widget .description,
        ul.products.product_list_widget .labels,
        ul.products.product_list_widget .yith-wcwl-add-to-wishlist {
            display:none
        }
        ul.products.product_list_widget .rating-wrap .star-rating {
            margin-left:0!important;
            font-size:1em
        }
        ul.products.product_list_widget .rating-wrap .star-rating span:before,
        ul.products.product_list_widget .rating-wrap .star-rating:before {
            left:0!important
        }
        ul.products.product_list_widget .add-links-wrap {
            display:block!important
        }
        ul.products.product_list_widget .links-on-image .add-links-wrap {
            display:none!important
        }
        .yith-wcan-loading {
            min-height:200px;
            height:auto;
            opacity:0.6!important
        }
        .products.yith-wcan-loading .porto-loading-icon {
            position:fixed;
            z-index:9999
        }
        li.product-default .add-links .yith-compare,
        li.product-onimage .add-links .yith-compare,
        li.product-outimage .add-links .yith-compare {
            display:none
        }
        .product-image .yith-compare {
            position:absolute;
            top:55px;
            right:15px;
            padding:0;
            text-indent:-9999px;
            border-radius:18px
        }
        .product-image .yith-compare:before {
            width:100%;
            text-indent:0
        }
        .product-image>.yith-compare {
            top:15px;
            width:36px;
            height:36px;
            line-height:34px;
            opacity:0
        }
        .product-image>.yith-compare:before {
            content:"\e810";
            font-family:"porto";
            position:relative;
            float:left
        }
        .product-image>.yith-compare.added:before {
            content:"\f00c";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            line-height:36px
        }
        li.product-col:hover .product-image>.yith-compare {
            opacity:1
        }
        .product-onimage .product-image>.yith-compare {
            top:50px;
            right:10px
        }
        .uni-cpo-calculate-btn,
        li.product-col .add_to_cart_button,
        li.product-col .add_to_cart_read_more,
        li.product-col .quickview {
            font-family:var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif
        }
        .porto-product-category-widget .thumb-info .btn {
            padding-left:0;
            padding-right:0
        }
        .porto-product-category-widget ul.products .rating-wrap {
            margin-left:auto;
            margin-right:auto
        }
        #loading-mask {
            font-size:1.1em;
            font-weight:700;
            position:fixed;
            text-align:center;
            z-index:20002;
            width:100%;
            height:100%;
            left:0;
            top:0
        }
        .loader-container {
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            z-index:199;
            text-align:center;
            background-color:rgba(255,255,255,0.5);
            display:none
        }
        .loader-container>.loader {
            position:absolute;
            width:100%;
            top:50%;
            margin-top:-17px
        }
        .loader-container i.porto-ajax-loader {
            display:inline-block;
            border:2px solid transparent;
            border-top-color:var(--porto-primary-color);
            width:40px;
            height:40px;
            vertical-align:middle;
            border-radius:20px;
            animation:spin 0.75s infinite linear;
            display:inline-block
        }
        .loader-container i.porto-ajax-loader:before {
            left:-2px;
            top:-2px;
            display:inline-block;
            position:absolute;
            content:"";
            width:inherit;
            height:inherit;
            border:inherit;
            border-radius:inherit;
            border-top-color:inherit;
            animation:spin 1.5s infinite ease
        }
        li.product-col .loader-container i.porto-ajax-loader {
            width:34px;
            height:34px
        }
        .after-loading-success-message {
            display:none;
            font-size:1.1em;
            position:fixed;
            text-align:center;
            z-index:20002
        }
        .after-loading-success-message.style-2 {
            width:100%;
            height:100%;
            left:0;
            top:0
        }
        .after-loading-success-message.style-3 {
            right:20px;
            bottom:0
        }
        .background-overlay {
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            opacity:0.5;
            background-color:transparent
        }
        .success-message-container {
            margin:auto;
            padding:20px 14px;
            line-height:1.4;
            position:relative;
            text-align:center;
            top:35%;
            width:300px;
            z-index:1000;
            background:#fff;
            box-shadow:0 0 5px rgba(0,0,0,0.5)
        }
        .success-message-container .msg {
            display:block;
            margin-bottom:10px;
            font-size:13px
        }
        .success-message-container img {
            display:inline-block;
            width:30%;
            margin-left:auto;
            margin-right:auto
        }
        .style-2>.success-message-container {
            border-top:4px solid var(--porto-primary-color)
        }
        .style-2>.success-message-container .product-name {
            font-size:14px;
            margin:5px 0 10px
        }
        .style-2>.success-message-container button {
            margin-top:12px;
            padding:8.5px 0;
            min-width:133px
        }
        .style-3>.success-message-container {
            text-align:left;
            margin-bottom:20px;
            padding:20px;
            box-shadow:0 1px 30px rgba(0,0,0,0.08);
            word-break:break-word;
            transform:translateX(100px);
            opacity:0;
            transition:transform 0.4s ease-in-out,opacity 0.4s ease-in-out
        }
        .style-3>.success-message-container.active {
            transform:translateX(0);
            opacity:1
        }
        .style-3>.success-message-container .msg-box {
            display:flex;
            align-items:center;
            margin-bottom:20px
        }
        .style-3>.success-message-container .msg {
            order:2;
            letter-spacing:-0.025em;
            font-weight:500;
            margin-bottom:0;
            font-size:0.75rem
        }
        .style-3>.success-message-container .continue_shopping {
            float:right
        }
        .style-3>.success-message-container img {
            width:60px;
            margin:0 12px 0 0
        }
        .style-3>.success-message-container .btn {
            min-width:120px;
            letter-spacing:0.025em
        }
        .success-message-container .product-name a:not(:hover) {
            color:var(--porto-dark-color,#212529)
        }
        .success-message-container .woocommerce-loop-product__title {
            font-size:0.75rem;
            font-weight:700;
            letter-spacing:inherit;
            line-height:1.4;
            margin:0 0 0.25rem
        }
        .success-message-container .product-loop-title:hover>.woocommerce-loop-product__title {
            color:inherit
        }
        .compare-msg p,
        .sales-msg p {
            font-size:inherit
        }
        .compare-msg a:hover .product-title,
        .sales-msg a:hover .product-title {
            color:inherit
        }
        .compare-msg .product-title,
        .sales-msg .product-title {
            font-size:0.75rem;
            transition:color 0.3s
        }
        .compare-msg .price,
        .sales-msg .price {
            font-size:0.875rem
        }
        .compare-msg .compare-popup-title,
        .compare-msg .sales-popup-title,
        .sales-msg .compare-popup-title,
        .sales-msg .sales-popup-title {
            font-size:0.75rem;
            font-weight:500;
            margin-bottom:0.625rem
        }
        .sidebar-box,
        .widget_layered_nav,
        .widget_layered_nav_filters,
        .widget_price_filter,
        .widget_product_categories,
        .widget_rating_filter {
            border:none;
            margin-bottom:1.0714em;
            margin-top:0;
            position:relative;
            background:none
        }
        .sidebar-box>*,
        .sidebar-box>div>ul,
        .sidebar-box>ul,
        .widget_layered_nav>*,
        .widget_layered_nav>div>ul,
        .widget_layered_nav>ul,
        .widget_layered_nav_filters>*,
        .widget_layered_nav_filters>div>ul,
        .widget_layered_nav_filters>ul,
        .widget_price_filter>*,
        .widget_price_filter>div>ul,
        .widget_price_filter>ul,
        .widget_product_categories>*,
        .widget_product_categories>div>ul,
        .widget_product_categories>ul,
        .widget_rating_filter>*,
        .widget_rating_filter>div>ul,
        .widget_rating_filter>ul {
            padding:0.7143em 0;
            border-width:0;
            margin:0
        }
        .sidebar-box>.select2-container,
        .widget_layered_nav>.select2-container,
        .widget_layered_nav_filters>.select2-container,
        .widget_price_filter>.select2-container,
        .widget_product_categories>.select2-container,
        .widget_rating_filter>.select2-container {
            padding-top:0;
            margin-top:0.7143em
        }
        .sidebar-box>select,
        .widget_layered_nav>select,
        .widget_layered_nav_filters>select,
        .widget_price_filter>select,
        .widget_product_categories>select,
        .widget_rating_filter>select {
            margin:1.0714em 5%;
            width:90%;
            padding:0.8em 1em;
            box-shadow:0 0 2px rgba(0,0,0,0.3) inset
        }
        .sidebar-box .widget-title,
        .widget_layered_nav .widget-title,
        .widget_layered_nav_filters .widget-title,
        .widget_price_filter .widget-title,
        .widget_product_categories .widget-title,
        .widget_rating_filter .widget-title {
            color:var(--porto-heading-color);
            font-weight:600;
            line-height:1.4;
            padding:0;
            margin:0;
            text-transform:uppercase;
            transition:0.25s
        }
        .sidebar-box ol li,
        .sidebar-box ul li,
        .widget_layered_nav ol li,
        .widget_layered_nav ul li,
        .widget_layered_nav_filters ol li,
        .widget_layered_nav_filters ul li,
        .widget_price_filter ol li,
        .widget_price_filter ul li,
        .widget_product_categories ol li,
        .widget_product_categories ul li,
        .widget_rating_filter ol li,
        .widget_rating_filter ul li {
            position:relative;
            border-width:0;
            padding:0
        }
        .sidebar-box ol li>a,
        .sidebar-box ul li>a,
        .widget_layered_nav ol li>a,
        .widget_layered_nav ul li>a,
        .widget_layered_nav_filters ol li>a,
        .widget_layered_nav_filters ul li>a,
        .widget_price_filter ol li>a,
        .widget_price_filter ul li>a,
        .widget_product_categories ol li>a,
        .widget_product_categories ul li>a,
        .widget_rating_filter ol li>a,
        .widget_rating_filter ul li>a {
            display:inline-block;
            padding:4px 0;
            color:var(--porto-body-color)
        }
        .sidebar-box ol li .toggle:before,
        .sidebar-box ul li .toggle:before,
        .widget_layered_nav ol li .toggle:before,
        .widget_layered_nav ul li .toggle:before,
        .widget_layered_nav_filters ol li .toggle:before,
        .widget_layered_nav_filters ul li .toggle:before,
        .widget_price_filter ol li .toggle:before,
        .widget_price_filter ul li .toggle:before,
        .widget_product_categories ol li .toggle:before,
        .widget_product_categories ul li .toggle:before,
        .widget_rating_filter ol li .toggle:before,
        .widget_rating_filter ul li .toggle:before {
            content:"\f0fe";
            font-size:1.2em
        }
        .sidebar-box ol li.current>.toggle:before,
        .sidebar-box ol li.open>.toggle:before,
        .sidebar-box ul li.current>.toggle:before,
        .sidebar-box ul li.open>.toggle:before,
        .widget_layered_nav ol li.current>.toggle:before,
        .widget_layered_nav ol li.open>.toggle:before,
        .widget_layered_nav ul li.current>.toggle:before,
        .widget_layered_nav ul li.open>.toggle:before,
        .widget_layered_nav_filters ol li.current>.toggle:before,
        .widget_layered_nav_filters ol li.open>.toggle:before,
        .widget_layered_nav_filters ul li.current>.toggle:before,
        .widget_layered_nav_filters ul li.open>.toggle:before,
        .widget_price_filter ol li.current>.toggle:before,
        .widget_price_filter ol li.open>.toggle:before,
        .widget_price_filter ul li.current>.toggle:before,
        .widget_price_filter ul li.open>.toggle:before,
        .widget_product_categories ol li.current>.toggle:before,
        .widget_product_categories ol li.open>.toggle:before,
        .widget_product_categories ul li.current>.toggle:before,
        .widget_product_categories ul li.open>.toggle:before,
        .widget_rating_filter ol li.current>.toggle:before,
        .widget_rating_filter ol li.open>.toggle:before,
        .widget_rating_filter ul li.current>.toggle:before,
        .widget_rating_filter ul li.open>.toggle:before {
            content:"\f146"
        }
        .sidebar-box ol li.closed>.toggle:before,
        .sidebar-box ul li.closed>.toggle:before,
        .widget_layered_nav ol li.closed>.toggle:before,
        .widget_layered_nav ul li.closed>.toggle:before,
        .widget_layered_nav_filters ol li.closed>.toggle:before,
        .widget_layered_nav_filters ul li.closed>.toggle:before,
        .widget_price_filter ol li.closed>.toggle:before,
        .widget_price_filter ul li.closed>.toggle:before,
        .widget_product_categories ol li.closed>.toggle:before,
        .widget_product_categories ul li.closed>.toggle:before,
        .widget_rating_filter ol li.closed>.toggle:before,
        .widget_rating_filter ul li.closed>.toggle:before {
            content:"\f0fe"
        }
        .sidebar-box ol li.current>ol.children,
        .sidebar-box ol li.current>ul.children,
        .sidebar-box ul li.current>ol.children,
        .sidebar-box ul li.current>ul.children,
        .widget_layered_nav ol li.current>ol.children,
        .widget_layered_nav ol li.current>ul.children,
        .widget_layered_nav ul li.current>ol.children,
        .widget_layered_nav ul li.current>ul.children,
        .widget_layered_nav_filters ol li.current>ol.children,
        .widget_layered_nav_filters ol li.current>ul.children,
        .widget_layered_nav_filters ul li.current>ol.children,
        .widget_layered_nav_filters ul li.current>ul.children,
        .widget_price_filter ol li.current>ol.children,
        .widget_price_filter ol li.current>ul.children,
        .widget_price_filter ul li.current>ol.children,
        .widget_price_filter ul li.current>ul.children,
        .widget_product_categories ol li.current>ol.children,
        .widget_product_categories ol li.current>ul.children,
        .widget_product_categories ul li.current>ol.children,
        .widget_product_categories ul li.current>ul.children,
        .widget_rating_filter ol li.current>ol.children,
        .widget_rating_filter ol li.current>ul.children,
        .widget_rating_filter ul li.current>ol.children,
        .widget_rating_filter ul li.current>ul.children {
            display:block
        }
        .sidebar-box ol li .small,
        .sidebar-box ol li small,
        .sidebar-box ul li .small,
        .sidebar-box ul li small,
        .widget_layered_nav ol li .small,
        .widget_layered_nav ol li small,
        .widget_layered_nav ul li .small,
        .widget_layered_nav ul li small,
        .widget_layered_nav_filters ol li .small,
        .widget_layered_nav_filters ol li small,
        .widget_layered_nav_filters ul li .small,
        .widget_layered_nav_filters ul li small,
        .widget_price_filter ol li .small,
        .widget_price_filter ol li small,
        .widget_price_filter ul li .small,
        .widget_price_filter ul li small,
        .widget_product_categories ol li .small,
        .widget_product_categories ol li small,
        .widget_product_categories ul li .small,
        .widget_product_categories ul li small,
        .widget_rating_filter ol li .small,
        .widget_rating_filter ol li small,
        .widget_rating_filter ul li .small,
        .widget_rating_filter ul li small {
            float:right;
            font-size:1em
        }
        .sidebar-box ol ol,
        .sidebar-box ol ul,
        .sidebar-box ul ol,
        .sidebar-box ul ul,
        .widget_layered_nav ol ol,
        .widget_layered_nav ol ul,
        .widget_layered_nav ul ol,
        .widget_layered_nav ul ul,
        .widget_layered_nav_filters ol ol,
        .widget_layered_nav_filters ol ul,
        .widget_layered_nav_filters ul ol,
        .widget_layered_nav_filters ul ul,
        .widget_price_filter ol ol,
        .widget_price_filter ol ul,
        .widget_price_filter ul ol,
        .widget_price_filter ul ul,
        .widget_product_categories ol ol,
        .widget_product_categories ol ul,
        .widget_product_categories ul ol,
        .widget_product_categories ul ul,
        .widget_rating_filter ol ol,
        .widget_rating_filter ol ul,
        .widget_rating_filter ul ol,
        .widget_rating_filter ul ul {
            padding-left:1.0714em;
            margin:0
        }
        .sidebar-box ol ol.children,
        .sidebar-box ol ul.children,
        .sidebar-box ul ol.children,
        .sidebar-box ul ul.children,
        .widget_layered_nav ol ol.children,
        .widget_layered_nav ol ul.children,
        .widget_layered_nav ul ol.children,
        .widget_layered_nav ul ul.children,
        .widget_layered_nav_filters ol ol.children,
        .widget_layered_nav_filters ol ul.children,
        .widget_layered_nav_filters ul ol.children,
        .widget_layered_nav_filters ul ul.children,
        .widget_price_filter ol ol.children,
        .widget_price_filter ol ul.children,
        .widget_price_filter ul ol.children,
        .widget_price_filter ul ul.children,
        .widget_product_categories ol ol.children,
        .widget_product_categories ol ul.children,
        .widget_product_categories ul ol.children,
        .widget_product_categories ul ul.children,
        .widget_rating_filter ol ol.children,
        .widget_rating_filter ol ul.children,
        .widget_rating_filter ul ol.children,
        .widget_rating_filter ul ul.children {
            margin:0;
            display:none
        }
        .sidebar-box li .toggle,
        .wc-block-product-categories li .toggle,
        .widget_layered_nav li .toggle,
        .widget_layered_nav_filters li .toggle,
        .widget_price_filter li .toggle,
        .widget_product_categories li .toggle,
        .widget_rating_filter li .toggle {
            cursor:pointer;
            display:inline-block;
            text-align:center;
            position:absolute;
            right:-5px;
            top:4px;
            margin:0;
            padding:0;
            width:24px;
            height:24px;
            line-height:23px;
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            color:var(--porto-primary-color)
        }
        .sidebar-box li .toggle:hover,
        .wc-block-product-categories li .toggle:hover,
        .widget_layered_nav li .toggle:hover,
        .widget_layered_nav_filters li .toggle:hover,
        .widget_price_filter li .toggle:hover,
        .widget_product_categories li .toggle:hover,
        .widget_rating_filter li .toggle:hover {
            color:var(--porto-primary-light-5)
        }
        .widget_layered_nav li.chosen>a,
        .widget_layered_nav li.current>a,
        .widget_layered_nav ul a:focus,
        .widget_layered_nav ul a:hover,
        .widget_layered_nav_filters li.chosen>a,
        .widget_layered_nav_filters li.current>a,
        .widget_layered_nav_filters ul a:focus,
        .widget_layered_nav_filters ul a:hover,
        .widget_product_categories li.chosen>a,
        .widget_product_categories li.current>a,
        .widget_product_categories ul a:focus,
        .widget_product_categories ul a:hover,
        .widget_rating_filter li.chosen>a,
        .widget_rating_filter li.current>a,
        .widget_rating_filter ul a:focus,
        .widget_rating_filter ul a:hover {
            color:var(--porto-primary-color)
        }
        .widget .widget-title,
        .widget .wp-block-group__inner-container>h2 {
            position:relative
        }
        .widget .widget-title .toggle,
        .widget .wp-block-group__inner-container>h2 .toggle {
            display:inline-block;
            width:1.8571em;
            height:1.8571em;
            line-height:1.7572em;
            color:var(--porto-gray-4);
            position:absolute;
            right:-7px;
            top:50%;
            margin-top:-0.9em;
            padding:0;
            cursor:pointer;
            text-align:center;
            transition:0.25s
        }
        .widget .widget-title .toggle:after,
        .widget .widget-title .toggle:before,
        .widget .wp-block-group__inner-container>h2 .toggle:after,
        .widget .wp-block-group__inner-container>h2 .toggle:before {
            content:"";
            position:absolute;
            left:50%;
            top:50%;
            background:#222529
        }
        .widget .widget-title .toggle:before,
        .widget .wp-block-group__inner-container>h2 .toggle:before {
            width:2px;
            height:10px;
            margin-left:-1px;
            margin-top:-5px;
            display:none
        }
        .widget .widget-title .toggle:after,
        .widget .wp-block-group__inner-container>h2 .toggle:after {
            width:10px;
            height:2px;
            margin-left:-5px;
            margin-top:-1px
        }
        .widget.closed .widget-title,
        .widget.closed .wp-block-group__inner-container>h2 {
            border-bottom-width:0
        }
        .widget.closed .widget-title .toggle:before,
        .widget.closed .wp-block-group__inner-container>h2 .toggle:before {
            display:block
        }
        .widget_layered_nav ul li>a {
            padding-right:25px
        }
        .widget_layered_nav ul li .count {
            position:absolute;
            top:0;
            right:0;
            padding-top:4px;
            color:var(--porto-body-color-light-5)
        }
        .widget_price_filter .price_slider_wrapper {
            margin-bottom:0.3571em
        }
        .widget_price_filter .price_slider {
            background:var(--porto-slide-bgc);
            margin-top:1.4286em;
            margin-bottom:2.1428em;
            border-width:0;
            border-radius:0
        }
        .widget_price_filter .price_slider_amount {
            line-height:2em;
            font-size:0.8751em;
            display:flex;
            align-items:center;
            flex-wrap:wrap;
            justify-content:space-between
        }
        .widget_price_filter .price_slider_amount .button {
            padding:0.4em 1.25em;
            text-transform:uppercase;
            font-weight:600;
            font-size:0.75rem;
            order:2
        }
        .widget_price_filter .clear {
            display:none
        }
        .widget_price_filter .ui-slider {
            position:relative;
            text-align:left
        }
        .widget_price_filter .ui-slider .ui-slider-handle {
            position:absolute;
            z-index:2;
            width:11px;
            height:11px;
            cursor:pointer;
            outline:none;
            top:50%;
            margin-top:-5.5px;
            border-radius:6px;
            background:var(--porto-primary-color)
        }
        .widget_price_filter .ui-slider .ui-slider-handle:last-child {
            margin-left:-10px
        }
        .widget_price_filter .ui-slider .ui-slider-range {
            position:absolute;
            z-index:1;
            font-size:0.7em;
            box-shadow:0 1px 2px 0 rgba(0,0,0,0.38) inset
        }
        .widget_price_filter #max_price,
        .widget_price_filter #min_price {
            width:45%;
            margin-right:4%;
            margin-top:0.3571em;
            margin-bottom:1.2857em
        }
        .widget_price_filter .ui-slider-horizontal {
            height:3px
        }
        .widget_price_filter .ui-slider-horizontal .ui-slider-range {
            top:0;
            height:100%
        }
        .widget_price_filter .ui-slider-horizontal .ui-slider-range-min {
            left:-1px
        }
        .widget_price_filter .ui-slider-horizontal .ui-slider-range-max {
            right:-1px
        }
        .widget_layered_nav_filters ul:after {
            content:" ";
            display:table;
            clear:both
        }
        .widget_layered_nav_filters ul li {
            float:left
        }
        .widget_layered_nav_filters ul li a {
            margin-right:0.8571em
        }
        .widget_layered_nav_filters ul li a:before {
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            content:"\f057";
            margin-right:0.3571em;
            display:inline-block;
            color:var(--porto-primary-color)
        }
        .widget_layered_nav_filters ul li a:hover:before {
            color:var(--porto-primary-light-5)
        }
        .yith-woo-ajax-reset-navigation {
            background:transparent;
            border-width:0;
            border-radius:0
        }
        .yith-woo-ajax-reset-navigation>* {
            padding:0
        }
        .widget_layered_nav .yit-wcan-select-open {
            text-decoration:none
        }
        .widget_layered_nav .yith-wcan-select-wrapper {
            border-width:1px;
            border-color:var(--porto-widget-bc);
            padding:10px 0
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan {
            padding-top:0;
            padding-bottom:0
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li {
            padding:5px;
            border-width:0
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li.chosen,
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li:hover {
            box-shadow:none;
            border-width:0
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li.chosen a {
            background-image:none;
            position:relative;
            color:var(--porto-primary-color)
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li.chosen a:before {
            content:"\f00d";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900;
            font-size:0.9em;
            position:absolute;
            top:0.1em;
            left:-3px
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li a {
            padding:0 12px;
            border-width:0
        }
        .widget_layered_nav .yith-wcan-select-wrapper ul.yith-wcan-select.yith-wcan li:hover a {
            color:var(--porto-primary-color)
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-group,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-group {
            padding:11px 0;
            font-size:11px
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-color li,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-color li {
            width:14.2857%;
            min-width:34px;
            max-width:35px;
            text-align:center;
            float:left
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-color li a,
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-color li span,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-color li a,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-color li span {
            border-color:transparent;
            width:26px;
            height:26px;
            margin:4px 4px 4px 0;
            box-shadow:1px 1px 0 rgba(0,0,0,0.35)
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-color li.chosen a,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-color li.chosen a {
            border-color:var(--porto-color-price)
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-label li,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-label li {
            float:left
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-label li a,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-label li a {
            min-width:32px;
            text-align:center;
            margin:3px 6px 3px 0;
            padding:4px 8px;
            line-height:16px;
            background:var(--porto-body-bg);
            border:1px solid var(--porto-gray-5);
            color:var(--porto-body-color)
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-label li a:hover,
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-label li.chosen a,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-label li a:hover,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-label li.chosen a {
            color:#fff;
            background:var(--porto-primary-color);
            border-color:var(--porto-primary-color)
        }
        .woocommerce .yith-woo-ajax-navigation ul.yith-wcan-label li.chosen a:hover,
        .woocommerce-page .yith-woo-ajax-navigation ul.yith-wcan-label li.chosen a:hover {
            background:var(--porto-primary-light-5);
            border-color:var(--porto-primary-light-5)
        }
        .widget .product_list_widget li {
            padding:0.5rem 0
        }
        ul.product_list_widget {
            list-style:none outside;
            padding:0;
            margin:-0.5rem 0;
            border-width:0!important
        }
        ul.product_list_widget li {
            display:flex;
            align-items:center;
            border-width:0;
            position:relative;
            padding:0.5rem 0
        }
        ul.product_list_widget li .product-image {
            width:84px;
            flex:0 0 auto;
            padding:0;
            margin-right:20px
        }
        ul.product_list_widget li .product-image img {
            width:100%;
            height:auto
        }
        ul.product_list_widget li .product-image .img-effect img {
            position:relative;
            opacity:1
        }
        ul.product_list_widget li .product-image .img-effect .hover-image {
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            margin:auto;
            opacity:0
        }
        ul.product_list_widget li .product-image:hover .img-effect img {
            opacity:0
        }
        ul.product_list_widget li .product-image:hover .img-effect .hover-image {
            opacity:1
        }
        .product_list_widget .product-details {
            position:relative;
            flex:0 0 auto;
            width:calc(100% - 104px)
        }
        .product_list_widget .product-details a {
            display:block;
            font-size:1.0769em;
            line-height:1.4;
            white-space:nowrap;
            color:var(--porto-dark-color);
            overflow:hidden;
            text-overflow:ellipsis;
            margin-bottom:0.5rem
        }
        .product_list_widget .product-details .amount {
            font-size:1.1538em;
            font-weight:600;
            line-height:1;
            vertical-align:middle;
            color:var(--porto-color-price)
        }
        .product_list_widget .product-details .amount .currency,
        .product_list_widget .product-details .amount .decimal {
            font-size:0.75em;
            font-weight:400
        }
        .product_list_widget .product-details .amount .currency .decimal {
            font-size:1em
        }
        .product_list_widget .product-details ins {
            text-decoration:none;
            vertical-align:baseline
        }
        .product_list_widget .product-details .from,
        .product_list_widget .product-details del {
            color:#a7a7a7;
            font-size:0.8em;
            margin-right:3px;
            vertical-align:baseline
        }
        .product_list_widget .product-details .from .amount,
        .product_list_widget .product-details del .amount {
            color:#a7a7a7
        }
        .product_list_widget dl {
            margin:0;
            padding-left:1em;
            border-left:2px solid rgba(0,0,0,0.1)
        }
        .product_list_widget dl:after {
            content:" ";
            display:table;
            clear:both
        }
        .product_list_widget dl dd,
        .product_list_widget dl dt {
            display:inline-block;
            float:left;
            margin-bottom:1em
        }
        .product_list_widget dl dt {
            font-weight:700;
            padding:0 0 0.25em 0;
            margin:0 4px 0 0;
            clear:left
        }
        .product_list_widget dl dd {
            padding:0 0 0.25em 0
        }
        .product_list_widget dl dd p:last-child {
            margin-bottom:0
        }
        .product_list_widget .star-rating {
            margin:3px 0 5px
        }
        .product_list_widget .ajax-loading {
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            opacity:0.6;
            display:none;
            background:var(--porto-normal-bg)
        }
        .product_list_widget .ajax-loading:before {
            content:"\f110";
            font-family:"porto";
            position:absolute;
            left:50%;
            top:50%;
            font-size:20px;
            font-weight:400;
            line-height:1;
            margin-top:-13px;
            margin-left:-13px;
            color:#999;
            z-index:0;
            animation:spin 0.75s infinite linear;
            display:inline-block
        }
        ul.cart_list li.empty {
            padding-left:0
        }
        ul.cart_list li .quantity,
        ul.cart_list li .quantity .amount {
            vertical-align:baseline
        }
        ul.cart_list li dl {
            margin:6px 0;
            border:none;
            padding-left:5px;
            display:table
        }
        ul.cart_list li dl dd,
        ul.cart_list li dl dt {
            padding:3px;
            margin:0;
            line-height:1.2
        }
        ul.cart_list li dl dd p,
        ul.cart_list li dl dt p {
            line-height:1.2
        }
        .hide_cart_widget_if_empty .empty {
            display:none
        }
        .widget_recent_reviews .product_list_widget {
            flex-wrap:wrap
        }
        .widget_recent_reviews .product_list_widget li {
            padding:0.5rem 1%;
            display:block;
            text-align:center
        }
        .widget_recent_reviews .product_list_widget li a {
            display:block;
            position:relative;
            color:var(--porto-body-color)
        }
        .widget_recent_reviews .product_list_widget li img {
            width:96px;
            border:none;
            display:block;
            background:var(--porto-normal-bg);
            margin:0 auto 10px
        }
        .widget_recent_reviews .product_list_widget li .star-rating {
            margin:5px auto 0
        }
        .widget_recent_reviews .product_list_widget li .reviewer {
            font-size:0.8571em
        }
        .widget_shopping_cart {
            color:var(--porto-body-color)
        }
        .widget_shopping_cart .total {
            padding:0.7143em 0;
            margin:0;
            text-align:center
        }
        .widget_shopping_cart .total .amount {
            font-size:1.4286em;
            font-weight:600;
            color:var(--porto-primary-color)
        }
        .widget_shopping_cart .total .amount .currency,
        .widget_shopping_cart .total .amount .decimal {
            font-size:0.75em;
            font-weight:400
        }
        .widget_shopping_cart .total .amount .currency .decimal {
            font-size:1em
        }
        .widget_shopping_cart .buttons {
            margin-bottom:0
        }
        .widget_shopping_cart .buttons:after {
            content:" ";
            display:table;
            clear:both
        }
        .widget_shopping_cart .buttons .wc-forward {
            float:left;
            width:49%
        }
        .widget_shopping_cart .buttons .checkout {
            float:right;
            width:49%
        }
        @media (max-width:991px) {
            .mobile-sidebar .widget_shopping_cart .buttons .wc-forward {
                float:none;
                width:100%
            }
            .mobile-sidebar .widget_shopping_cart .buttons .wc-forward+.wc-forward {
                margin-top:8px
            }
        }
        @media (max-width:767px) {
            .widget_shopping_cart .buttons .wc-forward {
                float:none;
                width:100%
            }
            .widget_shopping_cart .buttons .wc-forward+.wc-forward {
                margin-top:8px
            }
        }
        .widget_shopping_cart .product-details a {
            padding-right:15px
        }
        .widget .cart_list {
            margin-top:0
        }
        .shop_table.cart-table a.remove,
        .widget_shopping_cart .product-image .remove-product,
        .wishlist-popup .remove_from_wishlist,
        .wishlist_table.traditional .remove_from_wishlist:not(.button) {
            padding:0;
            position:absolute;
            top:6px;
            right:2px;
            text-align:center;
            width:20px;
            height:20px;
            line-height:20px;
            font-size:11px;
            background-color:#fff;
            color:#222529;
            border-radius:50%;
            box-shadow:0 2px 6px 0 rgba(0,0,0,0.4);
            z-index:3
        }
        .shop_table.cart-table a.remove:before,
        .widget_shopping_cart .product-image .remove-product:before,
        .wishlist-popup .remove_from_wishlist:before,
        .wishlist_table.traditional .remove_from_wishlist:not(.button):before {
            content:"\f00d";
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900
        }
        .brand-thumbnails,
        .widget .brand-thumbnails {
            list-style:none;
            margin:0;
            padding:0
        }
        .products-slider.products li.product {
        }
        .products-slider.products li.product .add-links-wrap {
            line-height:0
        }
        .products-slider.show-nav-title .owl-nav {
            margin-top:-23px
        }
        .products-slider .slick-dots li {
            clear:none!important;
            width:20px!important;
            margin-bottom:0
        }
        .products-slider .slick-dots li button {
            box-shadow:none!important
        }
        .products-slider.slick-initialized .product {
            display:block
        }
        .products-slider.owl-carousel {
            margin:0!important
        }
        .products-slider.owl-carousel .owl-stage-outer {
            padding-top:10px;
            margin-top:-10px
        }
        .products-slider.owl-carousel .owl-dots {
            margin-top:20px
        }
        .products-slider.owl-loaded .product {
            margin-bottom:0
        }
        .widget .owl-carousel.show-nav-title .owl-nav [class*=owl-] {
            margin-left:0;
            margin-right:0
        }
        .widget .owl-carousel.show-nav-title .owl-nav .owl-prev {
            left:-30px
        }
        .yith-wcan-list-price-filter.loading,
        .yith-woo-ajax-navigation.loading {
            position:relative
        }
        .yith-wcan-list-price-filter.loading:after,
        .yith-woo-ajax-navigation.loading:after {
            content:" ";
            display:block;
            position:absolute;
            left:0;
            right:0;
            top:0;
            bottom:0;
            z-index:10000
        }
        .yith-wcan-list-price-filter.loading form input[type=text] {
            opacity:0
        }
        .woocommerce-product-search label {
            display:none
        }
        .woocommerce-product-search .search-field {
            margin-bottom:8px;
            vertical-align:top
        }
        .widget_rating_filter>ul {
            padding-top:1rem
        }
        .widget_rating_filter>ul li {
            line-height:1;
            margin-bottom:0.75rem
        }
        .widget_rating_filter>ul li a {
            padding-top:0;
            padding-bottom:0
        }
        .widget_rating_filter .star-rating {
            display:block;
            float:left;
            margin-top:0.15em
        }
        .widget_rating_filter .wc-layered-nav-rating a {
            display:block;
            text-align:right;
            color:var(--porto-body-color-light-5)
        }
        .widget_rating_filter .wc-layered-nav-rating a:after {
            content:" ";
            display:table;
            clear:both
        }
        .woocommerce-widget-layered-nav-list {
            display:flex;
            flex-wrap:wrap
        }
        .wp-block-group__inner-container>h2 {
            position:relative;
            font-size:15px;
            font-weight:600;
            margin-bottom:0
        }
        .wp-block-group__inner-container.closed>h2 {
            border-bottom-width:0
        }
        .wp-block-group__inner-container.closed>h2 .toggle:before {
            display:block
        }
        .wc-block-product-categories li {
            position:relative;
            padding:4px 0
        }
        .wc-block-product-categories li .toggle:before {
            font-size:1.2em
        }
        .wc-block-product-categories>ul ul {
            display:none;
            padding-left:1.0714em
        }
        .wc-block-product-categories>ul .current-active>a {
            color:var(--porto-primary-color)
        }
        .wc-block-product-categories-list-item>a {
            color:var(--porto-body-color)
        }
        .wc-block-product-categories .count,
        .widget_product_categories .count {
            color:var(--porto-body-color-light-5)
        }
        .woocommerce-cart .shipping_calculator h2 {
            margin-top:0
        }
        .woocommerce-cart .shipping_calculator h2 a {
            cursor:default
        }
        .woocommerce-cart .shipping-form-wrap .shipping-calculator-form {
            display:block!important;
            height:auto!important
        }
        .woocommerce-cart .shipping-calculator-form {
            margin-top:10px
        }
        .shop_table .product-thumbnail img {
            max-width:80px
        }
        .cross-sells {
            margin-top:20px;
            margin-bottom:20px
        }
        .shop_table.responsive.cart-total tbody tr:first-child td,
        .shop_table.responsive.cart-total tbody tr:first-child th,
        .shop_table.shop_table_responsive.cart-total tbody tr:first-child td,
        .shop_table.shop_table_responsive.cart-total tbody tr:first-child th {
            border-top-width:0
        }
        .shop_table.responsive.cart-total th,
        .shop_table.shop_table_responsive.cart-total th {
            width:25%
        }
        @media (max-width:767px) {
            .shop_table.responsive.cart-total td,
            .shop_table.responsive.cart-total th,
            .shop_table.shop_table_responsive.cart-total td,
            .shop_table.shop_table_responsive.cart-total th {
                width:100%;
                text-align:left
            }
        }
        #shipping_method {
            margin:0;
            padding:0;
            list-style:none
        }
        #shipping_method li:not(:last-child) {
            padding-bottom:12px
        }
        .wc-proceed-to-checkout .btn {
            font-size:15px;
            letter-spacing:-0.015em;
            margin-bottom:10px
        }
        .woocommerce-shipping-destination {
            line-height:26px
        }
        .wc-proceed-to-checkout {
            margin-bottom:20px;
            text-align:left
        }
        .cart_totals h2,
        .review-order.shop_table h2 {
            margin-top:0;
            color:var(--porto-primary-color)
        }
        .cart_totals h2 a,
        .review-order.shop_table h2 a {
            color:inherit
        }
        .cart_totals .order-total .amount,
        .review-order.shop_table .order-total .amount {
            font-size:22px;
            color:var(--porto-heading-color)
        }
        .cart-v2 .heading-primary {
            font-size:20px;
            line-height:27px;
            margin:0 0 20px;
            display:flex;
            justify-content:space-between;
            align-items:center
        }
        .cart-v2 .proceed-to-checkout {
            letter-spacing:normal
        }
        .cart-v2 .shipping-calculator-form {
            display:block!important
        }
        .cart-v2 #coupon_code {
            padding:11px 12px
        }
        .cart-v2 .card-default {
            padding:24px 30px;
            border:2px solid var(--porto-gray-5)
        }
        .cart-v2 .card-default tbody tr {
            border-bottom:1px solid var(--porto-gray-2)
        }
        .cart-v2 .card-default tbody tr:last-child {
            border-bottom:none
        }
        .cart-v2 .card-default tbody th {
            padding:10px;
            font-weight:400;
            line-height:1.4;
            text-align:left!important
        }
        .cart-v2 .card-default tbody td {
            padding:10px;
            line-height:1.4;
            text-align:left!important
        }
        .cart-v2 .card-default tbody td:last-child {
            color:var(--porto-color-price);
            text-align:right!important;
            font-weight:400
        }
        .cart-v2 .card-default tbody .order-total th {
            padding:18px 12px
        }
        .checkout-v2 .checkout_coupon {
            display:block!important
        }
        .card-default .card-header.arrow a {
            position:relative;
            padding-right:40px;
            font-size:13px;
            font-weight:700;
            letter-spacing:0!important
        }
        .card-default .card-header.arrow a:before {
            border:none;
            color:#212529;
            font-family:"porto";
            content:"\e81b";
            width:26px;
            height:26px;
            display:block;
            position:absolute;
            right:15px;
            top:50%;
            margin-top:-13px;
            text-align:center;
            line-height:26px;
            font-size:17px;
            background-color:transparent
        }
        .card-default .card-header.arrow a.collapsed:before {
            content:"\e81c"
        }
        .card-default .card-header.arrow a:hover:before {
            background-color:transparent;
            border-color:transparent;
            color:#212529
        }
        .shop_table.cart-table th.product-thumbnail {
            width:16%
        }
        .shop_table.cart-table th.product-name {
            width:33%
        }
        .shop_table.cart-table th.product-price {
            width:14%
        }
        .shop_table.cart-table .product-subtotal .amount {
            font-size:16px;
            font-weight:600;
            color:var(--porto-heading-color)
        }
        .shop_table.cart-table .actions input[type=text]::placeholder {
            font-size:12px;
            font-weight:500;
            color:#999
        }
        .shop_table.cart-table .actions button {
            padding:12px 24px
        }
        td.order-total,
        td.product-total {
            font-weight:400!important
        }
        .cart_totals_toggle .card-header a {
            display:block;
            padding:10px 20px
        }
        .cart_totals_toggle .card-header {
            padding:0;
            border-bottom:none
        }
        .cart_totals_toggle .card:not(:first-child) {
            margin-top:5px
        }
        .also-bought .products-slider.show-nav-title .owl-nav {
            margin-top:-32px
        }
        i.cart-empty,
        i.wishlist-empty {
            font-size:100px;
            color:#d3d3d4
        }
        .cart-empty-page .woocommerce-info {
            text-align:center
        }
        .checkout_coupon .form-row {
            display:inline-block;
            float:none;
            width:auto;
            vertical-align:middle;
            padding-right:0
        }
        form.checkout_coupon {
            padding-left:5px;
            padding-bottom:5px
        }
        .woocommerce-form-coupon-toggle,
        .woocommerce-form-login-toggle {
            font-size:13px;
            font-weight:500;
            letter-spacing:-0.025em
        }
        .form-row.terms {
            position:relative;
            margin-top:15px
        }
        .form-row.terms .input-checkbox {
            position:absolute;
            left:0;
            top:2px
        }
        .form-row.terms label.checkbox {
            margin-left:20px;
            display:block
        }
        .payment_methods {
            margin:15px 0 10px;
            padding:0;
            list-style:none
        }
        .payment_methods li {
            padding-bottom:10px
        }
        .payment_methods p {
            margin-bottom:0.5rem
        }
        .payment_methods .porto-control-label {
            font-size:14px;
            font-weight:400
        }
        .payment_methods .payment_method_paypal .about_paypal {
            display:inline-block;
            margin-left:10px
        }
        .payment_methods .payment_method_paypal img {
            width:170px;
            margin-left:0.25rem
        }
        @media (max-width:767px) {
            .payment_methods .payment_method_paypal .input-radio {
                vertical-align:top
            }
            .payment_methods .payment_method_paypal .about_paypal,
            .payment_methods .payment_method_paypal img {
                display:block;
                margin:0
            }
        }
        @media (max-width:575px) {
            .payment_methods .payment_method_paypal img {
                width:150px
            }
        }
        .woocommerce-page .woocommerce header {
            margin-top:32px
        }
        .woocommerce-page .woocommerce .featured-box header {
            margin-top:20px
        }
        .checkout-v2 .card-header {
            line-height:40px
        }
        .place-order img {
            margin-left:5px;
            display:none
        }
        form.woocommerce-checkout h3 {
            margin-bottom:13px;
            font-size:22px;
            font-weight:700;
            letter-spacing:-0.01em;
            line-height:32px
        }
        .woocommerce-checkout .select2-dropdown {
            border-color:#e7e7e7
        }
        .woocommerce-checkout .select2-container .select2-selection--single {
            height:50px;
            border-color:#e7e7e7
        }
        .woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding:10px 12px
        }
        .woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__arrow {
            top:50%;
            transform:translateY(-50%);
            right:1rem
        }
        .woocommerce-checkout .screen-reader-text {
            clip:rect(1px,1px,1px,1px);
            height:1px;
            overflow:hidden;
            position:absolute!important;
            width:1px;
            word-wrap:normal!important
        }
        .woocommerce-checkout input[type=text]::placeholder,
        .woocommerce-checkout textarea::placeholder {
            font-size:12px
        }
        .woocommerce-checkout .shipping_address {
            margin-top:1rem
        }
        .woocommerce-checkout input[type=email],
        .woocommerce-checkout input[type=password],
        .woocommerce-checkout input[type=tel],
        .woocommerce-checkout input[type=text] {
            line-height:2.3
        }
        .woocommerce-checkout label {
            margin-bottom:3px;
            font-weight:500;
            letter-spacing:-0.01em
        }
        #order_comments {
            min-height:125px
        }
        .woocommerce-privacy-policy-text p {
            font-size:12px;
            line-height:23px;
            color:#8a8b8e
        }
        .checkout-order-review .featured-boxes {
            padding:22px 32px
        }
        .checkout-order-review .woocommerce-privacy-policy-text p {
            padding:0 8px;
            font-size:13px
        }
        .checkout-order-review .shop_table td {
            padding:12px 10px
        }
        .woocommerce-shipping-totals td {
            padding:25px 10px
        }
        .woocommerce-checkout .shop_table .button {
            color:#fff
        }
        .woocommerce-account .woocommerce {
            margin:0 -10px
        }
        .woocommerce-account .woocommerce:after {
            content:" ";
            display:table;
            clear:both
        }
        .woocommerce-account .woocommerce>.row {
            margin-left:calc(10px - var(--porto-column-spacing));
            margin-right:calc(10px - var(--porto-column-spacing))
        }
        .woocommerce-account .woocommerce>.col-lg-10,
        .woocommerce-account .woocommerce>.col-md-6 {
            padding-right:calc(var(--porto-grid-gutter-width) / 2);
            padding-left:calc(var(--porto-grid-gutter-width) / 2)
        }
        .woocommerce-account .woocommerce-MyAccount-navigation {
            float:left;
            width:25%;
            padding:0 10px 30px
        }
        @media (max-width:991px) {
            .woocommerce-account .woocommerce-MyAccount-navigation {
                float:none;
                width:100%
            }
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul {
            list-style:none;
            padding:0
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li {
            margin:0;
            padding:0;
            display:block;
            position:relative
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li a {
            transition:background 0.1s;
            padding:8px 0 8px 0;
            display:block;
            color:var(--porto-body-color);
            font-size:1em;
            font-weight:500;
            letter-spacing:-0.025em
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover {
            text-decoration:none
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active>a {
            font-weight:700;
            color:var(--porto-heading-color)
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li:not(:last-child) a {
            border-bottom:1px solid var(--porto-gray-5)
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul li ul {
            list-style:none;
            margin:0 0 0 25px;
            padding:0
        }
        .woocommerce-account .woocommerce-MyAccount-content {
            float:right;
            width:75%;
            padding:0 10px
        }
        @media (max-width:991px) {
            .woocommerce-account .woocommerce-MyAccount-content {
                float:none;
                width:100%
            }
        }
        .woocommerce-account ol.commentlist.notes li.note p.meta {
            font-weight:700;
            margin-bottom:0
        }
        .woocommerce-account ol.commentlist.notes li.note .description p:last-child {
            margin-bottom:0
        }
        .woocommerce-account ul.digital-downloads {
            margin-left:0;
            padding-left:0
        }
        .woocommerce-account ul.digital-downloads li {
            list-style:none;
            margin-left:0;
            padding-left:0
        }
        .woocommerce-account ul.digital-downloads li .count {
            float:right
        }
        .woocommerce-account .account-sub-title i,
        .woocommerce-account .featured-box i {
            color:#d3d3d4
        }
        .woocommerce-account .featured-box .icon-featured {
            font-size:60px
        }
        .woocommerce-account .featured-box h4 {
            font-size:1rem;
            letter-spacing:-0.01em
        }
        .address .featured-box {
            text-align:left
        }
        #rememberme,
        .back-login {
            margin-top:10px;
            margin-bottom:10px
        }
        .woocommerce-password-strength {
            text-align:center;
            font-weight:600;
            margin-top:10px;
            padding:3px 0px 3px 0px;
            color:#333;
            line-height:1.2
        }
        .woocommerce-password-strength.strong {
            background-color:#c1e1b9;
            border-color:#83c373
        }
        .woocommerce-password-strength.short {
            background-color:#f1adad;
            border-color:#e35b5b
        }
        .woocommerce-password-strength.bad {
            background-color:#fbc5a9;
            border-color:#f78b53
        }
        .woocommerce-password-strength.good {
            background-color:#ffe399;
            border-color:#ffc733
        }
        .woocommerce-password-hint {
            margin:1em 0 0 0;
            display:block
        }
        .order-info mark {
            display:block;
            background:transparent;
            color:var(--porto-heading-color);
            padding:0
        }
        .porto-social-login-section.false-modal a {
            padding:17px 12px;
            margin-bottom:20px
        }
        .porto-social-login-section.false-modal i {
            margin-right:5px
        }
        .porto-social-login-section.false-modal i.fa-facebook-f {
            width:25px;
            height:25px;
            line-height:35px;
            vertical-align:middle;
            color:#3a589d;
            background:#fff;
            border-radius:50%
        }
        .porto-social-login-section.false-modal span {
            letter-spacing:-0.03em
        }
        .porto-social-login-section .social-button:hover i.fa-facebook-f {
            color:var(--porto-primary-color)
        }
        #login-form-popup .register-btn {
            margin:20px 0 0;
            color:var(--porto-heading-color);
            letter-spacing:-0.025em;
            outline:none
        }
        #login-form-popup .register-btn:hover {
            color:var(--porto-primary-color)
        }
        .shopswatchinput {
            margin-bottom:5px;
            margin-top:5px
        }
        .wcvaswatchinput {
            text-decoration:none!important;
            margin:0 1px
        }
        .wcvashopswatchlabel,
        .wcvaswatchlabel {
            cursor:pointer;
            background-size:contain;
            background-repeat:no-repeat;
            display:inline-block;
            transition:0.1s ease-in;
            line-height:1;
            border:1px solid var(--porto-normal-bg);
            box-shadow:0 0 0 1px var(--porto-gray-4)
        }
        .wcvashopswatchlabel {
            width:24px!important;
            height:24px!important
        }
        .wcvaswatchinput.active .wcvashopswatchlabel {
            border:1px solid var(--porto-color-price)
        }
        .swatchinput {
            display:inline-block;
            padding-right:7px;
            padding-bottom:6px;
            margin-top:-3px
        }
        .belowtext {
            display:table-cell;
            vertical-align:bottom;
            padding-bottom:16px;
            font-weight:bold
        }
        .wcvaswatch input {
            margin:0;
            padding:0;
            display:none;
            -webkit-appearance:none;
            -ms-appearance:none;
            appearance:none
        }
        .wcvaswatchlabel {
            border-width:2px
        }
        .wcvaswatch input:active+.wcvaswatchlabel {
            opacity:0.9
        }
        .wcvaswatch input:checked+.wcvaswatchlabel {
            -webkit-filter:none;
            -ms-filter:none;
            filter:none;
            border:2px solid var(--porto-color-price)
        }
        .wcvaround {
            border-radius:50%;
            outline:solid 0 #9C9999
        }
        input.wcva_attribute_radio {
            margin-right:5px
        }
        .wishlist_table tr td {
            background-color:var(--porto-body-bg)
        }
        .shop_table.wishlist_table {
            margin-bottom:15px
        }
        .shop_table.wishlist_table tr td {
            text-align:left
        }
        @media (max-width:767px) {
            .shop_table.wishlist_table tr td {
                text-align:center
            }
        }
        .shop_table.wishlist_table.mobile .add-links .add_to_cart,
        .shop_table.wishlist_table.mobile .add-links .quickview,
        .shop_table.wishlist_table.mobile .add-links .yith-compare,
        .shop_table.wishlist_table.mobile .product-add-to-cart .remove_from_wishlist {
            display:block!important;
            width:100%!important
        }
        .shop_table.wishlist_table.traditional:not(.mobile) .add-links {
            max-width:240px
        }
        .shop_table.wishlist_table .add-links .add_to_cart_button:before {
            content:none
        }
        @media (max-width:767px) {
            .shop_table.wishlist_table .add-links .add_to_cart,
            .shop_table.wishlist_table .add-links .quickview,
            .shop_table.wishlist_table .add-links .yith-compare {
                width:100%!important
            }
        }
        .shop_table.wishlist_table .quickview {
            margin-bottom:10px;
            margin-right:0
        }
        .shop_table.wishlist_table .add_to_cart {
            margin-left:0!important;
            margin-right:0!important;
            margin-bottom:10px!important
        }
        .shop_table.wishlist_table .product-thumbnail {
            width:10%
        }
        .shop_table.wishlist_table .product-name {
            width:29%
        }
        .shop_table.wishlist_table .product-price {
            width:13%
        }
        .shop_table.wishlist_table .product-stock-status {
            width:19%
        }
        @media (max-width:767px) {
            .shop_table.wishlist_table .product-name,
            .shop_table.wishlist_table .product-price,
            .shop_table.wishlist_table .product-stock-status,
            .shop_table.wishlist_table .product-thumbnail {
                width:100%
            }
        }
        .shop_table.wishlist_table .product-add-to-cart .remove_from_wishlist {
            display:inline-block!important;
            font-size:13px;
            text-transform:uppercase;
            font-weight:600;
            line-height:30px;
            width:auto
        }
        .woocommerce table.shop_table.wishlist_table thead td,
        .woocommerce table.shop_table.wishlist_table thead th {
            border:none;
            padding:10px 5px 10px 16px
        }
        .woocommerce table.shop_table.wishlist_table tbody td,
        .woocommerce table.shop_table.wishlist_table tfoot td {
            border-color:var(--porto-gray-5)
        }
        .woocommerce table.shop_table.wishlist_table tbody td,
        .woocommerce table.shop_table.wishlist_table tbody th,
        .woocommerce table.shop_table.wishlist_table tfoot td,
        .woocommerce table.shop_table.wishlist_table tfoot th {
            padding:20px 5px 23px 16px;
            font-weight:600
        }
        @media (max-width:767px) {
            .woocommerce table.shop_table.wishlist_table tbody td,
            .woocommerce table.shop_table.wishlist_table tbody th,
            .woocommerce table.shop_table.wishlist_table tfoot td,
            .woocommerce table.shop_table.wishlist_table tfoot th {
                padding:10px 20px
            }
        }
        .shop_table.wishlist_table,
        .woocommerce table.wishlist_table {
            font-size:100%
        }
        .shop_table.wishlist_table .add_to_cart.button,
        .shop_table.wishlist_table .add_to_cart_read_more.button,
        .shop_table.wishlist_table .yith-compare,
        .woocommerce table.wishlist_table .add_to_cart.button,
        .woocommerce table.wishlist_table .add_to_cart_read_more.button,
        .woocommerce table.wishlist_table .yith-compare {
            display:inline-block!important;
            min-width:160px
        }
        .shop_table.wishlist_table .add_to_cart.button,
        .shop_table.wishlist_table .add_to_cart_read_more.button,
        .shop_table.wishlist_table .quickview,
        .shop_table.wishlist_table .yith-compare,
        .woocommerce table.wishlist_table .add_to_cart.button,
        .woocommerce table.wishlist_table .add_to_cart_read_more.button,
        .woocommerce table.wishlist_table .quickview,
        .woocommerce table.wishlist_table .yith-compare {
            height:42px;
            width:auto;
            padding:0 25px!important;
            font-family:var(--porto-add-to-cart-ff),var(--porto-body-ff),sans-serif;
            font-size:13px;
            line-height:42px;
            text-indent:0
        }
        .shop_table.wishlist_table .yith-compare,
        .woocommerce table.wishlist_table .yith-compare {
            min-width:1px;
            padding:0 15px!important;
            font-weight:700;
            margin-bottom:10px!important
        }
        .shop_table.wishlist_table .yith-compare:before,
        .woocommerce table.wishlist_table .yith-compare:before {
            float:none
        }
        .shop_table.wishlist_table .yith-compare.added:before,
        .woocommerce table.wishlist_table .yith-compare.added:before {
            line-height:42px
        }
        .shop_table.wishlist_table .quickview,
        .woocommerce table.wishlist_table .quickview {
            font-weight:700
        }
        .shop_table.wishlist_table .quickview:before,
        .woocommerce table.wishlist_table .quickview:before {
            content:none
        }
        .shop_table.wishlist_table .yith-wcwl-add-to-wishlist,
        .woocommerce table.wishlist_table .yith-wcwl-add-to-wishlist {
            display:none
        }
        .shop_table.wishlist_table .wishlist-empty,
        .woocommerce table.wishlist_table .wishlist-empty {
            text-align:center!important
        }
        p.wishlist-empty,
        table.wishlist_table tbody td.wishlist-empty {
            margin:1rem 0
        }
        .shop_table.cart-table a.remove.remove-product,
        .woocommerce #content table.shop_table.wishlist_table.cart a.remove {
            top:-10px;
            right:-10px;
            color:var(--porto-dark-color)
        }
        .shop_table.cart-table a.remove.remove-product:hover,
        .woocommerce #content table.shop_table.wishlist_table.cart a.remove:hover {
            background:#fff;
            color:var(--porto-primary-color)
        }
        .blockUI {
            background:#fff!important;
            opacity:0.5!important
        }
        .sidebar-content #yith-ajaxsearchform .btn {
            color:#fff;
            border-width:1px;
            background:var(--porto-primary-color)
        }
        .sidebar-content .autocomplete-suggestions {
            padding-top:0;
            padding-bottom:0
        }
        .sidebar-content .autocomplete-suggestion {
            padding-left:8px;
            padding-right:8px
        }
        .wishlist_table .add_to_cart.button,
        .wishlist_table .add_to_cart_read_more.button {
            padding-top:6px;
            padding-bottom:6px;
            line-height:22px
        }
        .wishlist_table .button,
        .woocommerce .hidden-title-form a.btn,
        .woocommerce .hidden-title-form input[type=submit],
        .woocommerce .wishlist-title a.btn {
            color:#fff;
            vertical-align:middle;
            font-size:0.8rem;
            line-height:1.5
        }
        .woocommerce .wishlist-title h2 {
            margin:0!important
        }
        #header .my-account,
        #header .my-wishlist,
        #header .yith-woocompare-open {
            display:inline-block;
            font-size:26px;
            vertical-align:middle
        }
        #header .my-wishlist,
        #header .yith-woocompare-open {
            position:relative
        }
        .shop_table.cart-table .product-thumbnail>div,
        .wishlist_table td.product-thumbnail>div {
            width:80px
        }
        @media (max-width:767px) {
            .shop_table.cart-table .product-thumbnail>div,
            .wishlist_table td.product-thumbnail>div {
                margin:0 auto
            }
        }
        .wishlist-popup {
            position:fixed;
            top:0;
            height:100%;
            width:300px;
            right:0;
            z-index:1003;
            padding:1.5rem 1.25rem;
            background:var(--porto-normal-bg);
            box-shadow:0 5px 8px rgba(0,0,0,0.15);
            font-size:0.8125rem;
            text-align:left;
            transform:translateX(105%);
            transition:transform 0.35s
        }
        .minicart-opened .wishlist-popup {
            transform:translateX(0)
        }
        .wishlist-popup .product_list_widget {
            margin:0 0 1.25rem
        }
        .wishlist-popup .product_list_widget li {
            padding:1.25rem 0;
            border-bottom:1px solid #e7e7e7
        }
        .wishlist-popup .product-details {
            padding-right:1rem;
            position:static
        }
        .wishlist-popup .product-details a {
            font-weight:500
        }
        .wishlist-popup .product-details .amount {
            font-size:0.8125rem;
            font-weight:400
        }
        .wishlist-popup .remove_from_wishlist.remove {
            top:10px;
            right:-8px;
            cursor:pointer
        }
        .wishlist-popup .btn {
            letter-spacing:0.25em;
            padding:0.8125rem 0;
            border-radius:2px
        }
        .wishlist-popup .empty-msg {
            padding:8px 10px
        }
        .yith_wcwl_wishlist_footer .yith-wcwl-share.page-share {
            float:unset
        }
        .yith-wcwl-dropdown {
            font-size:0.875rem;
            text-align:left
        }
        .yith-wcwl-dropdown a {
            text-indent:0;
            width:auto!important;
            opacity:1!important;
            vertical-align:baseline;
            line-height:inherit;
            height:auto;
            border:none!important;
            background:none!important;
            color:inherit!important;
            overflow:visible!important
        }
        .yith-wcwl-dropdown a:hover {
            color:initial!important
        }
        .yith-wcwl-dropdown .add_to_wishlist:before {
            content:none!important
        }
        .yes-js .product-onimage .yith-wcwl-dropdown,
        .yes-js .product-onimage2 .yith-wcwl-dropdown,
        .yes-js .product-onimage3 .yith-wcwl-dropdown,
        .yes-js .product-outimage_aq_onimage .yith-wcwl-dropdown,
        .yes-js .product-wq_onimage .yith-wcwl-dropdown {
            right:0
        }
        .yes-js .product-awq_onimage .yith-wcwl-dropdown {
            left:-80px
        }
        .yes-js .product-onimage .product-image {
            position:static
        }
        .yith-wcwl-add-button.with-dropdown {
            padding:0;
            min-height:2rem
        }
        .product-onimage3 .yith-wcwl-add-button.with-dropdown {
            z-index:4!important
        }
        .yes-js .yith-wcwl-add-button ul.yith-wcwl-dropdown {
            top:100%
        }
        .yith-wcwl-add-button ul.yith-wcwl-dropdown li:before {
            font-family:var(--fa-style-family-classic,"Font Awesome 6 Free");
            font-weight:900
        }
        .woocommerce-wishlist #main,
        .woocommerce-wishlist .page-wrapper {
            position:static
        }
        .wishlist_table.traditional tr td.product-arrange {
            text-align:center
        }
        .shop_table.wishlist_table input[type=number] {
            max-width:80px
        }
        .shop_table.wishlist_table:not(.traditional) {
            font-size:120%
        }
        .shop_table.wishlist_table:not(.traditional) .product-thumbnail img {
            max-width:100%
        }
        .shop_table.wishlist_table.traditional tr td.product-arrange {
            text-align:center
        }
        .shop_table.wishlist_table.images_grid,
        .shop_table.wishlist_table.modern_grid {
            display:flex;
            flex-wrap:wrap;
            width:auto;
            padding:0
        }
        .shop_table.wishlist_table.images_grid .product-remove,
        .shop_table.wishlist_table.modern_grid .product-remove {
            box-shadow:none
        }
        .shop_table.wishlist_table.modern_grid .product-thumbnail {
            width:30%
        }
        @media (max-width:1220px) {
            .shop_table.wishlist_table.modern_grid li {
                width:50%
            }
        }
        .shop_table.wishlist_table .item-details .product-name {
            width:100%
        }
        .shop_table.wishlist_table.mobile:not(.traditional) {
            border:none;
            padding-left:0;
            box-shadow:none
        }
        .shop_table.wishlist_table .additional-info-wrapper .label,
        .shop_table.wishlist_table .item-details .label {
            color:inherit;
            line-height:2
        }
        .shop_table.wishlist_table .additional-info-wrapper tr,
        .shop_table.wishlist_table .item-details tr {
            border:none;
            display:table-row
        }
        .shop_table.wishlist_table .additional-info-wrapper td,
        .shop_table.wishlist_table .item-details td {
            display:table-cell;
            vertical-align:middle!important
        }
        .shop_table.wishlist_table .additional-info-wrapper .yith-compare,
        .shop_table.wishlist_table .item-details .yith-compare {
            padding-top:0!important;
            padding-bottom:0!important
        }
        @media (max-width:1220px) {
            .shop_table.wishlist_table.images_grid li {
                width:33.33%
            }
            .shop_table.wishlist_table.images_grid .product-thumbnail img,
            .shop_table.wishlist_table.images_grid .product-thumbnail>a {
                width:100%
            }
        }
        .shop_table.wishlist_table.images_grid .product-thumbnail {
            width:100%
        }
        .shop_table.wishlist_table.images_grid .quickview {
            position:relative;
            opacity:1;
            visibility:visible
        }
        .shop_table.wishlist_table.images_grid .product-name {
            font-size:1rem;
            margin-top:2.5rem;
            text-align:center
        }
        .yith-wcwl-add-to-wishlist .yith-wcwl-tooltip {
            text-indent:0;
            display:inline-block!important;
            min-width:100px
        }
        .product-outimage .yith-wcwl-add-to-wishlist .yith-wcwl-tooltip {
            top:-100%
        }
        .product-outimage .yith-wcwl-add-to-wishlist .yith-wcwl-tooltip:before {
            top:100%;
            transform:rotate(180deg)
        }
        .yith-wcwl-add-to-wishlist .count-add-to-wishlist>span {
            line-height:inherit
        }
        .yith-wfbt-item .price {
            font-size:inherit
        }
        .yith-wfbt-slider-wrapper .yith-wfbt-products-list {
            margin-left:0;
            margin-right:0
        }
        .quickview-wrap {
            width:900px;
            padding:15px
        }
        @media (max-width:991px) {
            .quickview-wrap {
                width:550px
            }
        }
        @media (max-width:767px) {
            .quickview-wrap {
                width:auto
            }
            .quickview-wrap.skeleton-body {
                width:calc(100vw - 40px)
            }
        }
        @media (max-width:575px) {
            .quickview-wrap {
                padding:0
            }
            .quickview-wrap .row {
                margin-left:0;
                margin-right:0
            }
            .quickview-wrap .summary,
            .quickview-wrap .summary-before {
                padding-left:0;
                padding-right:0
            }
        }
        .quickview-wrap .product .entry-summary,
        .quickview-wrap .product .summary-before {
            margin-bottom:0
        }
        @media (max-width:991px) {
            .quickview-wrap .product .summary-before {
                margin-bottom:30px
            }
        }
        .quickview-wrap .product-image-slider.owl-carousel {
            overflow:hidden
        }
        .quickview-wrap .woocommerce-product-rating:after {
            content:none
        }
        .quickview-wrap .variations_form:not(.vf_init) .reset_variations {
            display:none
        }
        .quickview-wrap .summary .added_to_cart {
            font-size:0.8em;
            font-weight:700;
            text-transform:uppercase;
            text-decoration:underline;
            margin-left:0.5rem
        }
        .quickview-wrap .summary .single_add_to_cart_button.loading {
            pointer-events:none;
            opacity:0.75
        }
        .quickview-wrap .summary .porto-loading-icon {
            position:static;
            width:25px;
            height:25px;
            margin:0.5em
        }
        .woocommerce-page.archive .sidebar-content {
            border:1px solid var(--porto-gray-5)
        }
        .woocommerce-page.archive .sidebar-content .widget-title {
            padding:0;
            background:none;
            border:none
        }
        .woocommerce-page.archive .sidebar-content .porto-separator {
            display:none
        }
        .woocommerce-page.archive .sidebar-content aside.widget {
            border-bottom:1px solid var(--porto-gray-5);
            margin-bottom:0;
            margin-top:0;
            padding:20px
        }
        .woocommerce-page.archive .sidebar-content aside.widget:last-child {
            border-bottom:none
        }
        .woocommerce-page.archive .sidebar-content aside.widget .widget {
            margin-bottom:0
        }
        .woocommerce-page.archive .sidebar-content .widget>:last-child,
        .woocommerce-page.archive .sidebar-content .wp-block-group__inner-container>:last-child {
            margin-bottom:0;
            padding-bottom:0
        }
        @media (max-width:991px) {
            .woocommerce-page.archive .mobile-sidebar aside.widget {
                padding-left:0;
                padding-right:0
            }
            .woocommerce-page.archive .mobile-sidebar aside.widget:first-child {
                padding-top:0
            }
        }
        .woocommerce-page .sidebar-content .widget-title {
            font-weight:600;
            font-size:15px
        }
        .sidebar .product-categories li>a {
            font-size:14px;
            font-weight:500
        }
        .wc-block-product-categories ul li .toggle,
        .widget_product_categories ul li .toggle {
            font-size:11px;
            color:#222529!important;
            font-family:Porto
        }
        .wc-block-product-categories ul li .toggle:before,
        .widget_product_categories ul li .toggle:before {
            content:"\e81c"
        }
        .wc-block-product-categories ul li.current>.toggle:before,
        .wc-block-product-categories ul li.open>.toggle:before,
        .widget_product_categories ul li.current>.toggle:before,
        .widget_product_categories ul li.open>.toggle:before {
            content:"\e81b"
        }
        .wc-block-product-categories ul li.closed>.toggle:before,
        .widget_product_categories ul li.closed>.toggle:before {
            content:"\e81c"
        }
        .woocommerce-page .widget_block .wp-block-heading {
            font-size:15px;
            font-weight:600;
            text-transform:uppercase;
            line-height:1.4;
            margin-bottom:15px
        }
        .woocommerce-page .wc-block-active-filters,
        .woocommerce-page .wc-block-components-price-slider,
        .woocommerce-page .wc-block-components-product-sort-select,
        .woocommerce-page .wc-block-stock-filter,
        .woocommerce-page .wp-block-woocommerce-rating-filter {
            margin-bottom:0
        }
        .woocommerce-page .wc-block-active-filters .wc-block-active-filters__list-item-type {
            font-weight:400
        }
        .wp-block-woocommerce-price-filter {
            color:var(--porto-primary-color)
        }
        .wp-block-woocommerce-customer-account .label {
            color:#777;
            font-weight:400;
            font-size:inherit
        }
        .widget_block .wc-block-review-list {
            border-bottom-width:0
        }
        .widget_block .wc-block-review-list>li {
            padding-top:20px;
            padding-bottom:20px
        }
        .widget_block .wc-block-review-list>li:last-child {
            padding-bottom:0
        }
        .widget_block .wc-block-components-review-list-item__info {
            margin-bottom:15px
        }
        .widget_block .wc-block-review-list-item__image img {
            border-radius:50%
        }
        .widget_block .wc-block-components-review-list-item__author,
        .widget_block .wc-block-components-review-list-item__product {
            line-height:1.4
        }
        .widget_block .wc-block-review-list-item__product>a {
            color:#222529
        }
        .widget_block .wc-block-review-list-item__product>a:hover {
            color:#0d0d0d
        }
        .widget_block .wc-block-product-categories-list {
            border-bottom-width:0
        }
        .widget_block .wc-block-product-categories-list>li {
            border-top-width:0
        }

    </style>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </div>
    </nav>
    <div class="container">
    <div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
        <div class="row">
            <div class="col-md-5 product-single-gallery mb-md-0">
                <div class="product-slider-container">
                    <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                        <div class="product-item">
                            <img class="product-single-image" src="{{ $product->ProductImage }}"
                                 data-zoom-image="{{ $product->ProductImage }}"/>
                        </div>
                        @foreach($product->GalleryImages as $galleryImage)
                            <div class="product-item">
                                <img class="product-single-image" src="{{ $galleryImage }}"
                                     data-zoom-image="{{ $galleryImage }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="prod-thumbnail owl-dots">
                    <div class="owl-dot">
                        <img src="{{ $product->ProductImage }}"/>
                    </div>
                    @foreach($product->GalleryImages as $galleryImage)
                        <div class="owl-dot">
                            <img src="{{ $galleryImage }}"/>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-7">
                <div class="product-single-details mb-0 ml-md-4 product-div">
                    <h1 class="product-title"> {{ $product->ProductName }}</h1>

                    <div class="ratings-container">
                        <div class="product-ratings">
                            <span class="ratings" style="width:{{ Rand(50,100) }}%"></span>
                        </div>
                    </div>

                    <hr class="short-divider">
                    <div class="product-desc">
{{--                        <iframe id="productIFrame" src="{{ route('productShortDescription', $product->ProductID) }}" style="width: 100%; min-height: 200px; overflow: hidden;" frameborder="0"></iframe>--}}
                        {!! $product->ShortDescription !!}
                    </div>

                    <ul class="single-info-list">
                        <li>
                            CATEGORY:
                            <strong>
                                <a href="#" class="product-category">{{ $product->CategoryName }}</a>
                            </strong>
                        </li>
                        <li>
                            SUB CATEGORY:
                            <strong>
                                <a href="#" class="product-category">{{ $product->SubCategoryName }}</a>
                            </strong>
                        </li>
                    </ul>

                    <div class="product-action">
                        <a href="#"
                           class="btn btn-dark mr-2 product-type-simple btn-shop {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'added-in-cart' : 'wishlistCartBtn btnAddCart' }}"
                           title="Add to Cart" id="{{ $product->ProductID }}">
                            {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'Added in Cart' : 'ADD TO CART' }}
                        </a>
                        <a href="#" class="btn view-cart d-none">View cart</a>
                    </div>

                    {{--                <hr class="divider mb-0 mt-0">--}}

                    {{--                <div class="product-single-share mb-0">--}}
                    {{--                    <a href="#" class="btn-icon-wish add-wishlist {{ $product->IsInWishlist ? 'added-wishlist' : '' }}" title="{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"><i--}}
                    {{--                            class="icon-wishlist-2"></i><span>{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span></a>--}}
                    {{--                </div>--}}
                </div>
            </div>

            <button title="Close (Esc)" type="button" class="mfp-close">
                ×
            </button>
        </div><!-- End .row -->
    </div>
        <!-- End .product-single-container -->


        <div class="mt-lg-3 wpb_custom_3df3a217ba8228c65da804bd5a0f04b6">
            <div class="woocommerce-tabs woocommerce-tabs-kktu2rb5 resp-htabs" id="product-tab" style="display: block; width: 100%;">
                <ul class="resp-tabs-list" role="tablist">
                    <li class="description_tab resp-tab-item resp-tab-active" id="tab-title-description" role="tab" aria-controls="tab_item-0">
                        Description				</li>
{{--                    <li class="additional_information_tab resp-tab-item" id="tab-title-additional_information" role="tab" aria-controls="tab_item-1">--}}
{{--                        Additional information				</li>--}}
{{--                    <li class="reviews_tab resp-tab-item" id="tab-title-reviews" role="tab" aria-controls="tab_item-2">--}}
{{--                        Reviews (0)				</li>--}}

                </ul>
                <div class="resp-tabs-container">

                    <h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span
                            class="resp-arrow"></span>
                        Description </h2>
                    <div class="tab-content resp-tab-content resp-tab-content-active" id="tab-description"
                         aria-labelledby="tab_item-0" style="display:block">

                        <h2>Description</h2>

                        <div class="wpb-content-wrapper">
                            {!! $product->Description !!}
                        </div>
                    </div>


{{--                    <h2 class="resp-accordion" role="tab" aria-controls="tab_item-1"><span class="resp-arrow"></span>--}}
{{--                        Additional information				</h2><div class="tab-content resp-tab-content" id="tab-additional_information" aria-labelledby="tab_item-1">--}}

{{--                        <h2>Additional information</h2>--}}

{{--                        <table class="woocommerce-product-attributes shop_attributes table table-striped">--}}
{{--                            <tbody><tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--weight">--}}
{{--                                <th class="woocommerce-product-attributes-item__label">Weight</th>--}}
{{--                                <td class="woocommerce-product-attributes-item__value">23 kg</td>--}}
{{--                            </tr>--}}
{{--                            <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--dimensions">--}}
{{--                                <th class="woocommerce-product-attributes-item__label">Dimensions</th>--}}
{{--                                <td class="woocommerce-product-attributes-item__value">12 × 23 × 56 cm</td>--}}
{{--                            </tr>--}}
{{--                            <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_model">--}}
{{--                                <th class="woocommerce-product-attributes-item__label">Model</th>--}}
{{--                                <td class="woocommerce-product-attributes-item__value"><p>Motor</p>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody></table>--}}

{{--                    </div>--}}


{{--                    <h2 class="resp-accordion" role="tab" aria-controls="tab_item-2"><span class="resp-arrow"></span>--}}
{{--                        Reviews (0)				</h2><div class="tab-content resp-tab-content" id="tab-reviews" aria-labelledby="tab_item-2">--}}
{{--                        <div id="reviews" class="woocommerce-Reviews">--}}
{{--                            <div id="comments">--}}
{{--                                <h2 class="woocommerce-Reviews-title">--}}
{{--                                    Reviews		</h2>--}}


{{--                                <p class="woocommerce-noreviews">There are no reviews yet.</p>--}}

{{--                            </div>--}}

{{--                            <hr class="tall">--}}


{{--                            <div id="review_form_wrapper">--}}
{{--                                <div id="review_form">--}}
{{--                                    <div id="respond" class="comment-respond">--}}
{{--                                        <h3 id="reply-title" class="comment-reply-title">Be the first to review “Product Short Name” <small><a rel="nofollow" id="cancel-comment-reply-link" href="/wordpress/porto/shop42/product/product13/#respond" style="display:none;">Cancel reply</a></small></h3><form action="https://www.portotheme.com/wordpress/porto/shop42/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate=""><div class="comment-form-rating"><label for="rating">Your rating&nbsp;<span class="required">*</span></label><p class="stars">						<span>							<a class="star-1" href="#">1</a>							<a class="star-2" href="#">2</a>							<a class="star-3" href="#">3</a>							<a class="star-4" href="#">4</a>							<a class="star-5" href="#">5</a>						</span>					</p><select name="rating" id="rating" required="" style="display: none;">--}}
{{--                                                    <option value="">Rate…</option>--}}
{{--                                                    <option value="5">Perfect</option>--}}
{{--                                                    <option value="4">Good</option>--}}
{{--                                                    <option value="3">Average</option>--}}
{{--                                                    <option value="2">Not that bad</option>--}}
{{--                                                    <option value="1">Very poor</option>--}}
{{--                                                </select></div><p class="comment-form-comment"><label for="comment">Your review <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea></p><p class="comment-form-author"><label for="author">Name&nbsp;<span class="required">*</span></label><input id="author" name="author" type="text" value="" size="30" required=""></p>--}}
{{--                                            <p class="comment-form-email"><label for="email">Email&nbsp;<span class="required">*</span></label><input id="email" name="email" type="email" value="" size="30" required=""></p>--}}
{{--                                            <p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"> <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label></p>--}}
{{--                                            <p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Submit"> <input type="hidden" name="comment_post_ID" value="2823" id="comment_post_ID">--}}
{{--                                                <input type="hidden" name="comment_parent" id="comment_parent" value="0">--}}
{{--                                            </p></form>	</div><!-- #respond -->--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="clear"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>


                <script>
                    ( function() {
                        var porto_init_desc_tab = function() {
                            ( function( $ ) {
                                var $tabs = $('.woocommerce-tabs-kktu2rb5');

                                function init_tabs($tabs) {
                                    $tabs.easyResponsiveTabs({
                                        type: 'default', //Types: default, vertical, accordion
                                        width: 'auto', //auto or any width like 600px
                                        fit: true,   // 100% fit in a container
                                        activate: function(event) { // Callback function if tab is switched
                                        }
                                    });
                                }
                                if (!$.fn.easyResponsiveTabs) {
                                    var js_src = "https://www.portotheme.com/wordpress/porto/shop42/wp-content/themes/porto/js/libs/easy-responsive-tabs.min.js";
                                    if (!$('script[src="' + js_src + '"]').length) {
                                        var js = document.createElement('script');
                                        $(js).appendTo('body').on('load', function() {
                                            init_tabs($tabs);
                                        }).attr('src', js_src);
                                    }
                                } else {
                                    init_tabs($tabs);
                                }

                                var $review_content = $tabs.find('#tab-reviews'),
                                    $review_title1 = $tabs.find('h2[aria-controls=tab_item-2]'),
                                    $review_title2 = $tabs.find('li[aria-controls=tab_item-2]');

                                function goReviewTab(target) {
                                    var recalc_pos = false;
                                    if ($review_content.length && $review_content.css('display') == 'none') {
                                        recalc_pos = true;
                                        if ($review_title1.length && $review_title1.css('display') != 'none')
                                            $review_title1.click();
                                        else if ($review_title2.length && $review_title2.closest('ul').css('display') != 'none')
                                            $review_title2.click();
                                    }

                                    var delay = recalc_pos ? 400 : 0;
                                    setTimeout(function() {
                                        $('html, body').stop().animate({
                                            scrollTop: target.offset().top - theme.StickyHeader.sticky_height - theme.adminBarHeight() - 14
                                        }, 600, 'easeOutQuad');
                                    }, delay);
                                }

                                function goAccordionTab(target) {
                                    setTimeout(function() {
                                        var label = target.attr('aria-controls');
                                        var $tab_content = $tabs.find('.resp-tab-content[aria-labelledby="' + label + '"]');
                                        if ($tab_content.length && $tab_content.css('display') != 'none') {
                                            var offset = target.offset().top - theme.StickyHeader.sticky_height - theme.adminBarHeight() - 14;
                                            if (offset < $(window).scrollTop())
                                                $('html, body').stop().animate({
                                                    scrollTop: offset
                                                }, 600, 'easeOutQuad');
                                        }
                                    }, 500);
                                }

                                // go to reviews, write a review
                                $('.woocommerce-review-link, .woocommerce-write-review-link').on('click', function(e) {
                                    var target = $(this.hash);
                                    if (target.length) {
                                        e.preventDefault();

                                        goReviewTab(target);

                                        return false;
                                    }
                                });
                                // Open review form if accessed via anchor
                                if ( window.location.hash == '#review_form' || window.location.hash == '#reviews' || window.location.hash.indexOf('#comment-') != -1 ) {
                                    var target = $(window.location.hash);
                                    if (target.length) {
                                        goReviewTab(target);
                                    }
                                }

                                $tabs.find('h2.resp-accordion').on('click', function(e) {
                                    goAccordionTab($(this));
                                });
                            } )( window.jQuery );
                        };

                        if ( window.theme && theme.isLoaded ) {
                            porto_init_desc_tab();
                        } else {
                            window.addEventListener( 'load', porto_init_desc_tab );
                        }
                    } )();
                </script>
            </div>

        </div>





        <section class="product-section1 recently">
            <div class="container">
                <h2 class="title title-underline pb-1 appear-animate" data-animation-name="fadeInLeftShorter">
                    Related Products</h2>
                <div class="owl-carousel owl-theme appear-animate" data-owl-options="{
        'loop': false,
        'dots': false,
        'nav': true,
        'margin': 20,
        'responsive': {
            '0': {
                'items': 2
            },
            '576': {
                'items': 4
            },
            '991': {
                'items': 6
            }
        }
    }">
                    @for ($i = 0; $i < 6; $i++)
                        @php
                            $relatedProduct = $RelatedProducts[$i];
                            $ratingWidth = rand(0, 100);
                        @endphp
                        <div class="product-default inner-quickview inner-icon product-div">
                            <figure>
                                <a href="#">
                                    <img src="{{ $relatedProduct->ProductImage }}" width="300" height="300" alt="product">
                                </a>
                                <div class="label-group">
                                    {{-- <span class="product-label label-sale">-13%</span> --}}
                                </div>
                                <div class="btn-icon-group">
                                    <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{ $relatedProduct->ProductID }}"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                                <a href="{{ route('products.quickView', $relatedProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
                            </figure>
                            <div class="product-details">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <a href="#">{{ $relatedProduct->PSCName }}</a>
                                    </div>
                                    {{--                    <a href="#" class="btn-icon-wish {{ $relatedProduct->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>--}}
                                </div>
                                <h3 class="product-title">
                                    <a href="#">{{ $relatedProduct->ProductName }}</a>
                                </h3>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:{{ $ratingWidth }}%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>
    </div>

{{--    <div class="main-content col-lg-12">--}}


{{--        <div id="primary" class="content-area">--}}
{{--            <main id="content" class="site-main">--}}


{{--                <div class="woocommerce-notices-wrapper"></div>--}}
{{--                <div id="product-2823" class="product type-product post-2823 status-publish first instock product_cat-external-accessories product_cat-hot-deals product_tag-ford has-post-thumbnail sale downloadable shipping-taxable purchasable product-type-simple product-layout-builder">--}}

{{--                    <div class="porto-block" data-id="3440">--}}
{{--                        <style>.vc_custom_1686008322696 {--}}
{{--                                margin-bottom: 1.875rem !important;--}}
{{--                            }--}}

{{--                            .vc_custom_1686184843273 {--}}
{{--                                margin-bottom: 1.875rem !important;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .owl-item:not(.active) {--}}
{{--                                opacity: 1;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .zoom {--}}
{{--                                left: 4px;--}}
{{--                                width: 38px;--}}
{{--                                height: 38px;--}}
{{--                                border: 2px solid;--}}
{{--                                box-sizing: content-box;--}}
{{--                                border-color: #e7e7e7;--}}
{{--                                margin: 0 18px 18px 18px;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .image-galley-viewer {--}}
{{--                                left: 4px;--}}
{{--                                width: 38px;--}}
{{--                                height: 38px;--}}
{{--                                --porto-product-action-width: 38px;--}}
{{--                                border: 2px solid;--}}
{{--                                box-sizing: content-box;--}}
{{--                                --porto-product-action-border: 2px;--}}
{{--                                border-color: #e7e7e7;--}}
{{--                                margin: 0 18px;--}}
{{--                                --porto-product-action-margin: 18px;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .zoom, .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .img-thumbnail:hover .zoom {--}}
{{--                                background-color: #ffffff;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .image-galley-viewer, .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .img-thumbnail:hover .image-galley-viewer {--}}
{{--                                background-color: #ffffff;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .zoom i {--}}
{{--                                line-height: 38px;--}}
{{--                                font-size: 15px;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .image-galley-viewer i {--}}
{{--                                line-height: 38px;--}}
{{--                                font-size: 15px;--}}
{{--                            }--}}

{{--                            .wpb_custom_28cd31740062b65fa72da7855828c3e8 .product-images .image-galley-viewer.without-zoom {--}}
{{--                                margin-bottom: 18px;--}}
{{--                            }--}}

{{--                            .wpb_custom_8f6d0738362b448ff07fec85b28a8a37 .review-link {--}}
{{--                                font-size: 12px;--}}
{{--                            }--}}

{{--                            .wpb_custom_c6c3704a6e3e934fed6212c4b339237c .product-summary-wrap .quantity .minus {--}}
{{--                                border-width: 2px 0px 2px 2px;--}}
{{--                            }--}}

{{--                            .wpb_custom_c6c3704a6e3e934fed6212c4b339237c .product-summary-wrap .quantity .qty {--}}
{{--                                border-width: 2px 1px 2px 1px;--}}
{{--                            }--}}

{{--                            .wpb_custom_c6c3704a6e3e934fed6212c4b339237c .product-summary-wrap .quantity .plus {--}}
{{--                                border-width: 2px 2px 2px 0px;--}}
{{--                            }--}}

{{--                            .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a span {--}}
{{--                                width: auto;--}}
{{--                                text-indent: 0;--}}
{{--                                font-weight: 700;--}}
{{--                                font-size: 13px;--}}
{{--                                text-transform: uppercase;--}}
{{--                            }--}}

{{--                            .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 .yith-wcwl-add-to-wishlist a:before {--}}
{{--                                position: static;--}}
{{--                                margin-right: 0.125rem;--}}
{{--                                line-height: 1;--}}
{{--                            }--}}

{{--                            .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 .yith-wcwl-wishlistaddedbrowse a:before, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 .yith-wcwl-wishlistexistsbrowse a:before {--}}
{{--                                color: #da5555;--}}
{{--                            }--}}

{{--                            .single-product .product-summary-wrap .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a, .single-product .product-summary-wrap .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a span, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a span:not(.yith-wcwl-tooltip) {--}}
{{--                                color: #222529;--}}
{{--                            }--}}

{{--                            .single-product .product-summary-wrap .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover, .single-product .product-summary-wrap .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover span, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover span {--}}
{{--                                color: #f26100;--}}
{{--                            }--}}

{{--                            .single-product .product-summary-wrap .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover, .wpb_custom_c06d0c01b425e1d36f52a84b39afb506 a:hover {--}}
{{--                                background-color: #ffffff;--}}
{{--                                border-color: #ffffff;--}}
{{--                            }--}}

{{--                            .wpb_custom_83f06af8bcb7f7c49b58cd12e98587f8 .yith-wfbt-images td img {--}}
{{--                                width: 106px;--}}
{{--                            }--}}

{{--                            .wpb_custom_83f06af8bcb7f7c49b58cd12e98587f8 .yith-wfbt-images .image_plus {--}}
{{--                                width: 40px;--}}
{{--                                font-size: 24px;--}}
{{--                            }--}}

{{--                            .wpb_custom_83f06af8bcb7f7c49b58cd12e98587f8 .price_text {--}}
{{--                                margin-bottom: 13px;--}}
{{--                            }--}}

{{--                            .wpb_custom_83f06af8bcb7f7c49b58cd12e98587f8 .yith-wfbt-item {--}}
{{--                                font-size: 15px;--}}
{{--                            }--}}

{{--                            .wpb_custom_3df3a217ba8228c65da804bd5a0f04b6 .resp-tabs-list li, .wpb_custom_3df3a217ba8228c65da804bd5a0f04b6 .resp-accordion {--}}
{{--                                color: #777777 !important;--}}
{{--                                font-weight: 600;--}}
{{--                                font-size: 1rem;--}}
{{--                                letter-spacing: -0.01em;--}}
{{--                            }--}}

{{--                            .wpb_custom_3df3a217ba8228c65da804bd5a0f04b6 .tab-content h2 {--}}
{{--                                font-weight: 600;--}}
{{--                                font-size: 14px;--}}
{{--                                letter-spacing: -.01em;--}}
{{--                                line-height: 1;--}}
{{--                                text-transform: uppercase;--}}
{{--                            }--}}

{{--                            .wpb_custom_3df3a217ba8228c65da804bd5a0f04b6 .woocommerce-tabs .tab-content {--}}
{{--                                padding: 21px 0px 15px 0px;--}}
{{--                            }--}}

{{--                            .wpb_custom_4f82888d1bd42c841f5e1a7616421c83 .owl-dots {--}}
{{--                                top: -48px !important;--}}
{{--                            }--}}

{{--                            .wpb_custom_4f82888d1bd42c841f5e1a7616421c83 .owl-dots {--}}
{{--                                right: 10px !important;--}}
{{--                            }--}}

{{--                            .wpb_custom_4f82888d1bd42c841f5e1a7616421c83 .owl-dots:not(.disabled) {--}}
{{--                                display: block !important;--}}
{{--                            }--}}

{{--                            .wpb_custom_4f82888d1bd42c841f5e1a7616421c83 .sp-linked-heading {--}}
{{--                                font-weight: 600;--}}
{{--                                font-size: 1rem;--}}
{{--                                letter-spacing: -0.01em;--}}
{{--                                line-height: 2.5em;--}}
{{--                            }--}}

{{--                            .wpb_custom_4f82888d1bd42c841f5e1a7616421c83 .owl-item:not(.active) {--}}
{{--                                opacity: 0.5--}}
{{--                            }--}}

{{--                            .yith-wfbt-section h3 {--}}
{{--                                font-size: 1rem;--}}
{{--                                font-weight: 600;--}}
{{--                                line-height: 2.5;--}}
{{--                                letter-spacing: -.01em;--}}
{{--                                text-transform: uppercase;--}}
{{--                                border-bottom: 1px solid #e7e7e7;--}}
{{--                                margin-bottom: 12px;--}}
{{--                            }--}}

{{--                            .yith-wfbt-section .yith-wfbt-images .image_plus {--}}
{{--                                color: #222529;--}}
{{--                            }--}}

{{--                            .yith-wfbt-submit-block .price_text {--}}
{{--                                padding-top: 30px;--}}
{{--                                font-size: 16px;--}}
{{--                            }--}}

{{--                            .yith-wfbt-item .product-name {--}}
{{--                                color: #222329;--}}
{{--                            }--}}

{{--                            .wooco-products {--}}
{{--                                border-width: 0;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product {--}}
{{--                                align-items: unset;--}}
{{--                                border-width: 0;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product .wooco-thumb {--}}
{{--                                width: 100px;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product .wooco-thumb img {--}}
{{--                                width: 80px;--}}
{{--                                height: 80px;--}}
{{--                                max-width: 80px;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product .wooco-title {--}}
{{--                                font-size: 16px;--}}
{{--                                font-weight: 600;--}}
{{--                                order: 1;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product form.variations_form .variations .variation > div {--}}
{{--                                display: inline-block;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product form.variations_form .variations .variation {--}}
{{--                                display: block;--}}
{{--                                float: unset;--}}
{{--                                border-width: 0;--}}
{{--                                margin-right: 0;--}}
{{--                                padding: 0;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product form.variations_form .variations .variation .label {--}}
{{--                                font-size: 14px;--}}
{{--                                font-weight: 600;--}}
{{--                                color: #222529;--}}
{{--                            }--}}

{{--                            .wooco-product .wooco-qty,--}}
{{--                            .wooco-product .wooco-price,--}}
{{--                            .wooco-products .wooco-product .wooco-title .wooco-title-inner {--}}
{{--                                display: flex;--}}
{{--                                align-items: center;--}}
{{--                                height: 80px;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product .wooco-price {--}}
{{--                                text-align: left;--}}
{{--                                font-size: 20px;--}}
{{--                                font-weight: 600;--}}
{{--                                color: #222529;--}}
{{--                                justify-content: flex-end;--}}
{{--                                width: 180px;--}}
{{--                                flex: 0 0 180px;--}}
{{--                                order: 2;--}}
{{--                            }--}}

{{--                            .wooco-products .wooco-product .wooco-price ins {--}}
{{--                                font-weight: 600;--}}
{{--                            }--}}

{{--                            @media (max-width: 1159px) and (min-width: 768px) {--}}
{{--                                .wooco-products .wooco-product {--}}
{{--                                    display: block;--}}
{{--                                    border-bottom-width: 1px;--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .reset_variations {--}}
{{--                                    margin-bottom: 1rem !important;--}}
{{--                                }--}}

{{--                                .wooco-product .wooco-qty, .wooco-product .wooco-price, .wooco-products .wooco-product .wooco-title .wooco-title-inner {--}}
{{--                                    height: auto;--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .wooco-products .wooco-product .wooco-thumb {--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .wooco-products .wooco-product .wooco-price {--}}
{{--                                    justify-content: flex-start;--}}
{{--                                    text-align: left !important;--}}
{{--                                }--}}
{{--                            }--}}

{{--                            @media (max-width: 575px) {--}}
{{--                                .wooco-products .wooco-product {--}}
{{--                                    display: block;--}}
{{--                                    border-bottom-width: 1px;--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .reset_variations {--}}
{{--                                    margin-bottom: 1rem !important;--}}
{{--                                }--}}

{{--                                .wooco-product .wooco-qty, .wooco-product .wooco-price, .wooco-products .wooco-product .wooco-title .wooco-title-inner {--}}
{{--                                    height: auto;--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .wooco-products .wooco-product .wooco-thumb {--}}
{{--                                    margin-bottom: 1rem;--}}
{{--                                }--}}

{{--                                .wooco-products .wooco-product .wooco-price {--}}
{{--                                    justify-content: flex-start;--}}
{{--                                    text-align: left !important;--}}
{{--                                }--}}
{{--                            }--}}


{{--                            .woocommerce-Reviews {--}}
{{--                                display: flex;--}}
{{--                                flex-wrap: wrap;--}}
{{--                            }--}}

{{--                            .woocommerce-Reviews > div:not(.clear) {--}}
{{--                                width: 100%;--}}
{{--                            }--}}

{{--                            #reviews .cr-summaryBox-wrap {--}}
{{--                                display: block;--}}
{{--                                background: #fff;--}}
{{--                            }--}}

{{--                            #reviews .cr-summaryBox-wrap .cr-overall-rating-wrap {--}}
{{--                                display: block;--}}
{{--                            }--}}

{{--                            #reviews .cr-summaryBox-wrap .ivole-summaryBox,--}}
{{--                            #reviews .cr-summaryBox-wrap .cr-overall-rating-wrap {--}}
{{--                                padding-left: 0;--}}
{{--                                padding-right: 0;--}}
{{--                            }--}}

{{--                            #reviews .commentlist {--}}
{{--                                margin-right: 40px;--}}
{{--                            }--}}

{{--                            #reviews .commentlist .img-thumbnail img {--}}
{{--                                max-width: 65px;--}}
{{--                                border-radius: 50%;--}}
{{--                            }--}}

{{--                            #reviews .comment-form {--}}
{{--                                padding: 0;--}}
{{--                                background: #fff;--}}
{{--                            }--}}

{{--                            #reviews .comment-form > * {--}}
{{--                                margin-bottom: 2rem;--}}
{{--                            }--}}

{{--                            #reviews .comment-form label {--}}
{{--                                font-weight: 400;--}}
{{--                                color: #777;--}}
{{--                            }--}}

{{--                            #ivole-histogramTable {--}}
{{--                                margin-left: 0;--}}
{{--                            }--}}

{{--                            .ivole-meter {--}}
{{--                                height: 10px;--}}
{{--                                background: #f3f3f3;--}}
{{--                                box-shadow: none;--}}
{{--                                border-radius: 5px;--}}
{{--                            }--}}

{{--                            .ivole-meter .ivole-meter-bar {--}}
{{--                                box-shadow: none;--}}
{{--                                border-radius: 5px;--}}
{{--                                background: #d8d8d8;--}}
{{--                            }--}}

{{--                            #review_form_wrapper .comment-respond {--}}
{{--                                margin-top: 3rem;--}}
{{--                            }--}}

{{--                            #review_form_wrapper .comment-reply-title {--}}
{{--                                font-size: 14px;--}}
{{--                                font-weight: 600;--}}
{{--                                letter-spacing: -.01em;--}}
{{--                                color: #222529;--}}
{{--                                text-transform: uppercase;--}}
{{--                            }--}}

{{--                            #reviews #comments .cr-summaryBox-wrap .crstar-rating,--}}
{{--                            #reviews span.required,--}}
{{--                            #reviews #comments .star-rating span:before {--}}
{{--                                color: #ff5b5b;--}}
{{--                            }--}}

{{--                            #review_form {--}}
{{--                                position: sticky;--}}
{{--                                top: 10px;--}}
{{--                            }--}}

{{--                            #reviews .form-submit .submit {--}}
{{--                                text-transform: uppercase;--}}
{{--                                padding: 1rem 3rem;--}}
{{--                            }--}}

{{--                            #reviews .comment-form input[type=text],--}}
{{--                            #reviews .comment-form input[type=email] {--}}
{{--                                line-height: 2;--}}
{{--                            }--}}

{{--                            #reviews .commentlist li {--}}
{{--                                padding-left: 85px;--}}
{{--                            }--}}

{{--                            .commentlist li .comment-text p {--}}
{{--                                font-size: 14px;--}}
{{--                                line-height: 27px;--}}
{{--                            }--}}

{{--                            #reviews .commentlist .comment-text {--}}
{{--                                display: flex;--}}
{{--                                flex-direction: column;--}}
{{--                                padding: 0;--}}
{{--                                background: #fff;--}}
{{--                            }--}}

{{--                            #reviews .commentlist .comment-text:before {--}}
{{--                                content: none;--}}
{{--                            }--}}

{{--                            #reviews .commentlist .star-rating {--}}
{{--                                float: unset;--}}
{{--                                margin-bottom: 7px;--}}
{{--                            }--}}

{{--                            .commentlist li .comment-text .meta {--}}
{{--                                order: -1;--}}
{{--                                margin-bottom: 10px;--}}
{{--                            }--}}

{{--                            .commentlist li .comment-text .meta strong {--}}
{{--                                color: #222529;--}}
{{--                            }--}}

{{--                            @media (min-width: 1025px) {--}}
{{--                                .woocommerce-Reviews {--}}
{{--                                    flex-wrap: nowrap;--}}
{{--                                }--}}

{{--                                #review_form_wrapper .comment-respond {--}}
{{--                                    margin-top: 0;--}}
{{--                                }--}}
{{--                            }--}}

{{--                            @media (max-width: 575px) {--}}
{{--                                .commentlist li .comment_container {--}}
{{--                                    background: #fff;--}}
{{--                                }--}}

{{--                                #reviews .commentlist {--}}
{{--                                    margin-right: 0;--}}
{{--                                }--}}

{{--                                #reviews .commentlist li {--}}
{{--                                    padding-left: 0;--}}
{{--                                }--}}
{{--                            }</style>--}}
{{--                        <div class="vc_row wpb_row top-row porto-inner-container">--}}
{{--                            <div class="porto-wrap-container container">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6 product-single-gallery mb-md-0">--}}
{{--                                        <div class="product-slider-container">--}}
{{--                                            <div class="product-single-carousel owl-carousel owl-theme show-nav-hover owl-loaded owl-drag">--}}

{{--                                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 424px;"><div class="owl-item active" style="width: 423.5px;"><div class="product-item">--}}
{{--                                                                <img class="product-single-image" src="http://localhost/RPC/assets/images/no-image-b.png" data-zoom-image="http://localhost/RPC/assets/images/no-image-b.png">--}}
{{--                                                                <div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;height:423.5px;width:423.5px;"><div class="zoomWindowContainer" style="width: 400px;"><div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: -2004.21px -4069.25px; width: 423.5px; height: 423.5px; float: left; cursor: grab; background-repeat: no-repeat; position: absolute; background-image: url(&quot;http://localhost/RPC/assets/images/no-image-b.png&quot;); top: 0px; left: 0px; display: none;" class="zoomWindow">&nbsp;</div></div></div></div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next disabled"><i class="icon-angle-right"></i></button></div></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="prod-thumbnail owl-dots owl-carousel owl-theme show-nav-hover owl-loaded owl-drag">--}}

{{--                                            <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1500px !important;"><div class="owl-item active" style="width: 99.875px; margin-right: 8px;"><div class="owl-dot active">--}}
{{--                                                            <img src="http://localhost/RPC/assets/images/no-image-b.png">--}}
{{--                                                        </div></div></div></div><div class="owl-nav disabled"><button type="button" title="nav" role="presentation" class="owl-prev disabled"><i class="fas fa-chevron-left"></i></button><button type="button" title="nav" role="presentation" class="owl-next disabled"><i class="fas fa-chevron-right"></i></button></div><div class="owl-dots disabled"></div></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="wpb_wrapper vc_column-inner">--}}
{{--                                            <div class="wpb_custom_0">--}}
{{--                                            </div>--}}
{{--                                            <h2 class="product_title entry-title show-product-nav">Product Short--}}
{{--                                                Name</h2>--}}
{{--                                            <div class="wpb_custom_8f6d0738362b448ff07fec85b28a8a37">--}}
{{--                                                <div class="woocommerce-product-rating">--}}
{{--                                                    <div class="star-rating" title="" data-bs-original-title="0">--}}
{{--		<span style="width:0%">--}}
{{--						<strong class="rating">0</strong> out of 5		</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="review-link noreview">--}}
{{--                                                        <a href="#review_form" class="woocommerce-write-review-link" rel="nofollow">( There are no reviews yet. )</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="wpb_custom_77090d79c3fd758972c3f759c33f2003">--}}
{{--                                                <div class="single-product-price">--}}
{{--                                                    <p class="price">--}}
{{--                                                        <del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>299.00</bdi></span>--}}
{{--                                                        </del>--}}
{{--                                                        <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>259.00</bdi></span>--}}
{{--                                                        </ins>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-0">--}}
{{--                                                <div class="description woocommerce-product-details__short-description">--}}
{{--                                                    <p>Pellentesque habitant morbi tristique senectus et netus et--}}
{{--                                                        malesuada fames ac turpis egestas. Vestibulum tortor quam,--}}
{{--                                                        feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu--}}
{{--                                                        libero sit amet quam egestas semper. Aenean ultricies mi vitae--}}
{{--                                                        est. Mauris placerat eleifend leo.</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3 wpb_custom_0ee23895009ca265b2bcfc2b33fb9222">--}}
{{--                                                <div class="product_meta">--}}


{{--                                                    <span class="sku_wrapper">SKU: <span class="sku">654111995-1-2-1-1</span></span>--}}


{{--                                                    <span class="posted_in">Categories: <a href="https://www.portotheme.com/wordpress/porto/shop42/product-category/external-accessories/" rel="tag">External Accessories</a>, <a href="https://www.portotheme.com/wordpress/porto/shop42/product-category/hot-deals/" rel="tag">Hot Deals</a></span>--}}
{{--                                                    <span class="tagged_as">Tag: <a href="https://www.portotheme.com/wordpress/porto/shop42/product-tag/ford/" rel="tag">Ford</a></span>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="wpb_custom_c6c3704a6e3e934fed6212c4b339237c">--}}
{{--                                                <div class="product-summary-wrap">--}}

{{--                                                    <form class="cart" action="https://www.portotheme.com/wordpress/porto/shop42/product/product13/" method="post" enctype="multipart/form-data">--}}

{{--                                                        <div class="quantity buttons_added">--}}
{{--                                                            <button type="button" value="-" class="minus">-</button>--}}
{{--                                                            <input type="number" id="quantity_65e6a30978274" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" aria-label="Product quantity" size="4" placeholder="" inputmode="numeric">--}}
{{--                                                            <button type="button" value="+" class="plus">+</button>--}}
{{--                                                        </div>--}}

{{--                                                        <button type="submit" name="add-to-cart" value="2823" class="single_add_to_cart_button button alt">Add to cart--}}
{{--                                                        </button>--}}

{{--                                                    </form>--}}


{{--                                                </div>--}}
{{--                                            </div>--}}



























{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="vc_row wpb_row top-row porto-inner-container">--}}
{{--                            <div class="porto-wrap-container container">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="vc_column_container col-md-12">--}}
{{--                                        <div class="wpb_wrapper vc_column-inner">--}}
{{--                                            <div class="wpb_custom_83f06af8bcb7f7c49b58cd12e98587f8"></div>--}}
{{--                                            <div class="mt-lg-3 mb-3 wpb_custom_3df3a217ba8228c65da804bd5a0f04b6">--}}
{{--                                                <div class="woocommerce-tabs woocommerce-tabs-kktu2rb5 resp-htabs" id="product-tab" style="display: block; width: 100%;">--}}
{{--                                                    <ul class="resp-tabs-list" role="tablist">--}}
{{--                                                        <li class="description_tab resp-tab-item resp-tab-active" id="tab-title-description" role="tab" aria-controls="tab_item-0">--}}
{{--                                                            Description--}}
{{--                                                        </li>--}}
{{--                                                        <li class="additional_information_tab resp-tab-item" id="tab-title-additional_information" role="tab" aria-controls="tab_item-1">--}}
{{--                                                            Additional information--}}
{{--                                                        </li>--}}
{{--                                                        <li class="reviews_tab resp-tab-item" id="tab-title-reviews" role="tab" aria-controls="tab_item-2">--}}
{{--                                                            Reviews (0)--}}
{{--                                                        </li>--}}

{{--                                                    </ul>--}}
{{--                                                    <div class="resp-tabs-container">--}}

{{--                                                        <h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span class="resp-arrow"></span>--}}
{{--                                                            Description </h2>--}}
{{--                                                        <div class="tab-content resp-tab-content resp-tab-content-active" id="tab-description" aria-labelledby="tab_item-0" style="display:block">--}}

{{--                                                            <h2>Description</h2>--}}

{{--                                                            <div class="wpb-content-wrapper">--}}
{{--                                                                <div class="vc_row wpb_row row top-row m-b-md">--}}
{{--                                                                    <div class="vc_column_container col-md-12">--}}
{{--                                                                        <div class="wpb_wrapper vc_column-inner">--}}
{{--                                                                            <div class="wpb_text_column wpb_content_element ">--}}
{{--                                                                                <div class="wpb_wrapper">--}}
{{--                                                                                    <p>Lorem ipsum dolor sit amet,--}}
{{--                                                                                        consectetur adipiscing elit, sed--}}
{{--                                                                                        do eiusmod tempor incididunt ut--}}
{{--                                                                                        labore et dolore magna aliqua.--}}
{{--                                                                                        Ut enim ad minim veniam, nostrud--}}
{{--                                                                                        ipsum consectetur sed do, quis--}}
{{--                                                                                        nostrud exercitation ullamco--}}
{{--                                                                                        laboris nisi ut aliquip ex ea--}}
{{--                                                                                        commodo consequat. Duis aute--}}
{{--                                                                                        irure dolor in reprehenderit in--}}
{{--                                                                                        voluptate velit esse cillum--}}
{{--                                                                                        dolore eu fugiat nulla pariatur.--}}
{{--                                                                                        Excepteur sint occaecat.</p>--}}

{{--                                                                                </div>--}}
{{--                                                                            </div>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="vc_row wpb_row row top-row m-b-md vc_custom_1511248807031">--}}
{{--                                                                    <div class="vc_column_container col-md-12">--}}
{{--                                                                        <div class="wpb_wrapper vc_column-inner">--}}
{{--                                                                            <style>#porto-info-list134973087665e6a3097b1c7 i {--}}
{{--                                                                                    color: #21293c;--}}
{{--                                                                                    font-size: 16px;--}}
{{--                                                                                }</style>--}}
{{--                                                                            <ul id="porto-info-list134973087665e6a3097b1c7" class="porto-info-list  wpb_custom_a8283160c59238d5e464cd213570c9f4">--}}
{{--                                                                                <li class="porto-info-list-item  wpb_custom_205edc6de9e53bd4458e8a5265d85879">--}}
{{--                                                                                    <i class="porto-info-icon fa fa-check-circle"></i>--}}
{{--                                                                                    <div class="porto-info-list-item-desc">--}}
{{--                                                                                        Any Product types that You want--}}
{{--                                                                                        – Simple, Configurable--}}
{{--                                                                                    </div>--}}
{{--                                                                                </li>--}}
{{--                                                                                <li class="porto-info-list-item  wpb_custom_205edc6de9e53bd4458e8a5265d85879">--}}
{{--                                                                                    <i class="porto-info-icon fa fa-check-circle"></i>--}}
{{--                                                                                    <div class="porto-info-list-item-desc">--}}
{{--                                                                                        Downloadable/Digital Products,--}}
{{--                                                                                        Virtual Products--}}
{{--                                                                                    </div>--}}
{{--                                                                                </li>--}}
{{--                                                                                <li class="porto-info-list-item  wpb_custom_205edc6de9e53bd4458e8a5265d85879">--}}
{{--                                                                                    <i class="porto-info-icon fa fa-check-circle"></i>--}}
{{--                                                                                    <div class="porto-info-list-item-desc">--}}
{{--                                                                                        Inventory Management with--}}
{{--                                                                                        Backordered items--}}
{{--                                                                                    </div>--}}
{{--                                                                                </li>--}}
{{--                                                                            </ul>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="vc_row wpb_row row top-row">--}}
{{--                                                                    <div class="vc_column_container col-md-12">--}}
{{--                                                                        <div class="wpb_wrapper vc_column-inner">--}}
{{--                                                                            <div class="wpb_text_column wpb_content_element ">--}}
{{--                                                                                <div class="wpb_wrapper">--}}
{{--                                                                                    <p>Sed do eiusmod tempor incididunt--}}
{{--                                                                                        ut labore et dolore magna--}}
{{--                                                                                        aliqua. Ut enim ad minim veniam,--}}
{{--                                                                                        quis nostrud exercitation--}}
{{--                                                                                        ullamco laboris nisi ut aliquip--}}
{{--                                                                                        ex ea commodo consequat.</p>--}}

{{--                                                                                </div>--}}
{{--                                                                            </div>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}


{{--                                                        <h2 class="resp-accordion" role="tab" aria-controls="tab_item-1"><span class="resp-arrow"></span>--}}
{{--                                                            Additional information </h2>--}}
{{--                                                        <div class="tab-content resp-tab-content" id="tab-additional_information" aria-labelledby="tab_item-1">--}}

{{--                                                            <h2>Additional information</h2>--}}

{{--                                                            <table class="woocommerce-product-attributes shop_attributes table table-striped">--}}
{{--                                                                <tbody>--}}
{{--                                                                <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--weight">--}}
{{--                                                                    <th class="woocommerce-product-attributes-item__label">--}}
{{--                                                                        Weight--}}
{{--                                                                    </th>--}}
{{--                                                                    <td class="woocommerce-product-attributes-item__value">--}}
{{--                                                                        23 kg--}}
{{--                                                                    </td>--}}
{{--                                                                </tr>--}}
{{--                                                                <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--dimensions">--}}
{{--                                                                    <th class="woocommerce-product-attributes-item__label">--}}
{{--                                                                        Dimensions--}}
{{--                                                                    </th>--}}
{{--                                                                    <td class="woocommerce-product-attributes-item__value">--}}
{{--                                                                        12 × 23 × 56 cm--}}
{{--                                                                    </td>--}}
{{--                                                                </tr>--}}
{{--                                                                <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_model">--}}
{{--                                                                    <th class="woocommerce-product-attributes-item__label">--}}
{{--                                                                        Model--}}
{{--                                                                    </th>--}}
{{--                                                                    <td class="woocommerce-product-attributes-item__value">--}}
{{--                                                                        <p>Motor</p>--}}
{{--                                                                    </td>--}}
{{--                                                                </tr>--}}
{{--                                                                </tbody>--}}
{{--                                                            </table>--}}

{{--                                                        </div>--}}


{{--                                                        <h2 class="resp-accordion" role="tab" aria-controls="tab_item-2"><span class="resp-arrow"></span>--}}
{{--                                                            Reviews (0) </h2>--}}
{{--                                                        <div class="tab-content resp-tab-content" id="tab-reviews" aria-labelledby="tab_item-2">--}}
{{--                                                            <div id="reviews" class="woocommerce-Reviews">--}}
{{--                                                                <div id="comments">--}}
{{--                                                                    <h2 class="woocommerce-Reviews-title">--}}
{{--                                                                        Reviews </h2>--}}


{{--                                                                    <p class="woocommerce-noreviews">There are no--}}
{{--                                                                        reviews yet.</p>--}}

{{--                                                                </div>--}}

{{--                                                                <hr class="tall">--}}


{{--                                                                <div id="review_form_wrapper">--}}
{{--                                                                    <div id="review_form">--}}
{{--                                                                        <div id="respond" class="comment-respond">--}}
{{--                                                                            <h3 id="reply-title" class="comment-reply-title">Be the first--}}
{{--                                                                                to review “Product Short Name” <small><a rel="nofollow" id="cancel-comment-reply-link" href="/wordpress/porto/shop42/product/product13/#respond" style="display:none;">Cancel--}}
{{--                                                                                        reply</a></small></h3>--}}
{{--                                                                            <form action="https://www.portotheme.com/wordpress/porto/shop42/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate="">--}}
{{--                                                                                <div class="comment-form-rating"><label for="rating">Your--}}
{{--                                                                                        rating&nbsp;<span class="required">*</span></label>--}}
{{--                                                                                    <p class="stars"><span>							<a class="star-1" href="#">1</a>							<a class="star-2" href="#">2</a>							<a class="star-3" href="#">3</a>							<a class="star-4" href="#">4</a>							<a class="star-5" href="#">5</a>						</span>--}}
{{--                                                                                    </p><select name="rating" id="rating" required="" style="display: none;">--}}
{{--                                                                                        <option value="">Rate…</option>--}}
{{--                                                                                        <option value="5">Perfect--}}
{{--                                                                                        </option>--}}
{{--                                                                                        <option value="4">Good</option>--}}
{{--                                                                                        <option value="3">Average--}}
{{--                                                                                        </option>--}}
{{--                                                                                        <option value="2">Not that bad--}}
{{--                                                                                        </option>--}}
{{--                                                                                        <option value="1">Very poor--}}
{{--                                                                                        </option>--}}
{{--                                                                                    </select></div>--}}
{{--                                                                                <p class="comment-form-comment"><label for="comment">Your review <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea></p>--}}
{{--                                                                                <p class="comment-form-author"><label for="author">Name&nbsp;<span class="required">*</span></label><input id="author" name="author" type="text" value="" size="30" required=""></p>--}}
{{--                                                                                <p class="comment-form-email"><label for="email">Email&nbsp;<span class="required">*</span></label><input id="email" name="email" type="email" value="" size="30" required=""></p>--}}
{{--                                                                                <p class="comment-form-cookies-consent">--}}
{{--                                                                                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">--}}
{{--                                                                                    <label for="wp-comment-cookies-consent">Save--}}
{{--                                                                                        my name, email, and website in--}}
{{--                                                                                        this browser for the next time I--}}
{{--                                                                                        comment.</label></p>--}}
{{--                                                                                <p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Submit"> <input type="hidden" name="comment_post_ID" value="2823" id="comment_post_ID">--}}
{{--                                                                                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">--}}
{{--                                                                                </p></form>--}}
{{--                                                                        </div><!-- #respond -->--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="clear"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}

{{--                                                    </div>--}}


{{--                                                    <script>--}}
{{--                                                        (function () {--}}
{{--                                                            var porto_init_desc_tab = function () {--}}
{{--                                                                (function ($) {--}}
{{--                                                                    var $tabs = $('.woocommerce-tabs-kktu2rb5');--}}

{{--                                                                    function init_tabs($tabs) {--}}
{{--                                                                        $tabs.easyResponsiveTabs({--}}
{{--                                                                            type: 'default', //Types: default, vertical, accordion--}}
{{--                                                                            width: 'auto', //auto or any width like 600px--}}
{{--                                                                            fit: true,   // 100% fit in a container--}}
{{--                                                                            activate: function (event) { // Callback function if tab is switched--}}
{{--                                                                            }--}}
{{--                                                                        });--}}
{{--                                                                    }--}}

{{--                                                                    if (!$.fn.easyResponsiveTabs) {--}}
{{--                                                                        var js_src = "https://www.portotheme.com/wordpress/porto/shop42/wp-content/themes/porto/js/libs/easy-responsive-tabs.min.js";--}}
{{--                                                                        if (!$('script[src="' + js_src + '"]').length) {--}}
{{--                                                                            var js = document.createElement('script');--}}
{{--                                                                            $(js).appendTo('body').on('load', function () {--}}
{{--                                                                                init_tabs($tabs);--}}
{{--                                                                            }).attr('src', js_src);--}}
{{--                                                                        }--}}
{{--                                                                    } else {--}}
{{--                                                                        init_tabs($tabs);--}}
{{--                                                                    }--}}

{{--                                                                    var $review_content = $tabs.find('#tab-reviews'),--}}
{{--                                                                        $review_title1 = $tabs.find('h2[aria-controls=tab_item-2]'),--}}
{{--                                                                        $review_title2 = $tabs.find('li[aria-controls=tab_item-2]');--}}

{{--                                                                    function goReviewTab(target) {--}}
{{--                                                                        var recalc_pos = false;--}}
{{--                                                                        if ($review_content.length && $review_content.css('display') == 'none') {--}}
{{--                                                                            recalc_pos = true;--}}
{{--                                                                            if ($review_title1.length && $review_title1.css('display') != 'none')--}}
{{--                                                                                $review_title1.click();--}}
{{--                                                                            else if ($review_title2.length && $review_title2.closest('ul').css('display') != 'none')--}}
{{--                                                                                $review_title2.click();--}}
{{--                                                                        }--}}

{{--                                                                        var delay = recalc_pos ? 400 : 0;--}}
{{--                                                                        setTimeout(function () {--}}
{{--                                                                            $('html, body').stop().animate({--}}
{{--                                                                                scrollTop: target.offset().top - theme.StickyHeader.sticky_height - theme.adminBarHeight() - 14--}}
{{--                                                                            }, 600, 'easeOutQuad');--}}
{{--                                                                        }, delay);--}}
{{--                                                                    }--}}

{{--                                                                    function goAccordionTab(target) {--}}
{{--                                                                        setTimeout(function () {--}}
{{--                                                                            var label = target.attr('aria-controls');--}}
{{--                                                                            var $tab_content = $tabs.find('.resp-tab-content[aria-labelledby="' + label + '"]');--}}
{{--                                                                            if ($tab_content.length && $tab_content.css('display') != 'none') {--}}
{{--                                                                                var offset = target.offset().top - theme.StickyHeader.sticky_height - theme.adminBarHeight() - 14;--}}
{{--                                                                                if (offset < $(window).scrollTop())--}}
{{--                                                                                    $('html, body').stop().animate({--}}
{{--                                                                                        scrollTop: offset--}}
{{--                                                                                    }, 600, 'easeOutQuad');--}}
{{--                                                                            }--}}
{{--                                                                        }, 500);--}}
{{--                                                                    }--}}

{{--                                                                    // go to reviews, write a review--}}
{{--                                                                    $('.woocommerce-review-link, .woocommerce-write-review-link').on('click', function (e) {--}}
{{--                                                                        var target = $(this.hash);--}}
{{--                                                                        if (target.length) {--}}
{{--                                                                            e.preventDefault();--}}

{{--                                                                            goReviewTab(target);--}}

{{--                                                                            return false;--}}
{{--                                                                        }--}}
{{--                                                                    });--}}
{{--                                                                    // Open review form if accessed via anchor--}}
{{--                                                                    if (window.location.hash == '#review_form' || window.location.hash == '#reviews' || window.location.hash.indexOf('#comment-') != -1) {--}}
{{--                                                                        var target = $(window.location.hash);--}}
{{--                                                                        if (target.length) {--}}
{{--                                                                            goReviewTab(target);--}}
{{--                                                                        }--}}
{{--                                                                    }--}}

{{--                                                                    $tabs.find('h2.resp-accordion').on('click', function (e) {--}}
{{--                                                                        goAccordionTab($(this));--}}
{{--                                                                    });--}}
{{--                                                                })(window.jQuery);--}}
{{--                                                            };--}}

{{--                                                            if (window.theme && theme.isLoaded) {--}}
{{--                                                                porto_init_desc_tab();--}}
{{--                                                            } else {--}}
{{--                                                                window.addEventListener('load', porto_init_desc_tab);--}}
{{--                                                            }--}}
{{--                                                        })();--}}
{{--                                                    </script>--}}
{{--                                                </div>--}}

{{--                                            </div>--}}
{{--                                            <div id="porto-posts-grid-atil" class="porto-posts-grid pt-3 wpb_custom_4f82888d1bd42c841f5e1a7616421c83 porto-productsl1ws">--}}
{{--                                                <h2 class="sp-linked-heading">Related Products</h2>--}}
{{--                                                <style scope="scope">.porto-gb-bac6fe3e7b55235a4423a8db4207098a .tb-hover-content {--}}
{{--                                                        background-color: rgba(255, 255, 255, 0);--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-bac6fe3e7b55235a4423a8db4207098a {--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-0434fa1dea7c0c21db7bdc9b3670be95 {--}}
{{--                                                        background-color: rgba(255, 255, 255, 1);--}}
{{--                                                        border-style: solid;--}}
{{--                                                        border-width: 1px 1px 1px 1px;--}}
{{--                                                        border-color: rgba(231, 231, 231, 1);--}}
{{--                                                        border-radius: 50% 50% 50% 50%;--}}
{{--                                                        position: absolute;--}}
{{--                                                        z-index: 2;--}}
{{--                                                        top: 10px;--}}
{{--                                                        right: 10px;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-0434fa1dea7c0c21db7bdc9b3670be95:hover {--}}
{{--                                                        background-color: rgba(242, 97, 0, 1);--}}
{{--                                                        color: #ffffff;--}}
{{--                                                        border-color: rgba(242, 97, 0, 1);--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-0434fa1dea7c0c21db7bdc9b3670be95 {--}}
{{--                                                        font-size: 1.5rem;--}}
{{--                                                        text-align: center;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-377d621c363371180d034230281e9d12 {--}}
{{--                                                        background-color: rgba(255, 255, 255, 1);--}}
{{--                                                        border-style: solid;--}}
{{--                                                        border-width: 1px 1px 1px 1px;--}}
{{--                                                        border-color: rgba(231, 231, 231, 1);--}}
{{--                                                        border-radius: 50% 50% 50% 50%;--}}
{{--                                                        position: absolute;--}}
{{--                                                        z-index: 2;--}}
{{--                                                        top: 60px;--}}
{{--                                                        right: 10px;--}}
{{--                                                        width: 2.5rem;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-377d621c363371180d034230281e9d12:hover {--}}
{{--                                                        background-color: rgba(242, 97, 0, 1);--}}
{{--                                                        color: #ffffff;--}}
{{--                                                        border-color: rgba(242, 97, 0, 1);--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-377d621c363371180d034230281e9d12 {--}}
{{--                                                        font-size: 1.375rem;--}}
{{--                                                        line-height: 2.375rem;--}}
{{--                                                        text-align: center;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-a74cac27f4fa16d4a2258767c06aae3a {--}}
{{--                                                        background-color: rgba(242, 97, 0, 1);--}}
{{--                                                        position: absolute;--}}
{{--                                                        z-index: 2;--}}
{{--                                                        right: 0px;--}}
{{--                                                        bottom: 0px;--}}
{{--                                                        left: 0px;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-a74cac27f4fa16d4a2258767c06aae3a:hover {--}}
{{--                                                        background-color: rgba(245, 126, 50, 1);--}}
{{--                                                        color: #ffffff;--}}
{{--                                                        opacity: 1;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-a74cac27f4fa16d4a2258767c06aae3a {--}}
{{--                                                        font-size: 13px;--}}
{{--                                                        font-weight: 500;--}}
{{--                                                        text-transform: uppercase;--}}
{{--                                                        line-height: 40px;--}}
{{--                                                        letter-spacing: -.05em;--}}
{{--                                                        text-align: center;--}}
{{--                                                        color: #ffffff--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-84f638dc4fa0a1e503997126ad3e73a1 {--}}
{{--                                                        padding-top: 18px;--}}
{{--                                                        padding-bottom: 0px;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-b1ffdf49f3e84bfd12210c3edafc4133 {--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-b1ffdf49f3e84bfd12210c3edafc4133 {--}}
{{--                                                        font-size: .625rem;--}}
{{--                                                        text-transform: uppercase;--}}
{{--                                                        line-height: 1.9;--}}
{{--                                                        text-align: center;--}}
{{--                                                        color: #999999--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-b1ffdf49f3e84bfd12210c3edafc4133 a:hover {--}}
{{--                                                        color: #212529--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-670276434285b693027f0fed593ea808 {--}}
{{--                                                        margin-bottom: 8px;--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-670276434285b693027f0fed593ea808, .porto-gb-670276434285b693027f0fed593ea808 p {--}}
{{--                                                        font-size: .9375rem;--}}
{{--                                                        font-weight: 500;--}}
{{--                                                        line-height: 1.35;--}}
{{--                                                        letter-spacing: -.025em;--}}
{{--                                                        text-align: center;--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-670276434285b693027f0fed593ea808 a:hover, .porto-gb-670276434285b693027f0fed593ea808 p a:hover {--}}
{{--                                                        color: #0b0c0d--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-d8158a44c1f0f2c9790209ff8ab2ec08 {--}}
{{--                                                        margin-bottom: 11px;--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-d8158a44c1f0f2c9790209ff8ab2ec08 .star-rating {--}}
{{--                                                        font-size: 12px;--}}
{{--                                                        letter-spacing: 0.5px;--}}
{{--                                                        margin-left: auto;--}}
{{--                                                        margin-right: auto;--}}
{{--                                                    }--}}

{{--                                                    .page-wrapper .porto-gb-8e3470c6224b098bb08318f8978e311d {--}}
{{--                                                        margin-bottom: 0px;--}}
{{--                                                        width: 100%;--}}
{{--                                                    }--}}

{{--                                                    .porto-gb-8e3470c6224b098bb08318f8978e311d .price {--}}
{{--                                                        font-size: 1.125rem;--}}
{{--                                                        letter-spacing: -.05em;--}}
{{--                                                        text-align: center;--}}
{{--                                                    }--}}

{{--                                                    .product-type-imgzoom .porto-tb-wishlist a {--}}
{{--                                                        width: 2.375rem;--}}
{{--                                                        height: 2.375rem;--}}
{{--                                                        line-height: 2.25rem;--}}
{{--                                                    }--}}

{{--                                                    .product-type-imgzoom .porto-tb-addcart i {--}}
{{--                                                        font-size: 22px;--}}
{{--                                                    }--}}

{{--                                                    .product-type-imgzoom .star-rating {--}}
{{--                                                        width: 70px;--}}
{{--                                                    }--}}

{{--                                                    .product-type-imgzoom .price del {--}}
{{--                                                        font-weight: 400;--}}
{{--                                                    }--}}

{{--                                                    @media (max-width: 575px) {--}}
{{--                                                        .product-type-imgzoom .tb-hover-content {--}}
{{--                                                            opacity: 1 !Important;--}}
{{--                                                        }--}}
{{--                                                    }--}}

{{--                                                    /* For preview add_to_cart button */--}}
{{--                                                    [data-type="porto-tb/porto-featured-image"] [data-type="porto-tb/porto-woo-buttons"]:last-child > div {--}}
{{--                                                        width: 100%;--}}
{{--                                                    }</style>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div><!-- #product-2823 -->--}}


{{--            </main>--}}
{{--        </div>--}}


{{--    </div>--}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

            // function adjustIframeHeight() {
            //     var iframe = document.getElementById('productIFrame');
            //     var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            //     var body = iframeDocument.querySelector('body');
            //     iframe.style.height = (body.scrollHeight+10) + 'px';
            // }
            //
            // // Adjust iframe height after content is loaded
            // window.addEventListener('load', adjustIframeHeight);
            // // Also adjust iframe height when the window is resized
            // window.addEventListener('resize', adjustIframeHeight); function adjustIframeHeight() {
            //     var iframe = document.getElementById('productIFrame');
            //     var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            //     var body = iframeDocument.querySelector('body');
            //     iframe.style.height = (body.scrollHeight+10) + 'px';
            // }
            //
            // // Adjust iframe height after content is loaded
            // window.addEventListener('load', adjustIframeHeight);
            // // Also adjust iframe height when the window is resized
            // window.addEventListener('resize', adjustIframeHeight);

            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadProducts();
                    }
                });
            });
            var config = {attributes: true};
            observer.observe(document.getElementById('customerSelectedAddress'), config);
        });
    </script>
@endsection
