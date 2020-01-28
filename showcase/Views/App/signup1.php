<?php 
namespace Showcase\Views\App;
require "calcule.php";
use \Showcase\Framework\Initializer\AutoLoad;
use \Showcase\Models\User;
use \Showcase\Models\Degree;

$name = User::Current()->username;
$degree = Degree::getByEmail(User::Current()->email);
if (!is_null($degree)) {
			
		echo '<table class="form-table">';
    echo "<thead>";
    echo "<tr>";
      echo "<th scope=\"col\">Name</th>";
      echo "<th scope=\"col\">P.web</th>";
      echo "<th scope=\"col\">Compilation</th>";
      echo "<th scope=\"col\">Artificiel intelligence</th>";
      echo "<th scope=\"col\">UML</th>";
      echo "<th scope=\"col\"><span> Result </span> </th>";
    echo "</tr>";
		echo "</thead>";
				
	    echo "<tr>";
	      echo "<td>" . $name. "</td>";
	      echo "<td>" . $degree->programmation . "</td>";
	      echo "<td>" . $degree->compilation . "</td>";
	      echo "<td>" . $degree->ai . "</td>";
	      echo "<td>" . $degree->uml . "</td>";
	      echo "<td>" . $degree->result() . "</td>";
				echo "<td> <button type=\"submit\" name=\"update\" value=\"Update\" onclick=\"update()> Update </button></td>";
				echo "<td> <button type=\"submit\" name=\"delete\" value=\"Delete\" onclick=\"delete()> Delete </button></td>";
	    echo "</tr>";
			echo "</table>";
			}
				else {
					echo "<h3> You did not fill out the required fields. </h3>";
				}

		function update(){

		}

    function delete(){
			$user = array();
			$prog = array();
			$comp = array();
			$ai = array();
			$uml = array();
		  $find = false;
		  $filename = 'C:\xampp\htdocs\note\file\note.csv';
		  if (!$fp = fopen('C:\xampp\htdocs\note\file\note.csv',"r")) {
		    echo "Echec de l'ouverture du fichier";
		    exit;
		  } else {
		    $file = file($filename);
		    foreach ($file as $key => $Ligne) {
		      $Ligne = trim($Ligne);
		      $tab = explode(';',$Ligne);
		      $user[] = $tab[0];
		      $prog[] = $tab[1];
					$comp[] = $tab[2];
					$ai[] = $tab[3];
					$uml[] = $tab[4];
		    }
		  fclose($fp);
		  }
			$fp1 = fopen('C:\xampp\htdocs\note\file\note1.csv',"a");
		  foreach ($user as $key => $value) {
		    if($value == $email && $prog[$key] == $prog && $comp[$key] == $comp && $ai[$key] == $ai &&  $uml[$key] == $uml ){
		      //delete
		    }else {
				   fputs($fp , "$email;$password\n");
		    }
		}
		fclose($fp1);
		rename("'C:\xampp\htdocs\note\file\note1.csv'", "'C:\xampp\htdocs\note\file\note.csv'");
		unlink("note1.csv");
}

?>
