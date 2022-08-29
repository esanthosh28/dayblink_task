<html lang = "en">  
   <head>  
      <meta charset = "utf-8">  
      <meta name = "viewport" content = "width = device-width, initial-scale = 1, shrink-to-fit = no">  
      <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">         
      <title> Registration Form </title>
      <style>  
      body {  
      color: green;  
      }  
      </style>  
   </head>  
   <body>  
<section class="h-100 bg-dark">  
  <div class="container py-5 h-100">  
    <div class="row d-flex justify-content-center align-items-center h-100">  
      <div class="col">  
        <div class="card card-registration my-4">  
          <div class="row g-0">  
            <div class="col-xl-12"> 
            <form class="register-form" action="{{url('register/form')}}" method="POST"> 
            	@csrf
              <div class="card-body p-md-5 text-black">  
                <h3 class="mb-5 text-uppercase">Registration form </h3>  
                <div class="form-outline mb-4">  
                  <input type="text" id="user_name" name="user_name" class="form-control form-control-lg" required/>
                  <label class="form-label" for="user_name"> Name </label>  
                </div> 
                <div class="form-outline mb-4">  
                  <input type="email" id="user_email" name="user_email" class="form-control form-control-lg" required/>
                  <label class="form-label" for="user_email"> Email ID </label>  
                </div>  
                <div class="form-outline mb-4">  
                  <input type="number"
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                         maxlength="10" id="user_mobile" name="user_mobile" class="form-control form-control-lg" required/>
                  <label class="form-label" for="user_mobile"> Phone Number </label>  
                </div>  
                <div class="d-flex justify-content-end pt-3">  
                  <button type="reset" class="btn btn-light btn-lg"> Reset all </button>  
                  <button type="submit" class="btn btn-warning btn-lg ms-2"> Submit form </button>  
                </div>  
              </div>
            </form>  
            </div>  
          </div>  
        </div>  
      </div>  
    </div>  
  </div>  
</section>  
</body>  
</html>  