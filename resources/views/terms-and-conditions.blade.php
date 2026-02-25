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
                <header>
                    <h1>Terms and Conditions – Logistics Towing PTE Ltd. Singapore</h1>
                </header>
                <section>
                    <p>Welcome to Logistics Towing PTE Ltd.. By using our services, you agree to be bound by the following terms and conditions. Please read them carefully before engaging in any of our towing or roadside assistance services. These terms apply to all customers, including individuals, businesses, and organizations, across Singapore.</p>
                    <h2>1. General Terms</h2>
                    <p>Logistics Towing PTE Ltd. provides towing, roadside assistance, and related services ("Services") to our customers in Singapore. By requesting or accepting our services, you agree to comply with all terms and conditions outlined here. If you do not agree to these terms, please refrain from using our services.</p>
                    <h2>2. Service Request</h2>
                    <p>To request towing or assistance services, customers must provide accurate and complete information about the vehicle and location. This includes details such as the type of vehicle, its condition, the reason for requiring service, and the precise location where the service is needed. Logistics Towing PTE Ltd. reserves the right to refuse service if insufficient or incorrect information is provided.</p>
                    <h2>3. Fees and Payment</h2>
                    <ul>
                        <li>All towing and roadside assistance services are subject to the applicable fees as agreed at the time of service request. Fees are based on the type of service, distance, vehicle size, and any other special requirements.</li>
                        <li>Payment must be made immediately upon completion of services unless otherwise agreed. We accept cash, credit/debit cards, and other forms of payment as specified.</li>
                        <li>Logistics Towing PTE Ltd. reserves the right to change service charges, and all customers will be informed of such changes prior to service provision.</li>
                    </ul>
                    <h2>4. Service Availability</h2>
                    <p>Our services are available 24/7, but availability may depend on location, traffic conditions, and the nature of the request. While we strive for timely service, Logistics Towing PTE Ltd. is not liable for delays caused by circumstances beyond our control, including weather, road conditions, or traffic.</p>
                    <h2>5. Customer Responsibilities</h2>
                    <ul>
                        <li>The customer must ensure that the vehicle to be towed is in a safe and accessible condition for towing. This includes ensuring that the vehicle is not obstructing traffic and is parked legally.</li>
                        <li>Customers must also ensure that there are no personal items left in the vehicle during towing, as Logistics Towing PTE Ltd. is not responsible for any lost or damaged items inside the vehicle.</li>
                        <li>In the event that our towing services involve a vehicle that has been involved in an accident, the customer must ensure proper legal documentation, including accident reports, are available for processing.</li>
                    </ul>
                    <h2>6. Limitations of Liability</h2>
                    <p>Logistics Towing PTE Ltd. is not responsible for any damage that may occur to the vehicle during towing, except in cases where damage is caused by our negligence or misconduct. We take every precaution to ensure that your vehicle is handled with care, but we do not accept liability for any damages that may arise from unavoidable circumstances during transport.</p>
                    <p>Additionally, Logistics Towing PTE Ltd. is not liable for any loss, injury, or damage that occurs due to circumstances such as acts of God, third-party actions, or conditions that are beyond our control.</p>
                    <h2>7. Insurance and Indemnity</h2>
                    <p>Customers are encouraged to have their vehicles insured against any potential damage. In the event of damage caused by the customer’s vehicle or any third-party involvement during the towing process, the customer agrees to indemnify and hold Logistics Towing PTE Ltd. harmless against any claims, damages, or costs arising from the service.</p>
                    <h2>8. Changes to Terms</h2>
                    <p>Logistics Towing PTE Ltd. reserves the right to modify or update these terms and conditions at any time. Any changes will be posted on our website, and by continuing to use our services, customers agree to abide by the updated terms.</p>
                    <h2>9. Governing Law</h2>
                    <p>These terms and conditions are governed by the laws of Singapore. Any disputes arising from the use of our services will be subject to the exclusive jurisdiction of the courts in Singapore.</p>
                    <h2>10. Contact Information</h2>
                    <p>For any questions, complaints, or service-related inquiries, customers are encouraged to contact our support team directly. We are committed to providing prompt and effective assistance.</p>
                    <p>By using Logistics Towing PTE Ltd., you acknowledge that you have read, understood, and agreed to these terms and conditions.</p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection