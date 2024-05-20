<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
include 'admin/db_connect.php';
include 'topbar.php';
?>

<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
    <div class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Categories</div>
                            <div class="card-body">
                                <ul class='list-group' id='cat-list'>
                                    <li class='list-group-item' data-id='all' data-href="index.php?page=auctionhome&category_id=all">All</li>
                                    <?php
                                    $cat = $conn->query("SELECT * FROM auction_categories ORDER BY name ASC"); // fixed SQL syntax
                                    while ($row = $cat->fetch_assoc()) :
                                        $cat_arr[$row['id']] = $row['name'];
                                    ?>
                                        <li class='list-group-item' data-id='<?php echo $row['id'] ?>' data-href="index.php?page=auctionhome&category_id=<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    $cid = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
                                    $where = "";

                                    if ($cid !== "all" && $cid > 0) {
                                        $where  = " and category_id = $cid ";
                                    }

                                    $currentTime = strtotime(date("Y-m-d H:i"));
                                    $query = "SELECT * FROM auction_products WHERE unix_timestamp(bid_end_datetime) >= $currentTime $where ORDER BY name ASC";
                                    $cat = $conn->query($query);

                                    if ($cat->num_rows <= 0) {
                                        echo "<center><h4><i>No Available Product.</i></h4></center>";
                                    }
                                    while ($row = $cat->fetch_assoc()) :
                                    ?>
                                        <div class="col-sm-4">
                                            <div class="card">
                                                <div class="card-header p-1">
                                                    <span class="badge badge-pill badge-primary text-white ml-3"><i class="fa fa-tag"></i> <?php echo number_format($row['start_bid']) ?></span>
                                                </div>
                                                <div class="card-body">
                                                    <img src="assets/uploads/<?php echo $row['img_fname'] ?>" class="img-fluid" alt="Card image cap">
                                                    <div class="text-center">
                                                        <p class="badge badge-pill badge-warning text-white"><i class="fa fa-hourglass-half"></i> <?php echo date("M d,Y h:i A", strtotime($row['bid_end_datetime'])) ?></p>
                                                    </div>
                                                    <p class="m-0"><?php echo $row['name'] ?></p>
                                                    <p class="text-sm m-0"><?php echo $cat_arr[$row['category_id']] ?></p>
                                                    <p class="truncate m-0"><?php echo ucwords($row['description']) ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="view_aucprod.php?id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm view_prod" type="button"> View </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    $('#cat-list li').click(function() {
        location.href = $(this).attr('data-href');
    })
    $('#cat-list li').each(function() {
        var id = '<?php echo $cid > 0 ? $cid : 'all' ?>';
        if (id == $(this).attr('data-id')) {
            $(this).addClass('active');
        }
    })
    $('.view_prod').click(function() {
        uni_modal_right('View Product', 'view_aucprod.php?id=' + $(this).attr('data-id'));
    })
</script>