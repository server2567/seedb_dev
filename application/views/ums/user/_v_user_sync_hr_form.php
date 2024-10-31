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
        <div class="card card-button col-md-3 me-5" id="btn-sync">
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
            <div class="card-body"> <!--  onClick="sync()" -->
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
				    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ชื่อ</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="SearchFirstName" id="SearchFirstName" placeholder="ชื่อ" value="<?php echo !empty($edit) ? $edit['SearchFirstName'] : "" ;?>">
                        </div>
                        <div class="col-md-2">
                            <label for="SearchLastName" class="form-label">นามสกุล</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="SearchLastName" id="SearchLastName" placeholder="นามสกุล" value="<?php echo !empty($edit) ? $edit['SearchLastName'] : "" ;?>">
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
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
                    <i class="bi-people icon-menu"></i><span>  รายชื่อผู้ใช้</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
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
                            <tr>
                                <td><input type="text" class="form-control" name="FirstName" id="FirstName" placeholder="" value="อารีรัตน์ ผ่องอุไร"></td>
                                <td><input type="email" class="form-control" name="Email" id="Email" placeholder="" value="areerat.p@gmail.com"></td>
                                <td>
                                    <input type="text" class="form-control" name="Username" id="Username" placeholder="" value="areerat.p">
                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary">validate user</button>
                                        <span class="text-success">OK!</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="Password" id="Password" placeholder="" value="<?php echo !empty($edit) ? $edit['Password'] : "ar" ;?>">
                                    <!-- <div class="input-group">
                                        <input type="password" class="form-control" name="Password" id="Password" placeholder="" value="areerat.p">
                                        <span class="input-group-text password-toggle" onclick="togglePassword(this)"><i class="bi-eye-slash"></i></span>
                                    </div> -->
                                    <div class="mt-2">
                                        <!-- <button class="btn btn-outline-secondary">validate user</button> -->
                                        <span class="text-success">OK!</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" data-url=""><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php for($i=0; $i<5; $i++){ ?>
                            <tr>
                                <td><input type="text" class="form-control" name="FirstName-<?php echo $i+1; ?>" id="FirstName-<?php echo $i+1; ?>" placeholder="" value="<?php echo !empty($edit) ? $edit['FirstName'] : "อารีรัตน์ ผ่องอุไร" ;?>"></td>
                                <td><input type="email" class="form-control" name="Email-<?php echo $i+1; ?>" id="Email-<?php echo $i+1; ?>" placeholder="" value="<?php echo !empty($edit) ? $edit['Email'] : "areerat.p@gmail.com" ;?>"></td>
                                <td>
                                    <input type="text" class="form-control" name="Username-<?php echo $i+1; ?>" id="Username-<?php echo $i+1; ?>" placeholder="" value="<?php echo !empty($edit) ? $edit['Username'] : "ar" ;?>">
                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary">validate</button>
                                        <span class="text-danger">Can't use!</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="Password-<?php echo $i+1; ?>" id="Password-<?php echo $i+1; ?>" placeholder="" value="<?php echo !empty($edit) ? $edit['Password'] : "ar" ;?>">
                                    <!-- <div class="input-group">
                                        <input type="password" class="form-control" name="Password-<?php echo $i+1; ?>" id="Password-<?php echo $i+1; ?>" placeholder="" value="<?php echo !empty($edit) ? $edit['Password'] : "ar" ;?>">
                                        <span class="input-group-text password-toggle" onclick="togglePassword(this)"><i class="bi-eye-slash"></i></span>
                                    </div> -->
                                    <div class="mt-2">
                                        <button class="btn btn-outline-secondary">validate</button>
                                        <span class="text-danger">Can't use!</span>
                                    </div>
                                </td>
                                <td class="text-center option">
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/SyncHRsingle/delete/<?php echo $i?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Filename</th>
                                <th>User</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<5; $i++){ ?>
                            <tr>
                                <td class="text-center"><?php echo $i;?></td>
                                <td>Filename.xlsx</td>
                                <td>admin</td>
                                <td class="text-center">2024-03-26 09:34:34</td>
                                <td class="text-center option">
                                    <button class="btn btn-danger" data-url="<?php echo base_url()?>index.php/ums/SyncHRsingle/delete/<?php echo $i?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('btn-sync').onclick = function () {
            var jqxhr = $.get( "User_sync_hr/sync_all", function() {
            })
            .done(function(data) {
                $("#sync_table").html(data);
                $("#sync_form").fadeIn('slow');
                $("#history_form").hide();
                $(".da-button-row").show();
                running_user = new Array();
                check_all_user();
            })
            .fail(function() { notics_error();
            })
            .always(function() {//alert( "finished" );
            });
            // document.getElementById('card-sync').classList.add('show');
            document.getElementById('card-sync').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('card-history').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
        }
        
        document.getElementById('btn-history').onclick = function () {
            // document.getElementById('card-history').classList.add('show');
            document.getElementById('card-history').setAttribute('style', 'display: block; opacity: 1;');
            document.getElementById('card-sync').setAttribute('style', 'display: none; opacity: 0; transition: opacity 0.5s ease-in-out;');
        }
    });

    function sync() {

    }
</script>