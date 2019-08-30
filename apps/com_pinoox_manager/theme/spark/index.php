<!doctype html>
<html lang="<?php echo app('lang'); ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?php echo $_url; ?>dist/<?php echo @$assets['css']; ?>">
    <script src="<?php echo url(); ?>dist/pinoox.js?v1.3"></script>

    <title>پینوکس</title>
</head>

<body class="<?php echo @$_direction; ?>">

<div id="app"></div>

<script src="<?php echo $_url; ?>dist/<?php echo @$assets['js']; ?>"></script>
</body>
</html>