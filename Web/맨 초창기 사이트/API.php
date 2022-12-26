<?php
	function getJSON($file) {
		return json_decode(file_get_contents($file));
	}
	function replaceColor($text) {
		$text = str_replace("\n", "<br>", str_replace("§l", "", str_replace("§m", "", str_replace("§n", "", str_replace("§o", "", str_replace("§f", "§0", str_replace("§r", "§7", $text)))))));
		$array = explode("§", "§7".$text);
		$list = "";
		for ($i = 0; $i < count($array); $i++) {
			$color = substr($array[$i], 0, 1);
			if (!isset($color)) continue;
			else if (strlen($color) < 1) continue;
			else {
				$color_code = "";
				switch ($color) {
					case "a": $color_code = "01DF3A"; break;
					case "b": $color_code = "01DFD7"; break;
					case "c": $color_code = "FF5555"; break;
					case "d": $color_code = "FF55FF"; break;
					case "e": $color_code = "FBD500"; break;
					case "f": $color_code = "FFFFFF"; break;
					case "0": $color_code = "000000"; break;
					case "1": $color_code = "0000AA"; break;
					case "2": $color_code = "00AA00"; break;
					case "3": $color_code = "00AAAA"; break;
					case "4": $color_code = "AA0000"; break;
					case "5": $color_code = "AA00AA"; break;
					case "6": $color_code = "FFAA00"; break;
					case "7": $color_code = "AAAAAA"; break;
					case "8": $color_code = "555555"; break;
					case "9": $color_code = "5555FF"; break;
				}
				if ($color_code != "") $list = $list."<font color=\"".$color_code."\">".substr($array[$i], 1)."</font>";
				else $list = $list."§".$array[$i];
			}
		}
		return $list;
	}
?>