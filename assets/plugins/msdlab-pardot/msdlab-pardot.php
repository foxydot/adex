<?php
/*
Plugin Name: MSDLab Pardot Integration
Plugin URI:
Description: Simple hard-coded integration of Pardot scripts for AdEx Intl.
Author: Catherine Sandrick
Version: 0.1
Author URI: http://MadScienceDept.com
*/

/*  Copyright 2017

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('MSDLab_Pardot')){
    class MSDLab_Pardot{
        //Properties

        //Methods
        function __construct()
        {
            add_action('wp_footer', array(&$this,'add_pardot_footer_scripts'));
        }

        function add_pardot_footer_scripts(){
            //print the script
            $ret = '<script name="pardot" type="text/javascript">
var piAId = \'319401\';
var piCId = null;
switch(window.location.hash){
    case \'#environments\':
        piCId = \'4577\';
        break;
    case \'#exhibits\':
        piCId = \'4579\';
        break;
    case \'#events\':
        piCId = \'4581\';
        break;
    case \'#fulfillment\':
        piCId = \'4583\';
        break;
}
console.log(\'hash: \' + window.location.hash);
console.log(\'piCId: \' + piCId);

(function() {
	function async_load(){
		var s = document.createElement(\'script\'); s.type = \'text/javascript\';
		s.src = (\'https:\' == document.location.protocol ? \'https://pi\' : \'http://cdn\') + \'.pardot.com/pd.js\';
		var c = document.getElementsByTagName(\'script\')[0]; c.parentNode.insertBefore(s, c);
	}
	if(window.attachEvent) { window.attachEvent(\'onload\', async_load); }
	else { window.addEventListener(\'load\', async_load, false); }
})();
</script>';
            print $ret;
        }
    }//close class

    //instantiate
    global $msdlab_pardot;
    $msdlab_pardot = new MSDLab_Pardot();
}//close if