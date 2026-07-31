<?php
    require_once 'lib/database.php';
    include 'header.php';

    //auth check
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }

    $db = new Database();

    //get the products
    $productId = $_GET['id'] ?? $_POST['id'] ?? null;
    $product = $db->getProduct($productId);

    //if no product is chosen to edit go to admin
    if (!$product) {
        echo "<script>window.location.href = 'admin.php';</script>";
        exit;
    }

    //post edit product
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //get the form variables
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        //clean the product name to make it safe to folder name
        $folderName = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $name));

        //fallback folder name
        if ($folderName === '') {
            $folderName = 'product-' . $productId;
        }

        //create paths
        $folderPath = __DIR__ . '/images/' . $folderName . '/';
        $databaseFolder = './images/' . $folderName . '/';

        //create folder if not there
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Keep the current cover image by default.
        $coverImage = $product['cover_image'];

        // Replace the cover image when a new one is uploaded.
        if (isset($_FILES['cover_image']) ) {
            //clean using regex
            $coverFileName = preg_replace('/[^a-zA-Z0-9._-]+/','-', basename($_FILES['cover_image']['name']));
            //move the file from temp to path
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $folderPath . $coverFileName);
            $coverImage = $databaseFolder . $coverFileName;
        }

        //db call update product
        $db->updateProduct($productId,$name,$description,$price,$coverImage);

        // if remove visuals not empty remove them
        if (!empty($_POST['remove_visuals'])) {
            foreach ($_POST['remove_visuals'] as $visualId) {
                $db->deleteProductVisual($visualId, $productId);
            }
        }

        // Add newly uploaded visuals.
        $visuals = [];
        //if newly uploaded visuals set
        if (isset($_FILES['visuals'])) {
            foreach ($_FILES['visuals']['name'] as $index => $originalName) {
                //regex search and replace
                $visualFileName = preg_replace('/[^a-zA-Z0-9._-]+/', '-', basename($originalName));

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
        }

        //db call to add visuals
        $db->addProductVisuals($productId, $visuals);

        //redirect
        $redirectUrl = 'product.php?id=' . urlencode($productId);
        echo '<script>window.location.href = ' . json_encode($redirectUrl) . ';</script>';
        exit;
    }

    //get the product visuals
    $productVisuals = $db->getProductVisuals($productId);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Edit product page for the store">
    <meta name="keywords" content="minipc, admin, product">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
</head>

<body>
<div class="add-product-form-container">

    <form class="add-product-form" method="post" action="product-edit.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <a href="admin.php"> < Go Back to Admin Page</a>

        <h1>Edit Product</h1>

        <label for="name">Product name</label>
        <input type="text" id="name" name="name" maxlength="100" required value="<?= $product['name'] ?>">
        <br><br>

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= $product['description'] ?></textarea>
        <br><br>

        <label for="price">Price</label>
        <input type="number" id="price" name="price" min="0" step="0.01" required value="<?= $product['price'] ?>">
        <br><br>

        <p>
            Current rating:
            <?= $product['rating'] ?>
        </p>

        <label>Current cover image</label>
        <br>

        <img src="<?= $product['cover_image'] ?>" alt="Current cover image" width="200" >
        <br><br>

        <label for="cover_image">Replace cover image</label>
        <input type="file" id="cover_image" name="cover_image" accept="image/*">
        <br><br>

        <h2>Current product visuals</h2>

        <?php if (count($productVisuals) > 0): ?>
            <?php foreach ($productVisuals as $visual): ?>
                <div>
                    <?php if ($visual['type'] === 'video'): ?>
                        <video width="200" controls>
                            <source src="<?= $visual['src'] ?>">
                        </video>
                    <?php else: ?>
                        <img src="<?= $visual['src'] ?>" alt="Product visual" width="200" >
                    <?php endif; ?>

                    <label>
                        <input type="checkbox" name="remove_visuals[]" value="<?= $visual['id'] ?>">
                        Remove
                    </label>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No additional visuals.</p>
        <?php endif; ?>
        <br>

        <label for="visuals">Add product images and videos</label>
        <input type="file" id="visuals" name="visuals[]" accept="image/*,video/*" multiple >
        <div id="selectedvisuals"></div>
        <br><br>

        <input type="submit" class="admin-add-button" value="Update Product">
    </form>
</div>
<script src="uploadedFiles.js"></script>
</body>
</html>


<?php include 'footer.php'; ?>