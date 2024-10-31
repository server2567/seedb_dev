<style>
    .profile-item .profile-badge {
        font-size: 2rem;
        line-height: normal;
    }

    .profile-item .profile-content {
        padding-left: 10px;
    }

    .profile-item {
        padding-bottom: 2rem;
    }

    .profile-item:last-child {
        padding-bottom: 0;
    }

    .profile-content .bi-circle-fill {
        font-size: 10px;
    }

    /* .profile-icon {
        padding-top: 10px; 
    } */

    .d-none {
        display: none;
    }

    .dt-search {
        display: none;
    }

    .dataTables_filter {
        display: none;
    }

    .list-group-borderless {
        --bs-list-group-border-width: 0px
    }

    /* .dt-start {
        display: none;
    } */

    #profile_picture1 {
        /* margin-top: -100px; */
        /* border-radius: 5 px; */
        /* width: 250px !important;  */
        /* max-width: 300px; */
        height: 200px !important;
        /* max-height: 200px; */
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    }

    #profile_picture2 {
        /* margin-top: -100px; */
        /* border-radius: 5 px; */
        /* width: 250px !important;  */
        max-width: 1000px;
        height: 500px !important;
        /* max-height: 200px; */
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    }


    .card1 {
        transition: transform 0.3s ease;
        padding: 15px !important;
        border-radius: 10px;
        border: 1px solid #e1e1e1;
    }

    .card1:hover {
        transform: scale(1.05);
        /* เพิ่มขนาดของการ์ดเมื่อ hover */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        /* เพิ่มเงาเมื่อ hover */
        cursor: pointer;
        /* เปลี่ยน cursor เป็น pointer เมื่อ hover */
        background-color: white;
    }

    input#searchInput {
        width: 50% !important;
        margin-left: auto !important;
        margin-right: auto !important;
        height: 50px !important;
        float: none !important;
    }
