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
			use \Faycal\Company as Company ;

			$connexion = new linkLoader ;
			$contents = $connexion->connexion('http://dz.kompass.com/s/' , '.footerCol1-1 ul li a' , 'a' , true) ;
						
			$lists = $connexion->getCollection();

			//  array_shift($list);
			//  array_shift($list);
			//  array_shift($list);
			//  array_shift($list);
			
			$list = array(
						array(
							'href' =>  'http://dz.kompass.com/s/enseignement-formation-administrations/14/',
						      'categorie' =>  'Enseignement, formation - Administrations',
						      'title' =>  '' 
							),
						array(
							'href' => 'http://dz.kompass.com/s/informatique-internet-r-d/12/' ,
						      'categorie' =>  'Informatique, Internet, R et D' ,
						      'title' =>  '' ,
							),
						array(
							'href' =>  'http://dz.kompass.com/s/loisirs-tourisme-culture/15/',
						      'categorie' =>  'Loisirs, Tourisme, Culture' ,
						      'title' =>  '' ,
							),
						array(
							'href' =>  'http://dz.kompass.com/s/materiel-electrique-electronique-optique/08/' ,
						      'categorie' =>  'Matériel électrique, électronique, optique' ,
						      'title' =>  '' 
							)
				);

			 //var_dump($list);	

			 

			foreach ($list as $key=>$value)
			{				
				$categorie0	= new linkLoader ;
				$categorie0->connexion($value['href'] , '.prod_list' , 'a' , false) ;

				$categoryName = $value['categorie'] ; 

				foreach ($categorie0->getCollection() as $kk0=>$vv0)
					{
							//var_dump($vv);

							$Do = new Dom;		
							$Do->load($vv0['href']);
							$addressCoordinates = $Do->find('.headerDetailsCompany .headerRowTop p');
							$addressCoordinates = preg_replace('/<br \/>/', '', $addressCoordinates->outerHtml) ;
							
							$phone = $Do->find('#phone a');
							$presentation = $Do->find('#presentation .presentation ul');
							$chiffre = $Do->find('#keynumbers .employees ul.effectif ');
							$executives = $Do->find('#executives ul ');

							$company0 = new Company ;
							$company0->nom = $vv0['title'];
							$company0->adresse = $vv0['adresse'];
							$company0->tel1 = $phone->innerHtml;
							$company0->presentation = $presentation->innerHtml;
							$company0->chiffre = $chiffre->innerHtml;							
							$company0->executives = $executives->innerHtml;
							$company0->categorie = $categoryName;
							$company0->link = $vv0['href'];
							$company0->save();
					}

				// par pages script
				foreach ($connexion::$pages as $k=>$v)
				{
					$categorie	= new linkLoader ;
					$categorie->connexion($value['href'].$v , '.prod_list' , 'a' , false) ;

					//array_push( $entreprise , array('link'=>$value['href'].$v , $categorie->getCollection()));
					foreach ($categorie->getCollection() as $kk=>$vv)
					{
							
							$href = $vv['href'] ;
							$D = new Dom;		
							$D->load($href);
							$addressCoordinates = $D->find('.headerDetailsCompany .headerRowTop p');
							$addressCoordinates = preg_replace('/<br \/>/', '', $addressCoordinates->outerHtml) ;
							
							$phone = $D->find('#phone a');
							$presentation = $D->find('#presentation .presentation ul');
							$chiffre = $D->find('#keynumbers .employees ul.effectif ');
							$executives = $D->find('#executives ul ');


							$company = new Company ;
							$company->nom = $vv['title'];
							$company->adresse = $vv['adresse'];
							$company->tel1 = $phone->innerHtml;
							$company->presentation = $presentation->innerHtml;
							$company->chiffre = $chiffre->innerHtml;							
							$company->executives = $executives->innerHtml;
							$company->categorie = $categoryName;
							$company->link = $href ;
							$company->page = $v;

							$company->save();
					}
				}
			}
		?>
	</body>
</html>