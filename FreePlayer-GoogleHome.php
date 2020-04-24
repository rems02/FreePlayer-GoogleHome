<?php
#--
# Copyright (c) 2016 R.Syrek aka Rem'S http://Domotique-Home.fr
#
# author		 :Rem'S 
# Permission is hereby granted, free of charge, to any person obtaining
# a copy of this software and associated documentation files (the
# "Software"), to deal in the Software without restriction, including
# without limitation the rights to use, copy, modify, merge, publish,
# distribute, sublicense, and/or sell copies of the Software, and to
# permit persons to whom the Software is furnished to do so, subject to
# the following conditions:
#
# The above copyright notice and this permission notice shall be
# included in all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
# MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
# LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
# OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
# WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
#
#++
  
##################
#  Utilisation:
#  Renseigner: le code de votre télécommande dans "remote"
#  changer éventuellement hd=2 pour votre deuxieme Freeplayer etc...
#  .../FreeBox-GoogleHome.php  remote=<CodeTélécommande> hd=1 message="#message#"  
#  Documentation: http://domotique-home.fr/gestion-simple-de-la-freebox-avec-google-homme-et-ifttt/  
##################
  
## protection de l'url ##

if (php_sapi_name() != 'cli' || isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['argc'])) {
    header("Status: 404 Not Found");
    header('HTTP/1.0 404 Not Found');
    $_SERVER['REDIRECT_STATUS'] = 404;
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}

## analyse des arguments interpréteur PHP ##

if (isset($argv)) {
	array_shift($argv);
    foreach ($argv as $arg) {
        $arg = explode('=', $arg);
        if (isset($arg[0]) && isset($arg[1])) {
            $_GET[$arg[0]] = $arg[1];
        }
    }
}

## initialisation des variables ##

$remote = $_GET["remote"];

$hd = isset($_GET["hd"])?$_GET["hd"]:"1";

$message = trim(preg_replace("/(sur|SUR) *(la)? */","",$_GET["message"]));

$path = "http://hd".$hd.".freebox.fr/pub/remote_control?";


## construction de commande ##

function requete($button,$repeat=1,$long=false,$delay=0) {
// fonction qui renvoit un tableau avec les arguments de la requète HTTP vers le FreePlayer
// [ id du bouton , nombre de répétition , type d'appui , delais avant prochaine requète ( en s ) ]
	global $path,$remote;
	$long = ($long) ? 'true' : 'false';
	return array($path."code=".$remote."&key=".$button."&repeat=".$repeat."&long=".$long,$delay) ;
}

## mapage des chaînes textuelles en numériques ##

if (!is_numeric($message)) { // évite le mappage des châines numériques

	switch($message) {
		case "TF 1":
		case "un": {
			$message="1";
			break;
		}
		case "France 2":
		case "deux": {
			$message="2";
			break;
		}
		case "France 3":
		case "trois": {
			$message="3";
			break;
		}
		case "Canal +":
		case "quatre": {
			$message="4";
			break;
	}
		case "France 5":
		case "cinq": {
			$message="5";
			break;
		}
		case "M 6":
		case "six": {
			$message="6";
			break;
		}
		case "Arte":
		case "sept": {
			$message="7";
			break;
		}
		case "C 8":
		case "huit": {
			$message="8";
			break;
		}
		case "W 9":
		case "neuf": {
			$message="9";
			break;
		}
		case "TMC":
		case "dix": {
			$message="10";
			break;
		}
		case "NT 1": {
			$message="11";
			break;
		}
		case "NRJ 12": {
			$message="12";
			break;
		}
		case "LCP":
		case "la chaîne parlementaire":
		case"Public Sénat": {
			$message="13";
			break;
		}
		case "France 4": {
			$message="14";
			break;
		}
		case "BFM TV": {
			$message="15";
			break;
		}
		case "cnews": {
			$message="16";
			break;
		}
		case "cstar": {
			$message="17";
			break;
		}
		case "Gulli": {
			$message="18";
			break;
		}
		case "France Ô": {
			$message="19";
			break;
		}
		case "HD 1": {
			$message="20";
			break;
		}
		case "l'équipe":
		case "l  équipe": {
			$message="21";
			break;
		}
		case "6 ter":
		case "sister": {
			$message="22";
			break;
		}
		case "numéro 23": {
			$message="23";
			break;
		}
		case "RMC découverte": {
			$message="24";
			break;
		}
		case "Chérie 25": {
			$message="25";
			break;
		}
		case "LCI": {
			$message="26";
			break;
		}
		case "France Info": {
			$message="27";
			break;
		}
		case "Paris Première": {
			$message="28";
			break;
		}
		case "RTL 9": {
			$message="29";
			break;
		}
		case "Téva": {
			$message="38";
			break;
		}
		case "Disney Channel": {
			$message="48";
			break;
		}
		case "Disney Channel + 1": {
			$message="49";
			break;
		}
		case "Planète +": {
			$message="59";
			break;
		}
		case "National Geographic Channel": {
			$message="60";
			break;
		}
		case "comédie +":
		case "comédie plus": {
			$message="80";
			break;
		}
		case "MTV": {
                        $message="84";
                        break;
                }
                case "Science et Vie TV": {
                        $message="207";
                        break;
                }

		case "Disney Junior": {
			$message="140";
			break;
		}
		case "Nickelodeon junior": {
			$message="141";
			break;
		}
		case "Tiji": {
			$message="142";
			break;
		}
		case "Piwi plus": {
			$message="143";
			break;
		}
		case "boomerang": {
			$message="144";
			break;
		}
		case "boomerang plus 1": {
			$message="145";
			break;
		}
		case "Cartoon Network": {
			$message="146";
			break;
		}
		case "Nickelodeon": {
			$message="147";
			break;
		}
		case "Disney XD": {
			$message="148";
			break;
		}
		case "Canal J": {
			$message="149";
			break;
		}
		case "Télétoon +": {
			$message="150";
			break;
		}
		case "Télétoon + 1": {
			$message="151";
			break;
		}
		case "Nickelodeon fourteen": {
			$message="152";
			break;
		}
		case "Boing": {
			$message="153";
			break;
		}
		case "toonami": {
			$message="154";
			break;
		}
		case "Baby TV": {
			$message="155";
			break;
		}
		case "Nickelodeon plus 1": {
			$message="156";
			break;
		}
        case "Poker": {
			$message="244";
			break;
		}
	}
}

