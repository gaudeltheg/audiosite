document.addEventListener("DOMContentLoaded", function () {
    const audioElements = document.querySelectorAll(".cards .audio, .popup .audio");
    const visualizerCanvases = document.querySelectorAll(".cards .visualizer, .popup .visualizer");
    const playButtons = document.querySelectorAll(".cards .playButton, .popup .playButton");

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


const popUp = document.querySelector(".popup");
const body = document.querySelector("body");
const container = document.querySelector(".container");
const clos = document.querySelectorAll(".okbtn");
const submit = document.querySelectorAll(".cards");
const poetryContainer = document.querySelector(".poetry-container");
// Get references to elements in the cards section
const cards = document.querySelectorAll('.cards');
const popupAudio = document.querySelector('.popup .popupaudio');
const popupPlayButton = document.querySelector('.popup .playButton');



// Add event listener to each card
cards.forEach(card => {
    card.addEventListener('click', function() {
        console.log('Card clicked'); // Log to check if the event listener is triggered
        
        // Check if the audio in the card is already playing
        const cardAudio = card.querySelector('.audio');
        if (!cardAudio.paused) {
            // Audio in the card is playing, pause it
            cardAudio.pause();
        }

        // // Play audio in the popup section
        // popupAudio.currentTime = 0; // Reset audio to the beginning
        // popupAudio.play();
        // updatePlayButton(popupPlayButton, true); // Update the play button in the popup
        // openPopup();
    });
});

// Function to update play button text and state
function updatePlayButton(button, isPlaying) {
    if (isPlaying) {
        button.textContent = "Pause";
    } else {
        button.textContent = "Play";
    }
}



function applyBlur() {
    poetryContainer.classList.add('active');
    popUp.classList.remove("active");
}

function removeBlur() {
    poetryContainer.classList.remove('active');
}

function openPopup() {
    popUp.classList.add("open-popup");
    applyBlur();
   
}

function closePopup() {
    popUp.classList.remove("open-popup");
    removeBlur();
    
}

clos.forEach(button => {
    button.addEventListener("click", () => {
        closePopup();
        popupAudio.pause();
        
    });
});

submit.forEach(button => {
    button.addEventListener("click", () => {
        openPopup();
    });
});

popUp.addEventListener("click", (event) => {
    event.stopPropagation();
});


let scrollPosition = 0; // Variable to store the scroll position

submit.forEach(button => {
    button.addEventListener("click", () => {
        // Store the current scroll position
        scrollPosition = window.scrollY;

        // Scroll the window to the top of the webpage
        window.scrollTo({
            top: 0,
            behavior: "smooth" // Add smooth scrolling behavior if supported by the browser
        });

        // Open the popup and apply blur
        openPopup();
        applyBlur();
    });
});

clos.forEach(button => {
    button.addEventListener("click", () => {
        // Close the popup
        closePopup();
        removeBlur();

        // Restore the scroll position
        window.scrollTo({
            top: scrollPosition,
            behavior: "smooth" // Add smooth scrolling behavior if supported by the browser
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const audioElements = document.querySelectorAll(".cards .audio, .popup .audio");
    const playButtons = document.querySelectorAll(".cards .playButton, .popup .playButton");
    const visualizerCanvases = document.querySelectorAll(".cards .visualizer, .popup .visualizer");

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

        // Update play/pause button text
        updatePlayButtonText(playButton);
    }

    // Function to update play button text
    function updatePlayButtonText(playButton) {
        playButton.textContent = isPaused ? "Play" : "Pause";
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

// // Get reference to play/pause button in the popup section
// const playButtonPopup = document.querySelector('.popup .playButton');

// // Add event listener to the play/pause button in the cards section
// playButtonCards.addEventListener('click', function() {
//     // Open the popup section
//     openPopup();

//     // Play the music in the popup section
//     playButtonPopup.click(); // Simulate a click on the play button in the popup
// });




    // document.body.addEventListener("click", (event) => {
    //     let isSubmitClicked = false;
    //     submit.forEach(button => {
    //         if (button.contains(event.target)) {
    //             isSubmitClicked = true;
    //         }
    //     });
    //     if (!popUp.contains(event.target) && !isSubmitClicked) {
    //         closePopup();
    //         removeBlur();
    //     } 
    // });

    // function isSubmitClicked(target) {
    //     let isSubmitClicked = true;
    //     submit.forEach(button => {
    //         if (button.contains(target)) {
    //             isSubmitClicked = false;
    //         }
    //     });
    //     return isSubmitClicked;
    // }
   
   
    