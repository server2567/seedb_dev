<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลการเตรียมตัวก่อนวันพบแพทย์</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/add_form'"><i class="bi-plus"></i> เพิ่มข้อมูลการเตรียมตัวก่อนวันพบแพทย์ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ประเภทโรค</th>
                                <th class="text-center">ข้อมูลการเตรียมตัวก่อนวันพบแพทย์</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>หัวใจ </td>
                                <td class="text-center" width="50%">
                                ตรวจด้วยวิธีการ  CT calcium scoring
                                    -ไม่จำเป็นต้องงดอาหาร
                                    -หลีกเลี่ยงการดื่มเครื่องดื่มที่มีคาเฟอีน เช่น กาแฟ ชา ต่างๆ  
                                    -งดการสูบบุหรี่ และงดการออกกำลังกายก่อนเข้ารับบริการ
                                ตรวจด้วยวิธีการ Exercise Stress Test
                                    -สามารถรับประทานอาหารอ่อนๆ ย่อยง่าย เช่น ข้าวต้ม โจ๊ก แต่ควรงดรับประทานอาหารมื้อหนัก 
                                    -งดเครื่องดื่มแอลกอฮอล์ประมาณ 3-4 ชั่วโมง ก่อนการทดสอบ 
                                    -ควรสอบถามแพทย์ด้านหัวใจถึงยาที่รับประทานอยู่เป็นประจำ ว่าควรหยุดก่อนการทดสอบหรือไม่ เช่น ยารักษาโรคหัวใจ ยารักษาความดันโลหิต เป็นต้น
                                ตรวจด้วยวิธีการ Echocardiogram
                                    -สามารถรับประทานอาหารได้ตามปกติ ไม่ต้องงดอาหารหรือยาที่ทานเป็นประจำก่อนตรวจ
                                </td>
                                
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>มะเร็ง</td>
                                <td class="text-center">
                                ตรวจด้วยวิธีการ  CT calcium scoring
                                    -ไม่จำเป็นต้องงดอาหาร
                                    -หลีกเลี่ยงการดื่มเครื่องดื่มที่มีคาเฟอีน เช่น กาแฟ ชา ต่างๆ  
                                    -งดการสูบบุหรี่ และงดการออกกำลังกายก่อนเข้ารับบริการ
                                ตรวจด้วยวิธีการ Exercise Stress Test
                                    -สามารถรับประทานอาหารอ่อนๆ ย่อยง่าย เช่น ข้าวต้ม โจ๊ก แต่ควรงดรับประทานอาหารมื้อหนัก 
                                    -งดเครื่องดื่มแอลกอฮอล์ประมาณ 3-4 ชั่วโมง ก่อนการทดสอบ 
                                    -ควรสอบถามแพทย์ด้านหัวใจถึงยาที่รับประทานอยู่เป็นประจำ ว่าควรหยุดก่อนการทดสอบหรือไม่ เช่น ยารักษาโรคหัวใจ ยารักษาความดันโลหิต เป็นต้น
                                ตรวจด้วยวิธีการ Echocardiogram
                                    -สามารถรับประทานอาหารได้ตามปกติ ไม่ต้องงดอาหารหรือยาที่ทานเป็นประจำก่อนตรวจ
                                </td>
                                
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>กระดูกและข้อต่อ</td>
                                <td class="text-center">
                                ตรวจความหนาแน่นมวลกระดูก
                                    -ไม่จำเป็นต้องงดอาหาร
                                    -ควรแจ้งแพทย์ให้ทราบก่อนการตรวจหาก ตั้งครรภ์หรือสงสัยว่าตั้งครรภ์ , กรณีที่มีโลหะฝังอยู่ในร่างกาย เช่น ใส่ข้อสะโพกเทียม หรือใส่เครื่องกระตุ้นหัวใจ , ผู้ที่เพิ่งเข้ารับการตรวจที่ต้องรับประทานสารทึบรังสี หรือสารกัมมันตรังสี
                                </td>
                                
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>สมองและระบบประสาท</td>
                                <td class="text-center"></td>
                                
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>ศัลยกรรมและการผ่าตัด</td>
                                <td class="text-center">
                                    -แจ้งประวัติยาที่ใช้เป็นประจำ และประวัติการแพ้ยา
                                    -หากตั้งครรภ์หรือสงสัยว่าตั้งครรภ์ ต้องแจ้งให้แพทย์ทราบทุกครั้ง
                                    -
                                </td>
                                
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td>หู ตา คอ จมูก</td>
                                <td class="text-center"></td>
                               
                                <td class="text-center"><i class="bi-circle-fill text-success"></i> เปิดใช้งาน</td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>index.php/que/Base_prepare/update_form/1'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/que/Base_prepare/dalete/1"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>