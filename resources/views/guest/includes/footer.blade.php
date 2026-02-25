<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Address</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $company->address_line_1 }} {{ $company->address_line_2 }}</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ $company->dialcode }} {{ $company->phone }}</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $company->email }}</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Opening Hours</h4>
                <h6 class="text-light">Monday - Friday:</h6>
                <p class="mb-4">09.00 AM - 09.00 PM</p>
                <h6 class="text-light">Saturday - Sunday:</h6>
                <p class="mb-0">09.00 AM - 12.00 PM</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Services</h4>
                <a class="btn btn-link" href="">Recovery & Towing</a>
                <a class="btn btn-link" href="">Flatbed Towing</a>
                <a class="btn btn-link" href="">Multi & Basement Carpark Towing</a>
                <a class="btn btn-link" href="">Onsite Tyre Services</a>
                <a class="btn btn-link" href="">Onsite Battery Services</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Newsletter</h4>
                <p>Receive Updates on services and offers on your email.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Logistics Towing Pvt Ltd.</a>, All Right Reserved.

                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ route('index') }}">Home</a>
                        <a href="{{ route('about-us') }}">About Us</a>
                        <a href="{{ route('cookies-policy') }}">Cookies</a>
                        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
