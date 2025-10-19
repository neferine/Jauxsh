@extends('layouts.app')
@section('title', 'Terms of Service | Jauxsh')
@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="px-6 md:px-20 lg:px-40 pt-32 pb-8">
        <nav class="text-sm text-gray-600 font-lora">
            <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">TERMS OF SERVICE</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="px-6 md:px-20 lg:px-40 pb-20">
        <!-- Title -->
        <div class="mb-12">
            <h1 class="font-cg font-bold text-4xl md:text-5xl uppercase text-gray-900 mb-4 tracking-tight">
                Terms of Service
            </h1>
            <p class="font-lora text-gray-600 text-sm">
                Last Updated: October 19, 2025
            </p>
        </div>

        <!-- Content -->
        <div class="max-w-4xl space-y-10">
            <!-- Section 1 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">1. Agreement to Terms</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    By accessing or using the Jauxsh website and services, you agree to be bound by these Terms of Service 
                    and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited 
                    from using or accessing this site.
                </p>
            </div>

            <!-- Section 2 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">2. Use License</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    Permission is granted to temporarily access the materials on Jauxsh's website for personal, 
                    non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, 
                    and under this license you may not:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                    <li>Modify or copy the materials</li>
                    <li>Use the materials for any commercial purpose or for any public display</li>
                    <li>Attempt to decompile or reverse engineer any software contained on Jauxsh's website</li>
                    <li>Remove any copyright or other proprietary notations from the materials</li>
                    <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">3. Account Registration</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    To make purchases on Jauxsh, you must create an account. You agree to:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                    <li>Provide accurate, current, and complete information during registration</li>
                    <li>Maintain and promptly update your account information</li>
                    <li>Maintain the security of your password and account</li>
                    <li>Accept all responsibility for activities that occur under your account</li>
                    <li>Notify us immediately of any unauthorized use of your account</li>
                </ul>
            </div>

            <!-- Section 4 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">4. Products and Pricing</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    All product descriptions, images, specifications, and prices are subject to change at any time without 
                    notice. We reserve the right to limit the quantities of any products or services that we offer. All 
                    descriptions of products or product pricing are subject to change without notice, at our sole discretion.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    We strive to display colors and images as accurately as possible, but we cannot guarantee that your 
                    device's display will accurately reflect the actual product colors.
                </p>
            </div>

            <!-- Section 5 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">5. Orders and Payment</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    By placing an order, you represent that you are legally able to enter into binding contracts. We reserve 
                    the right to refuse or cancel any order for any reason, including:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4 mb-4">
                    <li>Product or service availability</li>
                    <li>Errors in product or pricing information</li>
                    <li>Errors in your order</li>
                    <li>Suspected fraudulent or unauthorized transactions</li>
                </ul>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    All payments are processed securely through our payment providers. We accept major credit cards, debit 
                    cards, and other payment methods as displayed at checkout.
                </p>
            </div>

            <!-- Section 6 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">6. Shipping and Delivery</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    Shipping times and costs vary based on your location and chosen shipping method. While we strive to 
                    meet estimated delivery dates, we are not responsible for delays caused by shipping carriers, customs, 
                    or events beyond our control.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    Risk of loss and title for items purchased pass to you upon delivery to the shipping carrier.
                </p>
            </div>

            <!-- Section 7 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">7. Returns and Refunds</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    We want you to be completely satisfied with your purchase. If you are not satisfied, you may return 
                    unworn, unwashed items with original tags attached within 30 days of delivery for a full refund or exchange.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    To initiate a return, please contact our customer service team. Return shipping costs are the responsibility 
                    of the customer unless the item is defective or we made an error in your order.
                </p>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    Refunds will be processed to the original payment method within 7-10 business days after we receive 
                    your return.
                </p>
            </div>

            <!-- Section 8 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">8. Intellectual Property</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    All content on this website, including but not limited to text, graphics, logos, images, and software, 
                    is the property of Jauxsh and is protected by international copyright and trademark laws. Unauthorized 
                    use of any content may violate copyright, trademark, and other laws.
                </p>
            </div>

            <!-- Section 9 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">9. Prohibited Uses</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    You may not use our site:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                    <li>For any unlawful purpose or to solicit others to perform unlawful acts</li>
                    <li>To violate any international, federal, or state regulations, rules, laws, or local ordinances</li>
                    <li>To infringe upon or violate our intellectual property rights or the rights of others</li>
                    <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
                    <li>To submit false or misleading information</li>
                    <li>To upload or transmit viruses or any other type of malicious code</li>
                    <li>To spam, phish, scrape, or use automated systems to access the site</li>
                </ul>
            </div>

            <!-- Section 10 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">10. Limitation of Liability</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    To the fullest extent permitted by law, Jauxsh shall not be liable for any indirect, incidental, special, 
                    consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or 
                    indirectly, or any loss of data, use, goodwill, or other intangible losses resulting from:
                </p>
                <ul class="list-disc list-inside font-lora text-gray-700 text-base leading-relaxed space-y-2 ml-4">
                    <li>Your access to or use of or inability to access or use the service</li>
                    <li>Any conduct or content of any third party on the service</li>
                    <li>Any content obtained from the service</li>
                    <li>Unauthorized access, use, or alteration of your transmissions or content</li>
                </ul>
            </div>

            <!-- Section 11 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">11. Indemnification</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    You agree to defend, indemnify, and hold harmless Jauxsh and its employees, contractors, agents, officers, 
                    and directors from and against any and all claims, damages, obligations, losses, liabilities, costs, or 
                    debt, and expenses arising from your use of the service or violation of these Terms.
                </p>
            </div>

            <!-- Section 12 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">12. Governing Law</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    These Terms shall be governed by and construed in accordance with the laws of the Philippines, without 
                    regard to its conflict of law provisions. Any disputes arising from these Terms or your use of the service 
                    shall be subject to the exclusive jurisdiction of the courts located in the Philippines.
                </p>
            </div>

            <!-- Section 13 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">13. Changes to Terms</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    We reserve the right to modify or replace these Terms at any time at our sole discretion. If a revision 
                    is material, we will provide at least 30 days' notice prior to any new terms taking effect. What constitutes 
                    a material change will be determined at our sole discretion. By continuing to access or use our service 
                    after those revisions become effective, you agree to be bound by the revised terms.
                </p>
            </div>

            <!-- Section 14 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">14. Contact Information</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed mb-4">
                    If you have any questions about these Terms of Service, please contact us at:
                </p>
                <div class="font-lora text-gray-700 text-base leading-relaxed space-y-1">
                    <p><strong>Email:</strong> support@jauxsh.com</p>
                    <p><strong>Phone:</strong> +63 XXX XXX XXXX</p>
                    <p><strong>Address:</strong> Daet, Camarines Norte, Philippines</p>
                </div>
            </div>

            <!-- Section 15 -->
            <div>
                <h2 class="font-cg font-bold text-2xl uppercase text-gray-900 mb-4 tracking-wide">15. Severability</h2>
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    If any provision of these Terms is held to be unenforceable or invalid, such provision will be changed 
                    and interpreted to accomplish the objectives of such provision to the greatest extent possible under 
                    applicable law, and the remaining provisions will continue in full force and effect.
                </p>
            </div>

            <!-- Acceptance -->
            <div class="bg-gray-50 p-8 rounded-sm border-l-4 border-[#1fac99ff]">
                <p class="font-lora text-gray-700 text-base leading-relaxed">
                    By using Jauxsh's website and services, you acknowledge that you have read, understood, and agree to be 
                    bound by these Terms of Service.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection