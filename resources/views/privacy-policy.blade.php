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
                    <header>
                        <h1>Privacy Policy – Logistics Towing PTE Ltd. Singapore</h1>
                    </header>
                    <section>
                        <p>At Logistics Towing PTE Ltd., we are committed to safeguarding your privacy and ensuring that your personal information is protected. This Privacy Policy outlines how we collect, use, and protect your personal data when you use our services. By using our website or engaging with our towing and roadside assistance services, you consent to the practices described in this policy.</p>
                        <h2>1. Information We Collect</h2>
                        <p>We collect personal information that you provide to us when you request our services, fill out forms on our website, or communicate with us in any way. The information we collect may include:</p>
                        <ul>
                            <li><strong>Personal Details:</strong>Name, address, phone number, and email address.</li>
                            <li><strong>Vehicle Information:</strong>Vehicle make, model, license plate number, and condition of the vehicle.</li>
                            <li><strong>Service Details:</strong>Information regarding the type of service you require, such as towing or roadside assistance.</li>
                            <li>
                                <p><strong>Location Data (For Drivers Only) :</strong></p>
                                <ul>
                                    <li>We collect real-time location information from your assigned towing vehicle during your service request. This data is used solely to facilitate the provision of the towing service.</li>
                                    <li>Your location data will only be shared with you (the customer) and is not sold or used for any other purpose.</li>
                                </ul>
                            </li>
                        </ul>
                        <p>We may also collect non-personal information such as technical data about your device or web browser when you visit our website. This information helps us improve your experience and enhance our services.</p>
                        <h2>2. How We Use Your Information</h2>
                        <p>We use the information we collect to provide, manage, and improve our services, and to communicate with you effectively. Specifically, your information may be used for:</p>
                        <ul>
                            <li><strong>Providing Towing Services:</strong>To process service requests, including scheduling and dispatching tow trucks.</li>
                            <li><strong>Customer Support:</strong>To respond to your inquiries, complaints, or feedback and to ensure that we are meeting your service needs.</li>
                            <li><strong>Billing and Payments:</strong>To process payment for services rendered and send invoices or receipts as needed.</li>
                            <li><strong>Marketing Communications:</strong>To send you information about promotions, special offers, or updates related to our services (only with your consent).</li>
                            <li><strong>Legal and Regulatory Compliance:</strong>To comply with applicable laws and regulations and to protect our rights, property, and users.</li>
                        </ul>
                        <h2>3. How We Protect Your Information</h2>
                        <p>We take the security of your personal information seriously and implement appropriate measures to protect it. These measures include physical, electronic, and administrative safeguards to prevent unauthorized access, disclosure, alteration, or destruction of your personal data. However, please note that no method of transmission over the internet or electronic storage is 100% secure, and while we strive to protect your personal information, we cannot guarantee its absolute security.</p>
                        <h2>4. Sharing Your Information</h2>
                        <p>We respect your privacy and do not sell, rent, or trade your personal information to third parties. However, we may share your information in the following situations:</p>
                        <ul>
                            <li><strong>Service Providers:</strong>We may share your data with trusted third-party service providers who assist us in delivering our services, such as payment processors, vehicle transportation partners, or technical support services. These parties are required to protect your data and use it only for the purposes we specify.</li>
                            <li><strong>Legal Obligations:</strong>We may disclose your information if required by law, in response to legal processes or government requests, or to protect the safety, rights, or property of Logistics Towing PTE Ltd., its customers, or others.</li>
                        </ul>
                        <h2>5. Cookies and Tracking Technologies</h2>
                        <p>Our website may use cookies or similar tracking technologies to enhance your browsing experience, analyze website usage, and provide personalized content. Cookies are small text files stored on your device that help us remember your preferences and track your activity on our site.</p>
                        <p>You can manage cookie settings through your browser, but please note that disabling cookies may affect your experience on our website.</p>
                        <h2>6. Your Rights and Choices</h2>
                        <p>As a customer, you have certain rights regarding your personal information, including:</p>
                        <ul>
                            <li><strong>Access:</strong>You have the right to request access to the personal data we hold about you.</li>
                            <li><strong>Correction:</strong>You can request corrections to any inaccurate or incomplete data.</li>
                            <li><strong>Deletion:</strong>You may request the deletion of your personal information, subject to legal and contractual obligations.</li>
                            <li><strong>Opt-Out:</strong>You can opt out of marketing communications at any time by contacting us directly or following the unsubscribe link in promotional emails.</li>
                        </ul>
                        <h2>7. Changes to This Privacy Policy</h2>
                        <p>We may update this Privacy Policy from time to time to reflect changes in our practices, legal requirements, or service offerings. When we make significant changes, we will notify you by updating the date at the bottom of this page or by other means as appropriate.</p>
                        <h2>8. Contact Us</h2>
                        <p>If you have any questions or concerns about our privacy practices or wish to exercise your rights, please contact us at:</p>
                        <p><strong>Logistics Towing PTE Ltd.</strong><br>Email: Logistics2020hq@gmail.com<br>Phone: +65 8800 9090<br>Address: 61 Woodlands Ind Park E9 #04-19 Spore 757047</p>
                        <p>By using our services, you acknowledge that you have read and understood this Privacy Policy.</p>
                        <p><em>Last updated: January 2025</em></p>
                    </section>
                </header>
            </div>
        </div>
    </div>
</div>
@endsection