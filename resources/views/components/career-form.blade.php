@props(['action' => null])

<div class="career-form-component">
    <form method="POST" action="{{ $action ?? route('careers.store') }}" enctype="multipart/form-data" class="space-y-6" id="career-form">
        @csrf

        <!-- Position Applied For -->
        <div>
            <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Position Applied For *</label>
            <select id="job_title" name="job_title"
                    class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 bg-white @error('job_title') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror" required>
                <option value="">Select Position</option>
                <option value="Islamic Studies Teacher" {{ old('job_title') == 'Islamic Studies Teacher' ? 'selected' : '' }}>Islamic Studies Teacher</option>
                <option value="Mathematics Teacher" {{ old('job_title') == 'Mathematics Teacher' ? 'selected' : '' }}>Mathematics Teacher</option>
                <option value="Administrative Assistant" {{ old('job_title') == 'Administrative Assistant' ? 'selected' : '' }}>Administrative Assistant</option>
                <option value="Science Laboratory Technician" {{ old('job_title') == 'Science Laboratory Technician' ? 'selected' : '' }}>Science Laboratory Technician</option>
                <option value="General Application" {{ old('job_title') == 'General Application' ? 'selected' : '' }}>General Application</option>
            </select>
            @error('job_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Personal Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label for="applicant_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" id="applicant_name" name="applicant_name" value="{{ old('applicant_name') }}"
                       class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 @error('applicant_name') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror" required>
                @error('applicant_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                       class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 @error('phone') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cover Letter -->
        <div>
            <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
            <textarea id="cover_letter" name="cover_letter" rows="6" class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 resize-y @error('cover_letter') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror"
                      placeholder="Tell us why you're interested in this position and what makes you a good fit...">{{ old('cover_letter') }}</textarea>
            @error('cover_letter')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Resume Upload -->
        <div class="bg-blue-50 p-3 sm:p-4 rounded-xl">
            <h4 class="text-sm sm:text-base font-semibold text-gray-900 mb-2">Resume/CV Upload *</h4>
            <p class="text-xs sm:text-sm text-gray-600 mb-3">Please upload your resume in PDF format (Maximum 5MB)</p>
            <div>
                <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Select Resume File</label>
                <input type="file" id="resume" name="resume" accept=".pdf"
                       class="w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 @error('resume') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-slate-300 focus:border-indigo-600 focus:ring-indigo-500 @enderror" required>
                @error('resume')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="inline-flex items-center justify-center font-semibold text-white transition-all duration-300 min-h-[44px] rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 shadow-primary hover:shadow-primary-hover hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 text-base sm:px-8 sm:py-4 w-full sm:w-auto" id="submit-btn">
                Submit Application
            </button>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 px-4">By submitting this application, you agree to our privacy policy and terms of service.</p>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('career-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
    });
});
</script>