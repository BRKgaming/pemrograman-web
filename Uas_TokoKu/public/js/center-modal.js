// Center Modal JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Function to apply center-modal class to specific modals
    function setupCenteredModals() {
        // Target delete confirmation modals specifically
        const deleteModals = document.querySelectorAll('.delete-confirm-modal, .fullscreen-modal');
        
        deleteModals.forEach(modal => {
            if (!modal.classList.contains('center-modal')) {
                modal.classList.add('center-modal');
            }
            
            // Handle backdrop manually for better control
            modal.setAttribute('data-backdrop', 'static');
            modal.setAttribute('data-keyboard', 'false');
            
            // Initialize Bootstrap modal with specific options
            $(modal).on('show.bs.modal', function() {
                // Force hardware acceleration
                document.body.classList.add('hw-accelerated');
                
                // Ensure modal is shown with proper z-index
                setTimeout(() => {
                    this.style.zIndex = '1050';
                }, 10);
            });
            
            $(modal).on('shown.bs.modal', function() {
                // Ensure modal content is clickable
                const content = this.querySelector('.modal-content');
                if (content) {
                    content.style.pointerEvents = 'all';
                }
            });
            
            $(modal).on('hide.bs.modal', function() {
                // Clean up
                document.body.classList.remove('hw-accelerated');
            });
        });
    }
    
    // Custom click handler for delete confirmation
    function setupDeleteConfirmationHandlers() {
        document.querySelectorAll('[data-toggle="delete-confirm"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const target = this.getAttribute('data-target') || this.getAttribute('href');
                const modal = document.querySelector(target);
                
                if (modal) {
                    // Apply center-modal class if not already present
                    if (!modal.classList.contains('center-modal')) {
                        modal.classList.add('center-modal');
                    }
                    
                    // Show modal with jQuery to ensure Bootstrap's modal functionality works
                    $(modal).modal('show');
                    
                    // Ensure the modal is properly centered by forcing a reflow
                    setTimeout(() => {
                        const dialog = modal.querySelector('.modal-dialog');
                        if (dialog) {
                            dialog.style.display = 'flex';
                            dialog.style.alignItems = 'center';
                            dialog.style.justifyContent = 'center';
                        }
                    }, 50);
                }
            });
        });
    }
    
    // Handle ESC key to close modal properly
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.modal.show');
            if (activeModal && !activeModal.hasAttribute('data-keyboard') || 
                activeModal.getAttribute('data-keyboard') !== 'false') {
                $(activeModal).modal('hide');
            }
        }
    });
    
    // Run setup functions
    setupCenteredModals();
    setupDeleteConfirmationHandlers();
    
    // Re-run setup after AJAX content loads
    document.addEventListener('DOMNodeInserted', function(e) {
        if (e.target.tagName && 
            (e.target.tagName.toLowerCase() === 'div' && e.target.classList.contains('modal')) ||
            (e.target.querySelector && e.target.querySelector('.modal'))) {
            setTimeout(() => {
                setupCenteredModals();
                setupDeleteConfirmationHandlers();
            }, 50);
        }
    });
});
