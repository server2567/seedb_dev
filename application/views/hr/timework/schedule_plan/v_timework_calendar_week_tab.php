<style>
.week-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    float: right;
    padding: 16px;
}

.week-navigation button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.week-navigation button:hover {
    background-color: #0056b3;
}

.week-range {
    padding: 8px 16px;
    font-size: 1.2em;
    font-weight: bold;
}

.table thead th {
    text-align: center;
    background-color: #343a40;
    color: white;
}

.table {
    display: table; /* ค่าเริ่มต้นของตาราง */
}

.table tr {
    display: table-row; /* ค่าเริ่มต้นของแถว */
}

.table td, .table th {
    display: table-cell; /* ค่าเริ่มต้นของเซลล์ */
    vertical-align: middle; /* จัดการการวางตำแหน่งในแนวตั้ง */
}

/* สีพื้นฐานของ work-block */
.work-block {
    position: relative;
    border-radius: 4px;
    border: 1px solid;
    padding: 5px;
    text-align: center;
    margin-bottom: 8px;
}

/* ประเภทของงาน */
.work-block.normal-work {
    background-color: #e3f2fd;
    border-color: #90caf9;
}

.work-block.overtime-work {
    background-color: #ffecb3;
    border-color: #ffb74d;
}

/* ประเภทการลา */
.work-block.sick-leave {
    background-color: #fce4ec;
    border-color: #f06292;
}

.work-block.personal-leave {
    background-color: #fff3e0;
    border-color: #ffb74d;
}

.work-block.vacation-leave {
    background-color: #e8f5e9;
    border-color: #81c784;
}

.work-block.maternity-leave {
    background-color: #f3e5f5;
    border-color: #ba68c8;
}

.work-block.ordination-leave {
    background-color: #e0f7fa;
    border-color: #4dd0e1;
}

.work-block.training-leave {
    background-color: #fffde7;
    border-color: #fff176;
}

/* สีเมื่อ hover */
.work-block:hover {
    opacity: 0.9;
    transition: opacity 0.3s ease;
}


.time-slot {
    font-size: 0.9em;
    color: #333;
}

.profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.work-type {
    font-size: 0.8em;
    color: #6c757d;
    margin-top: 4px;
}

.person_list_td {
    text-align: left;
    padding-left: 10px; /* เพิ่มระยะห่างจากขอบซ้าย */
    display: flex;
    align-items: center;
}

.work-block-container.skip {
    display: none;
}



</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <input type="text" id="search-person" class="form-control me-2" placeholder="ค้นหาบุคลากร">
        <button id="filter-button" class="btn btn-outline-secondary"><i class="bi bi-filter"></i></button>
    </div>
    <div class="week-navigation">
        <button id="prev-week" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-square"></i></button>
        <span id="week-range" class="week-range">Week 1 - Week 7</span>
        <button id="next-week" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-right-square"></i></button>
    </div>
</div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>รายชื่อบุคลากร</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
            </tr>
        </tbody>
    </table>
     
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentWeek = 1; // สัปดาห์ที่กำลังแสดงอยู่
    const totalWeeks = 5; // จำนวนสัปดาห์ทั้งหมดที่สามารถเลือกได้
    const startDate = new Date(2024, 7, 1); // เริ่มต้นวันที่ 1 สิงหาคม 2024
    const weekRangeSpan = document.getElementById('week-range');
    const prevWeekBtn = document.getElementById('prev-week');
    const nextWeekBtn = document.getElementById('next-week');

    // อัปเดตช่วงวันที่ในแถบแสดงสัปดาห์
    function updateWeekRange() {
        const weekStartDate = new Date(startDate);
        weekStartDate.setDate(weekStartDate.getDate() + (currentWeek - 1) * 7);
        const weekEndDate = new Date(startDate);
        weekEndDate.setDate(weekStartDate.getDate() + 6);

        const options = { month: 'long', day: 'numeric' };
        weekRangeSpan.textContent = `${weekStartDate.toLocaleDateString('th-TH', options)} - ${weekEndDate.toLocaleDateString('th-TH', options)}`;

        updateTable(weekStartDate); // อัปเดตตารางสำหรับสัปดาห์ที่เลือก

         // อัปเดตข้อความใน th 1-7 ตามวันของสัปดาห์ที่เลือก
        const thElements = document.querySelectorAll('.table thead th');
        for (let i = 1; i <= 7; i++) {
            const dayDate = new Date(weekStartDate);
            dayDate.setDate(weekStartDate.getDate() + (i - 1));
            thElements[i].textContent = dayDate.toLocaleDateString('th-TH', options);
        }
    }

    // เปลี่ยนไปยังสัปดาห์ก่อนหน้า
    prevWeekBtn.addEventListener('click', function () {
        if (currentWeek > 1) {
            currentWeek--;
            updateWeekRange();
        }
    });

    // เปลี่ยนไปยังสัปดาห์ถัดไป
    nextWeekBtn.addEventListener('click', function () {
        if (currentWeek < totalWeeks) {
            currentWeek++;
            updateWeekRange();
        }
    });

    // ฟังก์ชันสำหรับอัปเดตตารางด้วยข้อมูลใหม่
    function updateTable(weekStartDate) {
        const mockupData = {
    1: [
        {
            name: 'นายสมชาย พัฒนาการ',
            profilePic: 'default.png', // ชื่อไฟล์รูปภาพสำหรับบุคลากร 1
            workDetails: [
                {
                    start_date: '2024-08-01',
                    end_date: '2024-08-01',
                    start_time: '08:00',
                    end_time: '12:00',
                    class: 'normal-work',
                    work_name: 'งานปกติ',
                    work_time: '08:00 - 12:00',
                    work_detail: 'งานเอกสารทั่วไป'
                },
                {
                    start_date: '2024-08-02',
                    end_date: '2024-08-03',
                    start_time: '13:00',
                    end_time: '17:00',
                    class: 'sick-leave',
                    work_name: 'ลาป่วย',
                    work_time: '13:00 - 17:00',
                    work_detail: 'ลาป่วยเนื่องจากอาการไข้',
                    span: 2
                },
                // เพิ่มกิจกรรมอื่นๆ ตามความจำเป็น...
            ]
        },
        {
            name: 'นางสาววิไล ศรีสุข',
            profilePic: 'default.png', // ชื่อไฟล์รูปภาพสำหรับบุคลากร 2
            workDetails: [
                {
                    start_date: '2024-08-01',
                    end_date: '2024-08-02',
                    start_time: '20:00',
                    end_time: '07:00',
                    class: 'overtime-work',
                    work_name: 'งานนอกเวลา',
                    work_time: '20:00 - 07:00',
                    span: 2
                },
                {
                    start_date: '2024-08-02',
                    end_date: '2024-08-02',
                    start_time: '15:00',
                    end_time: '18:00',
                    class: 'personal-leave',
                    work_name: 'ลากิจ',
                    work_time: '15:00 - 18:00'
                },
                {
                    start_date: '2024-08-03',
                    end_date: '2024-08-03',
                    start_time: '09:00',
                    end_time: '12:00',
                    class: 'normal-work',
                    work_name: 'งานปกติ',
                    work_time: '09:00 - 12:00'
                },
                {
                    start_date: '2024-08-04',
                    end_date: '2024-08-04',
                    class: '',
                    work_name: '',
                    work_time: ''
                },
                {
                    start_date: '2024-08-05',
                    end_date: '2024-08-05',
                    start_time: '08:00',
                    end_time: '12:00',
                    class: 'vacation-leave',
                    work_name: 'ลาพักร้อน',
                    work_time: '08:00 - 12:00'
                },
                {
                    start_date: '2024-08-06',
                    end_date: '2024-08-06',
                    class: '',
                    work_name: '',
                    work_time: ''
                },
                {
                    start_date: '2024-08-07',
                    end_date: '2024-08-07',
                    start_time: '12:00',
                    end_time: '16:00',
                    class: 'normal-work',
                    work_name: 'งานปกติ',
                    work_time: '12:00 - 16:00'
                }
            ]
        }
        // เพิ่มบุคคลเพิ่มเติมตามต้องการ...
    ]
};


   const tbody = document.querySelector('tbody');
    const data = mockupData[currentWeek] || [];

    tbody.innerHTML = ''; // Reset tbody

    data.forEach((person, personIndex) => {
        const row = document.createElement('tr');

        const profilePictureUrl = '<?php echo site_url($this->config->item("hr_dir") . "getIcon?type=" . $this->config->item("hr_profile_dir") . "profile_picture&image="); ?>' + 
                                (person.profilePic != null ? person.profilePic : 'default.png');

        const nameCell = document.createElement('td');
        nameCell.classList.add('person_list_td');
        nameCell.innerHTML = `
            <img src="${profilePictureUrl}" class="rounded-circle me-2" alt="Person ${personIndex + 1}" width="50" height="50">
            ${person.name}
        `;
        row.appendChild(nameCell);

        let dayIndex = 0;
        while (dayIndex < 7) {
            const workCell = document.createElement('td');
            workCell.classList.add('work-block-container');
            workCell.setAttribute('id', `person-${personIndex + 1}-day-${dayIndex + 1}`);
            workCell.setAttribute('data-person', person.name);
            
            const dayDate = new Date(weekStartDate);
            dayDate.setDate(dayDate.getDate() + dayIndex);
            workCell.setAttribute('data-date', dayDate.toISOString().split('T')[0]);

            const dayDetails = person.workDetails[dayIndex];
            if (dayDetails && dayDetails.class) {
                if (dayDetails.span) {
                    workCell.setAttribute('colspan', dayDetails.span); // ใช้ colspan เพื่อครอบคลุมหลายวัน
                    for (let i = 0; i < dayDetails.span - 1; i++) {
                        row.appendChild(document.createElement('td')).classList.add('skip'); // สร้างเซลล์ที่ข้าม (skip) เพื่อให้ตรงกับ colspan
                    }
                    dayIndex += dayDetails.span - 1;
                }

                const block = document.createElement('div');
                block.classList.add('work-block', 'mb-1', dayDetails.class);
                block.innerHTML = `
                    <div class="time-slot">${dayDetails.work_time}</div>
                    <div class="work-type">${dayDetails.work_name}</div>
                    <div class="work-detail">${dayDetails.work_detail}</div>
                `;
                workCell.appendChild(block);
            }

            row.appendChild(workCell);
            dayIndex++;
        }

        tbody.appendChild(row);
    });
}

    // เรียกใช้ฟังก์ชันเพื่อแสดงข้อมูลเริ่มต้นเมื่อหน้าโหลดเสร็จ
    updateWeekRange();
});







</script>