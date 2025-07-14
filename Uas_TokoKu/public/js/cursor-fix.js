// Cursor Fix Script - Solusi untuk mengatasi masalah kedipan kursor dan flicker pada modal

(function() {
    // Fungsi untuk mendeteksi perangkat mobile
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    // Fungsi untuk memperbaiki masalah kedipan kursor dan flicker pada modal
    function fixCursorAndModalFlickering() {
        // Untuk desktop saja
        if (isMobileDevice()) return;
        
        // Memperbaiki kursor saat hover pada elemen yang berbeda
        const defaultCursor = document.body.style.cursor;
        
        // Fungsi untuk menetapkan kursor
        function setCursorForElement(element, cursor) {
            element.addEventListener('mouseover', function() {
                document.body.style.cursor = cursor;
            });
            
            element.addEventListener('mouseout', function() {
                document.body.style.cursor = defaultCursor;
            });
        }
        
        // Set kursor untuk semua elemen
        document.querySelectorAll('a, button, .btn, [role="button"], .nav-link, .clickable').forEach(function(el) {
            setCursorForElement(el, 'pointer');
        });
        
        document.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], input[type="password"], textarea').forEach(function(el) {
            setCursorForElement(el, 'text');
        });
        
        document.querySelectorAll('select, select.form-control, select.form-select').forEach(function(el) {
            setCursorForElement(el, 'pointer');
        });
        
        // Perbaikan untuk modal - mencegah flicker pada modal
        const fixModals = function() {
            // Pre-initialize modals to prevent flicker
            document.querySelectorAll('.modal').forEach(function(modal) {
                // Add hardware acceleration class
                modal.classList.add('hw-accelerated');
                
                // Prevent backdrop flicker
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.classList.add('hw-accelerated');
                    backdrop.style.willChange = 'opacity';
                }
                
                // Ensure smooth transitions by disabling them initially
                modal.style.transition = 'none';
                
                // Apply optimizations directly to each part of the modal
                if (modal.querySelector('.modal-content')) {
                    const content = modal.querySelector('.modal-content');
                    content.classList.add('hw-accelerated');
                    content.style.willChange = 'transform';
                    content.style.transform = 'translateZ(0)';
                    content.style.transition = 'none';
                }
                
                if (modal.querySelector('.modal-dialog')) {
                    const dialog = modal.querySelector('.modal-dialog');
                    dialog.classList.add('hw-accelerated');
                    dialog.style.transform = 'translateZ(0) translate(0, 0)';
                    dialog.style.transition = 'none';
                }
                
                // Disable pointer events during animation to prevent flicker
                modal.style.pointerEvents = 'none';
                setTimeout(() => {
                    modal.style.pointerEvents = 'auto';
                }, 300);
            });
            
            // Fix modal triggers
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(trigger) {
                // Remove any existing handlers and replace with our optimized version
                const originalOnClick = trigger.onclick;
                trigger.onclick = null;
                
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Apply hardware acceleration to prevent flicker
                    const targetId = this.getAttribute('data-bs-target');
                    const targetModal = document.querySelector(targetId);
                    
                    if (targetModal) {
                        // Force hardware acceleration
                        targetModal.style.transform = 'translateZ(0)';
                        targetModal.style.backfaceVisibility = 'hidden';
                        targetModal.style.webkitBackfaceVisibility = 'hidden';
                        targetModal.style.perspective = '1000px';
                        targetModal.style.webkitPerspective = '1000px';
                        targetModal.style.willChange = 'opacity';
                        
                        // Force layout recalculation before showing
                        void targetModal.offsetWidth;
                        
                        // Show modal after minimal delay
                        requestAnimationFrame(() => {
                            try {
                                const bsModal = new bootstrap.Modal(targetModal);
                                bsModal.show();
                            } catch (error) {
                                console.error("Error showing modal:", error);
                            }
                        });
                    }
                }, { capture: true });
            });
            
            // Apply fix to existing modals
            const existingModals = document.querySelectorAll('.modal');
            existingModals.forEach(modal => {
                // Force hardware acceleration
                modal.style.transform = 'translateZ(0)';
                modal.style.backfaceVisibility = 'hidden';
                modal.style.webkitBackfaceVisibility = 'hidden';
            });
        };
        
        // Fix for form elements to prevent accidental selection cancellation
        const formElements = document.querySelectorAll('input, textarea, select, button, a.btn');
        formElements.forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // Only prevent selection on non-input elements
        document.addEventListener('mousedown', function(e) {
            if (e.target.tagName !== 'INPUT' && 
                e.target.tagName !== 'TEXTAREA' && 
                e.target.tagName !== 'SELECT' &&
                e.target.tagName !== 'BUTTON' &&
                e.target.tagName !== 'A' &&
                !e.target.closest('.modal-content') && // Don't prevent events inside modals
                !e.target.closest('form') && // Don't prevent in forms
                e.target.isContentEditable !== true) {
                e.preventDefault();
            }
        }, { passive: false });
        
        // Apply hardware acceleration to elements that need it
        document.querySelectorAll('.modal, .modal-dialog, .modal-content, .alert').forEach(function(el) {
            el.classList.add('hw-accelerated');
        });
        
        // Mencegah pemilihan teks tidak disengaja
        document.body.classList.add('no-select');
        
        // Tambahkan kelas untuk elemen yang perlu dapat dipilih
        document.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], input[type="password"], textarea').forEach(function(el) {
            el.classList.add('can-select');
            el.classList.remove('no-select');
        });
        
        // Fix modals after DOM is fully loaded
        setTimeout(fixModals, 100);
    }
    
    // Jalankan ketika DOM sudah siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fixCursorAndModalFlickering);
    } else {
        fixCursorAndModalFlickering();
    }
})();
