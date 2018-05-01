<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
  <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
  <meta name="keywords" content="login, signin">

    <title>Informes PGM</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="estilos/login/core.min.css" rel="stylesheet">
    <link href="estilos/login/app.min.css" rel="stylesheet">
    <link href="estilos/login/style.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
    <link rel="icon" href="assets/favicon.png">
  </head>

  <body>


	
    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(img.php?r=background/pgm_informes_background.png)" data-overlay="1">

        <div class="row h-100 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
            <img src="img.php?r=logos/logo_pgm.png" alt="..." width="80" height="90">

            <p class="text-white">Sistema de Gestión Multiple</p>
            <br><br>
          </div>
        </div>

      </div>



      <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
        <div class="px-80 py-30">
          <h4>Login</h4>
          <p><small>Iniciar sesión en su cuenta</small></p>
          <br>

		  <form data-provide="validation" data-disable="false" class="form-type-material" action="valida.php" method="post">
		  
            <div class="form-group">
              <input name="rut" type="text" class="form-control" id="rut" value="" required>
              <label for="rut">Rut</label>
            </div>
		  
 		   <div class="form-group">
              <input name="login" type="text" class="form-control" id="username" value="" required>
              <label for="username">Usuario</label>
            </div>
			
            <div class="form-group">
              <input name="pwd" type="password" class="form-control" id="password" value="" required>
              <label for="password">Contraseña</label>
            </div>

            <div class="form-group flexbox">
              <label class="custom-control custom-checkbox">
                <!--input type="checkbox" class="custom-control-input" checked-->
                <!--span class="custom-control-indicator"></span-->
                <!--span class="custom-control-description">Remember me</span-->
              </label>

              <!--a class="text-muted hover-primary fs-13" href="#">Olvido su contraseña?</a-->
            </div>

            <div class="form-group">
              <button class="btn btn-bold btn-block btn-primary" type="submit">Login</button>
            </div>
          </form>



          <hr class="w-30px">

        </div>
      </div>
    </div>




    <!-- Scripts -->
    <script src="estilos/login/core.min.js"></script>
    <script src="estilos/login/app.min.js"></script>
    <script src="estilos/login/script.min.js"></script>

  </body>
</html>

