<?php if (!empty($excelFiles)): ?>
  <?php foreach ($excelFiles as $file): ?>
    <h2>ไฟล์: <?= htmlspecialchars($file['fileName']) ?></h2>
    <table border="1" cellpadding="5" cellspacing="0">
      <thead>
        <?php foreach ($file['sheetData'] as $rowIndex => $row): ?>
          <?php if ($rowIndex == 0): ?>
            <tr>
              <?php foreach ($row as $cell): ?>
                <th><?= htmlspecialchars($cell) ?></th>
              <?php endforeach; ?>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </thead>
      <tbody>
        <?php foreach ($file['sheetData'] as $rowIndex => $row): ?>
          <?php if ($rowIndex > 0): ?>
            <tr>
              <?php foreach ($row as $cell): ?>
                <td><?= htmlspecialchars($cell) ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endforeach; ?>
<?php else: ?>
  <p>ไม่มีข้อมูลจากไฟล์ Excel</p>
<?php endif; ?>

<button onclick="window.history.back()">ย้อนกลับ</button>