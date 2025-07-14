/**
 * Modal Anti-flicker Script (Improved Version)
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

        // Fix untuk modal Bootstrap yang lebih halus
        const fixBootstrapModal = function() {
            // Jangan override method default Bootstrap
            // Sebagai gantinya, gunakan event handler yang lebih ringan
            
            // Tangani semua modal yang ada di halaman
            document.querySelectorAll('.modal').forEach(function(modalElement) {
                // Hindari manipulasi style yang berlebihan
                modalElement.classList.add('smooth-modal');
            });
        };

        // Tangani modal saat akan muncul dengan lebih halus
        document.addEventListener('show.bs.modal', function(event) {
            // Target modal yang akan muncul
            const modal = event.target;
            
            // Tandai modal sebagai sedang dibuka
            modal.classList.add('is-opening');
            
            // Gunakan requestAnimationFrame untuk lebih smooth
            requestAnimationFrame(() => {
                modal.classList.add('smooth-modal');
            });
        }, true);
        
        // Bersihkan setelah modal selesai ditampilkan
        document.addEventListener('shown.bs.modal', function(event) {
            const modal = event.target;
            modal.classList.remove('is-opening');
        });

        // Perbaiki flicker akibat scrollbar yang muncul/hilang
        document.addEventListener('hidden.bs.modal', function() {
            // Beri delay sedikit untuk menghindari perubahan tata letak yang tiba-tiba
            setTimeout(() => {
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
            }, 100);
        });

        // Jalankan perbaikan untuk Bootstrap modal
        fixBootstrapModal();
    }

    // Inisialisasi
    function initModalFixes() {
        // Jalankan setelah DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fixModalFlickering);
        } else {
            fixModalFlickering();
        }
    }

    // Inisialisasi
    initModalFixes();
})();
