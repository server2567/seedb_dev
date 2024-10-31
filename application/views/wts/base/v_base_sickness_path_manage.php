<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span> เลือกข้อมูลระยะเวลารักษาประเภทโรคผู้ป่วย</span><span class="badge bg-success" id="rowCount"><?php echo count($route_time); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" id="select_rt_form">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="dst_id" class="form-label">จุดบริการ</label>
                            <select class="form-select select2" name="dst_id" id="dst_id" data-placeholder="-- กรุณาเลือกจุดบริการ --">
                                <option value=""></option>
                                <?php if (isset($select_dst)) { ?>
                                    <?php foreach ($select_dst as $item) : ?>
                                        <?php if ($item['dst_ds_id']) { ?>
                                            <option value="<?php echo $item['dst_id'] ?>" data-name-point="<?php echo $item['dst_name_point'] ?>"><?php echo $item['dst_name_point'] . ' (' . $item['dst_patient_treatment_type']. ') ' . $item['dst_minute'] . ' ' . "นาที" ?>
                                            </option>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>   
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/wts/Base_sickness_path'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end" id="select_route_time">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sickness Duration Table Card -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi bi-info-circle-fill icon-menu"></i><span>เส้นทางการรักษาของ<?php echo !empty($route[0]['rdp_id']) ? $route[0]['rdp_name'] : '' ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form novalidate method="post" id="rt_form">
                        <table class="table datatable" width="100%" id="route_time_table">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">จุดบริการ</th>
                                    <!-- <th class="text-center">ประเภทการรักษา</th> -->
                                    <th class="text-center">นาที</th>
                                    <th class="text-center">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($route_time as $key => $item) { ?>
                                    <tr id="rt_seq">
                                        <td class="text-center">
                                            <div><?php echo $item['rt_seq']; ?></div>
                                            <input type="hidden" class="form-control" name="rt_seq" value="<?php echo $item['rt_seq']; ?>">
                                            <input type="hidden" class="form-control" name="dst_id" value="<?php echo $item['dst_id']; ?>">
                                            <input type="hidden" class="form-control" name="rt_rdp_id" value="<?php echo $rdp_id; ?>">
                                            <input type="hidden" class="form-control" name="rt_id" value="<?php echo $item['rt_id']; ?>">
                                        </td>
                                        <td>
                                            <div><?php echo $item['dst_name_point']; ?></div>
                                            <input type="hidden" class="form-control" name="dst_name_point" value="<?php echo $item['dst_name_point']; ?>">
                                        </td>
                                        <!-- <td class="text-center">
                                            <div><?php echo $item['dst_patient_treatment_type']; ?></div>
                                            <input type="hidden" class="form-control" name="dst_patient_treatment_type" value="<?php echo $item['dst_patient_treatment_type']; ?>">
                                        </td> -->

                                        <td class="text-center">
                                            <div><?php echo $item['dst_minute'] ?></div>
                                            <input type="hidden" class="form-control" name="dst_minute" value="<?php echo $item['dst_minute']; ?>">
                                        </td>
                                        <td class="text-center option">
                                            <div class="option">
                                                <?php 
                                                if(!empty($item['rt_id'])) { ?>
                                                <button type="button" class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/wts/Base_sickness_path/route_time_delete/<?php echo $item['rt_id']?>"><i class="bi-trash"></i></button>
                                                <?php }else{?>
                                                    <button type="button" class="btn btn-danger" onclick = "delete_new_row(this)"><i class="bi-trash"></i></button>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <?php if (($route[0]['rdp_id'] == $route_time[0]['rt_rdp_id']) && isset($route_time) && !empty($route_time[0]['rt_id'])) { ?>
                <button type="button" class="btn btn-success float-end" id="route_time_update">ยืนยันเส้นทาง</button>
            <?php } else { ?>
                <button type="button" class="btn btn-success float-end" id="route_time_add">ยืนยันเส้นทาง</button>
            <?php } ?>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<script>
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width());
        });
        return $helper;
    };

    var updateIndex = function() {
        $('#route_time_table tbody tr').each(function(i) {
            $(this).find('td:first div').text(i + 1);
        });
        updateRowCount();
    };

    var updateRowCount = function() {
        var rowCount = $('#route_time_table tbody tr').length;
    
        if ($('#route_time_table tbody td.dt-empty').length > 0) {
            rowCount = 0;
        } else if (rowCount > 0) {
        // If there are rows and none of them has the dt-empty class, we display the row count
            $('#rowCount').text(rowCount);
            return;
        }
    // If there are no rows or the only row has the dt-empty class, we set rowCount to 0
        $('#rowCount').text(0);
    };



    var serializeTableData = function() {
        var tableData = [];
        $('#route_time_table tbody tr').each(function() {
            var row = $(this);
            var rt_id = row.find('td:eq(0) input:eq(3)').val();
            var rt_seq = row.find('td:eq(0) input:eq(0)').val();
            var rt_rdp_id = row.find('td:eq(0) input:eq(2)').val();
            var dst_id = row.find('td:eq(0) input:eq(1)').val();

            if (rt_seq && dst_id && rt_rdp_id) { // Ensure all necessary fields are present
                var rowData = {
                    rt_id: rt_id,
                    rt_seq: rt_seq,
                    rt_rdp_id: rt_rdp_id,
                    dst_id: dst_id
                };
                tableData.push(rowData);
            }
        });
        return tableData;
    };

        function delete_new_row(el) {
            $(el).closest('tr').remove();
            updateIndex();
        }

    $(document).ready(function() {
        $("#route_time_table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        }).disableSelection();

        $('#select_rt_form').on('submit', function(event) {
            event.preventDefault();
            
            var selectedOption = $('#dst_id option:selected');
            var dst_name_point = selectedOption.data('name-point').replace(/\d+/g, ''); // Remove digits
            var dst_id = selectedOption.val();
            var dst_minute = selectedOption.text().match(/\d+/) ? selectedOption.text().match(/\d+/)[0] : '';
            var rt_seq = parseInt($('#rowCount').text()) + 1;
            var rt_rdp_id = <?php echo $rdp_id; ?>;
            if (dst_id) {
                var newRow = `
                    <tr>
                        <td class="text-center">
                            <div>${rt_seq}</div>
                            <input type="hidden" class="form-control" name="rt_seq" value="${rt_seq}">
                            <input type="hidden" class="form-control" name="dst_id" value="${dst_id}">
                            <input type="hidden" class="form-control" name="rt_rdp_id" value="${rt_rdp_id}">
                        </td>
                        <td>
                            <div>${dst_name_point}</div>
                            <input type="hidden" class="form-control" name="dst_name_point[]" value="${dst_name_point}">
                        </td>
                        <td class="text-center">
                            <div>${dst_minute}</div>
                            <input type="hidden" class="form-control" name="dst_minute[]" value="${dst_minute}">
                        </td>
                        <td class="text-center">
                            <div class="option">
                                <button type="button" class="btn btn-danger" onclick = "delete_new_row(this)"><i class="bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>`;
                
                // Remove the "no items" row if it exists
                $('#route_time_table tbody .dt-empty').closest('tr').remove();
                
                // Append the new row
                $('#route_time_table tbody').append(newRow);
                updateIndex();
            }
        });

        // Ensure row count is updated on page load
        updateRowCount();

        $('#route_time_add').on('click', function() {
            var tableData = serializeTableData();
            // if (tableData.length > 0) { // Check if tableData is not empty
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/wts/Base_sickness_path/route_time_insert',
                    type: 'POST',
                    data: JSON.stringify(tableData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'error') {
                            dialog_error({
                                'header': response.header,
                                'body': response.body
                            });
                        } else if (response.status === 'success') {
                            dialog_success({
                                'header': response.header,
                                'body': response.body
                            });
                            setInterval(function(){window.location.href = response.returnUrl;}, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("error")
                        console.log(xhr)
                        console.log(status)
                        console.log(error)
                    }
                });
            // }
        });

        $('#route_time_update').on('click', function() {
            var tableData = serializeTableData();
            if (tableData.length > 0) { // Check if tableData is not empty
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/wts/Base_sickness_path/route_time_update',
                    type: 'POST',
                    data: JSON.stringify(tableData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'error') {
                            dialog_error({
                                'header': response.header,
                                'body': response.body
                            });
                        } else if (response.status === 'success') {
                            dialog_success({
                                'header': response.header,
                                'body': response.body
                            });
                            setInterval(function(){window.location.href = response.returnUrl;}, 3000);
                        }
                    }
                });
            }
        });

        // function dialog_error(options) {
        //     alert(options.header + '\n' + options.body);
        // }

        // function dialog_success(options) {
        //     alert(options.header + '\n' + options.body);
        // }
    });
</script>
