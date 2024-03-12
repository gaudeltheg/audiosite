document.addEventListener("DOMContentLoaded", function () {
    const audioElements = document.querySelectorAll(".cards .audio");
    const visualizerCanvases = document.querySelectorAll(".cards .visualizer");
    const playButtons = document.querySelectorAll(".cards .playButton");

    // Function to create audio context for each card
    const createAudioContext = (audioElement, visualizerCanvas) => {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const analyser = audioContext.createAnalyser();
        analyser.fftSize = 256;
        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);

        const canvasContext = visualizerCanvas.getContext("2d");
        visualizerCanvas.width = visualizerCanvas.offsetWidth;
        visualizerCanvas.height = visualizerCanvas.offsetHeight;

        const source = audioContext.createMediaElementSource(audioElement);
        source.connect(analyser);
        analyser.connect(audioContext.destination);

        return { audioContext, analyser, dataArray, canvasContext };
    };

    // Function to draw visualizer for each card
    const drawVisualizer = (analyser, dataArray, canvasContext, visualizerCanvas) => {
        analyser.getByteFrequencyData(dataArray);
        canvasContext.clearRect(0, 0, visualizerCanvas.width, visualizerCanvas.height);
    
        const barWidth = ((visualizerCanvas.width / dataArray.length) * 2.5) * 0.8; // 80% of the original bar width for spacing
        const barSpacing = barWidth * 0.3; // Space between all bars
        const x = visualizerCanvas.width / 2;
    
        for (let i = 0; i < dataArray.length / 2; i++) {
            const barHeight = dataArray[i] / 2; // Divide by 2 to make the visualizer start from the middle of the canvas
    
            // Change the color of the bars based on their height
            const red = barHeight + (25 * (i / dataArray.length));
            const green = 250 * (i / dataArray.length);
            const blue = 50;
    
            canvasContext.fillStyle = `rgb(${red},${green},${blue}`;
    
            const barX = x + (i * (barWidth + barSpacing));
            const barY = (visualizerCanvas.height - barHeight) / 2;
            const cornerRadius = 5; // Adjust the corner radius as needed
    
            // Draw a rectangle with blunt corners
            canvasContext.beginPath();
            canvasContext.moveTo(barX + cornerRadius, barY);
            canvasContext.lineTo(barX + barWidth - cornerRadius, barY);
            canvasContext.quadraticCurveTo(barX + barWidth, barY, barX + barWidth, barY + cornerRadius);
            canvasContext.lineTo(barX + barWidth, barY + barHeight - cornerRadius);
            canvasContext.quadraticCurveTo(barX + barWidth, barY + barHeight, barX + barWidth - cornerRadius, barY + barHeight);
            canvasContext.lineTo(barX + cornerRadius, barY + barHeight);
            canvasContext.quadraticCurveTo(barX, barY + barHeight, barX, barY + barHeight - cornerRadius);
            canvasContext.lineTo(barX, barY + cornerRadius);
            canvasContext.quadraticCurveTo(barX, barY, barX + cornerRadius, barY);
            canvasContext.closePath();
            canvasContext.fill();

             // Mirror the bars on the left side
             const mirroredX = x - (i * (barWidth + barSpacing));
             canvasContext.beginPath();
             canvasContext.moveTo(mirroredX - cornerRadius, barY);
             canvasContext.lineTo(mirroredX - barWidth + cornerRadius, barY);
             canvasContext.quadraticCurveTo(mirroredX - barWidth, barY, mirroredX - barWidth, barY + cornerRadius);
             canvasContext.lineTo(mirroredX - barWidth, barY + barHeight - cornerRadius);
             canvasContext.quadraticCurveTo(mirroredX - barWidth, barY + barHeight, mirroredX - barWidth + cornerRadius, barY + barHeight);
             canvasContext.lineTo(mirroredX - cornerRadius, barY + barHeight);
             canvasContext.quadraticCurveTo(mirroredX, barY + barHeight, mirroredX, barY + barHeight - cornerRadius);
             canvasContext.lineTo(mirroredX, barY + cornerRadius);
             canvasContext.quadraticCurveTo(mirroredX, barY, mirroredX - cornerRadius, barY);
             canvasContext.closePath();
             canvasContext.fill();
            
        }
    
        requestAnimationFrame(() => drawVisualizer(analyser, dataArray, canvasContext, visualizerCanvas));
    };

    // Loop through each card
    audioElements.forEach((audioElement, index) => {
        const visualizerCanvas = visualizerCanvases[index];
        const playButton = playButtons[index];

        const { audioContext, analyser, dataArray, canvasContext } = createAudioContext(audioElement, visualizerCanvas);

        // Draw visualizer for each card
        drawVisualizer(analyser, dataArray, canvasContext, visualizerCanvas);

        // Add event listeners or functionality to playButton, if needed
        playButton.addEventListener("click", () => {
            event.stopPropagation();
            if (audioContext && audioContext.state === "suspended") {
                audioContext.resume().then(() => {
                    audioElement.play();
                    playButton.textContent = "Pause";
                });
            } else if (!audioContext) {
                // Recreate audio context if it's not created
                const { audioContext: newAudioContext } = createAudioContext(audioElement, visualizerCanvas);
                newAudioContext.resume().then(() => {
                    audioElement.play();
                    playButton.textContent = "Pause";
                });
            } else if (audioElement.paused) {
                audioElement.play();
                playButton.textContent = "Play";
            } else {
                audioElement.pause();
                playButton.textContent = "Pause";
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const audioElements = document.querySelectorAll(".cards .audio");
    const playButtons = document.querySelectorAll(".cards .playButton");
    const visualizerCanvases = document.querySelectorAll(".cards .visualizer");

    let currentPlayingAudio = null;
    let currentVisualizerCanvas = null;
    let currentCanvasContext = null;
    let isPaused = false;

   // Function to play audio
function playAudio(audioElement, visualizerCanvas, canvasContext, playButton) {
    if (currentPlayingAudio !== audioElement) {
        if (currentPlayingAudio) {
            currentPlayingAudio.pause(); // Pause the currently playing audio
            if (currentCanvasContext) {
                currentCanvasContext.clearRect(0, 0, visualizerCanvas.width, visualizerCanvas.height);
            }
            updatePlayButtonText(playButtons[Array.from(audioElements).indexOf(currentPlayingAudio)], "Play"); // Update play button text for previously playing audio
        }

        currentPlayingAudio = audioElement;
        currentVisualizerCanvas = visualizerCanvas;
        currentCanvasContext = canvasContext;

        currentPlayingAudio.play(); // Play the selected audio
        isPaused = false;
    } else {
        if (isPaused) {
            currentPlayingAudio.play(); // If paused, resume playing
            isPaused = false;
        } else {
            currentPlayingAudio.pause(); // If playing, pause
            isPaused = true;
        }
    }

    updatePlayButtonText(playButton, isPaused ? "Play" : "Pause"); // Update play button text for current audio
}

// Function to update play button text
function updatePlayButtonText(playButton, text) {
    playButton.textContent = text;
}


    // Function to draw visualizer
    function drawVisualizer(analyser, dataArray, canvasContext, visualizerCanvas) {
        analyser.getByteFrequencyData(dataArray);
        canvasContext.clearRect(0, 0, visualizerCanvas.width, visualizerCanvas.height);
    
        // Drawing the visualizer bars...
    }

    // Loop through each card
    audioElements.forEach((audioElement, index) => {
        const visualizerCanvas = visualizerCanvases[index];
        const playButton = playButtons[index];
        const canvasContext = visualizerCanvas.getContext("2d");

        playButton.addEventListener("click", () => {
            playAudio(audioElement, visualizerCanvas, canvasContext, playButton);
        });
    });
});

popUp.addEventListener("click", (event) => {
    event.stopPropagation();
});