</style>
<h4 class="partial-name"><span>ข้อมูลข่าวสาร/ประชาสัมพันธ์</span></h4>
<div class="p-3">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="urgent-tab" data-bs-toggle="tab" data-bs-target="#urgent" type="button" onclick="settable(1)" role="tab">&nbsp;ข่าวด่วน &nbsp; </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" onclick="settable(2)" role="tab"> &nbsp;ข่าวทั่วไป &nbsp;</button>
        </li>
    </ul>
    <div class="tab-content p-3 pt-4">
        <div class="tab-pane fade show active" id="urgent" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-12 mb-2"><b>ข้อมูลข่าวสาร/ประชาสัมพันธ์: ข่าวด่วน</b></div>
                <div class="container">
                    <input style="width: 25%; float: right;" type="text" id="searchInput" class="form-control" placeholder="ค้นหาข่าว...">
                    <table id="table1" class="table datatable col-12" width="100%">
                        <thead>
                            <tr>
                                <th class="d-none">Card 1</th>
                                <th class="d-none">Card 2</th>
                                <th class="d-none">Card 3</th>
                            </tr>
                        </thead>
                        <tbody id="newsTableBody">
                            <?php
                            function truncateText($text, $limit = 5)
                            {
                                $words = explode(' ', $text);
                                if (count($words) > $limit) {
                                    return implode(' ', array_slice($words, 0, $limit)) . '...';
                                } else {
                                    return $text;
                                }
                            }
                            ?>
                            <?php if ($news_d && count($news_d) > 0) : ?>
                                <?php for ($i = 0; $i < count($news_d); $i += 3) : ?>
                                    <tr class="news-row">
                                        <?php for ($j = $i; $j < $i + 3 && $j < count($news_d); $j++) : ?>
                                            <td class="news-data" style="width: 33%; padding:20px;">
                                                <div class="card card1 p-1" style="width:100%; height: 30rem;">
                                                    <img style="height:8rem" class="card-img-top" id="profile_picture1" src="<?php echo site_url($this->config->item('ums_dir') . 'getIcon?type=' . $this->config->item('ums_news_dir') . 'img&image=' . ($news_d[$j]->news_img_name != '' ? $news_d[$j]->news_img_name : 'default.png')); ?>">
                                                    <br>
                                                    <div class="pt-2 pb-1" style="height:0.1rem; font-size:14px;">ประกาศเมื่อวันที่<?= abbreDate4($news_d[$j]->news_start_date) ?>
                                                        <div class="mb-3"><?= setrow($news_d[$j]->news_bg_id) ?></div>
                                                    </div>
                                                    <div style="height:10rem" class="card-body">
                                                        <h5 class="card-title pt-5"><?= $j + 1 . '. ' ?><?= $news_d[$j]->news_name ?></h5>
                                                        <p class="card-text mb-3"><?= truncateText($news_d[$j]->news_text) ?>
                                                        </p>
                                                    </div>
                                                    <div class="text-right p-3">
                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="modal" data-bs-target="#Newsdetailmodal" onclick="editForm(<?= $news_d[$j]->news_id ?>)">
                                                            อ่านเพิ่มเติม
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php endfor; ?>
                                        <?php for ($k = $j; $k < $i + 3; $k++) : ?>
                                            <td></td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="general" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-12 mb-2"><b>ข้อมูลข่าวสาร/ประชาสัมพันธ์: ข่าวทั่วไป</b></div>

                <div class="container">
                    <input style="width: 25%; float: right;" type="text" id="searchInput" class="form-control" placeholder="ค้นหาข่าว...">
                    <table id="table2" class="table datatable col-12" width="100%">
                        <thead>
                            <tr>
                                <th class="d-none">Card 1</th>
                                <th class="d-none">Card 2</th>
                                <th class="d-none">Card 3</th>
                            </tr>
                        </thead>
                        <tbody id="newsTableBody">
                            <?php
                            function truncateText1($text, $limit = 5)
                            {
                                $words = explode(' ', $text);
                                if (count($words) > $limit) {
                                    return implode(' ', array_slice($words, 0, $limit)) . '...';
                                } else {
                                    return $text;
                                }
                            }
                            function setrow($text)
                            {
                                $words = explode(',', $text);
                                $row = "";
                                foreach ($words as $key => $value) {
                                    if ($value == 1) {
                                        $row .= "<i class='text-primary p-1'>#หมอ</i>";
                                    }
                                    if ($value == 2) {
                                        $row .= "<i class='text-success p-1'>#พยาบาล</i>";
                                    }
                                    if ($value == 3) {
                                        $row .= "<i class='text-info p-1'>#เจ้าหน้าที่</i>";
                                    }
                                    if ($value == 4) {
                                        $row .= "<i class='text-warning p-1'>#ผู้ป่วย</i>";
                                    }
                                }
                                return $row;
                            }
                            ?>
                            <?php if ($news_n && count($news_n) > 0) : ?>
                                <?php for ($i = 0; $i < count($news_n); $i += 3) : ?>
                                    <tr class="news-row">
                                        <?php for ($j = $i; $j < $i + 3 && $j < count($news_n); $j++) : ?>
                                            <td class="news-data" style="width: 33%; padding:20px;">
                                                <div class="card card1 p-2" style="width:100%; height: 30rem;">
                                                    <img style="height:8rem" class="card-img-top" id="profile_picture1" src="<?php echo site_url($this->config->item('ums_dir') . 'getIcon?type=' . $this->config->item('ums_news_dir') . 'img&image=' . ($news_n[$j]->news_img_name != '' ? $news_n[$j]->news_img_name : 'default.png')); ?>">
                                                    <div class="pt-2 pb-1 style=" height:0.1rem; font-size:14px;">ประกาศเมื่อวันที่<?= abbreDate4($news_n[$j]->news_start_date) ?>
                                                        <div class="mb-2"><?= setrow($news_n[$j]->news_bg_id) ?></div>
                                                    </div>
                                                    <div style="height:10rem" class="card-body">
                                                        <div class="row">
                                                            <h5 class="card-title"><?= $j + 1 . '. ' ?><?= $news_n[$j]->news_name ?></h5>
                                                            <p class="card-text"><?= truncateText1($news_n[$j]->news_text) ?>
                                                            </p>
                                                        </div>
                                                        <div class="text-right p-3">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="modal" data-bs-target="#Newsdetailmodal" onclick="editForm(<?= $news_n[$j]->news_id ?>)">
                                                                อ่านเพิ่มเติม
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                </div>
                </td>
            <?php endfor; ?>
            <?php for ($k = $j; $k < $i + 3; $k++) : ?>
                <td></td>
            <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    <?php endif; ?>
    </tbody>
    </table>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="Newsdetailmodal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modaltitle" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="ModalBody" class="modal-body">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-clock-history icon-menu"></i><span> รายการประวัติการมาทำงาน</span><span class="badge bg-success">17</span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%" scope="col" class="text-center">#</th>
                                                <th width="45%" scope="col">วันที่เข้างาน</th>
                                                <th width="45%" scope="col">เวลาเข้างาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < 17; $i++) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i + 1; ?></td>
                                                    <td><?php echo $i + 1; ?> พฤษภาคม พ.ศ. 2567</td>
                                                    <td>09.00 - 18.00</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ModalFooter" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable({
                "searching": false,
                "columnDefs": [{
                        "visible": false,
                        "targets": [0]
                    } // ซ่อนคอลัมน์ที่ 0 (คอลัมน์แรก)
                ],
                "paging": true,
                "searching": false,
                "ordering": false
            });
        }
        // $(document).ready(function() {
        //     $('#example1 tfoot th').each(function() {
        //         var title = $(this).text();
        //         $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        //     });
        //     var table = $('#example1').DataTable({
        //         "autoWidth": false,
        //         "paging": false,
        //         "bInfo": false,
        //         initComplete: function() {
        //             this.api().columns().every(function(d, j) {
        //                 var that = this;
        //                 $('input', this.footer()).on('keyup change', function() {
        //                     if (that.search() !== this.value) {
        //                         that.search(this.value).draw();
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });
    });

    function editForm(id) {
        $.ajax({
            method: "post",
            url: 'Home/getEditForm',
            data: {
                id: id,
            }
        }).done(function(returnData) {
            $('#modaltitle').html(returnData.title);
            $('#ModalBody').html(returnData.body);
            // $('#ModalFooter').html(returnData.footer);
            $('#mainModal').modal();
            $('#print').prop('disabled', false);
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#newsTableBody .news-data').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $('#newsTableBody .news-row').each(function() {
                var anyVisibleTd = $(this).find('.news-data:visible').length > 0;
                $(this).toggle(anyVisibleTd);
            });
            if (value === '') {
                $('#newsTableBody .news-row').show();
                $('#newsTableBody .news-data').show();
            }
        });
        $('#table1 tbody tr').each(function() {
            var row = $(this); // Get the DOM node for the row
            var tdCount = row.children('td').length; // Count the number of td elements in the row
            row.find('.dt-info').html('<div>กำลังแสดง ' + <?php echo ($news_d && count($news_d) > 0 ? count($news_d) : 0) ?> + ' ข่าวสาร จากทั้งหมด ' + <?php echo ($news_d && count($news_d) > 0 ? count($news_d) : 0) ?> + ' ข่าวสาร </div>');
        });

    });

    function settable(News = 0) {
        if (News == 1) {
            $('#table1 tbody tr').each(function() {
                var row = $(this); // Get the DOM node for the row
                var tdCount = row.children('td').length; // Count the number of td elements in 
                $('.dt-info').html('<div>กำลังแสดง ' + <?php echo ($news_d && count($news_d) > 0 ? count($news_d) : 0) ?> + ' ข่าวสาร จากทั้งหมด ' + <?php echo ($news_d && count($news_d) > 0 ? count($news_d) : 0) ?> + ' ข่าวสาร </div>');
            });
        }
        if (News == 2) {
            $('#table2 tbody tr').each(function() {
                var row = $(this); // Get the DOM node for the row
                var tdCount = row.children('td').length; // Count the number of td elements in 
                $('.dt-info').html('<div>กำลังแสดง ' + <?php echo ($news_n && count($news_n) > 0 ? count($news_n) : 0) ?> + ' ข่าวสาร จากทั้งหมด ' + <?php echo ($news_n && count($news_n) > 0 ? count($news_n) : 0) ?> + ' ข่าวสาร </div>');
            });
        }
    }
</script>