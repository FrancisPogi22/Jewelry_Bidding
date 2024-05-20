<?php session_start() ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<p>This transaction accept only cash on delivery. Please wait for verification call from the management after checking out</p>
		<form id="manage-order">
			<div class="form-group">
				<label for="" class="control-label">Location</label>
				<textarea name="address" id="" cols="30" rows="4" class="form-control" required><?php echo $_SESSION['login_address'] ?></textarea>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Note</label>
				<input type="text" name="note" class="form-control" placeholder="Leave a note">
			</div>
		</form>
	</div>
</div>
<script>
	$('#manage-order').submit(function(e) {
		e.preventDefault()
		let selectedItems = $('.order-checkbox:checked').map(function() {
			return $(this).data('product-id');
		}).get();
		start_load()
		$.ajax({
			url: 'admin/ajax.php?action=save_order',
			method: 'POST',
			data: $(this).serialize() + '&selected_items=' + selectedItems.join(','),
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Order successfully submitted.', "success");
					setTimeout(function() {
						location.reload()
					}, 2000)
				}
			},
			error: err => {
				console.log(err)
			},
		})
	})
</script>