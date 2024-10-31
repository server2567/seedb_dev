<div class="modal fade" id="pms_system_modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pms_hidden_st_id" value=""> <!-- Hidden input field to store st_id -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" title="คลิกเพื่อเข้าสู่ระบบ" data-toggle="tooltip" data-placement="top" onclick="redirect_to_gear('pms')"> <i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-bell icon-menu"></i><span>  รายการแจ้งเตือน</span><span class="badge bg-success">4</span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>			
                                                <th class="text-center" width="5%">#</th>
                                                <th width="30%">รายละเอียด</th>
                                                <th class="text-center" width="20%">วันเวลาที่ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>ระบบดำเนินการจ่ายเงินเดือนค่าจ้างให้กับแพทย์ปฏิบัติงานประจำ ประจำเดือน<b>เมษายน ปีพ.ศ. 2567</b></td>
                                                <td class="text-center">28 เมษายน พ.ศ.2567<br>03.21 น.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>ระบบดำเนินการจ่ายเงินเดือนค่าจ้างให้กับแพทย์ปฏิบัติงานประจำ ประจำเดือน<b>มีนาคม ปีพ.ศ. 2567</b></td>
                                                <td class="text-center">28 มีนาคม พ.ศ.2567<br>03.20 น.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>ระบบดำเนินการจ่ายเงินเดือนค่าจ้างให้กับแพทย์ปฏิบัติงานประจำ ประจำเดือน<b>กุมภาพันธ์ ปีพ.ศ. 2567</b></td>
                                                <td class="text-center">28 กุมภาพันธ์ พ.ศ.2567<br>03.26 น.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td>ระบบดำเนินการจ่ายเงินเดือนค่าจ้างให้กับแพทย์ปฏิบัติงานประจำ ประจำเดือน<b>มกราคม ปีพ.ศ. 2567</b></td>
                                                <td class="text-center">28 มกราคม พ.ศ.2567<br>03.20 น.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="คลิกเพื่อปิด" data-toggle="tooltip" data-placement="top">ปิด</button>
            </div>
        </div>
    </div>
</div>