<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางแพทย์ออกตรวจ</title>
    <style>
        body {
            margin: 20px;
        }

        .page {
            page-break-after: always;
            margin-top: 140px; /* ระยะเผื่อหลังโลโก้ */
        }

        h1, h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        td.name-left {
            text-align: left;
        }

        td {
            color: #225177;
            font-size: 14pt;
            font-weight: bold;
        }

        .weekend {
            background-color: #c0e4d8; /* Highlight วันเสาร์-อาทิตย์ */
        }

        .header-row {
            background-color: #6cccbe !important;
            color: #225177 !important;
            font-size: 16pt;
        }

        .sub-header-row {
            background-color: #00a48c !important;
            color: #fff !important; 
            font-size: 16pt;
        }

        .logo {
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            margin-top: 10px;
        }
        .date-col{
            font-size: 14pt;
        }

        @media print {
            .page {
                margin-top: 140px; /* ระยะห่างจากโลโก้ */
            }

            .logo {
                position: fixed;
                top: 10mm;
                left: 0;
                right: 0;
                text-align: center;
            }

            table {
                margin-top: 50mm; /* ดันตารางให้ลงมาหลังโลโก้ */
            }
        }
    </style>
</head>
<body>
<?php
$logo_url = base_url() . "assets/" . $this->config->item("site_logo");

// ฟังก์ชันแปลงชื่อเดือนภาษาไทย
function thai_month($month) {
    $thai_months = [
        1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน",
        5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม",
        9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม"
    ];
    return $thai_months[intval($month)];
}

// ฟังก์ชันแปลงวันภาษาไทย
function thai_day($date) {
    $days = ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'];
    $timestamp = strtotime($date);
    $day_index = date("w", $timestamp);
    return $days[$day_index];
}

// ฟังก์ชันแปลงวันที่ภาษาไทย
function thai_date($date) {
    $timestamp = strtotime($date);
    $day_name = thai_day($date);
    $day = date("j", $timestamp);
    $month = thai_month(date("n", $timestamp));
    $year = date("Y", $timestamp) + 543;
    return "{$day_name} {$day} {$month} " . substr($year, -2);
}

// ดึงข้อมูลวันทั้งหมดในเดือน
function get_days_in_month($month, $year) {
    $days = [];
    $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i = 1; $i <= $total_days; $i++) {
        $days[] = sprintf("%04d-%02d-%02d", $year, $month, $i);
    }
    return $days;
}

// ฟังก์ชันตัดเวลาให้เหลือเพียงชั่วโมงและนาที
function format_time($time) {
    return substr($time, 0, 5);
}

foreach ($rs_stuc as $department) {
    $department_name = $department['stde_name_th'];

    // แยกข้อมูลตามเดือน
    $monthly_data = [];
    foreach ($department['format_time'] as $time_slot) {
        foreach ($time_slot['twac_date'] as $date_entry) {
            $date = $date_entry['twpp_display_date'];
            $month_year = date("Y-m", strtotime($date));
            $time_range = format_time($time_slot['twac_start_time']) . " - " . format_time($time_slot['twac_end_time']);
            $doctor_name = "{$date_entry['pf_name_abbr']}{$date_entry['ps_fname']}";

            if (!isset($monthly_data[$month_year])) {
                $monthly_data[$month_year] = [];
            }
            if (!isset($monthly_data[$month_year][$date])) {
                $monthly_data[$month_year][$date] = [];
            }
            if (!isset($monthly_data[$month_year][$date][$time_range])) {
                $monthly_data[$month_year][$date][$time_range] = [];
            }

            // ห้ามเพิ่มชื่อซ้ำ
            if (!in_array($doctor_name, $monthly_data[$month_year][$date][$time_range])) {
                $monthly_data[$month_year][$date][$time_range][] = $doctor_name;
            }
        }
    }

    // แสดงข้อมูลตามแผนก
    foreach ($monthly_data as $month_year => $dates_data) {
        [$year, $month] = explode("-", $month_year);
        $days_in_month = get_days_in_month($month, $year);
        $month_name = thai_month($month);
        $year_thai = $year + 543;

        echo '<div class="page">';
        // echo '<div class="logo"><img src="' . $logo_url . '" alt="Logo" width="100"></div>'; // แสดงโลโก้ทุกหน้า

        echo "<table>";
        echo "<thead>
                <tr>
                    <th colspan='3' class='header-row'>{$department_name} - {$month_name} {$year_thai}</th>
                </tr>
                <tr>
                    <th class='sub-header-row'>วันที่</th>
                    <th class='sub-header-row'>เวลา</th>
                    <th class='sub-header-row'>รายชื่อแพทย์ออกตรวจ</th>
                </tr>
              </thead>";
        echo "<tbody>";

        foreach ($days_in_month as $day) {
            $formatted_day = thai_date($day);
            $is_weekend = date("w", strtotime($day)) == 0 || date("w", strtotime($day)) == 6;
            $row_class = $is_weekend ? "weekend" : "";

            if (isset($dates_data[$day])) {
                $shifts = $dates_data[$day];
                $rowspan = count($shifts);
                $first_row = true;

                foreach ($shifts as $time_range => $doctors) {
                    echo "<tr class='{$row_class}'>";
                    if ($first_row) {
                        echo "<td class='date-col' rowspan='{$rowspan}'>{$formatted_day}</td>";
                        $first_row = false;
                    }
                    $doctor_names = implode(" / ", $doctors);
                    echo "<td>{$time_range}</td>";
                    echo "<td class='name-left'>{$doctor_names}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr class='{$row_class}'>
                        <td class='date-col'>{$formatted_day}</td>
                        <td colspan='2'>-</td>
                      </tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
        echo '</div>'; // ปิดหน้ากระดาษ
    }
}
?>
</body>
</html>
