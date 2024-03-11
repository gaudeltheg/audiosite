// document.addEventListener("DOMContentLoaded", function() {
//     let container = document.querySelector(".container");
//     let container1 = document.querySelector(".container-1");
//     let options = document.querySelectorAll(".option");
//     let prevOption = null;

//     options.forEach(option => {
//         option.addEventListener("click", () => {
//             let index = parseInt(option.classList[1].replace("option", ""));

//             if (prevOption !== null) {
//                 if (prevOption === option) {
//                     container.classList.remove("open");
//                     container1.classList.remove("open");
//                     prevOption.style.backgroundColor = '';
//                     prevOption = null;
//                     return;
//                 }
//             }

//             if (prevOption !== null) {
//                 prevOption.style.backgroundColor = '';
//             }

//             option.style.backgroundColor = 'grey';

//             container.classList.remove("open");
//             container1.classList.remove("open");

//             if (index === 1) {
//                 container.classList.add("open");
//             } else if (index === 2) {
//                 container1.classList.add("open");
//             }

//             prevOption = option;

//             var dropdownMenu = document.getElementById("myDropdown");
//             dropdownMenu.style.display = "none";
//         });
//     });
// });

// function toggleDropdown() {
//     var dropdownMenu = document.getElementById("myDropdown");
//     if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
//       dropdownMenu.style.display = "block";
//     } else {
//       dropdownMenu.style.display = "none";
//     }
// }

// window.onclick = function (event) {
//     if (!event.target.matches(".button")) {
//         var dropdowns = document.getElementsByClassName("dropdown-menu");
//         var i;
//         for (i = 0; i < dropdowns.length; i++) {
//             var openDropdown = dropdowns[i];
//             if (openDropdown.style.display === "block") {
//                 openDropdown.style.display = "none";
//             }
//         }
//     }
// };

// // // Select the node that will be observed for mutations
// // var targetNode = document.getElementById('container');

// // // Options for the observer (which mutations to observe)
// // var config = { childList: true, subtree: true };

// // // Callback function to execute when mutations are observed
// // var callback = function(mutationsList, observer) {
// //     for(var mutation of mutationsList) {
// //         if (mutation.type === 'childList') {
// //             // Trigger action based on the added elements
// //             // For example, if a new option is added, you may want to attach event listeners to it
// //             // or trigger some other action.
// //             attachEventListenersToNewOptions();
// //         }
// //     }
// // };

// // // Create an observer instance linked to the callback function
// // var observer = new MutationObserver(callback);

// // // Start observing the target node for configured mutations
// // observer.observe(targetNode, config);
 

// document.addEventListener("DOMContentLoaded", function() {
//     let container = document.querySelector(".container");
//     let container1 = document.querySelector(".container-1");
//     let options = document.querySelectorAll(".option");
//     let prevOption = null;

//     // Display the first container by default
//     container.classList.add("open");

//     options.forEach(option => {
//         option.addEventListener("click", () => {
//             let index = parseInt(option.classList[1].replace("option", ""));

//             // Remove previous option's background color
//             if (prevOption !== null) {
//                 prevOption.style.backgroundColor = '';
//             }

//             // Set current option's background color
//             option.style.backgroundColor = 'grey';

//             // Remove open class from all containers with transition effect
//             container.classList.remove("open");
//             container1.classList.remove("open");

//             // Add open class to the selected container with transition effect
//             if (index === 1) {
//                 container.classList.add("open");
//             } else if (index === 2) {
//                 container1.classList.add("open");
//             } else {
//                 container.classList.add("open"); // For options other than 1 and 2, default to container
//             }

//             prevOption = option;

//             var dropdownMenu = document.getElementById("myDropdown");
//             dropdownMenu.style.display = "none";
//         });
//     });
// });
// function toggleDropdown() {
//     var dropdownMenu = document.getElementById("myDropdown");
//     if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
//         dropdownMenu.style.display = "block";
//     } else {
//         dropdownMenu.style.display = "none";
//     }
// }

// window.onclick = function(event) {
//     if (!event.target.matches(".button")) {
//         var dropdowns = document.getElementsByClassName("dropdown-menu");
//         var i;
//         for (i = 0; i < dropdowns.length; i++) {
//             var openDropdown = dropdowns[i];
//             if (openDropdown.style.display === "block") {
//                 openDropdown.style.display = "none";
//             }
//         }
//     }
// };
 
document.addEventListener("DOMContentLoaded", function() {
    let container = document.querySelector(".container");
    let container1 = document.querySelector(".container-1");
    let options = document.querySelectorAll(".option");
    let prevOption = null;

    // Display the first container by default
    container.classList.add("open");

    options.forEach(option => {
        option.addEventListener("click", () => {
            let index = parseInt(option.classList[1].replace("option", ""));

            // Pause all audio elements
            let audioElements = document.querySelectorAll("audio");
            audioElements.forEach(audio => {
                audio.pause();
            });

            // Remove previous option's background color
            if (prevOption !== null) {
                prevOption.style.backgroundColor = '';
            }

            // Set current option's background color
            option.style.backgroundColor = 'grey';

            // Remove open class from all containers with transition effect
            container.classList.remove("open");
            container1.classList.remove("open");

            // Add open class to the selected container with transition effect
            if (index === 1) {
                container.classList.add("open");
            } else if (index === 2) {
                container1.classList.add("open");
            } else {
                container.classList.add("open"); // For options other than 1 and 2, default to container
            }

            prevOption = option;

            var dropdownMenu = document.getElementById("myDropdown");
            dropdownMenu.style.display = "none";
        });
    });
});

function toggleDropdown() {
    var dropdownMenu = document.getElementById("myDropdown");
    if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
        dropdownMenu.style.display = "block";
    } else {
        dropdownMenu.style.display = "none";
    }
}

window.onclick = function(event) {
    if (!event.target.matches(".button")) {
        var dropdowns = document.getElementsByClassName("dropdown-menu");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
};
