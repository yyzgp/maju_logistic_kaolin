@extends('layouts.guest')
@section("head")
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
<style>
    :root {
    --primary-color: #D82D36;
    --secondary-color: #000;
    --accent-color: #D82D36;
    --gradient: linear-gradient(135deg, var(--primary-color), #D82D36);
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
}

.hero-section {
    background: var(--gradient);
    padding-top: 120px;
    padding-bottom: 100px;
    position: relative;
    overflow: hidden;
}

.hero-section::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    height: 100px;
    background: white;
    transform: skewY(-3deg);
}

.hero-text h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1.5rem;
}

.hero-text p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

.app-badge {
    height: 40px;
    margin: 10px;
    transition: transform 0.3s ease;
}

.app-badge:hover {
    transform: scale(1.05);
}

.phone-mockup {
    position: relative;
    z-index: 1;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-20px);
    }
}

.feature-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 2rem;
    text-align: center;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.screenshot {
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.screenshot:hover {
    transform: scale(1.05);
}

.pricing-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease;
    padding: 2rem;
}

.pricing-card.featured {
    background: var(--gradient);
    color: white;
    transform: scale(1.05);
}

.pricing-card:not(.featured):hover {
    transform: scale(1.03);
}

.testimonial-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin: 1rem 0;
}

.testimonial-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.cta-section {
    background: var(--gradient);
    padding: 5rem 0;
    position: relative;
}

.download-btn {
    background: white;
    color: var(--primary-color);
    border: none;
    padding: 1rem 2rem;
    border-radius: 30px;
    font-weight: 600;
    transition: transform 0.3s ease;
}

.download-btn:hover {
    transform: scale(1.05);
    background: white;
    color: var(--primary-color);
}

.navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.stat-card {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
}
</style>
@endsection
@section('content')
<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="/frontend/img/carousel-bg-1.jpg" alt="Image">
                <div class="carousel-caption d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center justify-content-center justify-content-lg-start">
                            <div class="col-10 col-lg-7 text-center text-lg-start">
                                <h6 class="text-white text-uppercase mb-3 animated slideInDown">24/7 Active Towing Service</h6>
                                <h1 class="display-3 text-white mb-4 pb-3 animated slideInDown">Logistics Towing 高嶺拖车</h1>
                                <a href="{{ route('contact-us') }}" class="btn btn-primary py-3 px-5 animated slideInDown">Contact Us<i class="fa fa-arrow-right ms-3"></i></a>
                            </div>
                            <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                <img class="img-fluid" src="/frontend/img/carousel-1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="/frontend/img/carousel-bg-2.jpg" alt="Image">
                <div class="carousel-caption d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center justify-content-center justify-content-lg-start">
                            <div class="col-10 col-lg-7 text-center text-lg-start">
                                <h6 class="text-white text-uppercase mb-3 animated slideInDown">Expert Help for Stranded Drivers, Anytime, Anywhere, Every Timer
                                    Towing</h6>
                                <h1 class="display-3 text-white mb-4 pb-3 animated slideInDown">24x7 Roadside Assistance</h1>
                                <a href="{{ route('contact-us') }}" class="btn btn-primary py-3 px-5 animated slideInDown">Contact Us<i class="fa fa-arrow-right ms-3"></i></a>
                            </div>
                            <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                <img class="img-fluid" src="/frontend/img/carousel-2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->
<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp text-center" data-wow-delay="0.08s">
                <h2 class="text-primary text-uppercase">Our Services</h2>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="d-flex bg-light py-5 px-4">
                    <img src="{{ asset("frontend/img/crane-truck.gif") }}" width="28%">
                    <div class="ps-4">
                        <h5 class="mb-3">Recovery & Towing</h5>
                        <p>Professional and timely assistance for vehicle recovery and towing needs.</p>
                        <a class="text-secondary border-bottom" href="">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="d-flex bg-light py-5 px-4">
                    <img src="{{ asset("frontend/img/tow-truck.png") }}" width="28%">
                    <div class="ps-4">
                        <h5 class="mb-3">Flatbed Towing</h5>
                        <p>Secure transport of vehicles using flatbed trucks to prevent damage during transit.</p>
                        <a class="text-secondary border-bottom" href="">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="d-flex bg-light bg-light py-5 px-4">
                    <img src="{{ asset("frontend/img/towing-vehicle.png") }}" width="28%">
                    <div class="ps-4">
                        <h5 class="mb-3">Multi & Basement Carpark Towing</h5>
                        <p>Expertise in handling towing services in complex car park environments.</p>
                        <a class="text-secondary border-bottom" href="">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="d-flex bg-light py-5 px-4">
                    <img src="{{ asset("frontend/img/tire.gif") }}" width="28%">
                    <div class="ps-4">
                        <h5 class="mb-3">Tyre Patching &
                            Onsite Tyre Services</h5>
                        <p>Flat tyre? No problem! Our 24/7 mobile service fixes your tyres anywhere—home, work, or roadside.</p>
                        <a class="text-secondary border-bottom" href="">Read More</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="d-flex bg-light py-5 px-4">
                    <img src="{{ asset("frontend/img/eco-battery.gif") }}" width="28%">
                    <div class="ps-4">
                        <h5 class="mb-3">24/7 Onsite
                            Battery Services</h5>
                        <p>Dead battery? Logistics Towing’s 24/7 onsite service gets you moving again. We use reliable SAIL batteries for lasting performance.</p>
                        <a class="text-secondary border-bottom" href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
  <!-- Fact Start -->
  <div class="container-fluid fact bg-dark my-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                <i class="fa fa-check fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">10 +</h2>
                <p class="text-white mb-0">Years Experience</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                <i class="fa fa-users-cog fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">1200</h2>
                <p class="text-white mb-0">Expert Technicians</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                <i class="fa fa-users fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">100000</h2>
                <p class="text-white mb-0">Satisfied Clients</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                <i class="fa fa-car fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">114344</h2>
                <p class="text-white mb-0">Completed Projects</p>
            </div>
        </div>
    </div>
