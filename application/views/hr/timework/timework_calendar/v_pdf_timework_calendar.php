
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo "ปฏิทินการทำงาน_".$ps_full_name."_".$filter_start_date."_ถึง_".$filter_end_date; ?></title>
    <style>
        body, html {
            font-family: "Sarabun", sans-serif;
            padding: 0;
            height: 100%;
            width: 100%;
            margin: 5px; /* ลด margin เพื่อเพิ่มพื้นที่แสดงผล */
        }

        /* ตาราง */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* ทำให้ตารางคงที่ ไม่ขยายหรือย่อ */
        }

        th, td {
            border: 4px solid white; /* เส้นขอบของตาราง */
            padding: 2px; /* ลด padding เพื่อให้ข้อความชิดกันมากขึ้น */
            vertical-align: top; /* ทำให้ข้อความชิดขอบบนของเซลล์ */
            text-align: left; /* ตั้งค่าให้ข้อความใน td ชิดซ้ายโดยปกติ */
            word-wrap: break-word; /* ทำให้ข้อความในเซลล์ห่อกลับหากยาวเกินไป */
            font-size: 14pt; /* ขนาดฟอนต์ที่เล็กลง */
            line-height: 1.2; /* ลดระยะห่างระหว่างบรรทัด */
        }

        .day-cell {
            text-align: right; /* จัดให้เนื้อหาใน td ชิดขวา */
            vertical-align: top; /* ทำให้ข้อความชิดขอบบนของเซลล์ */
            padding: 5px;
            font-size: 20pt;
            width: 14.28%;
        }

        /* หัวเดือน */
        h1 {
            /* border: 4px solid white; */
            /* background-color: #e43169; */
            color: white;
            font-size: 20pt;
            padding: 5px;
            text-align: center;
            margin: 0;
            font-weight: bold;
        }



        /* หัวตาราง (วันจันทร์ - อาทิตย์) */
        th {
            border: 4px solid white;
            background-color: #f07b96; /* พื้นหลังสีเทาของหัวตาราง */
            color: #53357a;
            font-size: 16pt; /* ขนาดฟอนต์ของหัวตาราง */
            font-weight: bold;
            text-align: center;
        }

        /* ข้อมูลในตาราง */
        td {
            font-size: 14pt; /* ขนาดฟอนต์ของข้อมูลในตาราง */
            font-weight: bold;
            background-color: #f9d8df;
            color: #53357a;
            padding: 2px; /* ลด padding เพื่อให้ข้อความชิดกัน */
            line-height: 1.2; /* ลดระยะห่างระหว่างบรรทัด */
        }

        /* ตารางย่อยภายในเซลล์ */
        .inner-table {
            width: 100%;
            border: none; /* ไม่มีเส้นขอบของตารางย่อย */
        }

        .inner-table td {
            border: none; /* ไม่มีเส้นขอบของเซลล์ในตารางย่อย */
            padding: 0; /* ไม่มี padding ในเซลล์ของตารางย่อย */
        }
         /* CSS สำหรับการแบ่งหน้าใน PDF */
         .page-break {
            page-break-before: always;
        }

        /* สำหรับการพิมพ์ */
        @media print {
            .page-break {
                page-break-before: always;
            }

            /* ซ่อน header/footer */
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
        }

    </style>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</head>
<body>

<?php
$logo_url = base_url() . "assets/" . $this->config->item("site_logo");

// ฟังก์ชันเพื่อจัดกลุ่มข้อมูลตามวันที่ โดยพิจารณาช่วงวันที่
function group_by_date($data) {
    $grouped = [];
    foreach ($data as $item) {
        $start_date = strtotime($item->twpp_start_date);
        $end_date = strtotime($item->twpp_end_date);

        // วนลูปเพิ่มข้อมูลในทุกวันที่อยู่ในช่วงเวลานั้น
        for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
            $date_key = date('Y-m-d', $current_date); // จัดรูปแบบวันที่เป็น Y-m-d
            $grouped[$date_key][] = $item; // เก็บข้อมูลตามวันที่ในรูปแบบของ array
        }
    }
    return $grouped;
}

// ฟังก์ชันสำหรับการตัดเวลาเป็น ชั่วโมง:นาที
function format_time($time) {
    return substr($time, 0, 5); // ตัดเวลาเพื่อแสดงเฉพาะ 2 หลัก (ชั่วโมง:นาที)
}

// เรียกใช้ฟังก์ชันเพื่อจัดกลุ่มข้อมูลตามวันที่
$grouped_timework = group_by_date($timework_data);

