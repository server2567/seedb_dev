<style>
        @media print {
            @page {
                size: 8.2cm 6.5cm;
                margin: 0;
                padding: 0;
                width: 10.5cm;
                height: 8.2cm;
                font-size: 26px;
            }
            body {
                margin: 0;
                padding: 0;
                width: 10.5cm;
                height: 8.2cm;
                font-size: 26px;
            }
            .container {
                width: 100%;
                height: 100%;
                margin-top: -140px;
                margin-bottom: -40px;
            }
            .header2 {
                text-align: left;
                font-size: 16px;
                font-weight: bold;
                display: flex;
            }
            .subheader {
                text-align: center;
                font-size: 10px;
            }
            .patient-info {
                margin-top: 5px;
            }
            .patient-info p {
                margin: 0;
                font-size: 12px;
            }
            .barcode-section {
                text-align: center;
                margin-top: 10px;
            }
            .barcode {
                margin-top: 10px;
            }
            .large-text {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                margin: 0;
            }
            .small-info {
                font-size: 24px;
                text-align: center;
                margin-top: 5px;
            }
        }
        .header {
            display: none !important;
        }
        #footer {
            display: none !important;
        }
    </style>

<?php
// Assuming 'apm_date' is in the format 'YYYY-MM-DD' and 'apm_time' is in 'H:i:s'
$appointment_date = $get_appointment_by_visit[0]['apm_date'];
$appointment_time = $get_appointment_by_visit[0]['apm_time'];

// Convert appointment date to a timestamp
$appointment_timestamp = strtotime($appointment_date);

// Format the appointment date to Thai format (d/m/Y)
$thai_year = date('Y', $appointment_timestamp) + 543; // Convert to Buddhist year
$formatted_appointment_date = date('j/m/', $appointment_timestamp) . $thai_year;

// Format the appointment time (assuming it's in 'H:i:s' format)
$formatted_time = date('H:i', strtotime($appointment_time));

// Display the formatted appointment date and time
// echo 'วันที่เข้ารับบริการ: ' . $formatted_appointment_date . ' เวลา ' . $formatted_time . ' น.';
?>
<body onload="window.print(); window.onafterprint = function(){ window.close(); }">
    <div class="container"  style="text-align: center;">
        <!-- Header Section -->
        <div class="header2" style="margin-bottom: 15px; width:110%;">
        <img src="<?php echo base_url(); ?>/assets/img/apple-touch-icon2.png" alt="" class="img-width" style="width:100px; margin-right: 15px;">
            โรงพยาบาลจักษุสุราษฎร์<br> 
            SURAT EYE HOSPITAL
            <span style="font-weight: 400;">&emsp;&emsp;&emsp;&emsp;&emsp;โทร 077-276-999</span>
        </div>
        <!-- Patient Information -->
        <div class="patient-info" style="text-align: center;">
            <p style="font-weight: 600; font-size:26px; margin-top: 10px;"><?php echo $get_appointment_by_visit[0]['pt_name'];?></p>
            <p style="margin-top: 8px; font-size:22px;">
                ว/ด/ป เกิด : 
                <?php 
                    // Check if 'ptd_birthdate' is set, not empty, and not '0000-00-00'
                    if (!empty($get_appointment_by_visit[0]['ptd_birthdate']) && $get_appointment_by_visit[0]['ptd_birthdate'] != '0000-00-00') {
                        // Assuming 'ptd_birthdate' is in the format 'YYYY-MM-DD'
                        $birthdate = $get_appointment_by_visit[0]['ptd_birthdate'];

                        // Convert birthdate to a timestamp
                        $birthdate_timestamp = strtotime($birthdate);

                        // Format the birthdate to Thai format (d/m/Y)
                        $thai_year = date('Y', $birthdate_timestamp) + 543; // Convert to Buddhist year
                        $formatted_birthdate = date('j/m/', $birthdate_timestamp) . $thai_year;

                        // Calculate the age
                        $current_year = date('Y');
                        $birth_year = date('Y', $birthdate_timestamp);
                        $age = $current_year - $birth_year;

                        // Adjust the age if the birthdate hasn't occurred yet this year
                        if (date('md', $birthdate_timestamp) > date('md')) {
                            $age--;
                        }

                        // Display formatted birthdate and age
                        echo $formatted_birthdate . ' &nbsp; อายุ : ' . $age;
                    } else {
                        // Display a placeholder when no birthdate is available or when it's '0000-00-00'
                        echo '- &nbsp; อายุ : -';
                    } 
                ?> 
                ปี &nbsp; เพศ : 
                <?php
                    // Display 'ชาย' if sex is 'M', 'หญิง' if sex is 'F', and '-' for other values
                    if ($get_appointment_by_visit[0]['ptd_sex'] == 'M') {
                        echo 'ชาย';
                    } elseif ($get_appointment_by_visit[0]['ptd_sex'] == 'F') {
                        echo 'หญิง';
                    } else {
                        echo '-'; // Display '-' if the value is not 'M' or 'F'
                    }
                ?>
            </p>
            <p style="margin-top: 8px; font-size:22px;">วันที่เข้ารับบริการ : <?php echo $formatted_appointment_date . ' เวลา ' . $formatted_time . ' น.'; ?></p>
        </div>

        <!-- Large Number and Barcode Section -->
        <div class="barcode-section" style="text-align: center;">
            <p class="large-text" style="font-size:46px; margin-top:-10px;">คิว <?php echo $get_appointment_by_visit[0]['apm_ql_code']; ?></p>
            <p class="small-info" style="margin-top: 0px;">VN : <?php echo $get_appointment_by_visit[0]['apm_visit']; ?> &nbsp; HN : <?php echo $get_appointment_by_visit[0]['pt_member']; ?></p>
            <?php
              $stde_name_th = array_column($get_appointment_by_visit, 'stde_name_th');
              $c_stde_name_th = implode(', ', $stde_name_th); // 'John Doe, Jane Smith'
            ?>
            <p class="small-info" style="margin-top: -15px;"><?php echo $c_stde_name_th.''; ?></p>
            <div class="barcode" style="margin-top: -10px;">
              <img src="<?php echo site_url($this->config->item("hr_dir") . "getbarcode?type=barcodes&image=".$barcode_path.""); ?>" alt="Barcode" style="width:70%; height:60px;">
            </div>
          </div>
    </div>
</body>