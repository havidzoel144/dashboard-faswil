<!DOCTYPE html>
<html>

<head>
  <title><?= $file_name ?></title>
  <style>
    body {
      font-family: Arial;
    }

    .header {
      margin-bottom: 10px;
    }

    iframe {
      border: none;
    }
  </style>
</head>

<body>
  <?php if ($ext === 'pdf'): ?>

    <!-- PDF langsung -->
    <iframe src="<?= $file_url ?>" width="100%" height="700px"></iframe>

  <?php elseif (in_array($ext, ['doc', 'docx'])): ?>

    <!-- Microsoft Office Viewer -->
    <iframe
      src="https://view.officeapps.live.com/op/embed.aspx?src=<?= urlencode($file_url) ?>"
      width="100%"
      height="700px">
    </iframe>

    <!-- Alternatif Google Viewer -->
    <iframe
      src="https://docs.google.com/gview?url=<?= urlencode($file_url) ?>&embedded=true"
      width="100%"
      height="700px">
    </iframe>


  <?php else: ?>

    <p>Preview tidak tersedia. <a href="<?= $file_url ?>">Download file</a></p>

  <?php endif; ?>

</body>

</html>