## construction de la (multi-)commande ##

$commands = [] ;

if (is_numeric($message)) {
	for($i=0; $i<strlen($message); $i++) {
		$commands[]=requete($message[$i]);
	}
}
else {
	switch ($message) {
		case "allume":
		case "arrête":
		case "éteint":
		case "étang": {
			$a = @fsockopen("Freebox-Player.local", 7000) ? true : false ;
			$b = ($message==="allume") ? true : false ;
			if ($a xor $b) { $commands[]=requete("power") ;}
			break;
		}
		case "bouquet free": {
			$commands[]=requete("home",1,false,1.5);
			$commands[]=requete("home",1,false,0.5);
			$commands[]=requete("ok");
			break;
		}
		case "bouquet Canal": {
			$commands[]=requete("home",1,false,1.5);
			$commands[]=requete("home",1,false,0.5);
			$commands[]=requete("down");
			$commands[]=requete("down");
			$commands[]=requete("ok");
			break;
		}
		case "enregistre": {
			$commands[]=requete("rec");
			break;
		}
		case "ok": {
			$commands[]=requete("ok");
			break;
		}
		case "chercher":
		case "bleu": {
			$commands[]=requete("blue");
			break;
		}
		case "retour":
		case "rouge":
		case "précédent": {
			$commands[]=requete("red");
			break;
		}
		case "Menu":
		case "vert":
		case "verre": {
			$commands[]=requete("green");
			break;
		}
		case "info":
		case "jaune": {
			$commands[]=requete("yellow");
			break;
		}
		case "haut":
		case "au": {
			$commands[]=requete("up");
			break;
		}
		case "bas":
		case "barre": {
			$commands[]=requete("down");
			break;
		}
		case "gauche": {
			$commands[]=requete("left");
			break;
		}
		case "droite": {
			$commands[]=requete("right");
			break;
		}
		case "free": {
			$commands[]=requete("home");
			break;
		}
		case "volume plus":
		case "volume +":
		case "monte le son":
		case "montre le son": {
			$commands[]=requete("vol_inc",1,true);
            break;
		}
		case "volume moins":
		case "volume moi":
		case "volume -":
	        case "baisse le son": {
			$commands[]=requete("vol_dec",1,true);
			break;
		}
		case "volume muet":
		case "remets le son":
		case "coupe le son": {
			$commands[]=requete("mute");
			break;
		}
		case "programme plus":
		case "programme +": {
			$commands[]=requete("prgm_inc");
			break;
		}
		case "programme moins":
		case "programme moi":
		case "programme -": {
			$commands[]=requete("prgm_dec");
		break;
		}
	}
}

## execution de la (multi-)commande ##

foreach ($commands as $command) {
	$url = $command[0];
	$delay = $command[1];
	echo $url;

	file_get_contents($url);
	usleep($delay*1000000);
	}

?>
