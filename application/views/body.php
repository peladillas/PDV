<?php
$title = $this->uri->segment(1).' - '.$this->uri->segment(2);
$html = startContent($title);
$html .= $output;
$html .= endContent();

echo $html;
?>