<style>
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-folder2-open icon-menu"></i><span>จัดการเครื่องมือหัตถการ <?php echo $structure_detail->stde_name_th; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%" class="text-center">#</th>
                                        <th width="60%">ชื่อโรค</th>
                                        <th width="20%" class="text-center">จำนวนเครื่องมือหัตถการ</th>
                                        <th width="10%" class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Default of stde -->
                                    <?php 
                                        $count = 0;
                                        foreach ($tools as $tool) {
                                            if(empty($tool['ddt_ds_id'])) {
                                                $count++;
                                            }
                                        } 
                                    ?>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>เครื่องมือหัตถการเริ่มต้นของ <?php echo $structure_detail->stde_name_th; ?></td>
                                        <td class="text-center"><?php echo $count; ?></td>
                                        <td class="text-center option">
                                            <button class="btn btn-warning" onclick="get_tools_by_disease('')"><i class="bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Each disease -->
                                    <?php 
                                        $i=1;
                                        foreach ($diseases as $row) {
                                            $count = 0;
                                            foreach ($tools as $tool) {
                                                if(!empty($tool['ddt_ds_id']) && (decrypt_id($row['ds_id']) == decrypt_id($tool['ddt_ds_id']))) {
                                                    $count++;
                                                }
                                            }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i+1; ?></td>
                                        <td><?php echo $row['ds_name_disease']; ?></td>
                                        <td class="text-center"><?php echo $count; ?></td>
                                        <td class="text-center option">
                                            <button class="btn btn-warning" onclick="get_tools_by_disease('<?php echo $row['ds_id']; ?>')"><i class="bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                    <?php 
                                        $i++; } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-tools" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>


<script>
    let index_tools = 0;
    let order_tools = 0;
    let ddt_stde_id = '<?php echo !empty($ddt_stde_id) ? $ddt_stde_id : ''; ?>'
    
    function get_tools_by_disease(ddt_ds_id) {
        $('#modal-tools .modal-content').empty();
        let url = '<?php echo base_url().'index.php/wts/Manage_tool/Manage_tool_get_tools/'; ?>';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'ddt_stde_id': ddt_stde_id,
                'ddt_ds_id': ddt_ds_id,
             },
            success: function(response) {
                index_tools = 0;
                order_tools = 0;
                $('#modal-tools .modal-content').html(response);
                $('#modal-tools').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal content:', error);
            }
        });
    }
</script>