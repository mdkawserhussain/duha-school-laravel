<div class="newsletter-signup">
    <form id="newsletter-form" class="flex gap-2">
        @csrf
        <input
            type="email"
            id="newsletter-email"
            name="email"
            placeholder="Email"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
        >
        <button
            type="submit"
            id="newsletter-submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap"
        >
            Subscribe
        </button>
    </form>

    <div id="newsletter-message" class="mt-4 hidden">
        <p id="newsletter-message-text" class="text-sm"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const submitBtn = document.getElementById('newsletter-submit');
    const messageDiv = document.getElementById('newsletter-message');
    const messageText = document.getElementById('newsletter-message-text');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('newsletter-email').value;

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Subscribing...';

        // Hide previous messages
        messageDiv.classList.add('hidden');

        // Send AJAX request
        fetch('{{ route("newsletter.subscribe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: email
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.classList.remove('hidden');
                messageDiv.classList.add('text-green-600');
                messageText.textContent = data.message || 'Successfully subscribed!';
                form.reset();
            } else {
                throw new Error(data.message || 'Subscription failed');
            }
        })
        .catch(error => {
            console.error('Newsletter subscription error:', error);
            messageDiv.classList.remove('hidden');
            messageDiv.classList.add('text-red-600');
            messageText.textContent = error.message || 'An error occurred. Please try again.';
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Subscribe';
        });
    });
});
</script>