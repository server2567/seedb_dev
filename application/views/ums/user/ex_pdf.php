<?php
function preview($adm5_id,$mn_id,$ar_id){
    $this->load->model('admission/M_admission_step5','adm5');
    $this->pidb = $this->load->database('default',true);

    $MEMBERID = $this->session->userdata("MEMBERID");      
    $rs_count = $this->adm5->get_data_step5_by_adm5_and_mn_and_member_id($adm5_id,$mn_id,$ar_id,$MEMBERID)->num_rows(); //ป้องกันการเปลี่ยนไอดีตรง url ด้วย
    if($rs_count == 0) {
      redirect('/member/Admission_home');
    }else {
  
      ob_start();

      $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];
      $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $mpdf = new \Mpdf\Mpdf(
          [ 
              'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf',
              'fontDir' => array_merge($fontDirs, [
                  __DIR__ . '/fonts',
              ]),
              'fontdata' => $fontData + [
                  'thsarabun' => [
                      'R' => 'THSarabunNew.ttf',
                      'I' => 'THSarabunNewItalic.ttf',
                      'B' => 'THSarabunNewBold.ttf',
                      'BI'=> 'THSarabunNewBoldItalic.ttf'
                  ]
              ]
          ]
      );

      $mpdf->allow_charset_conversion = true;
      $mpdf->charset_in = 'UTF-8';
      $mpdf->autoScriptToLang = true;
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->showImageErrors = true;
      $mpdf->curlAllowUnsafeSslRequests = true;
      $mpdf->useDictionaryLBR = false;

      // $mpdf->SetDefaultFont('thsarabun');
      $defaultFont = $mpdf->default_font;
      // echo $defaultFont;
      // die;
      $mpdf->AddPageByArray([
          'margin-left' => '6mm',
          'margin-right' => '6mm',
          'margin-top' => '2mm',
          'margin-bottom' => '2mm',
      ]);
      $mpdf->setDisplayMode('fullpage');

      $res = $this->get_detail_admission_payment($adm5_id,$mn_id,$ar_id);

      $res['detail_admissions'] = $this->pidb->query(
        "SELECT * FROM front_admission_step4
        LEFT JOIN front_admission_step4_detail ON front_admission_step4.adm4_id = front_admission_step4_detail.adm4de_adm4_id
        LEFT JOIN base_area ON front_admission_step4_detail.adm4de_area_id = base_area.area_id
        LEFT JOIN base_faculty ON front_admission_step4_detail.adm4de_fc_id = base_faculty.fc_id
        LEFT JOIN base_university ON front_admission_step4_detail.adm4de_un_id = base_university.un_id
        LEFT JOIN base_major ON adm4de_mj_id = base_major.mj_id
        LEFT JOIN base_project ON adm4de_pj_id = base_project.proj_id
        WHERE adm4de_active LIKE 'Y' AND front_admission_step4.adm4_id = {$res['step5']->adm4_id}
        ORDER BY front_admission_step4_detail.adm4de_seq ASC;");

        $sql = "SELECT * 
        FROM base_admission_round
        WHERE ar_active ='Y' AND ar_is_open = 1 AND ar_mn_id = ? AND ar_id = ?";
        $res['round_is_open']  = $this->pidb->query($sql, array($mn_id, $ar_id))->row();

        $sql = "SELECT * FROM base_education_level
              WHERE el_active = 'Y' AND el_id = ?";
        $res['education_level'] = $this->pidb->query($sql, array($res['round_is_open']->ar_el_id))->row();

      $html = $this->load->view('member/payment_slip_pdf.php',$res, true);
      
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->WriteHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
      $mpdf->WriteHTML($html);
      ob_end_clean();//End Output Buffering
      $mpdf->Output('ใบชำระเงินค่าสมัคร.pdf','I');
    }
    
  }

?>

<style>
body{
    font-family: "thsarabun";
    font-size: 11pt;
}
table {
  border-collapse: collapse;
}   
 

</style>
<head>
        <title>ใบแจ้งชำระเงินค่าสมัคร</title>
