<?php
// Include the autoload file for mPDF
require '/var/www/html/seedb/application/third_party/vendor/autoload.php';

// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 12,
    'default_font' => 'sarabun' // Use "Sarabun" for Thai characters
]);

// Fetch any POST data if necessary (e.g., for form fields)
// $courseName = $_POST['course_name'];  // Example of retrieving data from the form

// Your HTML content
$html = '
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>????????????????????????</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table-bordered {
            border: 1px solid black;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
        }
        .form-title {
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: 100%;
            border: none;
            border-bottom: 1px solid black;
            padding: 5px;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .checkbox-container input[type="checkbox"] {
            margin-right: 5px;
        }
        .table-responsive {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
        }
        .form-container {
            border: 2px solid black;
            padding: 20px;
        }
        .no-border-table td {
            border: none !important;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: none;
            resize: none;
            background: repeating-linear-gradient(to bottom,
                    transparent,
                    transparent 25px,
                    black 25px,
                    black 26px);
            line-height: 19px;
            font-family: Arial, sans-serif;
        }
        hr {
            margin: 0;
            padding: 0;
            border: 0;
            color: black;
            border: 2px solid black;
            border-top: 2px solid black;
            position: relative;
            left: -22px;
            width: 103.5%;
        }
    </style>
</head>
<body>
    <div class="container mb-2">
        <h2 class="form-title">???????????????????</h2>
        <div class="form-container">
            <table class="table no-border-table">
                <tbody>
                    <tr>
                        <div class="row">
                            <div class="col-md-2">
                                <b>???????????? :</b>
                            </div>
                            <div class="col-md-10">
                                <input type="text">
                            </div>
                        </div>
                    </tr>
                    <!-- Additional fields here... -->
                </tbody>
            </table>
        </div>
        <!-- Add more sections here -->
    </div>
</body>
</html>
';

// Write the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser as a preview
$mpdf->Output('form.pdf', \Mpdf\Output\Destination::INLINE); // Displays the PDF in the browser
