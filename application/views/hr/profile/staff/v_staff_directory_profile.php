<style>
  .card.info-card.sales-card {
    transition: transform 0.3s, background-color 0.3s, color 0.3s;
    cursor: pointer;
  }

  .card.info-card.sales-card:hover {
    transform: translateY(-10px);
  }

  .card.info-card.sales-card .icon path {
    fill: #0086c3;
    transition: fill 0.3s;
  }

  .card.info-card.sales-card.active {
    background-color: #0086c3;
    color: white;
  }

  .card.info-card.sales-card.active .card-title,
  .card.info-card.sales-card.active .d-flex,
  .card.info-card.sales-card.active .card-title i {
    color: white;
  }

  .card.info-card.sales-card.active .icon path {
    fill: white;
  }


  /* Loader styles */
  #loader {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #0086c3;
    width: 80px;
    height: 80px;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .title-with-line {
    position: relative;
    display: inline-block;
    padding-right: 20px;
    /* ระยะห่างจากข้อความถึงเส้น */
  }

  .title-with-line::after {
    content: '';
    position: absolute;
    left: 100%;
    top: 40%;
    transform: translateY(-50%);
    width: calc(280% - 100%);
    /* min-width: 500px; */
    /* max-width: 1000px; */
    /* ความยาวของเส้น */
    height: 2px;
    background: linear-gradient(to right, #8B4513, #D2691E, #F4A460, #DEB887);
    /* ไล่โทนสีน้ำตาล */
    margin-left: 10px;
  }

  .icon path {
    fill: #0086c3;
  }
</style>
<div id="loader"></div>
<div class="row justify-content-md-center mt-2">
  <!-- <span class='text-white font-16'>Staff Directory And Profile</span> -->
  <!-- <div class="col-3 col-md-2">
    <div id="doctors-card" class="card info-card sales-card" style="box-shadow: none; border-radius: 15px; cursor: pointer;">
      <div class="card-body p-2">
        <h5 class="card-title pt-2 pb-2 text-center fs-2">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="40" height="40">
            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
          </svg>
        </h5>
        <div class="d-flex align-items-center justify-content-center font-18 fw-bold">แพทย์</div>
      </div>
    </div>
  </div> -->
  <div class="col-3 col-md-2">
    <div id="nurses-card" class="card info-card sales-card" style="box-shadow: none; border-radius: 15px; cursor: pointer;">
      <div class="card-body p-2">
        <h5 class="card-title pt-2 pb-2 text-center fs-2">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="40" height="40">
            <path d="M96 128l0-57.8c0-13.3 8.3-25.3 20.8-30l96-36c7.2-2.7 15.2-2.7 22.5 0l96 36c12.5 4.7 20.8 16.6 20.8 30l0 57.8-.3 0c.2 2.6 .3 5.3 .3 8l0 40c0 70.7-57.3 128-128 128s-128-57.3-128-128l0-40c0-2.7 .1-5.4 .3-8l-.3 0zm48 48c0 44.2 35.8 80 80 80s80-35.8 80-80l0-16-160 0 0 16zM111.9 327.7c10.5-3.4 21.8 .4 29.4 8.5l71 75.5c6.3 6.7 17 6.7 23.3 0l71-75.5c7.6-8.1 18.9-11.9 29.4-8.5C401 348.6 448 409.4 448 481.3c0 17-13.8 30.7-30.7 30.7L30.7 512C13.8 512 0 498.2 0 481.3c0-71.9 47-132.7 111.9-153.6zM208 48l0 16-16 0c-4.4 0-8 3.6-8 8l0 16c0 4.4 3.6 8 8 8l16 0 0 16c0 4.4 3.6 8 8 8l16 0c4.4 0 8-3.6 8-8l0-16 16 0c4.4 0 8-3.6 8-8l0-16c0-4.4-3.6-8-8-8l-16 0 0-16c0-4.4-3.6-8-8-8l-16 0c-4.4 0-8 3.6-8 8z" />
          </svg>
        </h5>
        <div class="d-flex align-items-center justify-content-center font-18 fw-bold">พยาบาล</div>
      </div>
    </div>
  </div>
  <div class="col-3 col-md-2">
    <div id="staff-card" class="card info-card sales-card" style="box-shadow: none; border-radius: 15px; cursor: pointer;">
      <div class="card-body p-2">
        <h5 class="card-title pt-2 pb-2 text-center fs-2">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="40" height="40">
            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64L64 64C28.7 64 0 92.7 0 128L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64l-37.5 0C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM128 256a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM80 432c0-44.2 35.8-80 80-80l64 0c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16L96 448c-8.8 0-16-7.2-16-16z" />
          </svg>
        </h5>
        <div class="d-flex align-items-center justify-content-center font-18 fw-bold">เจ้าหน้าที่</div>
      </div>
    </div>
  </div>
  <!-- <div class="col-3 col-md-2">
    <div id="executives-card" class="card info-card sales-card" style="box-shadow: none; border-radius: 15px; cursor: pointer;">
      <div class="card-body p-2">
        <h5 class="card-title pt-2 pb-2 text-center fs-2">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="40" height="40">
            <path d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7l131.7 0c0 0 0 0 .1 0l5.5 0 112 0 5.5 0c0 0 0 0 .1 0l131.7 0c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2L224 304l-19.7 0c-12.4 0-20.1 13.6-13.7 24.2z" />
          </svg>
        </h5>
        <div class="d-flex align-items-center justify-content-center font-18 fw-bold">ผู้บริหาร</div>
      </div>
    </div>
  </div> -->
</div>
<div id="content_staff">

</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script>
  // Global function definitions;
  function loadContent(url, params = {}) {
    showLoader();
    const urlWithParams = new URL(url);
    Object.keys(params).forEach(key => urlWithParams.searchParams.append(key, params[key]));

    fetch(urlWithParams)
      .then(response => response.text())
      .then(data => {
        document.getElementById('content_staff').innerHTML = data;
        hideLoader();
        var selectElement = document.getElementById('floatingSelect');

        // var labelElement = document.getElementById('Mylabel')
        // var selectedOption = selectElement.options[selectElement.selectedIndex].text;
        // labelElement.textContent = selectedOption;
      })
      .catch(error => {
        console.error('Error loading content:', error);
        hideLoader();
      });
  }

  function activateCard(cardId, url, params = {}) {
    document.querySelectorAll('.info-card').forEach(card => card.classList.remove('active'));
    document.getElementById(cardId).classList.add('active');
    loadContent(url, params);
  }

  function showLoader() {
    document.getElementById('loader').style.display = 'block';
  }

  function hideLoader() {
    document.getElementById('loader').style.display = 'none';
  }

  function filter_profile() {
    const button = document.getElementById('seacrh_button');
    if (button) {
      var check = button.getAttribute('data-value');
      activateCard(check + '-card', '<?= site_url('hr/profile/Profile_staff/') ?>' + '/' + check, {
        ft_name: $('#floatingInput').val(),
        ft_stde: $('#floatingSelect').val()
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    // document.getElementById("doctors-card").addEventListener("click", function() {
    //   activateCard('doctors-card', '<?= site_url('hr/profile/Profile_staff/doctors') ?>', {
    //     ft_name: '',
    //     ft_stde: 'all'
    //   });
    // });

    document.getElementById("nurses-card").addEventListener("click", function() {
      activateCard('nurses-card', '<?= site_url('hr/profile/Profile_staff/nurses') ?>', {
        ft_name: '',
        ft_stde: 'all'
      });
    });

    document.getElementById("staff-card").addEventListener("click", function() {
      activateCard('staff-card', '<?= site_url('hr/profile/Profile_staff/staff') ?>', {
        ft_name: '',
        ft_stde: 'all'
      });
    });

    // document.getElementById("executives-card").addEventListener("click", function() {
    //   activateCard('executives-card', '<?= site_url('staff/Directory_profile/executives') ?>', {
    //     ft_name: '',
    //     ft_stde: 'all'
    //   });
    // });

    // // Auto click the doctor card on page load
    activateCard('nurses-card', '<?= site_url('hr/profile/Profile_staff/nurses') ?>', {
      ft_name: '',
      ft_stde: 'all'
    });

    // Initialize filter_profile
    filter_profile();
  });
</script>