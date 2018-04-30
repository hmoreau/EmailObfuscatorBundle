<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hmo\Bundle\EmailObfuscatorBundle\Twig;

use Twig\Extension\AbstractExtension;

/**
 * Extension for content form generation.
 */
class EmailObfuscatorTwigExtension extends AbstractExtension
{
    

    /**
     * Returns an array of possible function in this extension.
     *
     * @return array
     */
    public function getFunctions()
    {
    	return [
            new \Twig_SimpleFunction('hmo_emailobfuscator', [$this, 'emailObfuscator']),
        ];
    }

    /**
     * Returns FormView by given params.
     *
     * @param string $email
     *
     * @return string
     */
    public function emailObfuscator($email)
    {
    	try{
	    	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';

			  $key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
			
			  for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
			
			  $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
			  $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
			  $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
			  $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
			  $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
			  return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
    	}
    	catch(\Exception $e)
    	{
    		return "<pre>".$e->getMessage()."\r\n".$e->getFile()."\r\n".$e->getLine()."\r\n".$e->getCode()."</pre>";
    	}
    }
}
