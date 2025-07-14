/**
 * Modal Fix Script (Advanced Version)
 * Solves the Bootstrap modal backdrop and focus trap issues
 */

(function() {
    'use strict';
    
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Fix modals
        fixModals();
        
        // Additional event handlers to ensure modals work properly
        setupModalEventHandlers();
    });

    function fixModals() {
        // Move all modals to the end of the body to prevent z-index issues
        document.querySelectorAll('.modal').forEach(function(modal) {
            // Detach and move to end of body
            document.body.appendChild(modal);
            
            // Ensure proper backdrop removal
            modal.addEventListener('hidden.bs.modal', function() {
                // Force cleanup of backdrop and body classes
                setTimeout(function() {
                    if (!document.querySelector('.modal.show')) {
                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.paddingRight = '';
                        document.body.style.overflow = '';
                    }
                }, 200);
            });
        });
    }
    
    function setupModalEventHandlers() {
        // Handle modal show event
        document.addEventListener('show.bs.modal', function(event) {
            // Ensure any existing backdrops are removed first
            document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                if (!document.querySelector('.modal.show')) {
                    backdrop.remove();
                }
            });
            
            // Ensure the clicked modal gets proper focus
            const targetModal = event.target;
            setTimeout(function() {
                const firstFocusable = targetModal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }, 300);
        });

        // Handle modal close by escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const bootstrapModal = bootstrap.Modal.getInstance(openModal);
                    if (bootstrapModal) {
                        bootstrapModal.hide();
                    }
                }
            }
        });
        
        // Ensure proper modal closure
        document.addEventListener('click', function(event) {
            if (event.target.hasAttribute('data-bs-dismiss') || 
                event.target.classList.contains('modal')) {
                const modalElement = event.target.closest('.modal') || event.target;
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                    
                    // Ensure cleanup happens
                    setTimeout(function() {
                        if (!document.querySelector('.modal.show')) {
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }
                    }, 300);
                }
            }
        });
    }
})();
