document.addEventListener('DOMContentLoaded', function() {
    const ball = document.getElementById('ball');
    let startTime = null;
    const duration = 15000; // 15 seconds

    // Initial position
    ball.style.top = '180px';
    ball.style.left = '0px';

    function animate(currentTime) {
        if (!startTime) startTime = currentTime;
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // Calculate positions
        let top, left;

        if (progress <= 0.33) {
            // First segment: left to right at top
            top = 180;
            left = (progress / 0.33) * 660;
        } else if (progress <= 0.66) {
            // Second segment: move down at right
            top = 180 + ((progress - 0.33) / 0.33) * (330 - 180);
            left = 660;
        } else if (progress <= 0.90) {
            // Third segment: right to left at bottom
            top = 330;
            left = 660 - ((progress - 0.66) / 0.24) * 660;
        } else {
            // Final segment: move off screen to left
            top = 330;
            left = -((progress - 0.90) / 0.1) * 50;
        }

        // Apply positions
        ball.style.top = `${top}px`;
        ball.style.left = `${left}px`;

        // Continue animation if not complete
        if (progress < 1) {
            requestAnimationFrame(animate);
        }
    }

    // Start animation
    requestAnimationFrame(animate);
});