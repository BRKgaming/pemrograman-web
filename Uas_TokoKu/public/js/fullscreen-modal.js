// Fullscreen Modal JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Preload delete modal content untuk mencegah flicker
    preloadDeleteModalImages();

    // Setup delegasi event untuk modal dan tombol delete
    setupDeleteModalEvents();
});

function preloadDeleteModalImages() {
    // Mengambil semua data-image dari delete buttons
    const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteModal"][data-image]');
    
    deleteButtons.forEach(button => {
        const imageUrl = button.getAttribute('data-image');
        if (imageUrl) {
            const img = new Image();
            img.src = imageUrl;
        }
    });
}

function setupDeleteModalEvents() {
    // Modal element
    const modal = document.getElementById('deleteModal');
    
    if (!modal) return;
    
    // Convert to fullscreen modal
    modal.classList.add('fullscreen-modal');
    modal.classList.remove('modal', 'fade');
    
    // Remove default modal backdrop (will be handled by fullscreen-modal)
    modal.setAttribute('data-bs-backdrop', 'false');
    
    // Delegate click events for opening the modal
    document.body.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('[data-bs-toggle="modal"][data-bs-target="#deleteModal"]');
        
        if (deleteButton) {
            e.preventDefault();
            
            // Get data from button
            const productName = deleteButton.getAttribute('data-product-name');
            const productId = deleteButton.getAttribute('data-product-id');
            const imageUrl = deleteButton.getAttribute('data-image');
            const deleteUrl = deleteButton.getAttribute('data-url');
            
            // Update modal content
            if (productName) {
                document.getElementById('delete-product-name').textContent = productName;
            }
            
            if (imageUrl) {
                const imgElement = document.getElementById('delete-product-image');
                if (imgElement) {
                    imgElement.src = imageUrl;
                }
            }
            
            // Set form action
            const deleteForm = document.getElementById('delete-product-form');
            if (deleteForm && deleteUrl) {
                deleteForm.action = deleteUrl;
            }
            
            // Open modal
            openFullscreenModal(modal);
        }
    });
    
    // Close modal when clicking outside content
    modal.addEventListener('click', function(e) {
        // If click is directly on the modal (backdrop) and not on any of its children
        if (e.target === modal) {
            closeFullscreenModal(modal);
        }
    });
    
    // Close modal when clicking close buttons
    const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            closeFullscreenModal(modal);
        });
    });
    
    // Handle delete button and form submission
    const deleteForm = document.getElementById('delete-product-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            // Get delete button
            const deleteButton = this.querySelector('button[type="submit"]');
            
            if (deleteButton) {
                // Disable button and show loading state
                deleteButton.disabled = true;
                
                // Change button text to loading
                const originalText = deleteButton.textContent;
                deleteButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menghapus...';
                
                // Return true to allow form submission
                return true;
            }
        });
    }
}

function openFullscreenModal(modal) {
    if (!modal) return;
    
    // Add modal-open to body
    document.body.classList.add('modal-open');
    
    // Show modal
    modal.style.display = 'flex';
    modal.classList.add('show', 'animate-in');
    
    // Focus first focusable element in modal
    setTimeout(() => {
        const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (focusable) {
            focusable.focus();
        }
    }, 150);
}

function closeFullscreenModal(modal) {
    if (!modal) return;
    
    // Add animation out class
    modal.classList.add('animate-out');
    modal.classList.remove('animate-in');
    
    // Wait for animation to complete
    setTimeout(() => {
        // Hide modal
        modal.classList.remove('show', 'animate-out');
        modal.style.display = 'none';
        
        // Remove modal-open from body
        document.body.classList.remove('modal-open');
    }, 150);
}
