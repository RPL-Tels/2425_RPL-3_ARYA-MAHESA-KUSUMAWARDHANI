<?php
if (isset($_POST['submit'])) {
    $input_image = $_FILES['input_image']['tmp_name'];
    $background_image = $_FILES['background_image']['tmp_name'] ?? null;

    $url = 'http://127.0.0.1:5000/process-image';

    $post_fields = [
        'input_image' => new CURLFile($input_image),
    ];

    if ($background_image) {
        $post_fields['background_image'] = new CURLFile($background_image);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $output_file = 'processed_image.png';

        // Save the response as a file
        file_put_contents($output_file, $response);

        // Send the file to the user for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($output_file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($output_file));
        readfile($output_file);

        // Optionally delete the file after download
        unlink($output_file);
    }

    curl_close($ch);
}
?>
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
    <link rel="stylesheet" type="text/css" href="./css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="./css/Revisi2.css" />
    <script src="script.js"></script>



</head>

<body class="flex-column">

    <main class="revisi2 main">
            <section id="home" class="home">
            <!-- Tombol hamburger -->
            <button class="openbtn" onclick="openNav()">☰</button>

            <!-- Sidebar -->
            <div class="sidebar closed">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <a href="#home">Home</a>
            <a href="#howTo">How To Do It</a>
            <a href="#Feedback">Feedback</a>
            </div>

            <a href="./Admin/login.php" target="_blank" class="logo">
                <img src="./assets/Logo.png" alt="">
            </a>
            <div class="home1">
                <p class="lbl1_box">
                    <span class="lbl1">
                        <span class="lbl1_span0">
                            REMOVE BACKGROUND<br />
                        </span>
                        <span class="lbl1_span1"><br /></span>
                        <span class="lbl1_span2"><br /><br /></span>
                    </span>
                </p>
                <p class="lbl2">Designed to remove photo background with a single click! Don't worry, it's 100% free!</p>
                <a href="gas.php" style="text-decoration: none;">
                    <button class="btnGas">Let’s do it now!</button>
                </a>
            </div>
        </section>


        <section id="howTo" class="howTo">
            <div class="howto">
                <div class="judul">How to do it?</div>
                <div class="step-hapus">
                    <div class="info1">Remove background</div>
                    <p class="desc">
                        Put the photo you want to edit into the drag and drop photo section
                        <br />
                        <br />
              Lalu klik tombol untuk menghapus latar belakang
                        <br />
                        <br />
              If the results are as you want, you can immediately download!
                    </p>
                </div>
                <div class="step-tambah">
                    <div class="info1">Add background</div>
                    <p class="desc">
                        tap the button to add background. you can choose a color background or a photo from your gallery.
                        <br />
                        <br />
              If you choose to add a background from the gallery then input the photo/image you want to add a background to.
                        <br />
                        <br />
              If the results are as you want, you can immediately download!
                    </p>
                </div>
            </div>
        </section>

        <form action="./Admin/proses-backup.php" method="POST">
        <section id ="Feedback">
                <div class="feedback-box">
                    <h1>Feedback</h1>
                    <label for="feedback"></label>
                        <input type="text" name="nama" placeholder="Name/Nickname. . .">
                        <input type="email" name="email" placeholder="Email Address. . .">
                        <textarea type="feedback" name="feedback" placeholder="Type your Feedback. . ."></textarea>
                        <button type="submit" value="submit" name="submit">Submit</button> 
                </div>
            </section>

    </main>

</body>

</html>