<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
        .small-swal-popup {
            width: 100% !important; /* Adjust the width as needed */
            font-size: 1rem !important; /* Smaller font size */
        }

        .small-swal-title {
            font-size: 1.5rem !important; /* Smaller title font size */
        }

        .small-swal-content {
            font-size: 12rem !important; /* Smaller content font size */
        }

        .small-swal-button {
            font-size: 1rem !important; /* Smaller button font size */
            padding: 8px 16px !important; /* Adjust button padding */
        }
    </style>
    
</head>
<body>

<!-- Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- LINE LIFF -->
<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>

<div></div>

<script>
    var scan_data = '';

    //start main
    main();

    async function main() {
        await liff.init({
                liffId: '<?php echo $this->config->item('scan_liff_id'); ?>'
        }, () => {
                if (liff.isLoggedIn()) {
                    scan_code_v2();
                } else {
                    //ถ้าไม่ Login ผ่าน LINE ต้อง Login
                    liff.login();
                }
        }, err => console.error(err.code, error.message));
    } //main

    async function scan_code_v2() {
        try {
            if (liff.scanCodeV2) {
                const result = await liff.scanCodeV2();
                scan_data = result.value;

                if (scan_data.includes("http")) {
                    location.href = scan_data;
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ข้อมูลไม่ถูกต้อง',
                        showConfirmButton: true,
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        liff.closeWindow();
                    });
                }
            } else {
                throw new Error("scanCodeV2 is not allowed in this LIFF app");
            }
        } catch (error) {
            // console.log('scanCodeV2', error);
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'ไม่สามารถสแกน QR โค้ดได้',
                text: 'กรุณาลองใหม่อีกครั้ง',
                showConfirmButton: true,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#3085d6',
                customClass: {
                    popup: 'small-swal-popup',
                    title: 'small-swal-title',
                    content: 'small-swal-content',
                    confirmButton: 'small-swal-button'
                }
            }).then(() => {
                liff.closeWindow();
            });
        }
    }
</script>