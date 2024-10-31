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
        <?php 
            $h = 0;
            foreach ($systems as $row) { ?>
            <h3><?php echo ($h + 1).". ".$row['st_name_th']; ?></h3>
            <?php if(empty($row['groups'])) { ?>
                <p class="text-center">ไม่มีรายการสิทธิ์</p>
            <?php } else { ?>
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="10%">#</th>
                            <th width="90%">ชื่อ-นามสกุล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($row['groups'] as $gp){ ?>
                            <tr>
                                <td colspan="2"><?php echo $gp['gp_name_th']; ?></td>
                            </tr>
                            <?php if(empty($gp['users'])) { ?>
                                <tr>
                                    <td colspan="2"> - ไม่มีรายการผู้ใช้ -</td>
                                </tr>
                            <?php } else { 
                                $i = 0;
                                foreach($gp['users'] as $us){ ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i + 1; ?></td>
                                        <td><?php echo $us['us_name']; ?></td>
                                    </tr>
                                <?php $i++; } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        <?php $h++; } ?>
    </main>
</body>
</html>