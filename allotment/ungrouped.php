<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .button-54 {
            font-family: "Poppins", "Open Sans", sans-serif;
            font-size: 16px;
            letter-spacing: 2px;
            text-decoration: none;
            text-transform: uppercase;
            color: #00bfff;
            background: #fff;
            cursor: pointer;
            border: 3px solid #00bfff;
            padding: 0.25em 0.5em;
            box-shadow: 1px 1px 0px 0px #00bfff, 2px 2px 0px 0px #00bfff, 3px 3px 0px 0px #00bfff, 4px 4px 0px 0px #00bfff, 5px 5px 0px 0px #00bfff;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            border-radius: 10px;
            margin: 0 4px 8px 0;
            transition: box-shadow 0.2s, top 0.2s, left 0.2s, background 0.2s, color 0.2s;
        }
        .button-54:active, .button-54.active, .button-54:focus {
            box-shadow: 0px 0px 0px 0px #00bfff;
            top: 5px;
            left: 5px;
            background: #00bfff;
            color: #fff;
        }
        .button-54:hover {
            background: #00bfff;
            color: #fff;
        }
        @media (min-width: 768px) {
            .button-54 {
                padding: 0.25em 0.75em;
            }
        }
    </style>
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
            overflow: auto;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: black;
            position: relative;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            z-index: 1;
        }

        .head {
            position: absolute;
            left: 50%;
            top: 5%;
            transform: translateX(-50%);
            font-size: 40px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: aqua;
            z-index: 2;
        }

        .wheel-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 60px;
            margin: 100px auto 20px;
            max-width: 1400px;
            z-index: 2;
        }

        .container {
            position: relative;
            width: 400px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            z-index: 3;
        }

        @keyframes zoom {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.2);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .spinBtn, .spinBtn1, .spinBtn2, .spinBtn3 {
            animation: zoom 2s infinite;
            position: absolute;
            width: 60px;
            height: 60px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
        .imageWheel,
        .wheel1,
        .imageWheel1,
        .wheel2,
        .imageWheel2,
        .wheel3,
        .imageWheel3 {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 5s ease-in-out;
            top: 0;
            left: 0;
        }

        .wheel,
        .wheel1,
        .wheel2,
        .wheel3 {
            background: #333;
            box-shadow: 0 0 0 5px #333, 0 0 0 15px #fff, 0 0 0 18px #111;
        }

        .imageWheel,
        .imageWheel1,
        .imageWheel2,
        .imageWheel3 {
            width: 140%;
            height: 140%;
            top: -20%;
            left: -20%;
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
            transform: rotate(calc(var(--slot-angle, 90deg) * var(--i)));
        }

        .imageSlot {
            transform: rotate(calc(var(--slot-angle-neg, -90deg) * var(--i)));
        }

        .number span {
            position: relative;
            transform: rotate(45deg);
            font-size: 2em;
            font-weight: 700;
            color: #fff;
            text-shadow: 3px 5px 2px rgba(0, 0, 0, 0.15);
            left: 40px;
            top: 40px;
        }

        @keyframes animateDropShadow {
            0% {
                filter: drop-shadow(0px 0px 30px rgba(255, 0, 0, 0.7));
            }
            33% {
                filter: drop-shadow(0px 0px 30px rgba(0, 255, 0, 0.7));
            }
            66% {
                filter: drop-shadow(0px 0px 30px rgba(0, 0, 255, 0.7));
            }
            100% {
                filter: drop-shadow(0px 0px 30px rgba(255, 0, 0, 0.7));
            }
        }

        .imageSlot img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            transform: rotate(30deg);
            animation: animateDropShadow 5s infinite;
        }

        .select-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin: 40px auto;
            padding: 20px 32px;
            background: rgba(20, 20, 20, 0.9);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3), 0 0 0 2px rgba(0, 255, 231, 0.2);
            backdrop-filter: blur(8px);
            max-width: 800px;
            z-index: 10;
        }

        #teamSelect {
            padding: 12px 16px;
            font-size: 1.1em;
            font-weight: 500;
            background: #1a1a1a;
            color: #00ffe7;
            border: 2px solid #00ffe7;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 160px;
        }

        #teamSelect:hover, #teamSelect:focus {
            background: #2a2a2a;
            border-color: #00ccff;
            box-shadow: 0 0 12px rgba(0, 255, 231, 0.3);
            outline: none;
        }

        #teamSelect option {
            background: #1a1a1a;
            color: #00ffe7;
            padding: 10px;
        }

        .submitBtn {
            background: linear-gradient(135deg, #00ffe7, #ff00cc);
            border: none;
            color: #fff;
            padding: 14px 28px;
            font-size: 1.1em;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 255, 231, 0.2);
            transition: all 0.3s ease;
            letter-spacing: 0.05em;
        }

        .submitBtn:hover {
            background: linear-gradient(135deg, #ff00cc, #00ffe7);
            box-shadow: 0 6px 16px rgba(0, 255, 231, 0.3);
            transform: translateY(-2px);
        }

        .submitBtn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 8px rgba(0, 255, 231, 0.2);
        }

        #triggerSpin, #triggerSpinTwo {
            background: linear-gradient(135deg, #007bff, #00ffe7);
            border: none;
            color: #fff;
            padding: 14px 28px;
            font-size: 1.1em;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 255, 231, 0.2);
            transition: all 0.3s ease;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        #triggerSpin:hover, #triggerSpinTwo:hover {
            background: linear-gradient(135deg, #00ffe7, #007bff);
            box-shadow: 0 6px 16px rgba(0, 255, 231, 0.3);
            transform: translateY(-2px);
        }

        #triggerSpin:active, #triggerSpinTwo:active {
            transform: translateY(1px);
            box-shadow: 0 2px 8px rgba(0, 255, 231, 0.2);
        }

        #triggerSpin span, #triggerSpinTwo span {
            font-size: 1.3em;
        }

        #event_name {
            padding: 12px 16px;
            font-size: 1.1em;
            font-weight: 500;
            background: #1a1a1a;
            color: #00ffe7;
            border: 2px solid rgba(0, 255, 231, 0.5);
            border-radius: 8px;
            cursor: not-allowed;
            opacity: 0.7;
            min-width: 200px;
            text-align: center;
        }

        /* Popup Styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
            z-index: 100;
            max-width: 800px;
            width: 95%;
            max-height: 85vh;
            overflow-y: auto;
            border: 3px solid #00ffe7;
        }

        .popup.show {
            display: block;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .popup-header h2 {
            color: #00ffe7;
            font-size: 2em;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            color: #00ffe7;
            font-size: 2em;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #ff00cc;
        }

        .slot-table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }

        .slot-table th,
        .slot-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1.5px solid rgba(0, 255, 231, 0.2);
            font-size: 1.2em;
        }

        .slot-table th {
            background: #1a1a1a;
            color: #00ffe7;
            font-weight: 600;
        }

        .slot-table td {
            background: #2a2a2a;
        }

        .slot-table img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            vertical-align: middle;
            margin-right: 12px;
        }

        @media (max-width: 600px) {
            .select-container {
                flex-direction: column;
                gap: 12px;
                padding: 16px 24px;
                max-width: 90%;
            }

            #teamSelect, .submitBtn, #triggerSpin, #triggerSpinTwo, #event_name {
                width: 100%;
                max-width: 300px;
            }

            .popup {
                width: 95%;
                padding: 20px;
                max-width: 95%;
            }

            .popup-header h2 {
                font-size: 1.8em;
            }

            .close-btn {
                font-size: 1.8em;
            }

            .slot-table th,
            .slot-table td {
                font-size: 1em;
                padding: 12px;
            }

            .slot-table img {
                width: 60px;
                height: 60px;
                margin-right: 8px;
            }
        }
    </style>
</head>

<body>
    <a href="index.php" class="button-54" style="position: absolute; left: 30px; top: 30px; z-index: 100;">&larr; Back to Event List</a>
    <canvas id="backgroundCanvas"></canvas>
    <canvas id="particleCanvas"></canvas>

    <audio id="spinSound" src="../public/music/spinning-jar-cap.mp3"></audio>

    <div class="wheel-container">
        <div class="container">
            <div class="spinBtn">Spin</div>
            <div class="wheel"></div>
            <div class="imageWheel"></div>
        </div>
        <div class="container">
            <div class="spinBtn1">Spin</div>
            <div class="wheel1"></div>
            <div class="imageWheel1"></div>
        </div>
        <div class="container">
            <div class="spinBtn2">Spin</div>
            <div class="wheel2"></div>
            <div class="imageWheel2"></div>
        </div>
        <div class="container">
            <div class="spinBtn3">Spin</div>
            <div class="wheel3"></div>
            <div class="imageWheel3"></div>
        </div>
    </div>

    <form id="hidden-form" action="../routes/admin/assignSlot.php" method="post" style="display:none;">
        <input type="hidden" id="gender" name="gender" value="">
        <input type="hidden" id="slots" name="slot_array" value="">
        <input type="hidden" name="event_name" value="<?php echo $_GET['eventName'] ?>">
        <input type="hidden" name="isGroup" value="0">
        <input type="hidden" name="group_count" value="1">
    </form>

    <div class="select-container">
        <select id="teamSelect">
            <option value="BOYS">Select Gender</option>
            <option value="GIRLS">Girls</option>
            <option value="BOYS">Boys</option>
        </select>
        <button class="submitBtn">Submit</button>
        <button id="triggerSpin"><span style="font-size:1.3em;">&#x1F3B2;</span> Spin All</button>
        <button id="triggerSpinTwo"><span style="font-size:1.3em;">&#x1F3B2;</span> Spin Two</button>
        <input type="text" id="event_name" name="eventName" readonly value="<?php echo $_GET['eventName'] ?>">
    </div>

    <!-- Popup for displaying slot assignments -->
    <div class="popup" id="slotPopup">
        <div class="popup-header">
            <h2>Slot Assignments</h2>
            <button class="close-btn" id="closePopup">&times;</button>
        </div>
        <table class="slot-table">
            <thead>
                <tr>
                    <th>Team</th>
                    <th>Slot Number</th>
                </tr>
            </thead>
            <tbody id="slotTableBody"></tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allSlots = {
                GIRLS: [
                    { name: 'Slot 1', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 2', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 3', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 4', color: '#daa520', image: 'VIOLET_VIPERS.png' },
                    { name: 'Slot 5', color: '#228B22', image: 'EMERALD_EAGLES.png' }
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
                    { name: 'Slot 6', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 7', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 8', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 9', color: '#daa520', image: 'VIOLET_VIPERS.png' },
                    { name: 'Slot 10', color: '#228B22', image: 'EMERALD_EAGLES.png' }
                ],
                BOYS: [
                    { name: 'Slot 5', color: '#ff34f0', image: 'DINO_THUNDERS.png' },
                    { name: 'Slot 6', color: '#ff7f50', image: 'DRAGON_WARRIORS.png' },
                    { name: 'Slot 7', color: '#3cb371', image: 'PHOENIX_BLASTERS.png' },
                    { name: 'Slot 8', color: '#4169e1', image: 'TIGER_THRASHERS.png' }
                ]
            }

            const allSlots2 = {
                GIRLS: [
                    { name: 'Slot 11', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 12', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 13', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 14', color: '#daa520', image: 'VIOLET_VIPERS.png' },
                    { name: 'Slot 15', color: '#228B22', image: 'EMERALD_EAGLES.png' }
                ],
                BOYS: [
                    { name: 'Slot 9', color: '#ff34f0', image: 'DINO_THUNDERS.png' },
                    { name: 'Slot 10', color: '#ff7f50', image: 'DRAGON_WARRIORS.png' },
                    { name: 'Slot 11', color: '#3cb371', image: 'PHOENIX_BLASTERS.png' },
                    { name: 'Slot 12', color: '#4169e1', image: 'TIGER_THRASHERS.png' }
                ]
            }

            const allSlots3 = {
                GIRLS: [
                    { name: 'Slot 16', color: '#db7093', image: 'BLUE_BLASTERS.png' },
                    { name: 'Slot 17', color: '#20b2aa', image: 'GALACTIC_STARS.png' },
                    { name: 'Slot 18', color: '#d63e92', image: 'ROSY_RIDERS.png' },
                    { name: 'Slot 19', color: '#daa520', image: 'VIOLET_VIPERS.png' },
                    { name: 'Slot 20', color: '#228B22', image: 'EMERALD_EAGLES.png' }
                ],
                BOYS: [
                    { name: 'Slot 13', color: '#ff34f0', image: 'DINO_THUNDERS.png' },
                    { name: 'Slot 14', color: '#ff7f50', image: 'DRAGON_WARRIORS.png' },
                    { name: 'Slot 15', color: '#3cb371', image: 'PHOENIX_BLASTERS.png' },
                    { name: 'Slot 16', color: '#4169e1', image: 'TIGER_THRASHERS.png' }
                ]
            }

            const wheel = document.querySelector('.wheel')
            const imageWheel = document.querySelector('.imageWheel')

            const wheel1 = document.querySelector('.wheel1')
            const imageWheel1 = document.querySelector('.imageWheel1')

            const wheel2 = document.querySelector('.wheel2')
            const imageWheel2 = document.querySelector('.imageWheel2')

            const wheel3 = document.querySelector('.wheel3')
            const imageWheel3 = document.querySelector('.imageWheel3')

            // Fisher-Yates shuffle
            function shuffle(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            function populateWheel(shuffledSlots0, shuffledSlots1, shuffledSlots2, shuffledSlots3) {
                const selectedValue = document.getElementById('teamSelect').value

                wheel.innerHTML = ''
                imageWheel.innerHTML = ''

                wheel1.innerHTML = ''
                imageWheel1.innerHTML = ''

                wheel2.innerHTML = ''
                imageWheel2.innerHTML = ''

                wheel3.innerHTML = ''
                imageWheel3.innerHTML = ''

                // Wheel 0 (first wheel)
                let slots0 = shuffledSlots0 || allSlots[selectedValue]
                let slotAngle0 = slots0.length === 5 ? '72deg' : '90deg'
                let slotAngleNeg0 = slots0.length === 5 ? '-72deg' : '-90deg'
                wheel.style.setProperty('--slot-angle', slotAngle0)
                imageWheel.style.setProperty('--slot-angle-neg', slotAngleNeg0)

                slots0.forEach((slot, index) => {
                    const numberSlot = document.createElement('div')
                    numberSlot.classList.add('number')
                    numberSlot.style.setProperty('--i', index)
                    numberSlot.style.setProperty('--clr', slot.color)
                    numberSlot.innerHTML = `<span>${slot.name}</span>`
                    wheel.appendChild(numberSlot)

                    const imageSlot = document.createElement('div')
                    imageSlot.classList.add('imageSlot')
                    imageSlot.style.setProperty('--i', index)
                    const img = document.createElement('img')
                    img.src = `../public/images/house/${slot.image}`
                    img.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot.appendChild(img)
                    imageWheel.appendChild(imageSlot)
                })

                // Wheel 1 (second wheel)
                let slots1 = shuffledSlots1 || allSlots1[selectedValue]
                let slotAngle1 = slots1.length === 5 ? '72deg' : '90deg'
                let slotAngleNeg1 = slots1.length === 5 ? '-72deg' : '-90deg'
                wheel1.style.setProperty('--slot-angle', slotAngle1)
                imageWheel1.style.setProperty('--slot-angle-neg', slotAngleNeg1)

                slots1.forEach((slot, index) => {
                    const numberSlot = document.createElement('div')
                    numberSlot.classList.add('number')
                    numberSlot.style.setProperty('--i', index)
                    numberSlot.style.setProperty('--clr', slot.color)
                    numberSlot.innerHTML = `<span>${slot.name}</span>`
                    wheel1.appendChild(numberSlot)

                    const imageSlot = document.createElement('div')
                    imageSlot.classList.add('imageSlot')
                    imageSlot.style.setProperty('--i', index)
                    const img = document.createElement('img')
                    img.src = `../public/images/house/${slot.image}`
                    img.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot.appendChild(img)
                    imageWheel1.appendChild(imageSlot)
                })

                // Wheel 2 (third wheel)
                let slots2 = shuffledSlots2 || allSlots2[selectedValue]
                let slotAngle2 = slots2.length === 5 ? '72deg' : '90deg'
                let slotAngleNeg2 = slots2.length === 5 ? '-72deg' : '-90deg'
                wheel2.style.setProperty('--slot-angle', slotAngle2)
                imageWheel2.style.setProperty('--slot-angle-neg', slotAngleNeg2)

                slots2.forEach((slot, index) => {
                    const numberSlot = document.createElement('div')
                    numberSlot.classList.add('number')
                    numberSlot.style.setProperty('--i', index)
                    numberSlot.style.setProperty('--clr', slot.color)
                    numberSlot.innerHTML = `<span>${slot.name}</span>`
                    wheel2.appendChild(numberSlot)

                    const imageSlot = document.createElement('div')
                    imageSlot.classList.add('imageSlot')
                    imageSlot.style.setProperty('--i', index)
                    const img = document.createElement('img')
                    img.src = `../public/images/house/${slot.image}`
                    img.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot.appendChild(img)
                    imageWheel2.appendChild(imageSlot)
                })

                // Wheel 3 (fourth wheel)
                let slots3 = shuffledSlots3 || allSlots3[selectedValue]
                let slotAngle3 = slots3.length === 5 ? '72deg' : '90deg'
                let slotAngleNeg3 = slots3.length === 5 ? '-72deg' : '-90deg'
                wheel3.style.setProperty('--slot-angle', slotAngle3)
                imageWheel3.style.setProperty('--slot-angle-neg', slotAngleNeg3)

                slots3.forEach((slot, index) => {
                    const numberSlot = document.createElement('div')
                    numberSlot.classList.add('number')
                    numberSlot.style.setProperty('--i', index)
                    numberSlot.style.setProperty('--clr', slot.color)
                    numberSlot.innerHTML = `<span>${slot.name}</span>`
                    wheel3.appendChild(numberSlot)

                    const imageSlot = document.createElement('div')
                    imageSlot.classList.add('imageSlot')
                    imageSlot.style.setProperty('--i', index)
                    const img = document.createElement('img')
                    img.src = `../public/images/house/${slot.image}`
                    img.alt = slot.image.slice(0, slot.image.length - 4)
                    imageSlot.appendChild(img)
                    imageWheel3.appendChild(imageSlot)
                })
            }

            function updateSlots() {
                populateWheel()
            }

            document.getElementById('teamSelect').addEventListener('change', updateSlots)
            // Initial wheel population
            populateWheel()
            const spinBtn = document.querySelector('.spinBtn')
            // Helper to get slot numbers from slot objects
            function getSlotNumbers(slots) {
                return slots.map(slot => {
                    const match = slot.name.match(/\d+/)
                    return match ? parseInt(match[0]) : null
                }).filter(n => n !== null)
            }

            // Spin All button logic
            document.getElementById('triggerSpin').addEventListener('click', () => {
                const selectedValue = document.getElementById('teamSelect').value
                let slots0 = allSlots[selectedValue].slice()
                let slots1 = allSlots1[selectedValue].slice()
                let slots2 = allSlots2[selectedValue].slice()
                let slots3 = allSlots3[selectedValue].slice()

                const shuffledSlots0 = shuffle(slots0)
                const shuffledSlots1 = shuffle(slots1)
                const shuffledSlots2 = shuffle(slots2)
                const shuffledSlots3 = shuffle(slots3)

                populateWheel(shuffledSlots0, shuffledSlots1, shuffledSlots2, shuffledSlots3)

                const slotNumbers = [
                    ...getSlotNumbers(shuffledSlots0),
                    ...getSlotNumbers(shuffledSlots1),
                    ...getSlotNumbers(shuffledSlots2),
                    ...getSlotNumbers(shuffledSlots3)
                ]

                document.getElementById('slots').value = JSON.stringify(slotNumbers)
            })

            // Spin Two button logic
            document.getElementById('triggerSpinTwo').addEventListener('click', () => {
                spinMode = 'two';
                const selectedValue = document.getElementById('teamSelect').value
                let slots0 = allSlots[selectedValue].slice()
                let slots1 = allSlots1[selectedValue].slice()

                const shuffledSlots0 = shuffle(slots0)
                const shuffledSlots1 = shuffle(slots1)

                populateWheel(shuffledSlots0, shuffledSlots1)

                const slotNumbers = [
                    ...getSlotNumbers(shuffledSlots0),
                    ...getSlotNumbers(shuffledSlots1)
                ]

                document.getElementById('slots').value = JSON.stringify(slotNumbers)
            })

            const spinBtn1 = document.querySelector('.spinBtn1')
            const spinBtn2 = document.querySelector('.spinBtn2')
            const spinBtn3 = document.querySelector('.spinBtn3')
            const spinSound = document.getElementById("spinSound")

            let isSpinning = false
            let spinned = false

            let isSpinning1 = false
            let spinned1 = false

            let isSpinning2 = false
            let spinned2 = false

            let isSpinning3 = false
            let spinned3 = false

            let spinMode = 'all';

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
                }, { once: true })
            })

            spinBtn2.addEventListener('click', () => {
                if (isSpinning2) return
                isSpinning2 = true
                spinned2 = true

                const randomDegree = Math.floor(Math.random() * 3600)
                const rotationAmount = randomDegree + 1800

                wheel2.style.transition = 'transform 5s ease-in-out'
                imageWheel2.style.transition = 'transform 5s ease-in-out'
                wheel2.style.transform = `rotate(${rotationAmount}deg)`
                imageWheel2.style.transform = `rotate(${-rotationAmount}deg)`

                spinSound.play()

                wheel2.addEventListener('transitionend', () => {
                    isSpinning2 = false
                    spinSound.pause()
                    spinSound.currentTime = 0
                }, { once: true })
            })

            spinBtn3.addEventListener('click', () => {
                if (isSpinning3) return
                isSpinning3 = true
                spinned3 = true

                const randomDegree = Math.floor(Math.random() * 3600)
                const rotationAmount = randomDegree + 1800

                wheel3.style.transition = 'transform 5s ease-in-out'
                imageWheel3.style.transition = 'transform 5s ease-in-out'
                wheel3.style.transform = `rotate(${rotationAmount}deg)`
                imageWheel3.style.transform = `rotate(${-rotationAmount}deg)`

                spinSound.play()

                wheel3.addEventListener('transitionend', () => {
                    isSpinning3 = false
                    spinSound.pause()
                    spinSound.currentTime = 0
                }, { once: true })
            })

            document.getElementById('triggerSpinTwo').addEventListener('click', () => {
                if (!isSpinning && !isSpinning1) {
                    spinBtn.click()
                    spinBtn1.click()
                }
            })

            function trackPositions(wheelSelector, imageWheelSelector) {
                const imageSlots = document.querySelectorAll(`${imageWheelSelector} .imageSlot`)
                const numberSlots = document.querySelectorAll(`${wheelSelector} .number`)

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
                        matchedSlots.push({ image: imageName, slot: slotNumber, imageSrc: imageSlot.querySelector('img').src })
                    }
                })

                return matchedSlots
            }

            const submitBtn = document.querySelector('.submitBtn')
            const eventName = document.getElementById('event_name').value
            let gender = 'BOYS'
            const popup = document.getElementById('slotPopup')
            const closePopupBtn = document.getElementById('closePopup')
            const slotTableBody = document.getElementById('slotTableBody')

            function updateGender() {
                gender = document.getElementById('teamSelect').value
            }

            document.getElementById('teamSelect').addEventListener('change', updateGender)

            function showPopup(slotValues) {
                slotTableBody.innerHTML = ''
                slotValues.sort((a, b) => {
                    const slotA = parseInt(a.slot.match(/\d+/)[0])
                    const slotB = parseInt(b.slot.match(/\d+/)[0])
                    return slotA - slotB
                })
                slotValues.forEach(item => {
                    const row = document.createElement('tr')
                    row.innerHTML = `
                        <td><img src="${item.imageSrc}" alt="${item.image}">${item.image}</td>
                        <td>${item.slot}</td>
                    `
                    slotTableBody.appendChild(row)
                })
                popup.classList.add('show')
            }

            closePopupBtn.addEventListener('click', () => {
                popup.classList.remove('show')
                document.getElementById('hidden-form').submit()
            })

            submitBtn.addEventListener('click', () => {
                const spunCheck = spinMode === 'two' ? (spinned && spinned1) : (spinned && spinned1 && spinned2 && spinned3);
                if (spunCheck) {
                    let slotValues;
                    if (spinMode === 'two') {
                        slotValues = [
                            ...trackPositions('.wheel', '.imageWheel'),
                            ...trackPositions('.wheel1', '.imageWheel1')
                        ]
                    } else {
                        slotValues = [
                            ...trackPositions('.wheel', '.imageWheel'),
                            ...trackPositions('.wheel1', '.imageWheel1'),
                            ...trackPositions('.wheel2', '.imageWheel2'),
                            ...trackPositions('.wheel3', '.imageWheel3')
                        ]
                    }

                    const slotNumbers = slotValues.map(item => {
                        return parseInt(item.slot.slice(5), 10)
                    })

                    document.getElementById('slots').value = JSON.stringify(slotNumbers)
                    document.getElementById('gender').value = gender
                    document.querySelector('input[name="isGroup"]').value = '0';
                    document.querySelector('input[name="group_count"]').value = '1';

                    showPopup(slotValues)
                } else {
                    alert('Please spin the required wheels before submitting!')
                }
            })

            const triggerSpin = document.getElementById('triggerSpin')

            triggerSpin.addEventListener('click', () => {
                spinMode = 'all';
                if (!isSpinning && !isSpinning1 && !isSpinning2 && !isSpinning3) {
                    spinBtn.click()
                    spinBtn1.click()
                    spinBtn2.click()
                    spinBtn3.click()
                }
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles-confetti.bundle.min.js"></script>
    <script>
        const duration = 15 * 1000,
            animationEnd = Date.now() + duration,
            defaults = {
                startVelocity: 30,
                spread: 360,
                ticks: 60,
                zIndex: 50
            }

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now()

            if (timeLeft <= 0) {
                return clearInterval(interval)
            }

            const particleCount = 20 * (timeLeft / duration)

            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.2, 0.7),
                        y: Math.random() - 0.2
                    },
                })
            )
            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.7, 0.9),
                        y: Math.random() - 0.2
                    },
                })
            )
        }, 250)
    </script>
</body>

</html>