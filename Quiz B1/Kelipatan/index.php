<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelipatan Angka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align to top */
            min-height: 100vh;
            margin: 0;
            padding-top: 20px; /* Add some padding at the top */
            box-sizing: border-box;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px; /* Lebar maksimal kontainer */
        }
        .form-input {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-input label {
            font-weight: bold;
        }
        .form-input input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 80px; /* Sesuaikan lebar input */
        }
        .form-input input[type="submit"] {
            padding: 8px 15px;
            background-color: #e0e0e0; /* Warna tombol seperti di video */
            color: black;
            border: 1px solid #bbb;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-input input[type="submit"]:hover {
            background-color: #d0d0d0;
        }
        h2 {
            text-align: left; /* Judul "Kelipatan dari X" rata kiri */
            margin-top: 0;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            font-weight: bold; /* Header tabel bold */
        }
        .highlight {
            background-color: #e6ffe6; /* Warna hijau muda seperti di video */
        }
        /* Browser validation message styling (opsional, browser default biasanya cukup) */
        input:invalid + .validation-message-bubble {
            /* Ini lebih kompleks untuk direplikasi persis tanpa JS, 
               kita andalkan styling browser default untuk pesan validasi */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            // Default kelipatan adalah 1 jika tidak ada input atau input tidak valid
            $kelipatan_basis = 1;
            $input_value_for_field = 1; // Nilai untuk ditampilkan di input field

            if (isset($_GET['kelipatan'])) {
                $input_value_for_field = $_GET['kelipatan']; // Simpan input asli untuk field
                if (is_numeric($_GET['kelipatan']) && intval($_GET['kelipatan']) >= 1) {
                    $kelipatan_basis = intval($_GET['kelipatan']);
                } else {
                    // Jika input tidak valid (misal, 0, negatif, atau non-numerik setelah submit),
                    // tabel akan tetap menggunakan default 1, tapi field akan menampilkan input user.
                    // Validasi browser dengan min="1" akan mencegah submit nilai < 1.
                }
            }
        ?>

        <form method="GET" action="" class="form-input">
            <label for="kelipatan">Masukan Kelipatan :</label>
            <input type="number" id="kelipatan" name="kelipatan" 
                   value="<?php echo htmlspecialchars($input_value_for_field); ?>" 
                   min="1" required>
            <input type="submit" value="Kirim">
        </form>
        
        <!-- Pesan validasi browser akan muncul otomatis dekat input jika `min="1"` dilanggar -->

        <h2>Kelipatan dari <?php echo htmlspecialchars($kelipatan_basis); ?></h2>

        <table>
            <thead>
                <tr>
                    <th>Angka</th>
                    <th>Kelipatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $batas_angka = 40; // Batas angka yang ditampilkan di tabel (seperti di video)

                    for ($i = 1; $i <= $batas_angka; $i++) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";

                        if ($kelipatan_basis > 0 && $i % $kelipatan_basis == 0) {
                            // Jika $i adalah kelipatan dari $kelipatan_basis
                            echo "<td class='highlight'>" . $i . " (kelipatan dari " . htmlspecialchars($kelipatan_basis) . ")</td>";
                        } else {
                            // Jika bukan kelipatan
                            echo "<td>" . $i . "</td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>