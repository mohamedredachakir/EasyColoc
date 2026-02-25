/**
 * EasyColoc — Premium UI Interactions
 * Handles modals, toasts, and global UX events.
 */
document.addEventListener('DOMContentLoaded', () => {

    // ── Modal open / close ──────────────────────────────────────
    const openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    // Close modal when clicking the dark backdrop (both overlay classes)
    document.querySelectorAll('.modal-overlay-v3, .modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay-v3.active, .modal-overlay.active').forEach(m => {
                m.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });

    // Expose globally
    window.ui = { openModal, closeModal };

    // ── Toast auto-dismiss ──────────────────────────────────────
    document.querySelectorAll('.toast, .alert-float').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-14px)';
            setTimeout(() => el.remove(), 450);
        }, 4200);
    });

});
