@props(['action' => null])

<div class="admission-form-component">
    <form method="POST" action="{{ $action ?? route('admission.store') }}" enctype="multipart/form-data" class="space-y-6" id="admission-form">
        @csrf

        <!-- Parent Information -->
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Parent/Guardian Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('parent_name') border-red-500 @enderror" required>
                    @error('parent_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Child Information -->
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Child Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="child_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" id="child_name" name="child_name" value="{{ old('child_name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('child_name') border-red-500 @enderror" required>
                    @error('child_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="child_dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                    <input type="date" id="child_dob" name="child_dob" value="{{ old('child_dob') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('child_dob') border-red-500 @enderror" required>
                    @error('child_dob')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <label for="grade_applied" class="block text-sm font-medium text-gray-700 mb-1">Grade Applied For *</label>
                <select id="grade_applied" name="grade_applied"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('grade_applied') border-red-500 @enderror" required>
                    <option value="">Select Grade</option>
                    <option value="Kindergarten" {{ old('grade_applied') == 'Kindergarten' ? 'selected' : '' }}>Kindergarten</option>
                    <option value="Grade 1" {{ old('grade_applied') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                    <option value="Grade 2" {{ old('grade_applied') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                    <option value="Grade 3" {{ old('grade_applied') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                    <option value="Grade 4" {{ old('grade_applied') == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                    <option value="Grade 5" {{ old('grade_applied') == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                    <option value="Grade 6" {{ old('grade_applied') == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                    <option value="Grade 7" {{ old('grade_applied') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_applied') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_applied') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_applied') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_applied') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_applied') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                </select>
                @error('grade_applied')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Additional Information -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Additional Information</label>
            <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror"
                      placeholder="Please provide any additional information about your child or special requirements...">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Documents Upload -->
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-900 mb-2">Supporting Documents (Optional)</h4>
            <p class="text-sm text-gray-600 mb-3">You can upload supporting documents now or provide them later. Accepted formats: PDF, JPG, JPEG, PNG (Max 5MB each)</p>
            <div>
                <label for="documents" class="block text-sm font-medium text-gray-700 mb-1">Upload Documents</label>
                <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('documents.*') border-red-500 @enderror">
                @error('documents.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed" id="submit-btn">
                Submit Application
            </button>
            <p class="text-sm text-gray-600 mt-2">By submitting this form, you agree to our terms and conditions.</p>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('admission-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
    });
});
</script>