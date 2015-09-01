<!DOCTYPE html>
<html>
	<head>
		<title>Dz Compass</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php
		
			require __DIR__ . '/vendor/autoload.php';

			use PHPHtmlParser\Dom;
			use \Faycal\linkLoader as  linkLoader;

			$connexion = new linkLoader ;
			$contents = $connexion->connexion('http://dz.kompass.com/s/' , '.footerCol1-1 ul li a' , 'a' , true) ;

			$entreprise = array() ;

			// echo $connexion->getUrl();
			 var_dump($connexion->getCollection());			

			foreach ($connexion->getCollection() as $key=>$value)
			{
				
				$categorie0	= new linkLoader ;
				$categorie0->connexion($value['href'] , '.prod_list' , 'a' , false) ;

				//array_push($entreprise, $categorie0->getCollection() ) ;
				
				

				// par pages script
				// foreach ($connexion::$pages as $k=>$v)
				// {
				// 	$categorie	= new linkLoader ;
				// 	$categorie->connexion($value['href'].$v , '.prod_list' , 'a' , false) ;

				// 	array_push( $entreprise , array('link'=>$value['href'].$v , $categorie->getCollection()));
				// }

				// $categorie	= new linkLoader ;
				// $categorie->connexion($value['href'] , '.prod_list' , 'a' , false) ;

				//var_dump($categorie->getCollection());

				// foreach ($categorie->getCollection() as $key => $value) 
				// {
				// 		$company
				// }	
			}

			var_dump($entreprise);
		?>	

		
	</body>
</html>