<?php 
$nonce=random_int(10000000000000,100000000000000000);
header("Set-Cookie: Secure; HttpOnly");
header("Content-Security-Policy:default-src 'self'; img-src 'self'; font-src https://fonts.googleapis.com https://use.fontawesome.com https://fonts.gstatic.com;  frame-ancestors 'none'; style-src 'self' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://stackpath.bootstrapcdn.com https://use.fontawesome.com; object-src 'none'; script-src 'strict-dynamic' 'nonce-".$nonce."'; base-uri 'none'; form-action 'self'; ");
header("X-Frame-Options: DENY");
header("Strict-Transport-Security: max-age=31536000");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Cache-Control: max-age=31536000");
