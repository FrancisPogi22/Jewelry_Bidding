<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>

<body class="hold-transition register-page">
	<div class=" col-lg-7">
		<div class="register-logo">
			<a href="#"><b>O.C Burgos Online Jewelry </b>Shop</a>
		</div>
		<?php session_start() ?>
		<?php include('admin/db_connect.php'); ?>
		<?php
		if (isset($_SESSION['login_id'])) {
			$qry = $conn->query("SELECT * from users where id = {$_SESSION['login_id']} ");
			foreach ($qry->fetch_array() as $k => $v) {
				$$k = $v;
			}
		}
		?>
		<div class="card">
			<div class="card-body register-card-body">
				<p class="login-box-msg"><?php echo !isset($id) ? 'Create Account' : 'Manage Account'; ?></p>
				<form id="manage-signup">
					<input type="hidden" value="<?php echo isset($id) ? $id : '' ?>" name="id">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 border-right">
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="firstname" required placeholder="First Name" value="<?php echo isset($firstname) ? $firstname : '' ?>">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="<?php echo isset($middlename) ? $middlename : '' ?>">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="lastname" required placeholder="Last Name" value="<?php echo isset($lastname) ? $lastname : '' ?>">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>
								<!-- <div class="input-group mb-3">
			          <input type="text" class="form-control" name="contact" required placeholder="Contact Number" value="<?php echo isset($contact) ? $contact : '' ?>">
			          <div class="input-group-append">
			            <div class="input-group-text">
			              <span class="fas fa-mobile"></span>
			            </div>
			          </div>
			        </div> -->
								<div class="mb-3">
									<textarea cols="30" rows="3" class="form-control" name="address" required placeholder="Address"><?php echo isset($address) ? $address : '' ?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group mb-3">
									<input type="email" class="form-control" name="email" required="" placeholder="Email" value="<?php echo isset($email) ? $email : '' ?>">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-envelope"></span>
										</div>
									</div>
								</div>
								<small id="msg"></small>
								<div class="input-group mb-3">
									<input type="password" class="form-control" name="password" <?php echo isset($id) ? '' : "required" ?> placeholder="Password">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
								</div>
								<?php if (isset($id)) : ?>
									<small><i>Leave this field blank if you dont want to change your password.</i></small>
								<?php endif; ?>
								<div class="input-group mb-3">
									<input type="password" class="form-control" name="cpass" <?php echo isset($id) ? '' : "required" ?> placeholder="Retype password">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
								</div>
								<small id="pass_match" data-status=''></small>
								<?php if (!isset($id)) : ?>
									<div class="input-group mb-3">
										<input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact Number: 09123456789" required maxlength="11" pattern="09\d{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo isset($contact) ? $contact : '' ?>">
										<div class="input-group-append">
											<button class="btn bg-primary" type="button" id="sendOTPButton">Send OTP</button>
										</div>
									</div>
									<!-- SENT OTP -->
									<input type="hidden" class="form-control" name="sentOTP">
									<small id="msg2"></small>
									<div class="input-group mb-3">
										<input type="text" class="form-control" name="enteredOTP" placeholder="Enter OTP">
										<div class="input-group-append">
											<div class="input-group-text">
												<span class="fas fa-key"></span>
											</div>
										</div>
									</div>
								<?php else : ?>
									<div class="input-group mb-3">
										<input type="text" class="form-control" name="contact" required placeholder="Contact Number" value="<?php echo isset($contact) ? $contact : '' ?>">
										<div class="input-group-append">
											<div class="input-group-text">
												<span class="fas fa-mobile"></span>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<!-- <label for="">Enter</label> -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">
							<?php if (!isset($id)) : ?>
								<div class="icheck-primary">
									<input type="checkbox" id="agreeTerms" value="agree">
									<label for="agreeTerms">
										I agree to the <a href="#">terms</a>
									</label>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-4">
							<!-- <button type="submit" class="btn btn-primary btn-block"><?php echo !isset($id) ? 'Register' : 'Update Account'; ?></button> -->
							<button type="button" class="btn btn-primary btn-block" id="registerButton" <?php echo !isset($id) ? 'disabled' : ''; ?>><?php echo !isset($id) ? 'Register' : 'Update Account'; ?></button>
							<script>
								function onClick(e) {
									e.preventDefault();
									grecaptcha.enterprise.ready(async () => {
										const token = await grecaptcha.enterprise.execute('6Lemn3cpAAAAAGwmtW41Ya-LbHQITE-S8sGTpwgV', {
											action: 'Register'
										});
									});
								}
							</script>
						</div>
					</div>
				</form>
				<?php if (!isset($id)) : ?>
					<p>If you already have an account <br>Please&nbsp;&nbsp;<a href="login.php" class="text-center">Log in</a></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#sendOTPButton').click(function() {
				$.ajax({
					url: 'admin/send_otp.php',
					method: 'POST',
					data: {
						contact: $('[name="contact"]').val()
					},
					success: function(response) {
						let data = JSON.parse(response);
						if (data.success) {
							alert('OTP sent successfully');
							$('#registerButton').removeAttr('disabled');
							$('[name="sentOTP"]').val(data.otp);
						} else {
							alert('Failed to send OTP: ' + data.message);
						}
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			});

			$('#manage-signup').submit(function(e) {
				e.preventDefault()
				$('input').removeClass("border-danger")
				start_load()
				$('#msg').html('')
				if ($('#pass_match').attr('data-status') != 1) {
					if ($("[name='password']").val() != '') {
						$('[name="password"],[name="cpass"]').addClass("border-danger")
						end_load()
						return false;
					}
				}
				$.ajax({
					url: 'admin/ajax.php?action=signup',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success: function(resp) {
						if (resp == 1) {
							alert_toast('Data successfully saved.', "success");
							setTimeout(function() {
								location.replace('index.php?page=home')
							}, 750)
						} else if (resp == 2) {
							$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
							$('[name="email"]').addClass("border-danger")
							end_load()
						}
					}
				})
			})

			$('#registerButton').click(function() {
				let enteredOTP = $('[name="enteredOTP"]').val();
				let sentOTP = $('[name="sentOTP"]').val();

				if (enteredOTP === sentOTP) {
					$('#manage-signup').submit();
				} else {
					$('#msg2').html("<div class='alert alert-danger'>Entered OTP does not match the sent OTP.</div>");
				}
			});

			$('[name="password"],[name="cpass"]').keyup(function() {
				let pass = $('[name="password"]').val()
				let cpass = $('[name="cpass"]').val()
				if (cpass == '' || pass == '') {
					$('#pass_match').attr('data-status', '')
				} else {
					if (cpass == pass) {
						$('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>')
					} else {
						$('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>')
					}
				}
			})
		})
	</script>
	<?php include 'footer.php' ?>
</body>

</html>