// Get the canvas element from the HTML file
var canvas = document.getElementById("animatedEggsCanvas");

// Set the canvas dimensions to match the browser window
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// Get the canvas context
var ctx = canvas.getContext("2d");

// Define the easter egg image and number of eggs
var eggImg = new Image();
eggImg.src = "/img/pink-egg.png";
var numEggs = 30;

// Create an array to hold the easter egg objects
var eggs = [];

// Define the easter egg object
function Egg(x, y, speed) {
    this.x = x;
    this.y = y;
    this.speed = speed;

    // Draw the easter egg on the canvas
    this.draw = function () {
        ctx.drawImage(eggImg, this.x, this.y, 60, 70);
    };

    // Update the position of the easter egg
    this.update = function () {
        this.y += this.speed;

        // Reset the easter egg to the top of the canvas when it reaches the bottom
        if (this.y > canvas.height) {
            this.y = -70;
            this.x = Math.random() * canvas.width;
        }
    };
}

// Create the easter egg objects and add them to the array
for (var i = 0; i < numEggs; i++) {
    var x = Math.random() * canvas.width;
    var y = Math.random() * canvas.height;
    var speed = Math.random() *0.1 + 0.35;
    var egg = new Egg(x, y, speed);
    eggs.push(egg);
}

// Animate the easter eggs
function animate() {
    // Clear the canvas on each frame
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Call the draw and update functions for each easter egg object
    for (var i = 0; i < numEggs; i++) {
        eggs[i].draw();
        eggs[i].update();
    }

    // Request the next animation frame
    requestAnimationFrame(animate);
}

// Start the animation
animate();

