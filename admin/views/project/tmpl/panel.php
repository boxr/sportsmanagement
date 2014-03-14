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

defined('_JEXEC') or die('Restricted access');
$templatesToLoad = array('footer');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);

// Get a refrence of the page instance in joomla
$document = JFactory::getDocument();
$stylelink = '<link rel="stylesheet" href="'.JURI::root().'administrator/components/com_sportsmanagement/assets/css/jlextusericons.css'.'" type="text/css" />' ."\n";
$document->addCustomTag($stylelink);$path='/administrator/components/com_sportsmanagement/assets/icons/';
$user = JFactory::getUser();
JToolBarHelper::title(JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_CONTROL_PANEL_TITLE'),'projects');

?>
			<div id="element-box">
				<div class="m">
					<div class="adminform">
						<legend><?php echo JText::sprintf('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_CONTROL_PANEL_LEGEND','<i>'.$this->project->name.'</i>'); ?></legend>
						<div class="cpanel">
							<?php
	 						$link=JRoute::_('index.php?option=com_sportsmanagement&task=project.edit&id='.$this->project->id);
							$text=JText::_('COM_SPORTSMANAGEMENT_P_PANEL_PSETTINGS');
							$imageFile='projekte.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>									
							<?php
	 						$link=JRoute::_('index.php?option=com_sportsmanagement&view=templates&pid='.$this->project->id);
							$text=JText::_('COM_SPORTSMANAGEMENT_P_PANEL_FES');
							$imageFile='templates.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
							if ((isset($this->project->project_type)) &&
								 (($this->project->project_type == 'PROJECT_DIVISIONS') ||
								   ($this->project->project_type == 'DIVISIONS_LEAGUE')))
							{
								$link=JRoute::_('index.php?option=com_sportsmanagement&view=divisions&pid='.$this->project->id);
								$text=JText::plural('COM_SPORTSMANAGEMENT_P_PANEL_DIVISIONS', $this->count_projectdivisions);
								$imageFile='divisionen.png';
								$linkParams="<span>$text</span>&nbsp;";
								$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
								?>
								<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
								<?php
							}
							if ((isset($this->project->project_type)) &&
								(($this->project->project_type == 'TOURNAMENT_MODE') ||
								($this->project->project_type == 'DIVISIONS_LEAGUE')))
							{
								$link=JRoute::_('index.php?option=com_sportsmanagement&view=treetos&pid='.$this->project->id);
								$text=JText::_('COM_SPORTSMANAGEMENT_P_PANEL_TREE');
								$imageFile='turnierbaum.png';
								$linkParams="<span>$text</span>&nbsp;";
								$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
								?>
								<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
							}
                            
                            if ( $this->project->project_art_id != 3 )
                            {
							$link=JRoute::_('index.php?option=com_sportsmanagement&view=projectpositions&pid='.$this->project->id);
							$text=JText::plural('COM_SPORTSMANAGEMENT_P_PANEL_POSITIONS', $this->count_projectpositions);
							$imageFile='positionen.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
                            }
							$link=JRoute::_('index.php?option=com_sportsmanagement&view=projectreferees&persontype=3&pid='.$this->project->id);
							$text=JText::plural('COM_SPORTSMANAGEMENT_P_PANEL_REFEREES', $this->count_projectreferees);
							$imageFile='projektschiedsrichter.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
	 						$link=JRoute::_('index.php?option=com_sportsmanagement&view=projectteams&pid='.$this->project->id);
							$text=JText::plural('COM_SPORTSMANAGEMENT_P_PANEL_TEAMS', $this->count_projectteams);
							$imageFile='mannschaften.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
	 						$link=JRoute::_('index.php?option=com_sportsmanagement&view=rounds&pid='.$this->project->id);
							$text=JText::plural('COM_SPORTSMANAGEMENT_P_PANEL_MATCHDAYS', $this->count_matchdays);
							$imageFile='spieltage.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
							<?php
	 						$link=JRoute::_('index.php?option=com_sportsmanagement&view=jlxmlexports&pid='.$this->project->id);
							$text=JText::_('COM_SPORTSMANAGEMENT_P_PANEL_XML_EXPORT');
							$imageFile='xmlexport.png';
							$linkParams="<span>$text</span>&nbsp;";
							$image=JHtml::_('image.administrator',$imageFile,$path,NULL,NULL,$text).$linkParams;
							?>
							<div class="icon-wrapper"><div class="icon"><?php echo JHtml::link($link,$image); ?></div></div>
						</div>
					</div>
				</div>
			</div>
			<div id="element-box">
				<div class="m">
					<div class="adminform">
						<div class="cpanel"><?php echo JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_CONTROL_PANEL_HINT'); ?></div>
					</div>
				</div>
			</div>
			<!-- bottom close main table opened in default_admin -->
		</td>
	</tr>
</table>
<?PHP
echo "<div>";
echo $this->loadTemplate('footer');
echo "</div>";
?>   
