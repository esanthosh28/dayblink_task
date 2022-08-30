<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
    <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>         

</head>
<body>
	<section class="vh-100" style="background-color: #9A616D;height: 100vh;">
	  <div class="container py-5 h-100">
	    <div class="row d-flex justify-content-center align-items-center h-100">
	      <div class="col col-xl-10">
	        <div class="card" style="border-radius: 1rem;">
	          <div class="row g-0" style="justify-content: center">
	            <div class="col-md-6 col-lg-7 d-flex align-items-center">
	              <div class="card-body p-4 p-lg-5 text-black">

	                <form autocomplete="off" id="login-form" class="login-form">

	                  <h1 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;text-align: center;">Sign In</h1>

	                  <div class="form-outline mb-4">
	                    <input type="text" id="user_mobile" class="form-control form-control-lg" name="user_mobile" />
	                    <label class="form-label" for="user_mobile">Mobile No.</label>
	                  </div>
	                    <span class="err_msg"></span>
	                    <img class="loadinIcon" src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87_w200.webp" style="height:30px;display:none;">

	                  <div class="form-outline mb-4 otp_div" style="display:none">
	                    <input type="text" id="user_otp" class="form-control form-control-lg" />

	                    <input type="text" id="user_otp_db" class="form-control form-control-lg" style="display: none;" disabled/>
	                    <label class="form-label" for="user_otp">OTP</label>
	                  </div>

	                  <div class="pt-1 mb-4">
	                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
	                  </div>

	                  <a class="small text-muted" href="#!">Forgot password?</a>
	                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="{{ url('register') }}"
	                      style="color: #393f81;">Register here</a></p>
	                </form>

	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</section>

</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('#login-form').submit(function(e){
			e.preventDefault();
			// alert($('.otp_div').css('display'))
			if($('#user_mobile').val() === ''){
				$('#user_mobile').css('border','1px solid red').focus();
			}else if($('#user_mobile').val() !== '' && $('#user_otp_db').val() !== ''){
				if($('#user_otp_db').val() != $('#user_otp').val()){
					$('.err_msg').show().html('<span style="color:red">OTP is Incorrect</span>');
				}else{
					$('.err_msg').show().html('<span style="color:green">OTP is Verified</span>');

                    $.ajax({
                        url: "{{ url('login/customLogin') }}",
                        type: "POST",
                        data: { "_token": "{{ csrf_token() }}",mobile : $('#user_mobile').val(),password:$('#user_otp').val(), otp:$('#user_otp').val() },
                        success: function(data){
                            $('.loadinIcon').hide();

                            if(!data.error){
								alert('logged in successfully..!');

                                setTimeout(function(){
                        			window.location.href="products";
                                }, 2000);
                            }else{
                                $('.err_msg').show().html('<span style="color:red">'+data.msg+'</span>');

                            }
                        }
                    });
				}
			}else{

				$('.loadinIcon').show();
				$('.err_msg').hide();

				$.ajax({
			        url: "{{ url('login/verify') }}",
			        type: "POST",
			        data: { "_token": "{{ csrf_token() }}",user_mobile : $('#user_mobile').val() },
			        success: function(data){
						$('.loadinIcon').hide();

			            const res = JSON.parse(data);
			            if(res.status === 'success'){
			            	$('.otp_div').css('display','block');
			            	$('#user_otp_db').val(res.otp);
                            $('#user_otp_db').fadeIn();
			            	$('.err_msg').show().html('<span style="color:green">'+res.message+'</span>');
			            }else{
			            	$('.err_msg').show().html('<span style="color:red">'+res.message+'</span>');

			            }
			        },
                    statusCode: {
                        401: function() {
                            alert('Please login to proceed further')
                        },
                        500: function(xhr) {
                            alert('some error occured');
                        }
                    }

			    });
			}

		})
	})
</script>
</html>