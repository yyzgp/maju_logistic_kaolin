@extends('layouts.guest')
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
                <section>
                    <p>At <span class="text-danger">Logistics Towing PTE Ltd.</span>, we pride ourselves on being a reliable and professional towing company, serving the diverse needs of individuals, businesses, and organizations across Singapore. Established with a commitment to providing fast, efficient, and customer-oriented towing solutions, we have built a reputation as one of the most trusted names in the towing industry.</p>
                    <h2>Our Mission</h2>
                    <p>Our mission is simple : to offer top-notch, affordable towing services with the highest standards of safety, professionalism, and customer satisfaction. Whether you're facing an unexpected breakdown on the road or need to move a vehicle to a different location, our team is here to help 24/7. We understand how stressful vehicle-related emergencies can be, which is why we strive to make the towing process as smooth and hassle-free as possible.</p>
                    <h2>What We Offer</h2>
                    <p> <span class="text-danger">Logistics Towing PTE Ltd.</span>offers a comprehensive range of towing and roadside assistance services designed to cater to both personal and commercial needs. Our fleet of well-maintained tow trucks and skilled operators ensure that every job, big or small, is handled with utmost care and precision.</p>
                    <h3>We specialize in the following services :</h3>
                    <ul>
                        <li><strong>Emergency Towing : </strong>Whether you are stranded due to a breakdown, accident, or mechanical failure, we provide quick and efficient towing to get you out of a difficult situation. We offer prompt response times and can tow vehicles of all sizes, from motorcycles to large commercial trucks.</li>
                        <li><strong>Roadside Assistance : </strong>Our team is ready to assist with common roadside problems, including flat tires, dead batteries, fuel delivery, and lockouts. We aim to get you back on the road as quickly as possible, minimizing disruptions to your day.</li>
                        <li><strong>Vehicle Relocation : </strong>We also assist with the safe transportation of vehicles across the city for moving, parking violations, or other reasons. Our towing experts ensure the safe handling and delivery of vehicles to the required destination.</li>
                        <li><strong>Accident Recovery :</strong>After an accident, we step in to safely recover and tow vehicles to your preferred location or a repair shop, assisting you with the next steps in the process.</li>
                        <li><strong>Commercial Towing Services:</strong>Businesses in Singapore trust us for towing and fleet management services. We help with the transportation of company vehicles, machinery, and equipment, offering scheduled and emergency towing solutions for logistics companies, construction businesses, and other commercial sectors.</li>
                    </ul>
                    <h2>Why Choose Us?</h2>
                    <ul>
                        <li><strong>Professional and Experienced Team:</strong>Our team of licensed drivers and operators have years of experience in the towing industry. They are well-trained to handle all types of vehicles and towing situations, ensuring the safety of both your vehicle and the driver.</li>
                        <li><strong>24/7 Availability:</strong>Emergencies can happen at any time. That's why we are available around the clock, providing towing and roadside assistance services 24 hours a day, 7 days a week.</li>
                        <li><strong>Affordable and Transparent Pricing:</strong>We understand that towing services can be costly, which is why we offer competitive and transparent pricing. There are no hidden fees, and we make sure you know exactly what you're paying for.</li>
                        <li><strong>Reliability and Timeliness:</strong>We take pride in being punctual and dependable. When you call us, you can count on us to be there on time and ready to resolve your issue efficiently.</li>
                        <li><strong>State-of-the-Art Equipment:</strong>We use modern towing trucks and equipment to ensure safe and efficient services. Our fleet is regularly maintained, and we keep up with the latest industry practices.</li>
                    </ul>
                    <h2>Our Commitment to Customer Satisfaction</h2>
                    <p>At <span class="text-danger">Logistics Towing PTE Ltd.</span>, our customers are our top priority. We are dedicated to providing excellent customer service, and our friendly team is always ready to answer your questions and guide you through the towing process. Our goal is to make sure that you have a stress-free experience, whether you need a simple tow or emergency assistance.</p>
                    <p>Choose <span class="text-danger">Logistics Towing PTE Ltd.</span>for all your towing needs in Singapore. We’re here to provide the fast, reliable, and professional towing services you deserve.</p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection