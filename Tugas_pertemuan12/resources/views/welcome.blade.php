<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background: #fdfdfc; color: #1b1b18; }
        .menu-container { max-width: 600px; margin: 60px auto; padding: 48px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px #0002; }
        h2 { margin-bottom: 32px; text-align: center; }
        .menu-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 70%;
            padding: 8px 12px; /* lebih kecil */
            margin: 10px auto;  /* tengah dan lebih kecil */
            background: blue;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.98em; /* lebih kecil */
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px #f5300333;
            transition: background 0.2s, transform 0.2s;
        }
        .menu-btn:hover {
            background: darkblue;
            transform: translateY(-2px) scale(1.03);
        }
        .menu-btn svg {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <h2>Menu Utama</h2>
        <a href="{{ url('/kontaks') }}" class="menu-btn">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24"><path d="M21 19.5V17a2 2 0 0 0-2-2h-1.5M7.5 15H6a2 2 0 0 0-2 2v2.5m13-13A2.5 2.5 0 1 1 17 2.5a2.5 2.5 0 0 1 2.5 2.5Zm-11 0A2.5 2.5 0 1 1 6 2.5a2.5 2.5 0 0 1 2.5 2.5ZM12 21.5a9.5 9.5 0 1 1 0-19 9.5 9.5 0 0 1 0 19Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kontak(pakai refresh)
        </a>
        <a href="{{ url('/mahasiswa') }}" class="menu-btn">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.418 0-8 2.239-8 5v3h16v-3c0-2.761-3.582-5-8-5Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Mahasiswa(tanpa refresh)
        </a>

    </div>
</body>
</html>