<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$view_id = isset($_GET['id']) ? $_GET['id'] : 0;

include 'header.php';
include 'admin/db_connect.php';
include 'topbar.php';

$qry = $conn->query("SELECT
ap.*,
ac.name AS ac_name,
ap.name AS ap_name,
hb.highest_bid,
hb.user_id AS highest_bidder_id
FROM
auction_products ap
JOIN auction_categories ac ON
ap.category_id = ac.id
LEFT JOIN(
SELECT product_id,
    MAX(bid_amount) AS highest_bid,
    user_id
FROM
    bids
WHERE
    product_id = $view_id
GROUP BY
    product_id,
    user_id
ORDER BY
    highest_bid
DESC
LIMIT 1
) hb
ON
ap.id = hb.product_id
WHERE
ap.id = $view_id");
?>

<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
    <div class="wrapper p-3">
        <div class="row d-flex justify-content-center">
            <?php
            $logged_in_user = $_SESSION['login_id'];
            if ($qry && $qry->num_rows > 0) {
                while ($row = $qry->fetch_assoc()) {
                    $img = array();
                    if (isset($row['item_code']) && !empty($row['item_code'])) {
                        if (is_dir('assets/uploads/products/' . $row['item_code'])) {
                            $_fs = scandir('assets/uploads/products/' . $row['item_code']);
                            foreach ($_fs as $k => $v) {
                                if (is_file('assets/uploads/products/' . $row['item_code'] . '/' . $v) && !in_array($v, array('.', '..'))) {
                                    $img[] = 'assets/uploads/products/' . $row['item_code'] . '/' . $v;
                                }
                            }
                        }
                    }
            ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header p-1">
                                <span class="badge badge-pill badge-primary text-white ml-3"><i class="fa fa-tag"></i> <?php echo number_format($row['start_bid']) ?></span>
                            </div>
                            <div class="card-body">
                                <img src="assets/uploads/<?php echo $row['img_fname'] ?>" class="img-fluid d-block m-auto" alt="Card image cap">
                                <div class="text-center">
                                    <p class="badge badge-pill badge-warning text-white"><i class="fa fa-hourglass-half"></i> <?php echo date("M d,Y h:i A", strtotime($row['bid_end_datetime'])) ?></p>
                                </div>
                                <p class="m-0">
                                <p>Product Name: <?php echo $row['ap_name'] ?></p>
                                <p class="truncate m-0"><?php echo $row['description'] ?></p>
                                <p class="text-sm m-0" id="price" data-price="<?php echo $row['regular_price'] ?>">Regular price:<?php echo $row['regular_price'] ?></p>
                                <p class="text-sm m-0" id="highestBidder" data-bid="<?php echo $row['highest_bid'] ?>">Highest Bidder: <?php echo $row['highest_bid'] ?></p>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="button">
                                    <button class="btn btn-primary btn-sm bid-btn" data-product-id="<?php echo $row['id'] ?>">Bid</button>
                                </div>
                                <div class="form-group ml-5 bid-form" style="display: none;">
                                    <div class="d-flex">
                                        <input type="text" class="form-control bid-amount" placeholder="Enter amount">
                                        <button class="btn btn-primary btn-sm submit-bid" data-product-id="<?php echo $row['id'] ?>">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No records found.";
            }
            ?>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#"></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Burgos Online Jewelry Shop</b>
            </div>
        </footer>
    </div>
    <?php include 'footer.php' ?>
</body>

</html>
<script>
    $(document).ready(function() {
        $('.bid-btn').click(function() {
            $('.bid-form').hide();
            let bidForm = $(this).closest('.card-footer').find('.bid-form');

            bidForm.show();
        });

        $('.submit-bid').click(function() {
            let productId = $(this).data('product-id');
            let bidAmount = $(this).closest('.form-group').find('.bid-amount').val();
            let price = $('#price').data('price');
            let userId = <?php echo $logged_in_user; ?>;
            let highestBidder = $('#highestBidder').data('bid')

            if (price > bidAmount) {
                alert("Regular price doesn't meet.");
            } else if (highestBidder >= bidAmount) {
                alert("Bid higher than highest bidder.");
            } else {
                $.ajax({
                    url: 'save_bid.php',
                    type: 'POST',
                    data: {
                        productId: productId,
                        bidAmount: bidAmount,
                        userId: userId
                    },
                    success: function(response) {
                        alert(response);
                        setTimeout(function() {
                            window.location.href = 'auctionhome.php';
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>