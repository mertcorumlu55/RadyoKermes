<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 09/05/2018
 * Time: 12:48
 */

?>
<body class="app">

<!-- @Page Loader -->
<!-- =================================================== -->
<div id="loader" class="fadeOut">
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>

<!-- @App Content -->
<!-- =================================================== -->
<div>
<?php include 'sidebar.php'?>
    <!-- #Main ============================ -->
    <div class="page-container">
        <!-- ### $Topbar ### -->

        <?php include 'navbar.php'?>