// ฟังก์ชันสำหรับแสดงปฏิทิน
function render_calendar($year, $month, $grouped_timework, $logo_url, $actor_type, $ps_full_name) {
    $date = new DateTime("$year-$month-01");

    // หาจำนวนวันในเดือนที่กำหนด
    $days_in_month = $date->format('t'); // จำนวนวันในเดือน
    $start_day_of_week = (new DateTime("$year-$month-01"))->format('w'); // 0 = อาทิตย์, 1 = จันทร์, ...
    
    // เพิ่มส่วนหัวพร้อมโลโก้
    echo '<div style="text-align: center;">';
    echo '<img src="' . $logo_url . '" alt="logo" style="max-height:60px;"> <br>';
    echo '</div><br>';
    // echo "<h1>เดือน " . $date->format('F Y') . "</h1>"; // หัวเรื่องปฏิทิน
    if ($actor_type == "medical") {
        $title_report = "ตารางแพทย์ออกตรวจ " . $ps_full_name . " ประจำเดือน" . getMonthTh($month) . " พ.ศ." . ($year + 543);
    } else {
        $title_report = "ตารางปฏิทินการทำงาน " . $ps_full_name . " ประจำเดือน" . getMonthTh($month) . " พ.ศ." . ($year + 543);
    }
    // echo "<h1>" . $title_report . "</h1>"; // หัวเรื่องปฏิทิน

    echo '<table>';
    echo '<thead>
            <tr>
            <th colspan="7" style="background-color: #e43169; padding: 6px; text-align: center;">'."<h1>" . $title_report . "</h1>".'</th>
            </tr>
            <tr>
                <th>อาทิตย์</th>
                <th>จันทร์</th>
                <th>อังคาร</th>
                <th>พุธ</th>
                <th>พฤหัสบดี</th>
                <th>ศุกร์</th>
                <th>เสาร์</th>
            </tr>
          </thead>';
    echo '<tbody>';
    echo '<tr>';

    // วนลูปเพื่อเติมช่องว่างในสัปดาห์แรก
    for ($i = 0; $i < $start_day_of_week; $i++) {
        echo '<td class="day-cell"></td>'; // ช่องว่างสำหรับวันแรกของเดือน
    }

    // วนลูปแสดงวันที่ในเดือน
    for ($day = 1; $day <= $days_in_month; $day++) {
        $current_date = sprintf('%s-%s-%02d', $year, $month, $day); // YYYY-MM-DD
        echo '<td class="day-cell">';
        echo "<strong class='day-number' style='font-weight: bold; -webkit-text-stroke: 4px #53357a; font-size: 20pt;'>$day</strong><br>"; // แสดงวันที่

        // ตรวจสอบว่ามีข้อมูลการทำงานในวันนี้หรือไม่
        if (isset($grouped_timework[$current_date])) {
            echo '<table class="inner-table">';
            $row_count = 0;
            foreach ($grouped_timework[$current_date] as $work) {

                echo '<tr>';
                if($work->twpp_is_holiday == 0){
                    echo '<td style="text-align: left;">';
                    echo format_time($work->twpp_start_time) . '-' . format_time($work->twpp_end_time);
                    if($work->twac_is_ot == 1){
                        echo " (OT)";
                    }
                    echo '</td>';
                }
                else{
                    $time_text = "OFF";
                    echo '<td style="text-align: center;">OFF</td>';
                }
                
                // echo '<td>' . $work->pf_name_abbr . $work->ps_fname . '</td>';
                // echo '<td>' . '</td>';
                
                echo '</tr>';
                $row_count++;
            }
            // ถ้าข้อมูลไม่ถึง 7 แถว ให้เติมช่องว่าง
            for ($i = $row_count; $i < 3; $i++) {
                echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
            }
            echo '</table>';
        } else {
            echo '<table class="inner-table">';
            for ($i = 0; $i < 3; $i++) {
                echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>'; // ช่องว่าง
            }
            echo '</table>';
        }

        echo '</td>';

        // ถ้าครบ 7 วัน ให้ขึ้นแถวใหม่
        if (($day + $start_day_of_week) % 7 == 0) {
            echo '</tr><tr>';
        }
    }

    // เติมช่องว่างที่เหลือในแถวสุดท้ายถ้ายังไม่ครบ 7 วัน
    while (($day + $start_day_of_week) % 7 != 1) {
        echo '<td class="day-cell"></td>';
        $day++;
    }
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
}

// หาวันที่เริ่มต้นและสิ้นสุดที่ผู้ใช้เลือก
$start_date = new DateTime($filter_start_date);
$end_date = new DateTime($filter_end_date);

// วนลูปแสดงปฏิทินสำหรับแต่ละเดือนที่อยู่ในช่วง
while ($start_date <= $end_date) {
    $year = $start_date->format('Y');
    $month = $start_date->format('m');
    render_calendar($year, $month, $grouped_timework, $logo_url, $actor_type, $ps_full_name);

    // เลื่อนไปยังเดือนถัดไป
    $start_date->modify('first day of next month');
}

?>
</body>
</html>

