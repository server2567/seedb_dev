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
  .form-floating > .form-control:focus ~ label, .form-floating > .form-control:not(:placeholder-shown) ~ label, .form-floating > .form-control-plaintext ~ label, .form-floating > .form-select ~ label {
    color: rgb(33 37 41 / 91%);
  }

/* card */
  .row-card {
    display: flex;
    flex-wrap: wrap;
  }
  .row-card .col-md-3 {
    display: flex;
    flex-grow: 1;
  }
  .row-card .col-md-3 .card.info-card.sales-card {
      display: flex;
      flex-direction: column;
      flex-grow: 1;
  }
</style>
