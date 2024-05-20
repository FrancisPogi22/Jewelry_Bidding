<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM bids where id= ".$_GET['id']);
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
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<form action="" id="manage-bid" enctype="multipart/form-data">
					<!-- <input type="hidden" name="action" value="save_product"> -->
					<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
					<h4><b><?php echo !isset($id) ? "New Bid" : "Manage Bid" ?></b></h4>
					<hr>
					<div class="form-group row">
						<label for="" class="control-label">User</label>
						<select class="custom-select select2" name="user_id">
							<option value=""></option>
							<?php
							$qry = $conn->query("SELECT * FROM users WHERE type=2 order by firstname asc");
							while($row=$qry->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>"><?php echo $row['firstname'].' '.$row['lastname'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group row">
						<label for="" class="control-label">Product</label>
						<select class="custom-select select2" name="product_id">
							<option value=""></option>
							<?php
							$qry2 = $conn->query("SELECT *, p.name AS p_name, p.id AS p_ID FROM products p JOIN auction_categories a ON p.category_id=a.id order by p_name asc");
							while($row2=$qry2->fetch_assoc()):
							?>
							<option value="<?php echo $row2['p_ID'] ?>"><?php echo $row2['p_name'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group row">
						<label for="" class="control-label">Bid amount</label>
						<input type="number" class="form-control text-right" name="bid_amount" value="<?php echo isset($bid_amount) ? $bid_amount : 0 ?>">
					</div>
					<div class="row">
						<button class="btn btn-sm btn-block btn-primary col-sm-2"> Save</button>
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
    
		$('#manage-bid').submit(function(e) {
        e.preventDefault(); 
        var formData = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
	            url: 'ajax.php?action=save_new_bidding',
	            data: formData,
	            contentType: false,
	            processData: false,
	            success: function(resp) {
	                if (resp == 1) {
	                    alert_toast("Data successfully saved", 'success');
	                    setTimeout(function() {
	                        location.href = "index.php?page=auction_bids";
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