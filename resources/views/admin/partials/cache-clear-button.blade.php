{{-- Cache Clear Button Component --}}
<div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <div class="flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-yellow-800">Cache Management</h4>
            <p class="text-xs text-yellow-700 mt-1">Clear homepage cache to see changes immediately on the frontend.</p>
        </div>
        <button 
            type="button"
            onclick="clearHomepageCache()"
            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg transition-colors"
            id="cache-clear-btn">
            Clear Cache
        </button>
    </div>
</div>

<script>
function clearHomepageCache() {
    // Confirmation dialog
    if (!confirm('Are you sure you want to clear the homepage cache?')) {
        return;
    }
    
    const btn = document.getElementById('cache-clear-btn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Clearing...';
    
    fetch('{{ route("admin.cache.clear-homepage") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.textContent = 'Cache Cleared!';
            btn.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            
            // Show success toast notification
            showToast('Homepage cache cleared successfully!', 'success');
            
            setTimeout(() => {
                btn.textContent = originalText;
                btn.disabled = false;
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
            }, 2000);
        } else {
            throw new Error(data.message || 'Failed to clear cache');
        }
    })
    .catch(error => {
        btn.textContent = 'Error';
        btn.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
        btn.classList.add('bg-red-600', 'hover:bg-red-700');
        
        // Show error toast notification
        showToast('Failed to clear cache. Please try again.', 'error');
        
        setTimeout(() => {
            btn.textContent = originalText;
            btn.disabled = false;
            btn.classList.remove('bg-red-600', 'hover:bg-red-700');
            btn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        }, 2000);
        console.error('Cache clear error:', error);
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-semibold ${
        type === 'success' ? 'bg-green-600' : 'bg-red-600'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

