<?php $this->load->view($view_dir . 'v_seedb_ums_style'); ?>
<div class="container" style="margin-top: -30px;">
    <div class="d-flex align-items-center justify-content-center my-3 mb-5 search-bar">
        <button class="btn btn-outline-primary me-5 btn-filters" id="toggleSearchBtn">ตัวเลือกอื่นๆ</button>
        <div class="selected-filters" id="selectedFilters"></div>
        <div class="autocomplete mx-auto" style="width:70%;">
            <svg viewbox="0 0 1000 50" class='pb-3'>
                <clipPath id="text" class="filled-heading ">
                    <text y="40" class="fw-bold">ระบบจัดการสิทธิ์ผู้ใช้งาน</text>
                </clipPath>
                <g id="background" clip-path="url(#text)">
                    <path d="m445.62-26.657c-19.58 20.137-3.6309 59.698 27.377 73.932 31.007 14.234 67.049-14.123 72.974-27.02 5.9253-12.875-13.142-59.988-24.058-65.022-10.937-5.012-42.19-16.996-76.294 18.11z" stroke-width=".22275" />
                    <path d="m299.4 7.4916c15.704-7.5959-10.269-35.128-31.297-38.002-20.983-2.8513-44.395 14.835-51.969 26.597-10.848 16.863 2.3389 30.785 9.7344 31.787 7.3954 1.0024 53.238-10.581 73.531-20.382z" stroke-width=".22275" />
                    <path d="m-23.125 15.756c-25.35 12.096-24.124 54.709 0 78.833 24.124 24.124 67.806 10.024 77.83 0 10.024-10.024 8.4869-60.834 0-69.321-8.487-8.487-33.658-30.584-77.83-9.5116z" stroke-width=".22275" />
                    <path d="m368.92 42.13c-17.442 0.33414-5.3461 36.22 12.563 47.58 17.909 11.36 46.556 5.0788 58.339-2.4503 16.907-10.804 10.737-28.958 4.4328-32.968-6.3039-3.9873-52.793-12.586-75.336-12.162z" stroke-width=".22275" />
                    <path d="m134.41-33.696c-25.35 12.096-24.124 54.709 0 78.833 24.124 24.124 67.806 10.024 77.83 0 10.024-10.024 8.4869-60.834 0-69.321-8.5092-8.4869-33.658-30.584-77.83-9.5116z" stroke-width=".22275" />
                    <path d="m132.74 79.753c3.4973 27.844 50.031 16.194 74.155-7.9301 24.124-24.124 17.553-32.789 7.5291-42.836-10.024-10.046-24.303 0.13365-47.246 13.588-21.407 12.608-38.18 7.3955-34.438 37.178z" stroke-width=".22275" />
                    <path d="m137.44 89.51c23.389-15.504-20.939-25.951-55.065-25.951-34.126 0-70.68 5.4352-80.192 25.817-13.655 29.27 10.425 48.605 22.431 48.605s82.575-28.423 112.83-48.471z" stroke-width=".22275" />
                    <path d="m102.51 97.173c15.504 23.389 53.795-24.013 53.795-58.139 0-34.126-33.28-67.606-53.684-77.14-29.27-13.655-48.605 10.425-48.605 22.431 0 12.006 28.446 82.597 48.494 112.85z" stroke-width=".22275" />
                    <path d="m38.601 4.2171c-16.484-5.7471-17.575 32.099-4.7447 48.984 12.831 16.885 41.9 20.917 55.555 17.954 19.602-4.2546 20.115-23.434 15.593-29.381-4.5219-5.9253-45.108-30.139-66.403-37.556z" stroke-width=".22275" />
                    <path d="m430.43 67.056c9.3779-26.463-21.63-55.755-55.756-55.755s-55.02 40.853-55.02 55.02c0 14.167 37 49.028 49.028 49.028 12.006 0.0223 45.397-2.1384 61.748-48.293z" stroke-width=".22275" />
                    <path d="m251.62 77.147c9.378-26.463-21.63-55.755-55.756-55.755s-55.02 40.853-55.02 55.02c0 14.167 37 49.051 49.006 49.051 12.029 0 45.42-2.1607 61.77-48.315z" stroke-width=".22275" />
                    <path d="m310.9 54.493c17.219-22.164-23.924-46.823-58.028-46.823-34.104 0-35.618 10.781-35.618 24.949 0 14.167 17.263 17.108 43.014 23.79 24.035 6.2594 32.21 21.785 50.632-1.9157z" stroke-width=".22275" />
                    <path d="m264.74 128.47c-5.5689 27.51 33.146 3.5418 57.27-20.583 24.124-24.124 46.132-53.84 38.447-74.979-11.026-30.361-41.722-26.998-50.209-18.511-8.4869 8.487-38.314 78.499-45.509 114.07z" stroke-width=".22275" />
                    <path d="m220.03 132.08c-5.5689 27.51 33.146 3.5418 57.27-20.583 24.124-24.124 46.132-53.818 38.448-74.979-11.026-30.361-41.722-26.998-50.209-18.511-8.5093 8.487-38.292 78.499-45.509 114.07z" stroke-width=".22275" />
                    <path d="m281.49-61.362c-27.51-5.5689-21.073 55.02 3.074 79.145 24.147 24.124 71.348 24.28 92.488 16.573 30.339-11.026 26.998-41.722 18.511-50.231-8.487-8.5092-78.499-38.292-114.07-45.486z" stroke-width=".22275" />
                    <path d="m315.04 74.385c-19.58 20.137-3.6309 59.698 27.376 73.932 31.007 14.234 67.071-14.123 72.974-27.02 5.9253-12.875-13.142-59.988-24.058-65.022-10.915-5.0342-42.167-16.974-76.293 18.11z" stroke-width=".22275" />
                    <path d="m483.42 80.31c12.942 24.904 52.548-2.1607 66.782-33.168 14.256-31.007 5.0788-36.844-7.8187-42.769-12.875-5.9253-22.743 8.5538-39.584 29.136-15.682 19.224-33.213 20.159-19.38 46.801z" stroke-width=".22275" />
                    <path d="m625.47 49.548c16.551-22.676-28.646-17.063-60.634-5.2347-32.01 11.851-64.398 29.626-66.247 52.058-2.6508 32.188 26.641 41.967 37.913 37.801 11.249-4.1655 67.562-55.332 88.968-84.625z" stroke-width=".22275" />
                    <path d="m461.12 107.13c22.676 16.551 42.123-41.187 30.272-73.197-11.85-32.01-54.686-51.835-77.118-53.684-32.166-2.6508-41.945 26.619-37.779 37.891 4.1655 11.271 55.31 67.584 84.624 88.99z" stroke-width=".22275" />
                    <path d="m547.3 32.024c-9.378 26.463 21.629 55.755 55.755 55.755 34.126 0 55.02-40.853 55.02-55.02 0-14.167-37-49.028-49.028-49.028-12.006 0-45.397 2.1607-61.748 48.293z" stroke-width=".22275" />
                    <path d="m626.36 113.44c22.164 17.219 46.823-23.924 46.823-58.028s-10.781-35.596-24.971-35.596-17.108 17.263-23.79 43.014c-6.2371 24.013-21.785 32.166 1.938 50.61z" stroke-width=".22275" />
                    <path d="m727.75 39.036c16.761-4.837-4.2105-36.369-24.45-42.708-20.224-6.3654-46.284 7.1438-55.717 17.466-13.535 14.811-2.876 30.75 4.2509 32.992 7.1212 2.2198 54.23-1.5013 75.916-7.7503z" stroke-width=".22275" />
                    <path d="m731.16 87.29c20.706-18.947-15.688-50.198-49.322-55.922-33.635-5.7237-36.903 4.6301-39.288 18.622-2.3853 13.992 14.149 19.754 38.388 30.694 22.633 10.194 28.053 26.891 50.222 6.6064z" stroke-width=".22275" />
                    <path d="m628.53 148.48c-10.118 26.187 32.086 9.0674 59.923-10.637 27.836-19.704 54.536-45.284 50.516-67.43-5.7704-31.777-36.595-33.642-46.405-26.701-9.7877 6.9351-50.944 70.912-64.034 104.77z" stroke-width=".22275" />
                    <path d="m569.35 72.75c27.801 3.8286 28.591-44.135 11.533-73.681-17.058-29.546-27.129-25.442-39.427-18.359-12.298 7.0822-6.1608 23.509 0.89676 49.153 6.6322 23.962-2.7382 38.793 26.998 42.887z" stroke-width=".22275" />
                </g>
            </svg>
            <input type="text" class="form-control w-100 mb-0" id="searchInput" placeholder="ค้นหาชื่อรายงานระบบจัดการสิทธิ์ผู้ใช้งาน">
        </div>
    </div>
    <div id="searchSection">
        <div class="row">
            <div class="col-md-3">
                <div class="form-floating mb-4">
                    <select class="form-select mb-4" id="select_department" name="select_department" onchange="filterUms(this)">
                        <option value="">กรุณาเลือกปี</option>
                        <?php
                        foreach ($ums_department_list as $key => $row) {
                            if ($key == 0) {
                                echo '<option value="' . $row->dp_id . '" selected>' . $row->dp_name_th . '</option>';
                            } else {
                                echo '<option value="' . $row->dp_id . '">' . $row->dp_name_th . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="ums_department">หน่วยงาน</label>
                </div>
            </div>
            <div class="col-md-3">
        <div class="form-floating mb-3">
          <input type="text" class="form-control mb-3" id="select_date_start" name="select_date_start" onchange="filterWts()">
          <label for="select_date_start">วัน/เดือน/ปี : เริ่ม</label>
          <button type="button" class="btn btn-outline-secondary btn-clear-date" onclick="clearDate('select_date_start')">&times;</button>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-floating mb-3">
          <input type="text" class="form-control mb-3" id="select_date_end" name="select_date_end" onchange="filterWts()">
          <label for="select_date_end">วัน/เดือน/ปี : ถึง</label>
          <button type="button" class="btn btn-outline-secondary btn-clear-date" onclick="clearDate('select_date_end')">&times;</button>
        </div>
      </div>
            <div class="col-md-3" id="filter_select_year">
                <div class="form-floating mb-3">
                    <select class="form-select mb-3" id="select_year" name="select_year" onchange="filterUms(this)">
                        <option value="">กรุณาเลือกปี</option>
                        <?php
                        $i = 0;
                        foreach ($default_year_list as $year) {
                            if ($year == getNowYearTh())
                                echo '<option value="' . ($year - 543) . '" selected>' . $year . '</option>';
                            else
                                echo '<option value="' . ($year - 543) . '">' . $year . '</option>';
                            $i++;
                        }
                        ?>
                    </select>
                    <label for="select_year">ปีพ.ศ.</label>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section dashboard" id="cardContainer">
    <div class="row">
        <div class="col-3">
            <div class="card info-card sales-card" style="border-bottom: 3px solid #0069bd; background: #FFF;">
                <div class="card-body pb-2">
                    <h5 class="card-title pt-1 pb-3 font-16">[UMS-C1] ประชาชนที่ลงทะเบียนทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0069bd; background: #d7edff;">
                             <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                            <h6 id="countPatient"><i class="font-16">loading..</i></h6>
                        </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 " data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด" onclick="get_detail_patient(this)"><div class="loader"></div></a> 
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card info-card sales-card" style="border-bottom: 3px solid #9b2500; background: #FFF;">
                <div class="card-body pb-2">
                    <h5 class="card-title pt-1 pb-3 font-16">[UMS-C2] ผู้ใช้งานทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9b2500; background: #fbd4c7;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                            <h6 id="countUser"><i class="font-16">loading..</i></h6>
                        </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 " data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"  onclick="getDetailUsers(this)"><div class="loader"></div></a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card info-card sales-card" style="border-bottom: 3px solid #009688; background: #FFF;">
                <div class="card-body pb-2">
                    <h5 class="card-title pt-1 pb-3 font-16">[UMS-C3] ประกาศข่าวทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #009688; background: #bffff9;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                            <h6 id="countNews"><i class="font-16">loading..</i></h6>
                        </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 " data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด" onclick="getDetailNews(this)"><div class="loader"></div></a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card info-card sales-card" style="border-bottom: 3px solid #9c27b0; background: #FFF;">
                <div class="card-body pb-2">
                    <h5 class="card-title pt-1 pb-3 font-16">[UMS-C4] ระบบทั้งหมด</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9c27b0; background: #f6c3ff;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-4">
                            <h6 id="countSystem"><i class="font-16">loading..</i></h6>
                        </div>
                    </div>
                </div>
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 " data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด" onclick="getDetailSystem(this)"><div class="loader"></div></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" data-bs-original-title="คลิกเพื่อดูรายละเอียด" onclick="getDetailPatientConsent(this)"> ดูรายละเอียด <div class="loader"></div> </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title pt-1 pb-0 font-16 w-80">[UMS-1] จำนวนประชาชนที่ลงทะเบียนเข้าใช้งานระบบ และผู้ที่ยินยอมนโยบายคุ้มครองข้อมูลส่วนบุคคล</h5>
                    <hr>
                    <div id="container_g1"></div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" data-bs-original-title="คลิกเพื่อดูรายละเอียด"  onclick="getDetailStaffOfSystem(this)"> ดูรายละเอียด <div class="loader"></div> </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title pt-1 pb-0 font-16 w-80">[UMS-2] จำนวนผู้ใช้งานที่เป็นเจ้าหน้าที่ ที่ถูกกำหนดสิทธิ์เข้าใช้งานของระบบ</h5>
                    <hr>
                    <div id="container_g2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="filter filterDetail">
                    <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" data-bs-original-title="คลิกเพื่อดูรายละเอียด" onclick="getDetailUsersActivitySystem(this)"> ดูรายละเอียด <div class="loader"></div></a>
                </div>
                <div class="card-body">
                    <h5 class="card-title pt-1 pb-0 font-16 w-80">[UMS-3] จำนวนการเข้าใช้งานระบบ จำแนกตามระบบ แสดง 14 วันล่าสุด</h5>
                    <hr>
                    <div id="container_g3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>

<?php $this->load->view('/seedb/ums/v_ums_modal_patient'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_user'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_news'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_system'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_patient_consent'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_staff_of_system'); ?>
<?php $this->load->view('/seedb/ums/v_ums_modal_history_user_activity_system'); ?>
<script>

    const loadingText = '<i class="font-16">loading...</i>';
    const api = axios.create({
        baseURL: "<?php echo site_url('/seedb/ums/ums_dashboard/'); ?>"
    });

    // Initial call to display default selected filters
    updateSelectedFilters();

    $(document).ready(function() {
        getAllData()
    });

    function getAllData(){
        getCountData()
        getChart()
    }

    function getCountData(){
            const department  = document.getElementById('select_department').value;
            const startDate   = document.getElementById('select_date_start').value;
            const endDate     = document.getElementById('select_date_end').value;
            const year        = document.getElementById('select_year').value;

            let formData = new FormData()
			formData.append('department', department)
			formData.append('startDate', startDate)
			formData.append('endDate', endDate)
			formData.append('year', year)

        api.post("/getUmsCountData",formData).then(respsone => {
            const res = respsone.data
            
            document.getElementById('countPatient').textContent = (res.countPatient ?? 0) + " คน";
            document.getElementById('countUser').textContent    = (res.countUser ?? 0) + " คน";
            document.getElementById('countNews').textContent    = (res.countNews ?? 0 )+ " ข่าว";
            document.getElementById('countSystem').textContent  = (res.countSystem ?? 0) + " ระบบ";
            
        }).catch(err => {

        })

    }


    document.getElementById('toggleSearchBtn').addEventListener('click', function() {
        var searchSection = document.getElementById('searchSection');
        if (searchSection.classList.contains('show')) {
            searchSection.classList.remove('show');
            setTimeout(function() {
                searchSection.style.display = 'none';
            }, 500); // Match the transition duration
        } else {
            searchSection.style.display = 'block';
            setTimeout(function() {
                searchSection.classList.add('show');
            }, 5); // Small delay to ensure display:block is applied
        }
    });
    var reports = [];
    document.querySelectorAll('.card-title').forEach(function(title) {
        reports.push(title.innerText || title.textContent);
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toUpperCase();
        var cards = document.querySelectorAll('#cardContainer .card');
        filterCards(filter);

        closeAllLists();
        if (!this.value) {
            return false;
        }
        var a, b, i, val = this.value;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < reports.length; i++) {
            if (reports[i].toUpperCase().includes(val.toUpperCase())) {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + reports[i].substr(0, val.length) + "</strong>";
                b.innerHTML += reports[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + reports[i] + "'>";
                b.addEventListener("click", function(e) {
                    document.getElementById('searchInput').value = this.getElementsByTagName("input")[0].value;
                    filterCards(this.getElementsByTagName("input")[0].value.toUpperCase());
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != document.getElementById('searchInput')) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });

    function filterCards(filter) {
        var cards = document.querySelectorAll('#cardContainer .card');
        cards.forEach(function(card) {
            var title = card.querySelector('.card-title');
            if (title) {
                var text = title.innerText || title.textContent;
                if (text.toUpperCase().indexOf(filter) > -1) {
                    card.parentElement.classList.remove('hidden');
                } else {
                    card.parentElement.classList.add('hidden');
                }
            }
        });
    }


    function updateSelectedFilters() {
        var department = document.getElementById('select_department');
        var year = document.getElementById('select_year');
        var date_start = document.getElementById('select_date_start');
        var date_end = document.getElementById('select_date_end');

        var departmentText = department && department.options[department.selectedIndex] ? department.options[department.selectedIndex].text : 'N/A';
        var yearText = year && year.options[year.selectedIndex] ? year.options[year.selectedIndex].text : 'N/A';

        // Retrieve the values of the date inputs directly
        var dateStartText = date_start && date_start.value ? date_start.value : null;
        var dateEndText = date_end && date_end.value ? date_end.value : null;


        var selectedFilters = 'หน่วยงาน: ' + departmentText;

        // Append date start if available
        if (dateStartText) {
        selectedFilters += ' | วันที่ : ' + dateStartText;
        }

        // Append date end if available
        if (dateEndText) {
        selectedFilters += ' | ถึง : ' + dateEndText;
        }

        // Append year if available
        selectedFilters += ' | ปี พ.ศ. : ' + yearText;

        var selectedFiltersElement = document.getElementById('selectedFilters');
        selectedFiltersElement.innerHTML = selectedFilters;
        selectedFiltersElement.style.display = 'block';
    }


    function filterUms(e) {
        if(e.value != ""){
            clearDate('select_date_end')
            clearDate('select_date_start')
            getAllData()
        }else{
            updateSelectedFilters();
            getAllData()
        }
    }

    function toggleLoaderSearchBtn(e){
        var loader = e.querySelector('.loader');
        if (loader.style.display === "none" || loader.style.display === "") {
            loader.style.display = "block";
        } else {
            loader.style.display = "none";
        }
    }

    
</script>
<!-- CSS ของหัวชื่อระบบ -->
<script>
    const colors2 = ['#e58800', '#007fb9', '#112b39'];
    var blobs = document.querySelectorAll("#background path");

    blobs.forEach(blob => {
        blob.style.fill = colors2[Math.floor(Math.random() * colors2.length)];
    });
</script>

<!-- วันที่เริ่ม - สิ้นสุด -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize the start date to the current date
    const today = new Date();
    const formattedDate = today.toLocaleDateString('th-TH', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });

    // Set the default value of the start date input to today's date
    const dateStartInput = document.getElementById('select_date_start');
    // dateStartInput.value = formattedDate;

    // Display the current date in the h6 element
    const currentDateDisplay = document.getElementById('currentDateDisplay');
    currentDateDisplay.textContent = `วันที่ : ${formattedDate}`;

    updateSelectedFilters();
  });

  function clearDate(inputId) {
    var inputField = document.getElementById(inputId);
    inputField.value = ''; // Clear the value
    // filterWts(); // Reapply the filter or any other necessary function
    updateSelectedFilters(); // Update the labels or any other necessary UI changes
  }

  function filterWts (){
    document.getElementById("select_year").value = ""
    getAllData()
  }


  const startDatePicker = flatpickr("#select_date_start", {
    dateFormat: "d F Y",
    locale: "th",
    position: "below", // Ensure the calendar opens below the input field
    // defaultDate: new Date(), // Set the default date to today
    onReady: function(selectedDates, dateStr, instance) {
      convertToBuddhistYear(instance);
      updateEndDatePickerMinDate(selectedDates[0]); // Set initial minDate for endDatePicker
    },
    onChange: function(selectedDates, dateStr, instance) {
      convertToBuddhistYear(instance);
      updateEndDatePickerMinDate(selectedDates[0]); // Update minDate for endDatePicker on change
      convertToBuddhistYear(endDatePicker);
    },
    onOpen: function(instance) {
      setTimeout(() => adjustFlatpickrPosition(instance), 0); // Delay to ensure elements are rendered
      convertToBuddhistYear(instance);
    },
    onMonthChange: function(instance) {
      convertToBuddhistYear(instance);
    },
    onYearChange: function(selectedDates, dateStr, instance) {
      setTimeout(() => convertToBuddhistYear(instance), 0); // Ensure conversion after year change
    }
  });

  const endDatePicker = flatpickr("#select_date_end", {
    dateFormat: "d F Y",
    locale: "th",
    position: "below", // Ensure the calendar opens below the input field
    minDate: new Date(), // Prevent selecting an end date earlier than today initially
    onReady: function(selectedDates, dateStr, instance) {
      convertToBuddhistYear(instance);
    },
    onChange: function(selectedDates, dateStr, instance) {
      convertToBuddhistYear(instance);
    },
    onOpen: function(instance) {
      setTimeout(() => adjustFlatpickrPosition(instance), 0); // Delay to ensure elements are rendered
      convertToBuddhistYear(instance);
    },
    onMonthChange: function(instance) {
      convertToBuddhistYear(instance);
    },
    onYearChange: function(selectedDates, dateStr, instance) {
      setTimeout(() => convertToBuddhistYear(instance), 0); // Ensure conversion after year change
    }
  });

  function convertToBuddhistYear(instance) {
    if (!instance) return;

    const currentYearElement = instance.currentYearElement;
    if (currentYearElement) {
      const gregorianYear = parseInt(currentYearElement.value);
      const buddhistYear = gregorianYear + 543;

      // Only convert if the Gregorian year is detected
      if (gregorianYear < 2500) {
        currentYearElement.value = buddhistYear;
      }
    }

    if (instance.selectedDates && instance.selectedDates.length > 0) {
      const selectedYear = instance.selectedDates[0].getFullYear();
      const buddhistYear = selectedYear + 543;
      instance.input.value = instance.input.value.replace(selectedYear, buddhistYear);
    }
  }

  function adjustFlatpickrPosition(instance) {
    if (!instance) return;

    const calendar = instance.calendarContainer;
    const inputField = instance.input;

    if (!calendar || !inputField) {
      return; // Ensure both elements exist before proceeding
    }

    const inputRect = inputField.getBoundingClientRect();
    const calendarRect = calendar.getBoundingClientRect();

    const top = inputRect.bottom + window.scrollY;
    const left = inputRect.left + window.scrollX;

    calendar.style.top = `${top}px`;
    calendar.style.left = `${left}px`;
    calendar.style.position = "absolute";
    calendar.style.zIndex = "9999";
  }

  function updateEndDatePickerMinDate(minDate) {
    endDatePicker.set('minDate', minDate);
  }
</script>

<!-- กราฟต่างๆ -->
<script>

</script>


<script>
    function getChart() {
        getRegistered()
        getStaffResponsibleSystem()
        getUserActivitySystemTimeline()
    }

    function getRegistered(){
        setTimeout(() => {
            let chart = Highcharts.chart('container_g1', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['จำนวน<br>ประชาชน'],
                    labels: {
                        style: {
                            fontSize: '16px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '',
                        style: {
                            fontSize: '16px'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '16px'
                        }
                    }
                },
                plotOptions: {
                    series: {
                        stacking: 'normal' // กำหนดให้ซีรีส์ยินยอมและไม่ยินยอมเป็น stacked bar
                    }
                },
                legend: {
                    itemStyle: {
                        fontSize: '16px' // ปรับขนาดฟอนต์ของ legend เป็น 16px
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            'จำนวน: ' + Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
                    },
                    style: {
                        fontSize: '16px'
                    }
                },
                series: [{
                    name: 'จำนวนประชาชนที่ลงทะเบียน',
                    data: [0],
                    color: '#7cb5ec',
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '16px'
                        },
                        formatter: function() {
                            return Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
                        }
                    },
                    stack: 'normal' // ไม่ซ้อนบาร์นี้
                }, {
                    name: 'ยินยอม',
                    data: [0],
                    color: '#90ed7d',
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '16px'
                        },
                        formatter: function() {
                            return Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
                        }
                    },
                    stack: 'consent' // ซ้อนบาร์ยินยอมกับไม่ยินยอม
                }, {
                    name: 'ไม่ยินยอม',
                    data: [0],
                    color: '#f15c80',
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '16px'
                        },
                        formatter: function() {
                            return Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
                        }
                    },
                    stack: 'consent' // ซ้อนบาร์ยินยอมกับไม่ยินยอม
                }]
            });


            const department  = document.getElementById('select_department').value;
            const startDate   = document.getElementById('select_date_start').value;
            const endDate     = document.getElementById('select_date_end').value;
            const year        = document.getElementById('select_year').value;

            let formData = new FormData()
            formData.append('department', department)
            formData.append('startDate', startDate)
            formData.append('endDate', endDate)
            formData.append('year', year)

            api.post('/getRegistrationSummary', formData).then( function (response) {
                const res = response.data;
                if(res) {
                    chart.series[0].setData([ parseInt(res.countPatient)]);
                    chart.series[1].setData([ parseInt(res.consent)]);
                    chart.series[2].setData([ parseInt(res.notConsent)]);
                }
            })
            .catch(function (error) {

            })
        }, 500);
    }

    function getStaffResponsibleSystem() {
        setTimeout(() => {
            let chart = Highcharts.chart('container_g2', {
                chart: {
                    type: 'column',
                    polar: true,
                    height: 500
                },
                title: {
                    text: '&emsp;',
                    style: {
                        fontSize: '16px'
                    }
                },
                pane: {
                    size: '90%'
                },
                xAxis: {
                    categories: [],
                    tickmarkPlacement: 'on',
                    lineWidth: 0,
                    labels: {
                        enabled: true,
                        style: {
                            fontSize: '16px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    endOnTick: false,
                    showLastLabel: true,
                    title: {
                        text: '',
                        style: {
                            fontSize: '16px'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '16px'
                        }
                    },
                    labels: {
                        enabled: false,  // ซ่อนตัวเลขลำดับชั้น
                    },
                    reversedStacks: false,
                    tickInterval: 1 
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    headerFormat: '<small><b>{point.key}</b></small><table>',
                    pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td>' +
                        '<td style="text-align: right"><b>{point.y} คน</b></td></tr>',
                    footerFormat: '</table>',
                    style: {
                        fontSize: '16px'
                    }
                },
                legend: {
                    itemStyle: {
                        fontSize: '16px' // ปรับขนาดฟอนต์ของ legend เป็น 16px
                    }
                },
                plotOptions: {
                    series: {
                        stacking: 'normal',
                        groupPadding: 0.1,
                        pointPlacement: 'between',
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '14px'
                            }
                        }
                    }
                },
                series: []
            });

            const department  = document.getElementById('select_department').value;
            const startDate   = document.getElementById('select_date_start').value;
            const endDate     = document.getElementById('select_date_end').value;
            const year        = document.getElementById('select_year').value;

            let formData = new FormData()
            formData.append('department', department)
            formData.append('startDate', startDate)
            formData.append('endDate', endDate)
            formData.append('year', year)

            api.post('/getStaffResponsibleSystemSummary', formData).then( function (response) {
                const res = response.data;
                if(res) {
                 
                    chart.xAxis[0].setCategories(res.system);
                    chart.series = [];  
                    
                    let countMax = 0;

                    res.series.forEach((row, index) => {
                        let countMaxTemp = 0;
                        row.data.forEach((c) => {
                            if(c != 0 ){
                                countMaxTemp ++;
                            }
                        })
                        
                        if (countMaxTemp >= countMax){
                            countMax = countMaxTemp
                        }
                        chart.addSeries({
                            name    :   row.name,
                            data    :   row.data,
                            color   :  row.color
                        });

                    })
                    // chart.yAxis[0].setExtremes(0,  countMax );
                }
            })
            .catch(function (error) {

            })
        }, 500);
    }

    function getUserActivitySystemTimeline() {
        setTimeout(function() {


            let chart = Highcharts.chart('container_g3', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: '',
                    style: {
                        fontSize: '16px'
                    }
                },
                xAxis: {
                    categories: [
                        
                    ],
                    labels: {
                        style: {
                            fontSize: '16px'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Logins',
                        style: {
                            fontSize: '16px'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '16px'
                        }
                    },
                    allowDecimals: false 
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' logins',
                    style: {
                        fontSize: '16px'
                    }
                },
                legend: {
                    itemStyle: {
                        fontSize: '16px'
                    }
                },
                plotOptions: {
                    spline: {
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '16px'
                            }
                        },
                        enableMouseTracking: true
                    }
                },
                series: []
            });

            const department  = document.getElementById('select_department').value;
            const startDate   = document.getElementById('select_date_start').value;
            const endDate     = document.getElementById('select_date_end').value;
            const year        = document.getElementById('select_year').value;
    
            let formData = new FormData()
            formData.append('department', department)
            formData.append('startDate', startDate)
            formData.append('endDate', endDate)
            formData.append('year', year)
            api.post('/getUserActivitySystemTimeline', formData).then( function (response) {
                const res = response.data;
                if(res) {
                    chart.xAxis[0].setCategories(res.datePeriod);

                    chart.series = [];  
                    res.series.forEach((row, index) => {
                        chart.addSeries({
                            name    :   row.name,
                            data    :   row.data,
                            color   :  row.color,
                            dashStyle : row.dashStyle
                        });
                    })

                    sessionStorage.setItem('sDate' , JSON.stringify(res.sDate))
                    sessionStorage.setItem('sMonth', JSON.stringify(res.sMonth))
                    sessionStorage.setItem('sYear' , res.sYear)

                }
            })
            .catch(function (error) {
    
            })
        }, 500);

    }





</script>