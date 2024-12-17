<?php
    // ฟังก์ชันแปลงเลขเดือนเป็นชื่อเดือนภาษาไทย
    function getThaiMonth($monthNumber) {
        $thaiMonths = [
            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
            '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
            '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
        ];
        return $thaiMonths[$monthNumber] ?? '-';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลลัพธ์การนำเข้าข้อมูลจาก Excel</title>
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        .hospital-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
            margin-top: 10px;
            color: #333;
        }

        .patient-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin: 0 auto 20px auto; /* Center and add bottom margin */
            border-radius: 5px;
            max-width: 100%; /* Prevent overflowing */
        }

        .header-title {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            margin-bottom: 10px;
            border-radius: 5px 5px 0 0;
        }

        .section-title {
            background-color: #ffc107;
            padding: 5px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Hospital Name -->
        <div class="hospital-header">
            โรงพยาบาลจักษุสุราษฎร์ Surat Eye Hospital
        </div>

        <!-- Header -->
        <div class="header-title">
            <h4>ผลลัพธ์การนำเข้าข้อมูลจาก Excel</h4>
        </div>

        <!-- Patient Info -->
        <?php 
            $gender = ($patient_info->ptd_sex ?? '-') === 'M' ? 'ชาย' : (($patient_info->ptd_sex ?? '-') === 'F' ? 'หญิง' : '-');
            $date = !empty($patient_info->exr_create_date) 
                ? date('d', strtotime($patient_info->exr_create_date)) . ' ' . 
                getThaiMonth(date('m', strtotime($patient_info->exr_create_date))) . ' ' . 
                (date('Y', strtotime($patient_info->exr_create_date)) + 543)
                : '-';
        ?>
        <div class="patient-info row mx-auto">
            <div class="col-6">
                <strong>ชื่อ-นามสกุล:</strong> <?= htmlspecialchars($patient_info->fullname ?? '-') ?><br>
                <strong>HN:</strong> <?= htmlspecialchars($patient_info->pt_member ?? '-') ?><br>
                <strong>Requested by:</strong> <?= htmlspecialchars($patient_info->doctor ?? '-') ?><br>
            </div>
            <div class="col-6">
                <strong>อายุ:</strong> <?= htmlspecialchars($patient_info->age ?? '-') ?> ปี<br>
                <strong>เพศ:</strong> <?= $gender ?><br>
                <strong>วันที่ตรวจ:</strong> <?= $date ?>
            </div>
        </div>

        <!-- Section Title -->
        <div class="section-title">
            Biochemistry (Clinical Chemistry)
        </div>

        <!-- Table -->
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Test</th>
                        <th>Result</th>
                        <th>Units</th>
                        <th>Reference Range</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?= htmlspecialchars($result->exrdtp_given_name ?? $result->exrdtp_test) ?></td>
                                <td>
                                    <input type="text" class="form-control text-center" 
                                           value="<?= htmlspecialchars($result->exrdtp_value) ?>">
                                </td>
                                <td><?= htmlspecialchars($result->exrdtp_unit) ?></td>
                                <td><?= htmlspecialchars($result->exrdtp_range) ?></td>
                                <td>
                                    <?php if ($result->exrdtp_level == 'L'): ?>
                                        <span class="badge bg-danger">Low</span>
                                    <?php elseif ($result->exrdtp_level == 'H'): ?>
                                        <span class="badge bg-warning text-dark">High</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลที่จะแสดง</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="card-footer text-center">
            <button class="btn btn-success">ยืนยันผลตรวจ</button>
            <!-- <a href="<?= base_url('index.php/dim/Import_examination_result') ?>" class="btn btn-primary">
                กลับไปหน้าหลัก
            </a> -->
        </div>
    </div>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
