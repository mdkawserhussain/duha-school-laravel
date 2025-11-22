{{-- Contact Form Component for Zaitoon Academy --}}
@props([
    'title' => 'Get in Touch',
    'description' => 'Have a question? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.',
    'showMap' => false,
    'submitUrl' => '/contact'
])

<div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
    {{-- Heading --}}
    @if($title)
    <div class="mb-8">
        <h3 class="text-3xl font-serif font-bold text-za-green-primary mb-3">{{ $title }}</h3>
        @if($description)
        <p class="text-gray-600">{{ $description }}</p>
        @endif
    </div>
    @endif

    {{-- Form --}}
    <form
        x-data="{
            formData: {
                name: '',
                email: '',
                phone: '',
                subject: '',
                message: ''
            },
            loading: false,
            success: false,
            errors: {},
            
            async submit() {
                this.loading = true;
                this.success = false;
                this.errors = {};
                
                try {
                    const response = await fetch('{{ $submitUrl }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify(this.formData)
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.success = true;
                        this.formData = { name: '', email: '', phone: '', subject: '', message: '' };
                        setTimeout(() => { this.success = false; }, 5000);
                    } else {
                        this.errors = data.errors || {};
                    }
                } catch (error) {
                    this.errors = { general: ['Network error. Please try again.'] };
                } finally {
                    this.loading = false;
                }
            }
        }"
        @submit.prevent="submit()"
        class="space-y-6"
    >
        {{-- Success Message --}}
        <div 
            x-show="success" 
            x-transition
            class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-800"
            style="display: none;"
        >
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="font-semibold">Message sent successfully! We'll get back to you soon.</p>
            </div>
        </div>

        {{-- General Error --}}
        <div 
            x-show="errors.general" 
            x-transition
            class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800"
            style="display: none;"
        >
            <p x-text="errors.general ? errors.general[0] : ''"></p>
        </div>

        {{-- Name Field --}}
        <div>
            <label for="contact-name" class="block text-sm font-semibold text-gray-700 mb-2">
                Full Name <span class="text-red-500">*</span>
            </label>
            <input
                x-model="formData.name"
                type="text"
                id="contact-name"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-za-green-primary focus:border-transparent transition-all"
                :class="errors.name ? 'border-red-500' : ''"
                placeholder="John Doe"
                required
            >
            <p x-show="errors.name" x-text="errors.name ? errors.name[0] : ''" class="mt-1 text-sm text-red-500"></p>
        </div>

        {{-- Email & Phone Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Email --}}
            <div>
                <label for="contact-email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input
                    x-model="formData.email"
                    type="email"
                    id="contact-email"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-za-green-primary focus:border-transparent transition-all"
                    :class="errors.email ? 'border-red-500' : ''"
                    placeholder="john@example.com"
                    required
                >
                <p x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="mt-1 text-sm text-red-500"></p>
            </div>

            {{-- Phone --}}
            <div>
                <label for="contact-phone" class="block text-sm font-semibold text-gray-700 mb-2">
                    Phone Number
                </label>
                <input
                    x-model="formData.phone"
                    type="tel"
                    id="contact-phone"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-za-green-primary focus:border-transparent transition-all"
                    :class="errors.phone ? 'border-red-500' : ''"
                    placeholder="+1 (555) 123-4567"
                >
                <p x-show="errors.phone" x-text="errors.phone ? errors.phone[0] : ''" class="mt-1 text-sm text-red-500"></p>
            </div>
        </div>

        {{-- Subject --}}
        <div>
            <label for="contact-subject" class="block text-sm font-semibold text-gray-700 mb-2">
                Subject <span class="text-red-500">*</span>
            </label>
            <input
                x-model="formData.subject"
                type="text"
                id="contact-subject"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-za-green-primary focus:border-transparent transition-all"
                :class="errors.subject ? 'border-red-500' : ''"
                placeholder="Admission Inquiry"
                required
            >
            <p x-show="errors.subject" x-text="errors.subject ? errors.subject[0] : ''" class="mt-1 text-sm text-red-500"></p>
        </div>

        {{-- Message --}}
        <div>
            <label for="contact-message" class="block text-sm font-semibold text-gray-700 mb-2">
                Message <span class="text-red-500">*</span>
            </label>
            <textarea
                x-model="formData.message"
                id="contact-message"
                rows="6"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-za-green-primary focus:border-transparent transition-all resize-none"
                :class="errors.message ? 'border-red-500' : ''"
                placeholder="Tell us how we can help you..."
                required
            ></textarea>
            <p x-show="errors.message" x-text="errors.message ? errors.message[0] : ''" class="mt-1 text-sm text-red-500"></p>
        </div>

        {{-- Privacy Notice --}}
        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
            <svg class="w-5 h-5 text-za-green-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-sm text-gray-600">
                Your information is secure and will only be used to respond to your inquiry. Read our 
                <a href="{{ route('privacy.show') }}" class="text-za-green-primary hover:text-za-yellow-accent font-semibold">Privacy Policy</a>.
            </p>
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full px-8 py-4 bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-bold rounded-full transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-za-yellow disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
            :disabled="loading"
        >
            <span x-show="!loading" class="flex items-center justify-center gap-2">
                <span>Send Message</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </span>
            <span x-show="loading" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Sending...</span>
            </span>
        </button>
    </form>
</div>
