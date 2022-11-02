<?php
$getOutlineText = function($isDesktopDocs, $openProjectLink, $gifLink)
{
    $navSide = $isDesktopDocs ? "left" : "right" ;
    echo "
<p>The <span class='section-name'>Outline</span> section in the Explorer panel is an easy way to navigate your files. The section shows the name of classes, members, and functions defined throughout the file. Click one of the names to jump your cursor to the respective definition in the file. To view the <span class='section-name'>Outline</span>, <a href='{$openProjectLink}'>open a project</a> and then, in the {$navSide} navigation menu, click the <img class='inline-icon' src='https://cdn.quantconnect.com/i/tu/explorer-icon.png'> <span class='icon-name'>Explorer</span> icon.</p>

<img class='docs-image' src='{$gifLink}'>
    ";
}
?>
