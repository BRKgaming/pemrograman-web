class SimpleCalendar {
    constructor() {
        this.currentDate = new Date(2025, 1, 1); // Mulai dari Februari 2025
        this.monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        this.dayNames = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];
        
        this.initializeEventListeners();
        this.render();
    }

    initializeEventListeners() {
        document.getElementById('prevLink').addEventListener('click', (e) => {
            e.preventDefault();
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.render();
        });

        document.getElementById('nextLink').addEventListener('click', (e) => {
            e.preventDefault();
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.render();
        });
    }

    render() {
        this.renderHeader();
        this.renderCalendar();
    }

    renderHeader() {
        const monthYear = `${this.monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
        document.getElementById('currentDate').textContent = monthYear;
    }

    renderCalendar() {
        const tbody = document.getElementById('calendarBody');
        tbody.innerHTML = '';

        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        
        // Dapatkan hari pertama bulan dan jumlah hari
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay(); // 0 = Minggu

        // Dapatkan informasi bulan sebelumnya
        const prevMonth = new Date(year, month - 1, 0);
        const prevMonthDays = prevMonth.getDate();

        let dayCount = 1;
        let nextMonthDay = 1;

        // Buat 6 minggu (6 baris)
        for (let week = 0; week < 6; week++) {
            const row = document.createElement('tr');
            
            // Buat 7 hari untuk setiap minggu
            for (let day = 0; day < 7; day++) {
                const cell = document.createElement('td');
                const cellIndex = week * 7 + day;
                
                if (cellIndex < startingDayOfWeek) {
                    // Hari-hari dari bulan sebelumnya
                    const prevDay = prevMonthDays - (startingDayOfWeek - cellIndex - 1);
                    cell.textContent = prevDay;
                    cell.classList.add('other-month');
                } else if (dayCount <= daysInMonth) {
                    // Hari-hari bulan ini
                    cell.textContent = dayCount;
                    
                    const currentDate = new Date();
                    const thisDate = new Date(year, month, dayCount);
                    
                    // Periksa apakah hari ini
                    if (thisDate.toDateString() === currentDate.toDateString()) {
                        cell.classList.add('today');
                    }

                    // Periksa apakah akhir pekan (Minggu atau Sabtu)
                    if (day === 0 || day === 6) {
                        cell.classList.add('weekend');
                    }
                    
                    dayCount++;
                } else {
                    // Hari-hari dari bulan berikutnya
                    cell.textContent = nextMonthDay;
                    cell.classList.add('other-month');
                    nextMonthDay++;
                }
                
                row.appendChild(cell);
            }
            
            tbody.appendChild(row);
            
            // Berhenti jika sudah mengisi semua hari dan menyelesaikan minggu
            if (dayCount > daysInMonth && week >= 4) {
                break;
            }
        }
    }
}

// Inisialisasi kalender ketika halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    new SimpleCalendar();
});