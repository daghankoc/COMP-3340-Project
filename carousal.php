<?php
    //get the product visuals to show
    $productVisuals = $db->getProductVisuals($product['id']);
?>

<style>
    .product-visual-viewer {
        margin-top: 20px;
    }

    .product-visual video,
    .product-visual img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .product-visual-controls {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }
    
    .next-button {
        padding: 6px 14px;
        border: 1px solid #999;
        font-size: 18px;
    }
</style>

<div class="product-visual-viewer">
    <?php if (count($productVisuals) > 0): ?>
        <div class="product-visuals">
            <?php foreach ($productVisuals as $index => $visual): ?>
                <div class="product-visual" data-visual-index="<?= $index ?>" <?= $index !== 0 ? 'hidden' : '' ?>>
                    <?php if ($visual['type'] === 'video'): ?>
                        <video controls>
                            <source src="<?= $visual['src'] ?>">
                        </video>
                    <?php else: ?>
                        <img src="<?= $visual['src'] ?>" alt="product visual <?= $index + 1 ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="product-visual-controls">
            <button type="button" id="previous-visual" class="next-button" <?= count($productVisuals) < 2 ? 'disabled' : '' ?>><</button>
            <button type="button" id="next-visual" class="next-button"<?= count($productVisuals) < 2 ? 'disabled' : '' ?>>></button>
        </div>
    <?php else: ?>
        <p>No product visuals available.</p>
    <?php endif; ?>
</div>
<script src="carousal.js"></script>