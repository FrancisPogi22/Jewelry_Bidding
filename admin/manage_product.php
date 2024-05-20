<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM auction_products where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<style>
	
	.jqte_editor{
		min-height: 30vh !important
	}
	#drop {
   	min-height: 15vh;
    max-height: 30vh;
    overflow: auto;
    width: calc(100%);
    border: 5px solid #929292;
    margin: 10px;
    border-style: dashed;
    padding: 10px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
	#uploads {
		min-height: 15vh;
	width: calc(100%);
	margin: 10px;
	padding: 10px;
	display: flex;
	align-items: center;
	flex-wrap: wrap;
	}
	#uploads .img-holder{
	    position: relative;
	    margin: 1em;
	    cursor: pointer;
	}
	#uploads .img-holder:hover{
	    background: #0095ff1f;
	}
	#uploads .img-holder .form-check{
	    display: none;
	}
	#uploads .img-holder.checked .form-check{
	    display: block;
	}
	#uploads .img-holder.checked{
	    background: #0095ff1f;
	}
	#uploads .img-holder img {
		height: 39vh;
    width: 22vw;
    margin: .5em;
		}
	#uploads .img-holder span{
	    position: absolute;
	    top: -.5em;
	    left: -.5em;
	}
	#dname{
		margin: auto 
	}
img.imgDropped {
    height: 16vh;
    width: 7vw;
    margin: 1em;
}
.imgF {
    border: 1px solid #0000ffa1;
    border-style: dashed;
    position: relative;
    margin: 1em;
}
span.rem.badge.badge-primary {
    position: absolute;
    top: -.5em;
    left: -.5em;
    cursor: pointer;
}
label[for="chooseFile"]{
	color: #0000ff94;
	cursor: pointer;
}
label[for="chooseFile"]:hover{
	color: #0000ffba;
}
.opts {
    position: absolute;
    top: 0;
    right: 0;
    background: #00000094;
    width: calc(100%);
    height: calc(100%);
    justify-items: center;
    display: flex;
    opacity: 0;
    transition: all .5s ease;
}
.img-holder:hover .opts{
    opacity: 1;

}
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
button.btn.btn-sm.btn-rounded.btn-sm.btn-dark {
    margin: auto;
}
img#img_path-field{
		max-height: 15vh;
		max-width: 8vw;
	}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form action="" id="manage-product" enctype="multipart/form-data">
					<!-- <input type="hidden" name="action" value="save_product"> -->
					<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
					<h4><b><?php echo !isset($id) ? "New Product" : "Manage Product" ?></b></h4>
					<hr>
					<div class="form-group row">
						<div class="col-md-4">
							<label for="" class="control-label">Name</label>
							<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
						</div>
					
					</div>
					<div class="form-group row">
						<div class="col-md-4">
							<label for="" class="control-label">Category</label>
							<select class="custom-select select2" name="category_id">
								<option value=""></option>
								<?php
								$qry = $conn->query("SELECT * FROM auction_categories order by name asc");
								while($row=$qry->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						
					</div>
					<div class="form-group row">
						<div class="col-md-10">
							<label for="" class="control-label">Description</label>
							<textarea name="description" id="description" class="form-control" cols="30" rows="5" required><?php echo isset($description) ? html_entity_decode($description) : '' ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-4">
							<label for="" class="control-label">Regular Price</label>
							<input type="number" class="form-control text-right" name="regular_price" value="<?php echo isset($regular_price) ? $regular_price : 0 ?>">
						</div>
						<div class="col-md-4">
							<label for="" class="control-label">Starting Bidding Amount</label>
							<input type="number" class="form-control text-right" name="start_bid" value="<?php echo isset($start_bid) ? $start_bid : 0 ?>">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-4">
							<label for="" class="control-label">Bidding End Date/Time</label>
							<input type="datetime-local" class="form-control datetimepicker" name="bid_end_datetime" value="<?php echo isset($bid_end_datetime) && strtotime($bid_end_datetime) > 0 ? date("Y-m-d H:i",strtotime($bid_end_datetime)) : '' ?>">
						</div>
					</div>
					<div class=" row form-group">
						<div class="col-md-5">
							<label for="" class="control-label">Product Image</label>
							<input type="file" class="form-control" name="img" onchange="displayImg2(this,$(this))">
						</div>

						<div class="col-md-5">
							<img src="<?php echo isset($img_fname) ? 'assets/uploads/'.$img_fname :'' ?>" alt="" id="img_path-field">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-sm btn-block btn-primary col-sm-2"> Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="imgF" style="display: none " id="img-clone">
			<span class="rem badge badge-primary" onclick="rem_func($(this))"><i class="fa fa-times"></i></span>
	</div>
<script>
	$(document).ready(function() {
    
		$('#manage-product').submit(function(e) {
        e.preventDefault(); 
        var formData = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
	            url: 'ajax.php?action=save_auction_product',
	            data: formData,
	            contentType: false,
	            processData: false,
	            success: function(resp) {
	                if (resp == 1) {
	                    alert_toast("Data successfully saved", 'success');
	                    setTimeout(function() {
	                        location.href = "index.php?page=auction_products";
	                    }, 1500);
	                }
	            },
	            error: function(xhr, status, error){
	                console.log(error);
	            }
	        });
	    });
	});


	function displayImg2(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#img_path-field').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}

</script>