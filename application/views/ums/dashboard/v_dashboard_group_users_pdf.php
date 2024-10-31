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
        <h2 class="text-center"><?php echo $header; ?></h2>
        <table class="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>ชื่อระบบ</th>
                    <th>ชื่อสิทธิ์</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 0;
                    foreach ($users as $row) { ?>
                    <?php if(empty($row['groups'])) { ?>
                        <tr>
                            <td class="text-center"><?php echo $i + 1; ?></td>
                            <td><?php echo $row['us_name']; ?></td>
                            <td class="text-center" colspan="2">ไม่มีรายการสิทธิ์</td>
                        </tr>
                    <?php $i++; } else { 
                        $st_ids = [];
                        foreach($row['groups'] as $st) { 
                            $is_passed = true;
                            if (!in_array($st['st_id'], $st_ids)) {
                                $st_ids[] = $st['st_id'];
                                $is_passed = false;
                            } 
                            if (!$is_passed) { 
                                foreach($row['groups'] as $gp){ 
                                    if($gp['gp_st_id'] == $st['st_id']) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td><?php echo $row['us_name']; ?></td>
                                            <td><?php echo $st['st_name_th']; ?></td>
                                            <td><?php echo $gp['gp_name_th']; ?></td>
                                        </tr>
                                    <?php $i++; } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>