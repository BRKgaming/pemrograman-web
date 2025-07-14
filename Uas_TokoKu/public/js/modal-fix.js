/**
 * Modal Anti-flicker Script
 * Solusi untuk mengatasi masalah flicker/kedipan pada modal Bootstrap
 */

(function() {
    // Fungsi untuk mendeteksi jenis perangkat
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Fungsi untuk memperbaiki masalah flicker modal
    function fixModalFlickering() {
        // Jangan jalankan kode ini di perangkat mobile (kurang relevan dan bisa mempengaruhi kinerja)
        if (isMobileDevice()) return;

        // Fix untuk modal Bootstrap
        const fixBootstrapModal = function() {
            // Override Bootstrap modal show method
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                // Cadangkan method asli
                const originalShow = bootstrap.Modal.prototype.show;
                
                // Override method
                bootstrap.Modal.prototype.show = function() {
                    // Pastikan backdrop stabil
                    if (this._config) {
                        this._config.backdrop = 'static';
                        this._config.keyboard = false;
                    }
                    
                    // Pastikan modalnya sudah disiapkan
                    if (this._element) {
                        // Tambahkan kelas untuk hardware acceleration
                        this._element.classList.add('hw-accelerated');
                        
                        // Tambahkan pengaturan CSS inline untuk mencegah flicker
                        this._element.style.transform = 'translateZ(0)';
                        this._element.style.backfaceVisibility = 'hidden';
                        this._element.style.willChange = 'opacity';
                        
                        // Pastikan dialog juga dioptimalkan
                        const dialog = this._element.querySelector('.modal-dialog');
                        if (dialog) {
                            dialog.style.transform = 'none';
                            dialog.style.transition = 'none';
                        }
                        
                        // Pastikan konten juga dioptimalkan
                        const content = this._element.querySelector('.modal-content');
                        if (content) {
                            content.style.transform = 'translateZ(0)';
                            content.style.backfaceVisibility = 'hidden';
                        }
                    }
                    
                    // Panggil method asli setelah optimasi
                    return originalShow.apply(this, arguments);
                };
                
                // Tangani semua modal yang ada di halaman
                document.querySelectorAll('.modal').forEach(function(modalElement) {
                    // Nonaktifkan animasi bawaan
                    modalElement.classList.add('no-animation');
                    
                    // Tambahkan kelas untuk hardware acceleration
                    modalElement.classList.add('hw-accelerated');
                });
            }
        };

        // Tangani modal saat akan muncul
        document.addEventListener('show.bs.modal', function(event) {
            // Target modal yang akan muncul
            const modal = event.target;
            
            // Optimalkan tampilan modal
            modal.style.display = 'block';
            modal.style.transform = 'translateZ(0)';
            modal.style.backfaceVisibility = 'hidden';
            modal.style.willChange = 'opacity';
            
            // Nonaktifkan transisi yang bisa menyebabkan flicker
            const dialog = modal.querySelector('.modal-dialog');
            if (dialog) {
                dialog.style.transform = 'none !important';
                dialog.style.transition = 'none !important';
            }
        }, true);

        // Perbaiki flicker akibat scrollbar yang muncul/hilang
        document.addEventListener('hidden.bs.modal', function() {
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        });

        // Jalankan perbaikan untuk Bootstrap modal
        fixBootstrapModal();
    }

    // Tangani kasus khusus untuk modal di halaman produk admin
    function fixProductDeleteModal() {
        // Khusus modal hapus produk
        document.querySelectorAll('.no-flicker-modal').forEach(modal => {
            // Pra-muat gambar
            const images = modal.querySelectorAll('img');
            images.forEach(img => {
                // Pra-muat gambar
                const preloader = new Image();
                preloader.src = img.src;
            });
            
            // Perbaiki backdrop
            modal.addEventListener('show.bs.modal', function() {
                // Pastikan backdrop stabil
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => {
                    backdrop.style.opacity = '0.5';
                    backdrop.style.transform = 'translateZ(0)';
                    backdrop.style.backfaceVisibility = 'hidden';
                });
            });
        });
    }

    // Fungsi utama untuk menjalankan semua perbaikan
    function initModalFixes() {
        // Jalankan setelah DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                fixModalFlickering();
                setTimeout(fixProductDeleteModal, 100);
            });
        } else {
            fixModalFlickering();
            setTimeout(fixProductDeleteModal, 100);
        }
        
        // Tambahan saat window dimuat sepenuhnya
        window.addEventListener('load', function() {
            fixProductDeleteModal();
        });
    }

    // Inisialisasi
    initModalFixes();
})();
