<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Line Chart</title>
    <!-- Sertakan Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 700px; /* Lebar maksimal kontainer */
        }
        .input-group {
            display: flex;
            gap: 10px; /* Jarak antar input dan tombol */
            margin-bottom: 20px;
            align-items: flex-start; /* Agar validation message dekat dengan input */
        }
        .input-group input[type="text"],
        .input-group input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-grow: 1; /* Agar input mengambil sisa ruang */
        }
        .input-group button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .input-group button:hover {
            background-color: #0056b3;
        }
        /* Style untuk validation message browser (jika diperlukan override) */
        input:invalid {
            /* border-color: red; */ /* Browser default biasanya sudah cukup */
        }
        /* Pesan kustom jika tidak menggunakan validasi HTML5 default */
        .validation-message {
            color: #d9534f; /* Warna merah untuk error */
            font-size: 0.9em;
            margin-top: 5px;
            display: none; /* Sembunyikan secara default */
        }
        #chart-container {
            width: 100%;
            height: 400px; /* Atur tinggi chart */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Gunakan form agar validasi HTML5 'required' berfungsi dengan baik saat submit -->
        <form id="dataForm" class="input-group">
            <div>
                <input type="text" id="labelInput" placeholder="Label" required>
                <!-- Browser akan menampilkan pesan "Please fill out this field." jika kosong saat submit -->
            </div>
            <div>
                <input type="number" id="valueInput" placeholder="Value" required step="any">
                <!-- 'step="any"' untuk mengizinkan desimal jika perlu, 'required' untuk validasi -->
            </div>
            <button type="submit">Add Data</button>
        </form>

        <div id="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // Data awal seperti di video
        const initialLabels = ['January', 'February', 'March', 'April', 'May'];
        const initialDataValues = [10, 20, 15, 24.5, 29.5]; // Perkiraan dari video

        const chartData = {
            labels: [...initialLabels], // Salin array agar tidak mengubah original
            datasets: [{
                label: 'Monthly Values',
                data: [...initialDataValues], // Salin array
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.1)', // Warna area di bawah garis
                tension: 0.1 // Untuk sedikit melengkungkan garis
            }]
        };

        const config = {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting agar chart mengisi kontainer
                scales: {
                    y: {
                        beginAtZero: true, // Mulai sumbu Y dari 0
                        ticks: {
                            // Atur agar skala Y dinamis dan menampilkan kelipatan yang bagus
                            // Chart.js biasanya sudah menangani ini dengan baik secara default
                        }
                    }
                },
                animation: {
                    duration: 500 // Durasi animasi saat update
                }
            }
        };

        const myChart = new Chart(ctx, config);

        const dataForm = document.getElementById('dataForm');
        const labelInput = document.getElementById('labelInput');
        const valueInput = document.getElementById('valueInput');

        dataForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit dan reload halaman

            const newLabel = labelInput.value.trim();
            const newValue = valueInput.value; // Dapatkan sebagai string dulu

            // Validasi tambahan (walaupun 'required' sudah ada)
            if (newLabel === '') {
                // Browser akan menangani ini dengan 'required' attribute
                labelInput.focus();
                return;
            }
            if (newValue === '' || isNaN(parseFloat(newValue))) {
                // Browser akan menangani ini dengan 'required' dan type='number'
                valueInput.focus();
                return;
            }

            const numericValue = parseFloat(newValue);

            // Tambahkan data baru ke chart
            myChart.data.labels.push(newLabel);
            myChart.data.datasets[0].data.push(numericValue);
            
            // Update chart
            myChart.update();

            // Kosongkan input fields
            labelInput.value = '';
            valueInput.value = '';

            // Fokus kembali ke input label
            labelInput.focus();
        });

    </script>
</body>
</html>