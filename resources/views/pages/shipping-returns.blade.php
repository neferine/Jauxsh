@extends('layouts.app')
@section('title', 'Shipping & Returns | Jauxsh')
@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">SHIPPING & RETURNS</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="mb-12">
            <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-4 tracking-tight">
                Shipping & Returns
            </h1>
            <p class="font-lora text-gray-600 text-sm">
                Last Updated: October 19, 2025
            </p>
        </div>

        <!-- Content -->
        <div class="max-w-4xl space-y-10">
            <!-- Shipping Policy Section -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">Shipping Policy</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    <strong>Orders to PO boxes will not be accepted.</strong>
                </p>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">Domestic Shipping</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    We offer standard and express shipping options for all orders within the Philippines. Shipping times 
                    vary based on your location and chosen shipping method. Orders are typically processed within 1-2 
                    business days.
                </p>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">International Shipping</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    We ship to select countries worldwide. International shipping times vary by destination, typically 
                    ranging from 7-21 business days. Please note that international orders may be subject to customs 
                    delays beyond our control.
                </p>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">Duties & Taxes</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    Orders shipped outside of the Philippines may be subject to applicable taxes, duties, tariffs, and/or 
                    import fees by your local government. We have no up-front knowledge of these fees. The carrier will 
                    attempt to collect these fees at the time of delivery. Should they be unable to collect these fees, 
                    the shipment will be abandoned and you will not be eligible for a refund. Please research what import 
                    fees are applicable in your country before placing orders.
                </p>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">Tracking Your Order</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    Once your order ships, you will receive a confirmation email with tracking information. You can use 
                    this to monitor your package's progress. If you have any questions about your shipment, please contact 
                    our customer service team at support@jauxsh.com.
                </p>
            </div>

            <!-- Returns and Exchange Policy Section -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">Returns and Exchange Policy</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    If for any reason you need to exchange or return your item(s), please follow these steps below. Items 
                    must be returned within <strong>30 days of their delivery date</strong> in new, unused condition to be 
                    eligible for a refund.
                </p>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">Eligible Items</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                    To ensure your order is eligible for return or exchange, see below:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4 mb-4">
                    <li><strong>Sale items under 50% off</strong> can be exchanged but are non-refundable.</li>
                    <li><strong>Sale items that are 50% off or more</strong> are non-exchangeable and non-refundable.</li>
                    <li><strong>Bundle Deals</strong> are eligible for returns and exchanges.</li>
                    <li>Items must be unworn, unwashed, and with original tags attached.</li>
                </ul>

                <h3 class="font-cg font-semibold text-lg uppercase text-gray-900 mb-3 tracking-wide">Return Process</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="font-cg font-semibold text-base uppercase text-gray-900 mb-2">Step 1: Contact Us</h4>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Email us at <strong>support@jauxsh.com</strong> with your <strong>order number</strong> and 
                            <strong>reason for return</strong>. Any order shipped back to us without authorization will be 
                            refused and not refunded.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-cg font-semibold text-base uppercase text-gray-900 mb-2">Step 2: Package Your Return</h4>
                        <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                            Place your return/exchange in the original packaging it came in or another suitable carrier bag/box. 
                            If you would like to exchange your item(s), please place a new order for those items and return 
                            the original item(s) to us. We will issue a refund upon receipt.
                        </p>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            <strong>Please ensure your order number is clearly marked on the package.</strong>
                        </p>
                    </div>

                    <div>
                        <h4 class="font-cg font-semibold text-base uppercase text-gray-900 mb-2">Step 3: Ship Your Return</h4>
                        <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                            Ship your return fully pre-paid to the address below once your return request has been authorized:
                        </p>
                        <div class="bg-gray-50 p-6 rounded-sm border-l-4 border-[#1fac99ff] font-lora text-gray-700 text-base leading-relaxed">
                            <p><strong>Jauxsh Returns Department</strong></p>
                            <p>Daet, Camarines Norte</p>
                            <p>Philippines</p>
                            <p class="mt-2">+63 XXX XXX XXXX</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-cg font-semibold text-base uppercase text-gray-900 mb-2">Step 4: Inspection</h4>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Once we receive the package at our warehouse, each item will go through inspection. Any items 
                            that aren't in their original condition (worn, used, damaged, or missing tags) will not be accepted.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-cg font-semibold text-base uppercase text-gray-900 mb-2">Step 5: Refund Processing</h4>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Once inspection is complete, the refund will be processed and you will receive an email confirmation. 
                            Refunds will be issued to your original payment method within 7-10 business days. Any brokerage or 
                            import fees that are paid by us to have the package released will be deducted from your total refund amount.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="bg-gray-50 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <h3 class="font-cg font-bold text-lg uppercase text-gray-900 mb-3 tracking-wide">Important Notice</h3>
                <div class="font-lora text-gray-700 text-base leading-relaxed space-y-3">
                    <p>
                        <strong>You are responsible for the cost of returning the item(s).</strong> This includes the cost 
                        of the return label and any other import or brokerage fees that are applied when the return is 
                        shipping from outside of the Philippines.
                    </p>
                    <p>
                        Any return that is shipped collect or requires the payment of courier/freight costs upon return 
                        will be refused and not accepted. We strongly advise your return shipment to have a traceable 
                        service, so it can be located at all times.
                    </p>
                    <p>
                        Shipping and handling charges are not refundable. The company reserves the right to reject returns 
                        if it determines, in its sole discretion, that the customer is attempting to return worn items or 
                        for any other exploitation of this return policy.
                    </p>
                </div>
            </div>

            <!-- International Returns -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">International Returns</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    If you are returning goods from outside of the Philippines, customs brokerage fees will be incurred in 
                    addition to the cost of the return label. These fees vary by country and carrier.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    Any brokerage fees incurred will be deducted from your total refund amount after we receive the return. 
                    Please contact our customer service team before shipping your international return to understand the 
                    potential costs involved.
                </p>
            </div>

            <!-- Order Changes/Cancellations -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">Order Changes/Cancellations</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    To request an order change or cancellation, please email <strong>support@jauxsh.com</strong> with your 
                    order number as soon as possible. We will do our best to accommodate your request before your order ships, 
                    but it is not guaranteed, especially during busy seasons.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    Once an order has been shipped, it cannot be cancelled. You will need to follow our standard return process 
                    once you receive the package.
                </p>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">Questions?</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    If you have any questions about our shipping and returns policy, please contact us:
                </p>
                <div class="font-lora text-gray-700 text-base leading-relaxed space-y-1">
                    <p><strong>Email:</strong> support@jauxsh.com</p>
                    <p><strong>Phone:</strong> +63 XXX XXX XXXX</p>
                    <p><strong>Address:</strong> Daet, Camarines Norte, Philippines</p>
                </div>
            </div>

            <!-- Thank You Message -->
            <div class="bg-gray-50 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    We appreciate your understanding and patience. Our goal is to ensure you have the best possible 
                    shopping experience with Jauxsh. Thank you for choosing us!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection