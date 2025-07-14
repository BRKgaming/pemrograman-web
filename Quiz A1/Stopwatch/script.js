/* filepath: d:\Pemograman\Pemograman web\Tugas 2\Stopwatch\script.js */
let interval = null;
let milliseconds = 0, seconds = 0;

function updateDisplay() {
    document.querySelector('.seconds').innerText = String(seconds).padStart(3, '0');
    document.querySelector('.milliseconds').innerText = String(milliseconds / 10).padStart(2, '0');
}

function startTimer() {
    if (!interval) {
        interval = setInterval(() => {
            milliseconds += 10;
            if (milliseconds >= 1000) {
                milliseconds = 0;
                seconds++;
            }
            updateDisplay();
        }, 10);
    }
}

function stopTimer() {
    clearInterval(interval);
    interval = null;
}

function resetTimer() {
    stopTimer();
    milliseconds = 0;
    seconds = 0;
    updateDisplay();
}