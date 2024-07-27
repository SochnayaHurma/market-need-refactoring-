<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= ___('tpl_checkout_mail_title_admin')?></h1>
    <table style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_product')?></th>
                <th style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_qty')?></th>
                <th style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_price')?></th>
                <th style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_sum')?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($_SESSION['cart'] as $item):?>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['title']?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['qty']?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['price']?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['price'] * $item['qty']?></td>
                </tr>
            <?php endforeach;?>
                <tr>
                    <td colspan="3" style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_total_qty')?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $_SESSION['cart.qty']?></td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 8px; border: 1px solid #ddd;"><?= ___('tpl_cart_sum')?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $_SESSION['cart.sum']?></td>
                </tr>
        </tbody>
    </table>
    <p><?= ___('tpl_checkout_mail_message_admin')?></p>
</body>
</html>