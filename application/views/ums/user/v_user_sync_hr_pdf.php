<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <style>
        body {
            font-family: "Sarabun";
            font-size: 11pt;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000000;
            padding: 10px;
        }
        .text-center {
            text-align: center !important;
        }
    </style>
</head>
<body>
    <main id="main" class="main">
        <center><h2>รายชื่อผู้ใช้งานที่ทำการ sync ณ วันที่ <?php echo $date; ?></h2></center>
        <table class="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>ชื่อเข้าใช้ระบบ</th>
                    <th>รหัสผ่าน</th>
                    <th>E-Mail</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 0;
                    foreach ($user_insert as $row) { ?>
                <tr>
                    <td class="text-center"><?php echo $i + 1; ?></td>
                    <td><?php echo $row->us_name; ?></td> <!-- Access object properties with -> -->
                    <td><?php echo $row->us_username; ?></td>
                    <td><?php echo $row->us_password; ?></td>
                    <td><?php echo $row->us_email; ?></td>
                </tr>
                <?php 
                    $i++;
                    } 
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>