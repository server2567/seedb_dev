<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-newspaper icon-menu"></i><span> รายชื่อผู้ป่วย</span><span class="badge bg-success">15</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center ">#</th>
                                <th class=" w-25 p-3">หมายเลขติดตาม</th>
                                <th class="text-center">ชื่อ-นามสกุล</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $data = array(
                                    array(
                                        'title' => 'IP-0001',
                                        'title_des' => 'หฤทัย ทองชัยภูมิ',
                                        'dep_id' => '1',
                                        'id' => 1
                                    ),
                                    array(
                                        'title' => 'OP-0001',
                                        'title_des' => 'ปิติภัทร แสนธารา',
                                        'dep_id' => '1',
                                        'id' => 2
                                    ),
                                    array(
                                        'title' => 'A-ER-0001',
                                        'title_des' => 'นัทธ์ รุ่งรัศมีทรัพย์',
                                        'dep_id' => '1',
                                        'id' => 3
                                    ),
                                    array(
                                        'title' => 'C-IP-0001',
                                        'title_des' => 'ธณิกา ก้องวัฒนะกุล',
                                        'dep_id' => '4',
                                        'id' => 4
                                    ),
                                    array(
                                        'title' => 'G-0001',
                                        'title_des' => 'ก้องวัฒนะกุล รัชนวีระ',
                                        'dep_id' => '4',
                                        'id' => 5
                                    ),
                                    array(
                                        'title' => 'OP-0001',
                                        'title_des' => 'รัชนวีระ พัชญ์ธนัน ',
                                        'dep_id' => '3',
                                        'id' => 6
                                    ),
                                    array(
                                        'title' => 'A-ER-0001',
                                        'title_des' => 'พัชญ์ธนัน แสนธารา',
                                        'dep_id' => '3',
                                        'id' => 7
                                    ),
                                    array(
                                        'title' => 'C-IP-0001',
                                        'title_des' => 'ก้อง พัชญ์ธนัน',
                                        'dep_id' => '2',
                                        'id' => 8
                                    ),
                                    array(
                                        'title' => 'G-0001',
                                        'title_des' => 'วัฒนะกุล รัชนวีระ',
                                        'dep_id' => '2',
                                        'id' => 9
                                    ),
                                );
                                
                                $target_dep_id = $id;
                                $index = 0;
                            ?>

                            

                            <?php foreach($data as $key => $item):  ?>
                                
                                <?php if ($item['dep_id'] == $target_dep_id || $target_dep_id==0):   $index++ ?>
                                    <tr>

                                        <td class="text-center"><?php echo $index; ?></td>
                                        <td><?php echo $item['title']; ?></td>
                                        <td class="text-center"><?php echo $item['title_des']; ?></td>
                                        <td class="text-center option">
                                            <button class="btn btn-info" onclick="window.location.href='<?php echo base_url()?>index.php/que/Patient/show_info/<?php echo $item['id'];?>'"><i class="bi-search"></i></button>
                                        </td>
                                        
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        
                    </table>
                    
                </div>
            </div>
            
        </div>
    </div>
    
</div>