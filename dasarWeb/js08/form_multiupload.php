<html>
    <head>
        <title>File Upload</title>
    </head>
    <body>
        <h2>Unggah Dokumen</h2>
        <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple="multiple" accept=".jpg, .png, .jpeg" />
            <input type="submit" name="Unggah" />
        </form>
    </body>
</html>