@extends('layouts.app')
@section('title', 'FAQ | Jauxsh')
@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">FAQ</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="mb-12">
            <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-4 tracking-tight">
                Frequently Asked Questions
            </h1>
            <p class="font-lora text-gray-600 text-base">
                Find answers to common questions about ordering, shipping, returns, and more.
            </p>
        </div>

        <!-- Content -->
        <div class="max-w-4xl space-y-12">
            
            <!-- Orders & Payment -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Orders & Payment
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How do I place an order?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Browse our collections, select your desired items, choose your size and color, and click "Add to Cart." 
                            Once you're ready to checkout, click the cart icon, review your items, and proceed to checkout. You'll 
                            need to create an account or log in to complete your purchase.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">What payment methods do you accept?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            We accept major credit cards (Visa, Mastercard, American Express), debit cards, PayPal, and other secure 
                            payment methods as displayed at checkout. All transactions are processed securely through our payment providers.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Can I modify or cancel my order after placing it?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Please contact us immediately at support@jauxsh.com with your order number. We'll do our best to accommodate 
                            changes or cancellations before the order ships. Once an order has shipped, you'll need to follow our return 
                            process.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Do you offer gift cards?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Yes! Gift cards are available for purchase on our website. They make perfect gifts and never expire. The 
                            recipient will receive a digital gift card code via email that can be used at checkout.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Will I receive an order confirmation?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Yes, you'll receive an email confirmation immediately after placing your order. This email will include your 
                            order number and a summary of your purchase. If you don't receive this email within a few minutes, please 
                            check your spam folder or contact us.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Shipping & Delivery -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Shipping & Delivery
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How long does shipping take?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                            Shipping times vary based on your location and chosen shipping method:
                        </p>
                        <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                            <li><strong>Metro Manila:</strong> 2-3 business days</li>
                            <li><strong>Luzon:</strong> 3-5 business days</li>
                            <li><strong>Visayas & Mindanao:</strong> 5-7 business days</li>
                            <li><strong>International:</strong> 7-21 business days depending on destination</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How much does shipping cost?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Shipping costs are calculated at checkout based on your location and the weight of your order. We offer 
                            free standard shipping on orders over ₱2,500 within the Philippines.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Do you ship internationally?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Yes, we ship to select countries worldwide. International shipping rates and times vary by destination. 
                            Please note that international orders may be subject to customs duties and taxes, which are the 
                            responsibility of the recipient.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How can I track my order?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Once your order ships, you'll receive a shipping confirmation email with a tracking number. You can use 
                            this number to track your package on the carrier's website. You can also track your order by logging into 
                            your account on our website.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Do you ship to PO boxes?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Unfortunately, we do not accept orders to PO boxes. Please provide a physical street address for delivery.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">What if my package is lost or damaged?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            If your package is lost in transit or arrives damaged, please contact us immediately at support@jauxsh.com 
                            with your order number and photos of any damage. We'll work with you to resolve the issue quickly.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Returns & Exchanges -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Returns & Exchanges
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">What is your return policy?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            We accept returns within 30 days of delivery for unworn, unwashed items with original tags attached. 
                            Some sale items may have restrictions. Please see our full 
                            <a href="/shipping-returns" class="text-[#1fac99ff] hover:underline">Shipping & Returns policy</a> 
                            for complete details.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How do I initiate a return or exchange?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Email us at support@jauxsh.com with your order number and reason for return. We'll provide you with 
                            return instructions. Please do not ship items back without authorization, as unauthorized returns will 
                            be refused.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Who pays for return shipping?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Customers are responsible for return shipping costs unless the item is defective or we made an error 
                            with your order. We recommend using a trackable shipping service for returns.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How long does it take to process a refund?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Once we receive and inspect your return, refunds are processed within 7-10 business days to your 
                            original payment method. You'll receive an email confirmation once the refund has been issued.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Can I exchange an item for a different size or color?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            To ensure you receive your preferred item as quickly as possible, we recommend placing a new order for 
                            the item you want and returning the original item for a refund.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Are sale items returnable?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Sale items under 50% off can be exchanged but are non-refundable. Sale items that are 50% off or more 
                            are final sale and cannot be returned or exchanged.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Products & Sizing -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Products & Sizing
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How do I find the right size?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Please refer to our detailed <a href="/size-guide" class="text-[#1fac99ff] hover:underline">Size Guide</a> 
                            which includes measurements for all our products. If you're between sizes, we generally recommend sizing up. 
                            You can also contact us for personalized sizing advice.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Are your products true to size?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Yes, our products generally fit true to size. However, fit preferences vary by individual. We provide 
                            detailed measurements and fit notes on each product page to help you make the best choice.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">What materials are your products made from?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            We use high-quality, premium materials including 100% cotton, premium blends, and sustainable fabrics. 
                            Specific material composition is listed on each product page. All our garments are designed for comfort, 
                            durability, and style.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How should I care for my Jauxsh products?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                            Care instructions are included on the garment tag. General recommendations:
                        </p>
                        <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                            <li>Machine wash cold with like colors</li>
                            <li>Tumble dry low or hang dry</li>
                            <li>Do not bleach</li>
                            <li>Iron on low heat if needed</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Will the colors look exactly like the photos?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            We strive to display colors as accurately as possible, but actual colors may vary slightly due to 
                            differences in monitor settings and lighting conditions. If you have specific color questions, feel 
                            free to contact us.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">When will out-of-stock items be restocked?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Restock dates vary by product. You can sign up for restock notifications on the product page, and we'll 
                            email you when the item becomes available again.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account & Security -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Account & Security
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Do I need an account to place an order?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Yes, you'll need to create an account to complete your purchase. This allows you to track orders, 
                            save your information for faster checkout, and access your order history.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How do I reset my password?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Click "Forgot Password" on the login page and enter your email address. We'll send you instructions 
                            to reset your password. If you don't receive the email, check your spam folder or contact us for assistance.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Is my payment information secure?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Absolutely. We use industry-standard SSL encryption to protect your personal and payment information. 
                            We never store your complete credit card information on our servers. All payments are processed securely 
                            through trusted payment providers.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How can I update my account information?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Log into your account and navigate to "Account Settings" where you can update your email, password, 
                            shipping addresses, and other information.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact & Support -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-6 tracking-wide border-b-2 border-[#1fac99ff] pb-2">
                    Contact & Support
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">How can I contact customer service?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed mb-3">
                            You can reach us through:
                        </p>
                        <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                            <li><strong>Email:</strong> support@jauxsh.com</li>
                            <li><strong>Phone:</strong> +63 XXX XXX XXXX</li>
                            <li><strong>Contact Form:</strong> Available on our <a href="/contact" class="text-[#1fac99ff] hover:underline">Contact page</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">What are your customer service hours?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Our customer service team is available Monday through Friday, 9:00 AM to 6:00 PM Philippine Time. 
                            We respond to emails within 24-48 hours during business days.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-cg font-semibold text-lg text-gray-900 mb-2">Do you have a physical store?</h3>
                        <p class="font-lora text-gray-700 text-base leading-relaxed">
                            Currently, Jauxsh operates exclusively online to provide you with the best prices and widest selection. 
                            However, we're exploring retail opportunities for the future. Follow us on social media for updates!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Still Have Questions -->
            <div class="bg-gray-50 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <h3 class="font-cg font-bold text-xl uppercase text-gray-900 mb-4 tracking-wide">Still Have Questions?</h3>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    Can't find the answer you're looking for? Our customer service team is here to help!
                </p>
                <div class="font-lora text-gray-700 text-base leading-relaxed space-y-1">
                    <p><strong>Email:</strong> support@jauxsh.com</p>
                    <p><strong>Phone:</strong> +63 XXX XXX XXXX</p>
                    <p><strong>Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM PHT</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection