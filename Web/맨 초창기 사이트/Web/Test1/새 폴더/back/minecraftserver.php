<?php

    /**
     * Minecraft Server Status Query
     * @author Julian Spravil <julian.spr@t-online.de> https://github.com/FunnyItsElmo
     * @license Free to use but dont remove the author, license and copyright
     * @copyright © 2013 Julian Spravil
     */
    class MinecraftServerStatus {

        public function getStatus($host = '127.0.0.1', $port = 25565) {
			
            if (substr_count($host , '.') != 4) $host = gethostbyname($host);

            $serverdata = array();
            $serverdata['hostname'] = $host;
            $serverdata['version'] = false;
            $serverdata['protocol'] = false;
            $serverdata['players'] = false;
            $serverdata['maxplayers'] = false;
            $serverdata['motd'] = false;
            $serverdata['motd_raw'] = false;
            $serverdata['favicon'] = false;
            $serverdata['ping'] = false;

            $socket = $this->connect($host, $port);	
			
            if(!$socket) {
                return false;
            }
			
            $start = microtime(true);
			
            socket_send($socket, "\xFE\x01", 2, 0);
			
            $length = socket_recv($socket, $data, 512, 0);

            $ping = round((microtime(true)-$start)*1000);//calculate the high five duration
                
            if($length < 4 || $data[0] != "\xFF") {
                return false;
            }

            $motd = "";
            $motdraw = "";
			
            if (substr((String)$data, 3, 5) == "\x00\xa7\x00\x31\x00"){
                $result = explode("\0", mb_convert_encoding(substr((String)$data, 15), 'UTF-8', 'UCS-2'));
				if (empty($result[0])) {
					$serverdata['version'] = $result[1];
                    $motd = $result[2];
				} else {
					$serverdata['version'] = $result[0];
                    $motd = $result[1];
				}
                $motdraw = $motd;
            } else {
                $result = explode('§', mb_convert_encoding(substr((String)$data, 3), 'UTF-8', 'UCS-2'));
                foreach ($result as $key => $string) {
                    if($key != sizeof($result)-1 && $key != sizeof($result)-2 && $key != 0) {
                        $motd .= '§'.$string;
                    }
                }
                $motdraw = $motd;
				$serverdata['version'] = $result[2];
            }
			
            $motd = preg_replace("/(§.)/", "", $motd);
            $motd = preg_replace("/[^[:alnum:][:punct:] ]/", "", $motd); //Remove all special characters from a string	
			
            $serverdata['players'] = $result[sizeof($result)-2];
            $serverdata['maxplayers'] = $result[sizeof($result)-1];
            $serverdata['motd'] = $motd;
            $serverdata['motd_raw'] = $motdraw;
            $serverdata['ping'] = $ping;
			
            $this->disconnect($socket);
            return $serverdata;

        }

		private function connect($host, $port) {
            try {
				$result=@dns_get_record('_minecraft._tcp.'.$host,DNS_SRV);
				if ($result) {
					$host=$result[0]['target'];
					$port=$result[0]['port'];
				}
			} catch (Exception $e) {}
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>10, "usec"=>0));
            if (!socket_connect($socket, $host, $port)) {
                $this->disconnect($socket);
                return false;
            }
            return $socket;
        }

        private function disconnect($socket) {
            if($socket != null) {
                socket_close($socket);
            }
        }

        private function read_packet_length($socket) {
            $a = 0;
            $b = 0;
            while(true) {
                $c = socket_read($socket, 1);
                if(!$c) {
                    return 0;
                }
                $c = Ord($c);
                $a |= ($c & 0x7F) << $b++ * 7;
                if( $b > 5 ) {
                    return false;
                }
                if(($c & 0x80) != 128) {
                    break;
                }
            }
            return $a;
        }
    }