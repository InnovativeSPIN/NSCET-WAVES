<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSCET WAVES SLOT</title>
    <link rel="icon" href="../public/images/logos/waves-logo.png" type="image/icon type">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            overflow: hidden;
            flex-direction: column;
            min-height: 100vh;
            background-color: black;
            position: relative;
        }

        canvas {
            position: absolute;
            top: 0%;
            right: 10%;
            left: -0%;
            display: block;
        }

        .head {
            position: absolute;
            left: 30%;
            top: 5%;
            font-size: 40px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: aqua;
            z-index: 2;
        }

        .container {
            position: relative;
            width: 500px;
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }
        @keyframes zoom {
        0% {
            transform: scale(1); /* Initial size */
        }
        50% {
            transform: scale(1.2); /* Zoom in */
        }
        100% {
            transform: scale(1); /* Zoom out */
        }
        }

        .spinBtn {
            animation: zoom 2s infinite;
            position: absolute;
            width: 60px;
            height: 60px;
            left: 115%;
            top: 70%;
            background: #fff;
            border-radius: 50%;
            z-index: 3;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
            font-weight: 600;
            color: #333;
            letter-spacing: .1em;
            border: 4px solid rgba(0, 0, 0, 0.75);
            cursor: pointer;
            user-select: none;
        }
        .spinBtn1 {
            animation: zoom 2s infinite;
            position: absolute;
            width: 60px;
            height: 60px;
            left: 185%;
            top: 50%;
            background: #fff;
            border-radius: 50%;
            z-index: 3;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
            font-weight: 600;
            color: #333;
            letter-spacing: .1em;
            border: 4px solid rgba(0, 0, 0, 0.75);
            cursor: pointer;
            user-select: none;
        }

        .wheel,
        .imageWheel {
            position: absolute;
            top: 25%;
            left: 70%;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 5s ease-in-out;
        }

        .wheel1,
        .imageWheel1 {
            position: absolute;
            top: 5%;
            left: 140%;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 5s ease-in-out;
        }
    

        .wheel,
        .wheel1 {
            background: #333;
            box-shadow: 0 0 0 5px #333, 0 0 0 15px #fff, 0 0 0 18px #111;
        }

        .imageWheel {
            width: 150%;
            height: 150%;
            top:0%;
            left: 48%;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 5s ease-in-out;
        }

        .imageWheel1 {
            width: 150%;
            height: 148%;
            top: -20%;
            left: 117%;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 5s ease-in-out;
        }

        .number,
        .imageSlot {
            position: absolute;
            width: 50%;
            height: 50%;
            transform-origin: bottom right;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            user-select: none;
            cursor: pointer;
        }

        .number {
            background: var(--clr);
            transform: rotate(calc(90deg * var(--i)));
        }

        .imageSlot {
            transform: rotate(calc(-90deg * var(--i)));
        }

        .number span {
            position: relative;
            transform: rotate(45deg);
            font-size: 2.5em;
            font-weight: 700;
            color: #fff;
            text-shadow: 3px 5px 2px rgba(0, 0, 0, 0.15);
            left:50px;
            top: 50px;
        }

        @keyframes animateDropShadow {
            0% {
                filter: drop-shadow(0px 0px 30px rgba(255, 0, 0, 0.7)); /* Red */
            }
            33% {
                filter: drop-shadow(0px 0px 30px rgba(0, 255, 0, 0.7)); /* Green */
            }
            66% {
                filter: drop-shadow(0px 0px 30px rgba(0, 0, 255, 0.7)); /* Blue */
            }
            100% {
                filter: drop-shadow(0px 0px 30px rgba(255, 0, 0, 0.7)); /* Back to Red */
            }
        }
        .imageSlot img {
            width: 190px;
            height: 190px;
            border-radius: 50%;
            object-fit: cover;
            transform: rotate(30deg);
            animation: animateDropShadow 5s infinite;
        }

        #teamSelect {
            font-size: 16px;
            padding: 10px 15px;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #333;
            transition: border-color 0.3s, background-color 0.3s;
            cursor: pointer;
        }

        #teamSelect:focus {
            border-color: #007bff;
            background-color: #e9f5ff;
            outline: none;
        }

        #teamSelect option {
            padding: 10px;
        }

        .select-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
        }

        #teamSelect {
            margin: 10px;
        }

        .submitBtn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .submitBtn:hover {
            background-color: #45a049;
        }

        .submitBtn:active {
            background-color: #3e8e41;
            transform: translateY(2px);
        }
    </style>
</head>

