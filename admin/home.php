<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
        <div class="row">
        <!-- /.col -->
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-gem"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Product</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM products")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pending Orders</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM orders where status = 0")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Shipped Orders</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM orders where status = 2")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Delivered Orders</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM orders where status = 3")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-chart-line"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Sales</span>
            <span class="info-box-number">
                <?php
                $result = $conn->query("SELECT SUM(order_items.price) as total_sales FROM orders JOIN order_items ON orders.id = order_items.order_id WHERE orders.status = 3");
                $row = $result->fetch_assoc();
                echo $row["total_sales"];
               ?>
            </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
      <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type = 2")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="info-box">
    
    <div class="info-box-content">
        <span class="info-box-text">Monthly Sales</span>
        <span class="info-box-number">
            <canvas id="sales-chart" style="height: 250px; width: 542px;" width="542" height="250"></canvas>
        </span>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("sales-chart").getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Monthly Sales',
                data: [
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $month = date('m', mktime(0, 0, 0, $i, 1, date('Y')));
                        $result = $conn->query("SELECT SUM(order_items.price) as total_sales FROM orders JOIN order_items ON orders.id = order_items.order_id WHERE orders.status = 3 AND MONTH(orders.date_created) = '$month'");
                        $row = $result->fetch_assoc();
                        echo $row["total_sales"] . ',';
                    }
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-folder"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Documents</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM documents  where user_id = {$_SESSION['login_id']}")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
      
          
<?php endif; ?>
