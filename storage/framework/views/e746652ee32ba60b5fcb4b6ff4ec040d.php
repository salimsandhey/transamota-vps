<?php $__env->startSection('title', 'Contact Us - Transamota'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Contact Us</h1>
            <p class="text-xl max-w-3xl mx-auto">Have questions? We're here to help. Reach out to our team anytime.</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Send us a message</h2>
                    
                    <form id="contact-form" method="POST" action="<?php echo e(route('contact.store')); ?>" class="space-y-6">
                                            <?php echo csrf_field(); ?>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <button type="submit" 
                                class="w-full px-6 py-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                Send Message
                            </button>
                        </div>
                    <div id="toast-container"></div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        <?php if(session('success')): ?>
                            if (typeof Toast !== 'undefined') {
                                Toast.show('<?php echo e(session('success')); ?>', 'success');
                            } else {
                                // Fallback to simple alert if Toast is not available
                                alert('<?php echo e(session('success')); ?>');
                            }
                        <?php endif; ?>
                        
                        // Handle form submission with AJAX
                        const contactForm = document.getElementById('contact-form');
                        if (contactForm) {
                            contactForm.addEventListener('submit', function(e) {
                                e.preventDefault();
                                
                                const submitButton = contactForm.querySelector('button[type="submit"]');
                                const originalText = submitButton.textContent;
                                
                                // Disable button and show loading state
                                submitButton.disabled = true;
                                submitButton.textContent = 'Sending...';
                                
                                const formData = new FormData(contactForm);
                                
                                fetch(contactForm.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Show success toast
                                        if (typeof Toast !== 'undefined') {
                                            Toast.show(data.message, 'success');
                                        } else {
                                            alert(data.message);
                                        }
                                        
                                        // Reset form
                                        contactForm.reset();
                                    } else {
                                        // Show error toast
                                        if (typeof Toast !== 'undefined') {
                                            Toast.show('An error occurred. Please try again.', 'error');
                                        } else {
                                            alert('An error occurred. Please try again.');
                                        }
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    // Show error toast
                                    if (typeof Toast !== 'undefined') {
                                        Toast.show('An error occurred. Please try again.', 'error');
                                    } else {
                                        alert('An error occurred. Please try again.');
                                    }
                                })
                                .finally(() => {
                                    // Re-enable button
                                    submitButton.disabled = false;
                                    submitButton.textContent = originalText;
                                });
                            });
                        }
                    });
                    </script>
                                        </form>
                </div>
                
                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Get in touch</h2>
                    
                    <div class="space-y-8">
                        <!-- Office Address -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Office Address</h3>
                                <p class="text-gray-600">123 Business Avenue<br>Trade District, Dubai<br>United Arab Emirates</p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Phone</h3>
                                <p class="text-gray-600">+971 4 123 4567<br>+971 50 123 4567 (WhatsApp)</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Email</h3>
                                <p class="text-gray-600">support@transamota.com<br>partnerships@transamota.com</p>
                            </div>
                        </div>
                        
                        <!-- Business Hours -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Business Hours</h3>
                                <p class="text-gray-600">Sunday - Thursday: 9:00 AM - 6:00 PM<br>Friday - Saturday: Closed</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <!-- <div class="mt-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.477 2 2 6.477 2 12c0 5.523 4.477 10 10 10 5.523 0 10-4.477 10-10 0-5.523-4.477-10-10-10zm-1.75 15c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75 1.75.784 1.75 1.75-.784 1.75-1.75 1.75zm3.25-6.5c0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5.672-1.5 1.5-1.5 1.5.672 1.5 1.5zm-6.5 0c0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5.672-1.5 1.5-1.5 1.5.672 1.5 1.5z"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                                </svg>
                            </a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Find answers to common questions about our services</p>
            </div>
            
            <div class="text-center">
                <p class="text-gray-600 mb-6">For a complete list of frequently asked questions, visit our dedicated FAQ page.</p>
                <a href="<?php echo e(route('faq')); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    View All FAQs
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/contact.blade.php ENDPATH**/ ?>