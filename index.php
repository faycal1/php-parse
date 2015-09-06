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
		use \Faycal\Company as Company ;
		use \Faycal\Executive as Executive ;

		$companies = Company::all();
		
		//$companies = Company::limit(10)->get();

		// var_dump($companies) ;

		exit();
		
		foreach ($companies as $key => $company) {
				
			//echo $company->id .'<br>';
			//$first = Company::find(6703);
			
			$presentation = $company->presentation ;
			$chiffre      = $company->chiffre ;
			$executives   = $company->executives ;

			//var_dump($presentation, $chiffre , $executives);
			//echo'<hr>' ;

			$dom = new Dom;
			$dom->setOptions([
			    'strict' => true, // Set a global option to enable strict html parsing.
			]);
			$dom->load($presentation) ;
			$presentation = $dom->find('li');
			$siteweb = $dom->find('.listWww a')->text;

			//echo'<h2>Présentation</h2>' ;
			
			foreach ($presentation as $key => $value) {
				//var_dump($value->innerHtml) ;
				$do = new Dom;
				$do->load($value->innerHtml) ;
				$attr = $do->find('p')[0]->text;
				$v = $do->find('p')[1]->text;

				//var_dump($attr , $v);
				//
				if($attr == 'Année de création')
					$annee_creation = $v;

				if($attr == 'Registration No.')
					$registration = $v;

				if($attr == "Nature de l'établissement")
					$nature_etablissement = $v;

				if($attr == "Fax")
					$fax = $v;
				
			}
			$siteweb = $siteweb ; //site web
			//echo'<hr>' ;

			//echo'<h2>Chiffre</h2>' ;
			$dom->load($chiffre) ;
			$chiffre = $dom->find('li p');

			$k=0 ;
			foreach ($chiffre as $key => $value) {

				if($k == 3) //nombre d'emplyer
					$employees = str_replace('&nbsp;Employés', ' ', $value->innerHtml);

				$k++;
			}

			$employees = str_replace( '&#x20;' , '' , $employees );
			$employees = str_replace( '&agrave;' , ' à ' , $employees );
			$employees = str_replace('&eacute;&nbsp;', 'é' , $employees);

			$company->annee_creation = isset($annee_creation) ? $annee_creation : NULL;
			$company->registration = isset($registration) ? str_replace('&#x2f;', '/', $registration) : NULL;
			$company->nature_etablissement = isset($nature_etablissement) ? $nature_etablissement  : NULL;
			$company->fax = isset($fax) ? $fax : NULL;
			$company->siteweb = isset($siteweb) ? $siteweb : NULL ;
			$company->employees = isset($employees) ?$employees : NULL;

			$company->save();
			
			// var_dump(
			// 		$annee_creation,
			// 		str_replace('&#x2f;', '/', $registration),
			// 		$nature_etablissement,
			// 		$fax,
			// 		$siteweb,
			// 		$employees
			// 	) ;

			//echo'<hr>' ;
			//<h2>Executive</h2>
			/*$dom->load($executives) ;
			$li = $dom->find('.executiveInfo'); 
			
			//echo count($li);
			foreach ($li as $key => $value) {

				$d = new Dom;
				$d->load($value) ;
				$nom = $d->find('p.name span')->text;
				$fonction = $d->find('p.fonction span')->text;
				$fonction = str_replace("&eacute;", 'é', $fonction) ;

				$executive = new Executive ;

				$executive->nom = $nom ;
				$executive->poste = str_replace('&#x2f;', '/', $fonction) ;
				$executive->company_id = $company->id ;

				$executive->save();


				//var_dump($nom , $fonction );
			}*/
			echo'<hr>';
					
		}
	?>
		
		<!-- <h2>Presentation</h2>
		<li> 
			<p>Année de création</p>
			<p>2010</p> 
		</li> 
		<li> 
			<p>Nature de l'établissement</p>
			<p>Siège</p> 
		</li> 
		<li> 
			<p>Fax</p> 
			<p> +213 34 230221</p>
		</li>


		<h2>Chiffres</h2>
		<li> 
			<p> À l'adresse</p>
			<p class="number">
			Non&#x20;renseign&eacute;&nbsp;</p>
		</li>
		<li>
		 <p> Entreprise</p>
		 <p class="number"> 6&nbsp;Employés</p>
		</li>

		<h2>executives</h2>

		<li class="bloc"> 
			<div class="executiveInfo">
				 <div class="illustration">
				  	<img class="img-polaroid" src="/_ui/desktop/theme-kompass/images/ficheEntre/contact.png" width="100" height="100" alt="" />
				 </div>
				 <p class="name"> 
				 	<span>Mohand-Cherif Mesbah</span>
				  </p>
				 <p class="fonction">
				 	<span>g&eacute;rant&#x2f;dir.tec.</span>
				 </p>
			</div>
		 </li> -->

	</body>
</html>