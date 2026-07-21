document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-ajax="true"]').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = form.querySelector('[type="submit"], button');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

            try {
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message || 'Success', 'success');
                    const target = form.dataset.target;
                    if (target) {
                        const el = document.querySelector(target);
                        if (el && data.html) {
                            el.outerHTML = data.html;
                        } else if (el && data.partial) {
                            el.innerHTML = data.partial;
                        }
                    }
                } else {
                    showToast(data.message || 'Sync failed', 'danger');
                }
            } catch (err) {
                showToast('Connection error. Please try again.', 'danger');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    });
});

function showToast(message, type) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const colors = {
        success: 'bg-emerald-600',
        danger: 'bg-red-600',
        warning: 'bg-orange-500',
        info: 'bg-blue-600',
    };

    const toast = document.createElement('div');
    toast.className = `${colors[type] || 'bg-slate-700'} text-white px-5 py-3 rounded-xl shadow-lg mb-3 text-sm font-semibold transition-all duration-300`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(function () {
        toast.style.opacity = '0';
        setTimeout(function () { toast.remove(); }, 300);
    }, 4000);
}
