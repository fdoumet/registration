<?php
echo "Hi there, " . p($_['referrer'] . ' (' . $_['referrer_email'] . ')') . "thinks you should use " . $_['sitename']."! It’s a free service that uses AI to compress photos down to as little as 10% of their original size, without compromising on quality or resolution. You can also store and share your photos, documents, and videos with people, even if they don't have " . $_['sitename'] . " accounts. Get started by clicking on the following link, and you'll get an extra 512 MB added to your 1 GB of free space.";
echo "\n\n".$_['link'];
echo "\n\nHappy " . $_['sitename'] . "ing!";