</head>
<body>
    <div>
        <table  style="width:100%; margin:0px;padding:0px;">
            <tbody>
                <tr>
                    <td style="text-align:left;">
                        <!--<img class="rounded mr-3" src="<?php echo base_url('assets/img/logo/pi-logo.png');?>" style="height:120px; width:70px; margin:10px;">-->
                        <img class="rounded mr-3" src="/var/www/html/admission/frontend/assets/img/logo/pi-logo.png" style="height:120px; width:70px; margin:10px;">
                    </td>
                    <td>
                        <span style="font-size:12pt; margin:0px;"><strong><?php echo $step5->dp_name_th??'สถาบันพระบรมราชชนก' ?></strong></span>
                        <br>
                        <span style="font-size:11pt; margin:0px;">ใบแจ้งชำระเงินค่าสมัครรอบที่ <?php echo $round_is_open->ar_seq. " " . $round_is_open->ar_name; ?></span>
                        <br>
                        <span style="font-size:11pt; margin:0px;"> Statement of Enrollment Account / Invoice </span>
                        <br>
                        <span style="font-size:11pt; margin:0px;">TAX ID No. 0994002535497</span>
                    </td>
                    <td style="text-align:right; font-size:11pt;width:45%;">
                        <span>[ทป.010]</span>
                        <br>
                        <span>เลขที่ใบแจ้งหนี้ <?php echo $step5->adm5_index??'-';?></span>
                        <br>
                        <span>ปีการศึกษา <?php echo $step5->mn_year??'-'; ?> <?php echo $step5->mn_round??'-';?></span>
                        <br>
                        <span>วันที่พิมพ์ใบชำระเงิน <?php echo fullDate2(date('Y-m-d'));?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <table  style="width:100%; margin-top:15px;padding:0px;">
            <tbody>
                <tr>
                    <td style="text-align:left;">
                        <span style="font-size:11pt;">เลขบัตรประชาชน : <?php echo $member['member_identification']??'-';?></span>
                    </td>
                    <td style="text-align:right;">
                        <?php if ($member) { ?>
                            <span style="font-size:11pt;">ชื่อ-สกุล: <?php echo $member['member_prefix'].$member['member_fname'].' '.$member['member_lname'];?></span>
                        <?php }?>
                    </td>
                </tr>
            </tbody>
        </table>

        <table border="1" style="width:100%; margin-top:15px;padding:0px;">
            <thead>
                <tr>
                    <td style="width:10%; font-size:11pt;"><center>ลำดับ</center></td>
                    <td colspan="2" style="font-size:11pt;"><center>รายการ</center></td>
                    <td style="width:15%; font-size:11pt;"><center>จำนวนเงิน</center></td>
                </tr>
            </thead>
            <tbody>
                <tr >
                    <td style="font-size: 11pt; height:100px; vertical-align: top; padding: 10px;"><center>1.</center></td>
                    <td style="font-size: 11pt; vertical-align: top; padding: 10px;" colspan="2">
                        <!-- <span style="font-size:11pt;"><b></b></span> -->
                        <!-- <br> -->
                        <!-- <span style="font-size:11pt;"><?php echo $step5->md_name_th??'-'; ?></span> -->
                        <!-- <span style="font-size:11pt;">ค่าสมัคร คณะพยาบาลศาสตร์ สถาบันพระบรมราชชนก กระทรวงสาธารณสุข</span> -->
                        <!-- <br> -->
                        <!-- <span style="tab-size: 11;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $step5->mg_name_th??' -'; ?></span> -->
                        <!-- <br> -->
                        <!-- <span style="tab-size: 11;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;จังหวัด<?php echo $step5->pv_name_th??'-' ?></span> -->

                        <?php
                        // pre($detail_admissions->result());
                           
                            if($detail_admissions->num_rows() > 0){
                                    echo '<span style="font-size: 11pt;">ค่าสมัคร' . $education_level->el_name . "&nbsp;" . $detail_admissions->row()->fc_name_th . "&nbsp;" .'<br></span>';

                                foreach($detail_admissions->result() as $key=>$row){
                                    echo '<span style="font-size: 11pt;">อันดับที่&nbsp;' . ($key+1) . ".&nbsp;" . $row->proj_name . "<br>" . $row->mj_name.' '. $row->un_name  . '<br><br></span>';
                                }
                            }
                        ?>
                    </td>
                    <td style="font-size: 11pt; vertical-align: top; padding: 10px;">
                        <center><?php echo $step5->config_money??'ไม่ระบุ';?></center>
                    </td>
                </tr>
                <tr>
                    <td style="border-right:0px solid; padding-left: 10px;">
                        <span style="tab-size: 11; font-size:11pt;">จำนวนเงิน</span>
                    </td>
                    <td colspan="" style="height:40px;border-left:0px solid;">
                        <span style="tab-size: 11; font-size:11pt;"><?php echo $step5->config_money_word??'-'; ?></span>
                    </td>
                    <td style="font-size:11pt; width:20%;"><center>รวม</center></td>
                    <td style="font-size:12pt;"><center><?php echo $step5->config_money??'ไม่ระบุ';?></center></td>
                </tr>
                <tr>
                  <td colspan="2" style="height:110px; vertical-align: top; padding: 10px;">
                      <span style="font-size:11pt;">กำหนดชำระเงินระหว่างวันที่ <?php echo $calendar->cld_date_text??'วันที่ ไม่ระบุ';?></span>
                      <br>
                      <span style="font-size: 12pt;">การชำระเงินจะสมบูรณ์ เมื่อทางสถาบันได้รับการยืนยัน</span>
                      <br>
                      <span style="font-size: 12pt;">การชำระเงินจากธนาคารและมีเจ้าหน้าที่ธนาคารลงนามและประทับตราเรียบร้อยเท่านั้น</span>
                  </td>
                  <td style="font-size: 11pt; vertical-align: middle;" colspan="2">
                      <center>
                          <br>
                          <p>ผู้รับเงิน....................................................</p>
                          <br>
                          <p>วันที่.........................................................</p>
                          <p>สำหรับเจ้าหน้าที่ธนาคาร</p>
                          <p>(ลงลายมือชื่อและประทับตรา)</p>
                      </center>
                  </td>
                </tr>
            </tbody>
        </table>
        <div style="text-align:center; margin:15px;">
            <span style="font-size: 12pt;">พับ - ฉีกตามรอยประ ----------------------------------------------------------------------------------------------------------------------------------------------------------------</span>
        </div> 
        <table border="1" style="width:100%; margin-top:15px;padding:0px;">
          <tr style="border-bottom:0px solid;">
            <td style="text-align:center; width:10%; border-right:0px solid; border-bottom:0px solid;" >
                <!--<img class="rounded mr-3" src="<?php echo base_url('/assets/img/logo/pi-logo.png');?>" style="height:110px; width:70px;margin:10px;">-->
                <img class="rounded mr-3" src="/var/www/html/admission/frontend/assets/img/logo/pi-logo.png" style="height:110px; width:70px;margin:10px;">
            </td>
            <td style="width:40%;border-left:0px solid; border-bottom:0px solid;" colspan="2">
                <span style="font-size: 11pt;"><?php echo $step5->dp_name_th??'สถาบันพระบรมราชชนก' ?></span>
                <br>
                <span style="font-size: 11pt;">ใบแจ้งชำระเงินค่าสมัคร</span>
                <br>
                <span style="font-size: 11pt;">ชื่อบัญชี "<?php echo $step5->account_name??'ไม่ระบุ';?>"</span>
                <br>
                <span style="font-size: 11pt;"><?php echo $step5->bank_name.' '??'ไม่ระบุธนาคาร ';?><?php echo $step5->bank_comp_code??'';?></span>
            </td>
            <td style="width:36%; vertical-align: top; border-right:0px solid; border-bottom:0px solid; padding-left: 10px; padding-top: 4px;">
                    <br>
                    <p style="font-size: 11pt;">Name / ชื่อ : <?php echo $member['member_prefix'].$member['member_fname'].' '.$member['member_lname'];?></p>
                    <p style="font-size: 11pt;">Ref.1 เลขบัตรประชาชน :  ID<?php echo $member['member_identification']??'-';?></p>
                    <p style="font-size: 11pt;">Ref.2 เลขที่ใบแจ้งหนี้ : <?php echo $step5->adm5_index??'-';?></p>
            </td>
            <td style="width:12%; vertical-align: top; text-align:right; border-left:0px solid; border-bottom:0px solid;">
                 <span style="font-size: 11pt;">(สำหรับธนาคาร)</span>
            </td>
          </tr>
          <tr style="border-top:0px solid;">
            <td colspan="3" style="border-top:0px solid; text-align:center;">
                <span style="font-size: 11pt;">สาขา........................................... วันที่.......................................</span>
            </td>
            <td style="border-top:0px solid;" colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center; width:25%;" >
                <span  style="font-size: 11pt;">เงินสด</span>
            </td>
            <td style="text-align:center; width:25%;">
                <span  style="font-size: 11pt;"><?php echo $step5->config_money_word??'-'; ?></spa