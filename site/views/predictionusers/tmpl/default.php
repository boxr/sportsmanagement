<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

if ( COM_SPORTSMANAGEMENT_SHOW_DEBUG_INFO )
{
echo 'this->predictionMember<br /><pre>~' . print_r($this->predictionMember,true) . '~</pre><br />';
}

//$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'predictionheading' . DS . 'tmpl' );
//$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'backbutton' . DS . 'tmpl' );
//$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'footer' . DS . 'tmpl' );

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('globalviews','predictionheading');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);

?>
<!-- <div class='row'> -->
<?php
	echo $this->loadTemplate('predictionheading');
	if ($this->predictionMember->pmID > 0)
	{
		echo $this->loadTemplate('sectionheader');
		if (($this->predictionMember->show_profile) || ($this->allowedAdmin) || ($this->predictionMember->user_id==$this->actJoomlaUser->id))
		{
			echo $this->loadTemplate('info');
			
			if ($this->config['show_flash_statistic_points']){
				echo $this->loadTemplate('pointsflashchart');
			}
			if ($this->config['show_flash_statistic_ranks']){
				echo $this->loadTemplate('rankflashchart');	
			}
		}
		else
		{
			echo JText::_('COM_SPORTSMANAGEMENT_PRED_USERS_MEMBER_NO_PROFILE_SHOW');
		}
	}
	else
	{
		?><h3><?php echo JText::_('COM_SPORTSMANAGEMENT_PRED_USERS_SELECT_EXISTING_MEMBER'); ?></h3><?php
	}
	echo '<div>';
		//backbutton
		echo $this->loadTemplate('backbutton');
		// footer
		echo $this->loadTemplate('footer');
	echo '</div>';
?>
<!-- </div> -->