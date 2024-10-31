<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Bar with Labels</title>
    <style>
        .progress-container {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            height: 30px;
            margin-bottom: 60px;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(to right, green 75%, orange 95%, red 100%);
            border-radius: 10px;
            transition: width 0.5s ease;
            position: relative;
        }

        .shine {
            position: absolute;
            top: 0;
            left: -50%;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            transform: skewX(-45deg);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% {
                left: -50%;
            }

            100% {
                left: 150%;
            }
        }

        .tooltip {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background-color: black;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            display: none;
            /* Hidden by default */
        }

        .progress-container:hover .tooltip {
            display: block;
        }

        .day-label {
            position: absolute;
            top: calc(80% - 14px);
            /*135
            /* Position below the progress bar */
            transform: translateX(-50%);
            color: black;
            font-size: 12px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="progress-layout font-18">
        <div class=" row">
            <div class="col-md-12 col-12 mb-2">
                ระยะเวลาทดลองงาน
            </div>
            <div class="col-md-6 col-6 text-start text-secondary" style="padding-left: 34px;">
                วันที่เริ่มปฏิบัติงาน
            </div>
            <div class="col-md-6 col-6 text-secondary">
                <?= fullDateTH3($start_date) ?>
            </div>
            <div class="col-md-6 col-6 text-start text-secondary" style="padding-left: 34px;">
                จำนวนวัน
            </div>
            <div class="col-md-6 col-6 text-secondary" id="trail-day">
                xx วัน
            </div>
            <div class="col-md-12 col-12 text-end font-12">
                <i class="bi bi-clock"></i>&nbsp;&nbsp;วัน
            </div>
        </div>
        <div class="progress-container">
            <div class="progress-bar" id="progress-bar" style="width: 33.6134%; background: linear-gradient(to right, green 75.63%, orange 100%, red 100%);">
                <div class="shine"></div>
                <div class="tooltip" id="tooltip">Day 40 of 119</div>
            </div>
        </div>
        <!-- Labels for Day 0, Day 90, and Day 119 -->
        <div class="day-label font-14" id="day-0">0</div>
        <div class="day-label" id="current-label"></div>
        <div class="day-label font-14" id="day-90">92</div>
        <div class="day-label font-14" data-point="<?= $trail_date ?>" data-date="<?= $start_date ?>" id="day-119">119</div>

        <!-- Current label -->
    </div>
    <script>
        const day119Label = document.getElementById('day-119');
        const start_date = day119Label.getAttribute('data-date')
        const targetDate = new Date(start_date);
        // กำหนดวันปัจจุบัน
        const currentDate = new Date();

        // คำนวณความต่างของเวลาระหว่างสองวัน (ในหน่วย milliseconds)
        const timeDifference = currentDate - targetDate;

        // แปลงจาก milliseconds เป็นวัน (1 วัน = 24 ชั่วโมง * 60 นาที * 60 วินาที * 1000 มิลลิวินาที)
        const currentDay = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)); // Change the current day as needed
        const totalDays = day119Label.getAttribute('data-point')
        const endPoints = [90, day119Label.getAttribute('data-point')]; // End points

        const progressBar = document.getElementById('progress-bar');
        const tooltip = document.getElementById('tooltip');
        const currentLabel = document.getElementById('current-label');
        const day0Label = document.getElementById('day-0');
        const day90Label = document.getElementById('day-90');
        day90Label.innerText = endPoints[0]
        if (endPoints[0] == endPoints[1]) {
            day119Label.innerText = ''
        } else {
            day119Label.innerText = endPoints[1]
        }
        document.getElementById('trail-day').innerText = `${currentDay} วัน`
        // Calculate the percentage of the progress bar
        const progressPercentage = (currentDay / totalDays) * 100;
        progressBar.style.width = progressPercentage + '%';

        // Update tooltip and current label
        tooltip.innerText = `Day ${currentDay} of ${totalDays}`;
        // currentLabel.innerText = `${currentDay}`;

        // Update progress bar color based on end points
        const sortedEndPoints = endPoints.slice().sort((a, b) => a - b);
        let gradientStops = '';
        if (sortedEndPoints.length > 0) {
            gradientStops += `#012970 ${(((sortedEndPoints[0]-(sortedEndPoints[0] == sortedEndPoints[1]?20:0)) / totalDays) * 100).toFixed(2)}%`;
            if (sortedEndPoints.length > 1) {
                gradientStops += `, green ${((sortedEndPoints[1] / totalDays) * 100).toFixed(2)}%`;
            }
            gradientStops += `, green 100%`;
            progressBar.style.background = `linear-gradient(to right, ${gradientStops})`;
        } else {
            progressBar.style.backgroundColor = 'green'; // Default color if no end points
        }

        // Function to update label positions
        function updateLabelPositions() {
            const progressBarWidth = progressBar.parentElement.clientWidth;

            // Position current label based on progress
            const currentLabelPositionX = (progressPercentage / 100) * progressBarWidth;
            currentLabel.style.left = `${currentLabelPositionX}px`;

            // Position end point labels
            const day0PositionX = 26; // Starting point is at the very beginning
            day0Label.style.left = `${day0PositionX}px`;

            const day90PositionX = (endPoints[0] / totalDays) * progressBarWidth;
            day90Label.style.left = `${day90PositionX}px`;

            const day119PositionX = (endPoints[1] / totalDays) * progressBarWidth;
            day119Label.style.left = `${day119PositionX}px`;
        }

        // Initial update of label positions
        updateLabelPositions();

        // Adjust positions on window resize
        window.addEventListener('resize', updateLabelPositions);
    </script>
</body>

</html>