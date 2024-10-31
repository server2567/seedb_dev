<div class="modal fade" id="modalCountSystem" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[UMS-C4] รายละเอียดระบบทั้งหมด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table  table-bordered table-hover dataTable datatable " width="100%" id="systemDetailTable">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อระบบ</th>
                                    <th class="text-center">system Name</th>
                                    <th class="text-center">ตัวย่อ</th> 
                                    <th class="text-center">Icon</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          </div>
        </div>
    </div>
</div>

<script>
    function getDetailSystem(e){
        toggleLoaderSearchBtn(e);

        let table = $('#systemDetailTable').DataTable();
        table.clear().draw();


        api.post('/getUmsSystemDetail').then(response  => {
            const res = response.data;
            
            res.forEach((row, index) => {
                table.row.add([
                    `<center> ${index + 1} </center>`,
                    `${row.st_name_th}`,
                    `${row.st_name_en}`,
                    `<center> ${row.st_name_abbr_en} </center>`,
                    `<center> <img src="<?php echo site_url('/ums/GetFile?type=system&image')?>=${row.st_icon} " style="width:45px; height:45px; object-fit: contain;"></center>`
                ])
                table.draw();
            })


            var modal = document.getElementById('modalCountSystem');
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
            toggleLoaderSearchBtn(e);
                
        }).catch(err => {

        })


    }
</script>