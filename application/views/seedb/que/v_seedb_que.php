<style>
  a.bi-search {
    cursor: pointer;
  }

  .filterDetail {
    right: 20px !important;
  }

  .nav-pills .nav-link {
    /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    border: 1px dashed #607D8B;
    color: #012970;
  }

  .table {
    border-collapse: collapse !important;
  }

  .hidden {
    display: none;
  }

  .search-bar {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    margin-bottom: 40px !important;
    margin-top: 20px !important;
  }

  .search-bar input {
    width: 50%;
    border-radius: 20px;
    padding: 10px;
    border: 1px solid #ced4da;
    outline: none;
    transition: box-shadow 0.3s ease-in-out;
  }

  .search-bar input:focus {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
  }

  #searchSection {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }

  #searchSection.show {
    display: block;
    opacity: 1;
  }

  .selected-filters {
    position: fixed;
    top: 9px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #bbddff;
    padding: 7px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: none;
    border-radius: 10px;
    border: 1px solid #03A9F4;
  }

  .btn-filters {
    position: fixed;
    top: 10px;
    left: 30%;
    transform: translateX(-50%);
    z-index: 1000;
  }

  @media (max-width: 1600px) {
    .selected-filters {
      left: 50%;
      font-size: 14px;
    }

    .header-nav {
      font-size: 14px;
    }

    .btn-filters {
      position: fixed;
      top: 10px;
      left: 28%;
      transform: translateX(-50%);
      z-index: 1000;
      font-size: 14px;
    }
  }

  .loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .chart-container {
    position: relative;
    height: 400px;
  }

  .autocomplete-items {
    border: 1px solid #d4d4d4;
    border-top: none;
    z-index: 99;
    position: absolute;
    background-color: #fff;
    max-height: 150px;
    overflow-y: auto;
    width: 875px;
    margin-left: 15px;
  }

  .autocomplete-items div {
    padding: 10px;
    cursor: pointer;
  }

  .autocomplete-items div:hover {
    background-color: #e9e9e9;
  }

  .autocomplete-active {
    background-color: DodgerBlue !important;
    color: #ffffff;
  }

  /* Basic styling */
  svg {
    width: 100%;
  }

  .filled-heading {
    font-size: 30px;
  }

  /* Animate the background shapes */
  #background path {
    transform-origin: 50% 50%;
    transform-box: fill-box;
  }

  #background path:nth-of-type(2n) {
    animation: rotate 20s linear infinite;
  }

  #background path:nth-of-type(2n + 1) {
    animation: rotate 30s linear reverse infinite;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>
