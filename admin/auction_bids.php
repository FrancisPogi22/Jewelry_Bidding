<?php include('db_connect.php'); ?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                
            </div>
        </div>
        <div class="row">
            <!-- FORM Panel -->
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <b>List of Bids</b>
                                            <span class="float:right">
                                                <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=manage_bid" id="new_bid">
                                                    <i class="fa fa-plus"></i> New Entry
                                                </a>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-condensed table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="">Name</th>
                                                        <th class="">Product</th>
                                                        <th class="">Amount</th>
                                                        <th class="">Status</th>
                                                        <th class="">Date & Time</th>
                                                        <th class=""></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?php
// Execute SQL query
$qry = $conn->query("SELECT
b.*
FROM
bids b
JOIN(
SELECT product_id,
    MAX(bid_amount) AS highest_bid_amount
FROM
    bids
WHERE
STATUS
= 1
GROUP BY
product_id
) AS highest_bids
ON
b.product_id = highest_bids.product_id AND b.bid_amount = highest_bids.highest_bid_amount
WHERE
b.status = 1");

// Check if the query was successful and if there are any rows returned
if ($qry && $qry->num_rows > 0) {
    // Loop through each row of the result
    $i = 1;
    while ($row = $qry->fetch_assoc()) {
        // Fetch user and product details for each bid
        $user_query = $conn->query("SELECT * FROM users WHERE id = " . $row['user_id']);
        $product_query = $conn->query("SELECT * FROM products WHERE id = " . $row['product_id']);

        // Check if the user query was successful and if there are any rows returned
        if ($user_query && $user_query->num_rows > 0) {
            $user = $user_query->fetch_assoc();
        } else {
            // Error fetching user details or no rows found
            $user = array(); // Set an empty array to avoid null offset warning
        }

        // Check if the product query was successful and if there are any rows returned
        if ($product_query && $product_query->num_rows > 0) {
            $product = $product_query->fetch_assoc();
        } else {
            // Error fetching product details or no rows found
            $product = array(); // Set an empty array to avoid null offset warning
        }

        // Output table row
?>
        <tr>
            <td class="text-center"><?php echo $i++ ?></td>
            <td class="">
                <p><b><?php echo isset($user['firstname']) && isset($user['lastname']) ? ucwords($user['firstname'] . ' ' . $user['lastname']) : '' ?></b></p>
            </td>
            <td class="">
                <p><b><?php 
                    $product_query = $conn->query("SELECT name FROM auction_products WHERE id = " . $row['product_id']);
                    echo $product_query ? (ucwords($product_query->fetch_assoc()['name'] ?? 'Product Not Found')) : '';
                ?></b></p>
            </td>
            <td class="text-right">
                <p><b><?php echo isset($row['bid_amount']) ? number_format($row['bid_amount'], 2) : '' ?></b></p>
            </td>
           <td class="text-center">
										<?php if($row['status'] == 1): ?>
										<?php if(strtotime(date('Y-m-d H:i')) < strtotime($row['status'])): ?>
										<span class="badge badge-secondary">Bidding Stage</span>
										<?php else: ?>
										<span class="badge badge-success">Wins in Bidding</span>
										<?php endif; ?>
										<?php elseif($row['status'] == 2): ?>
										<span class="badge badge-primary">Confirmed</span>
										<?php else: ?>
										<span class="badge badge-danger">Canceled</span>
										<?php endif; ?>
									</td>
                                    
                                    <td><?php echo date('F d, Y - g:i:s A', strtotime($row['date_created'])); ?></td>

            <td>
                <?php if (isset($user['id'])) : ?>
                    <button class="btn btn-primary btn-sm view_user" type="button" data-id='<?php echo $user['id'] ?>'>View Buyer Details</button>
                <?php endif; ?>
            </td>
        </tr>
<?php
    }
} else {
    // No rows found or query failed
    ?>
    <tr><td colspan='6'>No data found</td></tr>
<?php
}
?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    
    td{
        vertical-align: middle !important;
    }
    td p{
        margin: unset
    }
    img{
        max-width:100px;
        max-height: 150px;
    }
</style>

<script>
    $(document).ready(function(){
        $('table').dataTable()
        
        $('.view_user').click(function(){
            uni_modal("<i class'fa fa-card-id'></i> Buyer Details","view_udet.php?id="+$(this).attr('data-id'))
            
        })

        $('#new_book').click(function(){
            uni_modal("New Book","manage_booking.php","mid-large")
            
        })

        $('.edit_book').click(function(){
            uni_modal("Manage Book Details","manage_booking.php?id="+$(this).attr('data-id'),"mid-large")
            
        })

        $('.delete_book').click(function(){
            _conf("Are you sure to delete this book?","delete_book",[$(this).attr('data-id')])
        })
        
        function delete_book($id){
            start_load()
            $.ajax({
                url:'ajax.php?action=delete_book',
                method:'POST',
                data:{id:$id},
                success:function(resp){
                    if(resp==1){
                        alert_toast("Data successfully deleted",'success')
                        setTimeout(function(){
                            location.reload()
                        },1500)
                    }
                }
            })
        }
    })
</script>
