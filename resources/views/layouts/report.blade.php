<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Informes</title>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link  rel="icon" href="{!! asset('imagedefeult/navegador.jpeg') !!}"/>

	</head>
	<style> 
	    body { font-family: Arial, Helvetica;}

	    section{ margin-top: 0.7em} 
	    .header,
		.footer {
		    width: 100%;
		    text-align: center;
		    position: fixed;
		}
		.header {
		    top: 0px;
		}
		.footer {
		    bottom: 0px;
		}
		.pagenum:before {
		    content: counter(page);
		}
	    table {
	      width: 100%;
	      color:black;
	      font-size:14px;
	      font-family: Arial, Helvetica;
	      margin-top: 0.7em;
	    }
	    thead {
	      background-color: #F5F5F5;
	    }
	    tbody {
	      background-color: #ffffff;     
	    }
	    th,td {
	      padding: 3pt;
	      border-bottom: 1px solid #A3A3A3;
	      border: 1px solid black;
	    }

	    table{
	      border-collapse: collapse;
	      border-bottom: 1px solid #A3A3A3;
	    }
	    table th {
	      border-bottom: 1px solid #6B8397;
	    }   
	  </style>
	<body>
		<div class="header" style="display:none">
		    Page <span class="pagenum"></span>
		</div>
		<div class="footer">
		    Pagina <span class="pagenum"></span>
		</div>

		<section>
			@yield('cuerpo')
		</section>

		<!--footer>
			<center>Instituto Superior de Sanidad "Prof. Ramón Carrillo" - Formosa</center>
		</footer -->

	</body>
</html>