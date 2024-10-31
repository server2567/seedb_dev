<style>
    /* Fonts */

    /* Family */
    h1 {
        font-family: 'Julius Sans One', sans-serif;
    }

    h2 {
        /* Contact, Skills, Education, About me, Work Experience */
        font-family: 'Archivo Narrow', sans-serif;
    }

    h3 {
        /* Accountant */
        font-family: 'Open Sans', sans-serif;
    }

    .jobPosition span,
    .projectName span {
        font-family: 'Source Sans Pro', sans-serif;
    }

    .upperCase {
        text-transform: uppercase;
    }

    .smallText,
    .smallText span,
    .smallText p,
    .smallText a {
        font-family: 'Source Sans Pro', sans-serif;
        text-align: justify;
    }

    /* End Family */

    /* Colors */
    h1 {
        color: #111;
    }

    .leftPanel,
    .leftPanel a {
        color: #bebebe;
        text-decoration: none;
    }

    .leftPanel h2 {
        color: white;
    }

    /* End Colors */

    /* Sizes */
    h1 {
        font-weight: 300;
        font-size: 1.2cm;
        transform: scale(1, 1.15);
        margin-bottom: 0.2cm;
        margin-top: 0.2cm;
        text-transform: uppercase;
    }

    h2 {
        margin-top: 0.1cm;
        margin-bottom: 0.1cm;
    }

    .leftPanel,
    .leftPanel a {
        font-size: 0.38cm;
    }

    .projectName span,
    .jobPosition span {
        font-size: 0.35cm;
    }

    .smallText,
    .smallText span,
    .smallText p,
    .smallText a {
        font-size: 0.35cm;
    }

    .leftPanel .smallText,
    .leftPanel .smallText,
    .leftPanel .smallText span,
    .leftPanel .smallText p,
    .smallText a {
        font-size: 0.45cm;
    }

    .contactIcon {
        width: 0.5cm;
        text-align: center;
    }

    p {
        margin-top: 0.05cm;
        margin-bottom: 0.05cm;
    }

    /* End Sizes */

    .bolded {
        font-weight: bold;
    }

    .white {
        color: white;
    }

    /* End Fonts */

    /* Layout */
    body {
        background: rgb(204, 204, 204);
        width: 21cm;
        height: 29.7cm;
        margin: 0 auto;
    }

    /* Printing */
    page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
    }

    page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
    }

    @page {
        size: 21cm 29.7cm;
        padding: 0;
        margin: 0mm;
        border: none;
        border-collapse: collapse;
    }

    /* End Printing */

    .container {
        display: flex;
        flex-direction: row;
        width: 100%;
        height: 100%;
    }

    .leftPanel {
        width: 27%;
        background-color: #484444;
        padding: 0.7cm;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .rightPanel {
        width: 50%;
        padding: 0.7cm;
        background-color: red;
        overflow: hidden;
    }

    /* .leftPanel img {
        width: 4cm;
        height: 4cm;
        margin-bottom: 0.7cm;
        border-radius: 50%;
        border: 0.15cm solid white;
        object-fit: cover;
        object-position: 50% 50%;
    } */

    .leftPanel .details {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .skill {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .bottomLineSeparator {
        border-bottom: 0.05cm solid white;
    }

    .yearsOfExperience {
        width: 1.6cm;
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .alignleft {
        text-align: left !important;
        width: 1cm;
    }

    .alignright {
        text-align: right !important;
        width: 0.6cm;
        margin-right: 0.1cm
    }

    .workExperience>ul {
        list-style-type: none;
        padding-left: 0;
    }

    .workExperience>ul>li {
        position: relative;
        margin: 0;
        padding-bottom: 0.5cm;
        padding-left: 0.5cm;
    }

    .workExperience>ul>li:before {
        background-color: #b8abab;
        width: 0.05cm;
        content: '';
        position: absolute;
        top: 0.1cm;
        bottom: -0.2cm;
        /* change this after border removal */
        left: 0.05cm;
    }

    .workExperience>ul>li::after {
        content: '';
        position: absolute;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' aria-hidden='true' viewBox='0 0 32 32' focusable='false'%3E%3Ccircle stroke='none' fill='%23484444' cx='16' cy='16' r='10'%3E%3C/circle%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        left: -0.09cm;
        top: 0;
        width: 0.35cm;
        height: 0.35cm;
    }

    .jobPosition {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .item {
        padding-bottom: 0.7cm;
        padding-top: 0.7cm;
    }

    .item h2 {
        margin-top: 0;
    }

    .lastParagrafNoMarginBottom {
        margin-bottom: 0;
    }

    .workExperience>ul>li ul {
        padding-left: 0.5cm;
        list-style-type: disc;
    }

    .profile_img {
        border: 1px solid white;
    }

    /*End Layout*/
</style>
<!DOCTYPE html>
<html>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow&family=Julius+Sans+One&family=Open+Sans&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <page size="A4">
        <div class="container">
            <div class="leftPanel" style="height:100%">
                <img class="profile_img" src="https://img2.pic.in.th/pic/covid19-healthcare-workers-pandemic-concept-confident-smiling-asian-nurse-scrubs-standing-selfassured-cross-arms-chest-professional-doctor-ready-surgery-standing-white-background.jpeg" />
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อมูลส่วนตัว</h2>
                <div>
                    ที่อยู่:
                </div>
                <div>
                    ตำบล:
                </div>
                <div>
                    จังหวัด:
                </div>
                <div>
                    วันเกิด:
                </div>
                <div>
                    อายุ:
                </div>
                <div>
                    เพศ:
                </div>
                <div>
                    สถานภาพ:
                </div>
                <div>
                    สัญชาติ:
                </div>
                <div>
                    ศาสนา:
                </div>
                <hr>
                <h2>&nbsp;&nbsp;&nbsp;ช่องทางการติดต่อ</h2>
                <div style="margin-top: 10px;">
                    <span style="font-family: fontawesome;">
                        <span style="font-size: 24px;">&#xf095;</span>
                    </span>
                    &nbsp;&nbsp;&nbsp;095-252-5512
                </div>
                <div style="margin-top: 10px;">
                    <span style="font-family: fontawesome;">
                        <span style="font-size: 24px;">&#xf0e0;</span>
                    </span>
                    &nbsp;&nbsp;nures.ptt@gmail.com
                </div>
                <hr>
                <h2>&nbsp;&nbsp;&nbsp;ประวัติการศึกษา</h2>
                <div style="margin-top: 10px;">
                    <b>2561 - 2562</b> <br>
                    หลักสูตรผู้ช่วยพยาบาล <br>
                    คณะพยาบาลศาสตร์ <br>
                    มหาวิทยาลัย.... <br>
                </div><br>
                <div style="margin-top: 10px;">
                    <b> 2556 - 2560</b><br>
                    สำเร็จการศึกษาระดับปริญญาตรี <br>
                    สาขาการจัดการทั่วไป <br>
                    มหาวิทยาลัย....
                </div>
            </div>
            <div class="rightPanel">
                asdasd
            </div>
        </div>
    </page>
</body>

</html>