// Improved implementation for fullscreen delete modal
document.addEventListener('DOMContentLoaded', function() {
    // Get references to delete modal elements
    const deleteModal = document.getElementById('deleteModal');
    
    // If modal doesn't exist on this page, exit early
    if (!deleteModal) return;
    
    // Ensure the modal has fullscreen-modal class
    if (!deleteModal.classList.contains('fullscreen-modal')) {
        deleteModal.classList.add('fullscreen-modal');
    }
    
    // Create a custom backdrop
    const createBackdrop = () => {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop-fs';
        backdrop.style.opacity = '0';
        document.body.appendChild(backdrop);
        
        // Force reflow to enable transition
        void backdrop.offsetWidth;
        backdrop.style.opacity = '1';
        
        return backdrop;
    };
    
    // Setup delete triggers
    const deleteButtons = document.querySelectorAll('[data-toggle="delete-modal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get product data
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productImage = this.getAttribute('data-image');
            const deleteUrl = this.getAttribute('data-url');
            
            // Update modal content with product data
            document.getElementById('delete-product-id').textContent = productId;
            document.getElementById('delete-product-name').textContent = productName;
            document.getElementById('delete-product-image').src = productImage;
            document.getElementById('delete-product-form').action = deleteUrl;
            
            // Show modal with custom animation
            const backdrop = createBackdrop();
            
            // Show modal
            deleteModal.style.display = 'flex';
            void deleteModal.offsetWidth; // Force reflow
            deleteModal.classList.add('show');
            
            // Disable body scrolling
            document.body.style.overflow = 'hidden';
            
            // Add pulse animation to image
            const productImg = document.getElementById('delete-product-image');
            if (productImg) {
                productImg.classList.add('pulse');
            }
            
            // Setup close handlers
            const closeButtons = deleteModal.querySelectorAll('[data-bs-dismiss="modal"]');
            closeButtons.forEach(button => {
                button.addEventListener('click', closeModal);
            });
            
            // Close when clicking outside modal
            backdrop.addEventListener('click', closeModal);
            
            // Close with Escape key
            document.addEventListener('keydown', escKeyHandler);
            
            function escKeyHandler(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            }
            
            function closeModal() {
                // Remove event listeners
                closeButtons.forEach(button => {
                    button.removeEventListener('click', closeModal);
                });
                backdrop.removeEventListener('click', closeModal);
                document.removeEventListener('keydown', escKeyHandler);
                
                // Hide modal
                deleteModal.classList.remove('show');
                backdrop.style.opacity = '0';
                
                // Remove elements after animation
                setTimeout(() => {
                    deleteModal.style.display = 'none';
                    document.body.removeChild(backdrop);
                    
                    // Re-enable body scrolling
                    document.body.style.overflow = '';
                    
                    // Remove pulse animation
                    if (productImg) {
                        productImg.classList.remove('pulse');
                    }
                }, 300);
            }
        });
    });
    
    // Ensure clicking on modal content doesn't close it
    const modalContent = deleteModal.querySelector('.modal-content');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
