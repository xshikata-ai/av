


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 NOT FOUND</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@700&display=swap');

        /* Mengatur tampilan halaman */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: black;
            color: white;
            font-family: 'Roboto Mono', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Elemen canvas untuk animasi Matrix */
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        /* Kontainer teks dengan glitch */
        .container {
            position: relative;
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            z-index: 2; /* Menempatkan teks di atas background */
            pointer-events: none;
        }

        .stack {
            position: relative;
            display: grid;
        }

        .stack span {
            font-weight: bold;
            grid-row-start: 1;
            grid-column-start: 1;
            font-size: 1rem;
            --stack-height: calc(100% / var(--stacks) - 1px);
            --inverse-index: calc(calc(var(--stacks) - 1) - var(--index));
            --clip-top: calc(var(--stack-height) * var(--index));
            --clip-bottom: calc(var(--stack-height) * var(--inverse-index));
            clip-path: inset(var(--clip-top) 0 var(--clip-bottom) 0);
            animation: stack 340ms cubic-bezier(.46,.29,0,1.24) 1 backwards calc(var(--index) * 120ms), glitch 2s ease infinite 2s alternate-reverse;
        }

        .stack span:nth-child(odd) {
            --glitch-translate: 8px;
        }

        .stack span:nth-child(even) {
            --glitch-translate: -8px;
        }

        /* Animasi stack teks */
        @keyframes stack {
            0% {
                opacity: 1;
                transform: translateX(-50%);
                text-shadow: -2px 3px 0 green, 2px -3px 0 blue;
            }
            50% {
                opacity: 2;
                transform: translateX(50%);
            }
            70% {
                transform: none;
                opacity: 3;
                text-shadow: 3px -4px 0 green, -2px 3px 0 blue;
            }
            100% {
                text-shadow: none;
            }
        }

        /* Animasi glitch */
        @keyframes glitch {
            0% {
                text-shadow: -3px 4px 0 green, 2px -3px 0 blue;
                transform: translate(var(--glitch-translate));
            }
            4% {
                text-shadow: 2px -3px 0 green, -2px 3px 0 blue;
            }
            5%, 100% {
                text-shadow: none;
                transform: none;
            }
        }

        /* Pengaturan teks tambahan */
        .container p {
            font-size: 18px;
            color: #00FF00;
            margin: 5px 0;
        }

        .container .small-text {
            font-size: 12px;
            color: #ff0000;
        }

    </style>
</head>
<body>
    <!-- Background Animasi Matrix -->
    <canvas id="matrixCanvas"></canvas>

    <!-- Teks Glitch -->
    <div class="container">
        <b>404 NOTFOUND</b>
        <div class="stack" layout="responsive" style="--stacks: 4;">
            <span style="--index: 0;">OOPS!! HALAMAN TIDAK DITEMUKAN</span>
            <span style="--index: 1;">OOPS!! HALAMAN TIDAK DITEMUKAN</span>
            <span style="--index: 2;">OOPS!! HALAMAN TIDAK DITEMUKAN</span>
            <span style="--index: 3;">OOPS!! HALAMAN TIDAK DITEMUKAN</span>
        </div>
        <p></p>
        <p class="small-text">JENDRAL KANCIL</p>
    </div>

    <script>
        // Mencegah Klik Kanan
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Mencegah Kombinasi Ctrl+U dan Lainnya
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && (e.key === 'u' || e.key === 's' || e.key === 'p' || e.key === 'c')) {
                e.preventDefault();
            }
            if (e.keyCode == 123) { // F12
                e.preventDefault();
            }
        });

        const canvas = document.getElementById('matrixCanvas');
        const ctx = canvas.getContext('2d');

        // Mengatur ukuran canvas sesuai layar
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const characters = "PEMULA-SEO-GOCEK-0215201999";
        const fontSize = 16; // Ukuran font Matrix Rain
        const columns = canvas.width / fontSize; // Jumlah kolom teks
        const drops = Array(Math.floor(columns)).fill(1); // Posisi awal setiap kolom

        function drawMatrix() {
            // Latar belakang hitam dengan sedikit transparansi
            ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Warna teks
            ctx.fillStyle = "#ff0000";
            ctx.font = fontSize + "px 'Roboto Mono'";

            // Menggambar karakter di setiap kolom
            for (let i = 0; i < drops.length; i++) {
                const char = characters.charAt(Math.floor(Math.random() * characters.length));
                const x = i * fontSize;
                const y = drops[i] * fontSize;

                ctx.fillText(char, x, y);

                // Reset posisi drop setelah mencapai bagian bawah
                if (y > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }

                // Menambahkan efek jatuh
                drops[i]++;
            }
        }

        setInterval(drawMatrix, 50);

        // Menyesuaikan ukuran canvas saat jendela diubah
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>
