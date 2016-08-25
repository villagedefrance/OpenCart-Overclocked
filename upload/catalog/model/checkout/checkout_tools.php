<?php
class ModelCheckoutCheckoutTools extends Model {

	function getJoinName($data) {
		if (!$data['lastname']) {
			return $data['firstname'];
		} else {
			return $data['firstname'] . ' ' . $data['lastname'];
		}
	}

	function getJoinNames($firstname, $lastname) {
		if (!$lastname) {
			return $firstname;
		} else {
			return $firstname . ' ' . $lastname;
		}
	}

	function generatePassword() {
		$passwords = array("qwerty","azerty","test","love","hello","monkey","dragon","iloveyou","shadow","sunshine","master","computer","princess","tiger","football","angel","whatever","freedom","soccer","superman","michael","cheese","internet","blessed","baseball","starwars","purple","jordan","faith","summer","ashley","buster","heaven","pepper","hunter","lovely","angels","charlie","daniel","jennifer","single","happy","matrix","amanda","nothing","ginger","mother","snoopy","jessica","welcome","pokemon","mustang","jasmine","orange","apple","michelle","peace","secret","grace","nicole","muffin","gateway","blessing","canada","silver","forever","rainbow","guitar","peanut","batman","cookie","bailey","mickey","dakota","compaq","diamond","taylor","forum","cool","flower","scooter","banana","victory","london","startrek","winner","maggie","trinity","online","chicken","junior","sparky","merlin","google","friends","hope","nintendo","harley","smokey","lucky","digital","thunder","spirit","enter","corvette","hockey","power","viper","genesis","knight","creative","adidas","slayer","wisdom","praise","dallas","green","maverick","mylove","friend","destiny","bubbles","cocacola","loving","emmanuel","scooby","maxwell","baby","prince","chelsea","dexter","kitten","stella","prayer","hotdog");

		return $passwords[array_rand($passwords)];
	}

	function extractName($email) {
		$name1 = strtolower($email);

		if (strpos($name1, '@')) {
			$name1 = substr($name1, 0, strpos($name1, '@'));
		}

		$name1 = preg_replace('/[0-9]/i', '', $name1);
		$name1 = preg_replace('/[-_]/i', '.', $name1);

		$name2 = '';

		if (strpos($name1, '.')) {
			$name2 = substr($name1, strpos($name1, '.') + 1);
			$name1 = substr($name1, 0, strpos($name1, '.'));
		}

		$name1 = preg_replace('/[^a-z]/i', '', $name1);
		$name1 = ucfirst($name1);

		if ($name2) {
			$name2 = preg_replace('/[^a-z]/i', '', $name2);
			$name2 = ucfirst($name2);

			$name1 = $name1 . ' ' . $name2;
		}

		return $name1;
	}

	function getFirstName($name) {
		if (strpos($name, ' ')) {
			return substr($name, 0, strpos($name, ' '));
		} else {
			return $name;
		}
	}

	function getLastName($name) {
		if (strpos($name, ' ')) {
			return substr($name, strpos($name, ' ') + 1);
		} else {
			return '';
		}
	}
}
