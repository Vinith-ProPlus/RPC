<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>RPC Construction</title>

    <meta name="keywords" content="HTML5 Template"/>
    <meta name="description" content="RPC Construction">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/')}}/{{$Company['Logo']}}">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/slider.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/demo42.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/home/assets/vendor/fontawesome-free/css/all.min.css">

    {{-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css?r={{date('YmdHis')}}"> --}}


    <style>
        @charset "UTF-8";

        button.mfp-arrow,
        button.mfp-close {
            overflow: visible;
            cursor: pointer;
            background: transparent;
            border: 0;
            -webkit-appearance: none;
            display: block;
            outline: none;
            padding: 0;
            z-index: 1046;
            box-shadow: none;
            touch-action: manipulation
        }

        button::-moz-focus-inner {
            padding: 0;
            border: 0
        }

        .mfp-fade.mfp-wrap .mfp-content {
            opacity: 0;
            -webkit-transition: all 0.15s ease-out;
            -moz-transition: all 0.15s ease-out;
            transition: all 0.15s ease-out
        }

        .mfp-fade.mfp-wrap.mfp-ready .mfp-content {
            opacity: 1
        }

        .mfp-fade.mfp-wrap.mfp-removing .mfp-content {
            opacity: 0
        }

        .bootstrap-touchspin .input-group-btn-vertical {
            position: absolute;
            right: 0;
            height: 100%;
            z-index: 11
        }

        .bootstrap-touchspin .form-control {
            text-align: center;
            margin-bottom: 0;
            height: 4.2rem;
            max-width: 46px;
            padding: 1.1rem 1rem
        }

        .bootstrap-touchspin .form-control:not(:focus) {
            border-color: #ccc
        }

        .bootstrap-touchspin .input-group-btn-vertical > .btn {
            position: absolute;
            right: 0;
            height: 2rem;
            padding: 0;
            width: 2rem;
            text-align: center;
            font-size: 1.2rem
        }

        .bootstrap-touchspin .input-group-btn-vertical > .btn:before {
            position: relative;
            margin: 0;
            width: auto;
            line-height: 1;
            width: auto;
            top: -0.1rem;
            margin-right: -0.2rem
        }

        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-up {
            border-radius: 0;
            top: 0
        }

        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-down {
            border-radius: 0;
            bottom: 0
        }

        html:not([dir=rtl]) .noUi-horizontal .noUi-origin {
            left: auto;
            right: 0
        }

        .noUi-vertical .noUi-origin {
            width: 0
        }

        .noUi-horizontal .noUi-origin {
            height: 0
        }

        .noUi-handle {
            position: absolute
        }

        .noUi-state-tap .noUi-connect,
        .noUi-state-tap .noUi-origin {
            -webkit-transition: transform 0.3s;
            transition: transform 0.3s
        }

        .noUi-state-drag * {
            cursor: inherit !important
        }

        .noUi-horizontal {
            height: 0.3rem
        }

        .noUi-horizontal .noUi-handle {
            width: 1.1rem;
            height: 1.1rem;
            left: -0.55rem;
            top: -0.3em
        }

        .noUi-vertical {
            width: 0.3rem;
            height: 150px
        }

        .noUi-vertical .noUi-handle {
            width: 1.1rem;
            height: 1.1rem;
            left: -0.4rem;
            top: -0.5rem
        }

        html:not([dir=rtl]) .noUi-horizontal .noUi-handle {
            right: -0.55rem;
            left: auto
        }

        .alert {
            display: flex;
            align-items: center;
            font-family: Poppins, sans-serif;
            margin-bottom: 2rem;
            padding: 1.6rem 1.5rem;
            border-radius: 0
        }

        .alert i {
            font-size: 1.7em;
            width: 3.9rem
        }

        .alert.icon-sm i {
            font-size: 1.1em;
            width: 2.9rem
        }

        .alert .pixel-icon {
            height: 16px;
            background-repeat: no-repeat;
            background-position: 0 0;
            margin-bottom: 1px
        }

        .alert .alert-wrapper h4 {
            letter-spacing: -0.05em;
            margin-bottom: 1.4rem
        }

        .alert .alert-wrapper p {
            line-height: 2.4rem;
            margin-bottom: 2rem
        }

        .alert .alert-wrapper ul {
            margin: 2rem 0 0 2.5rem;
            list-style: disc
        }

        .alert .alert-wrapper li {
            line-height: 2.5rem
        }

        .alert .alert-wrapper .btn {
            text-transform: none;
            font-weight: 400;
            font-size: 1.3rem;
            padding: 0.533rem 0.933rem
        }

        .alert .alert-close {
            z-index: 2;
            padding: 0.95rem 0 0.95rem 2.5rem;
            cursor: pointer;
            width: 1em;
            height: 1em;
            color: #000;
            background: transparent url(../images/elements/alert/close.svg) center/1em auto no-repeat;
            border: 0;
            border-radius: 0;
            opacity: 0.5;
            transition: opacity 0.2s;
            margin-left: auto
        }

        .alert .alert-close:hover {
            opacity: 1
        }

        .alert.alert-intro {
            font-size: 1.5rem
        }

        .alert-rounded {
            border-radius: 5px
        }

        .alert.alert-default {
            background-color: #f2f2f2;
            border-color: #eaeaea;
            color: #737373
        }

        .alert.alert-default .alert-link {
            color: #4c4c4c
        }

        .alert.alert-dark {
            background-color: #3a3f45;
            border-color: #0b0c0e;
            color: #d5d8dc
        }

        .alert.alert-dark .alert-link {
            color: #fff
        }

        .alert.alert-primary {
            background-color: #0088cc;
            border-color: #007ebd;
            color: #fff
        }

        .alert.alert-secondary {
            background-color: #e36159;
            border-color: #e1554c;
            color: #fff
        }

        .alert.alert-tertiary {
            background-color: #2baab1;
            border-color: #299fa5;
            color: #fff
        }

        .alert.alert-quaternary {
            background-color: #383f48;
            border-color: #323840;
            color: #fff
        }

        .alert.alert-sm {
            padding: 0.5rem 1rem
        }

        .alert.alert-lg {
            padding: 2rem
        }

        @keyframes maskUp {
            0% {
                transform: translate(0, 100%)
            }
            to {
                transform: translate(0, 0)
            }
        }

        @keyframes maskRight {
            0% {
                transform: translate(-100%, 0)
            }
            to {
                transform: translate(0, 0)
            }
        }

        @keyframes maskDown {
            0% {
                transform: translate(0, -100%)
            }
            to {
                transform: translate(0, 0)
            }
        }

        @keyframes maskLeft {
            0% {
                transform: translate(100%, 0)
            }
            to {
                transform: translate(0, 0)
            }
        }

        .maskUp {
            animation-name: maskUp
        }

        .maskRight {
            animation-name: maskRight
        }

        .maskDown {
            animation-name: maskDown
        }

        .maskLeft {
            animation-name: maskLeft
        }

        @keyframes fadeInUpShorter {
            0% {
                opacity: 0;
                transform: translate(0, 50px)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInUpShorter {
            animation-timing-function: ease-out;
            animation-name: fadeInUpShorter
        }

        @keyframes fadeInUpBig {
            0% {
                opacity: 0;
                transform: translate(0, 2000px)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInUpBig {
            animation-timing-function: ease-out;
            animation-name: fadeInUpBig
        }

        @keyframes fadeInLeftShorter {
            0% {
                opacity: 0;
                transform: translate(50px, 0)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInLeftShorter {
            animation-timing-function: ease-out;
            animation-name: fadeInLeftShorter
        }

        @keyframes fadeInLeftBig {
            0% {
                opacity: 0;
                transform: translate(2000px, 0)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInLeftBig {
            animation-timing-function: ease-out;
            animation-name: fadeInLeftBig
        }

        @keyframes fadeInRightShorter {
            0% {
                opacity: 0;
                transform: translate(-50px, 0)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInRightShorter {
            animation-timing-function: ease-out;
            animation-name: fadeInRightShorter
        }

        @keyframes fadeInRightBig {
            0% {
                opacity: 0;
                transform: translate(-2000px, 0)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInRightBig {
            animation-timing-function: ease-out;
            animation-name: fadeInRightBig
        }

        .fadeIn {
            animation-name: fadeIn
        }

        @keyframes fadeIn {
            0% {
                opacity: 0
            }
            to {
                opacity: 1
            }
        }

        @keyframes fadeInDownShorter {
            0% {
                opacity: 0;
                transform: translate(0, -50px)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInDownShorter {
            animation-name: fadeInDownShorter;
            animation-timing-function: ease-out
        }

        @keyframes fadeInDownBig {
            0% {
                opacity: 0;
                transform: translate(0, -2000px)
            }
            to {
                opacity: 1;
                transform: none
            }
        }

        .fadeInDownBig {
            animation-name: fadeInDownBig;
            animation-timing-function: ease-out
        }

        @keyframes flash {
            0%,
            50%,
            to {
                opacity: 1
            }
            25%,
            75% {
                opacity: 0
            }
        }

        .flash {
            animation-name: flash
        }

        @keyframes shake {
            0%,
            to {
                transform: translateX(0);
                opacity: 1
            }
            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-10px)
            }
            20%,
            40%,
            60%,
            80% {
                transform: translateX(10px)
            }
        }

        .shake {
            animation-name: shake
        }

        @keyframes tada {
            0% {
                transform: scale(1)
            }
            10%,
            20% {
                transform: scale(0.9) rotate(-3deg)
            }
            30%,
            50%,
            70%,
            90% {
                transform: scale(1.1) rotate(3deg)
            }
            40%,
            60%,
            80% {
                transform: scale(1.1) rotate(-3deg)
            }
            to {
                transform: scale(1) rotate(0);
                opacity: 1
            }
        }

        .tada {
            animation-name: tada
        }

        @keyframes pulse {
            0% {
                transform: scale(1)
            }
            50% {
                transform: scale(1.1)
            }
            to {
                transform: scale(1);
                opacity: 1
            }
        }

        .pulse {
            animation-name: pulse
        }

        @keyframes swing {
            0% {
                transform: rotate(0)
            }
            20% {
                transform: rotate(15deg)
            }
            40% {
                transform: rotate(-10deg)
            }
            60% {
                transform: rotate(5deg)
            }
            80% {
                transform: rotate(-5deg)
            }
            to {
                transform: rotate(0);
                opacity: 1
            }
        }

        .swing {
            animation-name: swing
        }

        @keyframes wobble {
            0% {
                transform: translateX(0%)
            }
            15% {
                transform: translateX(-25%) rotate(-5deg)
            }
            30% {
                transform: translateX(20%) rotate(3deg)
            }
            45% {
                transform: translateX(-15%) rotate(-3deg)
            }
            60% {
                transform: translateX(10%) rotate(2deg)
            }
            75% {
                transform: translateX(-5%) rotate(-1deg)
            }
            to {
                transform: translateX(0%);
                opacity: 1
            }
        }

        .wobble {
            animation-name: wobble
        }

        @keyframes blurIn {
            0% {
                opacity: 0;
                filter: blur(20px);
                transform: scale(1.3)
            }
            to {
                opacity: 1;
                filter: blur(0);
                transform: none
            }
        }

        .blurIn {
            animation-name: blurIn
        }

        @keyframes dotPulse {
            0% {
                opacity: 1;
                transform: scale(0.2)
            }
            to {
                opacity: 0;
                transform: scale(1)
            }
        }

        .dotPulse {
            animation-name: dotPulse;
            animation-iteration-count: infinite;
            animation-duration: 4s
        }

        @keyframes slideInUp {
            0% {
                transform: translate3d(0, 100%, 0);
                visibility: visible
            }
            to {
                transform: translateZ(0)
            }
        }

        @keyframes slideInDown {
            0% {
                transform: translate3d(0, -100%, 0);
                visibility: visible
            }
            to {
                transform: translateZ(0)
            }
        }

        @keyframes slideInLeft {
            0% {
                transform: translate3d(-100%, 0, 0);
                visibility: visible
            }
            to {
                transform: translateZ(0)
            }
        }

        @keyframes slideInRight {
            0% {
                transform: translate3d(100%, 0, 0);
                visibility: visible
            }
            to {
                transform: translateZ(0)
            }
        }

        @keyframes flipInX {
            0% {
                animation-timing-function: ease-in;
                opacity: 0;
                transform: perspective(400px) rotateX(90deg)
            }
            to {
                transform: perspective(400px)
            }
        }

        @keyframes flipInY {
            0% {
                animation-timing-function: ease-in;
                opacity: 0;
                transform: perspective(400px) rotateY(-90deg)
            }
            to {
                transform: perspective(400px)
            }
        }

        @keyframes brightIn {
            0% {
                animation-timing-function: ease-in;
                filter: brightness(0%)
            }
            to {
                filter: brightness(100%)
            }
        }

        @keyframes bounce {
            0%,
            20%,
            50%,
            80%,
            to {
                transform: translateY(0);
                opacity: 1
            }
            40% {
                transform: translateY(-30px)
            }
            60% {
                transform: translateY(-15px)
            }
        }

        .bounce {
            animation-name: bounce
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3)
            }
            50% {
                opacity: 1;
                transform: scale(1.05)
            }
            70% {
                transform: scale(0.9)
            }
            to {
                transform: scale(1)
            }
        }

        .bounceIn {
            animation-name: bounceIn
        }

        @keyframes bounceInUp {
            0% {
                opacity: 0;
                transform: translateY(2000px)
            }
            60% {
                transform: translateY(-30px)
            }
            80% {
                transform: translateY(10px)
            }
            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        .bounceInUp {
            animation-name: bounceInUp
        }

        @keyframes bounceInDown {
            0% {
                opacity: 0;
                transform: translateY(-2000px)
            }
            60% {
                transform: translateY(30px)
            }
            80% {
                transform: translateY(-10px)
            }
            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        .bounceInDown {
            animation-name: bounceInDown
        }

        @keyframes bounceInLeft {
            0% {
                opacity: 0;
                transform: translateX(-2000px)
            }
            60% {
                transform: translateX(30px)
            }
            80% {
                transform: translateX(-10px)
            }
            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        .bounceInLeft {
            animation-name: bounceInLeft
        }

        @keyframes bounceInRight {
            0% {
                opacity: 0;
                transform: translateX(2000px)
            }
            60% {
                transform: translateX(-30px)
            }
            80% {
                transform: translateX(10px)
            }
            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        .bounceInRight {
            animation-name: bounceInRight
        }

        @keyframes rotateIn {
            0% {
                transform-origin: center center;
                transform: rotate(-200deg);
                opacity: 0
            }
            to {
                transform: rotate(0);
                opacity: 1
            }
        }

        .rotateIn {
            animation-name: rotateIn
        }

        @keyframes rotateInUpLeft {
            0% {
                opacity: 0;
                transform: rotate(90deg);
                transform-origin: left bottom
            }
            to {
                opacity: 1;
                transform: rotate(0)
            }
        }

        .rotateInUpLeft {
            animation-name: rotateInUpLeft
        }

        @keyframes rotateInDownLeft {
            0% {
                opacity: 0;
                transform: rotate(-90deg);
                transform-origin: left bottom
            }
            to {
                opacity: 1;
                transform: rotate(0)
            }
        }

        .rotateInDownLeft {
            animation-name: rotateInDownLeft
        }

        @keyframes rotateInUpRight {
            0% {
                opacity: 0;
                transform: rotate(-90deg);
                transform-origin: right bottom
            }
            to {
                opacity: 1;
                transform: rotate(0)
            }
        }

        .rotateInUpRight {
            animation-name: rotateInUpRight
        }

        @keyframes rotateInDownRight {
            0% {
                opacity: 0;
                transform: rotate(90deg);
                transform-origin: right bottom
            }
            to {
                opacity: 1;
                transform: rotate(0)
            }
        }

        .rotateInDownRight {
            animation-name: rotateInDownRight
        }

        .brightIn {
            animation-name: brightIn
        }

        @keyframes customSVGLineAnimTwo {
            0% {
                stroke-dasharray: 820;
                stroke-dashoffset: 500
            }
            to {
                stroke-dasharray: 1120;
                stroke-dashoffset: 500
            }
        }

        .customSVGLineAnimTwo {
            animation-name: customSVGLineAnimTwo
        }

        .appear-animate {
            opacity: 0
        }

        .appear-animation-visible {
            opacity: 1
        }

        .banner {
            position: relative;
            font-size: 1.6rem
        }

        .banner figure {
            margin: 0
        }

        .banner img {
            width: 100%;
            object-fit: cover
        }

        .banner h1,
        .banner h2,
        .banner h3,
        .banner h4,
        .banner h5,
        .banner h6 {
            line-height: 1
        }

        .breadcrumb-nav {
            color: #000;
            border-top: 1px solid #dfdfdf;
            border-bottom: 1px solid #dfdfdf;
            margin-bottom: 3.5rem
        }

        .breadcrumb {
            margin-bottom: 0;
            padding: 1.5rem 0;
            border-radius: 0;
            background-color: transparent
        }

        .breadcrumb-item {
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.05em;
            line-height: 24px;
            text-transform: uppercase
        }

        .breadcrumb-item + .breadcrumb-item {
            padding-left: 1.3rem
        }

        .breadcrumb-item + .breadcrumb-item:before {
            color: inherit;
            padding-right: 1.1rem;
            content: "";
            font-size: 12px;
            font-family: "porto";
            vertical-align: middle;
            margin-top: -2px
        }

        .breadcrumb-item a:not(:first-child) {
            margin-left: 5px
        }

        .breadcrumb-item.active,
        .breadcrumb-item a {
            color: inherit
        }

        .owl-dots .owl-dot,
        .owl-nav .owl-next,
        .owl-nav .owl-prev {
            outline: none
        }

        a:focus {
            outline: none
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(359deg)
            }
        }

        .card-body a {
            text-decoration: underline
        }

        .card-body h4 {
            margin-bottom: 0.7rem;
            color: #666
        }

        .card-accordion.accordion-boxed p {
            padding: 1.5rem
        }

        .card-accordion.accordion-boxed i {
            margin-right: 1rem
        }

        .product-countdown-container {
            display: flex;
            position: absolute;
            padding: 1rem 0.7rem 0.9rem;
            justify-content: center;
            flex-wrap: wrap;
            left: 1rem;
            right: 1rem;
            bottom: 1rem;
            opacity: 0.7;
            letter-spacing: -0.01em;
            visibility: visible;
            text-transform: uppercase;
            font-family: Oswald, sans-serif;
            transition: opacity 0.3s ease;
            background: #0f43b0;
            z-index: 6
        }

        .product-countdown-container .product-countdown-title {
            display: inline-block;
            color: #fff;
            font-size: 11px;
            font-weight: 400;
            margin-bottom: 0;
            margin-right: 3px
        }

        .product-countdown-container .product-countdown {
            position: relative;
            left: auto;
            right: auto;
            bottom: auto;
            z-index: 6;
            line-height: 1;
            opacity: 1;
            color: #fff
        }

        .product-countdown-container .product-countdown .countdown-amount {
            display: block;
            padding-bottom: 2px;
            font-weight: 400;
            font-size: 1.3rem;
            line-height: 1;
            margin-bottom: 0;
            text-transform: uppercase
        }

        .product-default:not(.count-down):hover .product-countdown,
        .product-default:not(.count-down):hover .product-countdown-container {
            opacity: 0;
            visibility: hidden
        }

        .toolbox {
            flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            justify-content: space-between;
            -ms-flex-pack: justify;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            line-height: 1.5
        }

        .toolbox .select-custom:after {
            right: 1.5rem;
            font-size: 1.6rem;
            color: #222529
        }

        .toolbox .select-custom .form-control {
            max-width: 160px;
            padding-right: 2.5rem;
            padding-left: 0.8rem;
            font-size: 1.3rem;
            padding-top: 1px
        }

        .toolbox label {
            margin: 1px 1.1rem 0 0;
            color: #777;
            font-size: 1.3rem;
            font-weight: 400;
            font-family: "Open Sans", sans-serif
        }

        .toolbox .form-control {
            display: inline-block;
            margin-bottom: 0;
            padding: 0 0.8rem;
            color: #777
        }

        .toolbox .form-control:focus {
            color: #777
        }

        .toolbox select.form-control:not([size]):not([multiple]) {
            height: 34px
        }

        .toolbox .toolbox-show .select-custom:after {
            right: 1rem
        }

        .toolbox,
        .toolbox-item,
        .toolbox-left,
        .toolbox-right {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .toolbox-item {
            margin-bottom: 10px
        }

        .toolbox-item:not(:last-child) {
            margin-right: 10px
        }

        .toolbox-item.layout-modes {
            margin-top: -1px
        }

        .toolbox-item.toolbox-sort {
            margin-right: 1.5rem
        }

        .toolbox-item .select-custom {
            margin-bottom: 0
        }

        .toolbox-pagination {
            border-top: 1px solid #efefef;
            padding-top: 2.5rem;
            margin-bottom: 3.5rem
        }

        .pagination {
            flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            color: #706f6c;
            font-size: 1.4rem;
            font-weight: 600;
            font-family: Poppins, sans-serif
        }

        .page-item:not(:first-child) {
            margin-left: 0.5rem
        }

        .page-item.active .page-link {
            color: #706f6c;
            background-color: transparent;
            border-color: #0f43b0
        }

        .page-item.disabled {
            display: none
        }

        .page-link {
            border: 1px solid #ccc;
            padding: 0 0.5em;
            min-width: 2.2em;
            color: inherit;
            line-height: 2.1em;
            text-align: center
        }

        .page-link:focus,
        .page-link:hover {
            color: #706f6c;
            background-color: transparent;
            border-color: #0f43b0;
            box-shadow: none
        }

        .page-link i {
            font-size: 2rem
        }

        .page-link-btn,
        span.page-link {
            border: 0
        }

        .layout-btn {
            display: inline-block;
            width: 1.2em;
            color: #000;
            font-size: 16px;
            line-height: 34px;
            text-align: center
        }

        .layout-btn:not(:last-child) {
            margin-right: 4px
        }

        .layout-btn.active {
            color: #0f43b0
        }

        @media (min-width: 992px) {
            .toolbox-pagination {
                margin-bottom: 0
            }
        }

        @media (max-width: 991px) {
            aside .toolbox-item {
                display: block
            }

            aside .toolbox-item:after {
                content: normal
            }

            .toolbox:not(.toolbox-pagination) {
                padding: 10px;
                background-color: #f4f4f4;
                margin-bottom: 2rem
            }

            .toolbox:not(.toolbox-pagination) .toolbox-item {
                margin-bottom: 0
            }

            .toolbox label {
                font-size: 11px;
                font-weight: 600;
                color: #222529
            }

            .toolbox .select-custom .form-control {
                font-size: 11px;
                font-weight: 600;
                max-width: 140px;
                text-transform: uppercase;
                color: #222529
            }
        }

        @media (max-width: 767px) {
            .toolbox label {
                display: none
            }

            .toolbox .select-custom:after {
                padding: 0
            }
        }

        @media (max-width: 575px) {
            .toolbox .layout-modes {
                display: none
            }

            .toolbox .toolbox-show,
            .toolbox .toolbox-sort {
                margin-right: 0
            }

            .toolbox .select-custom .form-control {
                max-width: 132px
            }
        }

        .minipopup-area {
            position: fixed;
            right: 20px;
            bottom: 20px;
            font-size: 1.1em;
            text-align: center;
            z-index: 20002
        }

        .wishlist-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-width: 4px 0 0;
            font-weight: 600;
            line-height: 1.5;
            padding: 15px 20px;
            width: 250px;
            border-radius: 0;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.35s, visibility 0.35s;
            z-index: 100
        }

        .wishlist-popup .wishlist-popup-msg {
            font-weight: 600;
            line-height: 1.6;
            text-align: center
        }

        .wishlist-popup.active {
            opacity: 1;
            visibility: visible;
            z-index: 1071
        }

        .login-popup .mfp-content {
            margin-top: 2.1rem;
            max-width: 872px;
            background-color: #fff
        }

        .login-popup .btn-regist {
            margin-top: 3.6rem;
            font-size: 1.6rem;
            letter-spacing: -0.025em
        }

        .login-popup .form-footer-right {
            margin-bottom: 0.6rem
        }

        .login-popup .form-input {
            height: 42px
        }

        .login-popup .title {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            line-height: 1.45;
            margin-bottom: 0.9rem
        }

        .login-popup form {
            display: block
        }

        .login-popup label {
            color: #777;
            font-family: "Open Sans", sans-serif;
            font-size: 1.4rem;
            font-weight: 500;
            line-height: 1.57;
            margin-bottom: 0.6rem
        }

        .login-popup .form-footer {
            margin: 1rem 0 2.1rem
        }

        .login-popup .form-footer .custom-control {
            margin: 0 0 0 auto;
            font-size: 1.3rem;
            padding-left: 2.5rem
        }

        .login-popup .forget-password {
            color: #222529;
            font-size: 1.4rem;
            font-family: "Open Sans", sans-serif;
            font-weight: 600
        }

        .login-popup .btn-block {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.5;
            padding: 1.5rem 2.4rem;
            letter-spacing: -0.02em
        }

        .login-popup .form-control {
            padding-left: 2.5rem
        }

        .login-popup .form-control:hover {
            outline: none
        }

        .login-popup .custom-control-label {
            margin-top: 2px;
            font-size: 1.2rem
        }

        .newsletter-popup {
            position: relative;
            max-width: 740px;
            margin-right: auto;
            margin-left: auto;
            padding: 64px 40px;
            border-radius: 0;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.12)
        }

        .mfp-bg {
            background-color: #777777
        }

        button.mfp-close {
            position: absolute;
            top: 0;
            right: 0;
            overflow: visible;
            opacity: 0.65;
            cursor: pointer;
            background: transparent;
            border: 0;
            text-indent: -9999px;
            transform: rotateZ(45deg);
            color: #838383
        }

        button.mfp-close:hover {
            opacity: 1
        }

        .mfp-image-holder button.mfp-close {
            width: 41px;
            color: #fff;
            text-align: left
        }

        button.mfp-close:after {
            content: "";
            position: absolute;
            height: 17px;
            top: 12px;
            left: 20px;
            border-left: 1px solid
        }

        button.mfp-close:before {
            content: "";
            position: absolute;
            width: 17px;
            top: 20px;
            left: 12px;
            border-top: 1px solid
        }

        .newsletter-popup-content {
            max-width: 357px
        }

        .newsletter-popup-content .form-control {
            height: auto;
            padding: 7px 12px 9px 22px;
            border-radius: 3rem 0 0 3rem;
            font-size: 1.36rem;
            line-height: 2.4;
            border: none;
            background-color: #f4f4f4
        }

        .newsletter-popup-content .form-control::placeholder {
            position: relative;
            top: 2px;
            color: #999
        }

        .newsletter-popup-content .btn {
            margin-left: -1px;
            padding: 0 32px 0 25px;
            border-radius: 0 3rem 3rem 0;
            font-size: 1.28rem;
            font-family: "Open Sans", sans-serif;
            letter-spacing: 0;
            text-align: center;
            text-transform: uppercase
        }

        .logo-newsletter {
            display: inline-block;
            max-width: 111px;
            height: auto
        }

        .newsletter-popup h2 {
            margin: 24px 0 5px;
            color: #313131;
            font-size: 1.8rem;
            font-weight: 700;
            text-transform: uppercase
        }

        .newsletter-popup p {
            font-size: 1.4rem;
            line-height: 1.85;
            letter-spacing: -0.02em;
            margin-bottom: 2.4rem
        }

        .newsletter-popup form {
            margin: 0 0 2.7rem
        }

        .newsletter-popup .custom-control {
            margin: 0 0 4px 1px;
            padding-left: 2.5rem
        }

        .newsletter-subscribe {
            font-size: 1.1rem;
            text-align: left
        }

        .newsletter-subscribe .checkbox {
            margin: 1.5rem 0
        }

        .newsletter-subscribe input {
            margin-right: 0.5rem;
            vertical-align: middle
        }

        .newsletter-subscribe label {
            margin-top: 0.2rem;
            color: inherit;
            font-size: 1.2rem;
            font-weight: 400;
            font-family: "Open Sans", sans-serif;
            text-transform: none
        }

        .mfp-newsletter.mfp-removing {
            transition: opacity 0.35s ease-out;
            opacity: 0
        }

        .mfp-ready .mfp-preloader {
            display: none
        }

        .mfp-zoom-out-cur .mfp-bg {
            opacity: 0.8;
            background-color: #0b0b0b
        }

        .mfp-zoom-out-cur .mfp-counter {
            color: #fff
        }

        .mfp-zoom-out-cur .mfp-arrow-right:before {
            border-left: 0
        }

        .mfp-zoom-out-cur .mfp-arrow-left:before {
            border-right: 0
        }

        .login-popup.mfp-bg,
        .mfp-ajax-product.mfp-bg {
            opacity: 0.6;
            background-color: transparent
        }

        .mfp-ajax-product .product-single-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5)
        }

        .mfp-wrap .mfp-content {
            transition: all 0.35s ease-out;
            opacity: 0
        }

        .login-popup.mfp-wrap .mfp-content {
            max-width: 525px
        }

        .mfp-ajax-product.mfp-wrap .mfp-content {
            max-width: 931px
        }

        .mfp-wrap.mfp-ready .mfp-content {
            opacity: 1
        }

        .mfp-wrap.mfp-removing .mfp-content {
            opacity: 0
        }

        .mfp-ajax-product {
            z-index: 1058
        }

        .mfp-bg.login-popup,
        .mfp-bg.mfp-newsletter,
        .mfp-wrap.login-popup,
        .mfp-wrap.mfp-newsletter {
            z-index: 1058
        }

        @media (min-width: 768px) {
            .login-popup .col-md-6 {
                padding: 0 2rem
            }

            .login-popup .col-md-6:first-child {
                border-right: 1px solid #f5f6f6
            }
        }

        .product-intro.owl-carousel.owl-theme .owl-nav.disabled + .owl-dots {
            margin: 0
        }

        .product-intro.owl-carousel.owl-theme .owl-dots {
            top: -58px;
            position: absolute;
            right: 0
        }

        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot span {
            position: relative;
            display: block;
            width: 14px;
            height: 14px;
            border: 2px solid;
            background: none;
            margin: 5px 2px;
            border-radius: 7px;
            border-color: rgba(0, 68, 102, 0.4);
            transition: opacity 0.2s
        }

        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span {
            background: none;
            border-color: #0f43b0
        }

        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span:before,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span:before {
            display: none
        }

        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot.active span:after,
        .product-intro.owl-carousel.owl-theme .owl-dots .owl-dot:hover span:after {
            content: "";
            position: absolute;
            left: 3px;
            bottom: 3px;
            right: 3px;
            top: 3px;
            border-radius: 10px;
            background-color: #0f43b0
        }

        .product-intro.owl-carousel.owl-theme .owl-nav {
            color: #333;
            font-size: 2.4rem
        }

        .product-intro.owl-carousel.owl-theme .owl-nav .owl-next,
        .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
            opacity: 0;
            transition: opacity 0.2s, transform 0.4s;
            top: 30%;
            width: 30px
        }

        .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
            text-align: left;
            left: -30px;
            padding-right: 30px;
            transform: translateX(-10px)
        }

        .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
            text-align: right;
            right: -30px;
            padding-left: 30px;
            transform: translateX(10px)
        }

        .product-intro.owl-carousel.owl-theme:hover .owl-next,
        .product-intro.owl-carousel.owl-theme:hover .owl-prev {
            transform: translateX(0);
            opacity: 1
        }

        .product-panel {
            margin-bottom: 3.5rem
        }

        .product-panel .section-title {
            color: #313131;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            margin-bottom: 2.4rem
        }

        .product-panel .section-title h2 {
            font-weight: 700;
            font-size: 1.6rem;
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.01em;
            line-height: 22px;
            text-transform: uppercase
        }

        .tooltiptext {
            visibility: hidden;
            position: absolute;
            background-color: #333;
            color: #fff;
            font-family: "Open Sans", sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            text-align: center;
            padding: 1rem 0.7rem;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%)
        }

        figure .porto-loading-icon {
            position: absolute
        }

        .product-default {
            color: #777;
            margin-bottom: 2rem;
            transition: box-shadow 0.3s ease-in-out
        }

        .product-default a {
            color: inherit;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .product-default a:hover {
            color: #0f43b0;
            text-decoration: none
        }

        .product-default figure {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-bottom: 1.6rem
        }

        .product-default figure > a:first-child {
            width: 100%;
            height: 100%
        }

        .product-default figure img {
            transition: opacity 0.3s ease-in-out;
            height: auto;
            width: 100%
        }

        .product-default figure img:last-child {
            opacity: 0;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            left: 0
        }

        .product-default figure img:first-child {
            opacity: 1;
            position: relative
        }

        .product-default .label-group {
            position: absolute;
            top: 0.8rem;
            left: 0.8rem
        }

        .product-default .product-label {
            display: block;
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
            padding: 5px 11px;
            color: #fff;
            font-weight: 600;
            font-size: 10px;
            line-height: 1;
            border-radius: 12px
        }

        .product-default .product-label.label-hot {
            background-color: #2ba968
        }

        .product-default .product-label.label-sale {
            background-color: #da5555
        }

        .product-default .product-label.label-number {
            display: flex;
            position: relative;
            padding: 0;
            margin-left: auto;
            margin-right: auto;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 1.6rem;
            background-color: #0f43b0;
            color: #fff
        }

        .product-default .product-label.label-number span {
            margin-left: 1px
        }

        .product-default .product-details {
            display: flex;
            display: -ms-flexbox;
            padding: 0 0.8rem;
            flex-direction: column;
            -ms-flex-direction: column;
            align-items: center;
            -ms-flex-align: center;
            justify-content: center;
            -ms-flex-pack: center
        }

        .product-default .category-wrap {
            width: 100%;
            white-space: nowrap
        }

        .product-default .category-list {
            text-align: center;
            font-weight: 400;
            font-size: 1rem;
            font-family: "Open Sans", sans-serif;
            line-height: 1.7;
            opacity: 0.8;
            text-transform: uppercase;
            text-overflow: ellipsis;
            overflow: hidden
        }

        .product-default .product-title {
            max-width: 100%;
            font-weight: 400;
            font-size: 1.5rem;
            font-family: Poppins, sans-serif;
            line-height: 1.35;
            letter-spacing: 0.005em;
            margin-bottom: 0.4rem
        }

        .product-default .product-title a {
            display: block
        }

        .product-default .title-wrap .product-title {
            text-overflow: ellipsis;
            overflow: hidden;
            width: calc(100% - 20px);
            margin-bottom: 0.5rem
        }

        .product-default .title-wrap .guest-btn-icon-wish {
            margin-top: -2px
        }

        .product-default .product-action {
            position: relative;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center
        }

        .product-default .btn-add-cart,
        .product-default .guest-btn-icon-wish,
        .product-default .btn-quickview {
            border: 1px solid #f4f4f4;
            background: #f4f4f4;
            color: #6f6e6b;
            line-height: 34px
        }

        .product-default .guest-btn-icon-wish,
        .product-default .btn-quickview {
            display: inline-block;
            position: absolute;
            top: 0;
            margin: 0 2px;
            width: 36px;
            height: 36px;
            font-size: 1.6rem;
            text-align: center;
            opacity: 0;
            transition: all 0.25s ease
        }

        .product-default .guest-btn-icon-wish.checked,
        .product-default .btn-quickview.checked {
            color: #e27c7c
        }

        .product-default .guest-btn-icon-wish.checked i:before,
        .product-default .btn-quickview.checked i:before {
            content: ""
        }

        .product-default .guest-btn-icon-wish:hover,
        .product-default .btn-quickview:hover {
            color: #333
        }

        .product-default .guest-btn-icon-wish {
            left: 0
        }

        .product-default .guest-btn-icon-wish.added-wishlist i:before {
            content: "";
            color: #da5555
        }

        .product-default .btn-quickview {
            font-size: 1.4rem;
            right: 0
        }

        .product-default:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
            display: none
        }

        .product-default .btn-add-cart {
            display: inline-block;
            padding: 0 1.4rem;
            font-size: 1.2rem;
            font-weight: 600;
            font-family: Poppins, sans-serif;
            text-align: center;
            vertical-align: top;
            cursor: pointer;
            transition: all 0.25s ease
        }

        .product-default .btn-add-cart i {
            font-size: 1.5rem;
            line-height: 32px
        }

        .product-default .btn-add-cart i:before {
            margin: 0 4px 0 0;
            font-weight: 800
        }

        .product-default.product-unfold .btn-add-cart i {
            display: inline-block
        }

        .product-default.product-unfold .guest-btn-icon-wish,
        .product-default.product-unfold .btn-quickview {
            position: relative
        }

        .product-default.product-unfold:hover .product-action a.btn-quickview {
            right: 0
        }

        .product-default.product-unfold:hover .product-action a.guest-btn-icon-wish {
            left: 0
        }

        .product-default:hover {
            z-index: 1;
            box-shadow: 0 12px 20px 0 rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.3s ease-in-out;
        }

        .product-default:hover figure img:first-child {
            opacity: 0;
            transition: opacity 0.3s ease-in-out
        }

        .product-default:hover figure img:last-child {
            opacity: 1;
            transition: opacity 0.3s ease-in-out
        }

        .product-default:hover .btn-add-cart {
            background: #2b2b2d;
            border-color: #2b2b2d;
            color: #fff
        }

        .product-default:hover .btn-add-cart.product-type-simple i {
            display: inline-block
        }

        .product-default:hover .product-action a {
            opacity: 1
        }

        .product-default:hover .product-action a.guest-btn-icon-wish {
            left: -40px
        }

        .product-default:hover .product-action a.btn-quickview {
            right: -40px
        }

        .tooltip-top:after {
            content: "";
            position: absolute;
            top: 96%;
            left: 50%;
            margin-left: -6px;
            border-width: 6px;
            border-style: solid;
            border-color: #333 transparent transparent transparent
        }

        .old-price {
            text-decoration: line-through;
            font-size: 1.4rem;
            letter-spacing: 0.005em;
            color: #999;
            margin-right: 3px
        }

        .product-price {
            color: #222529;
            font-size: 1.8rem;
            line-height: 1
        }

        .price-box {
            margin-bottom: 1.4rem;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
            line-height: 1
        }

        .ratings-container {
            line-height: 1;
            margin: 0 0 12px 1px;
            cursor: pointer;
            position: relative;
            display: inline-block
        }

        .ratings-container .product-ratings,
        .ratings-container .ratings {
            position: relative;
            display: inline-block;
            font-size: 11px;
            letter-spacing: 0.1em;
            font-family: "Font Awesome 5 Free";
            font-weight: 900
        }

        .ratings-container .product-ratings {
            height: 11px
        }

        .ratings-container .product-ratings:before {
            content: "";
            color: rgba(0, 0, 0, 0.16)
        }

        .ratings-container .product-ratings:hover .tooltiptext {
            visibility: visible;
            opacity: 1
        }

        .ratings-container .ratings {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden
        }

        .ratings-container .ratings:before {
            content: "";
            color: #6a6a6d
        }

        .product-select-group {
            display: flex;
            display: -ms-flexbox
        }

        .product-select {
            margin: 0 4px 0 0;
            cursor: pointer
        }

        .product-select.type-image {
            width: 32px;
            height: 32px;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, 0.09)
        }

        .product-select.type-image.checked,
        .product-select.type-image.hover {
            border: 1px solid #0f43b0
        }

        .product-select.type-check {
            margin: 5px;
            overflow: visible;
            display: block;
            position: relative;
            width: 12px;
            height: 12px;
            border-radius: 50%
        }

        .product-select.type-check:after {
            content: "";
            background-color: transparent;
            border: 1px solid black;
            position: absolute;
            left: -3px;
            top: -3px;
            border-radius: 50%;
            width: 18px;
            display: block;
            height: 18px
        }

        .product-select.type-check.checked:before {
            font-size: 8px;
            content: "";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            -webkit-font-smoothing: antialiased;
            text-indent: 0;
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            color: #fff;
            height: 12px;
            line-height: 12px;
            margin-top: -6px;
            text-align: center
        }

        .product-nav-filter {
            display: flex;
            align-items: center
        }

        .product-nav-thumbs a,
        .product-nav-thumbs span {
            margin-right: 0.6rem;
            width: 32px;
            height: 32px;
            text-indent: -9999px;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: transparent !important;
            border: 1px solid #e9e9e9;
            transition: border-color 0.35s
        }

        .product-nav-thumbs a:hover,
        .product-nav-thumbs span:hover {
            border-color: #1d70ba
        }

        .product-nav-dots {
            padding-top: 2px
        }

        .product-nav-dots a,
        .product-nav-dots span {
            display: block;
            width: 1.6rem;
            height: 1.6rem;
            border-radius: 50%;
            border: 0.2rem solid #fff;
            margin-right: 0.6rem;
            transition: box-shadow 0.35s ease;
            box-shadow: 0 0 0 0.1rem #999
        }

        .product-nav-dots a.active,
        .product-nav-dots a:hover,
        .product-nav-dots span.active,
        .product-nav-dots span:hover {
            box-shadow: 0 0 0 0.1rem #222529
        }

        .product-single-qty {
            display: inline-block;
            max-width: 104px;
            vertical-align: middle
        }

        .product-single-qty .bootstrap-touchspin.input-group {
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            max-width: none;
            padding-right: 0
        }

        .product-single-qty .bootstrap-touchspin .form-control {
            width: 2.7em;
            height: 36px;
            padding: 10px 2px;
            color: #222529;
            font-size: 1.4rem;
            font-family: Poppins, sans-serif;
            text-align: center
        }

        .product-single-qty .bootstrap-touchspin .form-control,
        .product-single-qty .bootstrap-touchspin .form-control:not(:focus),
        .product-single-qty .btn-outline:not(:disabled):not(.disabled):active {
            border-color: #dae2e6
        }

        .product-single-qty .btn {
            width: 2.2em;
            padding: 0
        }

        .product-single-qty .btn.btn-down-icon:hover:after,
        .product-single-qty .btn.btn-down-icon:hover:before,
        .product-single-qty .btn.btn-up-icon:hover:after,
        .product-single-qty .btn.btn-up-icon:hover:before {
            background-color: #0f43b0
        }

        .product-single-qty .btn.btn-outline {
            border-color: #e7e7e7
        }

        .product-single-qty .btn.btn-down-icon:after,
        .product-single-qty .btn.btn-up-icon:after,
        .product-single-qty .btn.btn-up-icon:before {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 9px;
            height: 1px;
            margin-left: -0.55rem;
            background: #222529;
            content: ""
        }

        .product-single-qty .btn.btn-up-icon:before {
            transform: rotate(90deg)
        }

        .product-single-qty .horizontal-quantity::-webkit-inner-spin-button,
        .product-single-qty .horizontal-quantity::-webkit-outer-spin-button {
            -webkit-appearance: none
        }

        .config-swatch-list {
            margin: 1.5rem 0 0;
            padding: 0;
            font-size: 0;
            list-style: none
        }

        .config-swatch-list li a {
            position: relative;
            display: block;
            width: 2.8rem;
            height: 2.8rem;
            margin: 3px 6px 3px 0;
            box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.2)
        }

        .config-swatch-list li .color-panel {
            display: inline-block;
            width: 1.7rem;
            height: 1.7rem;
            border: 1px solid #fff;
            transition: all 0.3s;
            margin-right: 1.5rem
        }

        .config-swatch-list li span:last-child {
            cursor: pointer
        }

        .config-swatch-list li:hover span:last-child {
            color: #0f43b0
        }

        .config-swatch-list li.active a:before {
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            color: #fff;
            font-family: "porto";
            font-size: 1.1rem;
            line-height: 1;
            content: ""
        }

        .config-swatch-list a:focus .color-panel,
        .config-swatch-list a:hover .color-panel,
        .config-swatch-list li.active .color-panel {
            box-shadow: 0 0 0 0.1rem #dfdfdf
        }

        .modal#addCartModal {
            width: 340px;
            top: calc((100% - 320px) / 2);
            left: calc((100% - 320px) / 2);
            padding: 10px !important;
            overflow: hidden
        }

        .modal#addCartModal .modal-dialog {
            margin: 0
        }

        .modal#addCartModal .modal-content {
            margin: 0;
            border: none;
            box-shadow: none
        }

        .add-cart-box {
            padding: 19px 10px 20px !important;
            border-top: 4px solid #0f43b0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6)
        }

        .add-cart-box h4 {
            font-weight: 500;
            color: #0f43b0;
            margin-bottom: 1.8rem
        }

        .add-cart-box img {
            margin: 0 auto 10px;
            width: 120px
        }

        .add-cart-box .btn-actions {
            display: flex;
            display: -ms-flexbox;
            justify-content: space-around;
            -ms-flex-pack: distribute
        }

        .add-cart-box .btn-actions .btn-primary {
            width: 140px;
            padding: 8px 0;
            font: 500 16px "Open Sans", sans-serif;
            border: none;
            cursor: pointer
        }

        .add-cart-box .btn-actions .btn-primary:active,
        .add-cart-box .btn-actions .btn-primary:active:focus,
        .add-cart-box .btn-actions .btn-primary:focus {
            outline: none;
            border: none;
            box-shadow: none
        }

        .divide-line > .col-1:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-1:nth-child(12n) {
            border-right: none
        }

        .divide-line > .col-2:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-2:nth-child(6n) {
            border-right: none
        }

        .divide-line > .col-3:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-3:nth-child(4n) {
            border-right: none
        }

        .divide-line > .col-4:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-4:nth-child(3n) {
            border-right: none
        }

        .divide-line > .col-5:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-5:nth-child(2n) {
            border-right: none
        }

        .divide-line > .col-6:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-6:nth-child(2n) {
            border-right: none
        }

        .divide-line > .col-7:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-7:nth-child(1n) {
            border-right: none
        }

        .divide-line > .col-8:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-8:nth-child(1n) {
            border-right: none
        }

        .divide-line > .col-9:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-9:nth-child(1n) {
            border-right: none
        }

        .divide-line > .col-10:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-10:nth-child(1n) {
            border-right: none
        }

        .divide-line > .col-11:nth-child(n) {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            border-bottom: 1px solid rgba(0, 0, 0, 0.09)
        }

        .divide-line > .col-11:nth-child(1n) {
            border-right: none
        }

        .divide-line:not(.up-effect) .product-default .btn-quickview {
            width: calc(100% - 30px);
            margin: 0 15px
        }

        .divide-line:not(.up-effect) .product-default .product-details {
            padding: 0 1.5rem
        }

        .divide-line.up-effect {
            margin-top: -2rem
        }

        .divide-line.up-effect .product-default {
            padding-top: 5rem;
            margin: 0;
            transition: 0.3s
        }

        .divide-line.up-effect .product-default .product-action {
            transition: 0.3s;
            opacity: 0
        }

        .divide-line.up-effect .product-default:hover {
            padding-top: 1rem;
            padding-bottom: 4rem
        }

        .divide-line.up-effect .product-default:hover .product-action {
            opacity: 1
        }

        .divide-line .product-default {
            margin-bottom: 0
        }

        .divide-line .product-default:hover {
            box-shadow: 0 25px 35px -5px rgba(0, 0, 0, 0.1)
        }

        .divide-line .product-default:hover figure {
            box-shadow: none
        }

        .inner-quickview figure {
            position: relative
        }

        .inner-quickview figure .btn-quickview {
            position: absolute;
            padding: 0.8rem 1.4rem;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            color: #fff;
            background-color: #0f43b0;
            font-size: 1.3rem;
            font-weight: 400;
            letter-spacing: 0.025em;
            font-family: Poppins, sans-serif;
            text-transform: uppercase;
            visibility: hidden;
            opacity: 0;
            transform: none;
            margin: 0;
            border: none;
            line-height: 1.82;
            transition: padding-top 0.2s, padding-bottom 0.2s;
            z-index: 2
        }

        .inner-quickview figure .btn-quickview:hover {
            color: #fff;
            opacity: 1
        }

        .inner-quickview .product-details {
            align-items: flex-start;
            -ms-flex-align: start
        }

        .inner-quickview .category-wrap,
        .inner-quickview .title-wrap {
            display: flex;
            display: -ms-flexbox;
            justify-content: space-between;
            -ms-flex-pack: justify;
            align-items: center;
            -ms-flex-align: center;
            width: 100%
        }

        .inner-quickview .category-wrap .guest-btn-icon-wish,
        .inner-quickview .title-wrap .guest-btn-icon-wish {
            transform: none;
            opacity: 1;
            width: auto;
            height: auto;
            border: none;
            overflow: visible;
            font-size: 1.5rem;
            line-height: 0
        }

        .inner-quickview .category-list {
            text-align: left
        }

        .inner-quickview .category-wrap .guest-btn-icon-wish {
            font-size: 1.6rem;
            padding-top: 1px
        }

        .inner-quickview:hover .btn-quickview {
            visibility: visible;
            opacity: 0.85
        }

        .inner-icon {
            position: relative;
            margin-bottom: 1.9rem
        }

        .inner-icon:not(.product-widget) .product-details {
            padding: 0
        }

        .inner-icon .category-list {
            text-align: left;
            text-overflow: ellipsis;
            overflow: hidden;
            width: calc(100% - 20px)
        }

        .inner-icon .product-title {
            font-family: Poppins, sans-serif;
            letter-spacing: -0.01em
        }

        .inner-icon .ratings-container {
            margin-left: 0
        }

        .inner-icon .price-box {
            margin-bottom: 1.5rem;
            font-family: "Open Sans", sans-serif
        }

        .inner-icon .btn-icon-group {
            z-index: 2
        }

        .inner-icon .guest-btn-icon-wish,
        .inner-icon .btn-quickview {
            top: auto
        }

        .inner-icon .guest-btn-icon-wish {
            left: auto;
            right: 0
        }

        .inner-icon:not(.product-widget):hover {
            box-shadow: none
        }

        .inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top: 1.2rem;
            padding-bottom: 1.3rem;
            transition: padding-top 0.2s, padding-bottom 0.2s, opacity 0.2s
        }

        .inner-icon .btn-add-cart,
        .inner-icon .guest-btn-icon-wish,
        .inner-icon .btn-quickview {
            background-color: transparent
        }

        .inner-icon figure {
            position: relative
        }

        .inner-icon figure .btn-icon-group {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem
        }

        .inner-icon figure .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin: 0 0 5px;
            width: 36px;
            height: 36px;
            padding: 0;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, background-color 0.3s, color 0.3s, border-color 0.3s;
            transform: none
        }

        .inner-icon figure .btn-icon i:not(.fa):before {
            font-weight: 400
        }

        .inner-icon figure .btn-icon .fa {
            font-size: 12px;
            font-weight: 600
        }

        .inner-icon figure .btn-icon i {
            font-size: 1.6rem;
            margin-bottom: 0
        }

        .inner-icon figure .btn-icon i:before {
            margin: 0
        }

        .inner-icon figure .btn-icon i.icon-bag {
            font-size: 1.8rem
        }

        .inner-icon figure .btn-icon:hover {
            background-color: #0f43b0;
            border-color: #0f43b0;
            color: #fff
        }

        .inner-icon:hover .btn-icon {
            background-color: #fff;
            border-color: #ddd;
            color: black;
            visibility: visible;
            opacity: 1;
            overflow: hidden
        }

        .left-details .product-details {
            -ms-flex-align: start;
            align-items: flex-start
        }

        .left-details .btn-add-cart,
        .left-details .guest-btn-icon-wish,
        .left-details .btn-quickview {
            background-color: #f4f4f4;
            border-color: #f4f4f4;
            color: black
        }

        .left-details .guest-btn-icon-wish,
        .left-details .btn-quickview {
            transform: none
        }

        .left-details .btn-add-cart {
            margin-left: 0;
            padding: 0 1.5rem
        }

        .hidden-description {
            position: relative
        }

        .hidden-description:hover figure {
            box-shadow: none
        }

        .hidden-description:hover .btn-add-cart {
            background-color: #f4f4f4;
            position: absolute
        }

        .hidden-description:hover .product-details {
            opacity: 1;
            transform: translateY(0)
        }

        .hidden-description:hover .product-action a.btn-quickview {
            left: 0
        }

        .hidden-description figure {
            margin-bottom: 0
        }

        .hidden-description figure .btn-icon-group {
            top: 1rem;
            right: 1rem
        }

        .hidden-description .product-details {
            position: absolute;
            width: 100%;
            bottom: 46px;
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.09);
            opacity: 0;
            transform: translateY(5px);
            transition: all 0.3s ease
        }

        .hidden-description.product-default .product-details {
            padding: 1rem
        }

        .hidden-description .product-action {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            margin-bottom: 0
        }

        .hidden-description .btn-quickview {
            transform: none;
            background-color: #0f43b0;
            color: #fff;
            width: 50%;
            margin: 0;
            border: none;
            height: 45px;
            left: 0;
            font-size: 1.3rem;
            font-weight: 400;
            letter-spacing: 0.025em;
            font-family: Poppins, sans-serif;
            text-transform: uppercase;
            line-height: 45px
        }

        .hidden-description:hover .product-action .btn-quickview {
            opacity: 0.85
        }

        .hidden-description:hover .product-action .btn-quickview:hover {
            opacity: 1;
            color: #fff
        }

        .hidden-description .btn-add-cart {
            position: absolute;
            z-index: 3;
            justify-content: center;
            margin: 0;
            width: 50%;
            height: 45px;
            border: none;
            background: #f4f4f4;
            font-size: 1.3rem;
            font-weight: 400;
            letter-spacing: 0.025em;
            font-family: Poppins, sans-serif;
            text-transform: uppercase;
            line-height: 45px
        }

        .hidden-description .btn-add-cart:hover {
            background-color: #f46017;
            color: #fff
        }

        .full-width {
            padding-left: 10px;
            padding-right: 10px;
            margin: 0;
            display: flex;
            flex-wrap: wrap
        }

        .full-width [class*=col-] {
            padding-right: 10px;
            padding-left: 10px
        }

        .no-gaps {
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            padding-right: 0
        }

        .no-gaps [class*=col-] {
            padding-right: 0;
            padding-left: 0
        }

        .no-gaps .product-details {
            padding: 0 1rem
        }

        .no-gaps .product-default {
            margin-bottom: 0
        }

        .no-gaps .product-default:nth-child(2n) figure > a:first-child:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(33, 37, 41, 0.01)
        }

        .inner-icon-inline figure .btn-icon-group {
            display: flex;
            flex-direction: row
        }

        .inner-icon-inline figure .btn-icon {
            margin-left: 5px
        }

        .product-overlay figure {
            margin: 0
        }

        .product-overlay figure > a:first-child:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: rgba(27, 27, 23, 0);
            transition: all 0.25s
        }

        .product-overlay figure .btn-icon-group,
        .product-overlay figure .btn-quickview {
            z-index: 1
        }

        .product-overlay figure .btn-icon {
            border-color: #fff;
            border-width: 2px;
            color: #fff;
            background-color: #4d4d4a;
            opacity: 0
        }

        .product-overlay figure .guest-btn-icon-wish {
            position: relative
        }

        .product-overlay figure .btn-add-cart i {
            display: inline-block
        }

        .product-overlay .product-details {
            align-items: center;
            position: absolute;
            width: 100%;
            left: 0;
            top: 0;
            bottom: 0;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.4s
        }

        .product-overlay .product-details .product-category,
        .product-overlay .product-details .product-price,
        .product-overlay .product-details .product-title a {
            color: #fff
        }

        .product-overlay .product-details a:hover {
            color: #0f43b0
        }

        .product-overlay .product-details .ratings-container .product-ratings:before {
            color: rgba(255, 255, 255, 0.6)
        }

        .product-overlay .product-details .ratings-container .ratings:before {
            color: #fff
        }

        .product-overlay .product-details .price-box {
            margin-bottom: 0
        }

        .product-overlay .product-details .category-list {
            text-align: center;
            width: 100%
        }

        .product-overlay:hover figure,
        .product-overlay:nth-child(2n):hover figure {
            box-shadow: none
        }

        .product-overlay:hover figure > a:first-child:after,
        .product-overlay:nth-child(2n):hover figure > a:first-child:after {
            background-color: rgba(27, 27, 23, 0.6)
        }

        .product-overlay:hover figure .btn-icon,
        .product-overlay:hover figure .btn-quickview,
        .product-overlay:nth-child(2n):hover figure .btn-icon,
        .product-overlay:nth-child(2n):hover figure .btn-quickview {
            opacity: 0.85;
            visibility: visible
        }

        .product-overlay:hover figure .btn-icon:hover,
        .product-overlay:hover figure .btn-quickview:hover,
        .product-overlay:nth-child(2n):hover figure .btn-icon:hover,
        .product-overlay:nth-child(2n):hover figure .btn-quickview:hover {
            opacity: 1
        }

        .product-overlay:hover figure .btn-icon,
        .product-overlay:nth-child(2n):hover figure .btn-icon {
            border-color: #fff;
            border-width: 2px;
            color: #fff;
            background-color: #4d4d4a;
            opacity: 0.85
        }

        .product-overlay:hover .product-details,
        .product-overlay:nth-child(2n):hover .product-details {
            opacity: 1;
            transform: scale(1)
        }

        .overlay-dark figure {
            margin: 0
        }

        .overlay-dark figure > a:first-child:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: rgba(27, 27, 23, 0.3);
            transition: all 0.25s
        }

        .overlay-dark figure .btn-icon-group,
        .overlay-dark figure .btn-quickview {
            z-index: 1
        }

        .overlay-dark figure .btn-icon {
            border-color: #fff;
            border-width: 2px;
            color: #fff;
            background-color: #4d4d4a;
            opacity: 0;
            margin-left: 8px
        }

        .overlay-dark figure .btn-quickview {
            border: 2px solid #fff;
            background-color: #4d4d4a;
            border-radius: 2rem;
            padding: 1rem 2.3rem;
            width: auto;
            height: auto;
            left: 50%;
            bottom: 50%;
            transform: translate(-50%, 50%);
            opacity: 0;
            transition: all 0.1s
        }

        .overlay-dark .product-details {
            position: absolute;
            width: 100%;
            left: 2rem;
            bottom: 4rem;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s
        }

        .overlay-dark .product-details .product-category,
        .overlay-dark .product-details .product-price,
        .overlay-dark .product-details .product-title a {
            color: #fff
        }

        .overlay-dark .product-details a:hover {
            color: #0f43b0
        }

        .overlay-dark .product-details .ratings-container .product-ratings:before {
            color: rgba(255, 255, 255, 0.6)
        }

        .overlay-dark .product-details .price-box {
            margin-bottom: 0
        }

        .overlay-dark:hover figure,
        .overlay-dark:nth-child(2n):hover figure {
            box-shadow: none
        }

        .overlay-dark:hover figure > a:first-child:after,
        .overlay-dark:nth-child(2n):hover figure > a:first-child:after {
            background-color: rgba(27, 27, 23, 0.7)
        }

        .overlay-dark:hover figure .btn-icon,
        .overlay-dark:hover figure .btn-quickview,
        .overlay-dark:nth-child(2n):hover figure .btn-icon,
        .overlay-dark:nth-child(2n):hover figure .btn-quickview {
            opacity: 0.85
        }

        .overlay-dark:hover figure .btn-icon:hover,
        .overlay-dark:hover figure .btn-quickview:hover,
        .overlay-dark:nth-child(2n):hover figure .btn-icon:hover,
        .overlay-dark:nth-child(2n):hover figure .btn-quickview:hover {
            background-color: #4d4d4a;
            opacity: 1
        }

        .overlay-dark:hover figure .btn-icon,
        .overlay-dark:nth-child(2n):hover figure .btn-icon {
            border-color: #fff;
            border-width: 2px;
            color: #fff;
            background-color: #4d4d4a;
            opacity: 0.85
        }

        .overlay-dark:hover .product-details,
        .overlay-dark:nth-child(2n):hover .product-details {
            opacity: 1;
            transform: translateY(0)
        }

        .creative-grid {
            margin-left: -10px;
            margin-right: -10px
        }

        .creative-grid .product-default {
            padding: 0 10px 20px;
            margin-bottom: 0
        }

        .creative-grid .product-default .btn-add-cart i {
            display: inline-block
        }

        .creative-grid figure {
            height: 100%
        }

        .creative-grid figure img {
            height: 100%;
            object-fit: cover
        }

        .creative-grid .overlay-dark figure .btn-quickview {
            padding: 8px 15px;
            max-width: 128px;
            max-height: 41px;
            border-radius: 5rem
        }

        .creative-grid .inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top: 7px
        }

        .creative-grid .grid-height-1-2 {
            height: 300px
        }

        .creative-grid .grid-height-1 {
            height: 600px
        }

        .creative-grid .grid-col-sizer {
            width: 25%
        }

        .creative-grid .guest-btn-icon-wish {
            position: relative
        }

        .inner-btn figure .btn-icon-group {
            top: auto;
            left: auto;
            right: 1.5rem;
            bottom: 1.5rem
        }

        .inner-btn figure .btn-icon {
            position: relative;
            margin-bottom: 0
        }

        .inner-btn figure .btn-quickview {
            background-color: #fff
        }

        .inner-btn figure .btn-quickview i {
            font-size: 1.4rem
        }

        .inner-btn figure .btn-add-cart i {
            display: inline-block
        }

        .quantity-input .product-details {
            align-items: center
        }

        .quantity-input .product-single-qty {
            margin: 0 0 1rem
        }

        .quantity-input .btn-add-cart {
            margin: 0 0 1rem 2px
        }

        .quantity-input .btn-add-cart:hover {
            background-color: #0f43b0;
            border-color: #0f43b0;
            color: #fff
        }

        .quantity-input .category-list {
            text-align: center
        }

        .product-list {
            display: flex;
            display: -ms-flexbox;
            align-items: center
        }

        .product-list:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
            display: block
        }

        .product-list .product-action {
            margin-bottom: 0
        }

        .product-list:hover .btn-icon {
            padding-right: 0.8rem;
            transition: 0.35s
        }

        .product-list:hover .btn-icon i {
            opacity: 1;
            transition: 0.35s
        }

        .product-list:hover .btn-icon span {
            padding-left: 1.3rem;
            transition: 0.35s
        }

        .product-list figure {
            max-width: 250px;
            margin-right: 1.2rem;
            margin-bottom: 0
        }

        .product-list figure img {
            object-fit: cover;
            height: 100%
        }

        .product-list .product-details {
            padding-top: 3px;
            max-width: calc(100% - 270px)
        }

        .product-list .product-title {
            margin-bottom: 0.6rem;
            font-weight: 600;
            font-size: 1.8rem;
            font-family: "Open Sans", sans-serif
        }

        .product-list .ratings-container {
            margin: 0 0 10px 0px
        }

        .product-list .product-description {
            display: -webkit-box;
            margin-bottom: 1.6rem;
            max-width: 100%;
            font-weight: 400;
            font-size: 1.4rem;
            font-family: "Open Sans", sans-serif;
            line-height: 24px;
            overflow: hidden;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical
        }

        .product-list .price-box {
            margin-bottom: 1.6rem
        }

        .product-list .category-list {
            margin-bottom: -1px
        }

        .product-list .btn-add-cart {
            margin: 0 3px 5px 0;
            padding: 0 1.4rem;
            background-color: #0f43b0;
            border-color: #0f43b0;
            color: #fff
        }

        .product-list .btn-icon {
            position: relative;
            transition: 0.35s
        }

        .product-list .btn-icon i {
            position: absolute;
            display: inline-block;
            opacity: 0;
            left: 8px;
            transition: 0.35s
        }

        .product-list .btn-icon i:before {
            margin: 0;
            line-height: 1;
            font-weight: 800
        }

        .product-list .btn-icon i.fa {
            top: 26%
        }

        .product-list .btn-icon span {
            display: inline-block;
            transition: 0.35s
        }

        .product-list .guest-btn-icon-wish,
        .product-list .btn-quickview {
            position: static;
            opacity: 1;
            background-color: #f4f4f4;
            border: 1px solid #f4f4f4;
            color: #333333;
            margin: 0 0 5px;
            line-height: 32px
        }

        .product-list .guest-btn-icon-wish {
            position: relative
        }

        .product-list:hover {
            box-shadow: none
        }

        .product-list:hover figure {
            box-shadow: none
        }

        .product-list:hover .product-action a.guest-btn-icon-wish {
            left: 0
        }

        .product-widget {
            display: flex;
            display: -ms-flexbox;
            margin-bottom: 1.6rem
        }

        .product-widget figure {
            max-width: 84px;
            margin-right: 1rem;
            margin-bottom: 0
        }

        .product-widget figure img {
            object-fit: cover;
            height: 100%
        }

        .product-widget .ratings-container {
            margin-bottom: 1rem
        }

        .product-widget .product-details {
            margin-bottom: 2px;
            max-width: calc(100% - 104px)
        }

        .product-widget .product-title {
            margin-bottom: 0.5rem;
            font-size: 1.4rem
        }

        .product-widget .price-box {
            margin-bottom: 0
        }

        .product-widget .product-price {
            font-size: 1.5rem
        }

        .product-widget .old-price {
            font-size: 1.2rem
        }

        .product-widget:hover,
        .product-widget:hover figure {
            box-shadow: none
        }

        .row-joined.product-nogap .product-details {
            padding: 0 1rem
        }

        .row-joined.product-nogap .product-details .category-wrap {
            position: relative
        }

        .product-quick-view {
            padding: 3rem;
            background-color: #fff
        }

        .product-quick-view .product-single-filter label {
            margin-right: 0
        }

        .product-quick-view .product-single-details .product-title {
            width: 100%
        }

        .product-quick-view .view-cart {
            padding: 13px 10px;
            font-size: 0.8em;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: underline
        }

        .product-quick-view .product-single-details .product-single-filter:last-child {
            margin-left: -1px
        }

        .image-bg-white {
            filter: brightness(1.08)
        }

        .post-slider > .owl-stage-outer,
        .products-slider > .owl-stage-outer {
            margin: -10px -20px;
            padding: 10px 20px
        }

        @media (max-width: 1280px) {
            .post-slider > .owl-stage-outer,
            .products-slider > .owl-stage-outer {
                margin: -10px -15px;
                padding: 10px 15px
            }
        }

        .modal-backdrop.show {
            opacity: 0
        }

        @media (max-width: 1200px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left: 10px
            }

            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right: 10px
            }
        }

        @media (max-width: 1159px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left: -30px
            }

            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right: -30px
            }
        }

        @media (max-width: 1000px) {
            .product-intro.owl-carousel.owl-theme .owl-nav .owl-prev {
                left: 10px
            }

            .product-intro.owl-carousel.owl-theme .owl-nav .owl-next {
                right: 10px
            }
        }

        @media (min-width: 576px) {
            .divide-line > .col-sm-1:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-1:nth-child(12n) {
                border-right: none
            }

            .divide-line > .col-sm-2:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-2:nth-child(6n) {
                border-right: none
            }

            .divide-line > .col-sm-3:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-3:nth-child(4n) {
                border-right: none
            }

            .divide-line > .col-sm-4:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-4:nth-child(3n) {
                border-right: none
            }

            .divide-line > .col-sm-5:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-5:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-sm-6:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-6:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-sm-7:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-7:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-sm-8:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-8:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-sm-9:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-9:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-sm-10:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-10:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-sm-11:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-sm-11:nth-child(1n) {
                border-right: none
            }
        }

        @media (min-width: 768px) {
            .divide-line > .col-md-1:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-1:nth-child(12n) {
                border-right: none
            }

            .divide-line > .col-md-2:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-2:nth-child(6n) {
                border-right: none
            }

            .divide-line > .col-md-3:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-3:nth-child(4n) {
                border-right: none
            }

            .divide-line > .col-md-4:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-4:nth-child(3n) {
                border-right: none
            }

            .divide-line > .col-md-5:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-5:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-md-6:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-6:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-md-7:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-7:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-md-8:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-8:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-md-9:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-9:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-md-10:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-10:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-md-11:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-md-11:nth-child(1n) {
                border-right: none
            }

            .product-quick-view .product-single-details {
                position: absolute;
                right: 0;
                height: 100% !important;
                overflow-y: auto
            }

            .product-quick-view .product-single-details::-webkit-scrollbar {
                height: 10px;
                width: 3px
            }

            .product-quick-view .product-single-details::-webkit-scrollbar-thumb {
                background: #ebebeb;
                border-radius: 10px;
                position: absolute
            }

            .product-quick-view .product-single-details::-webkit-scrollbar-track {
                background: #fff;
                border-radius: 10px;
                margin: 8px;
                width: 100%
            }
        }

        @media (min-width: 992px) {
            .divide-line > .col-lg-1:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-1:nth-child(12n) {
                border-right: none
            }

            .divide-line > .col-lg-2:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-2:nth-child(6n) {
                border-right: none
            }

            .divide-line > .col-lg-3:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-3:nth-child(4n) {
                border-right: none
            }

            .divide-line > .col-lg-4:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-4:nth-child(3n) {
                border-right: none
            }

            .divide-line > .col-lg-5:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-5:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-lg-6:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-6:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-lg-7:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-7:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-lg-8:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-8:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-lg-9:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-9:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-lg-10:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-10:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-lg-11:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-lg-11:nth-child(1n) {
                border-right: none
            }
        }

        @media (min-width: 1200px) {
            .divide-line > .col-xl-1:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-1:nth-child(12n) {
                border-right: none
            }

            .divide-line > .col-xl-2:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-2:nth-child(6n) {
                border-right: none
            }

            .divide-line > .col-xl-3:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-3:nth-child(4n) {
                border-right: none
            }

            .divide-line > .col-xl-4:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-4:nth-child(3n) {
                border-right: none
            }

            .divide-line > .col-xl-5:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-5:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-xl-6:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-6:nth-child(2n) {
                border-right: none
            }

            .divide-line > .col-xl-7:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-7:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-xl-8:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-8:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-xl-9:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-9:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-xl-10:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-10:nth-child(1n) {
                border-right: none
            }

            .divide-line > .col-xl-11:nth-child(n) {
                border-right: 1px solid rgba(0, 0, 0, 0.09);
                border-bottom: 1px solid rgba(0, 0, 0, 0.09)
            }

            .divide-line > .col-xl-11:nth-child(1n) {
                border-right: none
            }

            .col-xl-7col .product-default .product-title,
            .col-xl-8col .product-default .product-title {
                font-size: 1.3rem
            }

            .col-xl-7col .old-price,
            .col-xl-8col .old-price {
                font-size: 1.2rem
            }

            .col-xl-7col .product-price,
            .col-xl-8col .product-price {
                font-size: 1.5rem
            }
        }

        @media (max-width: 575px) {
            .product-list {
                flex-direction: column;
                -ms-flex-direction: column
            }

            .product-list figure {
                max-width: none;
                margin-right: 0;
                margin-bottom: 2rem
            }

            .product-list .product-details {
                max-width: none;
                width: 100%
            }

            .product-list:not(.inner-icon) .btn-add-cart:not(.product-type-simple) i {
                display: block
            }

            .product-list .product-action > a {
                padding: 0;
                width: 34px;
                height: 34px
            }

            .product-list .product-action > a i {
                display: inline-block
            }

            .product-list .btn-icon {
                margin-right: 1px
            }

            .product-list .btn-icon i {
                position: static;
                opacity: 1
            }

            .product-list .btn-icon:hover {
                padding: 0
            }

            .product-list .btn-icon span {
                display: none
            }

            .product-list .btn-icon:not(.product-type-simple) i {
                margin-top: 1.1rem
            }

            .product-quick-view {
                padding: 2rem
            }

            .product-quick-view .product-single-details .product-title {
                font-size: 2.6rem
            }
        }

        @media (max-width: 479px) {
            .product-price {
                font-size: 1.3rem
            }

            .product-quick-view {
                padding: 2rem
            }
        }

        .product-category-panel {
            margin-bottom: 35px
        }

        .product-category-panel .owl-carousel {
            margin-top: -10px;
            padding-top: 10px
        }

        .product-category-panel .owl-carousel .owl-nav button.owl-next,
        .product-category-panel .owl-carousel .owl-nav button.owl-prev {
            width: 30px;
            font-size: 24px;
            color: #333;
            line-height: 22px
        }

        .product-category-panel .owl-carousel .owl-nav button.owl-prev {
            left: -41px
        }

        .product-category-panel .owl-carousel .owl-nav button.owl-next {
            right: -41px
        }

        .product-category-panel .section-title {
            padding-bottom: 1rem;
            border-bottom: 1px solid #dbdbdb;
            margin-bottom: 2.5rem
        }

        .product-category-panel .section-title h2 {
            font-weight: 700;
            font-size: 1.6rem;
            line-height: 1.2;
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.05em;
            color: #282d3b;
            text-transform: uppercase
        }

        .product-category {
            color: #1d2127;
            margin-bottom: 2rem;
            position: relative
        }

        .product-category a:hover {
            color: inherit
        }

        .product-category img {
            width: 100%
        }

        .product-category figure {
            margin-bottom: 0;
            position: relative
        }

        .product-category figure:after {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: transparent;
            transition: all 0.3s;
            z-index: 1;
            content: ""
        }

        .product-category:hover figure:after {
            background-color: rgba(27, 27, 23, 0.15)
        }

        .owl-item > .product-category {
            margin-bottom: 0
        }

        .category-content {
            padding: 2rem;
            display: flex;
            display: -ms-flex-box;
            flex-direction: column;
            -ms-flex-direction: column;
            align-items: center;
            -ms-flex-align: center
        }

        .category-content h3 {
            font-weight: 700;
            font-size: 1.5rem;
            line-height: 1.35;
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.005em;
            margin-bottom: 1rem;
            text-transform: uppercase
        }

        .category-content span {
            font-weight: 400;
            font-size: 10.2px;
            line-height: 1.8;
            font-family: "Open Sans", sans-serif;
            letter-spacing: normal;
            margin-top: -10px;
            text-transform: uppercase;
            opacity: 0.7;
            color: #1d2127
        }

        .category-content span mark {
            padding: 0;
            background-color: transparent;
            color: inherit
        }

        .content-center-bottom .category-content,
        .content-center .category-content,
        .content-left-bottom .category-content,
        .content-left-center .category-content {
            padding: 20.4px 25.5px;
            position: absolute;
            width: 100%;
            transform: translateY(-50%);
            z-index: 2
        }

        .content-center-bottom .category-content h3,
        .content-center-bottom .category-content span,
        .content-center .category-content h3,
        .content-center .category-content span,
        .content-left-bottom .category-content h3,
        .content-left-bottom .category-content span,
        .content-left-center .category-content h3,
        .content-left-center .category-content span {
            color: #fff
        }

        .content-center .category-content,
        .content-left-center .category-content {
            left: 0;
            top: 50%
        }

        .content-left-center .category-content {
            align-items: flex-start
        }

        .content-left-bottom .category-content {
            align-items: flex-start;
            left: 0;
            bottom: 0;
            transform: none
        }

        .content-center-bottom figure {
            min-height: 90px
        }

        .content-center-bottom .category-content {
            bottom: 0;
            transform: none;
            padding: 20.4px 0
        }

        .content-center-bottom .category-content h3,
        .content-center-bottom .category-content span {
            margin-bottom: 0;
            color: #1d2127
        }

        .overlay-lighter figure:after {
            background-color: rgba(27, 27, 23, 0)
        }

        .overlay-lighter:hover figure:after {
            background-color: rgba(27, 27, 23, 0.15)
        }

        .overlay-darker figure:after {
            background-color: rgba(27, 27, 23, 0.25)
        }

        .overlay-darker:hover figure:after {
            background-color: rgba(27, 27, 23, 0.4)
        }

        .overlay-light figure:after {
            background-color: rgba(27, 27, 23, 0.75)
        }

        .overlay-light:hover figure:after {
            background-color: rgba(27, 27, 23, 0.6)
        }

        .hidden-count .category-content span {
            max-height: 10px;
            transition: all 0.5s;
            transform: translateY(20%);
            opacity: 0
        }

        .hidden-count:hover .category-content span {
            max-height: 30px;
            transform: none;
            opacity: 0.7
        }

        .creative-grid .product-category {
            margin-bottom: 0;
            padding-bottom: 2rem
        }

        .creative-grid .product-category.content-left-bottom .category-content {
            margin-bottom: 20px
        }

        .creative-grid .product-category figure {
            height: 100%
        }

        .creative-grid .product-category figure img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 0
        }

        .height-600 {
            height: 600px
        }

        .height-400 {
            height: 400px
        }

        .height-300 {
            height: 300px
        }

        .height-200 {
            height: 200px
        }

        @media (min-width: 1199px) {
            .col-5col-1 {
                flex: 0 0 20%;
                max-width: 20%
            }
        }

        @media (max-width: 767px) {
            .height-600 {
                height: 400px
            }

            .height-300 {
                height: 200px
            }
        }

        @media (max-width: 450px) {
            .content-center-bottom .category-content {
                padding: 16.8px 21px;
                text-align: center;
                flex-wrap: wrap
            }
        }

        @media (max-width: 400px) {
            .content-center-bottom .category-content {
                padding-bottom: 1rem
            }
        }

        @media (max-width: 1200px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width: 15px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right: -18px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left: -18px
            }
        }

        @media (max-width: 1159px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width: 30px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right: -41px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left: -41px
            }
        }

        @media (max-width: 1024px) {
            .product-category-panel .owl-carousel .owl-nav button.owl-next,
            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                width: 15px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-next {
                right: -18px
            }

            .product-category-panel .owl-carousel .owl-nav button.owl-prev {
                left: -18px
            }
        }

        .testimonial-owner {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-content: center
        }

        .testimonial-owner figure {
            max-width: 40px;
            margin-right: 25px;
            margin-bottom: 2rem
        }

        .testimonial-owner figure.max-width-none {
            max-width: none;
            margin: 0
        }

        .testimonial-owner h4 {
            display: block;
            margin-bottom: 0.5rem;
            padding-top: 0.7rem;
            color: #111;
            font-size: 1.4rem;
            text-transform: uppercase
        }

        .testimonial-owner span {
            display: block;
            color: #666;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.045em;
            line-height: 1.2;
            font-weight: 600
        }

        .testimonial blockquote {
            position: relative;
            margin: 0 0 0 15px;
            padding: 1rem 2rem;
            color: #0f43b0
        }

        .testimonial blockquote:after,
        .testimonial blockquote:before {
            position: absolute;
            font-family: "Playfair Display";
            font-size: 5rem;
            font-weight: 900;
            line-height: 1
        }

        .testimonial blockquote:before {
            top: 0;
            left: -0.4em;
            content: "“"
        }

        .testimonial blockquote p {
            margin-bottom: 0;
            font-family: inherit;
            font-style: normal;
            font-size: 14px;
            line-height: 24px;
            color: #62615e
        }

        .testimonial.blockquote-both blockquote:after {
            display: block;
            content: "”";
            right: 0;
            bottom: -5px;
            line-height: 24px
        }

        .testimonial.owner-center > p,
        .testimonial.owner-center blockquote {
            text-align: center
        }

        .testimonial.owner-center .testimonial-title {
            text-align: center
        }

        .testimonial.owner-center .testimonial-owner {
            justify-content: center
        }

        .testimonial.owner-center .testimonial-owner span {
            text-align: center
        }

        .testimonial.owner-center .testimonial-owner figure,
        .testimonial.owner-center .testimonial-owner img {
            margin-left: auto;
            margin-right: auto
        }

        .testimonial.testimonial-border {
            border: 1px solid;
            border-top-color: #dfdfdf;
            border-bottom-color: #dfdfdf;
            border-left-color: #ececec;
            border-right-color: #ececec;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.04)
        }

        .testimonial.testimonial-border-bottom .testimonial-owner {
            border-top: 1px solid #f2f2f2
        }

        .testimonial.inner-blockquote figure {
            margin-top: 15px;
            margin-bottom: 10px
        }

        .testimonial.inner-blockquote blockquote {
            padding: 6px 20px
        }

        .testimonial.inner-blockquote .testimonial-title {
            margin-top: 28px
        }

        .testimonial .testimonial-arrow-down {
            border-left: 11px solid transparent;
            border-right: 11px solid transparent;
            border-top: 8px solid #CCC;
            height: 0;
            margin: 0 0 0 40px;
            width: 0
        }

        @media (max-width: 480px) {
            .testimonial blockquote:before {
                left: -15px
            }
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: #fff;
            background-color: #0f43b0;
            font-size: 14px;
            line-height: 3.2rem;
            text-align: center;
            text-decoration: none;
            opacity: 1
        }

        .social-icon + .social-icon {
            margin-left: 0.6rem
        }

        .social-icons .social-icon:focus,
        .social-icons .social-icon:hover {
            color: #fff;
            text-decoration: none;
            opacity: 0.85
        }

        .social-icon.social-facebook {
            background-color: #3b5a9a
        }

        .social-icon.social-twitter {
            background-color: #1aa9e1
        }

        .social-icon.social-instagram {
            background-color: #7c4a3a
        }

        .social-icon.social-linkedin {
            background-color: #0073b2
        }

        .social-icon.social-gplus {
            background-color: #dd4b39
        }

        .social-icon.social-mail {
            background-color: #dd4b39
        }

        .nav-tabs {
            margin: 0;
            border: 0;
            border-bottom: 1px solid #e7e7e7;
            padding-bottom: 2px
        }

        .nav-tabs .nav-item {
            margin-bottom: -3px
        }

        .nav-tabs .nav-item:not(:last-child) {
            margin-right: 3.5rem
        }

        .nav-tabs .nav-item .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            border-bottom-color: #0f43b0;
            color: #0f43b0
        }

        .nav-tabs .nav-link {
            padding: 1.2rem 0;
            border: 0;
            border-bottom: 2px solid transparent;
            color: #282d3b;
            font-weight: 700;
            font-size: 1.4rem;
            line-height: 1;
            font-family: Poppins, sans-serif;
            text-transform: uppercase
        }

        .nav-tabs .nav-link:hover {
            color: #0f43b0
        }

        .tabs .tab-content {
            border: 1px solid #eee;
            box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.04);
            padding: 1.5rem
        }

        .tabs .nav-tabs {
            border-bottom: 0
        }

        .tabs .nav-tabs .nav-item .nav-link.active,
        .tabs .nav-tabs .nav-item.show .nav-link {
            border-top-color: #0f43b0;
            color: #0f43b0;
            background: #fff
        }

        .tabs .nav-tabs .nav-item:not(:last-child) {
            margin-right: 0.1rem
        }

        .tabs .nav-tabs .nav-link {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-top: 3px solid #eee;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
            border-bottom: none;
            background: #f4f4f4;
            text-transform: none;
            font-weight: 400;
            line-height: 2.4rem;
            margin-bottom: -1px;
            padding: 0.8rem 1.6rem
        }

        .tabs .nav-tabs .nav-link:focus,
        .tabs .nav-tabs .nav-link:hover {
            border-top-color: #0f43b0
        }

        .tabs .tab-pane p:last-child {
            line-height: 2.4rem
        }

        .tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-top: none;
            border-bottom-color: #0f43b0
        }

        .tabs-bottom .nav-tabs .nav-item:not(:last-child) {
            margin-right: 0.1rem
        }

        .tabs-bottom .nav-tabs .nav-link {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom: 3px solid #eee;
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
            border-top: none;
            margin-top: -1px
        }

        .tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color: #0f43b0
        }

        .tabs-left {
            border-top: 1px solid #eee
        }

        .tabs-left .tab-content {
            border-top: 0
        }

        .tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left: 3px solid #0f43b0
        }

        .tabs-left .nav-tabs .nav-item:not(:last-child) {
            margin-right: 0.1rem
        }

        .tabs-left .nav-tabs .nav-link {
            border: 0;
            border-left: 3px solid #eee;
            margin-right: -1px
        }

        .tabs-left .nav-tabs .nav-link:focus,
        .tabs-left .nav-tabs .nav-link:hover {
            border-left-color: #0f43b0
        }

        .tabs-right {
            border-top: 1px solid #eee
        }

        .tabs-right .tab-content {
            border-top: 0
        }

        .tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right: 3px solid #0f43b0
        }

        .tabs-right .nav-tabs .nav-item:not(:last-child) {
            margin-right: 0
        }

        .tabs-right .nav-tabs .nav-link {
            border: 0;
            border-right: 3px solid #eee
        }

        .tabs-right .nav-tabs .nav-link:focus,
        .tabs-right .nav-tabs .nav-link:hover {
            border-right-color: #0f43b0
        }

        .nav-justified .nav-link {
            flex-basis: 0;
            flex-grow: 1;
            text-align: center
        }

        .tabs-vertical {
            display: flex
        }

        .tabs-vertical .nav-tabs {
            flex-flow: column nowrap;
            width: 27.8%;
            border: 0
        }

        .tabs-vertical .tab-content {
            flex: 1
        }

        .tabs-vertical .nav-link:last-child {
            border-bottom: 1px solid #eee !important
        }

        .tabs-secondary .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary .nav-tabs .nav-item.show .nav-link {
            border-top-color: #ff7272;
            color: #ff7272
        }

        .tabs-secondary .nav-tabs .nav-link:focus,
        .tabs-secondary .nav-tabs .nav-link:hover {
            border-top-color: #ff7272;
            color: #ff7272
        }

        .tabs-secondary.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color: #ff7272
        }

        .tabs-secondary.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color: #ff7272
        }

        .tabs-secondary.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color: #ff7272
        }

        .tabs-secondary.tabs-left .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-left .nav-tabs .nav-link:hover {
            border-left-color: #ff7272
        }

        .tabs-secondary.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-secondary.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color: #ff7272
        }

        .tabs-secondary.tabs-right .nav-tabs .nav-link:focus,
        .tabs-secondary.tabs-right .nav-tabs .nav-link:hover {
            border-right-color: #ff7272
        }

        .tabs-tertiary .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary .nav-tabs .nav-item.show .nav-link {
            border-top-color: #2baab1;
            color: #2baab1
        }

        .tabs-tertiary .nav-tabs .nav-link:focus,
        .tabs-tertiary .nav-tabs .nav-link:hover {
            border-top-color: #2baab1;
            color: #2baab1
        }

        .tabs-tertiary.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color: #2baab1
        }

        .tabs-tertiary.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color: #2baab1
        }

        .tabs-tertiary.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color: #2baab1
        }

        .tabs-tertiary.tabs-left .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-left .nav-tabs .nav-link:hover {
            border-left-color: #2baab1
        }

        .tabs-tertiary.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-tertiary.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color: #2baab1
        }

        .tabs-tertiary.tabs-right .nav-tabs .nav-link:focus,
        .tabs-tertiary.tabs-right .nav-tabs .nav-link:hover {
            border-right-color: #2baab1
        }

        .tabs-dark .nav-tabs .nav-item .nav-link.active,
        .tabs-dark .nav-tabs .nav-item.show .nav-link {
            border-top-color: #222529;
            color: #222529
        }

        .tabs-dark .nav-tabs .nav-link:focus,
        .tabs-dark .nav-tabs .nav-link:hover {
            border-top-color: #222529;
            color: #222529
        }

        .tabs-dark.tabs-bottom .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-bottom .nav-tabs .nav-item.show .nav-link {
            border-bottom-color: #222529
        }

        .tabs-dark.tabs-bottom .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-bottom .nav-tabs .nav-link:hover {
            border-bottom-color: #222529
        }

        .tabs-dark.tabs-left .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-left .nav-tabs .nav-item.show .nav-link {
            border-left-color: #222529
        }

        .tabs-dark.tabs-left .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-left .nav-tabs .nav-link:hover {
            border-left-color: #222529
        }

        .tabs-dark.tabs-right .nav-tabs .nav-item .nav-link.active,
        .tabs-dark.tabs-right .nav-tabs .nav-item.show .nav-link {
            border-right-color: #222529
        }

        .tabs-dark.tabs-right .nav-tabs .nav-link:focus,
        .tabs-dark.tabs-right .nav-tabs .nav-link:hover {
            border-right-color: #222529
        }

        .tabs-simple .tab-content {
            border: 0;
            box-shadow: none;
            padding: 3rem 0
        }

        .tabs-simple .nav-tabs .nav-item .nav-link.active,
        .tabs-simple .nav-tabs .nav-item.show .nav-link {
            border-bottom-color: #555;
            color: #777
        }

        .tabs-simple .nav-tabs .nav-item:not(:last-child) {
            margin-right: 0.1rem
        }

        .tabs-simple .nav-tabs .nav-link {
            border: 0;
            border-bottom: 3px solid #eee;
            text-transform: none;
            font-weight: 400;
            font-size: 16px;
            line-height: 2.4rem;
            margin-bottom: -1px;
            color: #777;
            background: none;
            padding: 15px 30px;
            margin-bottom: 1.5rem
        }

        .tabs-simple .nav-tabs .nav-link:focus,
        .tabs-simple .nav-tabs .nav-link:hover {
            border-bottom-color: #555
        }

        .tabs-with-icon .nav-tabs .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: none;
            margin-bottom: 1rem
        }

        .tabs-with-icon .icon-content {
            position: relative;
            height: 75px;
            width: 75px;
            line-height: 75px;
            text-align: center;
            font-size: 3rem;
            border: 1px solid #dfdfdf;
            border-radius: 50%;
            margin-bottom: 1.5rem
        }

        .tabs-with-icon .icon-content:after {
            content: "";
            border: 5px solid #f4f4f4;
            border-radius: 50%;
            display: block;
            height: 100%;
            padding: 1px;
            position: absolute;
            top: 0;
            width: 100%;
            transform: scale(1.2);
            transition: transform 0.3s
        }

        .tabs-with-icon .icon-content:hover:after {
            transform: scale(1.3)
        }

        .product-single-tabs.product-tabs-list .product-desc-content p {
            margin-bottom: 1.3rem
        }

        .product-single-tabs.product-tabs-list .product-desc-content ol,
        .product-single-tabs.product-tabs-list .product-desc-content ul {
            padding-left: 5.8rem;
            margin-bottom: 2rem
        }

        .product-single-tabs.product-tabs-list .product-desc-content li:before {
            left: 2.4rem
        }

        .product-slider-tab .tab-content {
            position: relative
        }

        .product-slider-tab .tab-content > .tab-pane {
            display: block !important;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            height: 0 !important;
            opacity: 0;
            z-index: -1;
            transition: visibility 0.3s, opacity 0.3s
        }

        .product-slider-tab .tab-content > .tab-pane:not(.active) {
            overflow: hidden;
            visibility: hidden
        }

        .product-slider-tab .tab-content > .active {
            position: relative;
            height: auto !important;
            opacity: 1;
            z-index: auto
        }

        @media (min-width: 992px) {
            .product-single-tabs.product-tabs-list {
                padding-bottom: 2px
            }

            .product-single-tabs.product-tabs-list .col-lg-2 {
                -ms-flex: 0 0 21.4%;
                flex: 0 0 21.4%;
                max-width: 21.4%
            }

            .product-single-tabs.product-tabs-list .col-lg-10 {
                -ms-flex: 0 0 78.6%;
                flex: 0 0 78.6%;
                max-width: 78.6%
            }

            .product-single-tabs.product-tabs-list .nav.nav-tabs {
                flex-direction: column;
                border: none
            }

            .product-single-tabs.product-tabs-list .nav.nav-tabs .nav-item {
                margin-right: 0;
                margin-bottom: 0.8rem;
                border-bottom: 1px solid #e7e7e7
            }

            .product-single-tabs.product-tabs-list .nav.nav-tabs .nav-link {
                display: inline-block;
                padding: 1.4rem 0 1.5rem;
                margin-bottom: -1px
            }

            .product-single-tabs.product-tabs-list .tab-pane {
                padding-top: 0.5rem
            }

            .product-single-tabs.product-tabs-list .tab-content {
                padding-left: 0.9rem
            }
        }

        @media (max-width: 479px) {
            .nav-tabs .nav-item:not(:last-child) {
                margin-right: 2.5rem
            }
        }

        .tooltip {
            font-family: "Open Sans", sans-serif;
            font-size: 1.3rem
        }

        .tooltip.show {
            opacity: 1
        }

        .tooltip .arrow {
            width: 1rem;
            height: 1rem
        }

        .bs-tooltip-auto[x-placement^=top],
        .bs-tooltip-top {
            padding: 1rem 0
        }

        .bs-tooltip-auto[x-placement^=top] .arrow:before,
        .bs-tooltip-top .arrow:before {
            margin-left: -0.5rem;
            border-width: 1rem 1rem 0;
            border-top-color: #ddd
        }

        .bs-tooltip-auto[x-placement^=right],
        .bs-tooltip-right {
            padding: 0 1rem
        }

        .bs-tooltip-auto[x-placement^=right] .arrow,
        .bs-tooltip-right .arrow {
            width: 1rem;
            height: 2rem
        }

        .bs-tooltip-auto[x-placement^=right] .arrow:before,
        .bs-tooltip-right .arrow:before {
            border-width: 1rem 1rem 1rem 0;
            border-right-color: #ddd
        }

        .bs-tooltip-auto[x-placement^=bottom],
        .bs-tooltip-bottom {
            padding: 1rem 0
        }

        .bs-tooltip-auto[x-placement^=bottom] .arrow:before,
        .bs-tooltip-bottom .arrow:before {
            margin-left: -0.5rem;
            border-width: 0 1rem 1em;
            border-bottom-color: #ddd
        }

        .bs-tooltip-auto[x-placement^=left],
        .bs-tooltip-left {
            padding: 0 1rem
        }

        .bs-tooltip-auto[x-placement^=left] .arrow,
        .bs-tooltip-left .arrow {
            width: 1rem;
            height: 1rem
        }

        .bs-tooltip-auto[x-placement^=left] .arrow:before,
        .bs-tooltip-left .arrow:before {
            border-width: 1rem 0 1rem 1rem;
            border-left-color: #ddd
        }

        .tooltip-inner {
            max-width: 270px;
            padding: 1.2rem 1.5rem;
            border: 1px solid #ddd;
            border-radius: 0.1rem;
            background-color: #f4f4f4;
            color: #777;
            text-align: left
        }

        html {
            overflow-x: hidden;
            font-size: 62.5%;
            font-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%
        }

        body {
            color: #777;
            background: #fff;
            font-size: 1.4rem;
            font-weight: 400;
            line-height: 1.4;
            letter-spacing: 0.2px;
            font-family: "Open Sans", sans-serif;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden
        }

        body:not(.loaded) > :not(.loading-overlay) {
            visibility: hidden !important;
            transition: none !important
        }

        body:not(.loaded) > :not(.loading-overlay) * {
            visibility: hidden !important;
            transition: none !important
        }

        ::-moz-selection {
            background-color: #0f43b0;
            color: #fff
        }

        ::selection {
            background-color: #0f43b0;
            color: #fff
        }

        p {
            margin-bottom: 1.5rem
        }

        ol,
        ul {
            margin: 0 0 2.25rem;
            padding: 0;
            list-style: none
        }

        b,
        strong {
            font-weight: 700
        }

        em,
        i {
            font-style: italic
        }

        hr {
            max-width: 1730px;
            margin: 5.5rem auto 5.2rem;
            border: 0;
            border-top: 1px solid #e7e7e7
        }

        sub,
        sup {
            font-size: 70%
        }

        sup {
            font-size: 50%
        }

        sub {
            bottom: -0.25em
        }

        img {
            display: block;
            max-width: 100%;
            height: auto
        }

        button:focus {
            outline: none
        }

        body.modal-open {
            padding-right: 0 !important
        }

        @keyframes rotating {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(360deg)
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(359deg)
            }
        }

        @keyframes bouncedelay {
            0%,
            80%,
            to {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            40% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @-webkit-keyframes bouncedelay {
            0%,
            80%,
            to {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            40% {
                transform: scale(1)
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transition: all 0.5s ease-in-out;
            background: #fff;
            opacity: 1;
            visibility: visible;
            z-index: 999999
        }

        .loaded > .loading-overlay {
            opacity: 0;
            visibility: hidden
        }

        .bounce-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 70px;
            margin: -9px 0 0 -35px;
            transition: all 0.2s;
            text-align: center;
            z-index: 10000
        }

        .bounce-loader .bounce1,
        .bounce-loader .bounce2,
        .bounce-loader .bounce3 {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 100%;
            background-color: #CCC;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
            -webkit-animation: 1.4s ease-in-out 0s normal both infinite bouncedelay;
            animation: 1.4s ease-in-out 0s normal both infinite bouncedelay
        }

        .bounce-loader .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s
        }

        .bounce-loader .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s
        }

        .custom-scrollbar,
        .mobile-cart > div,
        .mobile-sidebar {
            -webkit-overflow-scrolling: touch
        }

        .custom-scrollbar::-webkit-scrollbar,
        .mobile-cart > div::-webkit-scrollbar,
        .mobile-sidebar::-webkit-scrollbar {
            height: 10px;
            width: 6px
        }

        .custom-scrollbar::-webkit-scrollbar-thumb,
        .mobile-cart > div::-webkit-scrollbar-thumb,
        .mobile-sidebar::-webkit-scrollbar-thumb {
            background: #e5e5e5;
            border-radius: 10px;
            position: absolute
        }

        .custom-scrollbar::-webkit-scrollbar-track,
        .mobile-cart > div::-webkit-scrollbar-track,
        .mobile-sidebar::-webkit-scrollbar-track {
            background: #fff;
            border-radius: 10px;
            margin: 8px;
            width: 100%
        }

        .load-more-overlay.loading:after,
        .loading:not(.load-more-overlay) {
            animation: spin 650ms infinite linear;
            border: 2px solid #fff;
            border-radius: 32px;
            border-top: 2px solid rgba(0, 0, 0, 0.4) !important;
            border-right: 2px solid rgba(0, 0, 0, 0.4) !important;
            border-bottom: 2px solid rgba(0, 0, 0, 0.4) !important;
            content: "";
            display: block;
            height: 20px;
            top: 50%;
            margin-top: -10px;
            left: 50%;
            margin-left: -10px;
            right: auto;
            position: absolute;
            width: 20px;
            z-index: 3
        }

        .load-more-overlay {
            position: relative
        }

        .load-more-overlay.loading:after {
            content: ""
        }

        .load-more-overlay:before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: #fff;
            opacity: 0.8;
            z-index: 3
        }

        .popup-loading-overlay {
            position: relative
        }

        .popup-loading-overlay.porto-loading-icon:before {
            content: ""
        }

        .popup-loading-overlay:after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: #fff;
            opacity: 0.8
        }

        .col-6.fade.in {
            opacity: 1;
            transition: opacity 0.5s
        }

        .col-6.fade {
            opacity: 0;
            transition: opacity 0.5s
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(359deg)
            }
        }

        @media (max-width: 767px) {
            html {
                font-size: 9px
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
            margin-bottom: 1.8rem;
            color: #222529;
            font-weight: 700;
            line-height: 1.1;
            font-family: Poppins, sans-serif
        }

        .h1,
        h1 {
            font-size: 3.6rem;
            font-weight: 400;
            line-height: 1.223
        }

        .h2,
        h2 {
            font-size: 3rem;
            line-height: 1.5
        }

        .h3,
        h3 {
            font-size: 2.5rem;
            line-height: 1.28
        }

        .h4,
        h4 {
            font-size: 2rem;
            line-height: 1.35
        }

        .h5,
        h5 {
            font-size: 1.4rem;
            line-height: 1.429
        }

        .h6,
        h6 {
            font-size: 1.3rem;
            line-height: 1.385;
            font-weight: 600
        }

        a {
            transition: all 0.3s;
            color: #0f43b0;
            text-decoration: none
        }

        a:focus,
        a:hover {
            color: #0f43b0;
            text-decoration: none
        }

        .heading {
            margin-bottom: 3rem;
            color: #222529
        }

        .heading .title {
            margin-bottom: 1.6rem
        }

        .heading p {
            letter-spacing: -0.015em
        }

        .heading p:last-child {
            margin-bottom: 0
        }

        .light-title {
            margin-bottom: 2rem;
            font-weight: 300
        }

        .section-title {
            text-transform: uppercase;
            font-size: 1.8rem
        }

        .section-sub-title {
            font-size: 1.6rem;
            text-transform: uppercase
        }

        @media (min-width: 768px) {
            .h1,
            h1 {
                font-size: 4.5rem
            }

            .h2,
            h2 {
                font-size: 2.5rem
            }

            .heading {
                margin-bottom: 4rem
            }
        }

        @media (min-width: 992px) {
            .h1,
            h1 {
                font-size: 5rem
            }

            .h2,
            h2 {
                font-size: 3rem
            }

            .heading {
                margin-bottom: 5rem
            }
        }

        .page-wrapper {
            position: relative;
            left: 0;
            transition: all 0.25s
        }

        .main {
            flex: 1 1 auto
        }

        .row {
            margin-left: -10px;
            margin-right: -10px
        }

        [class*=col-] {
            padding-left: 10px;
            padding-right: 10px
        }

        .row-sparse {
            margin-left: -15px;
            margin-right: -15px
        }

        .row-sparse > [class*=col-] {
            padding-left: 15px;
            padding-right: 15px
        }

        .row-sm {
            margin-left: -6px;
            margin-right: -6px
        }

        .row-sm > [class*=col-] {
            padding-left: 6px;
            padding-right: 6px
        }

        .row-joined {
            margin-left: 0;
            margin-right: 0
        }

        .row-joined > [class*=col-] {
            padding-left: 0;
            padding-right: 0
        }

        .gutter-sm {
            margin-left: -10px;
            margin-right: -10px
        }

        .gutter-sm > * {
            padding-left: 10px;
            padding-right: 10px
        }

        .ajax-overlay {
            display: flex;
            display: -ms-flexbox;
            align-items: center;
            -ms-flex-align: center;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.8;
            background-color: #0b0b0b;
            z-index: 1055
        }

        @media (min-width: 1200px) {
            .col-xl-5col {
                -ms-flex: 0 0 20%;
                flex: 0 0 20%;
                max-width: 20%
            }

            .col-xl-5col-2 {
                -ms-flex: 0 0 40%;
                flex: 0 0 40%;
                max-width: 40%
            }

            .col-xl-7col {
                -ms-flex: 0 0 14.2857%;
                flex: 0 0 14.2857%;
                max-width: 14.2857%
            }

            .col-xl-8col {
                -ms-flex: 0 0 12.5%;
                flex: 0 0 12.5%;
                max-width: 12.5%
            }

            .row-xl-tight {
                margin-left: -5px;
                margin-right: -5px
            }

            .row-xl-tight > [class*=col-] {
                padding-left: 5px;
                padding-right: 5px
            }
        }

        @media (min-width: 768px) {
            .row-md-tight {
                margin-left: -5px;
                margin-right: -5px
            }

            .row-md-tight > [class*=col-] {
                padding-left: 5px;
                padding-right: 5px
            }
        }

        .cols-1 > * {
            max-width: 100%;
            flex: 0 0 100%
        }

        .cols-2 > * {
            max-width: 50%;
            flex: 0 0 50%
        }

        .cols-3 > * {
            max-width: 33.3333%;
            flex: 0 0 33.3333%
        }

        .cols-4 > * {
            max-width: 25%;
            flex: 0 0 25%
        }

        .cols-5 > * {
            max-width: 20%;
            flex: 0 0 20%
        }

        .cols-6 > * {
            max-width: 16.6667%;
            flex: 0 0 16.6667%
        }

        .cols-7 > * {
            max-width: 14.2857%;
            flex: 0 0 14.2857%
        }

        .cols-8 > * {
            max-width: 12.5%;
            flex: 0 0 12.5%
        }

        @media (min-width: 480px) {
            .cols-xs-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-xs-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-xs-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-xs-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-xs-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-xs-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-xs-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-xs-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        @media (min-width: 576px) {
            .cols-sm-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-sm-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-sm-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-sm-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-sm-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-sm-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-sm-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-sm-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        @media (min-width: 768px) {
            .cols-md-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-md-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-md-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-md-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-md-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-md-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-md-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-md-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        @media (min-width: 992px) {
            .cols-lg-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-lg-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-lg-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-lg-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-lg-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-lg-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-lg-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-lg-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        @media (min-width: 1200px) {
            .cols-xl-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-xl-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-xl-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-xl-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-xl-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-xl-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-xl-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-xl-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        @media (min-width: 1600px) {
            .cols-xxl-1 > * {
                max-width: 100%;
                flex: 0 0 100%
            }

            .cols-xxl-2 > * {
                max-width: 50%;
                flex: 0 0 50%
            }

            .cols-xxl-3 > * {
                max-width: 33.3333%;
                flex: 0 0 33.3333%
            }

            .cols-xxl-4 > * {
                max-width: 25%;
                flex: 0 0 25%
            }

            .cols-xxl-5 > * {
                max-width: 20%;
                flex: 0 0 20%
            }

            .cols-xxl-6 > * {
                max-width: 16.6667%;
                flex: 0 0 16.6667%
            }

            .cols-xxl-7 > * {
                max-width: 14.2857%;
                flex: 0 0 14.2857%
            }

            .cols-xxl-8 > * {
                max-width: 12.5%;
                flex: 0 0 12.5%
            }
        }

        .owl-carousel .owl-nav .disabled {
            opacity: 0.5;
            cursor: default
        }

        .owl-carousel .owl-dots .owl-dot span {
            width: 16px;
            height: 16px;
            border-width: 2px
        }

        .owl-carousel .owl-dots .owl-dot span:before {
            margin: 0;
            width: 8px;
            height: 8px;
            transform: translate(-50%, -50%)
        }

        .owl-carousel .owl-dots .owl-dot.active span:before,
        .owl-carousel .owl-dots .owl-dot:hover span:before {
            transform: translate(-50%, -50%)
        }

        .owl-carousel.dots-m-0 .disabled + .owl-dots {
            margin: 0
        }

        .owl-carousel.dots-mt-1 .disabled + .owl-dots {
            margin-top: 1rem
        }

        .owl-carousel.nav-big .owl-nav {
            font-size: 3.7rem
        }

        .owl-carousel.nav-big .owl-nav i {
            padding: 4px 7px
        }

        .owl-carousel.nav-large .owl-nav {
            font-size: 4.5rem
        }

        .owl-carousel.nav-large .owl-nav i {
            padding: 4px 2px
        }

        .owl-carousel.nav-image-center .owl-nav button {
            top: 35%
        }

        .owl-carousel.show-nav-hover .owl-nav {
            opacity: 0;
            transition: opacity 0.2s, color 0.2s
        }

        .owl-carousel.show-nav-hover:hover .owl-nav {
            opacity: 1
        }

        .owl-carousel .owl-nav .owl-prev {
            left: 1vw
        }

        .owl-carousel .owl-nav .owl-next {
            right: 1vw
        }

        @media (min-width: 992px) {
            .owl-carousel.nav-outer .owl-prev {
                left: -1.7vw
            }

            .owl-carousel.nav-outer .owl-next {
                right: -1.7vw
            }

            .owl-carousel.nav-outer.nav-large .owl-prev {
                left: -2.3vw
            }

            .owl-carousel.nav-outer.nav-large .owl-next {
                right: -2.3vw
            }
        }

        .owl-carousel.nav-top .owl-nav .owl-next,
        .owl-carousel.nav-top .owl-nav .owl-prev {
            top: -4px
        }

        .owl-carousel.nav-top .owl-nav .owl-prev {
            left: unset;
            right: 3rem
        }

        .owl-carousel.nav-top .owl-nav .owl-next {
            right: 0
        }

        .owl-carousel.dots-top .owl-dots {
            position: absolute;
            right: 0;
            bottom: 100%;
            margin: 0 0 3.4rem
        }

        .owl-carousel.dots-small .owl-dots span {
            width: 14px;
            height: 14px
        }

        .owl-carousel.dots-small .owl-dots span:before {
            width: 4px;
            height: 4px
        }

        .owl-carousel.dots-simple .owl-dots .owl-dot.active span:before {
            background-color: #222529
        }

        .owl-carousel.dots-simple .owl-dots .owl-dot span {
            margin: 1px 1px 2px 0px;
            border: none
        }

        .owl-carousel.dots-simple .owl-dots .owl-dot span:before {
            opacity: 1;
            visibility: visible;
            background-color: #D6D6D6
        }

        .owl-carousel.images-center img {
            width: auto;
            margin: auto
        }

        .dots-left .owl-dots {
            text-align: left
        }

        .owl-carousel-lazy {
            display: block
        }

        .owl-carousel-lazy .category-slide:first-child,
        .owl-carousel-lazy .home-slide:first-child,
        .owl-carousel-lazy .owl-item:first-child .category-slide,
        .owl-carousel-lazy .owl-item:first-child .home-slide {
            display: block
        }

        .owl-carousel-lazy:not(.owl-loaded) > :not(:first-child) {
            display: none
        }

        .category-slide,
        .home-slide {
            width: 100%
        }

        div.slide-bg {
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover
        }

        img.slide-bg {
            object-fit: cover;
            object-position: center top
        }

        .owl-carousel.dot-inside .owl-dots {
            position: absolute;
            right: 3.6rem;
            left: 3.6rem;
            bottom: 4.1rem;
            text-align: center
        }

        .owl-carousel:not(.owl-loaded) {
            flex-wrap: nowrap;
            overflow: hidden
        }

        .owl-carousel:not(.owl-loaded)[class*=cols-]:not(.gutter-no) {
            margin-left: -10px !important;
            margin-right: -10px !important;
            width: auto
        }

        .owl-carousel:not(.owl-loaded).row {
            display: flex
        }

        .noUi-target {
            background: #eee
        }

        .noUi-handle {
            background: #0f43b0
        }

        .noUi-connect {
            background: none;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.38) inset
        }

        .sticky-navbar {
            display: flex;
            position: fixed;
            left: 0;
            right: 0;
            top: 100%;
            width: 100%;
            background-color: #fff;
            border-top: 1px solid #e7e7e7;
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s;
            z-index: 997
        }

        .sticky-navbar.fixed {
            opacity: 1;
            visibility: visible;
            transform: translateY(-100%)
        }

        .mmenu-active .sticky-navbar.fixed,
        .sidebar-opened .sticky-navbar.fixed {
            left: 260px;
            transition: all 0.25s
        }

        .sticky-navbar .sticky-info {
            flex: 0 0 20%;
            max-width: 20%;
            padding: 1rem 0
        }

        .sticky-navbar .sticky-info:not(:last-child) {
            border-right: 1px solid #e7e7e7
        }

        .sticky-navbar .sticky-info a {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #222529;
            font-family: Poppins, sans-serif;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase
        }

        .sticky-navbar .sticky-info i {
            font-size: 27px;
            font-weight: 400
        }

        .sticky-navbar .sticky-info i span {
            font-style: normal;
            right: -4px;
            top: 3px
        }

        @media (min-width: 576px) {
            .sticky-navbar {
                display: none
            }
        }


        .top-notice h5 {
            color: inherit;
            font-size: inherit;
            font-weight: 500
        }

        .top-notice small {
            font-size: 0.8461em;
            letter-spacing: 0.025em;
            opacity: 0.5
        }

        .top-notice a {
            color: inherit;
            font-weight: 700
        }

        .top-notice .category {
            display: inline-block;
            padding: 0.3em 0.8em;
            background: #151719;
            font-size: 1rem
        }

        .top-notice .mfp-close {
            top: 50%;
            transform: translateY(-50%) rotateZ(45deg) translateZ(0);
            color: inherit;
            opacity: 0.7;
            z-index: 10
        }

        .top-notice .mfp-close:hover {
            opacity: 1
        }

        .dropdown-arrow .badge-circle {
            top: 3px;
            left: 19px;
            z-index: 2
        }

        .cart-dropdown a:focus,
        .cart-dropdown a:hover {
            color: inherit
        }

        .cart-dropdown .mobile-cart {
            display: block;
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            left: auto;
            width: 300px;
            margin: 0;
            transform: translate(340px);
            transition: transform 0.2s ease-in-out 0s;
            background-color: #fff;
            z-index: 1050;
            border: none;
            border-radius: 0;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.15)
        }

        .cart-opened .cart-dropdown .mobile-cart {
            transform: none
        }

        .cart-dropdown .mobile-cart .btn-close {
            position: absolute;
            left: -4.2rem;
            top: 0.7rem;
            font-size: 3.3rem;
            color: #fff;
            font-weight: 300
        }

        .cart-product-info {
            color: #696969
        }

        .cart-opened .cart-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1050
        }

        .cart-dropdown .dropdownmenu-wrapper {
            padding: 2rem;
            overflow-y: auto;
            height: 100%
        }

        .cart-dropdown .dropdownmenu-wrapper:before {
            right: 28px;
            left: auto
        }

        .cart-dropdown .dropdownmenu-wrapper:after {
            right: 29px;
            left: auto
        }

        .cart-dropdown .product {
            display: -ms-flexbox;
            display: flex;
            margin: 0 !important;
            padding: 2rem 0;
            -ms-flex-align: center;
            align-items: center;
            border-bottom: 1px solid #e6ebee;
            box-shadow: none !important;
            font-family: Poppins, sans-serif
        }

        .cart-dropdown .product-image-container {
            position: relative;
            max-width: 80px;
            width: 100%;
            margin: 0;
            margin-left: auto;
            border: 1px solid #f4f4f4
        }

        .cart-dropdown .product-image-container a:after {
            display: none
        }

        .cart-dropdown .product-title {
            padding-right: 1.5rem;
            margin-bottom: 1.1rem;
            font-size: 1.4rem;
            line-height: 19px;
            color: #222529;
            font-weight: 500
        }

        .cart-dropdown .product-title a {
            color: #222529
        }

        .cart-dropdown .product-details {
            margin-bottom: 3px;
            font-size: 1.3rem
        }

        .cart-dropdown .btn-remove {
            position: absolute;
            top: -11px;
            right: -9px;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            color: inherit;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
            text-align: center;
            line-height: 2rem;
            font-size: 1.8rem;
            font-weight: 500
        }

        .cart-dropdown .btn-remove span {
            display: block;
            margin-top: 1px
        }

        .cart-dropdown .btn-remove:focus,
        .cart-dropdown .btn-remove:hover {
            color: #0f43b0
        }

        .dropdown-cart-action .btn {
            padding: 1.3rem 2.5rem 1.4rem;
            border-radius: 0.2rem;
            color: #fff;
            height: auto;
            font-size: 1.2rem;
            font-weight: 600;
            font-family: Poppins, sans-serif;
            letter-spacing: 0.025em;
            border-color: transparent
        }

        .dropdown-cart-action .btn:last-child:hover {
            color: #fff
        }

        .dropdown-cart-action .view-cart {
            margin: 1rem 0;
            background: #e7e7e7;
            color: #222529
        }

        .dropdown-cart-action .view-cart:focus,
        .dropdown-cart-action .view-cart:hover {
            background: #f1f1f1;
            color: #222529
        }

        .compare-dropdown .dropdown-toggle {
            text-transform: uppercase
        }

        .compare-dropdown .dropdown-toggle i {
            margin-top: -0.2rem;
            margin-right: 0.2rem
        }

        .compare-dropdown .dropdown-toggle i:before {
            margin: 0
        }

        .compare-dropdown .dropdown-toggle:after {
            display: none
        }

        .compare-products {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .compare-products .product {
            position: relative;
            margin: 0;
            padding: 0.5rem 0;
            box-shadow: none !important
        }

        .compare-products .product:hover {
            box-shadow: none
        }

        .compare-products .product-title {
            margin: 0;
            color: #696969;
            font-size: 1.1rem;
            font-weight: 400;
            line-height: 1.35;
            text-transform: uppercase
        }

        .compare-products .btn-remove {
            display: -ms-flexbox;
            display: flex;
            position: absolute;
            top: 50%;
            right: 0;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 2.3rem;
            height: 2.3rem;
            margin-top: -1.2rem;
            padding: 0.5rem 0;
            color: #777;
            font-size: 1.3rem;
            line-height: 1;
            text-align: center;
            overflow: hidden
        }

        .compare-actions {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            margin-top: 2rem
        }

        .compare-actions .action-link {
            display: inline-block;
            color: #777;
            font-size: 1.1rem;
            text-transform: uppercase
        }

        .compare-actions .btn {
            min-width: 110px;
            margin-left: auto;
            padding: 0.9rem 1rem;
            border: 0;
            border-radius: 0.2rem;
            color: #fff;
            font-size: 1.2rem;
            font-weight: 400;
            letter-spacing: 0.025rem;
            text-align: center;
            text-transform: uppercase
        }

        .btn-remove {
            position: absolute;
            top: -10px;
            right: -8px;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            color: #474747;
            background-color: #fff;
            box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.4);
            text-align: center;
            line-height: 2rem
        }

        .btn-remove:focus,
        .btn-remove:hover {
            color: #0f43b0
        }

        .icon-cancel:before {
            content: "";
            font-family: "Font Awesome 5 Free";
            font-weight: 900
        }

        @media (min-width: 992px) {

            .dropdown-expanded li + li {
                margin-left: 0
            }

            .dropdown-expanded ul {
                position: static;
                display: flex;
                display: -ms-flexbox;
                padding: 0;
                border: 0;
                background-color: transparent;
                box-shadow: none;
                opacity: 1;
                visibility: visible
            }

            .dropdown-expanded ul a {
                padding: 0;
                color: inherit
            }

            .dropdown-expanded ul a:hover {
                background-color: transparent
            }
        }

        @media (max-width: 575px) {
            .compare-dropdown {
                display: none
            }
        }

        @media (max-width: 480px) {
            .cart-dropdown .dropdown-menu,
            .compare-dropdown .dropdown-menu {
                width: 262px
            }
        }

        .menu,
        .menu li,
        .menu ol,
        .menu ul {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .menu {
            font-size: 12px;
            font-weight: 600;
            line-height: 1.5
        }

        .menu:after {
            display: block;
            clear: both;
            content: ""
        }

        .menu .show > .megamenu,
        .menu .show > ul {
            opacity: 1
        }

        .menu li > a {
            display: block;
            padding: 0.8rem 1.8rem;
            transition: 0.2s ease-out;
            color: #777
        }

        .menu li.active > a,
        .menu li.show > a,
        .menu li:hover > a {
            background: #f4f4f4
        }

        .menu > li {
            float: left;
            position: relative;
            margin-right: 2.8rem
        }

        .menu > li > a {
            padding: 1rem 0;
            font-size: 13px;
            font-weight: 400;
            color: #555
        }

        .menu > li.active > a,
        .menu > li.show > a,
        .menu > li:hover > a {
            color: #0f43b0;
            background: transparent
        }

        .menu > li > .sf-with-ul:before {
            content: "";
            position: absolute;
            z-index: 1000;
            left: 50%;
            bottom: 0;
            margin-left: -14px;
            border: 10px solid;
            border-color: transparent transparent #fff;
            opacity: 0
        }

        .menu > li.show > .sf-with-ul:before {
            opacity: 1;
            visibility: visible
        }

        .menu .megamenu {
            display: none;
            position: absolute;
            z-index: 999;
            background-color: #fff;
            box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.15);
            border: 1px solid #eee;
            border-top: 3px solid #0f43b0;
            left: 15px;
            padding: 10px 20px;
            width: 580px
        }

        .menu .megamenu.megamenu-3cols {
            width: 600px
        }

        .menu .megamenu .row > div {
            padding-top: 1.5rem
        }

        .menu .megamenu img {
            width: 300px;
            height: 100%;
            object-fit: cover
        }

        .menu .megamenu .submenu {
            margin: 0;
            padding-top: 0;
            border-top: none;
            display: block;
            position: static;
            box-shadow: none;
            min-width: 0
        }

        .menu .megamenu .submenu a {
            padding: 7px 8px 8px 0;
            font-family: "Open Sans", sans-serif;
            font-size: 12px
        }

        .menu .megamenu .submenu li:hover a {
            text-decoration: underline;
            background: transparent
        }

        .menu .nolink {
            cursor: default;
            display: inline-block;
            padding-bottom: 11px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
            font-size: 12px;
            color: #333
        }

        .menu ul {
            display: none;
            position: absolute;
            min-width: 200px;
            padding: 5px 0;
            border-top: 3px solid #0f43b0;
            top: 100%;
            left: 0;
            z-index: 101;
            background-color: #fff;
            box-shadow: 0 29px 29px rgba(0, 0, 0, 0.1)
        }

        .menu ul.custom-scrollbar {
            max-height: 80vh;
            overflow-y: auto
        }

        .menu ul a {
            font-family: "Open Sans", sans-serif;
            font-size: 12px
        }

        .menu ul ul {
            top: -5px;
            left: 100%
        }

        .menu ul li {
            position: relative
        }

        .menu ul li:hover ul {
            display: block
        }

        .menu.sf-arrows .sf-with-ul + ul > li {
            position: relative
        }

        .menu.sf-arrows .sf-with-ul:after {
            position: absolute;
            right: 1rem;
            content: "";
            font-family: "porto"
        }

        .menu.sf-arrows > li > .sf-with-ul:after {
            content: "";
            position: static;
            margin-left: 5px;
            font-weight: 400
        }

        .main-nav .menu {
            text-transform: uppercase;
            font-size: 1.4rem;
            font-family: "Open Sans", sans-serif
        }

        .main-nav .menu > li {
            margin-right: 3rem
        }

        .main-nav .menu > li > a {
            font-size: 1.3rem;
            font-weight: 700;
            padding: 20px 0 21px;
            letter-spacing: 0;
            color: #222529;
            letter-spacing: 0
        }

.main-nav .menu > li.active > a,
        .main-nav .menu > li.show > a,
        .main-nav .menu > li:hover > a {
            color: #0f43b0
        }

        .main-nav .menu > li:first-child > a {
            padding-left: 0
        }

        .main-nav .menu > li:not(.float-right) + li.float-right,
        .main-nav .menu > li:not(.float-right):last-child {
            margin-right: 0
        }

        .main-nav .menu.sf-arrows ul {
            border-top: none
        }

        .main-nav .menu > li > ul {
            left: -15px
        }

        .main-nav .menu .megamenu {
            top: 100%;
            left: -15px;
            border-top: none
        }

        .main-nav .menu .megamenu img {
            height: 100%;
            object-fit: cover
        }

        .tip {
            display: inline-block;
            position: relative;
            margin: -2px 0 0 1rem;
            padding: 3px 4px;
            border-radius: 2px;
            color: #fff;
            font-family: "Open Sans", sans-serif;
            font-size: 1rem;
            line-height: 1;
            text-transform: uppercase;
            vertical-align: middle;
            z-index: 1
        }

        .tip:before {
            position: absolute;
            top: 50%;
            right: 100%;
            left: auto;
            margin-top: -3px;
            border: 3px solid transparent;
            border-width: 3px 2px 0 2px;
            content: ""
        }

        .tip-new {
            background-color: #0fc567
        }

        .tip-new:not(.tip-top):before {
            border-right-color: #0fc567
        }

        .tip-new.tip-top:before {
            border-top-color: #0fc567
        }

        .tip-hot {
            background-color: #eb2771
        }

        .tip-hot:not(.tip-top):before {
            border-right-color: #eb2771
        }

        .tip-hot.tip-top:before {
            border-right-color: #eb2771
        }

        .tip-top {
            position: absolute;
            top: 0;
            left: 50%;
            margin-top: 6px;
            margin-left: -2px;
            transform: translate(-50%)
        }

        .tip-top:before {
            top: 100%;
            right: 70%;
            margin: 0
        }

        .menu-banner {
            height: 100%
        }

        .menu-banner figure {
            margin-bottom: 0;
            height: 100%
        }

        .menu-banner .banner-content {
            position: absolute;
            top: 50%;
            left: 2rem;
            transform: translateY(-50%)
        }

        .menu-banner h4 {
            font-size: 2.7rem;
            font-weight: 600;
            line-height: 1;
            color: #485156;
            margin-bottom: 3.5rem
        }

        .menu-banner h4 span {
            font-size: 3.1rem;
            font-weight: 700
        }

        .menu-banner h4 b {
            font-size: 3.2rem;
            color: #f4762a;
            font-family: Oswald, sans-serif
        }

        .menu-banner h4 i {
            position: absolute;
            top: 33.5%;
            font-family: Oswald, sans-serif;
            font-size: 1.8rem;
            font-style: normal;
            transform: translateY(-50%) rotate(-90deg)
        }

        .menu-banner .btn {
            font-family: Oswald, sans-serif;
            border-radius: 1px;
            font-weight: 300;
            color: #fff
        }

        .menu-banner.menu-banner-2 {
            max-height: 317px
        }

        .menu-banner.menu-banner-2 figure img {
            object-position: center 80%
        }

        .menu-banner.menu-banner-2 .banner-content {
            top: 10px;
            left: auto;
            right: 10px;
            transform: none
        }

        .menu-banner.menu-banner-2 .banner-content b {
            color: #0f43b0
        }

        .menu-banner.menu-banner-2 i {
            position: absolute;
            font-style: normal;
            font-size: 108px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.02em;
            color: #fff;
            top: 58px;
            left: -58px;
            transform: rotate(-90deg)
        }

        .menu-banner.menu-banner-2 .btn {
            position: absolute;
            bottom: 10px;
            padding: 8px 32px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
            font-weight: 300
        }

        .mobile-menu-container {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            max-width: 260px;
            background-color: #1d1e20;
            font-size: 1.2rem;
            line-height: 1.5;
            z-index: 1051;
            transform: translateX(-100%);
            transition: transform 0.25s;
            overflow-y: auto
        }

        .mmenu-active .mobile-menu-container {
            transform: translateX(0)
        }

        .mobile-menu-container .social-icons {
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            margin-bottom: 0
        }

        .mobile-menu-container .social-icon + .social-icon {
            margin-left: 1.2rem
        }

        .mobile-menu-container .search-wrapper {
            display: flex;
            position: relative;
            align-items: center;
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .mobile-menu-container .search-wrapper .form-control {
            background: #282e36;
            border: 0;
            line-height: 22px;
            padding: 8px 12px;
            height: 38px
        }

        .mobile-menu-container .search-wrapper .btn {
            position: absolute;
            right: 28px
        }

        .mobile-menu-wrapper {
            position: relative;
            padding: 4.7rem 0 3rem
        }

        .mobile-menu-close {
            position: absolute;
            top: 1.2rem;
            right: 2.1rem;
            padding: 0.4rem;
            color: #fff;
            line-height: 1;
            cursor: pointer;
            z-index: 9;
            font-size: 1.3rem
        }

        .mobile-menu-overlay {
            display: block;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transition: all 0.25s;
            background: #000;
            opacity: 0;
            visibility: hidden;
            z-index: 1050
        }

        .mmenu-active .mobile-menu-overlay {
            opacity: 0.35;
            visibility: visible
        }

        .mmenu-active .sidebar-product {
            display: none
        }

        .mmenu-active .mobile-sidebar {
            display: none
        }

        .mobile-nav {
            margin: 0 0 2rem;
            padding: 0
        }

        .mobile-menu {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .mobile-menu li ul {
            display: none
        }

        .mobile-menu > li > a {
            text-transform: uppercase
        }

        .mobile-menu li {
            display: block;
            position: relative
        }

        .mobile-menu li:not(:last-child) {
            border-bottom: 1px solid #242527
        }

        .mobile-menu li a {
            display: block;
            position: relative;
            margin-left: 1.1rem;
            margin-right: 1.1rem;
            padding: 1rem 0 1.1rem 0.7rem;
            color: #fff;
            font-size: 1.3rem
        }

        .mobile-menu li a:focus,
        .mobile-menu li a:hover {
            color: #fff;
            text-decoration: none
        }

        .mobile-menu li.active > a,
        .mobile-menu li.open > a {
            color: #fff;
            background-color: #282e36
        }

        .mobile-menu li > div {
            padding-left: 1rem
        }

        .mobile-menu li ul {
            margin: 0;
            padding: 0
        }

        .mobile-menu li ul li a {
            padding-left: 2.5rem
        }

        .mobile-menu li ul ul li a {
            padding-left: 3.5rem
        }

        .mmenu-btn {
            display: block;
            position: absolute;
            top: 46%;
            right: 0.5rem;
            width: 3rem;
            height: 3rem;
            margin-top: -1.5rem;
            text-align: center;
            border-radius: 0;
            outline: none;
            font-weight: bold;
            background-color: transparent;
            color: #fff;
            font-size: 1.7rem;
            line-height: 3rem;
            cursor: pointer
        }

        .open > .mmenu-btn:after {
            content: ""
        }

        .mmenu-btn:after {
            display: inline-block;
            margin-top: -2px;
            font-family: "porto";
            content: ""
        }

        .open > a > .mmenu-btn:after {
            content: ""
        }

        .side-menu-wrapper {
            border: 1px solid #e7e7e7
        }

        .side-menu-title {
            padding: 1.5rem 2rem;
            margin-bottom: 0;
            background: #f6f7f9;
            font-size: 1.4rem;
            text-transform: uppercase
        }

        .side-menu li {
            position: relative
        }

        .side-menu li > a {
            display: block;
            border-bottom: 1px solid #e7e7e7;
            padding: 1.2rem 0;
            color: #555;
            font-weight: 600
        }

        .side-menu li i {
            margin-right: 1.2rem;
            font-size: 20px;
            line-height: 1;
            vertical-align: middle
        }

        .side-menu ul {
            display: none;
            padding-left: 1.0714em
        }

        .side-menu:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            margin-top: -1px;
            background: #fff
        }

        .side-menu-toggle {
            position: absolute;
            top: 1rem;
            right: 0;
            width: 24px;
            color: #222529;
            text-align: center;
            line-height: 24px;
            cursor: pointer
        }

        .side-menu-toggle:before {
            content: "";
            font-family: "porto";
            font-weight: 600
        }

        .show > .side-menu-toggle:before {
            content: ""
        }

        .menu-vertical .megamenu,
        .menu-vertical ul {
            top: 0;
            left: 100%;
            margin-left: -1px;
            border-top: 0
        }

        .menu-vertical.sf-arrows > li > .sf-with-ul:before {
            top: 50%;
            bottom: auto;
            left: calc(95% - 12px);
            margin: -10px 0 0;
            border-width: 10px 12px 10px 0;
            border-color: transparent;
            border-right-color: #fff;
            transition: 0.2s
        }

        .menu-vertical.sf-arrows > li > .sf-with-ul:after {
            content: "";
            position: absolute;
            right: 2.8rem;
            color: #838b90;
            font-size: 1.5rem
        }

        .menu-vertical.sf-arrows > li.show > .sf-with-ul:before {
            left: calc(100% - 12px)
        }

        .menu-vertical.sf-arrows > li.show > .sf-with-ul:after {
            color: inherit
        }

        .menu-vertical.sf-arrows > li:hover > .sf-with-ul:after {
            color: inherit
        }

        .menu-vertical .nolink {
            font-size: 1.3rem;
            font-weight: 700
        }

        .menu-vertical > li {
            float: none;
            margin: 0;
            padding: 0 1.8rem 0 1.6rem
        }

        .menu-vertical > li:not(:first-child) {
            border-top: 1px solid #fff
        }

        .menu-vertical > li:not(:first-child) > a {
            margin-top: -1px;
            border-top: 1px solid #e7e7e7
        }

        .menu-vertical > li > a {
            display: block;
            padding: 1.2rem 1rem 1.4rem 0.5rem;
            font-size: 1.4rem;
            font-weight: 600;
            text-transform: capitalize;
            transition: none
        }

        .menu-vertical > li i {
            position: relative;
            margin-right: 8px;
            top: 1px
        }

        .menu-vertical > li.active,
        .menu-vertical > li.show,
        .menu-vertical > li:hover {
            background: #0f43b0
        }

        .menu-vertical > li.active > a,
        .menu-vertical > li.show > a,
        .menu-vertical > li:hover > a {
            border-bottom-color: transparent;
            color: #fff
        }

        .menu-vertical > li.active + li > a,
        .menu-vertical > li.show + li > a,
        .menu-vertical > li:hover + li > a {
            border-top-color: transparent
        }

        .menu-custom-block {
            display: flex;
            justify-content: flex-end;
            padding-top: 1rem;
            padding-bottom: 0.9rem
        }

        .menu-custom-block a {
            display: block;
            position: relative;
            padding: 0 15px;
            text-transform: uppercase;
            font-family: Poppins, sans-serif;
            font-size: 12px;
            font-weight: 700;
            line-height: 32px
        }

        .menu-custom-block a:not(:hover) {
            color: #465157
        }

        .menu-custom-block a:last-child {
            padding-right: 0
        }

        .menu-item-sale {
            text-align: center
        }

        .menu-item-sale a {
            display: inline-block;
            margin: 7px 0px 20px;
            padding: 1.6rem 4rem;
            background-color: #f4f4f4;
            color: #ff7272;
            font-size: 1.4rem;
            font-weight: 700
        }

        .toggle-menu-wrap .side-nav {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0
        }

        .side-menu-wrapper {
            position: relative
        }

        .side-menu-title.cursor-pointer {
            cursor: pointer
        }

        .side-menu-title.cursor-pointer + .side-nav {
            display: none;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 5px 4px 4px
        }

        @media (max-width: 1199px) {
            .menu-item-sale a {
                padding-left: 1.2rem;
                padding-right: 1.2rem
            }
        }

        @media (max-width: 575px) {
            .menu-custom-block {
                display: none
            }
        }

        footer {
            font-size: 1.3rem;
            line-height: 23px
        }

        footer p {
            color: inherit
        }

        .footer a {
            color: #777
        }

        footer a:focus,
        footer a:hover {
            color: #222529
        }

        .footer-top {
            background: #0f43b0;
            padding-top: 2rem;
            padding-bottom: 2rem
        }

        .footer-middle {
            padding-top: 4.8rem;
            padding-bottom: 1.4rem
        }

        .footer-bottom {
            border-top: 1px solid #e1e1e1;
            padding-bottom: 2.4rem;
            padding-top: 2.6rem
        }

        footer .social-icon {
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            color: #222529;
            font-size: 1.4rem;
            line-height: 3rem
        }

        footer .social-icon:not(:hover):not(:active):not(:focus) {
            background: transparent
        }

        footer .social-icon + .social-icon {
            margin-left: 0
        }

        footer .payment-icons {
            margin-right: 2px
        }

        footer .payment-icons .payment-icon {
            display: inline-block;
            vertical-align: middle;
            margin: 1px;
            width: 56px;
            height: 32px;
            background-color: #d6d3cc;
            background-size: 80% auto;
            background-repeat: no-repeat;
            background-position: center;
            transition: opacity 0.25s;
            filter: invert(1);
            border-radius: 4px
        }

        footer .payment-icons .payment-icon:hover {
            opacity: 0.7
        }

        footer .payment-icons .payment-icon.paypal {
            background-size: 85% auto;
            background-position: 50% 48%
        }

        footer .payment-icons .payment-icon.stripe {
            background-size: 60% auto
        }

        footer .widget {
            margin-bottom: 3rem
        }

        footer .widget-title {
            color: #2b2b2d;
            font-size: 1.6rem;
            font-family: "Open Sans", sans-serif;
            text-transform: none;
            margin: 0 0 1.5rem
        }

        footer .tagcloud a {
            padding: 0.6em;
            margin: 0 0.8rem 0.8rem 0;
            border: 1px solid #313438;
            color: inherit;
            font-size: 11px;
            background: transparent
        }

        footer .tagcloud a:hover {
            border-color: #fff;
            background: transparent
        }

        footer .contact-info {
            margin: 0;
            padding: 0
        }

        footer .contact-info li {
            position: relative;
            margin-bottom: 1rem;
            line-height: 1.4
        }

        footer .contact-info-label {
            display: block;
            color: #2b2b2d;
            font-weight: 400;
            text-transform: uppercase;
            margin-bottom: 1px
        }

        .footer-ribbon {
            position: absolute;
            top: 0;
            margin: -16px 0 0;
            padding: 10px 20px 6px;
            color: #fff;
            font-size: 1.6em;
            z-index: 101;
            background-color: #0088cc;
            font-family: "Shadows Into Light", sans-serif;
            font-weight: 400
        }

        .footer-ribbon:before {
            content: "";
            display: block;
            height: 0;
            position: absolute;
            top: 0;
            width: 7px;
            right: 100%;
            border-right: 10px solid #005580;
            border-top: 16px solid transparent
        }

        #scroll-top {
            height: 40px;
            position: fixed;
            right: 15px;
            width: 40px;
            z-index: 9999;
            bottom: 0;
            color: #fff;
            background-color: #43494e;
            font-size: 16px;
            text-align: center;
            line-height: 1;
            padding: 11px 0;
            visibility: hidden;
            opacity: 0;
            border-radius: 0 0 0 0;
            transition: all 0.3s, margin-right 0s;
            transform: translateY(40px)
        }

        #scroll-top > i {
            position: absolute;
            height: 24px;
            line-height: 24px;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto
        }

        #scroll-top > i:before {
            font-weight: 700;
            font-size: 2rem
        }

        #scroll-top:focus,
        #scroll-top:hover {
            background-color: #3a4045
        }

        #scroll-top.fixed {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            color: #FFF;
            width: 49px;
            height: 48px;
            right: 10px;
            text-align: center;
            text-decoration: none;
            z-index: 996;
            transition: background 0.3s ease-out;
            background: rgba(64, 64, 64, 0.75)
        }

        #scroll-top.fixed:hover {
            color: #0f43b0
        }

        @media (max-width: 575px) {
            footer {
                margin-bottom: 68px
            }

            #scroll-top {
                display: none
            }
        }

        .top-message + .gap {
            position: relative;
            top: -2px
        }

        .mobile-menu-toggler {
            margin: 0.8rem;
            margin-left: 0;
            padding: 0.7rem 1.1rem;
            color: #fff;
            font-size: 1.4rem
        }

        .product-default.inner-icon {
            position: relative;
            padding: 1rem 1rem 0
        }

        .product-default.inner-icon .product-title {
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.01em
        }

        .product-default.inner-icon .product-details {
            padding: 0
        }

        .product-default.inner-icon .category-list {
            text-overflow: ellipsis;
            overflow: hidden;
            width: calc(100% - 20px)
        }

        .product-default.inner-icon .guest-btn-icon-wish,
        .product-default.inner-icon .btn-quickview {
            top: auto
        }

        .product-default.inner-icon .guest-btn-icon-wish {
            left: auto;
            right: 1rem
        }

        .product-default.inner-icon .ratings-container {
            margin-left: 0
        }

        .product-default.inner-icon .price-box {
            margin-bottom: 1.7rem
        }

        .product-default.inner-icon .old-price {
            color: #a7a7a7;
            letter-spacing: inherit
        }

        .product-default.inner-icon:not(.product-widget):hover {
            box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.1)
        }

        .product-default.inner-icon:not(.product-widget):hover .img-effect a:first-child:after {
            opacity: 1
        }

        .product-default.inner-icon:not(.product-widget):hover figure .btn-quickview {
            padding-top: 1.2rem;
            padding-bottom: 1.3rem
        }

        .product-default.inner-icon .guest-btn-icon-wish {
            background-color: transparent
        }

        .product-default.inner-icon .btn-quickview {
            background-color: #0f43b0;
        }

        .inner-quickview figure .btn-quickview {
            padding: 0.8rem 1.4rem;
            transition-property: padding-top, padding-bottom, opacity;
            transition-duration: 0.25s;
            line-height: 1.82;
            z-index: 2
        }

        .inner-quickview figure .btn-quickview:hover {
            color: #fff
        }

        .inner-quickview .category-wrap .guest-btn-icon-wish {
            font-size: 1.6rem;
            padding-top: 1px
        }

        .breadcrumb-item {
            line-height: 27px
        }

        footer .widget-title {
            letter-spacing: -0.01em;
            line-height: 1.4
        }

        footer .social-icons {
            margin-top: 4px
        }

        .contact-widget .widget-title {
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 0.2px;
            line-height: 1;
            text-transform: uppercase;
            color: #777;
            margin-bottom: 0
        }

        .contact-widget > a {
            color: #222529;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.8
        }

        .widget-newsletter-title {
            font-size: 1.8rem;
            line-height: 19px;
            margin-bottom: 0
        }

        p.widget-newsletter-content {
            font-size: 1.3rem;
            letter-spacing: 0.005em;
            line-height: 20px
        }

        span.widget-newsletter-content {
            font-size: 1.6rem;
            letter-spacing: 0.005em;
            line-height: 20px
        }

        .footer-submit-wrapper .form-control {
            width: 419px;
            min-width: 1px;
            border-radius: 24px 0 0 24px;
            padding-left: 25px;
            border: none;
            height: 48px;
            font-size: 1.4rem
        }

        .footer-submit-wrapper .form-control::placeholder {
            color: #999
        }

        .footer-submit-wrapper .btn {
            padding-left: 25px;
            padding-right: 30px;
            border-radius: 0 24px 24px 0;
            height: 48px;
            font-family: "Open Sans", sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            background: #333
        }

        @media (min-width: 768px) {
            .footer-middle .col-md-4 {
                flex-basis: 30%;
                max-width: 30%
            }
        }

        @media (min-width: 992px) and (max-width: 1440px) {
            .contact-widget.follow {
                margin-left: 4rem
            }
        }

        @media (max-width: 991px) {
            .widget-newsletter-title {
                margin-bottom: 2.4rem
            }

            .widget-newsletter-content {
                margin-bottom: 2.4rem
            }

            .footer-submit-wrapper .form-control {
                flex: 1
            }
        }

        .about .feature-box h3 {
            margin-bottom: 1.2rem;
            text-transform: none;
            font-weight: 600;
            font-size: 18px;
            line-height: 20px;
            color: #21293c
        }

        .about .feature-box i {
            margin-bottom: 1.3rem;
            font-size: 5.5rem
        }

        .about .feature-box p {
            line-height: 27px
        }

        .about-section .subtitle {
            margin-bottom: 1.7rem
        }

        .about-section p {
            margin-bottom: 2rem;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px
        }

        .about-section .lead {
            font-family: Poppins, sans-serif;
            color: #21293c;
            font-size: 1.8rem;
            line-height: 1.5;
            font-weight: 400
        }

        .features-section {
            padding: 5.1rem 0 2rem
        }

        .features-section .subtitle {
            margin-bottom: 1.7rem
        }

        .features-section h3 {
            font-family: Poppins, sans-serif
        }

        .features-section .feature-box {
            padding: 3rem 4rem
        }

        .testimonials-section {
            padding: 5.1rem 0 7rem
        }

        .testimonials-section .subtitle {
            margin-bottom: 5.2rem
        }

        .testimonials-carousel blockquote {
            margin-bottom: 0
        }

        .testimonials-carousel.owl-theme .owl-nav.disabled + .owl-dots {
            margin-top: 0.5rem
        }

        .testimonial-title {
            display: block;
            margin-bottom: 2px;
            font-size: 1.6rem;
            text-transform: uppercase;
            color: #2b2b2d
        }

        .counters-section {
            padding: 5rem 0 2.4rem
        }

        .count-container .count-wrapper {
            color: #0087cb;
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 3.2rem;
            font-family: "Open Sans", sans-serif
        }

        .count-container span:not(.count-to) {
            font-size: 1.9rem
        }

        .count-container .count-title {
            color: #7b858a;
            font-size: 1.4rem;
            font-weight: 600
        }

        .team-info figure {
            position: relative
        }

        .team-info:hover .prod-full-screen {
            opacity: 1
        }

        .team-info .prod-full-screen {
            display: flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            background-color: #222529;
            border-radius: 50%;
            bottom: 5px;
            right: 5px
        }

        .team-info .prod-full-screen i {
            color: #fff
        }

        .owl-carousel.images-left img {
            width: auto
        }

        @media (min-width: 992px) {
            .counters-section .col-md-4 {
                -ms-flex: 0 0 20%;
                flex: 0 0 20%;
                max-width: 20%
            }
        }

        @media (min-width: 768px) {
            .about-section {
                padding-top: 3.1rem;
                padding-bottom: 4.5rem
            }
        }

        @media (min-width: 576px) {
            .testimonial blockquote {
                margin-left: 85px;
                padding: 2rem 3rem 1.5rem 2rem
            }
        }

        @keyframes navItemArrow {
            0% {
                position: relative;
                right: -1px
            }
            50% {
                position: relative;
                right: 3px
            }
            to {
                position: relative;
                right: -1px
            }
        }

        .blog-section {
            padding-bottom: 1.6rem
        }

        .post {
            margin-bottom: 4.1rem
        }

        .post a {
            color: inherit
        }

        .post a:focus,
        .post a:hover {
            text-decoration: underline
        }

        .post .read-more {
            float: right
        }

        .post .read-more i:before {
            margin: 0
        }

        .post-media {
            position: relative;
            margin-bottom: 1.7rem;
            border-radius: 0;
            background-color: #ccc
        }

        .post-media .prod-full-screen {
            display: flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            background-color: #0f43b0;
            border-radius: 50%
        }

        .post-media .prod-full-screen i {
            color: #fff
        }

        .post-media:hover .prod-full-screen {
            opacity: 1
        }

        .post-media .post-date {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 4.5rem;
            padding: 1rem 0.8rem 0.8rem;
            color: #fff;
            background: #222529;
            font-family: Poppins, sans-serif;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05em
        }

        .post-media .day {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1
        }

        .post-media .month {
            display: block;
            font-size: 1.12rem;
            line-height: 1;
            opacity: 0.6
        }

        .post-media img {
            width: 100%
        }

        .post-slider {
            margin-bottom: 3rem
        }

        .post-slider .owl-dots {
            position: absolute;
            right: 0;
            bottom: 0.25rem;
            left: 0;
            margin: 0 !important
        }

        .post-body {
            margin-left: 0;
            padding-bottom: 2.1rem;
            border: 0;
            line-height: 24px
        }

        .post-body .post-date {
            width: 40px;
            margin-right: 10px;
            float: left;
            text-align: center;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1)
        }

        .post-body .post-date .day {
            display: block;
            padding: 1.1rem 0.2rem;
            background-color: #f4f4f4;
            color: #08c;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.375
        }

        .post-body .post-date .month {
            display: block;
            padding: 0.4rem 0.2rem 0.7rem;
            border-radius: 0 0 0.2rem 0.2rem;
            background-color: #08c;
            color: #fff;
            font-size: 1.2rem;
            line-height: 1.33;
            box-shadow: 0 -1px 0 0 rgba(0, 0, 0, 0.07) inset
        }

        .post-title {
            margin-bottom: 1.3rem;
            color: #222529;
            font-family: "Open Sans", sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.35
        }

        .post-content {
            font-size: 1.3rem
        }

        .post-content:after {
            display: block;
            clear: both;
            content: ""
        }

        .post-content p {
            margin-bottom: 7px
        }

        .post-comment {
            color: #999;
            font-size: 1rem;
            text-transform: uppercase
        }

        .post-meta > span {
            display: inline-block;
            margin-right: 1.5rem
        }

        .post-meta i {
            margin-right: 0.5rem
        }

        .post-meta i:before {
            margin: 0
        }

        .single {
            margin-bottom: 2.3rem
        }

        .single .post-media {
            margin-bottom: 3rem
        }

        .single .post-meta {
            margin-bottom: 2rem;
            margin-left: 49px
        }

        .single .post-meta a {
            color: #999;
            font-size: 1rem;
            text-transform: uppercase
        }

        .single .post-title {
            margin-bottom: -8px;
            font-size: 3rem;
            color: #0f43b0;
            font-weight: 700;
            font-family: Poppins, sans-serif;
            line-height: 40px
        }

        .single h3 {
            font-size: 2rem;
            font-weight: 600
        }

        .single h3 i {
            margin-right: 7px;
            font-size: 2rem
        }

        .single .post-share {
            margin-bottom: 2.4rem
        }

        .single .post-share h3 {
            margin-bottom: 2.2rem;
            letter-spacing: -0.01em
        }

        .single .post-content {
            margin-bottom: 5.7rem
        }

        .single .post-content p {
            margin-bottom: 2rem;
            font-family: "Open Sans", sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px
        }

        .single .post-content h3 {
            margin-bottom: 2rem;
            color: #21293c;
            font-size: 18px;
            font-weight: 400;
            line-height: 27px
        }

        .single .social-icon {
            width: 29px;
            height: 29px
        }

        .single .social-icon + .social-icon {
            margin-left: 0.8rem
        }

        .post-share {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            margin-bottom: 2.6rem;
            padding: 2.8rem 0
        }

        .post-share h3 {
            margin-right: 2rem
        }

        .post-share .social-icons {
            color: #fff
        }

        .post-author {
            margin-bottom: 2.2rem;
            padding-bottom: 2.7rem
        }

        .post-author:after {
            display: block;
            clear: both;
            content: ""
        }

        .post-author h3 {
            margin-bottom: 2rem;
            letter-spacing: -0.01em
        }

        .post-author figure {
            max-width: 80px;
            margin-right: 2rem;
            margin-bottom: 0;
            float: left
        }

        .post-author h4 {
            margin: 1rem;
            font-weight: 600;
            font-size: 1.6rem;
            letter-spacing: 0.03em;
            color: #0f43b0;
            font-family: "Open Sans", sans-serif
        }

        .post-author .author-content {
            font-size: 1.3rem;
            line-height: 1.8
        }

        .post-author .author-content p:last-child {
            margin-bottom: 0;
            line-height: 1.7
        }

        .zoom-effect {
            position: relative;
            overflow: hidden
        }

        .zoom-effect img {
            transition: transform 0.2s
        }

        .zoom-effect:hover img {
            transform: scale(1.1, 1.1)
        }

        .post-date-in-media .post-media {
            margin-bottom: 1.9rem;
            overflow: hidden
        }

        .post-date-in-media .post-media img {
            transition: transform 0.2s
        }

        .post-date-in-media .post-media:hover img {
            transform: scale(1.1, 1.1)
        }

        .post-date-in-media .post-body {
            margin-left: 0;
            padding-bottom: 2rem;
            border: 0
        }

        .post-date-in-media .post-title {
            margin-bottom: 0.7rem;
            font-size: 1.7rem;
            font-family: Poppins, sans-serif;
            font-weight: 700
        }

        .post-date-in-media p {
            font-size: 1.3rem;
            line-height: 1.846
        }

        .post-date-in-media .post-comment {
            color: #999;
            font-size: 1rem;
            text-transform: uppercase
        }

        .comment-respond h3 {
            margin-bottom: 2.9rem;
            letter-spacing: -0.01em
        }

        .comment-respond h3 + p {
            margin-bottom: 2.6rem
        }

        .comment-respond label {
            margin-bottom: 0.7rem;
            font-size: 1.4rem;
            font-family: "Open Sans", sans-serif
        }

        .comment-respond .form-control {
            height: 37px
        }

        .comment-respond .form-group {
            margin-bottom: 2rem
        }

        .comment-respond form {
            margin-bottom: 0;
            padding: 3rem;
            background-color: #f5f5f5
        }

        .comment-respond form p {
            margin-bottom: 2rem;
            line-height: 1.75
        }

        .comment-respond form textarea {
            margin-top: 1px;
            min-height: 170px
        }

        .comment-respond form .form-group-custom-control .custom-control-label {
            font-family: "Open Sans", sans-serif;
            font-size: 1.4rem;
            line-height: 1.75;
            font-weight: 700;
            color: #222529
        }

        .comment-respond .form-group-custom-control {
            padding-top: 1px
        }

        .comment-respond .custom-control-label:after,
        .comment-respond .custom-control-label:before {
            width: 13px;
            height: 13px
        }

        .comment-respond .custom-checkbox .custom-control-label:after {
            top: 2px;
            left: 1px;
            font-weight: 300;
            font-size: 1.2rem
        }

        .comment-respond .custom-control-label:after,
        .comment-respond .custom-control-label:before {
            top: 5px;
            left: 0;
            width: 13px;
            height: 13px;
            line-height: 2rem
        }

        .comment-respond .custom-control {
            padding-left: 2.2rem
        }

        .comment-respond .btn-sm {
            letter-spacing: 0.01em
        }

        .related-posts {
            padding-top: 3.2rem;
            margin-bottom: 5rem
        }

        .related-posts h4 {
            margin-bottom: 1.4rem;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: -0.01em
        }

        .related-posts .post {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: 0
        }

        .related-posts .post p {
            margin-bottom: 1rem
        }

        .related-posts .post-body {
            padding-bottom: 0;
            border-bottom: 0
        }

        .related-posts .post-media {
            margin-bottom: 2rem
        }

        .related-posts .post-title {
            color: #0077b3;
            margin-bottom: 1rem;
            font-size: 16.8px
        }

        .related-posts .post-content {
            margin-left: 55px
        }

        .related-posts .read-more {
            float: left;
            color: #222529;
            font-size: 12.6px;
            font-weight: 600
        }

        .sidebar {
            position: relative;
            height: 100%;
            font-size: 1.3rem
        }

        .sidebar .widget {
            margin-bottom: 3.1rem
        }

        .sidebar .sidebar-wrapper {
            padding-bottom: 4.2rem
        }

        .sidebar .sidebar-wrapper .widget:last-child {
            margin-bottom: 0;
            padding-bottom: 3rem
        }

        .widget-post .widget-title {
            margin-bottom: 1.7rem
        }

        .widget-title {
            margin: 0.5rem 0 1.3rem;
            color: #313131;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
            text-transform: uppercase
        }

        .widget form {
            margin-bottom: 0
        }

        .list {
            padding: 0;
            list-style: none;
            font-size: 1.3rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            margin-top: -8px;
            margin-bottom: 0
        }

        .list li {
            display: block;
            position: relative;
            margin: 0;
            padding: 6px 0 6px 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            line-height: 24px
        }

        .list li:before {
            content: "";
            position: relative;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-left: -11px;
            margin-right: 6px;
            font-size: 7.2px;
            opacity: 0.7;
            vertical-align: middle
        }

        .list li:hover:before {
            animation: navItemArrow 0.6s linear infinite
        }

        .list li a {
            color: inherit
        }

        .list li:first-child {
            border-top-width: 0
        }

        .list .list {
            margin-top: 5px;
            margin-bottom: -6px;
            border-bottom: none
        }

        .list .list li:first-child {
            border-top-width: 1px
        }

        .widget.widget-categories .widget-title {
            margin-top: 1px;
            margin-bottom: 1.8rem
        }

        .tagcloud:after {
            display: block;
            clear: both;
            content: ""
        }

        .tagcloud a {
            margin: 0.4rem 0.4rem 0.4rem 0;
            padding: 0.4rem 0.8rem;
            line-height: 1;
            display: inline-block;
            text-decoration: none;
            font-size: 10.5px;
            text-transform: uppercase;
            font-weight: 700;
            border-radius: 10px;
            background-color: #222529;
            color: #fff
        }

        .simple-post-list {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .simple-post-list li {
            padding-bottom: 15px
        }

        .simple-post-list li:after {
            display: block;
            clear: both;
            content: ""
        }

        .simple-post-list li:last-child {
            padding-top: 15px;
            border-top: 1px dotted #ececec
        }

        .simple-post-list .post-media {
            width: 5rem;
            margin: 0 1rem 0 0;
            float: left;
            border-radius: 0;
            line-height: 0
        }

        .simple-post-list .post-media img {
            display: block;
            width: 100%;
            max-width: none;
            height: auto
        }

        .simple-post-list .post-info a {
            display: inline-block;
            margin-bottom: 2px;
            font-weight: 600;
            font-size: 14px;
            line-height: 18px;
            color: #0f43b0
        }

        .simple-post-list .post-info a:hover {
            text-decoration-line: underline
        }

        .simple-post-list .post-info .post-meta {
            letter-spacing: 0.01em;
            font-size: 1.1rem
        }

        .comment-list {
            padding-bottom: 4px
        }

        .comments {
            position: relative
        }

        .comments .img-thumbnail {
            position: absolute;
            top: 0;
            padding: 0;
            border: 0
        }

        .comments .comment-block {
            padding: 2rem 2rem 3.5rem;
            margin-left: 11.5rem;
            position: relative
        }

        .comments .comment-block p {
            font-size: 0.9em;
            line-height: 21px;
            margin: 0;
            padding: 0
        }

        .comments .comment-block .date {
            color: #999;
            font-size: 0.9em
        }

        .comments .comment-by {
            display: block;
            padding: 0 0 4px 0;
            margin: 0;
            font-size: 1.3rem;
            line-height: 21px;
            letter-spacing: -0.005em;
            color: #999
        }

        .comments .comment-by strong {
            font-size: 1.4rem;
            letter-spacing: 0.005em;
            color: #7b858a
        }

        .comments .comment-footer {
            margin-top: 5px
        }

        .comments .comment-arrow {
            position: absolute;
            left: -15px;
            height: 0;
            top: 28px;
            width: 0;
            border-bottom: 15px solid transparent;
            border-top: 15px solid transparent;
            border-right: 15px solid #f4f4f4
        }

        .comments .comment-action {
            color: var(--primary-color)
        }

        @media (max-width: 991px) {
            .sidebar.mobile-sidebar {
                position: fixed
            }
        }

        @media (max-width: 767px) {
            .comment-respond .form-footer {
                margin-bottom: 3rem
            }
        }

        @media (max-width: 767px) {
            .comment-respond .form-footer {
                margin-bottom: 2rem
            }
        }

        @media (max-width: 575px) {
            .comment-respond form {
                padding: 1.5rem
            }
        }

        .sidebar-shop {
            font-size: 1.3rem
        }

        .sidebar-shop .product-widget .product-title {
            margin-bottom: 0.4rem;
            font-family: "Open Sans", sans-serif
        }

        .sidebar-shop .product-widget .product-details {
            margin-bottom: 1px
        }

        .sidebar-shop .widget:after {
            display: block;
            clear: both;
            content: ""
        }

        .sidebar-shop .widget:not(:last-child) {
            margin-bottom: 3rem;
            border-bottom: 0
        }

        .sidebar-shop .widget-title {
            margin: 0;
            color: #000;
            font-family: "Open Sans", sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dfdfdf;
            line-height: 1.4;
            text-transform: uppercase
        }

        .sidebar-shop .widget-title a {
            display: block;
            position: relative;
            color: inherit
        }

        .sidebar-shop .widget-title a:focus,
        .sidebar-shop .widget-title a:hover {
            text-decoration: none
        }

        .sidebar-shop .widget-title a:after,
        .sidebar-shop .widget-title a:before {
            display: inline-block;
            position: absolute;
            top: 50.4%;
            right: 2px;
            width: 10px;
            height: 2px;
            margin-top: -1px;
            transition: all 0.35s;
            background: #222529;
            content: ""
        }

        .sidebar-shop .widget-title a.collapsed:after {
            transform: rotate(-90deg)
        }

        .sidebar-shop .widget-body {
            padding: 1.5rem 0 0.7rem
        }

        .sidebar-shop .widget-featured {
            position: relative;
            padding-bottom: 0.5rem
        }

        .sidebar-shop .widget-featured .widget-body {
            padding-top: 1.5rem
        }

        .sidebar-shop .widget-featured .product-sm:last-child {
            margin-bottom: 0
        }

        .sidebar-shop .widget-featured .ratings-container {
            margin-left: 0
        }

        .widget-featured-products .product-widget {
            margin-bottom: 1.6rem
        }

        .widget-featured-products .product-widget figure {
            margin-right: 1.2rem;
            max-width: 84px;
            flex-shrink: 0
        }

        .widget-featured-products .product-widget .ratings-container {
            margin-bottom: 1.2rem;
            margin-top: 2px
        }

        .widget .owl-carousel .owl-nav {
            position: absolute;
            top: -3.5rem;
            right: 1px;
            line-height: 0
        }

        .widget .owl-carousel .owl-nav button.owl-next,
        .widget .owl-carousel .owl-nav button.owl-prev {
            padding: 0 0.4rem !important;
            border-radius: 0;
            color: #222529;
            font-size: 1.8rem;
            line-height: 1;
            background-color: transparent
        }

        .widget .owl-carousel .owl-nav i:before {
            width: auto;
            margin: 0
        }

        .cat-list {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .cat-list li {
            position: relative;
            margin-bottom: 1.3rem;
            font-size: 14px;
            font-weight: 500
        }

        .cat-list li:last-child {
            margin-bottom: 0
        }

        .cat-list li a {
            color: #777;
            font-weight: 500
        }

        .cat-list li a:focus,
        .cat-list li a:hover {
            color: #0f43b0
        }

        .cat-list .products-count {
            margin-left: 3px;
            font-size: 13px;
            font-weight: 500
        }

        .cat-sublist {
            margin-top: 1.3rem;
            margin-left: 1.4rem
        }

        span.toggle {
            cursor: pointer;
            display: inline-block;
            text-align: center;
            position: absolute;
            right: -5px;
            top: -3px;
            margin: 0;
            padding: 0;
            width: 24px;
            height: 24px;
            line-height: 23px;
            font-family: "Porto";
            font-weight: 900;
            color: #222529
        }

        span.toggle:before {
            content: ""
        }

        .collapsed span.toggle:before {
            content: ""
        }

        .config-size-list {
            margin: 0;
            padding: 0;
            font-size: 0;
            list-style: none
        }

        .config-size-list li {
            display: -ms-inline-flexbox;
            display: inline-flex
        }

        .config-size-list a {
            display: block;
            position: relative;
            min-width: 32px;
            text-align: center;
            margin: 3px 6px 3px 0;
            padding: 4px 8px;
            transition: all 0.3s;
            border: 1px solid #e9e9e9;
            color: #777;
            font-size: 1.1rem;
            font-weight: 400;
            line-height: 1.6rem;
            text-decoration: none
        }

        .config-size-list a.active,
        .config-size-list a:focus,
        .config-size-list a:hover {
            border-color: #0f43b0;
            background-color: #0f43b0;
            color: #fff;
            text-decoration: none
        }

        .price-slider-wrapper {
            padding: 1.5rem 0.4rem 0.5rem 0.6rem
        }

        .filter-price-action {
            margin-top: 2.5rem;
            padding-bottom: 0.5rem
        }

        .filter-price-action .btn {
            padding: 5px 1.5rem 6px 1.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            font-family: "Open Sans", sans-serif
        }

        .filter-price-action .filter-price-text {
            font-size: 1.2rem;
            line-height: 2
        }

        .widget-block {
            font-size: 1.5rem;
            line-height: 1.42
        }

        .widget-block h5 {
            margin-bottom: 1.5rem;
            color: #313131;
            font-size: 1.4rem;
            font-weight: 600;
            font-family: "Open Sans", sans-serif
        }

        .widget-block p {
            font-size: 1.4rem;
            line-height: 1.75;
            margin-bottom: 0
        }

        .widget-block .widget-title {
            padding-bottom: 3px
        }

        .widget .config-swatch-list {
            display: flex;
            flex-wrap: wrap;
            margin-top: 0.3rem
        }

        .widget .config-swatch-list li {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            margin: 0;
            font-size: 1.3rem
        }

        .widget .config-swatch-list li a {
            margin: 3px 6px 3px 0;
            box-shadow: none
        }

        .widget.widget-color .widget-body {
            padding-top: 0.6rem
        }

        .widget.widget-size .widget-body {
            padding-top: 1.1rem
        }

        .shop-toggle.sidebar-toggle {
            display: inline-flex;
            position: static;
            align-items: center;
            width: auto;
            height: 34px;
            background: #fff;
            padding: 0 8px;
            text-transform: uppercase;
            color: inherit;
            border: 1px solid #e7e7e7;
            cursor: pointer;
            margin-right: 1rem;
            margin-top: 0;
            z-index: 1
        }

        .shop-toggle.sidebar-toggle span {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: -0.05em;
            margin-left: 0.6rem;
            color: #222528
        }

        .sidebar-opened .shop-toggle.sidebar-toggle {
            z-index: 1
        }

        .sidebar-opened .shop-toggle.sidebar-toggle i:before {
            content: ""
        }

        .horizontal-filter {
            margin-bottom: 2rem;
            padding: 6px 0 0px;
            background-color: #f4f4f4
        }

        .horizontal-filter.filter-sorts {
            padding: 12px 12px 2px
        }

        .horizontal-filter.filter-sorts .select-custom select {
            border: none
        }

        .horizontal-filter:not(.filter-sorts) .toolbox-item:not(:last-child) {
            margin-right: 1.6rem
        }

        .horizontal-filter:not(.filter-sorts).toolbox label {
            margin: 0px 1rem 1px 0px;
            font-family: Poppins, sans-serif;
            letter-spacing: -0.025em
        }

        .horizontal-filter:not(.filter-sorts).toolbox .form-control {
            padding: 0 0.8rem 2px;
            color: #222529;
            font-family: "poppins"
        }

        .horizontal-filter:not(.filter-sorts).toolbox .select-custom .form-control {
            padding-right: 2.4rem
        }

        .horizontal-filter:not(.filter-sorts) .toolbox-item.toolbox-sort {
            margin-right: 3.2rem
        }

        .horizontal-filter .filter-price-form {
            font-family: "Open Sans", sans-serif;
            font-size: 1.36rem
        }

        .horizontal-filter .filter-price-form .btn {
            font-family: inherit;
            padding: 0.7rem 1.2rem;
            font-size: 1.2rem;
            font-weight: 400
        }

        .horizontal-filter .input-price {
            display: block;
            width: 50px;
            padding: 6px;
            line-height: 1.45;
            outline: none;
            border: 1px solid rgba(0, 0, 0, 0.09)
        }

        .horizontal-filter select {
            border: 0
        }

        .horizontal-filter:not(.filter-sorts) {
            background-color: #fff
        }

        .horizontal-filter:not(.filter-sorts) .layout-btn {
            width: 36px;
            border: 1px solid #dfdfdf;
            line-height: 34px
        }

        .horizontal-filter:not(.filter-sorts) .layout-btn.active {
            color: #222529;
            border-color: #222529
        }

        .horizontal-filter:not(.filter-sorts) .layout-btn:not(:last-child) {
            margin-right: 8px
        }

        .horizontal-filter .select-custom select {
            border: 1px solid #dfdfdf
        }

        .sort-menu-trigger {
            display: block;
            color: #313131;
            font-size: 12px;
            line-height: 1.4;
            text-transform: uppercase
        }

        .sort-list li {
            padding: 1rem 0;
            font-size: 12px;
            text-transform: uppercase
        }

        .sort-list li a {
            color: inherit;
            font-weight: 600
        }

        .sort-list li.active,
        .sort-list li:focus,
        .sort-list li:hover {
            color: #0f43b0
        }

        .sort-list.cat-list li {
            margin-bottom: 0
        }

        .sort-list.cat-list li span.toggle {
            top: 5px
        }

        .filter-toggle span {
            margin-bottom: 2px;
            color: #777;
            font-size: 1.3rem;
            letter-spacing: -0.02em
        }

        .filter-toggle a {
            display: inline-block;
            position: relative;
            width: 46px;
            height: 26px;
            margin-left: 7px;
            border-radius: 13px;
            background: #e6e6e6;
            text-decoration: none
        }

        .filter-toggle a:before {
            position: absolute;
            left: 0;
            width: 42px;
            height: 22px;
            -webkit-transform: translate3d(2px, 2px, 0) scale3d(1, 1, 1);
            transform: translate3d(2px, 2px, 0) scale3d(1, 1, 1);
            transition: all 0.3s linear;
            border-radius: 11px;
            background-color: #fff;
            content: ""
        }

        .filter-toggle a:after {
            position: absolute;
            left: 0;
            width: 22px;
            height: 22px;
            -webkit-transform: translate3d(2px, 2px, 0);
            transform: translate3d(2px, 2px, 0);
            transition: all 0.2s ease-in-out;
            border-radius: 11px;
            background-color: #fff;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.24);
            content: ""
        }

        .filter-toggle.opened a {
            background-color: #0f43b0
        }

        .filter-toggle.opened a:before {
            -webkit-transform: translate3d(18px, 2px, 0) scale3d(0, 0, 0);
            transform: translate3d(18px, 2px, 0) scale3d(0, 0, 0)
        }

        .filter-toggle.opened a:after {
            -webkit-transform: translate3d(22px, 2px, 0);
            transform: translate3d(22px, 2px, 0)
        }

        .shop-off-canvas .mobile-sidebar {
            display: block;
            position: fixed;
            padding: 1.3rem 0.8rem 1.3rem 0.9rem;
            top: 0;
            bottom: 0;
            left: 0;
            width: 300px;
            margin: 0;
            transform: translate(-300px);
            transition: transform 0.2s ease-in-out 0s;
            background-color: #fff;
            z-index: 9999;
            overflow-y: auto
        }

        .shop-off-canvas .widget {
            border: none
        }

        .shop-off-canvas .widget:not(:last-child) {
            border-bottom: 1px solid #e7e7e7
        }

        .shop-off-canvas .sidebar-wrapper {
            width: 100% !important
        }

        .sidebar-opened .shop-off-canvas .mobile-sidebar {
            transform: none
        }

        .sidebar-opened .shop-off-canvas .sidebar-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: #000;
            opacity: 0.35;
            z-index: 9999
        }

        .sidebar-toggle {
            display: flex;
            position: static;
            margin-right: 0.8rem;
            margin-top: 0;
            padding: 0 1.1rem 0 3px;
            align-items: center;
            width: auto;
            height: 34px;
            text-transform: uppercase;
            line-height: 36px;
            color: inherit;
            border: 1px solid #dfdfdf;
            background: #fff;
            cursor: pointer
        }

        .sidebar-toggle span {
            margin-left: 0rem;
            font-size: 1.3rem;
            letter-spacing: -0.05em
        }

        .sidebar-toggle:hover span {
            color: #0f43b0
        }

        .sidebar-opened .sidebar-toggle i:before {
            content: ""
        }

        .slide-content {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 11.4%;
            text-transform: uppercase
        }

        .boxed-slide-1 .slide-content {
            text-align: center
        }

        .boxed-slide-2 .slide-content {
            left: 6.8%;
            color: #222529
        }

        .boxed-slide-1 h4 {
            font-family: Oswald, sans-serif;
            font-size: 2.7rem;
            font-weight: 500;
            letter-spacing: -0.08em;
            margin-bottom: 0
        }

        .boxed-slide-1 h5 {
            font-family: "Open Sans", sans-serif;
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin-top: -5px;
            margin-bottom: 0
        }

        .boxed-slide-1 span {
            display: block;
            position: relative;
            width: 100%;
            color: #222529;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: -6px;
            margin-top: 3px
        }

        .boxed-slide-1 span:before {
            content: "";
            display: block;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 1px;
            background-color: #74b0bb
        }

        .boxed-slide-1 span:after {
            content: "";
            display: block;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 1px;
            background-color: #74b0bb
        }

        .boxed-slide-1 b {
            font-size: 3.6rem;
            font-weight: 800;
            color: #222529;
            letter-spacing: 0.025em
        }

        .boxed-slide-1 b i {
            font-weight: 500
        }

        .boxed-slide-1 p {
            font-size: 13px;
            font-weight: 700;
            color: #222529;
            letter-spacing: 0.03em;
            margin-top: -5px;
            margin-bottom: 2.2rem
        }

        .boxed-slide-2 h5 {
            font-family: "Open Sans", sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0
        }

        .boxed-slide-2 h5 span {
            font-family: Oswald, sans-serif;
            font-size: 2.9rem
        }

        .boxed-slide-2 h5 i {
            font-family: Poppins, sans-serif;
            font-style: normal;
            font-size: 1.6rem;
            margin-left: -2px;
            margin-bottom: 5px
        }

        .boxed-slide-2 h4 {
            font-size: 3.2rem;
            font-weight: 800;
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.02em;
            margin-bottom: 3rem;
            margin-top: -3px
        }

        .boxed-slide-2 .btn {
            font-family: Oswald, sans-serif;
            font-size: 1.5rem;
            font-weight: 300;
            letter-spacing: 0.04em;
            padding: 9px 17.5px 13px;
            margin-bottom: 1.3rem
        }

        .btn-loadmore {
            box-shadow: none;
            padding: 1.3rem 3rem;
            border: 1px solid #e7e7e7;
            font-size: 1.2rem;
            font-family: "Open Sans", sans-serif;
            color: #555
        }

        .btn-loadmore:hover {
            border-color: #ccc
        }

        .category-banner {
            padding: 6.8rem 0
        }

        .category-banner .coupon-sale-text {
            font-family: "Open Sans", sans-serif
        }

        .category-banner h3 {
            font-size: 3em;
            margin-left: 1.8rem;
            margin-bottom: 1.6rem
        }

        .category-banner h4 {
            font-size: 1.125em;
            line-height: 1.7
        }

        .category-banner h5 {
            font-size: 1em
        }

        .category-banner .btn {
            font-size: 0.75em;
            letter-spacing: 0.01em;
            padding: 1em 1.6em;
            margin-left: 1.8rem
        }

        @media (min-width: 992px) {
            .filter-sorts .toolbox-left {
                position: relative
            }

            .filter-sorts .toolbox-item.toolbox-sort {
                margin-left: 0;
                margin-right: 1rem;
                background-color: #fff
            }

            .filter-sorts select {
                border: 0;
                text-transform: uppercase
            }

            .filter-sorts .mobile-sidebar.sidebar-shop {
                left: 0;
                padding: 0;
                visibility: visible;
                z-index: 2
            }

            .sort-list {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                min-width: 220px;
                margin-top: 10px;
                padding: 10px 15px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
                z-index: 99
            }

            .sort-list:after,
            .sort-list:before {
                content: "";
                position: absolute;
                bottom: 100%;
                border-right: 10px solid transparent;
                border-bottom: 10px solid #fff;
                border-left: 10px solid transparent
            }

            .sort-list:before {
                left: 21px;
                z-index: 999
            }

            .sort-list:after {
                left: 20px;
                border-right-width: 11px;
                border-bottom: 11px solid #e8e8e8;
                border-left-width: 11px
            }

            .sort-menu-trigger {
                min-width: 140px;
                height: 34px;
                padding-left: 0.8rem;
                color: #777;
                line-height: 34px;
                z-index: 9
            }

            .sort-menu-trigger:focus,
            .sort-menu-trigger:hover {
                text-decoration: none
            }

            .toolbox-item.opened .sort-list {
                display: block
            }
        }

        .sidebar-toggle svg {
            stroke: #222529;
            fill: #fff;
            width: 28px
        }

        .product-ajax-grid + .bounce-loader {
            bottom: -1rem;
            top: auto
        }

        @media (min-width: 992px) {
            .sidebar-toggle {
                display: none
            }
        }

        @media (max-width: 991px) {
            .sort-menu-trigger {
                margin-bottom: 1.5rem;
                font-weight: 700
            }

            .shop-off-canvas .sidebar-wrapper {
                padding: 2rem
            }

            .shop-off-canvas .sidebar-toggle {
                margin-right: 0
            }

            .shop-off-canvas .toolbox {
                justify-content: flex-start
            }

            .shop-off-canvas .toolbox-right {
                margin-left: auto
            }

            .shop-off-canvas .toolbox .toolbox-item:not(:last-child) {
                margin-left: 0.7rem
            }

            .sidebar-toggle span {
                font-size: 11px;
                font-weight: 600;
                color: #222529
            }

            .sidebar-shop .widget {
                padding: 2rem 0;
                border: 0
            }

            .sidebar-shop .widget:first-child {
                padding-top: 0
            }

            .sidebar-shop .widget:not(:last-child) {
                border-bottom: 1px solid #e7e7e7
            }

            .horizontal-filter,
            .horizontal-filter.filter-sorts,
            .horizontal-filter:not(.filter-sorts) {
                padding: 10px;
                background-color: #f4f4f4
            }
        }

        @media (max-width: 767px) {
            .category-content {
                padding: 1rem
            }

            .category-banner h3 {
                margin-left: -2px
            }

            .category-banner .btn {
                margin-left: 0
            }

            .horizontal-filter:not(.filter-sorts).toolbox .select-custom .form-control {
                padding-top: 3px
            }
        }

        @media (max-width: 575px) {
            .home-slide1 {
                font-size: 2.5vw
            }

            .horizontal-filter.filter-sorts {
                justify-content: unset
            }

            .horizontal-filter .toolbox-item.toolbox-sort {
                margin-right: 0
            }

            .boxed-slide img {
                min-height: 250px
            }

            .horizontal-filter:not(.filter-sorts) .toolbox-item:not(:last-child) {
                margin-right: 0
            }
        }

        @media (max-width: 479px) {
            .horizontal-filter {
                justify-content: stretch
            }

            .horizontal-filter:not(.filter-sorts) .toolbox-item.toolbox-sort {
                margin-right: 0;
                margin-left: 0
            }

            .sidebar-toggle {
                margin-right: 2px
            }
        }

        @media (min-width: 992px) and (max-width: 1420px) {
            .sidebar-shop .product-widget figure {
                max-width: 70px;
                margin-right: 1.5rem
            }
        }

        .contact-two > .container {
            margin-bottom: 0.6rem
        }

        .contact-two #map {
            margin-bottom: 3.2rem;
            height: 400px;
            background-color: #e5e3df
        }

        .contact-two #map address {
            margin: 0;
            padding: 0.625rem 0.875rem;
            font-size: 1.3rem;
            font-style: normal;
            font-weight: 400;
            line-height: 1.5
        }

        .contact-two #map a {
            display: inline-block;
            margin-top: 0.8rem;
            font-size: 1.2rem;
            text-transform: uppercase
        }

        .contact-two .required-field > label:after {
            margin-bottom: 0.4rem;
            color: #777;
            font-size: 1.3rem
        }

        .contact-two .contact-info {
            margin-bottom: 3rem;
            padding-top: 0.4rem
        }

        .contact-two .contact-info > div {
            margin-bottom: 2rem
        }

        .contact-two .contact-info > div:after {
            display: block;
            clear: both;
            content: ""
        }

        .contact-two .contact-info i {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            float: left;
            border-radius: 50%;
            background-color: #3b3b3b;
            color: #fff;
            font-size: 1.4rem;
            text-align: center
        }

        .contact-two .contact-info p {
            margin-bottom: 0;
            margin-left: 5.5rem
        }

        .contact-two .contact-info p:first-of-type {
            padding-top: 0.1rem
        }

        .contact-two label {
            margin-bottom: 1.1rem;
            color: #777;
            font-family: "Open Sans", sans-serif;
            font-size: 1.4rem;
            font-weight: 400
        }

        .contact-two .form-control {
            border-color: rgba(0, 0, 0, 0.09);
            height: 37px
        }

        .contact-two .form-group {
            margin-bottom: 1.8rem
        }

        .contact-two textarea.form-control {
            min-height: 208px
        }

        .contact-two .form-footer {
            margin-top: 1.6rem
        }

        .contact-two .btn {
            padding: 0.7rem 1.3rem 0.7rem 1.4rem;
            font-size: 1.4rem;
            font-weight: 400;
            text-transform: none
        }

        .contact-two .contact-title {
            margin-top: 1.6rem;
            margin-bottom: 1.3rem;
            font-size: 2rem
        }

        .contact-two p {
            padding-bottom: 5px;
            font-size: 14px;
            line-height: 22px
        }

        .contact-two .porto-sicon-title {
            margin: 0;
            margin-left: 1.5rem;
            color: #777;
            font-weight: 400;
            font-size: 1.4rem
        }

        .contact-two .contact-time {
            padding-top: 4px
        }

        .contact-two .contact-time .contact-title {
            margin-bottom: 1.4rem
        }

        .contact-two .contact-time .porto-sicon-title {
            margin-top: 1px
        }

        .contact-two .contact-time .porto-sicon-box {
            margin-bottom: 2.3rem
        }

        @media (min-width: 768px) {
            #map {
                height: 380px;
                margin-bottom: 5rem
            }
        }

        @media (min-width: 992px) {
            #map {
                height: 460px;
                margin-bottom: 6rem
            }
        }

        .cart-message {
            padding: 0.8rem 0 1.9rem 3px
        }

        .cart-message:before {
            content: "";
            position: relative;
            margin-right: 0.6rem;
            top: 2px;
            font-size: 20px;
            font-weight: 900;
            font-family: "Font Awesome 5 Free";
            color: #0cc485
        }

        .cart-message span {
            color: #222529;
            font-size: 1.6rem
        }

        .single-cart-notice {
            line-height: 24px;
            font-size: 1.6rem;
            color: #222529
        }

        .view-cart {
            padding: 14px 27px 13px;
            margin: 3px 0;
            height: 48px;
            font-family: "Open Sans", sans-serif
        }

        .add-cart {
            padding: 12px 27px 10px 26px;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.015em;
            line-height: 24px
        }

        .add-cart:before {
            font-size: 1.8rem;
            line-height: 0;
            vertical-align: middle;
            margin-right: 8px;
            font-weight: 900
        }

        .add-wishlist {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 17px 8px;
            color: #222529;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: Poppins, sans-serif;
            letter-spacing: -0.015em;
            text-transform: uppercase;
            white-space: nowrap
        }

        .add-wishlist i {
            margin-right: 4px;
            font-size: 1.6rem
        }

        .add-wishlist i:before {
            font-weight: 700
        }

        .added-wishlist i:before {
            content: "";
            color: #da5555
        }

        .add-compare:before {
            content: "";
            font-size: 1.8rem;
            font-family: "porto";
            margin-right: 6px
        }

        .product-widgets-container {
            margin-bottom: 3.8rem
        }

        .product-widgets-container .product-single-details {
            margin-bottom: 3px
        }

        .product-widgets-container .section-sub-title {
            margin-bottom: 1.6rem
        }

        .product-widgets-container figure {
            max-width: 75px;
            margin-right: 0.7rem
        }

        .product-widgets-container .product-details {
            margin-bottom: 2px
        }

        .product-widgets-container .ratings-container {
            margin-bottom: 1.2rem;
            margin-left: 0
        }

        .product-widgets-container .product-title {
            font-size: 1.4rem;
            font-family: "Open Sans", sans-serif
        }

        .product-widgets-container .product-price {
            font-size: 1.5rem
        }

        .product-single-container:not(.product-quick-view) .product-action .add-cart.added-to-cart:before {
            display: none
        }

        .product-single-container:not(.product-quick-view) .product-action .add-cart.added-to-cart:after {
            margin-left: 8px;
            font-family: "Font Awesome 5 Free";
            content: "";
            font-weight: 600;
            font-size: 1.6rem
        }

        .product-single-details {
            margin-bottom: 1.1rem
        }

        .product-single-details .product-action .add-cart {
            display: inline-flex;
            align-items: center
        }

        .product-single-details .product-action .add-cart:before {
            content: "";
            margin-top: -2px;
            font-family: "Porto";
            font-weight: 600;
            font-size: 1.8rem;
            margin-right: 7px
        }

        .sticky-sidebar .product-single-details {
            margin-bottom: 2.7rem
        }

        .product-single-details .product-title {
            margin-bottom: 1.1rem;
            color: #222529;
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            width: calc(100% - 70px)
        }

        .product-single-details .product-nav {
            position: absolute;
            display: flex;
            top: 4px;
            right: 10px
        }

        .product-single-details .product-nav.top-0 {
            top: 0
        }

        .product-single-details .product-nav a {
            color: #222529
        }

        .product-single-details .product-nav .product-next,
        .product-single-details .product-nav .product-prev {
            float: left;
            margin-left: 2px
        }

        .product-single-details .product-nav .product-next.disabled > a,
        .product-single-details .product-nav .product-prev.disabled > a {
            color: #999;
            cursor: no-drop
        }

        .product-single-details .product-nav .product-next:hover .product-popup,
        .product-single-details .product-nav .product-prev:hover .product-popup {
            display: block
        }

        .product-single-details .product-nav a:hover {
            color: #333
        }

        .product-single-details .product-nav .product-link {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            width: 28px;
            height: 28px;
            line-height: 23px;
            border: 2px solid #e7e7e7;
            border-radius: 14px;
            text-align: center;
            text-decoration: none;
            font-family: "porto"
        }

        .product-single-details .product-nav .product-prev .product-link:before {
            content: "";
            display: block
        }

        .product-single-details .product-nav .product-next .product-link:before {
            content: "";
            display: block
        }

        .product-single-details .product-nav .product-popup {
            position: absolute;
            top: 31px;
            display: none;
            right: 0;
            font-size: 13px;
            z-index: 999;
            width: 110px;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.15);
            text-align: center;
            background-color: #fff
        }

        .product-single-details .product-nav .product-popup:before {
            right: 36px;
            border-bottom: 7px solid #333;
            border-left: 7px solid transparent !important;
            border-right: 7px solid transparent !important;
            content: "";
            position: absolute;
            top: -5px
        }

        .product-single-details .product-nav .box-content {
            border-top: 3px solid #222529;
            display: block;
            padding: 10px 10px 11px
        }

        .product-single-details .product-nav .box-content > span {
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            display: block;
            padding-top: 5px;
            line-height: 1.4em;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            color: #797876
        }

        .product-single-details .product-nav .product-next .product-popup:before {
            right: 7px
        }

        .product-single-details .product-filters-container {
            padding-top: 2px;
            padding-bottom: 1.4rem
        }

        .product-single-details .product-filters-container + .price-box {
            margin-top: 2.2rem;
            margin-bottom: 0.8rem
        }

        .product-single-details .price-box {
            margin-bottom: 2.3rem;
            color: #222529;
            font-weight: 600;
            font-family: Poppins, sans-serif
        }

        .product-single-details .product-filtered-price {
            display: none;
            margin-bottom: 1.3rem;
            margin-top: 0.7rem
        }

        .product-single-details .new-price {
            color: #222529;
            font-size: 2.4rem;
            letter-spacing: -0.02em;
            vertical-align: middle;
            line-height: 0.8;
            margin-left: 3px
        }

        .product-single-details .product-price {
            color: #222529;
            font-size: 2.4rem;
            letter-spacing: -0.02em;
            vertical-align: middle;
            line-height: 0.8
        }

        .product-single-details .old-price {
            position: relative;
            top: 2px;
            color: #a7a7a7;
            font-size: 1.9rem;
            font-weight: 600;
            vertical-align: middle
        }

        .product-single-details .old-price + .product-price {
            margin-left: 0.4rem
        }

        .product-single-details .add-wishlist:before {
            margin-right: 0.3rem
        }

        .product-single-details .short-divider {
            width: 40px;
            height: 0;
            border-top: 2px solid #e7e7e7;
            margin: 0 0 2.2rem;
            text-align: left
        }

        .product-single-details .product-single-filter:last-child {
            display: none;
            margin-bottom: 1rem;
            margin-top: -2px
        }

        .product-single-details .divider + .product-action {
            margin-top: -0.5rem
        }

        .product-single-details .product-action + .divider {
            margin-top: 1.6rem
        }

        .product-single-details .ratings-container {
            margin-bottom: 2.1rem;
            display: flex;
            align-items: center
        }

        .product-single-details .ratings-container .product-ratings,
        .product-single-details .ratings-container .ratings {
            font-size: 1.3rem
        }

        .product-single-details .ratings-container .product-ratings {
            height: 14px;
            margin-left: -1px;
            margin-right: 1px
        }

        .product-single-details .ratings-container .product-ratings:before {
            color: #999
        }

        .product-single-details .ratings-container .ratings:before {
            color: #FD5B5A
        }

        .product-single-details .rating-link {
            color: #999;
            font-size: 1.3rem;
            font-weight: 400;
            padding-left: 1rem
        }

        .product-single-details .rating-link:hover {
            text-decoration: underline
        }

        .product-single-details .rating-link-separator {
            padding-left: 0.9rem;
            font-size: 1.3rem
        }

        .product-single-details .product-desc {
            margin-bottom: 1.8rem;
            font-size: 1.6rem;
            letter-spacing: -0.015em;
            line-height: 1.6875
        }

        .product-single-details .product-desc a {
            color: #222529
        }

        .product-single-details .product-action {
            padding: 1.5rem 0 1.6rem;
            border-top: 1px solid #e7e7e7
        }

        .product-single-details .container {
            align-items: center;
            -ms-flex-align: center
        }

        .product-single-details .container img {
            max-width: 5rem;
            max-height: 5rem;
            margin-right: 2rem
        }

        .product-single-details .product-single-qty {
            margin: 0.5rem 0.5rem 0.5rem 1px
        }

        .product-single-details .product-single-qty .form-control {
            height: 48px;
            font-size: 1.6rem;
            font-weight: 700
        }

        .product-single-details .clear-btn {
            display: inline-block;
            background-color: #f4f4f4;
            margin-top: -3px;
            margin-left: -3px;
            padding: 5px 8px;
            font-size: 1rem;
            color: #777
        }

        .product-single-details .clear-btn:hover {
            background-color: #0f43b0;
            color: #fff
        }

        .product-filters-container select.form-control:not([size]):not([multiple]) {
            margin-bottom: 0;
            height: 42px;
            font-weight: 600
        }

        .product-filters-container .select-custom {
            max-width: 282px;
            width: 100%
        }

        .product-filters-container .select-custom:after {
            right: 1.5rem;
            color: #222529
        }

        .product-both-info .row .col-lg-12 {
            margin-bottom: 12px
        }

        .product-both-info .product-single-details {
            margin-top: 0
        }

        .product-both-info .product-single-details .product-desc {
            border-bottom: 0
        }

        .product-both-info .product-single-gallery .label-group {
            left: 1.8rem
        }

        .single-info-list {
            margin-bottom: 1.7rem;
            padding: 0;
            font-size: 1.2rem;
            line-height: 1.5;
            letter-spacing: 0.005em;
            text-transform: uppercase
        }

        .single-info-list li {
            margin-bottom: 1rem;
            letter-spacing: 0.001em
        }

        .single-info-list li strong {
            color: #222529;
            letter-spacing: 0
        }

        .product-single-filter {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            margin-bottom: 1rem
        }

        .product-single-filter label {
            margin-right: 4.2rem;
            min-width: 5rem;
            margin-bottom: 0;
            color: #777;
            font-weight: 400;
            font-family: "Open Sans", sans-serif;
            letter-spacing: 0.005em;
            text-transform: uppercase
        }

        .product-single-filter .config-swatch-list {
            display: inline-flex;
            margin: 0
        }

        .product-single-filter .config-size-list li {
            margin-bottom: 0;
            margin-right: 0;
            color: #777
        }

        .product-single-filter .config-size-list li a {
            margin: 3px 6px 3px 0;
            min-width: 3.2rem;
            height: 2.6rem;
            border: 1px solid #eee;
            color: inherit;
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 2.6rem;
            background-color: #fff
        }

        .product-single-filter .config-size-list li a:not(.disabled):hover {
            border-color: #0f43b0;
            background-color: #0f43b0;
            color: #fff
        }

        .product-single-filter .config-size-list li a.disabled {
            cursor: not-allowed;
            text-decoration: none;
            background-color: transparent;
            opacity: 0.5
        }

        .product-single-filter .config-size-list li a.filter-color {
            height: 2.8rem;
            min-width: 2.8rem
        }

        .product-single-filter .config-size-list li.active a {
            border-color: #0f43b0;
            outline: none;
            color: #fff;
            background-color: #0f43b0
        }

        .product-single-filter .config-size-list li.active a.filter-color:before {
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            font-family: "porto";
            font-size: 1.1rem;
            line-height: 1;
            content: ""
        }

        .product-single-filter .config-img-list li a {
            height: 100%
        }

        .product-single-filter .config-img-list li img {
            width: 30px;
            height: 30px
        }

        .product-single-filter.product-single-qty {
            max-width: 148px;
            max-height: 7.5rem;
            border-bottom: 0
        }

        .product-single-qty label {
            color: #222529;
            font-weight: 600;
            font-size: 1.5rem
        }

        .product-single-share {
            display: -ms-flexbox;
            display: flex;
            margin-top: 0.7rem;
            -ms-flex-align: center;
            align-items: center;
            flex-wrap: wrap;
            -ms-flex-wrap: wrap
        }

        .product-single-share label {
            margin-right: 1.2rem;
            margin-bottom: 0.5rem;
            color: #222529;
            font-weight: 600;
            font-size: 1.4rem;
            line-height: 1.1;
            font-family: "Open Sans", sans-serif;
            letter-spacing: 0.005em;
            text-transform: uppercase
        }

        .product-single-share .social-icons {
            margin-top: 2px
        }

        .product-single-share .social-icons.vertical {
            display: flex;
            flex-direction: column
        }

        .product-single-share .social-icons.vertical .social-icon {
            border-radius: 0
        }

        .product-single-share .social-icon {
            line-height: 2em;
            border: 2px solid transparent;
            margin: 0.2857em 1px 0.2857em 0
        }

        .product-single-share:not(.icon-with-color) .social-icon {
            border-radius: 50%
        }

        .product-single-share:not(.icon-with-color) .social-icon:not(:hover):not(:active):not(:focus) {
            color: #222529;
            background-color: transparent;
            border-color: #e7e7e7
        }

        .product-single-gallery {
            margin-bottom: 3.3rem
        }

        .product-single-gallery .sticky-slider:not(.sticked) {
            position: relative !important
        }

        .product-single-gallery a {
            display: block
        }

        .product-single-gallery img {
            display: block;
            width: 100%;
            max-width: none
        }

        .product-single-gallery .prod-thumbnail .owl-nav {
            font-size: 1.6rem;
            color: #0f43b0
        }

        .product-single-gallery .prod-thumbnail .owl-nav .owl-prev {
            left: 1.5rem
        }

        .product-single-gallery .prod-thumbnail .owl-nav .owl-next {
            right: 1.5rem
        }

        .product-single-gallery .owl-nav {
            font-size: 2.8rem
        }

        .product-single-gallery .owl-nav .owl-prev {
            left: 2.5rem
        }

        .product-single-gallery .owl-nav .owl-next {
            right: 2.5rem
        }

        .product-single-gallery .owl-nav button {
            transition: opacity 0.5s
        }

        .product-single-gallery .product-item {
            position: relative;
            z-index: 2
        }

        .product-single-gallery .product-item:not(:last-child) {
            margin-bottom: 4px
        }

        .product-single-gallery .product-item:hover .prod-full-screen {
            opacity: 1
        }

        .product-single-gallery .product-single-grid {
            margin-bottom: 3.6rem
        }

        .product-single-gallery .label-group {
            position: absolute;
            z-index: 100;
            top: 1.1rem;
            left: 1.1rem
        }

        .product-single-gallery .product-label {
            display: block;
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
            padding: 7px;
            color: #fff;
            font-weight: 600;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            border-radius: 12px
        }

        .product-single-gallery .product-label.label-hot {
            background-color: #2ba968
        }

        .product-single-gallery .product-label.label-sale {
            background-color: #da5555
        }

        .product-single-gallery .product-label.label-new {
            background-color: #08c
        }

        .prod-thumbnail {
            display: flex;
            display: -ms-flexbox;
            margin: 8px 0 0;
            padding: 0 1px
        }

        .prod-thumbnail > .owl-dot {
            flex: 0 0 25%;
            max-width: 25%;
            padding: 4px
        }

        .prod-thumbnail.owl-theme .owl-nav [class*=owl-]:hover {
            color: #0f43b0
        }

        .prod-thumbnail img {
            width: 100%;
            cursor: pointer
        }

        .prod-thumbnail .owl-dot.active img,
        .prod-thumbnail img:hover {
            border: 2px solid #21293c
        }

        .transparent-dots {
            position: absolute;
            top: 1.6rem;
            left: 2.6rem;
            width: 110px;
            margin: 0;
            padding: 0;
            z-index: 99
        }

        .transparent-dots .owl-dot {
            flex: 1;
            max-width: 108px;
            margin-bottom: 2px
        }

        .transparent-dots .owl-dot img {
            border: 0;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: border-color 0.2s
        }

        .transparent-dots .owl-dot.active img,
        .transparent-dots .owl-dot:hover img {
            border: 1px solid #0f43b0;
            transition: border-color 0.2s
        }

        .product-slider-container:not(.container) {
            position: relative;
            padding-left: 1px;
            padding-right: 1px
        }

        .product-slider-container:not(.container):hover .prod-full-screen {
            opacity: 1
        }

        .product-slider-container:not(.container) button.owl-next:not(.disabled),
        .product-slider-container:not(.container) button.owl-prev:not(.disabled) {
            opacity: 1
        }

        .prod-full-screen {
            position: absolute;
            right: 2rem;
            bottom: 1.7rem;
            transition: all 0.5s;
            outline: none;
            opacity: 0;
            z-index: 1
        }

        .prod-full-screen i {
            color: #000;
            font-size: 1.4rem;
            cursor: pointer
        }

        .product-single-tabs .tab-pane {
            padding-top: 3rem;
            padding-bottom: 3rem;
            color: #7b858a;
            line-height: 1.92
        }

        .product-single-tabs .nav.nav-tabs .nav-link {
            color: #818692
        }

        .product-single-tabs .nav.nav-tabs .nav-link.active {
            color: #222529
        }

        .product-single-tabs .nav.nav-tabs .nav-link {
            font-family: "Open Sans", sans-serif;
            font-size: 1.3rem
        }

        .product-single-tabs .nav.nav-tabs .nav-link.active,
        .product-single-tabs .nav.nav-tabs .nav-link:hover {
            border-bottom-color: #222529
        }

        .product-single-tabs .nav-item {
            font-size: 1.3rem
        }

        .scrolling-box .tab-pane + .tab-pane {
            margin-top: 3.5rem;
            border-top: 2px solid #dae2e6
        }

        .product-size-content {
            padding-top: 2rem;
            padding-bottom: 0.5rem
        }

        .product-size-content img {
            margin: 0 auto 2rem
        }

        .product-desc-content {
            margin-bottom: 2.5rem
        }

        .product-desc-content .feature-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.9rem;
            border-style: solid;
            border-width: 2px;
            width: 64px;
            height: 64px;
            line-height: 60px;
            border-radius: 60px;
            font-size: 28px;
            color: #0f43b0;
            background: transparent;
            border-color: #0f43b0
        }

        .product-desc-content .feature-box p {
            font-size: 14px;
            line-height: 27px;
            color: #4a505e;
            letter-spacing: 0
        }

        .product-desc-content .feature-box h3 {
            margin-bottom: 0.8rem;
            font-size: 1.4rem
        }

        .product-desc-content p {
            margin-bottom: 2.3rem;
            letter-spacing: 0.005em
        }

        .product-desc-content ol,
        .product-desc-content ul {
            margin-bottom: 2.4rem;
            padding-left: 7.4rem;
            letter-spacing: 0.005em;
            position: relative;
            padding-top: 2px
        }

        .product-desc-content li {
            margin-bottom: 9px;
            letter-spacing: 0
        }

        .product-desc-content li:before {
            content: "";
            position: absolute;
            left: 4rem;
            display: inline-block;
            margin-top: -2px;
            vertical-align: middle;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-right: 1.8rem;
            color: #21293c;
            font-size: 1.6rem
        }

        .product-desc-content img.float-left,
        .product-desc-content img.float-right {
            max-width: 50%
        }

        .product-desc-content img {
            padding-top: 4px
        }

        .product-desc-content .feature-box i {
            display: inline-block;
            font-size: 2.8rem;
            float: none;
            margin-bottom: 0;
            margin-top: 3px
        }

        .product-desc-content .feature-box-content {
            margin-left: 0
        }

        .table.table-striped {
            margin-top: 2rem;
            margin-bottom: 5.9rem
        }

        .table.table-striped td,
        .table.table-striped th {
            padding: 1.1rem 1.2rem
        }

        .table.table-striped tr:nth-child(odd) {
            background-color: #f9f9f9
        }

        .product-tags-content h4 {
            margin: 0 0 2rem;
            font-size: 1.8rem;
            font-weight: 700;
            text-transform: uppercase
        }

        .product-tags-content form {
            margin-bottom: 2rem
        }

        .product-tags-content .form-group {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: stretch;
            align-items: stretch
        }

        .product-tags-content .form-control {
            margin-right: 10px
        }

        .product-tags-content .btn {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .product-reviews-content {
            padding-top: 2px;
            padding-bottom: 2.5rem;
            line-height: 1.92
        }

        .product-reviews-content .required {
            color: #222529
        }

        .product-reviews-content .reviews-title {
            margin-bottom: 1.6rem;
            font-size: 2rem;
            font-weight: 400
        }

        .product-reviews-content .reviews-title + p {
            padding-bottom: 0.4rem;
            letter-spacing: 0.005em
        }

        .product-reviews-content .ratings-container {
            margin: -3px -2px 0.5rem 0
        }

        .product-reviews-content .divider {
            border-top: 1px solid #e7e7e7;
            margin: 4rem 0
        }

        .product-reviews-content .comments .comment-block {
            padding-bottom: 2.3rem;
            background-color: #f5f7f7
        }

        .comment-container {
            display: flex;
            display: -ms-flexbox;
            padding: 29px 0 8px
        }

        .comment-container:not(:first-child) {
            border-top: 1px solid #e7e7e7
        }

        .comment-container .comment-avatar {
            flex: 1 0 auto;
            padding: 0 22px 5px 8px
        }

        .comment-container img {
            border-radius: 10rem
        }

        .comment-container .ratings-container {
            margin-bottom: 6px
        }

        .comment-container .product-ratings,
        .comment-container .ratings {
            font-size: 14px
        }

        .comment-container .product-ratings:before {
            color: #999
        }

        .comment-container .ratings:before {
            color: #FD5B5A
        }

        .comment-container .comment-info {
            font-family: "Open Sans", sans-serif;
            font-size: 1.4rem;
            line-height: 1;
            letter-spacing: -0.02em
        }

        .comment-container .avatar-name {
            display: inline;
            font-family: inherit;
            font-size: inherit
        }

        .comment-container .comment-text {
            letter-spacing: -0.015em
        }

        .add-product-review {
            padding-top: 5px
        }

        .add-product-review .custom-checkbox .custom-control-input:checked ~ .custom-control-label:after {
            top: 4px;
            left: 2px
        }

        .add-product-review form {
            padding: 3.5rem 2rem 3.3rem;
            border-radius: 3px;
            background-color: #f4f4f4
        }

        .add-product-review h3 {
            margin-bottom: 1.6rem;
            font-size: 2rem;
            font-weight: 400;
            letter-spacing: -0.01em
        }

        .add-product-review label {
            display: block;
            font-family: "Open Sans", sans-serif;
            font-size: 1.4rem;
            line-height: 1;
            margin-bottom: 1.1rem
        }

        .add-product-review .rating-stars {
            margin-bottom: 1rem
        }

        .add-product-review .form-control {
            margin-top: 1.4rem;
            margin-bottom: 1.6rem;
            font-size: 1.4rem;
            max-width: 100%;
            height: 37px
        }

        .add-product-review textarea.form-control {
            min-height: 170px
        }

        .add-product-review .btn {
            padding: 0.55em 1rem 0.5em;
            font-weight: 400;
            text-transform: none;
            font-family: "Open Sans", sans-serif
        }

        .add-product-review .custom-control-label {
            letter-spacing: 0.005em;
            line-height: 1.9
        }

        .add-product-review .custom-control-label:after,
        .add-product-review .custom-control-label:before {
            top: 6px;
            left: 0;
            width: 15px;
            height: 15px;
            font-size: 1.2rem;
            font-weight: 300
        }

        .add-product-review .custom-checkbox .custom-control-input:checked ~ .custom-control-label:before {
            background-color: #0075ff;
            border-color: #0075ff
        }

        .add-product-review .custom-checkbox .custom-control-input:checked ~ .custom-control-label:after {
            color: #fff
        }

        .add-product-review .custom-control {
            padding-left: 2.2rem;
            margin-bottom: 1rem;
            margin-top: -6px
        }

        .rating-stars {
            display: flex;
            display: -ms-flexbox;
            position: relative;
            height: 14px;
            font-size: 1.4rem;
            margin-bottom: 2.8rem
        }

        .rating-stars a {
            color: #706f6c;
            text-indent: -9999px;
            letter-spacing: 1px;
            width: 16px
        }

        .rating-stars a:before {
            content: "";
            position: absolute;
            left: 0;
            height: 14px;
            line-height: 1;
            font-family: "Font Awesome 5 Free";
            text-indent: 0;
            overflow: hidden;
            white-space: nowrap
        }

        .rating-stars a.active:before,
        .rating-stars a:hover:before {
            content: "";
            font-weight: 900
        }

        .rating-stars .star-1 {
            z-index: 10
        }

        .rating-stars .star-2 {
            z-index: 9
        }

        .rating-stars .star-3 {
            z-index: 8
        }

        .rating-stars .star-4 {
            z-index: 7
        }

        .rating-stars .start-5 {
            z-index: 6
        }

        .rating-stars .star-1:before {
            width: 16px
        }

        .rating-stars .star-2:before {
            width: 32px
        }

        .rating-stars .star-3:before {
            width: 48px
        }

        .rating-stars .star-4:before {
            width: 64px
        }

        .rating-stars .star-5:before {
            content: ""
        }

        .products-section {
            padding-top: 3.8rem;
            padding-bottom: 3rem
        }

        .products-section .owl-carousel.dots-top .owl-dots {
            margin: 0px -2px 3.5rem
        }

        .products-section .owl-carousel.dots-top .owl-dots span {
            border-color: rgba(0, 68, 102, 0.4)
        }

        .products-section .owl-carousel.dots-top .owl-dot.active span {
            border-color: #0f43b0
        }

        .products-section .product-title {
            margin-bottom: 4px
        }

        .products-section .price-box {
            margin-bottom: 1.4rem
        }

        .products-section h2 {
            font-family: "Poppins";
            padding-bottom: 1rem;
            border-bottom: 1px solid #e7e7e7;
            margin-bottom: 3.4rem;
            font-size: 1.8rem;
            line-height: 22px;
            letter-spacing: -0.01em;
            text-transform: uppercase
        }

        .products-section.pt-sm {
            padding-top: 2.5rem
        }

        .product-sidebar-right {
            margin-bottom: 1.7rem
        }

        .product-sidebar-right .product-single-gallery {
            margin-bottom: 2.7rem
        }

        .product-sidebar-right .product-single-details {
            margin-bottom: 0.6rem
        }

        .product-sidebar-right .product-desc-content p {
            margin-bottom: 1.3rem;
            letter-spacing: 0.005em
        }

        .product-sidebar-right .product-desc-content ul {
            margin-bottom: 2rem;
            padding-left: 5.8rem
        }

        .product-sidebar-right .product-desc-content li:before {
            left: 2.4rem
        }

        .products-section .container-fluid {
            padding-right: 20px;
            padding-left: 20px
        }

        .custom-product-filters .config-size-list li a {
            height: 28px;
            font-size: 13px;
            border: 1px solid #e9e9e9;
            color: #222529;
            background-color: #f4f4f4
        }

        .custom-product-filters .config-color-list img {
            width: 30px;
            height: 30px
        }

        .custom-product-filters .config-color-list li a {
            height: 100%
        }

        .single-product-custom-block .porto-heading {
            padding: 0.85em 2em;
            margin-bottom: 1.7rem;
            box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.1);
            margin-right: 20px;
            font-family: "Open Sans", sans-serif;
            font-weight: 600;
            font-size: 1.2rem
        }

        .custom-product-single-share {
            position: absolute;
            top: 0;
            right: 0rem
        }

        .custom-product-single-share .social-icon {
            display: block;
            margin: 0;
            margin-bottom: 2px;
            border-radius: 0
        }

        .custom-product-single-tabs {
            padding: 7rem 0 3rem
        }

        .custom-product-single-tabs .add-product-review form {
            background-color: #f7f7f7
        }

        .custom-product-single-tabs .product-desc-content ol,
        .custom-product-single-tabs .product-desc-content ul {
            margin-bottom: 2rem;
            padding-left: 5.8rem
        }

        .custom-product-single-tabs .product-desc-content li:before {
            left: 2.4rem
        }

        .custom-product-single-tabs .product-desc-content p {
            margin-bottom: 1.3rem
        }

        .custom-product-single-tabs .nav.nav-tabs .nav-link {
            font-size: 1.5rem;
            padding: 1.1rem 0 1rem;
            margin-right: 1.5rem;
            background-color: transparent
        }

        .product-single-tab-two .product-desc-content p {
            margin-bottom: 1.3rem
        }

        .product-single-tab-two .product-desc-content ul {
            margin-bottom: 2rem;
            padding-left: 5.8rem
        }

        .product-single-tab-two .product-desc-content li:before {
            left: 2.4rem
        }

        .product-left-sidebar .product-single-details {
            margin-bottom: 0.8rem
        }

        .table.table-size tbody tr td,
        .table.table-size thead tr th {
            border: 0;
            color: #21293c;
            font-size: 1.4rem;
            letter-spacing: 0.005em;
            text-transform: uppercase
        }

        .table.table-size thead tr th {
            padding: 2.8rem 1.5rem 1.7rem;
            background-color: #f4f4f2;
            font-weight: 600
        }

        .table.table-size tbody tr td {
            padding: 1.1rem 1.5rem;
            background-color: #fff;
            font-weight: 700
        }

        .table.table-size tbody tr:nth-child(2n) td {
            background-color: #ebebeb
        }

        @media (max-width: 1199px) {
            .transparent-dots {
                width: 90px
            }
        }

        @media (min-width: 768px) {
            .custom-product-single-tabs .nav.nav-tabs .nav-item {
                margin-bottom: -3px
            }

            .custom-product-single-tabs .nav.nav-tabs .nav-link {
                padding: 1.1rem 0 1rem;
                font-size: 1.8rem;
                margin-right: 1.5rem
            }

            .products-section {
                padding-top: 4.8rem;
                padding-bottom: 3.6rem
            }

            .product-both-info .product-single-share {
                -ms-flex-pack: end;
                justify-content: flex-end
            }

            .add-product-review form {
                padding-left: 3rem;
                padding-right: 3rem
            }

            .product-both-info-bottom .col-md-4:last-child strong {
                order: 2;
                margin-left: 20px;
                margin-right: 0
            }
        }

        @media (min-width: 992px) {
            .product-both-info .row .col-lg-12 {
                margin-bottom: 4px
            }

            .main-content .col-lg-7 {
                -ms-flex: 0 0 54%;
                flex: 0 0 54%;
                max-width: 54%
            }

            .main-content .col-lg-5 {
                -ms-flex: 0 0 46%;
                flex: 0 0 46%;
                max-width: 46%
            }

            .product-full-width {
                padding-right: 3.5rem
            }

            .product-full-width .product-single-details .product-title {
                font-size: 4rem
            }

            .table.table-size thead tr th {
                padding-top: 2.9rem;
                padding-bottom: 2.9rem
            }

            .table.table-size tbody tr td,
            .table.table-size thead tr th {
                padding-right: 4.2rem;
                padding-left: 3rem
            }
        }

        @media (min-width: 1200px) {
            .product-both-info .product-single-share {
                margin-top: -13px
            }
        }

        @media (max-width: 991px) {
            .single-product-custom-block {
                margin-right: 4rem
            }

            .single-product-custom-block .porto-heading {
                padding: 0.85em 1em;
                margin-bottom: 0.7rem;
                margin-right: 1rem
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .product-all-icons.product-action .product-single-qty {
                margin-right: 50%;
                margin-bottom: 1.2rem
            }
        }

        @media (min-width: 576px) {
            .product-tags-content .form-control {
                width: 250px
            }
        }

        @media (max-width: 767px) {
            .product-size-content .table.table-size {
                margin-top: 3rem
            }
        }

        @media (max-width: 575px) {
            .transparent-dots {
                width: 70px
            }

            .rating-stars a:before {
                line-height: 1.2
            }

            .ratings-container .product-ratings,
            .ratings-container .ratings {
                line-height: 1.2
            }
        }

        @media (max-width: 480px) {
            .pg-vertical .product-thumbs-wrap {
                height: 165px
            }

            .pg-vertical .vertical-thumbs {
                max-width: 48px
            }

            .pg-vertical .product-slider-container {
                max-width: calc(100% - 53px)
            }

            .product-size-content .table.table-size td,
            .product-size-content .table.table-size th {
                padding-left: 1rem;
                padding-right: 0.5rem;
                font-size: 1.2rem
            }

            .product-reviews-content .reviews-title {
                font-size: 1.7rem
            }

            .custom-product-single-tabs .nav.nav-tabs .nav-item:not(:last-child) {
                margin-right: 0
            }

            .custom-product-single-tabs .nav.nav-tabs .nav-link {
                font-size: 1.4rem
            }
        }

        .sidebar-product .widget.widget-product-categories {
            margin-bottom: 3rem;
            padding: 1.8rem 1.5rem 1.3rem;
            border: 1px solid #e7e7e7
        }

        .sidebar-product .widget.widget-product-categories .widget-body {
            padding: 2px 0 0.5rem 1.4rem
        }

        .sidebar-product .widget.widget-product-categories .widget-body:after {
            display: block;
            clear: both;
            content: ""
        }

        .sidebar-product .widget.widget-product-categories .cat-list li {
            margin-bottom: 0.5rem
        }

        .sidebar-product .widget.widget-product-categories .cat-list li:last-child {
            margin-bottom: -2px
        }

        .sidebar-product .widget.widget-product-categories a {
            display: block;
            position: relative;
            padding: 4px 0;
            color: #7a7d82;
            font-weight: 600
        }

        .sidebar-product .widget.widget-product-categories .widget-title {
            color: #7a7d82;
            font-weight: 600;
            font-size: 14px;
            font-family: "Open Sans", sans-serif;
            line-height: 24px
        }

        .sidebar-product .widget-title a:after {
            content: "";
            display: inline-block;
            position: absolute;
            top: 46%;
            right: 2px;
            transform: translateY(-50%);
            transition: all 0.35s;
            font-family: "porto";
            font-size: 1.7rem;
            font-weight: 600;
            color: #222529
        }

        .sidebar-product .widget-title a.collapsed:after {
            content: ""
        }

        .sidebar-product .sidebar-toggle {
            position: fixed;
            padding-left: 10px;
            top: 50%;
            z-index: 9999;
            left: 0
        }

        .custom-sidebar-toggle {
            display: flex;
            position: fixed;
            padding: 0;
            align-items: center;
            justify-content: center;
            top: 20%;
            left: 0;
            width: 40px;
            height: 40px;
            transition: left 0.2s ease-in-out 0s;
            border: #dcdcda solid 1px;
            border-left-width: 0;
            background: #fff;
            font-size: 17px;
            line-height: 38px;
            text-align: center;
            cursor: pointer;
            z-index: 999;
            margin-top: 50px
        }

        .sidebar-opened .custom-sidebar-toggle {
            left: 260px;
            z-index: 9000
        }

        .sidebar-opened .custom-sidebar-toggle i:before {
            content: ""
        }

        .sidebar-product {
            margin-bottom: 2.8rem
        }

        .sidebar-product .widget:not(:last-child):not(.widget-info) {
            margin-bottom: 2.9rem
        }

        .sidebar-product .widget-info {
            margin: 0px 0 4.8rem
        }

        .sidebar-product .widget-info li {
            display: flex;
            align-items: center;
            margin-bottom: 2.2rem
        }

        .sidebar-product .widget-info i {
            margin: 1px 1.9rem 0 4px
        }

        .sidebar-product .widget-featured {
            padding-bottom: 3rem
        }

        .sidebar-product .widget-featured .widget-body {
            padding-top: 1.9rem
        }

        .sidebar-product .widget-featured .owl-carousel .owl-nav {
            top: -4.1rem
        }

        .sidebar-product .widget-title {
            margin: 0;
            text-transform: none;
            border-bottom-width: 1px;
            font-weight: 600;
            font-size: 1.5rem;
            line-height: 24px
        }

        .sidebar-product .widget-subtitle {
            color: #7a7d82;
            margin-bottom: 3rem;
            font-size: 1.3rem;
            font-weight: 400
        }

        .sidebar-product .widget-body {
            padding-left: 0;
            padding-top: 2.3rem
        }

        .sidebar-product .widget-body p {
            line-height: 27px;
            font-size: 1.3rem;
            color: #222529;
            letter-spacing: 0.01em;
            font-weight: 500;
            margin-bottom: 3rem
        }

        .sidebar-product .product-widget {
            margin-bottom: 1.3rem
        }

        .sidebar-product .product-widget figure {
            margin-right: 0.8rem;
            max-width: 75px
        }

        .sidebar-product .product-widget .widget-body {
            padding-top: 1.9rem
        }

        .sidebar-product .ratings-container {
            margin-left: 0;
            margin-bottom: 1.2rem
        }

        .sidebar-product .owl-carousel .owl-nav {
            top: -4.1rem;
            right: 1px
        }

        .sidebar-product .owl-carousel .owl-nav button.owl-next,
        .sidebar-product .owl-carousel .owl-nav button.owl-prev {
            font-size: 1.8rem
        }

        .widget-info ul {
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            -ms-flex-align: center;
            justify-content: space-between;
            -ms-flex-pack: justify;
            flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            margin: 0
        }

        aside .widget-info ul {
            display: block
        }

        .widget-info li {
            margin-bottom: 2rem
        }

        .widget-info li:not(:last-child) {
            margin-right: 2.5rem
        }

        aside .widget-info li:not(:last-child) {
            border-bottom: 1px solid rgba(231, 231, 231, 0.8);
            padding-bottom: 2.2rem;
            margin-right: 0
        }

        .widget-info i {
            min-width: 40px;
            margin-right: 15px;
            color: #0f43b0;
            font-size: 4rem;
            line-height: 1
        }

        .widget-info i:before {
            margin: 0
        }

        aside .widget-info i {
            margin-left: 7px
        }

        .widget-info h4 {
            display: inline-block;
            margin-bottom: 0;
            color: #6b7a83;
            font-weight: 600;
            font-size: 1.4rem;
            line-height: 1.286;
            font-family: "Open Sans", sans-serif;
            text-transform: uppercase
        }

        .product-single-collapse {
            line-height: 1.9;
            margin-bottom: 3.2rem;
            margin-top: -3px
        }

        .product-single-collapse p {
            margin-bottom: 1.3rem
        }

        .product-single-collapse .collapse-body-wrapper {
            padding-top: 3.1rem;
            padding-bottom: 2px
        }

        .product-single-collapse .product-desc-content {
            margin-bottom: 1.3rem
        }

        .product-single-collapse .product-desc-content ol,
        .product-single-collapse .product-desc-content ul {
            padding-left: 5.8rem;
            margin-bottom: 2rem
        }

        .product-single-collapse .product-desc-content li:before {
            left: 2.4rem
        }

        .product-collapse-title {
            margin: 0;
            font-size: 1.4rem;
            line-height: 1;
            text-transform: uppercase
        }

        .product-collapse-title a {
            display: flex;
            align-items: center;
            position: relative;
            padding: 1.4rem 1.5rem 1.5rem;
            border-bottom: 1px solid #ddd;
            color: inherit
        }

        .product-collapse-title a:focus,
        .product-collapse-title a:hover {
            color: inherit;
            text-decoration: none
        }

        .product-collapse-title a:before {
            content: "";
            margin-right: 1rem;
            font-family: "porto";
            font-size: 2rem;
            font-weight: 400
        }

        .product-collapse-title a:after {
            display: block;
            position: absolute;
            bottom: -0.2rem;
            left: 0;
            width: 100%;
            height: 0.2rem;
            transform-origin: left center;
            transform: scale(1, 1);
            transition: transform 0.4s;
            background-color: #0f43b0;
            content: ""
        }

        .product-collapse-title a.collapsed:before {
            content: ""
        }

        .product-collapse-title a.collapsed:after {
            transform-origin: right center;
            transform: scale(0, 1)
        }

        .collapse-body-wrapper {
            padding: 3rem 0 1.5rem 2rem
        }

        .maga-sale-container {
            font-family: "Oswald";
            position: relative
        }

        .maga-sale-container .mega-content {
            margin: 1.1rem;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            text-align: center;
            border: 1px solid #f6f5f0
        }

        .maga-sale-container .mega-price-box {
            position: relative;
            display: flex;
            margin: 4.4rem 0.5rem 2.4rem 0;
            align-items: center;
            justify-content: center;
            color: #fff
        }

        .maga-sale-container .mega-price-box .price-big {
            font-size: 4rem;
            margin-right: 5px;
            z-index: 1
        }

        .maga-sale-container .mega-price-box .price-desc {
            display: flex;
            flex-direction: column;
            font-size: 1.4rem;
            line-height: 1.1;
            z-index: 1
        }

        .maga-sale-container .mega-price-box em {
            font-size: 1.8rem;
            font-style: unset
        }

        .maga-sale-container .mega-price-box:after,
        .maga-sale-container .mega-price-box:before {
            position: absolute;
            content: "";
            display: block;
            width: 94px;
            border: 0 solid #0f43b0;
            border-width: 50px 0;
            border-bottom-color: transparent;
            border-radius: 50%
        }

        .maga-sale-container .mega-price-box:before {
            transform: rotate(-60deg);
            top: -34%
        }

        .maga-sale-container .mega-price-box:after {
            transform: rotate(120deg);
            margin-left: 8px;
            top: -41%
        }

        .maga-sale-container .mega-title {
            margin-left: 0.8rem;
            transform: scaleX(0.6);
            font-size: 3.8rem;
            letter-spacing: 0.07em;
            line-height: 1.1;
            color: #113952
        }

        .maga-sale-container .mega-subtitle {
            margin-left: 0.8rem;
            font-size: 1.6rem;
            letter-spacing: 0.17em;
            color: #113952
        }

        .custom-maga-sale-container {
            margin-bottom: 3.4rem
        }

        .custom-maga-sale-container .mega-price-box {
            margin: 4.2rem 0.8rem 3rem 0
        }

        .custom-maga-sale-container .mega-price-box .price-big {
            font-size: 4.7rem;
            margin-right: 5px;
            margin-top: 2px
        }

        .custom-maga-sale-container .mega-price-box .price-desc {
            font-size: 1.6rem
        }

        .custom-maga-sale-container .mega-price-box em {
            font-size: 2.2rem;
            margin-bottom: 1px;
            margin-top: 3px
        }

        .custom-maga-sale-container .mega-price-box:after,
        .custom-maga-sale-container .mega-price-box:before {
            width: 120px;
            border-width: 60px 0
        }

        .custom-maga-sale-container .mega-price-box:after {
            margin-left: 9px
        }

        .custom-maga-sale-container .mega-title {
            margin-left: 0;
            font-size: 4.4rem;
            white-space: nowrap;
            padding-top: 4px;
            margin-right: 1.5rem
        }

        .custom-maga-sale-container .mega-subtitle {
            font-size: 1.9rem;
            margin-left: 0;
            letter-spacing: 0.1em
        }

        @media (min-width: 992px) {
            .main-content-wrap {
                overflow: hidden
            }

            .main-content-wrap .main-content {
                margin-left: -25%;
                transition: 0.15s linear
            }

            .main-content-wrap .sidebar-shop {
                left: -25%;
                transition: 0.15s linear;
                visibility: hidden;
                z-index: -1
            }

            .sidebar-opened .main-content-wrap > .sidebar-shop {
                left: 0;
                visibility: visible;
                z-index: 0
            }

            .sidebar-opened .main-content-wrap > .main-content {
                margin-left: 0
            }

            body:not(.sidebar-opened) .main-content-wrap > .main-content {
                max-width: 100%;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%
            }

            .sidebar-toggle {
                display: none
            }
        }

        @media (min-width: 576px) {
            .sidebar-product .widget.widget-product-categories {
                padding: 2.4rem 3rem 2.5rem
            }
        }

        @media (max-width: 1199px) {
            .maga-sale-container .mega-title {
                font-size: 3rem
            }

            .custom-maga-sale-container .mega-price-box:after,
            .custom-maga-sale-container .mega-price-box:before {
                width: 100px;
                border-width: 52px 0
            }

            .custom-maga-sale-container .mega-price-box .price-big {
                margin-top: -3px
            }

            .maga-sale-container .mega-title {
                margin-right: 0
            }
        }

        @media (max-width: 991px) {
            .mobile-sidebar {
                display: block;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: 260px;
                padding: 2rem;
                margin: 0;
                transform: translate(-260px);
                transition: transform 0.2s ease-in-out 0s;
                background-color: #fff;
                z-index: 9999;
                overflow-y: auto
            }

            .sidebar-opened .mobile-sidebar {
                transform: none
            }

            .sidebar-opened .sidebar-overlay {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: #000;
                opacity: 0.35;
                z-index: 8999
            }
        }

        @media (max-width: 575px) {
            .widget-info ul {
                display: block
            }
        }

        .section-sub-title,
        .section-title {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            color: #313131;
            font-family: "Open Sans", sans-serif;
            font-weight: 600;
            font-size: 1.6rem;
            line-height: 23px;
            text-transform: none
        }

        .banner img {
            object-fit: cover
        }

        .intro-section {
            position: relative
        }

        .home-slide {
            height: 532px;
            padding: 1.5rem;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover
        }

        .home-slide h2 {
            color: #444;
            font-family: "Open Sans", sans-serif;
            font-size: 1.6875em;
            line-height: 1.2;
            letter-spacing: -0.01em
        }

        .home-slide h1 {
            font-size: 3.75em;
            line-height: 1.2;
            letter-spacing: -0.05em;
            margin-left: -3px;
            margin-bottom: 7px
        }

        .home-slide .btn {
            padding: 1.25em 3.125em;
            font-family: "Open Sans", sans-serif;
            font-size: 1.6rem;
            font-weight: 600;
            line-height: 1.42857
        }

        .home-slide .banner-layer {
            left: 0;
            right: 0
        }

        .home-slider-sidebar {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            transform: translateY(-50%);
            z-index: 1
        }

        .home-slider-sidebar ul {
            font-size: 1.7rem;
            white-space: nowrap;
            font-weight: 600;
            padding: 0;
            position: absolute;
            right: 20px;
            top: 50%;
            margin-top: -63px;
            color: #171f2f
        }

        .home-slider-sidebar li {
            position: relative;
            padding-right: 35px;
            margin-bottom: 15px;
            text-align: right;
            cursor: pointer;
            line-height: 27px
        }

        .home-slider-sidebar li.active {
            color: #ff6840
        }

        .home-slider-sidebar li:after {
            content: "";
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            border-top: 2px solid;
            width: 16px
        }

        .featured-products-section {
            padding: 7rem 0 3.4rem
        }

        .cat-section {
            padding: 7rem 0 5rem
        }

        .cat-section .product-category {
            padding: 3.9rem 0 3.5rem;
            background: #fff;
            transition: box-shadow 0.2s
        }

        .cat-section .product-category:hover {
            box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.1)
        }

        .cat-section .product-category:hover i {
            color: #f67434
        }

        .cat-section .product-category:hover h3 {
            color: #ff6840
        }

        .category-content {
            padding: 0
        }

        .category-content i {
            margin-bottom: 1.5rem;
            color: #222529;
            font-size: 4.2rem;
            line-height: 1
        }

        .category-content h3 {
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: none
        }

        .categories-slider .owl-stage-outer {
            margin: -1rem;
            padding: 1rem
        }

        .new-products-section {
            padding: 7rem 0 2.1rem
        }

        .new-products-section .banner,
        .new-products-section .container > .row:last-child {
            margin-bottom: 3.5rem
        }

        .banner1 img,
        .banner2 img {
            min-height: 190px
        }

        .banner1 h3,
        .banner2 h3 {
            font-size: 2.1875em;
            line-height: 1.2
        }

        .banner1 h4,
        .banner2 h4 {
            margin-bottom: 1.4rem;
            color: #444444;
            font-size: 1em;
            line-height: 19px
        }

        .banner1 h4 b,
        .banner2 h4 b {
            display: block;
            font-size: 1.425em;
            line-height: 1.5
        }

        .banner1 .btn,
        .banner2 .btn {
            padding: 0.8rem 2rem;
            font-family: "Open Sans", sans-serif;
            font-size: 1.2rem
        }

        .banner1 .banner-layer,
        .banner2 .banner-layer {
            left: 15px;
            right: 15px;
            margin: 0
        }

        .special-offer-section {
            padding: 7rem 0 2.5rem
        }

        .special-offer-section .subtitle {
            padding: 1.6rem 0 1.9rem;
            border-bottom: 1px solid #eaeaea;
            font-weight: 600;
            font-size: 1.8rem;
            line-height: 24px
        }

        .special-offer-section .nav-tabs .nav-item .nav-link {
            padding: 1.5rem 1.8rem;
            background: transparent;
            border-bottom-width: 3px;
            font-family: "Open Sans", sans-serif;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            line-height: 1.6875;
            text-transform: none
        }

        .special-offer-section .nav-tabs .nav-item:not(:last-child) {
            margin-right: 1px
        }

        .banner3 {
            max-width: 450px
        }

        .banner3 img {
            min-height: 220px
        }

        .banner3 h3 {
            font-size: 1.5em;
            text-indent: -2px
        }

        .banner3 h4 {
            font-size: 1.375em;
            font-weight: 600
        }

        .banner3 del {
            font-size: 80%;
            color: #aeaeae;
            margin-right: 7px
        }

        .banner3 .btn {
            padding: 1em 2.5em;
            font-family: "Open Sans", sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: -0.01em
        }

        .banner3 .banner-layer-left {
            left: 12%;
            margin-top: 5px
        }

        .cat-banners-section {
            padding: 4.8rem 0 2.8rem
        }

        .cat-banner {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 2rem;
            padding: 3.2rem;
            border: 1px solid #e7e7e7;
            font-size: 1.6rem
        }

        .cat-banner figure {
            flex: 1;
            margin-bottom: 0
        }

        .cat-banner img {
            display: inline-block
        }

        .cat-banner h3 {
            font-family: "Open Sans", sans-serif;
            font-size: 1.0625em;
            line-height: 20px;
            white-space: nowrap
        }

        .cat-banner .btn {
            font-family: "Open Sans", sans-serif;
            font-size: 0.75em;
            letter-spacing: -0.025em;
            padding: 0.8rem 2rem
        }

        .cat-banner .cat-content {
            flex: 1
        }

        .feature-boxes-container {
            padding: 8rem 0 6rem
        }

        .feature-box i {
            margin-bottom: 2.7rem;
            font-size: 5rem
        }

        .feature-box h3 {
            margin-bottom: 3px;
            font-size: 1.8rem;
            line-height: 1.5
        }

        .feature-box h5 {
            color: #21293c;
            font-weight: 600;
            font-size: 1.7rem;
            line-height: 1.6875
        }

        .feature-box p {
            font-size: 1.6rem;
            line-height: 1.625
        }

        .product-widgets-container {
            padding: 7rem 0 5.5rem
        }

        .product-widgets-container .section-sub-title {
            padding-top: 1.6rem
        }

        .product-widgets-container .product-widget figure {
            margin-right: 0.7rem
        }

        .product-widgets-container .product-widget .product-title {
            font-family: "Open Sans", sans-serif;
            font-size: 0.9em
        }

        .product-widgets-container .product-widget .product-price {
            font-size: 1.3rem
        }

        .product-widgets-container .product-widget .old-price {
            color: #444;
            font-size: 1.1rem
        }

        .product-widgets-container .product-widget .ratings-container {
            margin-bottom: 1rem
        }

        .product-widgets-container.lg-images .product-widget figure {
            max-width: 84px;
            margin-right: 1.2rem
        }

        .count-down {
            border: 3px solid #0f43b0;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            margin-bottom: 2.8rem
        }

        .count-down figure {
            max-width: 100%;
            margin-bottom: 0;
            margin-right: 0
        }

        .count-down .product-name {
            position: absolute;
            left: 0;
            right: 0;
            top: 1.6rem;
            z-index: 1;
            margin-bottom: 0;
            font-family: "Open Sans", sans-serif;
            font-size: 1.6rem;
            line-height: 27px
        }

        .count-down .product-details {
            padding: 0.4rem 1.6rem 4.8rem
        }

        .count-down .product-title {
            margin-bottom: 0.5rem;
            font-family: "Open Sans", sans-serif;
            font-size: 1.6rem;
            letter-spacing: -0.01em
        }

        .count-down .ratings-container {
            margin-bottom: 1.3rem
        }

        .count-down .old-price {
            letter-spacing: inherit
        }

        .count-down .product-price {
            font-size: 1.8rem
        }

        .count-down .label-group {
            left: auto;
            top: -2px;
            right: -2px
        }

        .count-down .product-label {
            border-radius: 0
        }

        .count-down .label-primary {
            background-color: #0f43b0;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.1px;
            line-height: 1;
            padding: 5px 11px;
            margin-bottom: 0
        }

        .count-down .label-dark {
            background-color: #222529;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.1px;
            line-height: 16px
        }

        .count-down:hover {
            box-shadow: none
        }

        .count-down:hover img {
            transform: none
        }

        .count-down .product-countdown-container {
            align-items: center;
            position: absolute;
            bottom: -13rem;
            left: 15%;
            right: 15%;
            padding: 5px;
            color: #444;
            background: #f4f4f4;
            border-radius: 3.2rem;
            line-height: 27px;
            opacity: 1
        }

        .count-down .product-countdown-title {
            color: #444;
            font-family: Oswald, sans-serif;
            font-size: 1.1rem;
            letter-spacing: -0.01em;
            text-transform: uppercase
        }

        .count-down .product-countdown {
            color: #444;
            font-size: 1.3rem;
            font-family: Oswald, sans-serif;
            letter-spacing: -0.01em
        }

        .brands-slider {
            margin-bottom: 4.8rem
        }

        @media (min-width: 992px) {
            .banner1 .col-lg-4:first-child,
            .banner2 .col-lg-4:last-child {
                padding-left: 3rem
            }

            .banner1 .col-lg-4:last-child {
                padding-left: 4rem
            }

            .banner2 .col-lg-4:first-child {
                padding-right: 4rem
            }
        }

        @media (min-width: 1200px) {
            .cat-banner {
                font-size: 0.83333vw
            }
        }

        @media (min-width: 1440px) {
            .special-offer-section .nav-tabs .nav-item .nav-link {
                padding-left: 2.2rem;
                padding-right: 2.2rem
            }

            .cat-banner figure {
                min-width: 139px
            }
        }

        .category-banner {
            padding: 7rem 0;
            background-position: center;
            background-size: cover;
            font-size: 1.6rem
        }

        .category-banner h2 {
            margin-left: -3px;
            margin-bottom: 1.7rem;
            font-size: 3.25em;
            letter-spacing: -0.05em;
            line-height: 48px
        }

        .category-banner h3 {
            font-size: 1.5em;
            color: #444444
        }

        .category-banner h4 {
            color: #444;
            font-size: 1.25em;
            line-height: normal
        }

        .sidebar-shop .widget-title {
            padding: 8px 0;
            letter-spacing: 0.05em
        }

        .sidebar-shop .widget-title a:after,
        .sidebar-shop .widget-title a:before {
            right: 3px
        }

        .sidebar-shop .widget-body {
            padding-top: 2.4rem
        }

        .sidebar-shop .config-swatch-list {
            display: block;
            margin-left: 1.5rem;
            margin-top: 1.3rem
        }

        .sidebar-shop .config-swatch-list li a {
            margin-bottom: 7px;
            width: 28px;
            height: 28px;
            color: #000;
            font-size: 1.2rem;
            line-height: 26px;
            text-indent: 37px
        }

        .sidebar-shop .config-swatch-list li a:before {
            text-indent: 0
        }

        .sidebar-shop .config-swatch-list li a.active,
        .sidebar-shop .config-swatch-list li a:hover {
            color: #0f43b0
        }

        .cat-list {
            padding-left: 1.5rem
        }

        .cat-list li {
            color: #000;
            font-size: 1.2rem;
            font-weight: 400;
            margin-bottom: 1.1rem
        }

        .cat-list li a {
            color: inherit;
            font-weight: inherit
        }

        .cat-list .products-count {
            color: #899296
        }

        .cat-sublist {
            margin-left: 1.3rem;
            margin-top: 1.1rem
        }

        .main-content > .row {
            margin-bottom: 1.5rem
        }

        .toolbox label {
            margin-top: -2px
        }

        @media (min-width: 992px) {
            .toolbox-pagination {
                margin-bottom: 0.7rem
            }
        }

        @media (max-width: 991px) {
            .sidebar-shop .widget {
                padding: 1.5rem 0
            }

            .sidebar-shop .widget:not(:last-child) {
                border-bottom: 0;
                margin-bottom: 0
            }
        }

        .product-single-details .product-title {
            margin-bottom: 1.2rem
        }

        .product-single-details .ratings-container {
            margin-bottom: 2.3rem
        }

        .product-single-details .product-desc {
            line-height: 1.6872
        }

        .product-single-details .single-info-list {
            margin-bottom: 1.8rem
        }

        .product-single-gallery {
            margin-bottom: 3.1rem
        }

        .product-single-tabs .nav.nav-tabs .nav-item .nav-link {
            line-height: 1.4
        }

        .product-desc-content li,
        .product-desc-content ul {
            letter-spacing: inherit
        }

        .products-section h2 {
            font-size: 1.6rem
        }

        .products-section .product-default.inner-quickview {
            padding: 1.4rem 0 0
        }

        .products-section .product-default.inner-quickview:hover {
            box-shadow: none
        }

        .products-section .owl-carousel.dots-top .owl-dots span {
            border-color: rgba(162, 59, 8, 0.4)
        }

        .product-single-container ~ .product-widgets-container .section-sub-title {
            padding-top: 0;
            border-bottom: 0;
            color: #222529;
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase
        }

        .about .subtitle {
            font-family: "Open Sans", sans-serif;
            letter-spacing: -0.01em;
            line-height: normal
        }

        .about .feature-box i {
            margin-bottom: 0.8rem;
            font-size: 5.6rem;
            margin-top: 4px
        }

        .about .feature-box p {
            font-size: 1.5rem;
            line-height: 27px
        }

        .about-section p {
            line-height: 27px
        }

        .features-section {
            padding-top: 5rem
        }

        .testimonials-section {
            padding-top: 5rem
        }

        .testimonials-section .subtitle {
            margin-bottom: 4.8rem
        }

        .testimonial-owner {
            align-items: center
        }

        .testimonial-owner figure {
            max-width: 25px;
            margin-bottom: 5px;
            margin-right: 27px
        }

        .testimonial-owner span {
            font-size: 1.28rem;
            letter-spacing: inherit;
            line-height: 16px
        }

        .testimonial blockquote:before {
            font-size: 4.8rem
        }

        .count-container .count-wrapper,
        .testimonial blockquote:before {
            color: #ff6840
        }

        .count-container .count-wrapper {
            margin-bottom: 1rem
        }

        @media (min-width: 768px) {
            .about-section {
                padding-top: 3rem
            }
        }

        .contact-two h2 {
            margin-bottom: 1.7rem
        }

        .contact-two .contact-title {
            margin-top: 1.5rem;
            margin-bottom: 1.2rem;
            font-size: 1.6rem
        }

        .contact-two p {
            line-height: 27px
        }

        .contact-two label {
            margin-bottom: 1.2rem
        }

        .contact-two .contact-info i {
            background: #08c
        }

        .contact-two .porto-sicon-title {
            margin-bottom: 2px
        }

        .contact-two .contact-time .contact-title {
            margin-bottom: 1.3rem
        }

        .contact-two .contact-time .porto-sicon-title {
            margin-top: 0;
            margin-bottom: 1px
        }
    </style>
    <script>
        WebFontConfig = {
            google: {families: ['Open+Sans:400,600', 'Poppins:400,500,600,700']}
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{url('/')}}/home/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

