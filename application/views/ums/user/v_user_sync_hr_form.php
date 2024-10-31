<style>
    .card-icon i {
        font-size: 3rem;
        opacity: 0.5;
    }
    #card-sync, #card-history {
        display: none;
    }
    .password-toggle {
        cursor: pointer;
    }
    /* #card-sync, #card-history {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    #card-sync.show, #card-history.show {
        display: block;
        opacity: 1;
    } */
</style>

<div class="row">
    <div class="d-flex justify-content-center">
        <div class="card card-button col-md-3 me-5" id="btn-sync" onClick="sync('all')">
            <div class="card-body">
                <h5 class="text-muted small">SYNC</span></h5>
                <div class="card-icon rounded-circle float-start">
                    <i class="bi bi-download text-warning"></i>
                </div>
                <div class="float-end">
                    <h1>Sync</h1>
                </div>
            </div>
        </div>
        <div class="card card-button col-md-3" id="btn-history">
            <div class="card-body">
                <h5 class="text-muted small">HISTORY</span></h5>
                <div class="card-icon rounded-circle float-start">
                    <i class="bi bi-clock-history text-success"></i>
                </div>
                <div class="float-end">
                    <h1>History</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span>  ค้นหารายชื่อผู้ใช้</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="javascript:void(0);" >
                    <!-- <form class="row g-3" method="post" onsubmit="return sync();" action="<?php echo base_url(); ?>index.php/ums/User_sync_hr/sync_hr_single"> -->
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ชื่อ</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="SearchFirstName" id="SearchFirstName" placeholder="ชื่อ">
                        </div>
                        <div class="col-md-2">
                            <label for="SearchLastName" class="form-label">นามสกุล</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="SearchLastName" id="SearchLastName" placeholder="นามสกุล">
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="button" class="btn btn-primary float-end" onClick="sync('single')">ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="card-sync">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>  รายชื่อผู้ใช้</span><span class="badge bg-success" id="badge-sync-count">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" onsubmit="return submit_it();" action="<?php echo base_url(); ?>index.php/ums/User_sync_hr/sync_hr_syncing">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>E-Mail</th>
                                    <th>ชื่อเข้าใช้ระบบ</th>
                                    <th>รหัสผ่าน</th>
                                    <th class="text-center">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody id="sync_table">
                            </tbody>
                        </table>
                        <div class="mt-3 mb-3 col-md-12">
                            <!-- <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/User'">ย้อนกลับ</button> -->
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="card-history">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>  รายงานการเชื่อมต่อข้อมูล</span><span class="badge bg-success">4</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อไฟล์</th>
                                <th>ผู้บันทึกข้อมูล</th>
                                <th class="text-center">เวลา sync ข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($syncs as $row) {
                                    $filename = $row['sync_file_name'].".pdf";
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
								<td><a href="<?php echo base_url().'index.php/ums/GetDoc?type=sync_pdf&doc='.$filename; ?> " target="_blank"><?php echo $filename; ?></a></td>
                                <td><?php echo $row['us_name']; ?></td>
                                <td class="text-center"><?php echo $row['sync_date']; ?></td>
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


<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('btn-history').onclick = function () {
            $("#card-history").fadeIn('slow');
            $("#card-sync").hide();
        }
    });

    var running_user = new Array();

    function delete_row(e){
        Swal.fire({
            title: text_swal_delete_title,
            text: text_swal_delete_text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545",
            confirmButtonText: text_swal_delete_confirm,
            cancelButtonText: text_swal_delete_cancel
            }).then((result) => {
            if (result.isConfirmed) {
                e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
                // notics_succuess();
                // alert("Delete Complete");
            }
        });
    }
    
    function sync(type='all') {
        let firstname = null;
        let lastname = null;
        if(type == 'single') {
            firstname = $("#SearchFirstName").val();
            lastname = $("#SearchLastName").val();
        }
        var jqxhr = $.post( "User_sync_hr/sync_hr", { 
            firstname: firstname, 
            lastname: lastname
        })
        .done(function(data) {
            $("#sync_table").empty();
            $("#sync_table").html(data);
            $("#card-sync").fadeIn('slow');
            $("#card-history").hide();
            // $(".da-button-row").show();
            running_user = new Array();
            check_all_user();
        })
        .fail(function() { consoe.error("ผิดพลาดดดด"); //notics_error();
        })
        .always(function() {//alert( "finished" );
        });
    }
    
    function check_all_user(){
        var sync_table = document.getElementById("sync_table");
        var row = sync_table.rows.length;
        document.getElementById("badge-sync-count").textContent = row;
        valid_all();
    }

    function temp_username(e){
	    var username = $(e).parent().prev(".input-username").val();
        running_user.push(username);
    }

    function valid_all() {
        let usernames = [];

        $('.check-username').each(function() {
            let e = $(this);
	        let username = $(e).parent().prev(".input-username").val();
            if (username.length > 4)
            {
                var url = "User_sync_hr/sync_hr_check_username/" + username;
                var jqxhr = $.get(url, function() {
                })
                .done(function(data) {
                    // usable
                    if (data==1){
                        if (usernames.includes(username)) {
                            $(e).next(".validate-username").addClass("text-danger");
                            $(e).next(".validate-username").html("username ซ้ำ");
                        } else {
                            usernames.push(username);
                            // running_user.push(username);
                            $(e).next(".validate-username").addClass("text-success");
                            $(e).next(".validate-username").html("OK!");
                        }
                    }
                    // can't use because duplicate in db
                    else{
                        $(e).next(".validate-username").addClass("text-danger");
                        $(e).next(".validate-username").html("มี username นี้แล้วในระบบ");
                    }
                })
                .fail(function() { //notics_error();
                })
                .always(function() {//alert( "finished" );
                });
            }
            else if(username.length == 0)
            {
                $(e).next(".validate-username").addClass("text-danger");
                $(e).next(".validate-username").html("กรุณาระบุข้อมูล");
            }
            else
            {
                $(e).next(".validate-username").addClass("text-danger");
                $(e).next(".validate-username").html("Too Short!!");
            }
        });
    }

    function valid(e) {
        let username = $(e).parent().prev(".input-username").val();
        if (username.length > 4)
        {
            var url = "User_sync_hr/sync_hr_check_username/" + username;
            var jqxhr = $.get(url, function() {
            })
            .done(function(data) {
                // usable
                if (data==1){
                    // let usernames = [];
                    let count_duplicate = 0;
                    $('.check-username').each(function() {
                        let username_check = $(this).parent().prev(".input-username").val();
                        // usernames.push(username);
                        if (username_check == username) {
                            count_duplicate++;
                            return;
                        }
                    });

                    if (count_duplicate > 1) {
                        $(e).next(".validate-username").removeClass("text-success");
                        $(e).next(".validate-username").addClass("text-danger");
                        $(e).next(".validate-username").html("username ซ้ำ");
                    } else {
                        // running_user.push(username);
                        $(e).next(".validate-username").removeClass("text-danger");
                        $(e).next(".validate-username").addClass("text-success");
                        $(e).next(".validate-username").html("OK!");
                    }
                }
                // can't use because duplicate in db
                else{
                    $(e).next(".validate-username").removeClass("text-success");
                    $(e).next(".validate-username").addClass("text-danger");
                    $(e).next(".validate-username").html("มี username นี้แล้วในระบบ");
                }
            })
            .fail(function() { //notics_error();
            })
            .always(function() {//alert( "finished" );
            });
        }
        else if(username.length == 0)
        {
            $(e).next(".validate-username").removeClass("text-success");
            $(e).next(".validate-username").addClass("text-danger");
            $(e).next(".validate-username").html("กรุณาระบุข้อมูล");
        }
        else
        {
            $(e).next(".validate-username").removeClass("text-success");
            $(e).next(".validate-username").addClass("text-danger");
            $(e).next(".validate-username").html("Too Short!!");
        }
    }
    
    // function submit_sync(){
    //     var check = 0;
    //     $(".check-username").each(function(e){
    //         check += 1;
    //     })
    //     if(check != 0){
    //         return false;
    //     }else{
    //         return true;
    //     }
    // }
</script>