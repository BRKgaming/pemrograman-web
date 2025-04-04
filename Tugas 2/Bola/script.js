const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

// Atur ukuran canvas
canvas.width = 700;
canvas.height = 400;

// Bola
const ball = {
    x: 0, // Mulai dari kiri
    y: 50, // Tengah atas
    radius: 20,
    speedX: 2,
    speedY: 2,
    movingRight: true,
    movingDown: false
};

// Animasi bola
function update() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Gambar background hijau
    ctx.fillStyle = "green";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Gambar bola putih (hanya jika belum menghilang)
    if (ball.x + ball.radius > 0) {
        ctx.fillStyle = "white";
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
        ctx.fill();
    }

    // Logika pergerakan bola
    if (ball.movingRight) {
        ball.x += ball.speedX;
        if (ball.x + ball.radius >= canvas.width) {
            ball.movingRight = false;
            ball.movingDown = true;
        }
    } else if (ball.movingDown) {
        ball.y += ball.speedY;
        if (ball.y + ball.radius >= canvas.height) {
            ball.movingDown = false;
        }
    } else {
        ball.x -= ball.speedX;
        if (ball.x + ball.radius <= 0) {
            ball.x = -ball.radius; // Hilangkan bola
        }
    }

    requestAnimationFrame(update);
}

update();
