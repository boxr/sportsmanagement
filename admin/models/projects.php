<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
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
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/ 

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');


/**
 * sportsmanagementModelProjects
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModelProjects extends JModelList
{
	var $_identifier = "projects";
	
    /**
     * sportsmanagementModelProjects::__construct()
     * 
     * @param mixed $config
     * @return void
     */
    public function __construct($config = array())
        {   
                $config['filter_fields'] = array(
                        'p.name',
                        'l.name',
                        'l.country',
                        's.name',
                        'st.name',
                        'p.project_type',
                        'p.published',
                        'p.id',
                        'p.ordering',
                        'p.picture',
                        'ag.name',
                        'p.agegroup_id',
                        'ag.name'
                        );
                parent::__construct($config);
                $getDBConnection = sportsmanagementHelper::getDBConnection();
                parent::setDbo($getDBConnection);
        }
        
    /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        // Initialise variables.
		$app = JFactory::getApplication('administrator');
        
        $app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' context -> '.$this->context.''),'');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);
        
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.league', 'filter_league', '');
		$this->setState('filter.league', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.sports_type', 'filter_sports_type', '');
		$this->setState('filter.sports_type', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.season', 'filter_season', '');
		$this->setState('filter.season', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.search_nation', 'filter_search_nation', '');
		$this->setState('filter.search_nation', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.search_association', 'filter_search_association', '');
		$this->setState('filter.search_association', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.project_type', 'filter_project_type', '');
		$this->setState('filter.project_type', $temp_user_request);
        
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.userfields', 'filter_userfields', '');
		$this->setState('filter.userfields', $temp_user_request);
        
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.search_agegroup', 'filter_search_agegroup', '');
		$this->setState('filter.search_agegroup', $temp_user_request);
$temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.unique_id', 'filter_unique_id', '');
$this->setState('filter.unique_id', $temp_user_request);
        
        $value = JRequest::getUInt('limitstart', 0);
		$this->setState('list.start', $value);

//		$image_folder = $this->getUserStateFromRequest($this->context.'.filter.image_folder', 'filter_image_folder', '');
//		$this->setState('filter.image_folder', $image_folder);
        
        //$app->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.' image_folder<br><pre>'.print_r($image_folder,true).'</pre>'),'');


//		// Load the parameters.
//		$params = JComponentHelper::getParams('com_sportsmanagement');
//		$this->setState('params', $params);

		// List state information.
		parent::populateState('p.name', 'asc');
	}
    
	/**
	 * sportsmanagementModelProjects::getListQuery()
	 * 
	 * @return
	 */
	protected function getListQuery()
	{
		$app = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        
        //$search	= $this->getState('filter.search');
        //$search_league = $this->getState('filter.league');
        //$search_sports_type	= $this->getState('filter.sports_type');
        //$search_season = $this->getState('filter.season');
        //$filter_state = $this->getState('filter.state');
        //$search_nation = $this->getState('filter.search_nation');
        //$search_project_type = $this->getState('filter.project_type');
        //$search_userfields = $this->getState('filter.userfields');
        
        // Create a new query object.
        $db = sportsmanagementHelper::getDBConnection();
		$query = $db->getQuery(true);
        $subQuery = $db->getQuery(true);
        $subQuery2 = $db->getQuery(true);
        
//        $subQuery->select('count(pt.id)');
//        $subQuery->from('#__sportsmanagement_project_team AS pt');
//        $subQuery->where('pt.project_id = p.id');

switch ( $this->getState('filter.unique_id') )
        {
        case 0:
        $subQuery->select('count(pt.id)');
        $subQuery->from('#__sportsmanagement_project_team AS pt');
        $subQuery->where('pt.project_id = p.id');
        break;
        case 1:
        $subQuery->select('count(pt.id)');
        $subQuery->from('#__sportsmanagement_project_team AS pt');
        $subQuery->join('INNER','#__sportsmanagement_season_team_id as st ON st.id = pt.team_id');
        $subQuery->join('INNER','#__sportsmanagement_team as t ON t.id = st.team_id');
        $subQuery->join('INNER','#__sportsmanagement_club as c ON c.id = t.club_id');
        $subQuery->where('pt.project_id = p.id');
        $subQuery->where('( c.unique_id IS NULL OR c.unique_id LIKE '.$db->Quote(''.'').' )');
        break;
        case 2:
        $subQuery->select('count(pt.id)');
        $subQuery->from('#__sportsmanagement_project_team AS pt');
        $subQuery->join('INNER','#__sportsmanagement_season_team_id as st ON st.id = pt.team_id');
        $subQuery->join('INNER','#__sportsmanagement_team as t ON t.id = st.team_id');
        $subQuery->join('INNER','#__sportsmanagement_club as c ON c.id = t.club_id');
        $subQuery->where('pt.project_id = p.id');
        $subQuery->where('( c.unique_id NOT LIKE '.$db->Quote(''.'').' )');
        break;
        }		
		
        $subQuery2->select('ef.name');
        $subQuery2->from('#__sportsmanagement_user_extra_fields_values as ev ');
        $subQuery2->join('INNER','#__sportsmanagement_user_extra_fields as ef ON ef.id = ev.field_id');
        $subQuery2->where('ev.jl_id = p.id');
        $subQuery2->where('ef.template_backend LIKE '.$db->Quote(''.'project'.''));
        $subQuery2->where('ev.fieldvalue != '.$db->Quote(''.''));
        

        $query->select('p.id,p.ordering,p.published,p.project_type,p.name,p.alias,p.checked_out,p.checked_out_time,p.sports_type_id,p.current_round,p.picture,p.agegroup_id ');
        $query->select('p.league_id');
        $query->select('p.modified,p.modified_by');
        $query->select('u1.username');
        
        $query->select('st.name AS sportstype');
        $query->select('s.name AS season');
        $query->select('l.name AS league,l.country');
        $query->select('u.name AS editor');
        $query->select('ag.name AS agegroup');
        $query->select('(' . $subQuery . ') AS proteams');
        
    $query->from('#__sportsmanagement_project AS p');
    $query->join('LEFT', '#__sportsmanagement_season AS s ON s.id = p.season_id');
    $query->join('LEFT', '#__sportsmanagement_league AS l ON l.id = p.league_id');
    $query->join('LEFT', '#__sportsmanagement_sports_type AS st ON st.id = p.sports_type_id');
    $query->join('LEFT', '#__sportsmanagement_agegroup AS ag ON ag.id = p.agegroup_id');
    $query->join('LEFT', '#__users AS u ON u.id = p.checked_out');
    $query->join('LEFT', '#__users AS u1 ON u1.id = p.modified_by');
  
        if ($this->getState('filter.userfields'))
		{
			$query->select('ev.fieldvalue as user_fieldvalue,ev.id as user_field_id');  
		$query->join('INNER','#__sportsmanagement_user_extra_fields_values as ev ON ev.jl_id = p.id');  
		$query->join('INNER','#__sportsmanagement_user_extra_fields as ef ON ef.id = ev.field_id');  
        $query->where('ef.id = ' . $this->getState('filter.userfields') );
        }

        if ($this->getState('filter.search'))
		{
        $query->where('LOWER(p.name) LIKE ' . $db->Quote( '%' . $this->getState('filter.search') . '%' ));
        }
        
        if ($this->getState('filter.league'))
		{
        $query->where('p.league_id = ' . $this->getState('filter.league'));
        }
        
        if ($this->getState('filter.sports_type'))
		{
        $query->where('p.sports_type_id = ' . $this->getState('filter.sports_type') );
        }
        
        if ($this->getState('filter.season'))
		{
        $query->where('p.season_id = ' . $this->getState('filter.season'));
        }
        
        if (is_numeric($this->getState('filter.state')) )
		{
		$query->where('p.published = '.$this->getState('filter.state'));	
		}
        
        if ($this->getState('filter.search_agegroup'))
		{
        $query->where('p.agegroup_id = ' . $this->getState('filter.search_agegroup'));
        }
        
        if ($this->getState('filter.search_nation'))
		{
        $query->where('l.country LIKE ' . $db->Quote( '' . $this->getState('filter.search_nation') . '' ));
        }
        
        if ($this->getState('filter.search_association'))
		{
        $query->where("l.associations = ".$this->getState('filter.search_association') );
        }
        
        if ($this->getState('filter.project_type'))
		{
        $query->where('p.project_type LIKE ' . $db->Quote( '' . $this->getState('filter.project_type') . '' ));
        }
     
     $query->order($db->escape($this->getState('list.ordering', 'p.name')).' '.
                $db->escape($this->getState('list.direction', 'ASC')));

//$app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'Notice');
                
        if ( COM_SPORTSMANAGEMENT_SHOW_QUERY_DEBUG_INFO )
        {
        $app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'Notice');
        }
                
		return $query;
        
	}
	
	
}
?>
