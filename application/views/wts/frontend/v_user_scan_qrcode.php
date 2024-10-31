    <style>
      /* body {
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            box-sizing: border-box;
            text-align: center;
            background: rgb(128 0 0 / 66%);
        } */

      /* .container {
            width: 100%;
            max-width: 500px;
            margin: 5px;
        }

        .container h1 {
            color: #ffffff;
        }

        .section {
            background-color: #ffffff;
            padding: 50px 30px;
            border: 1.5px solid #b2b2b2;
            border-radius: 0.25em;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
        } */

      #my-qr-reader {
        padding: 20px !important;
        border: none !important;
        border-radius: 8px;
        position: relative;
      }

      #my-qr-reader img[alt="Info icon"] {
        display: none;
      }

      #my-qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
      }

      button {
        padding: 10px 20px;
        border: 1px solid #b2b2b2;
        outline: none;
        border-radius: 0.25em;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
      }

      /* button:hover {
            background-color: #008000;
        }
 */
      #html5-qrcode-anchor-scan-type-change {
        text-decoration: none !important;
        color: #1d9bf0;
      }

      video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
      }

      .qr-scanning-box {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        height: 200px;
        transform: translate(-50%, -50%);
        border: 4px solid #ff0000;
        box-sizing: border-box;
        z-index: 10;
        pointer-events: none;
      }
    </style>
    <div class="card mb-3">
      <div class="card-body">
        <div class="pt-4 pb-2">
          <h5 class="card-title text-center pb-0 fs-4">แสกน QR-Code</h5>
          <p class="text-center small">กรุณานำ QR-Code ไปอยู่บริเวณกรอบสี่เหลี่ยม</p>
        </div>
        <form class="row g-3 needs-validation" novalidate method="post">
          <div class="col-12">
            <div class="container">
              <div class="section">
                <div id="my-qr-reader">
                  <div class="qr-scanning-box"></div>
                  <input type="hidden" class="form-control" name="qr_id" id="qr_id" value="<?php echo !empty($qr_code[0]['qr_id']) ? $qr_code[0]['qr_id'] : "" ?>">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
      function domReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
          setTimeout(fn, 1000);
        } else {
          document.addEventListener("DOMContentLoaded", fn);
        }
      }

      domReady(function() {
        // If found you qr code
        function onScanSuccess(decodeText, decodeResult) {
          window.location.href = decodeText;
        }

        let htmlscanner = new Html5QrcodeScanner(
          "my-qr-reader", {
            fps: 10,
            qrbox: 200
          }
        );
        htmlscanner.render(onScanSuccess);
      });
    </script>