</div>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-text">
                <h1>Join Us as a Logistics Towing Driver</h1>
                <p>Download the Driver app and become a Logistics Towing Driver.</p>
                <div class="d-flex flex-wrap">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Download_on_the_App_Store_RGB_blk.svg" alt="Download on App Store" class="app-badge">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" class="app-badge">
                </div>
            </div>
            <div class="col-lg-6 text-center pt-4">
                <img src="{{ asset("frontend/img/iphone16.png") }}" alt="Phone Mockup" class="phone-mockup img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">1K+</div>
                    <div>Drivers Connected</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">4.8</div>
                    <div>App Rating</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div>Succesfull Pickups</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div>Support</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">App Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-bolt feature-icon"></i>
                    <h3>Realtime Tracking</h3>
                    <p>Track your towing requests and navigate to locations with ease.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-bell feature-icon"></i>
                    <h3>Instant Notifications</h3>
                    <p>Receive alerts for new towing jobs and updates on your requests.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-dollar-sign feature-icon"></i>
                    <h3>Easy Payments</h3>
                    <p>Secure and convenient payment options for hassle-free transactions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Screenshots Section -->
<section id="screenshots" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">App Screenshots</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ asset("frontend/img/app-2.jpg") }}" alt="Screenshot 1" class="img-fluid screenshot">
            </div>
            <div class="col-md-4">
                <img src="{{ asset("frontend/img/app-1.jpg") }}" alt="Screenshot 2" class="img-fluid screenshot">
            </div>

            <div class="col-md-4">
                <img src="{{ asset("frontend/img/app-3.jpg") }}" alt="Screenshot 3" class="img-fluid screenshot">
            </div>
        </div>
    </div>
</section>


<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Testimonials</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User 1" class="testimonial-img">
                    <p class="mb-3">"I had an excellent experience with this towing company in Singapore. My car broke down on a busy street, and I was really stressed out. I called their hotline, and they responded within minutes!"</p>
                    <h5 class="mb-1">Sarah Johnson</h5>
                    <p class="text-muted">Review Update On :{{ now()->format('d M Y, h:i A') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="https://randomuser.me/api/portraits/men/64.jpg" alt="User 2" class="testimonial-img">
                    <p class="mb-3">"Great towing service! I had to call them when my vehicle wouldn’t start in the middle of the night, and they were there within 30 minutes, which was a huge relief. The pricing was fair, & they communicated clearly about the process & costs upfront."</p>
                    <h5 class="mb-1">Mike Chen</h5>
                    <p class="text-muted">Review Update On :{{ now()->format('d M Y, h:i A') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="User 3" class="testimonial-img">
                    <p class="mb-3">"Exceptional service! I was stranded on a busy expressway, and the team came through like pros. The customer service rep was friendly and knowledgeable, and the driver ensured my car was safely towed to the garage"</p>
                    <h5 class="mb-1">Linda Stark</h5>
                    <p class="text-muted">Review Update On :{{ now()->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section id="download" class="cta-section text-center">
    <div class="container">
        <h2 class="text-white fw-bold mb-4">Download Logistics Driver App Today</h2>
        <p class="text-white mb-5">Join our team of professional tow drivers! Earn flexible income, enjoy great support, and drive with confidence.</p>
        <div class="d-flex justify-content-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Download_on_the_App_Store_RGB_blk.svg" alt="Download on App Store" class="app-badge me-3">
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" class="app-badge">
        </div>
    </div>
</section>


<!-- Fact End -->
<div class="container-xxl py-5">
    <iframe id="mapIframe" width="100%" height="600"
    src="https://maps.google.com/maps?q=1.3327368,103.8082656&hl=es;z=14&amp;output=embed"
    allowfullscreen="true" loading="lazy"></iframe>
</div>
@endsection