</head>

<body>
<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">
<div class="page-wrapper">
    <div class="top-notice bg-dark text-white pt-3">
        <div class="container text-center d-flex align-items-center justify-content-center flex-wrap">
            <h4 class="text-uppercase font-weight-bold mr-2">Deal of the week</h4>
            <h6>- 15% OFF in All Construction Materials, -</h6>

            <a href="{{ route('guest.products') }}" class="ml-2">Shop Now</a>
        </div><!-- End .container -->
    </div><!-- End .top-notice -->

    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-left d-md-block">
                    <div class="info-box info-box-icon-left text-primary justify-content-start p-0">
                        {{-- <i class="icon-location" style="color:#ff6840;"></i>
                        <h6 class="font-weight-bold text-dark">Delivery Location - </h6> --}}
                        {{-- <span><a href="#" class="text-dark">45,Eden Garden, R.S.Puram, 3rd Cross, Coimbatore. 641006</a></span> --}}
                        <i class="fa fa-arrow"></i>
                    </div>
                </div>
                {{-- <div class="header-dropdown ">
                    <a href="#"></a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">45, Eden Garden, Ganapathy, Coimbatore. 641006</a></li>
                            <li><a href="#">R.S.Puram, 3rd Cross, Coimbatore. 641003</a></li>
                        </ul>
                    </div>
                </div> --}}

                <div class="header-right header-dropdowns ml-0 ml-md-auto w-md-100">
                    <div class="header-dropdown mr-auto mr-md-0">
                        <div class="header-menu">

                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropown -->
                    <ul class="top-links mega-menu d-none d-xl-flex mb-0 pr-2">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
                            <a href="#"><i class="icon-help-circle"></i>Help</a></li>
                    </ul>


                    <span class="separator d-none d-md-block mr-0 ml-4"></span>

                    <div class="social-icons">
                        <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook"
                           target="_blank"
                           title="facebook"></a>
                        <a href="{{$Company['twitter']}}" class="social-icon social-twitter icon-twitter"
                           target="_blank"
                           title="twitter"></a>
                        <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram mr-0"
                           target="_blank"
                           title="instagram"></a>
                    </div><!-- End .social-icons -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-top -->

        <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
            <div class="container">
                <div class="header-left col-lg-2 w-auto pl-0">
                    <button class="mobile-menu-toggler text-dark mr-2" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="demo42.html" class="logo">
                        <img src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="RPC">
                    </a>
                    <span class="ml-3 font-weight-bold">RPC Construction</span>
                </div><!-- End .header-left -->

                <div class="header-right w-lg-max">
                    <div
                        class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mb-0">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper">
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search..."
                                       required>

                                <button class="btn icon-magnifier p-0" title="search" type="submit"></button>
                            </div><!-- End .header-search-wrapper -->
                        </form>
                    </div><!-- End .header-search -->

                    <span class="separator d-none d-lg-block"></span>

                    <div class="sicon-box mb-0 d-none d-lg-flex align-items-center pr-3 mr-1">
                        <div class=" sicon-default">
                            <i class="icon-phone-1"></i>
                        </div>
                        <div class="sicon-header">
                            <h4 class="sicon-title ls-n-25">CALL US NOW</h4>
                            <p>0422 234688</p>
                        </div>
                    </div>

                    <span class="separator d-none d-lg-block mr-4"></span>
                    <a href="{{url('/')}}/social/auth/google" class="d-lg-block d-none" id="loginBtn">
                        <div class="header-user">
                            <div class="header-userinfo">
                                <span>Welcome</span>
                                <h4>Sign In / Register</h4>
                            </div>
                        </div>
                    </a>

                    {{-- <span class="separator d-none d-lg-block mr-4"></span>
                    <a href="{{url('/')}}/login" class="d-lg-block d-none">
                        <div class="header-user">
                            <i class="icon-user-2"></i>
                        </div>
                    </a> --}}

                    <span class="separator d-block"></span>

                    <div class="dropdown cart-dropdown">
                        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <i class="icon-cart-thick"></i>
                            {{-- <i class="fa-regular fa-cart-shopping"></i> --}}
                            {{-- <span class="cart-count badge-circle">3</span> --}}
                        </a>

                        <div class="cart-overlay"></div>

                        <div class="dropdown-menu mobile-cart">
                            <a href="#" title="Close (Esc)" class="btn-close">×</a>

                            <div class="dropdownmenu-wrapper custom-scrollbar">
                                <div class="dropdown-cart-header">Shopping Cart</div>

                                <span>Your Cart is Empty!</span>

                                <div class="dropdown-cart-action">
                                    <a href="cart.html" class="btn btn-gray btn-block view-cart">Add to Cart</a>
                                    <a href="checkout.html" class="btn btn-dark btn-block">Checkout</a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdownmenu-wrapper -->
                        </div><!-- End .dropdown-menu -->
                    </div><!-- End .dropdown -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

        <div class="header-bottom sticky-header d-none d-lg-flex" data-sticky-options="{'mobile': false}">
            <div class="container">
                <nav class="main-nav w-100">
                    <ul class="menu w-100">
                        <li class="menu-item d-flex align-items-center">
                            <a href="#" class="d-inline-flex align-items-center sf-with-ul">
                                <i class="custom-icon-toggle-menu d-inline-table"></i><span>All
                                        Categories</span></a>
                            <div class="menu-depart">
                                @foreach ($PCategories->take(5) as $row)
                                    <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $row->PCID ]) }}">{{$row->PCName}}</a>
                                @endforeach
                                    <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ route('products.guest.categoriesList') }}" class="text-center">More</a>
                                    </div>
                            </div>
                        </li>
                        <li class="{{ (Route::currentRouteName() == "homepage") ? 'active' : '' }}">
                                <a href="{{ route('homepage') }}">Home</a>
                            </li>
                        <li>
                            <a href="#">Products</a>
                            <div class="megamenu megamenu-fixed-width">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="#" class="nolink">PRODUCT CATEGORIES</a>
                                    </div>
                                    @php
                                        $PCategories = $PCategories->take(9);
                                        $chunks = $PCategories->chunk(3);
                                    @endphp

                                    @foreach ($chunks as $chunk)
                                        <div class="col-lg-4">
                                            <ul class="submenu">
                                                @foreach ($chunk as $category)
                                                    <li><a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12 p-1">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-4">
                                                <a href="{{ route('products') }}" class="btn btn-sm btn-dark mr-0">View
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End .row -->
                            </div><!-- End .megamenu -->
                        </li>
                    </ul>
                </nav>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 main-content" id="productDetailsDiv">
                    <div class="sticky-wrapper">
                        <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggle">
                                    <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                        <path
                                            d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                        <path
                                            d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                    </svg>
                                    <span>Filter</span>
                                </a>

                                <div class="toolbox-item toolbox-sort">
                                    <label>Sort By:</label>

                                    <div class="select-custom">
                                        <select name="orderby" class="form-control" id="orderBySelect">
                                            <option value="" selected="selected">Default sorting</option>
                                            <option value="new">Sort by newness</option>
                                            <option value="popularity">Sort by popularity</option>
                                            {{--                                        <option value="rating">Sort by average rating</option>--}}
                                        </select>
                                    </div><!-- End .select-custom -->


                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-right">
                                <div class="toolbox-item toolbox-show">
                                    <label>Show:</label>

                                    <div class="select-custom">
                                        <select name="count" class="form-control" id="productCountSelect">
                                            <option value="12">12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .toolbox-item -->

                                <div class="toolbox-item layout-modes">
                                    <a href="#" class="layout-btn btn-grid active" title="Grid">
                                        <i class="icon-mode-grid"></i>
                                    </a>
                                    <a href="#" class="layout-btn btn-list" title="List">
                                        <i class="icon-mode-list"></i>
                                    </a>
                                </div><!-- End .layout-modes -->
                            </div><!-- End .toolbox-right -->
                        </nav>
                    </div>

                    <div class="row no-gutters">

                    </div><!-- End .row -->

                    <nav class="toolbox toolbox-pagination">
                        <div class="toolbox-item toolbox-show">
                            <label class="mt-0">Show:</label>

                            <div class="select-custom">
                                <select name="count" class="form-control">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                </select>
                            </div><!-- End .select-custom -->
                        </div><!-- End .toolbox-item -->

                        <ul class="pagination toolbox-item">
                            <li class="page-item disabled">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><span class="page-link">...</span></li>
                            <li class="page-item">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-overlay"></div>
                <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                    <div class="pin-wrapper" style="height: 904.35px;">
                        <div class="sidebar-wrapper" style="border-bottom: 0px rgb(119, 119, 119); width: 335px;">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true"
                                       aria-controls="widget-body-1">Categories</a>
                                </h3>

                                <div class="collapse show" id="widget-body-1">
                                    <div class="widget-body" id="categories-widget">
                                        <ul class="cat-list">
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div>
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->

            <div class="mb-4"></div>
        </div>
    </main>
    <!-- End .main -->

    <footer class="footer bg-dark position-relative">
        <div class="footer-middle">
            <div class="container position-static">
                <div class="row">
                    <div class="col-lg-2 col-sm-6 pb-2 pb-sm-0 d-flex align-items-center">
                        <div class="widget m-b-3">
                            <img src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" width="202" height="54"
                                 class="logo-footer">

                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-4 pb-sm-0">
                        <div class="widget mb-2">
                            <h4 class="widget-title mb-1 pb-1">Get In Touch</h4>
                            <ul class="contact-info">
                                <li>
                                    <span class="contact-info-label">Address:</span>45, RPC Building, Erode,<br>TamilNadu.638001.
                                </li>
                                <li>
                                    <span class="contact-info-label">Phone:</span><a href="tel:0422-4567890">0422-4567890</a>
                                </li>
                                <li>
                                    <span class="contact-info-label">Email:</span> <a href="#"><span
                                            class="__cf_email__"
                                            data-cfemail="f895999194b89d80999588949dd69b9795">{{$Company['E-Mail']}}</span></a>
                                </li>
                                <li>
                                    <span class="contact-info-label">Working Days/Hours:</span>
                                    Mon - Sun / 9:00 AM - 8:00 PM
                                </li>
                            </ul>
                            <div class="social-icons">
                                <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook"
                                   target="_blank" title="Facebook"></a>

                                <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram"
                                   target="_blank" title="Instagram"></a>

                                <a href="{{$Company['linkedin']}}"
                                   class="social-icon social-linkedin fab fa-linkedin-in" target="_blank"
                                   title="Linkedin"></a>
                            </div><!-- End .social-icons -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-2 pb-sm-0">
                        <div class="widget">
                            <h4 class="widget-title pb-1">Customer Services</h4>

                            <ul class="links">
                                @foreach(DB::table('tbl_page_content')->select('Slug', 'PageName')->get() as $Policy)
                                    <li>
                                        <a href="{{ route('policies', $Policy->Slug) }}">{{ $Policy->PageName ?? '' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-4 col-sm-6 pb-0">
                        <div class="widget widget-newsletter mb-1 mb-sm-3">
                            <h4 class="widget-title">Subscribe Newsletter</h4>

                            <p class="mb-2">Get all the latest information on events, sales and offers.
                                Sign up for newsletter:</p>
                            <form action="#" class="d-flex mb-0 w-100">
                                <input type="email" class="form-control mb-0" placeholder="Email address"
                                       required="">

                                <input type="submit" class="btn shadow-none" value="OK">
                            </form>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .footer-middle -->

        <div class="container">
            <div class="footer-bottom d-sm-flex align-items-center bg-dark">
                <div class="footer-left">
                    <span class="footer-copyright">RPC Construction. © 2024. All Rights Reserved</span>
                </div>

                <div class="footer-right ml-auto mt-1 mt-sm-0">
                    <div class="payment-icons">
                            <span class="payment-icon visa"
                                  style="background-image: url({{url('/')}}/home/assets/images/payments/payment-visa.svg)"></span>
                        <span class="payment-icon paypal"
                              style="background-image: url({{url('/')}}/home/assets/images/payments/payment-paypal.svg)"></span>
                        <span class="payment-icon stripe"
                              style="background-image: url({{url('/')}}/home/assets/images/payments/payment-stripe.png)"></span>
                        <span class="payment-icon verisign"
                              style="background-image:  url({{url('/')}}/home/assets/images/payments/payment-verisign.svg)"></span>
                    </div>
                </div>
            </div>
        </div><!-- End .footer-bottom -->
    </footer>
</div><!-- End .page-wrapper -->

<div class="loading-overlay">
    <div class="bounce-loader">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="sticky-navbar">
    <div class="sticky-info">
        <a href="{{ route('homepage') }}">
            <i class="icon-home"></i>Home
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('products.guest.categoriesList') }}" class="">
            <i class="icon-bars"></i>Categories
        </a>
    </div>
    <div class="sticky-info">
        <a href="wishlist.html" class="">
            <i class="icon-wishlist-2"></i>Wishlist
        </a>
    </div>
    <div class="sticky-info">
        <a href="login.html" class="">
            <i class="icon-user-2"></i>Account
        </a>
    </div>
    <div class="sticky-info">
        <a href="cart.html" class="">
            <i class="icon-shopping-cart position-relative">
                <span class="cart-count badge-circle">3</span>
            </i>Cart
        </a>
    </div>
