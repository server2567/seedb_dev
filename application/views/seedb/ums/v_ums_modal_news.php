<div class="modal fade" id="modalCountNews" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[UMS-C3] รายละเอียดการประกาศข่าวทั้งหมด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table  table-bordered table-hover dataTable datatable " width="100%" id="newsDetailTable">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">หัวข้อข่าว</th>
                                    <th class="text-center">จำนวนการเข้าชม</th>
                                    <th class="text-center">ประเภทข่าว</th> 
                                    <th class="text-center">ดูรายละเอียด</th>
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


<div class="modal fade" id="mainModal"  style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mainModalTitle"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mainModalBody">
        </div>
        <div class="modal-footer" id="mainModalFooter">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>


<script>
    function getDetailNews(e){
        toggleLoaderSearchBtn(e);

        let table = $('#newsDetailTable').DataTable();
        table.clear().draw();

        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;

        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)
        

        api.post("/getUmsNewsDetail",formData).then(response  => {
      
            const res = response.data;
            res.forEach((row, index) => {
                table.row.add([
                    `<center> ${index + 1} </center>`,
                    `${row.news_name}`,
                    `<center> ${row.news_count} </center>`,
                    `<center> ${row.news_type_name} </center>`,
                    `<center> <a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12" onclick="showNewsDetail(${row.news_id})"></a> </center>`,

                ])
                table.draw();
            })

        }).catch(err => {

        })

        var modal = document.getElementById('modalCountNews');
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        toggleLoaderSearchBtn(e);
    }

    function showNewsDetail(news_id){

        let formData = new FormData()
        formData.append('id', news_id)

        const url = "<?php echo site_url('/personal_dashboard/Home/getEditForm')?>";
        axios.post(url,formData).then(response  => {
            
            const res = response.data;
            document.getElementById("mainModalTitle").innerHTML = res.title
            document.getElementById("mainModalBody").innerHTML = res.body

            var modal = document.getElementById('mainModal');
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
            
        }).catch(err => {

        })

          
    }
</script>
