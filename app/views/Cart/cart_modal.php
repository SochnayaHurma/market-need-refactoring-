<div class="modal-body">
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="table-responsive cart-table">
            <table class="table text-start">
                <thead>
                    <tr>
                        <th scope="col"><?= __('tpl_cart_photo')?></th>
                        <th scope="col"><?= __('tpl_cart_product')?></th>
                        <th scope="col"><?= __('tpl_cart_qty')?></th>
                        <th scope="col"><?= __('tpl_cart_price')?></th>
                        <th scope="col"><i class="far fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($_SESSION['cart'] as $prod_id => $product): ?>
                        <tr>
                            <td>
                                <a href="product/<?=$product['slug']?>">
                                    <img src="<?=PATH . $product['img'] ?>" alt="">
                                </a>
                            </td>
                            <td><a href="product/<?=$product['slug']?>"><?=$product['title']?></a></td>
                            <td><?=$product['qty']?></td>
                            <td>$<?=$product['price']?></td>
                            <td>
                                <a 
                                    href="cart/delete?id=<?= $prod_id?>"
                                    data-id="<?= $prod_id?>"
                                    class="del-item"
                                ><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td col="4" class="text-end"><?php __('tpl_cart_total_qty');?></td>
                        <td class="cart-qty"><?= $_SESSION['cart.qty']?></td>
                    </tr>
                    <tr>
                        <td col="4" class="text-end"><?php __('tpl_cart_sum');?></td>
                        <td class="cart-sum"><?= $_SESSION['cart.sum']?>$</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h4 class="text-start"><?= __('tpl_cart_empty')?></h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success ripple" data-bs-dismiss="modal"><?= __('tpl_cart_btn_continue')?></button>
    <?php if (!empty($_SESSION['cart'])):?>
        <a href="cart/view" class="btn btn-primary"><?= __('tpl_cart_btn_order')?></a>
        <button id="clear-cart" type="button" class="btn btn-danger"><?= __('tpl_cart_btn_clear')?></button>
    <?php endif; ?>
</div>