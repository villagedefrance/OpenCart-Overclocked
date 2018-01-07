<?php
class ModelCheckoutCheckoutTools extends Model {

	public function getJoinName($data) {
		if ($data['firstname'] && $data['lastname']) {
			return $data['firstname'] . ' ' . $data['lastname'];
		} elseif ($data['firstname'] && !$data['lastname']) {
			return $data['firstname'];
		} else {
			return;
		}
	}

	public function generatePassword() {
		$passwords = array(
			"qwerty", "azerty", "test", "love", "hello", "monkey", "dragon", "express", "shadow",
			"sunshine", "master", "computer", "princess", "tiger", "football", "angel", "whatever",
			"freedom", "soccer", "superman", "michael", "cheese", "internet", "blessed", "baseball",
			"starwars", "purple", "jordan", "faith", "summer", "ashley", "buster", "heaven", "pepper",
			"hunter", "lovely", "angels", "charlie", "daniel", "jennifer", "single", "happy", "matrix",
			"amanda", "nothing", "ginger", "mothership", "snoopy", "jessica", "welcome", "pokemon",
			"mustang", "jasmine", "orange", "apple", "michelle", "peace", "secret", "grace", "nicole",
			"muffin", "gateway", "blessing", "canada", "silver", "forever", "rainbow", "guitar", "peanut",
			"batman", "cookie", "bailey", "mickey", "dakota", "compaq", "diamond", "taylor", "forum",
			"icecool", "flower", "scooter", "banana", "victory", "london", "startrek", "winner", "maggie",
			"trinity", "online", "chicken", "junior", "sparky", "merlin", "google", "friends", "hope",
			"nintendo", "harley", "smokey", "lucky", "digital", "thunder", "spirit", "enter", "corvette",
			"hockey", "power", "viper", "genesis", "knight", "creative", "adidas", "slayer", "wisdom",
			"praise", "dallas", "green", "maverick", "mylove", "friend", "destiny", "bubbles", "cocacola",
			"loving", "scooby", "maxwell", "baby", "prince", "chelsea", "dexter", "kitten", "stella",
			"prayer", "hotdog", "zappa", "macadam", "ginseng", "orinoco", "chocolat", "mint"
		);

		return $passwords[array_rand($passwords)];
	}
}
