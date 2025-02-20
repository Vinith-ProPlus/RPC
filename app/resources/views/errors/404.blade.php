@extends('layouts.errors')
@section('content')

        <!-- error-400 start-->
        <div class="error-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-sm-7 col-md-5 col-lg-4 col-xl-3">
                        <img loading="lazy" class="img-fluid err-img" src="../assets/images/error-img.png" alt="">
                    </div>
                </div>
                <!-- <img loading="lazy" class="img-100" src="../assets/images/error-img.png" alt=""> -->
                <div class="error-heading">
                    <h2 class="headline font-info">404</h2>
                </div>
                <div class="col-md-8 offset-md-2">
                    <p class="sub-content">The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                </div>
                <div>
                    <a class="btn btn-pill btn-danger btn-air-danger btn-lg" href="{{url('/')}}/"> <i class="fa fa-home"></i> BACK TO HOME PAGE</a>
                </div>
            </div>
        </div>
@endsection
