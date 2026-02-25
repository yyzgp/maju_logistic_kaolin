@extends('layouts.guest')
@section("head")
<style>
    .invalid-feedback{
        display: block !important;
        color: #fff !important;
    }
</style>
@endsection
@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(/frontend/img/carousel-bg-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">{{ $page->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
<div class="container-xxl bg-danger py-5">
    <div class="row g-4">
        <div class="col-lg-6 mx-auto col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="my-2">
                @include("administrator.includes.flash-message")
            </div>
            <form action="{{ route('save-contact-us') }}" method="POST" id="contactForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12 mb-2 text-center">
                        <h3 class="text-white">Send Message</h3>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name" class="col-form-label text-white">Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter your name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="col-form-label text-white">Email Address <span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone" class="col-form-label text-white">Phone <span class="text-danger">*</span></label>
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone no.">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="subject" class="col-form-label text-white">Subject <span class="text-danger">*</span></label>
                        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="Enter Subject.">
                        @error('subject')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="message" class="col-form-label text-white">Message <span class="text-danger">*</span></label>
                        <textarea id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message"placeholder="Enter message here.">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12 d-grid my-3">
                        <button type="submit" class="btn btn-dark" form="contactForm">Submit Enquiry</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="container-xxl py-5">
    <iframe id="mapIframe" width="100%" height="600"
    src="https://maps.google.com/maps?q=1.3327368,103.8082656&hl=es;z=14&amp;output=embed"
    allowfullscreen="true" loading="lazy"></iframe>
</div>
@endsection