<body>
    <!-- <img width=240px src="https://www.nscet.org/hackathon/img/logoHack.png" alt=""> -->
    <canvas id="backgroundCanvas"></canvas>
    <canvas id="particleCanvas"></canvas>

    <audio id="spinSound" src="../public/music/spinning-jar-cap.mp3"></audio>
    <!-- <h1 class="head">Grouped Event Allotment</h1> -->

    <div style='display:flex'>

    <div class="container">
        <div class="spinBtn">Spin</div>
        <div class="wheel"></div>
        <div class="imageWheel"></div>
    </div>
    <div class="container" style="margin-top:100px; margin-bottom:100px">
        <div class="spinBtn1">Spin</div>
        <div class="wheel1"></div>
        <div class="imageWheel1"></div>
    </div>
    </div>
    
        
    <form id="hidden-form" action="../routes/admin/assignSlot.php" method="post" style="display:none;">
        <input type="hidden" id="gender" name="gender" value="">
        <input type="hidden" id="slots" name="slot_array" value="">
        <input type="hidden" name="event_name" value="<?php echo $_GET['eventName'] ?>">
    </form>

    <div style="display: flex;
    justify-content: center;
    flex-direction: column;
    width: 20%;
    text-align:center;position: absolute;
    bottom: 5%;
    left: 2%">
    <select id="teamSelect">
        <option value="BOYS">Select Gender</option>
        <option value="GIRLS">Girls</option>
        <option value="BOYS">Boys</option>
    </select>
    <button class="submitBtn">Submit</button>
    <button id="triggerSpin">Spin Both</button>

    <input type="text" id="event_name" name="eventName" readonly value="<?php echo $_GET['eventName'] ?>">
    </div>
    


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allSlots = {
                GIRLS: [
                    { name: 'Slot 1', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 2', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 3', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 4', color: '#daa520', image: 'VIOLET_VIPERS.png' }
                ],
                BOYS: [
                    { name: 'Slot 1', color: '#ff34f0', image: 'DINO_THUNDERS.png' },
                    { name: 'Slot 2', color: '#ff7f50', image: 'DRAGON_WARRIORS.png' },
                    { name: 'Slot 3', color: '#3cb371', image: 'PHOENIX_BLASTERS.png' },
                    { name: 'Slot 4', color: '#4169e1', image: 'TIGER_THRASHERS.png' }
                ]
            }

            const allSlots1 = {
                GIRLS: [
                    { name: 'Slot 5', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 6', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 7', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 8', color: '#daa520', image: 'VIOLET_VIPERS.png' }
                ],
                BOYS: [
                    { name: 'Slot 5', color: '#ff34f0', image: 'DINO_THUNDERS.png' },
                    { name: 'Slot 6', color: '#ff7f50', image: 'DRAGON_WARRIORS.png' },
                    { name: 'Slot 7', color: '#3cb371', image: 'PHOENIX_BLASTERS.png' },
                    { name: 'Slot 8', color: '#4169e1', image: 'TIGER_THRASHERS.png' }
                ]
            }

            let slots = allSlots.BOYS
            let slots1 = allSlots1.BOYS

            const wheel = document.querySelector('.wheel')
            const imageWheel = document.querySelector('.imageWheel')

            const wheel1 = document.querySelector('.wheel1')
            const imageWheel1 = document.querySelector('.imageWheel1')

            function populateWheel() {
                wheel.innerHTML = ''
                imageWheel.innerHTML = ''

                wheel1.innerHTML = ''
                imageWheel1.innerHTML = ''

                slots.forEach((slot, index) => {
                    const numberSlot = document.createElement('div')
                    numberSlot.classList.add('number')
                    numberSlot.style.setProperty('--i', index + 1)
                    numberSlot.style.setProperty('--clr', slot.color)
                    numberSlot.innerHTML = `<span>${slot.name}</span>`
                    wheel.appendChild(numberSlot)

                    const imageSlot = document.createElement('div')
                    imageSlot.classList.add('imageSlot')
                    imageSlot.style.setProperty('--i', index + 1)
                    const img = document.createElement('img')
                    img.src = `../public/images/house/${slot.image}`
                    img.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot.appendChild(img)
                    imageWheel.appendChild(imageSlot)
                })

                slots1.forEach((slot, index) => {
                    const numberSlot1 = document.createElement('div')
                    numberSlot1.classList.add('number')
                    numberSlot1.style.setProperty('--i', index + 1)
                    numberSlot1.style.setProperty('--clr', slot.color)
                    numberSlot1.innerHTML = `<span>${slot.name}</span>`
                    wheel1.appendChild(numberSlot1)

                    const imageSlot1 = document.createElement('div')
                    imageSlot1.classList.add('imageSlot')
                    imageSlot1.style.setProperty('--i', index + 1)
                    const img1 = document.createElement('img')
                    img1.src = `../public/images/house/${slot.image}`
                    img1.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot1.appendChild(img1)
                    imageWheel1.appendChild(imageSlot1)
                })
            }

            function updateSlots() {
                const selectedValue = document.getElementById('teamSelect').value
                slots = allSlots[selectedValue]
                populateWheel()
            }

            document.getElementById('teamSelect').addEventListener('change', updateSlots)

            populateWheel()
            const spinBtn = document.querySelector('.spinBtn')
            const spinBtn1 = document.querySelector('.spinBtn1')
            const spinSound = document.getElementById("spinSound")

            let isSpinning = false
            let spinned = false

            let isSpinning1 = false
            let spinned1 = false

            spinBtn.addEventListener('click', () => {
                if (isSpinning) return
                isSpinning = true
                spinned = true

                const randomDegree = Math.floor(Math.random() * 3600)
                const rotationAmount = randomDegree + 1800

                wheel.style.transition = 'transform 5s ease-in-out'
                imageWheel.style.transition = 'transform 5s ease-in-out'
                wheel.style.transform = `rotate(${rotationAmount}deg)`
                imageWheel.style.transform = `rotate(${-rotationAmount}deg)`

                spinSound.play()

                wheel.addEventListener('transitionend', () => {
                    isSpinning = false
                    spinSound.pause()
                    spinSound.currentTime = 0
                    trackPositions()
                }, { once: true })
            })

            spinBtn1.addEventListener('click', () => {
                if (isSpinning1) return
                isSpinning1 = true
                spinned1 = true

                const randomDegree = Math.floor(Math.random() * 3600)
                const rotationAmount = randomDegree + 1800

                wheel1.style.transition = 'transform 5s ease-in-out'
                imageWheel1.style.transition = 'transform 5s ease-in-out'
                wheel1.style.transform = `rotate(${rotationAmount}deg)`
                imageWheel1.style.transform = `rotate(${-rotationAmount}deg)`

                spinSound.play()

                wheel1.addEventListener('transitionend', () => {
                    isSpinning1 = false
                    spinSound.pause()
                    spinSound.currentTime = 0
                    trackPositions()
                }, { once: true })
            })

            function trackPositions() {
                const imageSlots = document.querySelectorAll('.imageSlot')
                const numberSlots = document.querySelectorAll('.number')

                const matchedSlots = []

                imageSlots.forEach((imageSlot, index) => {
                    const imageRect = imageSlot.getBoundingClientRect()
                    const imageCenterX = imageRect.left + imageRect.width / 2
                    const imageCenterY = imageRect.top + imageRect.height / 2

                    let closestSlot = null
                    let minDistance = Infinity

                    numberSlots.forEach((numberSlot) => {
                        const numberRect = numberSlot.getBoundingClientRect()
                        const numberCenterX = numberRect.left + numberRect.width / 2
                        const numberCenterY = numberRect.top + numberRect.height / 2

                        const distance = Math.sqrt(Math.pow(imageCenterX - numberCenterX, 2) + Math.pow(imageCenterY - numberCenterY, 2));

                        if (distance < minDistance) {
                            minDistance = distance
                            closestSlot = numberSlot
                        }
                    })

                    if (closestSlot) {
                        const slotNumber = closestSlot.querySelector('span').innerText
                        const imageName = imageSlot.querySelector('img').alt
                        matchedSlots.push({ image: imageName, slot: slotNumber })
                    }
                })

                return matchedSlots
            }
            const submitBtn = document.querySelector('.submitBtn')
            const eventName = document.getElementById('event_name').value
            let gender = 'BOYS'

            function updateGender() {
                gender = document.getElementById('teamSelect').value
            }

            document.getElementById('teamSelect').addEventListener('change', updateGender)

            submitBtn.addEventListener('click', () => {
                if (spinned) {
                    const slotValues = trackPositions()

                    const slotNumbers = slotValues.map(item => {
                        return parseInt(item.slot.slice(5), 10)
                    })

                    document.getElementById('slots').value = JSON.stringify(slotNumbers)
                    document.getElementById('gender').value = gender

                    document.getElementById('hidden-form').submit()
                }
            })

            const triggerSpin = document.getElementById('triggerSpin');

            triggerSpin.addEventListener('click', () => {
                spinBtn.click();
                spinBtn1.click();
            });
        })

    </script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
<script>
    const duration = 15 * 1000,
        animationEnd = Date.now() + duration,
        defaults = {
            startVelocity: 30,
            spread: 360,
            ticks: 60,
            zIndex: 50
        };

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function() {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 20 * (timeLeft / duration);

        // since particles fall down, start a bit higher than random
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.2, 0.7),
                    y: Math.random() - 0.2
                },
            })
        );
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.7, 0.9),
                    y: Math.random() - 0.2
                },
            })
        );
    }, 250);
</script>
</body>

</html>