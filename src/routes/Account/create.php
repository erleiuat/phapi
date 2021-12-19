<?php

🌟('CLS🦄/Account/Account');
🌟('CLS🦄/Account/Verification');

// Read and validate input
$🙂 = new Account(🔎::username('username', 🚀, true));
$🙂->mail = 🔎::mail('mail', 🚀, true);
$🙂🔑 = 🔎::password('password', 🚀, true);
if (!🔎::passed()) 💥('ACC001', 🔎::getIssues());

// Check for existing username
if ($🙂->read()) 💥('ACC002');

// Generate accountID & encrypt password
$🙂->generateID()->setPassword($🙂🔑);

// Create verification & generate code
$🙂📍 = new Verification($🙂);
$code = $🙂📍->getMailCode();

// TODO: Send code to mail
😼📝(['verification' => $code]);

// Create account
$🙂->create();
$🙂📍->create();

😺✅('Account created');
