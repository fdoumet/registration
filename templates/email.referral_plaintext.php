<?php
echo "Hi there, " . p($_['referrer'] . ' (' . $_['referrer_email'] . ')') . "thinks you should use " . $_['sitename']."! It's a free and easy way to access and share your docs, photos, and videos with colleagues and friends, even if they don't have " . $_['sitename'] . " accounts. Get started by clicking on the following link, and you'll get an extra 512 MB added to your 1 GB of free space.";
echo "\n\n".$_['link'];
echo "\n\nHappy " . $_['sitename'] . "ing!";