<div class="container" style="margin-top: -30px;">
  <div class="d-flex align-items-center justify-content-center my-3 mb-5 search-bar">
    <button class="btn btn-outline-primary me-5 btn-filters" id="toggleSearchBtn">ตัวเลือกอื่นๆ</button>
    <div class="selected-filters" id="selectedFilters"></div>
    <div class="autocomplete mx-auto" style="width:70%;">
      <svg viewbox="0 0 1000 50" class='pb-3'>
        <clipPath id="text" class="filled-heading ">
          <text y="40" class="fw-bold">ระบบจัดการคิว-นัดหมายแพทย์ (Queuing System)</text>
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
      <input type="text" class="form-control w-100 mb-0" id="searchInput" placeholder="ค้นหาชื่อรายงานระบบจัดการคิว / นัดหมายแพทย์">
    </div>
  </div>
  <div id="searchSection">
    <div class="row">
      <div class="col-md-4">
        <div class="form-floating mb-4">
          <select class="form-select mb-4" id="que_select_ums_department" name="que_select_ums_department" onchange="filterQue()">
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
      <div class="col-md-4" id="filter_que_select_year_type">
        <div class="form-floating mb-3">
          <select class="form-select mb-3" id="que_select_year_type" name="que_select_year_type" onchange="filterQue()">
            <option value="1" selected>ปีปฏิทิน</option>
          </select>
          <label for="que_select_year_type">ประเภทปี</label>
        </div>
      </div>
      <div class="col-md-4" id="filter_que_select_year">
        <div class="form-floating mb-3">
          <select class="form-select mb-3" id="que_select_year" name="que_select_year" onchange="filterQue()">
            <?php
            $i = 0;
            foreach ($default_year_list as $year) {
              // Get current date
              if ($year == getNowYearTh())
                echo '<option value="' . ($year - 543) . '" selected>' . $year . '</option>';
              else
                echo '<option value="' . ($year - 543) . '">' . $year . '</option>';
              $i++;
            }
            ?>
          </select>
          <label for="que_select_year">ปีพ.ศ.</label>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="section dashboard" id="cardContainer">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-12 col-md-12">
      <div class="alert alert-info" role="alert">
        <?php
        // Set locale to Thai
        setlocale(LC_TIME, 'th_TH.utf8');
        
        // Array of Thai month names
        $thaiMonths = array(
          'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
          'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        );
        
        // Get current date and format it
        $currentDay = date('d');
        $currentMonth = $thaiMonths[date('n') - 1];
        $currentYear = date('Y') + 543;

        echo '<span class="me-2">วันที่ ' . $currentDay . ' ' . $currentMonth . ' พ.ศ. ' . $currentYear . '</span>';
        ?>
        เวลา&nbsp;<span class="clock" id="clock"></span> น.
      
    
            <div class=" float-end" style="margin-top: -8px;">
              <input type="radio" class="btn-check" name="options-outlined" id="primary-outlined" autocomplete="off" checked="">
              <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="primary-outlined">วัน</label>

              <input type="radio" class="btn-check" name="options-outlined" id="outlined-1" autocomplete="off">
              <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-1">สัปดาห์</label>

              <input type="radio" class="btn-check" name="options-outlined" id="outlined-2" autocomplete="off">
              <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-2">เดือน</label>

              <input type="radio" class="btn-check" name="options-outlined" id="outlined-3" autocomplete="off">
              <label class="btn btn-outline-primary me-3 ps-4 pe-4 fw-semibold" for="outlined-3">ปี</label>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>ศ.</span>
              <h5 class="card-title p-0">26</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>ส.</span>
              <h5 class="card-title p-0">27</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>อา.</span>
              <h5 class="card-title p-0">28</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>จ.</span>
              <h5 class="card-title p-0">29</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>อ.</span>
              <h5 class="card-title p-0">30</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0" style="border: 1px solid #2196F3;border-radius: 10px; box-shadow: 0px 0 10px 0px rgb(0 170 255 / 32%);">
              <span>พ.</span>
              <h5 class="card-title p-0"><b>31</b></h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>พฤ.</span>
              <h5 class="card-title p-0">1</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>ศ.</span>
              <h5 class="card-title p-0">2</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>ส.</span>
              <h5 class="card-title p-0">3</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>อา.</span>
              <h5 class="card-title p-0">4</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <span>จ.</span>
              <h5 class="card-title p-0">5</h5>
            </div>
          </div>
        </div>
        <div class="col-md-1 pe-0" style="cursor: pointer;">
          <div class="card text-center" style="border-radius:10px; margin-bottom:5px;">
            <div class="card-body p-0">
              <i class="bi bi-arrow-right-square-fill text-primary"></i>
            </div>
          </div>
          <div class="card text-center" style="border-radius:10px;">
            <div class="card-body p-0">
              <i class="bi bi-arrow-left-square"></i>
            </div>
          </div>
        </div>
        <div class="row" style="margin-left:1px;">
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card" style="border-bottom: 3px solid #2196F3;">
              <div class="card-body pb-2">
                <h5 class="card-title pt-1 pb-3 font-16">[QUE-C1] ลงทะเบียนผู้ป่วย</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-heart"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $count_all_que['total'] ?> คน</h6>
                  </div>
                </div>
                <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                  <div class="col-md-6 text-center">
                    <span class="text-success fw-bold">ผู้ป่วยใหม่<br><?= $count_all_que_new['total'] ?></span><br>
                  </div>
                  <div class="col-md-6 text-center">
                    <span class="text-primary fw-bold">ผู้ป่วยเก่า<br><?= $count_all_que_old['total'] ?></span>
                  </div>
                </div>
              </div>
              <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"  data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card" style="border-bottom: 3px solid #795548;">
              <div class="card-body pb-2">
                <h5 class="card-title pt-1 pb-3 font-16">[QUE-C2] แบบ Walk In</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4c1906; background: #f3dfd7;">
                    <i class="bi bi-eye"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $count_all_que_W['total'] ?> คน</h6>
                  </div>
                </div>
                <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                  <div class="col-md-6 text-center">
                    <span class="text-success fw-bold">ผู้ป่วยใหม่<br><?= $count_all_que_W_new['total'] ?></span><br>
                  </div>
                  <div class="col-md-6 text-center">
                    <span class="text-primary fw-bold">ผู้ป่วยเก่า<br><?= $count_all_que_W_old['total'] ?></span>
                  </div>
                </div>
              </div>
              <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"  data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card" style="border-bottom: 3px solid #9c27b0;">
              <div class="card-body pb-2">
                <h5 class="card-title pt-1 pb-3 font-16">[QUE-C3] แบบนัดล่วงหน้า</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #9c27b0; background: #faddff;">
                    <i class="bi bi-emoji-heart-eyes"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $count_all_que_A['total'] ?> คน</h6>
                  </div>
                </div>
                <div class="row mt-2" style="border-top: 1px solid #e1e1e1; padding-top: 10px;">
                  <div class="col-md-6 text-center">
                    <span class="text-success fw-bold">ผู้ป่วยใหม่<br><?= $count_all_que_A_new['total'] ?></span><br>
                  </div>
                  <div class="col-md-6 text-center">
                    <span class="text-primary fw-bold">ผู้ป่วยเก่า<br><?= $count_all_que_A_old['total'] ?></span>
                  </div>
                </div>
              </div>
              <div class="filter filterDetail">
                <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12"  data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Reports -->
        <div class="col-12">
          <div class="card">
            <div class="filter filterDetail">
              <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
            </div>
            <div class="card-body">
              <h5 class="card-title pt-1 pb-0 font-16 w-90">[QUE-G1] รายงานเวลาที่ลงทะเบียนผู้ป่วย จำแนกตามประเภทผู้ป่วย</h5>
              <hr>
              <div id="container"></div>
            </div>

          </div>
        </div><!-- End Reports -->
        <div class="col-12">
          <div class="card">
            <div class="filter filterDetail">
              <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
            </div>
            <div class="card-body pb-0">
              <h5 class="card-title pt-1 pb-0 font-16 w-90">[QUE-G3] รายงานการลงทะเบียนผู้ป่วย จำแนกตามแผนก</h5>
              <hr>
              <div id="container3"></div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

      <!-- Recent Activity -->
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
        </div>
        <div class="card-body">
          <h5 class="card-title pt-1 pb-0 font-16 w-90">[QUE-T1] กิจกรรมล่าสุด</h5>
          <hr>
          <div class="activity">
            <?php foreach($activity as $index => $ntdp) {  ?>
            <div class="activity-item d-flex">
              <div class="activite-label"> <?php echo $ntdp['time_difference'] ?> </div>
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
                <?php echo $ntdp['pt_name'] ?> <a href="#" class="fw-bold text-dark"> <?php echo $ntdp['loc_name'] ?></a>
              </div>
            </div><!-- End activity item-->
            <?php } ?>
          </div>

        </div>
      </div>
      <div class="card">
        <div class="filter filterDetail">
          <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
        </div>
        <div class="card-body pb-0">
          <h5 class="card-title card-title pt-1 pb-0 font-16 w-90" >[QUE-G2] รายงานจำนวนนัดพบแพทย์ มาก-น้อย</h5>
          <hr>
          <div id="container2" ></div>
        </div>
        <div class="card-body pb-0">
          <h5 class="card-title card-title pt-1 pb-0 font-16 w-100" >[QUE-G4] รายงานสรุปการนัดพบแพทย์ 
            <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-14" style="float: right; margin-top: -10px;" data-toggle="tooltip" data-placement="top" data-bs-toggle="modal" href="#" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"> ดูรายละเอียด</a>
          </h5>
          <hr>
          <div id="container_summary"></div>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
  function updateClock() {
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let seconds = now.getSeconds().toString().padStart(2, '0');
    let time = hours + ':' + minutes + ':' + seconds;
    document.getElementById('clock').textContent = time;
  }

  // Initialize clock
  updateClock(); // Set the clock immediately
  setInterval(updateClock, 1000);
  // Initial call to display default selected filters
  updateSelectedFilters();

  $(document).ready(function() {

    // // Example event binding for a card to trigger viewCardHRMDetails function
    // $('.toggleCardHRMDetail').on('click', function() {
    // var cardType = $(this).data('card-type'); // Assuming card type is stored in data-card-type attribute
    //     viewCardHRMDetails(cardType);
    // });

    // // Event binding for tab change to populate DataTable
    // $('#detailsTab a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
    //     var cardType = $(e.target).attr('href').substring(1); // Get the card type from the tab href
    //     populateDataTableCardHRM(cardType);
    // });

    filterQue();

  });
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
    var department = document.getElementById('que_select_ums_department');
    var yearType = document.getElementById('que_select_year_type');
    var year = document.getElementById('que_select_year');

    var selectedFilters = document.getElementById('selectedFilters');
    selectedFilters.innerHTML = 'หน่วยงาน: ' + department.options[department.selectedIndex].text +
      ' | ประเภทปี: ' + yearType.options[yearType.selectedIndex].text +
      ' | ปีพ.ศ.: ' + year.options[year.selectedIndex].text;
    selectedFilters.style.display = 'block';
  }

  function filterQue() {
    updateSelectedFilters();
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


<!-- Template Main JS File -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>
<script>
  const colors = Highcharts.getOptions().colors;
  setTimeout(function() {


  Highcharts.chart('container', {
    chart: {
      type: 'spline',
      style: {
        fontSize: '14px', // Set the font size for the entire chart
      }
    },
    legend: {
      symbolWidth: 40
    },
    title: {
      text: '',
      align: ''
    },
    subtitle: {
      text: '',
      align: 'left'
    },
    yAxis: {
      title: {
        text: 'จำนวนการนัดหมาย',
        style: {
          fontSize: '14px' // Set the font size for the yAxis title
        }
      }
    },
    xAxis: {
      title: {
        text: 'Time',
        style: {
          fontSize: '14px' // Set the font size for the xAxis title
        }
      },
      labels: {
        style: {
          fontSize: '14px' // Set the font size for the xAxis labels
        }
      },
      categories: ['17.30', '18.00', '18.30', '19.00', '19.30', '20.00']
    },
    tooltip: {
      valueSuffix: ' คน',
      stickOnContact: true,
      style: {
        fontSize: '14px' // Set the font size for the xAxis labels
      }
    },
    plotOptions: {
      series: {
        cursor: 'pointer',
        lineWidth: 2,
        dataLabels: {
          enabled: true,
          format: '{y} คน',
          style: {
            fontSize: '14px' // Set the font size for the dataLabels
          }
        }
      }
    },
    series: [{
        name: 'ผู้ป่วยใหม่',
        data: [10, 15, 10, 19, 12, 8],
        color: Highcharts.getOptions().colors[2],
        label: {
          style: {
            fontSize: '16px'
          }
        }
      },
      {
        name: 'ผู้ป่วยเก่า',
        data: [20, 7, 9, 8, 7, 10],
        color: Highcharts.getOptions().colors[0],
        label: {
          style: {
            fontSize: '16px'
          }
        }
      },
      {
        name: 'Walk In',
        data: [5, 3, 4, 6, 6, 20],
        color: Highcharts.getOptions().colors[7],
        label: {
          style: {
            fontSize: '16px'
          }
        }
      },
      {
        name: 'นัดล่วงหน้า',
        data: [5, 3, 4, 6, 6, 20],
        color: Highcharts.getOptions().colors[9],
        label: {
          style: {
            fontSize: '16px'
          }
        }
      }
    ],
  });

  Highcharts.chart('container2', {
  chart: {
    type: 'bar',
    height: 600 // Auto height based on content
  },
  title: {
    text: ''
  },
  xAxis: {
    categories: [
      'พญ.สุวรรณา วัฒนสุข', 
      'พญ.บุณยดา ชินกุลกิจนิวัฒน์', 
      'พญ.บุญพิสุทธิ์ ชินกุลกิจนิวัฒน์', 
      'พญ.บัวขวัญ ชินกุลกิจนิวัฒน์', 
      'นพ.วีระชัย ศรีวิลาศ',
      'นพ.บรรยง ชินกุลกิจนิวัฒน์',
      'นพ.กิตติพงษ์ อัครนันท์', 
      'นพ.สมชาย ทองมี', 
      'พญ.รัตนาวดี พงศ์เจริญ', 
      'นพ.นภัส เตชะเลิศไพศาล'
    ]
  },
  yAxis: {
    min: 0,
    title: {
      text: ''
    }
  },
  legend: {
    reversed: true
  },
  plotOptions: {
    series: {
      stacking: 'normal',
      dataLabels: {
        enabled: true
      }
    }
  },
  tooltip: {
    shared: true,
    style: {
      fontSize: '16px' // Set the font size for the tooltip to 16 pixels
    },
    formatter: function() {
      let tooltip = '<b>' + this.x + '</b><br>';
      let total = 0;
      this.points.forEach(point => {
        tooltip += '<span style="color:' + point.color + '">\u25CF</span> ' + point.series.name + ': ' + point.y + ' คน<br>';
        total += point.y;
      });
      tooltip += '<br><b>รวมทั้งหมด: ' + total + ' คน</b>';
      return tooltip;
    }
  },
  series: [
   {
      name: 'ผู้ป่วยเก่า',
      data: [14, 12, 15, 12, 11, 15, 10, 9, 8, 5],
      color: Highcharts.getOptions().colors[0]
    }, {
      name: 'ผู้ป่วยใหม่',
      data: [8, 11, 3, 6, 7, 6, 4, 5, 6, 4],
      color: Highcharts.getOptions().colors[2]
    }]
});
Highcharts.chart('container_summary', {
  chart: {
    type: 'bubble',
    plotBorderWidth: 1,
    height: null
  },
  title: {
    text: ''
  },
  xAxis: {
    gridLineWidth: 1,
    title: {
      text: 'ประเภทการนัดหมาย'
    },
    categories: ['ผู้ป่วยใหม่', 'ผู้ป่วยเก่า']
  },
  yAxis: {
    startOnTick: false,
    endOnTick: false,
    title: {
      text: 'จำนวนการนัดหมาย (คน)'
    }
  },
  tooltip: {
    useHTML: true,
    formatter: function() {
      return '<tr><th>ประเภท:</th><td>' + this.series.xAxis.categories[this.point.x] + '<br>' +
             '<tr><th>จำนวน:</th><td>' + this.point.y + ' คน</td></tr>';
    },
    style: {
      fontSize: '16px'
    }
  },
  plotOptions: {
    bubble: {
      minSize: 70,
      maxSize: 100
    }
  },
  legend: {
    enabled: false // ซ่อน Legend ทั้งหมด
  },
  series: [{
    data: [
      { x: 0, y: 100, z: 100, name: 'ผู้ป่วยใหม่',color: Highcharts.getOptions().colors[2] },
      { x: 1, y: 70, z: 70, name: 'ผู้ป่วยเก่า',color: Highcharts.getOptions().colors[0] }
    ],
    colorByPoint: true
  }]
});




  Highcharts.chart('container3', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie',
    style: {
      fontSize: '16px' // Set the font size for the entire chart
    }
  },
  title: {
    text: '',
    align: 'left',
    style: {
      fontSize: '16px' // Set the font size for the title
    }
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
    style: {
      fontSize: '16px' // Set the font size for the tooltip
    }
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true, // Enable data labels
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        distance: -50, // Adjust the distance of labels from the center of the pie
        style: {
          fontSize: '16px' // Set the font size for the data labels
        }
      },
      showInLegend: true,
      size: '100%',
      innerSize: '50%' // Create a donut chart
    }
  },
  series: [{
    name: 'ร้อยละ',
    colorByPoint: true,
    colors: ['#7cb5ec', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354'], // Softer, vibrant colors
    data: [{
      name: 'ภาคจักษุวิทยา (EYE)',
      y: 74.77,
      sliced: true,
    }, {
      name: 'แผนกทัศนมาตร',
      y: 12.82,
    }, {
      name: 'แผนกทันตกรรม',
      y: 4.63
    }, {
      name: 'แผนกรังสีวิทยา',
      y: 2.44
    }, {
      name: 'แผนกผู้ป่วยนอกหู/คอ/จมูก',
      y: 100.00
    }]
  }],
  legend: {
    itemStyle: {
      fontSize: '16px' // Set the font size for the legend items
    }
  }
});




}, 500); // หน่วงเวลา 500 มิลลิวินาที (0.5 วินาที)

</script>