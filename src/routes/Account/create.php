<?php

π('CLSπ¦/Account/Account');
π('CLSπ¦/Account/Verification');

// Read and validate input
$π = new Account(π::username('username', π, true));
$π->mail = π::mail('mail', π, true);
$ππ = π::password('password', π, true);
if (!π::passed()) π₯('ACC001', π::getIssues());

// Check for existing username
if ($π->read()) π₯('ACC002');

// Generate accountID & encrypt password
$π->generateID()->setPassword($ππ);

// Create verification & generate code
$ππ = new Verification($π);
$code = $ππ->getMailCode();

// TODO: Send code to mail
πΌπ(['verification' => $code]);

// Create account
$π->create();
$ππ->create();

πΊβ('Account created');
