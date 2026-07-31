<?php
    include 'header.php';
    include 'lib/database.php';

    $db = new Database();

    //auth check
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }

    //add product post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //variables post 
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Turn the product name into a folder-safe name. use regex and to lowercase
        $folderName = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $name));

        //create paths
        $folderPath = __DIR__ . '/images/' . $folderName . '/';
        $databaseFolder = './images/' . $folderName . '/';

        //create if folder doesnt exist
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Upload cover image. use regex and to lowercase to name
        $coverFileName = preg_replace('/[^a-zA-Z0-9._-]+/','-', basename($_FILES['cover_image']['name']));
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $folderPath . $coverFileName);
        $coverImage = $databaseFolder . $coverFileName;

        // Upload additional product images and videos.
        $visuals = [];
        foreach ($_FILES['visuals']['name'] as $index => $originalName) {

            //regex search and replace
            $visualFileName = preg_replace('/[^a-zA-Z0-9._-]+/','-', basename($originalName));

            //move uploaded file from temp to correct place using php built in
            move_uploaded_file($_FILES['visuals']['tmp_name'][$index], $folderPath . $visualFileName);

            //extract file type
            $fileType = $_FILES['visuals']['type'][$index];

            //check if video
            if (str_starts_with($fileType, 'video/')) {
                $visualType = 'video';
            } else {
                $visualType = 'image';
            }
            //build the visuals array
            $visuals[] = ['src' => $databaseFolder . $visualFileName, 'type' => $visualType];
        }

        //add the product db call
        $db->addProduct($name,$description,$price,$coverImage,$visuals);

        //redirect to admin
        echo "<script>window.location.href = 'admin.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create New Product</title>
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Create new product page for the store">
    <meta name="keywords" content="minipc, admin, product">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <div class="add-product-form-container">
        <form class="add-product-form" method="post" action="product-add.php" enctype="multipart/form-data">
            <a class="" href="admin.php">< Go Back to Admin Page</a>

            <h1>Add Product</h1>

            <label for="name">Product name</label>
            <input type="text" id="name" name="name" maxlength="100" required>
            <br><br>

            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
            <br><br>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" min="0" step="1" required>
            <br><br>

            <label for="cover_image">Cover image</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required >
            <br><br>

            <label for="visuals">Product images and videos</label>
            <p>Add more than one image or video</p>
            <input type="file" id="visuals" name="visuals[]" accept="image/*,video/*" multiple >
            <br><br>

            <input type="submit" class="admin-add-button" value="Add Product">
        </form>
    </div>
</body>

</html>

<?php include 'footer.php'; ?>