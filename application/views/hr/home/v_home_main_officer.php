
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายชื่อบุคลากร</span><span class="summary_person badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="person_list" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ชื่อ - นามสกุล</th>
                                <th class="text-center">หน่วยงาน</th>
                                <th class="text-center">ตำแหน่งในการบริหารงาน</th>
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                <th class="text-center">สถานะการทำงาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     // Initial DataTable update
    //     updateDataTable();
    // });

    // // Function to update DataTable based on select dropdown values
    // function updateDataTable() {
    //     // Initialize DataTable
    //     var dataTable = $('#person_list').DataTable();

    //     var admin_id = $('#select_admin_id').val();
    //     var adline_id = $('#select_adline_id').val();
    //     var status_id = $('#select_status_id').val();
    //     var dp_id = $('#select_dp_id').val();

    //     // Make AJAX request to fetch updated data
    //     $.ajax({
    //         url: '<?php echo site_url()."/".$controller_dir; ?>get_profile_user_list',
    //         type: 'GET',
    //         data: { 
    //             admin_id: admin_id, 
    //             adline_id: adline_id,
    //             status_id: status_id,
    //             dp_id: dp_id
    //         },
    //         success: function(data) {
    //             // Clear existing DataTable data
    //             data = JSON.parse(data);
    //             dataTable.clear().draw();

    //             $(".summary_person").text(data.length);
    //             // Add new data to DataTable
    //             data.forEach(function(row, index) {
    //                 var status_text = "";
    //                 if(row.pos_status == 1){
    //                     status_text = '<div class="text-center"><i class="bi-circle-fill text-success"></i> ปฏิบัติงานอยู่</div>';
    //                 }
    //                 else{
    //                     status_text = '<div class="text-center"><i class="bi-circle-fill text-danger"></i> ออกจากหน้าที่</div>';
    //                 }
    //                 var button =    `  <div class="text-center option">
    //                                         <button class="btn btn-warning"  title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-placement="top" onclick="window.location.href='<?php echo site_url()."/".$controller_dir; ?>get_profile_user/${row.ps_id}'">
    //                                             <i class="bi-pencil-square"></i>
    //                                         </button>
    //                                     </div>
    //                                 `;
    //                 dataTable.row.add([
    //                     (index+1),
    //                     row.pf_name + row.ps_fname + " " + row.ps_lname,
    //                     row.dp_name_th,
    //                     row.admin_name,
    //                     row.alp_name,
    //                     status_text,
    //                     button  
    //                 ]).draw();
    //                 $('[data-toggle="tooltip"]').tooltip();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
    //         }
    //     });
    // }

</script>