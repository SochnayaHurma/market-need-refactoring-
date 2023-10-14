<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            
            <li class="breadcrumb-item">
                <a href="<?= baseUrl();?>"><i><i class="fas fa-home"></i></i></a>
            </li>
            <li class="breadcrumb-item">
                <?= __('wishlist_index_title');?>
            </li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= __('wishlist_index_title')?></h3>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>

                <?php else: ?>
                    <p><?php __('wistlist_index_not_found'); ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>