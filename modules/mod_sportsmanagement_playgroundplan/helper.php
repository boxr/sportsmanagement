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

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
 * modSportsmanagementPlaygroundplanHelper
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class modSportsmanagementPlaygroundplanHelper
{

	/**
	 * Method to get the list
	 *
	 * @access public
	 * @return array
	 */
	public static function getData(&$params)
	{
	   $app = JFactory::getApplication();
		$usedp = $params->get('projects','0');
		$usedpid = $params->get('playground', '0');
		$projectstring = (is_array($usedp)) ? implode(",", $usedp) : $usedp;
		$playgroundstring = (is_array($usedpid)) ? implode(",", $usedpid) : $usedpid;

		$numberofmatches = $params->get('maxmatches','5');

		$db  = sportsmanagementHelper::getDBConnection(); 
        $query = $db->getQuery(true);

		$result = array();
		
        $query->select('m.match_date, DATE_FORMAT(m.time_present, "%H:%i") time_present');	
        $query->select('p.name AS project_name, p.id AS project_id, st1.team_id as team1, st2.team_id as team2, lg.name AS league_name');
        $query->select('plcd.id AS club_playground_id');
        $query->select('plcd.name AS club_playground_name');
        $query->select('pltd.id AS team_playground_id');
        $query->select('pltd.name AS team_playground_name');
        $query->select('pl.id AS playground_id');
        
        $query->select('pl.picture AS playground_picture');
        $query->select('plcd.picture AS playground_club_picture');
        $query->select('pltd.picture AS playground_team_picture');
        
        $query->select('pl.name AS playground_name');
        $query->select('t1.name AS team1_name');
        $query->select('t2.name AS team2_name');
        
        $query->select('CONCAT_WS( \':\', p.id, p.alias ) AS project_slug');
        $query->select('CONCAT_WS( \':\', pl.id, pl.alias ) AS playground_slug');
        $query->select('CONCAT_WS( \':\', plcd.id, plcd.alias ) AS playground_club_slug');
        $query->select('CONCAT_WS( \':\', pltd.id, pltd.alias ) AS playground_team_slug');
            
        $query->from('#__sportsmanagement_match AS m ');
        $query->join('INNER',' #__sportsmanagement_project_team as tj1 ON tj1.id = m.projectteam1_id  ');
        $query->join('INNER',' #__sportsmanagement_project_team as tj2 ON tj2.id = m.projectteam2_id  ');
        
        $query->join('INNER',' #__sportsmanagement_project AS p ON p.id = tj1.project_id  ');
        
        $query->join('INNER',' #__sportsmanagement_season_team_id as st1 ON st1.id = tj1.team_id ');
        $query->join('INNER',' #__sportsmanagement_season_team_id as st2 ON st2.id = tj2.team_id ');
        
        $query->join('INNER',' #__sportsmanagement_team as t1 ON t1.id = st1.team_id ');
        $query->join('INNER',' #__sportsmanagement_team as t2 ON t2.id = st2.team_id ');
        $query->join('INNER',' #__sportsmanagement_club c ON c.id = t1.club_id');
        $query->join('INNER',' #__sportsmanagement_league as lg ON lg.id = p.league_id');
        
        $query->join('LEFT',' #__sportsmanagement_playground AS plcd ON c.standard_playground = plcd.id');
        $query->join('LEFT',' #__sportsmanagement_playground AS pltd ON tj1.standard_playground = pltd.id ');
        $query->join('LEFT',' #__sportsmanagement_playground AS pl ON m.playground_id = pl.id');
        
        if ( $playgroundstring )
        {
		$query->where('( m.playground_id IN ('.$playgroundstring.') 
        OR (tj1.standard_playground IN ('. $playgroundstring .') AND m.playground_id IS NULL)
                          OR (c.standard_playground IN ('. $playgroundstring .') AND (m.playground_id IS NULL AND tj1.standard_playground IS NULL )))
        ');
        }
        $query->where('m.match_date > NOW()');
        $query->where('m.published = 1');
        $query->where('p.published = 1');
        
        if ( $projectstring != 0 )
		{
            $query->where('p.id IN ('.$projectstring.')');
		}
        
        $query->order('m.match_date ASC');
        //$query->setLimit($numberofmatches);

			
		$db->setQuery($query,0,$numberofmatches);
        
        //$app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'');
        
        //echo ' <br><pre>'.print_r($query->dump(),true).'</pre>';
        
		$info = $db->loadObjectList();
        $db->disconnect(); // See: http://api.joomla.org/cms-3/classes/JDatabaseDriver.html#method_disconnect
        if ( !$info )
        {
            //$app->enqueueMessage(JText::_(__FILE__.' '.__LINE__.' <br><pre>'.print_r($db->getErrorMsg(),true).'</pre>'),'Error');
        }

		return $info;
	}

	/**
	 * modSportsmanagementPlaygroundplanHelper::getTeams()
	 * 
	 * @param mixed $team1_id
	 * @param mixed $teamformat
	 * @return
	 */
	public static function getTeams( $team1_id, $teamformat)
	{
	   $app = JFactory::getApplication();
	   $db  = sportsmanagementHelper::getDBConnection(); 
       $query = $db->getQuery(true);
       
       $query->select($teamformat);
       $query->from('#__sportsmanagement_team AS t ');
       $query->where('t.id ='.(int)$team1_id);

		
		$db->setQuery( $query );
        
        //$app->enqueueMessage(JText::_(__FILE__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'');
        
		$team_name = $db->loadResult();
        $db->disconnect(); // See: http://api.joomla.org/cms-3/classes/JDatabaseDriver.html#method_disconnect

		return $team_name;
	}

	/**
	 * modSportsmanagementPlaygroundplanHelper::getTeamLogo()
	 * 
	 * @param mixed $team_id
	 * @return
	 */
	public static function getTeamLogo($team_id,$logo = 'logo_big')
	{
	   $app = JFactory::getApplication();
	   $db  = sportsmanagementHelper::getDBConnection(); 
       $query = $db->getQuery(true);
       
       $query->select('c.'.$logo);
       $query->from('#__sportsmanagement_team AS t ');
       $query->join('LEFT',' #__sportsmanagement_club as c ON c.id = t.club_id ');
       $query->where('t.id ='.$team_id);
       
	
		$db->setQuery( $query );
        
        //$app->enqueueMessage(JText::_(__FILE__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'');
        
		$club_logo = $db->loadResult();

		if ($club_logo == '') 
        {
            switch ($logo)
            {
                case 'logo_small':
                $club_logo = sportsmanagementHelper::getDefaultPlaceholder('clublogosmall');
                break;
                case 'logo_middle':
                $club_logo = sportsmanagementHelper::getDefaultPlaceholder('clublogomiddle');
                break;
                case 'logo_big':
                $club_logo = sportsmanagementHelper::getDefaultPlaceholder('clublogobig');
                break;
                
            }

		}
        $db->disconnect(); // See: http://api.joomla.org/cms-3/classes/JDatabaseDriver.html#method_disconnect
		return $club_logo;
	}
}