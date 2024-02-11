<?php

require('init.php');
require('functions.php');

$error = '';
$success = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!empty($_FILES['uploadFile']['tmp_name'])) {

    $file_tmp_name = $_FILES["uploadFile"]["tmp_name"];
    $file_name = $_FILES["uploadFile"]["name"];
    $file_content = file_get_contents($file_tmp_name);
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // PROCESS THE FILE AND POST CONTENT ✉

    // Max size of file - 2Mo
    $maxUploadSize = 2000000;

    if ($_FILES['uploadFile']['size'] <= $maxUploadSize) {

      // Array of valid extension
      $validExt = ['csv', 'json'];

      if (in_array($file_extension, $validExt)) {

        if ($file_extension == 'csv') {

          $validFile = csvFileConverter($file_content);
          //var_dump($validFile);
          $result = fileValidator($validFile);
          
          if($result) {
            $success = SUCCESS_SUBMIT_FILE;
          }

        } else {
          $validFile = $file_content;
          //var_dump($validFile);
          $result = fileValidator($validFile);
          
          if($result === false) {
            $error = ERROR_FIELDS;
          }
        }
      } else {
        $error = ERROR_FORMAT_FILE;
      }
    } else {
      $error = ERROR_SIZE_FILE;
    }
  } else {
    $error = ERROR_EMPTY_FIELD;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <title>Upload your file</title>
</head>

<body>
  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32">
        <use xlink:href="#bootstrap"></use>
      </svg>
      <span class="fs-4">Upload File</span>
    </a>

    <ul class="nav nav-pills">
      <li class="nav-item me-2"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
    </ul>
  </header>

  <main class="form-signin w-100 m-auto text-center p-5">

    <form action="index.php" method="post" enctype="multipart/form-data">
      <h1 class="h3 mb-3 fw-normal">Choose a file and submit it</h1>

      <div class="text-center">
        <p for="floatingInput">Accepted format (csv or json) - Max size: 2Mb</p>
      </div>
      <div class="form-floating w-25 mx-auto">
        <input type="file" class="form-control" name="uploadFile" id="floatingInput">
      </div>

      <div class="bg-danger text-white w-25 mx-auto mt-3 rounded-2">
        <?= ($error != '') ? htmlspecialchars($error) : '' ?>
      </div>
      <div class="bg-success text-white w-25 mx-auto mt-3 rounded-2">
        <?= ($success != '') ? htmlspecialchars($success) : '' ?>
      </div>

      <button class="btn btn-primary mt-3" type="submit">Submit</button>
    </form>

    <div class="bg-dark text-white w-25 mx-auto mt-3 rounded-2">      
        <?= ($result != '') ? htmlspecialchars('API Response : '.$result) : '' ?>      
    </div>

  </main>

  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted ms-2">© 2022 Laurent GUIGUES</p>

  </footer>
</body>

</html>