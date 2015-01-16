<?php
	class Hash
	{
		public static function getHash($algoritmo,$data,$key)
		{
			$hash = hash_init($algoritmo, HASH_HMAC, $key); // codifica una cotraseña de forma un poco mas segura
			hash_update($hash, $data);

			return hash_final($hash);
		}
	}