</div>
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

<script src="{{url('/')}}/home/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/home/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/home/assets/js/optional/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/home/assets/js/plugins.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.appear.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.plugin.min.js"></script>
<script src="{{url('/')}}/home/assets/js/main.js"></script>
<script>
    $(document).ready(function () {
        $('.redirectLogin').on('click', function () {
            window.location.replace($('#loginBtn').attr('href'));
        });
    });

    $(document).ready(function () {
        var sub_category_id = "";
        var current_page_no = 1;
        var viewType = 'Grid';
        const LoadCategories = async () => {
            var formData = new FormData();
            formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
            $.ajax({
                type: "post",
                url: "{{url('/')}}/guest/products/get/categories/html",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#categories-widget').html(response);
                    $(".sub-category").on('click', function (e) {
                        e.preventDefault();
                        sub_category_id = $(this).data('sub-category-id');
                        current_page_no = 1;
                        LoadProducts();
                    });
                }
            });
        }

        const LoadProducts = async () => {
            var formData = new FormData();

            formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
            formData.append('SubCategoryID', sub_category_id);
            formData.append('productCount', $('#productCountSelect').val());
            formData.append('orderBy', $('#orderBySelect').val());
            formData.append('viewType', viewType);
            formData.append('pageNo', current_page_no);

            $.ajax({
                url: '{{ route('guest.products.productsHtml') }}',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#productDetailsDiv').html(response);
                    $('#productCountSelect').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect2').val(selectedValue);
                    });
                    $('#productCountSelect2').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect').val(selectedValue);
                    });
                    $('#productCountSelect').change(function () {
                        LoadProducts();
                    });
                    $('#productCountSelect2').change(function () {
                        LoadProducts();
                    });
                    $('#orderBySelect').change(function () {
                        LoadProducts();
                    });
                    $('.changePage').click(function () {
                        current_page_no = $(this).attr('data-page-no');
                        LoadProducts();
                    });
                    $('.changeView').click(function () {
                        viewType = $(this).attr('title');
                        LoadProducts();
                    });
                    $('.prevPage').click(function () {
                        current_page_no = parseInt(current_page_no) - 1;
                        LoadProducts();
                    });
                    $('.nextPage').click(function () {
                        current_page_no = parseInt(current_page_no) + 1;
                        LoadProducts();
                    });
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 419) {
                        window.location.replace("{{ route('homepage') }}");
                    } else {
                        console.log('An error occurred: ' + xhr.responseText);
                    }
                }
            });
        }

        LoadCategories();
        LoadProducts();
    });
</script>
</body>
</html>
