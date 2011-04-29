<?php 
class VimeoHelper extends AppHelper 
{ 
    /** 
     * Creates Vimeo Embed Code from a given Vimeo Video. 
     * 
     *    @param String $vimeo_id URL or ID of Video on Vimeo.com 
     *    @param Array $usr_options VimeoHelper Options Array (see below) 
     *    @return String HTML output. 
    */ 
    function getEmbedCode($vimeo_id, $usr_options = array()) 
    { 
        // Default options. 
        $options = array 
        ( 
            'width' => 400, 
            'height' => 225, 
            'show_title' => 1, 
            'show_byline' => 1, 
            'show_portrait' => 0, 
            'color' => '00adef', 
        ); 
        $options = array_merge($options, $usr_options); 
         
        // Extract Vimeo.id from URL. 
        if (substr($vimeo_id, 0, 21) == 'http://www.vimeo.com/') { 
            $vimeo_id = substr($vimeo_id, 21); 
        } 
         
        $output = array(); 
        $output[] = sprintf('<object width="%s" height="%s">', $options['width'], $options['height']); 
        $output[] = ' <param name="allowfullscreen" value="true" />'; 
        $output[] =    ' <param name="allowscriptaccess" value="always" />'; 
        $output[] =    sprintf(' <param name="movie" value="http://www.vimeo.com/moogaloop.swf?clip_id=%s&server=www.vimeo.com&show_title=%s&show_byline=%s&show_portrait=%s&color=%s&fullscreen=1" />', $vimeo_id, $options['show_title'], $options['show_byline'], $options['show_portrait'], $options['color']);
        $output[] = sprintf(' <embed src="http://www.vimeo.com/moogaloop.swf?clip_id=%s&server=www.vimeo.com&show_title=%s&show_byline=%s&show_portrait=%s&color=%s&fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="%s" height="%s"></embed>', $vimeo_id, $options['show_title'], $options['show_byline'], $options['show_portrait'], $options['color'], $options['width'], $options['height']);
        $output[] = '</object>'; 
         
        return $this->output(implode($output, "\n")); 
    } 
} 
?> 